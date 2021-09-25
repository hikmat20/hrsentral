<?php
$this->load->view('include/side_menu'); 
?>    
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?=$title;?></h3>
		
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		
			
	
	    <table id="index" class="table table-bordered table-striped">
			<thead>
				<tr class='bg-blue'>
                    <th class="text-center">No</th>				
					<th class="text-center">Name</th>
					<th class="text-center">Basic Salary</th>
					<th class="text-center">Tunjangan Harian</th>
					<th class="text-center">Tunjangan Bulanan</th>
					<th class="text-center">Tunjangan BPJS</th>
					<th class="text-center">Potongan BPJS</th>
					<th class="text-center">Potongan Lain-lain</th>
					<th class="text-center">Total</th>
					<th class="text-center">Option</th>						
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
							echo"<td align='right'>".number_format($tr->tj_bpjs,0, ',', '.')."</td>";
							echo"<td align='right'>".number_format($tr->pot_bpjs,0, ',', '.')."</td>";
							echo"<td align='right'>".number_format($tr->pot_lain,0, ',', '.')."</td>";
							echo"<td align='center'>".number_format($tr->total,0, ',', '.')."</td>";
							echo"<td align='center'>"; 
								echo"<button type='button' class='btn btn-primary add' id='add' data-karyawan='$tr->id_trsalary'>
										<i class='fa fa-plus'></i></button>";					
							    if($akses_menu['update']=='1'){
									echo"<button type='button' class='btn btn-success view' id='view' data-id='$tr->employee_id'>
										<i class='fa fa-eye'></i></button>";
								}									
								
								
							echo"</td>";
							echo"</tr>";
							
						    }
								 }
		 
		 ?>
			  
			 </tbody>
			 <tfoot>
			    <tr class='bg-blue'>
                    <th class="text-center">No</th>				
					<th class="text-center">Name</th>
					<th class="text-center">Basic Salary</th>
					<th class="text-center">Tunjangan Harian</th>
					<th class="text-center">Tunjangan Bulanan</th>
					<th class="text-center">Tunjangan BPJS</th>
					<th class="text-center">Potongan BPJS</th>
					<th class="text-center">Potongan Lain-lain</th>
					<th class="text-center">Total</th>
					<th class="text-center">Option</th>						
				</tr>
			</tfoot>
		</table>
	</div>
	<!-- /.box-body -->
 </div>
  <!-- /.box -->
  
  <div class="modal modal-default fade dialog-popup" id="dialog-popup" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-file"></span>&nbsp;VIEW SLIP</h4>
      </div>
      <div class="modal-body" id="ModalView">
		...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger"  id="close" data-dismiss="modal">
        <span class="glyphicon glyphicon-remove"></span>  Close</button>
        </div>
    </div>
  </div>
</div>

<?php $this->load->view('include/footer'); ?>
<script>
	$(document).ready(function(){
		$('#btn-add').click(function(){
			loading_spinner();
		});		
	});
	function deleteData(id){
		swal({
			  title: "Are you sure?",
			  text: "You will not be able to process again this data!",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Yes, Process it!",
			  cancelButtonText: "No, cancel process!",
			  closeOnConfirm: true,
			  closeOnCancel: false
			},
			function(isConfirm) {
			  if (isConfirm) {
					loading_spinner();
					window.location.href = base_url +'index.php/'+ active_controller+'/delete/'+id;
					
			  } else {
				swal("Cancelled", "Data can be process again :)", "error");
				return false;
			  }
		});
       
	} 
	
	
	$(".view").click(function(){
		
	   
		
		 var	id		= $(this).data('id');
         // var	tr		= $("#no_tr").val();
         // var	kelas	= $("#kd_kelas").val();
         // var	jaminan	= $("#kd_jaminan").val();		 
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b> Billing Pasien</b>");
		$.ajax({
			type:'POST',
			url:base_url+'salarycount/slip/',
			data	: "id="+id,
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
				//DataDetail();
			}
		})
		
		
		//$('.select2').select2();
		
	});
	
	$(".add").click(function(){
		
	   
		
		 var	id		= $(this).data('karyawan');
         // var	tr		= $("#no_tr").val();
         // var	kelas	= $("#kd_kelas").val();
         // var	jaminan	= $("#kd_jaminan").val();		 
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b></b>");
		$.ajax({
			type:'POST',
			url:base_url+'salarycount/addpotongan/',
			data	: "id="+id,
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
				//DataDetail();
			}
		})
		
		
		//$('.select2').select2();
		
	});
	
	$('#dialog-popup').on('hidden.bs.modal', function () {
	  document.location.reload();
	})
	
	
</script>
