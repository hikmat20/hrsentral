<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('wa_normalize_number')) {
    function wa_normalize_number($raw)
    {
        $raw = preg_replace('/[^0-9+]/', '', (string)$raw);
        $raw = ltrim($raw, '+');

        if (substr($raw, 0, 1) === '0') {
            return '62' . substr($raw, 1);
        }
        if (substr($raw, 0, 2) === '62') {
            return $raw;
        }
        return $raw; // fallback
    }
}

if (! function_exists('wa_send')) {
    function wa_send($number, $message)
    {
        if (empty($number) || empty($message)) {
            log_message('error', 'WA send: empty param');
            return false;
        }

        $CI = &get_instance();
        $waCfg = $CI->config->item('whacenter');
        $device_id = isset($waCfg['device_id']) ? $waCfg['device_id'] : '';
        $endpoint  = isset($waCfg['endpoint'])  ? $waCfg['endpoint']  : 'https://app.whacenter.com/api/send';
        $timeout   = isset($waCfg['timeout'])   ? (int)$waCfg['timeout'] : 10;

        $data = array(
            'device_id' => $device_id,
            'number'    => $number,
            'message'   => $message
        );

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        // ======== DEBUG SSL (lokal sering gagal di sini) ========
        // Sementara untuk test lokal, matikan verifikasi SSL.
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // ========================================================

        $result = curl_exec($ch);
        $errNo  = curl_errno($ch);
        $err    = curl_error($ch);
        $http   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        log_message('info', 'WA DEBUG http=' . $http . ' errno=' . $errNo . ' error=' . $err . ' resp=' . $result);

        if (!empty($err) || $errNo !== 0) {
            return false;
        }
        return $result;
    }
}


if (! function_exists('wa_notify_leaves')) {
    function wa_notify_leaves($leave_id)
    {
        $CI = &get_instance();

        $leave = $CI->db->select('la.*')
            ->from('leave_applications la')
            ->where('la.id', $leave_id)
            ->get()->row_array();

        if (empty($leave)) {
            log_message('error', 'WA notify: Pengajuan cuti tidak ditemukan: ' . $leave_id);
            return;
        }

        if (empty($leave['dept_head_phone'])) {
            $deptHead = $CI->db->select('dh.employee_id, e.name as dept_head_name, e.phone as dept_head_phone')
                ->from('divisions_head dh')
                ->join('employees e', 'e.id = dh.employee_id', 'left')
                ->where('dh.id', $leave['approval_by'])
                ->limit(1)
                ->get()->row_array();

            if (!empty($deptHead)) {
                $leave['dept_head_name']  = $deptHead['dept_head_name'];
                $leave['dept_head_phone'] = $deptHead['dept_head_phone'];
            }
        }

        if (empty($leave['dept_head_phone'])) {
            log_message('error', 'WA notify: Tidak ada nomor Department Head untuk pengajuan cuti: ' . $leave_id);
            return;
        }

        $wa_number      = wa_normalize_number($leave['dept_head_phone']);
        $tglPengajuan   = !empty($leave['created_at']) ? date('d/m/Y H:i', strtotime($leave['created_at'])) : date('d/m/Y H:i');
        $tglMulai       = !empty($leave['from_date']) ? date('d/m/Y', strtotime($leave['from_date'])) : '-';
        $tglSelesai     = !empty($leave['until_date']) ? date('d/m/Y', strtotime($leave['until_date']))   : '-';
        $durasi         = !empty($leave['total_days']) ? $leave['total_days'] . ' hari' : '-';

        $pesan  = "Yth. Bpk/Ibu " . $leave['dept_head_name'] . "\n\n";
        $pesan .= "Pengajuan cuti menunggu persetujuan Anda:\n";
        $pesan .= "• ID Pengajuan   : *" . $leave['id'] . "*\n";
        $pesan .= "• Karyawan       : *" . $leave['name'] . "* (" . $leave['employee_id'] . ")\n";
        $pesan .= "• Tgl Pengajuan  : " . $tglPengajuan . "\n";
        $pesan .= "• Periode        : " . $tglMulai . " s.d. " . $tglSelesai . " (" . $durasi . ")\n";

        // penetuan jenis cuti
        if (!empty($leave['flag_leave_type']) && $leave['flag_leave_type'] == 'CT') {
            $alasan         = !empty($leave['descriptions']) ? $leave['descriptions'] : '-';
            if (! empty($leave['special_leave_category'])) {
                $lv = $CI->db->select('name')
                    ->from('at_leaves')
                    ->where('id', $leave['special_leave_category'])
                    ->limit(1)
                    ->get()->row_array();
                if (! empty($lv['name'])) {
                    $jenis = 'Cuti Khusus - ' . $lv['name'];
                } else {
                    $jenis = 'Cuti Khusus';
                }
            } else if (! empty($leave['sick_leave']) && (float)$leave['sick_leave'] > 0) {
                $jenis = 'Cuti Sakit';
            } else if (! empty($leave['notpay_leave']) && (float)$leave['notpay_leave'] > 0) {
                $jenis = 'Cuti Tidak Dibayar';
                if (! empty($leave['notpay_leave_desc'])) {
                    $jenis .= ' - ' . $leave['notpay_leave_desc'];
                }
            } else {
                $jenis = '-';
            }

            $pesan .= "• Jenis     : " . $jenis . "\n";
            $pesan .= "• Alasan         : " . $alasan . "\n\n";
            $pesan .= "Mohon dapat ditindaklanjuti. Detail pengajuan dapat dilihat di link berikut : " . base_url('leavesapps/view/' . $leave['id']) . "\nTerima kasih atas perhatiannya.\n\n*HRIS*";
        } else if (!empty($leave['flag_leave_type']) && $leave['flag_leave_type'] == 'CP') {
            $jenis = "Cuti Pengganti";
            $alasan = !empty($leave['reason']) ? $leave['reason'] : '-';
            $request = !empty($leave['request_by']) ? $leave['request_by'] : '-';
            $request_reason = !empty($leave['request_by']) ? $leave['request_by'] : '-';

            $pesan .= "• Jenis     : " . $jenis . "\n";
            $pesan .= "• Alasan         : " . $alasan . "\n";
            $pesan .= "• Permintaan     : " . $request . "\n";
            $pesan .= "• Keterangan     : " . $request_reason . "\n\n";
            $pesan .= "Mohon dapat ditindaklanjuti. Detail pengajuan dapat dilihat di link berikut : " . base_url('pengganti/view/' . $leave['id']) . "\nTerima kasih atas perhatiannya.\n\n*HRIS*";
        }

        wa_send($wa_number, $pesan);
    }
}

