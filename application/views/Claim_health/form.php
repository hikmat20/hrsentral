<?php
$this->load->view('include/side_menu');
?>

<div class="box box-solid rounded-1 box-shadow">
    <div class="box-header">
        <h2 class="box-title font-nunito" style="padding: 10px;"><?= $title; ?></h2>
    </div>
    <div class="box-body">
        <form class="form-horizontal" id="form-data" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?=(isset($record->id)?$record->id:'')?>">
			<input type="hidden" id="dokumen_claim_old" name="dokumen_claim_old" value="<?=(isset($record->dokumen_claim)?$record->dokumen_claim:'')?>">
			<input type="hidden" name="insurance" value="<?=(isset($record->insurance)?$record->insurance:'')?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No Claim</label>
                        <div class="col-sm-9">
							<input type="text" name="no_claim" class="form-control" id="no_claim" readonly value="<?=(isset($record->no_claim)?$record->no_claim:'')?>" placeholder="Auto">
                        </div>
                    </div>
				</div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tgl. Claim<span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="date" name="tgl_claim" class="form-control" id="tgl_claim" required="required" value="<?=(isset($record->tgl_claim)?$record->tgl_claim:date("Y-m-d"))?>">
                            </div>
                        </div>
                    </div>
				</div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Tertanggung<span class="text-red">*</span></label>
                        <div class="col-sm-12 col-md-9" style="margin-bottom: 8px;">
                            <select name="tertanggung" id="tertanggung" required class="form-control" required="required">
                                <option value=""></option>
                                <?php $dt_lc=(isset($record->tertanggung)?$record->tertanggung:''); 
								$family[]=(object) array('id'=>$this->session->userdata['Employee']['id'],'name'=>$this->session->userdata['Employee']['name']);
								foreach ($family as $lc) : ?>
                                    <option value="<?= $lc->id; ?>"<?= ($dt_lc==$lc->id?' selected':'');?>><?= $lc->name; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
				</div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tgl. Perawatan<span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="date" name="date_treat" class="form-control" id="date_treat" required="required" value="<?=(isset($record->date_treat)?$record->date_treat:date("Y-m-d"))?>">
                            </div>
                        </div>
                    </div>
				</div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jenis Claim<span class="text-red">*</span></label>
                        <div class="col-sm-12 col-md-9" style="margin-bottom: 8px;">
                            <select name="jenis_claim" id="jenis_claim" required class="form-control" required="required">
                                <option value=""></option>
                                <?php 
								$dt_jc=(isset($record->jenis_claim)?$record->jenis_claim:'');
								foreach ($jc as $lc) : ?>
                                    <option value="<?= $lc->info;?>"<?= ($dt_jc==$lc->info?' selected':'');?>><?= $lc->info; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
				</div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Provider</label>
                        <div class="col-sm-9">
							<input type="text" name="provider" class="form-control" id="provider" value="<?=(isset($record->provider)?$record->provider:"")?>">
                        </div>
                    </div>
				</div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Biaya Claim<span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon">Rp.</div>
                                <input type="text" name="biaya_claim" class="form-control divide" id="biaya_claim" required="required" value="<?=(isset($record->biaya_claim)?$record->biaya_claim:0)?>">
                            </div>
                        </div>
                    </div>
				</div>
				<div class="col-md-6">
                    <div class="form-group">
						<label class="col-sm-3 control-label">Dokumen Claim<span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <input type="file" name="dokumen_claim" id="dokumen_claim"><br />
							<?=(isset($record->dokumen_claim)?'<a href="'.base_url('assets/documents/').$record->dokumen_claim.'" class="btn btn-default btn-xs" download target="_blank"><i class="fa fa-download"></i> Download</a>':"")?>
                        </div>
                    </div>
					
				</div>
            </div>
            <hr>
        </form>
    </div>

    <div class="box-footer rounded-1">
        <div class="row">
            <div class="col-md-6 text-center">
                <button type="button" class="btn btn-primary" id="save"><i class="fa fa-save"></i> Save</button>
                <a href="<?=base_url('claim_health')?>" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
            </div>
            <div class="col-md-6">
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('include/footer'); ?>
<script src="<?=base_url()?>assets/js/number-divider.min.js"></script>
<script>
	$('.divide').divide();
	<?php if($action=='view') {
		echo '$("#form-data :input").prop("disabled", true);$("#save").addClass("hidden");';
	} ?>
    $(document).ready(function() {
        $('.btn-spinner').click(function() {
            $('#spinner').modal('show');
        });

    });

    $(document).on('click', '#save', function() {
		save_application()
    })

    function save_application() {
        let formdata = new FormData($('#form-data')[0]);
        $.ajax({
            url: '<?= base_url('claim_health/save'); ?>',
            data: formdata,
            type: 'POST',
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(result, response) {
                if (result.status == 1) {
                    swal({
                        title: 'Succes',
                        text: result.msg,
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function() {
                        window.open('<?= base_url('claim_health/'); ?>', '_self');
                    }, 1500)
                } else if (result.status == 0) {
                    swal({
                        title: 'Kesalahan Upload',
                        text: result.msg,
                        type: 'warning',
                    });
                }
                console.log(result + ", " + response);
            },
            error: function(result) {
                swal({
                    title: 'Error!!',
                    text: 'Internal Error',
                    type: 'error'
                })
            }
        })
    }
</script>