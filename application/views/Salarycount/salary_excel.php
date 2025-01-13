<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Data Karyawan</title>

</head>
<body>
<?php
header("Content-Type: application/force-download");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 2010 05:00:00 GMT"); 
header("Content-Disposition: attachment; filename=Laporan_Penggajian.xls");
?>
<table id="grid-data" class="table table-bordered table-striped">
	  
			<thead>
				<tr class='bg-blue'>
                    <th class="text-center">No</th>				
					<th class="text-center">Name</th>
					<th class="text-center">Basic Salary</th>
					<th class="text-center">Tunjangan Harian</th>
					<th class="text-center">Tunjangan Bulanan</th>
					<th class="text-center">Potongan Absensi</th>
					<th class="text-center">Potongan Pinjaman</th>
					<th class="text-center">Potongan PPH</th>
					<th class="text-center">Total</th>
										
				</tr>
			</thead>
			<tbody>
			
		 <?php
		 
		 $bulan = date('M');
			   $tahun = date('Y');
		 
							 $tr_salary = $this->db->query("SELECT a.*,a.id as id_trsalary, b.* FROM tr_salary a  
							 INNER JOIN employees b on b.id=a.employee_id WHERE a.periode_gaji='$bulan' AND tahun='$tahun'")->result();
						
								
							
								 
							if($tr_salary){
									 $nomor=0;
									
							foreach($tr_salary as $tr){ 
							$nomor++;
		 
		                    echo"<tr>";							
						    echo"<td align='left'>".$nomor."</td>";
							echo"<td align='left'>".$tr->name."</td>";
							echo"<td align='right'>".number_format($tr->pokok,0, ',', '.')."</td>";
							echo"<td align='right'>".number_format($tr->tj_harian,0, ',', '.')."</td>";
							echo"<td align='right'>".number_format($tr->tj_bulanan,0, ',', '.')."</td>";
							echo"<td align='right'>".number_format($tr->pot_absensi,0, ',', '.')."</td>";
							echo"<td align='right'>".number_format($tr->pot_pinjaman,0, ',', '.')."</td>";
							echo"<td align='right'>".number_format($tr->pot_pph,0, ',', '.')."</td>";
							echo"<td align='right'>".number_format($tr->total,0, ',', '.')."</td>";
							echo"</tr>";
							
						    }
								 }
		 
		 ?>
			  
			 </tbody>
		</table>
		
</body>
</html>