if (! function_exists('wa_notify_overtime')) {
    function wa_notify_overtime($overtime_id)
    {
        $CI = &get_instance();

        $overtime = $CI->db->select('o.*, d.name as divisi')
            ->from('overtime o')
            ->join('divisions d', 'o.division_id = d.id', 'left')
            ->where('o.id', $overtime_id)
            ->get()->row_array();

        if (empty($overtime)) {
            log_message('error', 'WA notify: Pengajuan lembur tidak ditemukan : ' . $overtime_id);
            return;
        }

        if (empty($overtime['dept_head_phone'])) {
            $deptHead = $CI->db->select('dh.employee_id, e.name as dept_head_name, e.phone as dept_head_phone')
                ->from('divisions_head dh')
                ->join('employees e', 'e.id = dh.employee_id', 'left')
                ->where('dh.id', $overtime['approval_by'])
                ->limit(1)
                ->get()->row_array();

            if (!empty($deptHead)) {
                $overtime['dept_head_name']  = $deptHead['dept_head_name'];
                $overtime['dept_head_phone'] = $deptHead['dept_head_phone'];
            }
        }

        if (empty($overtime['dept_head_phone'])) {
            log_message('error', 'WA notify: Tidak ada nomor Department Head untuk pengajuan lembur: ' . $overtime_id);
            return;
        }

        $wa_number      = wa_normalize_number($overtime['dept_head_phone']);
        $tglPengajuan   = !empty($overtime['created_at']) ? date('d/m/Y', strtotime($overtime['created_at'])) : date('d/m/Y');
        $dari           = !empty($overtime['start_time']) ? date('H:i', strtotime($overtime['start_time'])) : '-';
        $sampai         = !empty($overtime['end_time']) ? date('H:i', strtotime($overtime['end_time'])) : '-';
        $durasi         = !empty($overtime['total_time']) ? $overtime['total_time'] . ' jam' : '-';
        $alasan         = !empty($overtime['reason'])     ? $overtime['reason'] : '-';

        $pesan  = "Yth. Bpk/Ibu " . $overtime['dept_head_name'] . "\n\n";
        $pesan .= "Pengajuan lembur karyawan menunggu persetujuan Anda:\n";
        $pesan .= "• ID Pengajuan   : *" . $overtime['id'] . "*\n";
        $pesan .= "• Karyawan       : *" . $overtime['name'] . "* (" . $overtime['employee_id'] . ")\n";
        $pesan .= "• Divisi         : *" . $overtime['divisi'] . "*\n";
        $pesan .= "• Tgl Pengajuan  : " . $tglPengajuan . "\n";
        $pesan .= "• Waktu          : " . $dari . " s.d. " . $sampai . "\n";
        $pesan .= "• Durasi         : " . $durasi . "\n";
        $pesan .= "• Alasan         : " . $alasan . "\n\n";
        $pesan .= "Mohon dapat ditindaklanjuti. Detail pengajuan dapat dilihat di link berikut : \n" . base_url('lembur/view/' . $overtime['id']) . "\nTerima kasih atas perhatiannya.\n\n*HRIS*";

        wa_send($wa_number, $pesan);
    }
}

