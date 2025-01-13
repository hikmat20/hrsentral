<style type="text/css">
thead input {
	width: 100%;
}
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>


<form id="data_billing">

<?php
if($row !=0){
	
	foreach($row as $dt){
	$karyawan = $dt->employee_id;	
	}
	
    $dat = $this->db->query("SELECT a.* FROM employees a  
			  WHERE a.id ='$karyawan'")->result();
			  
	foreach($dat as $nm){
	$nmkaryawan = $nm->name;	
	}
	
}

?>
		
<div class="box-body">
		<table class="table">
			<tr>				
				<th>Nama : <?= $nmkaryawan ?></th>
				<th></th>
				<th></th>
				<th></th>				
			</tr>
		</table>
</div>
			
<div class="box-body">
		<table class="table">
			<tr>
				
				<th>Potongan Category</th>
				<th>Potongan Name</th>
				<th>Total Potongan</th>
				<th></th>
				
				
			</tr>
			<tr valign="top"  class='baris_1'>
			    <td>
				
						<?php
							$data_category[0]	= 'Select An Option';
                            $data_category[1]	= 'Harian';				
                            $data_category[2]	= 'Bulanan';											
							echo form_dropdown('potongan',$data_category, 0, array('id'=>'potongan','class'=>'form-control input-sm', 'onchange'=>'get_potongan()'));											
						?>	
                         
                        <?php
							echo form_input(array('type'=>'hidden','id'=>'employee_id','name'=>'employee_id','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Total','value'=>$dt->employee_id));
							
							
							echo form_input(array('type'=>'hidden','id'=>'id','name'=>'id','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Total','value'=>$id));							
						?>
				</td>							 
						
				</td>
				<td>
				 <div id="select_kategori">
						<select class="form-control" name="id_potongan" id="id_potongan">
						<option value="">Select An Option</option>								
						</select> 
                 </div>						
				<td>
					<?php
							echo form_input(array('id'=>'jumlah','name'=>'jumlah','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Total'));											
						?>
				</td>	
               
				<th>
					<button type="submit" class="btn btn-success btn-sm" name="save" id="save"><i class="fa fa-save"></i>&nbsp;Simpan</button>
				</th>
				</tr>
				</table>
			</div>
</form>

	<div class="box box-primary" id="data_detail"></div>
			
<script type="text/javascript">
$(document).ready(function(){
	
DataDetail2;

})
   
$(document).on('submit', '#data_billing', function(e){
	
		e.preventDefault()
		var data = $('#data_billing').serialize();
		
		// alert(data);
// exit();
		swal({
		  title: "Anda Yakin?",
		  text: "Data akan di simpan.",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-info",
		  confirmButtonText: "Ya, Simpan!",
		  cancelButtonText: "Batal",
		  closeOnConfirm: false
		},
		function(){
		  $.ajax({
			  type:'POST',
			  url:base_url+'salarycount/savePotongan',
			  dataType : "json",
			  data:data,
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data berhasil disimpan.",
						  type : "success"
						},
						function (){
							 //window.location.href=siteurl+'pendaftaran/TrPendaftaranRj/'+noreg;
							 DataDetail2();
						})
				  } else {
					swal({
					  title : "Error",
					  text  : "Data error. Gagal insert data",
					  type  : "error"
					})
					
				  }
			  },
			  error : function(){
				swal({
					  title : "Error",
					  text  : "Data error. Gagal request Ajax",
					  type  : "error"
					})
			  }
		  })
		});
		
		
	
		
	})
	
	
	
	function DataDetail2(){
		
		var	cari		= $("#employee_id").val();		
		 
		$.ajax({
			type	: "POST",
			url		:base_url+"salarycount/load_potongan",
			data	: "cari="+cari,
			success	: function(data){
				$("#data_detail").html(data);
				$("#loading").fadeOut(100);	
		   		$("#data_detail").fadeIn(500);				
			}
		});
	}
	
	function deleteRow(ID) {
	var	noreg		= $("#noreg").val();		
	var id	= ID;
	swal({
		  title: "Anda Yakin?",
		  text: "Data akan di hapus.",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-info",
		  confirmButtonText: "Ya, Hapus!",
		  cancelButtonText: "Batal",
		  closeOnConfirm: false
		},
	function(){
		  $.ajax({
			  type:'POST',
			  url:siteurl+'pendaftaran/hapusDetail',
			  dataType : "json",
			  data	: "id="+id,
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data berhasil dihapus.",
						  type : "success"
						},
						function (){
							 // window.location.href=siteurl+'pendaftaran/TrPendaftaranRj/'+noreg;
							 DataDetail2();
						})
				  } else {
					swal({
					  title : "Error",
					  text  : "Data error. Gagal Hapus data",
					  type  : "error"
					})
					
				  }
			  },
			  error : function(){
				swal({
					  title : "Error",
					  text  : "Data error. Gagal request Ajax",
					  type  : "error"
					})
			  }
		  })
		});
}

     function get_potongan(){
		
		var kategori=$('#potongan').val();
       
		$.ajax({
            type:'POST',
            url:base_url + active_controller +'/get_potongan',
            data:{'kategori':kategori},
            success:function(html){
               $("#select_kategori").html(html);
             
            }
        });
	}
	
</script>