if (! function_exists('wa_notify_wfh')) {
    function wa_notify_wfh($wfh_id)
    {
        $CI = &get_instance();

        $wfh = $CI->db->select('w.*, d.name as divisi')
            ->from('work_from_home w')
            ->join('divisions d', 'w.division_id = d.id', 'left')
            ->where('w.id', $wfh_id)
            ->get()->row_array();

        if (empty($wfh)) {
            log_message('error', 'WA notify: Pengajuan WFH tidak ditemukan : ' . $wfh_id);
            return;
        }

        if (empty($wfh['dept_head_phone'])) {
            $deptHead = $CI->db->select('dh.employee_id, e.name as dept_head_name, e.phone as dept_head_phone')
                ->from('divisions_head dh')
                ->join('employees e', 'e.id = dh.employee_id', 'left')
                ->where('dh.id', $wfh['approval_by'])
                ->limit(1)
                ->get()->row_array();

            if (!empty($deptHead)) {
                $wfh['dept_head_name']  = $deptHead['dept_head_name'];
                $wfh['dept_head_phone'] = $deptHead['dept_head_phone'];
            }
        }

        if (empty($wfh['dept_head_phone'])) {
            log_message('error', 'WA notify: Tidak ada nomor Department Head untuk pengajuan lembur: ' . $wfh_id);
            return;
        }

        $wa_number      = wa_normalize_number($wfh['dept_head_phone']);
        $tglPengajuan   = !empty($wfh['created_at']) ? date('d/m/Y', strtotime($wfh['created_at'])) : date('d/m/Y');
        $tglMulai       = !empty($wfh['from_date']) ? date('d/m/Y', strtotime($wfh['from_date'])) : '-';
        $tglSelesai     = !empty($wfh['until_date'])   ? date('d/m/Y', strtotime($wfh['until_date']))   : '-';
        $durasi         = !empty($wfh['total_days']) ? $wfh['total_days'] . ' hari' : '-';
        $alasan         = !empty($wfh['reason'])     ? $wfh['reason'] : '-';

        $pesan  = "Yth. Bpk/Ibu " . $wfh['dept_head_name'] . "\n\n";
        $pesan .= "Pengajuan WFH karyawan menunggu persetujuan Anda:\n";
        $pesan .= "• ID Pengajuan   : *" . $wfh['id'] . "*\n";
        $pesan .= "• Karyawan       : *" . $wfh['name'] . "* (" . $wfh['employee_id'] . ")\n";
        $pesan .= "• Divisi         : *" . $wfh['divisi'] . "*\n";
        $pesan .= "• Tgl Pengajuan  : " . $tglPengajuan . "\n";
        $pesan .= "• Periode        : " . $tglMulai . " s.d. " . $tglSelesai . " (" . $durasi . ")\n";
        $pesan .= "• Alasan         : " . $alasan . "\n\n";
        $pesan .= "Mohon dapat ditindaklanjuti. Detail pengajuan dapat dilihat di link berikut : \n" . base_url('wfh/view/' . $wfh['id']) . "\nTerima kasih atas perhatiannya.\n\n*HRIS*";

        wa_send($wa_number, $pesan);
    }
}
