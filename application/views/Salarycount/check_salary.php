<?php
$this->load->view('include/side_menu'); 
?>    
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?=$title;?></h3>
		<div class="box-tool pull-right">
		<?php
		if($akses_menu['download']=='1'){
		?>
		  <a href="<?php echo site_url('salarycount/excel') ?>" class="btn btn-sm btn-success" id='btn-excel'>
			<i class="fa fa-download">&nbsp Download Excel</i>
		  </a>
		  <?php
			}
		  ?>
		</div>
		<div class="box-tool pull-right">
		
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		
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
							echo"<td align='center'><input type='text' class='form-control input-sm absensi uang' id='pot_absensi$nomor' data-absensi='$tr->id_trsalary' data-nomor='$nomor' value=".number_format($tr->pot_absensi,0, ',', '.')."></input></td>";
							echo"<td align='center'><input type='text' class='form-control input-sm pinjaman uang' id='pot_pinjaman$nomor' data-pinjaman='$tr->id_trsalary' data-nomor1='$nomor' value=".number_format($tr->pot_pinjaman,0, ',', '.')."></input></td>";
							echo"<td align='center'><input type='text' class='form-control input-sm pph uang' id='pot_pph$nomor' data-pph='$tr->id_trsalary' data-nomor2='$nomor' value=".number_format($tr->pot_pph,0, ',', '.')."></input></td>";
							echo"<td align='center'>".number_format($tr->total,0, ',', '.')."</td>";
							echo"<td align='center'>"; 
													
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
					<th class="text-center">Potongan Absensi</th>
					<th class="text-center">Potongan Pinjaman</th>
					<th class="text-center">Potongan PPH</th>
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
		
		
		 $('#grid-data').DataTable({
          
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
	
	$(document).on('keyup', '.absensi', function(e){
		
		
		 var	id		= $(this).data('absensi');
		 var	nomor		= $(this).data('nomor');
         var	harga	= $("#pot_absensi"+nomor).val();
		 var	hargarp	= formatRupiah(harga)
		 
		 
		 
		 $("#pot_absensi"+nomor).val(hargarp);
		 
		
		
	})
	
	$(document).on('keyup', '.pinjaman', function(e){
		
		
		 var	id		= $(this).data('pinjaman');
		 var	nomor		= $(this).data('nomor1');
         var	harga	= $("#pot_pinjaman"+nomor).val();
		 var	hargarp	= formatRupiah(harga)
		 
		 
		 
		 $("#pot_pinjaman"+nomor).val(hargarp);
		 
		
		
	})
	
	$(document).on('keyup', '.pph', function(e){
		
		
		 var	id		= $(this).data('pph');
		 var	nomor		= $(this).data('nomor2');
         var	harga	= $("#pot_pph"+nomor).val();
		 var	hargarp	= formatRupiah(harga)
		 
		 
		 
		 $("#pot_pph"+nomor).val(hargarp);
		 
		
		
	})
	
	
	
	$(document).on('blur', '.absensi', function(e){
		
		
		 var	id		= $(this).data('absensi');
		 var	nomor		= $(this).data('nomor');
         var	harga	= $("#pot_absensi"+nomor).val();
		 
		 
		 
		$.ajax({
			type:'POST',
			url:base_url+'salarycount/update_absensi/',
			data	: "id="+id+"&harga="+harga,
			success:function(data){
				 //document.location.reload();
				 window.location.href=base_url+'salarycount/search2';
			}
		})
		
	})
	
	$(document).on('blur', '.pinjaman', function(e){
		
		 var	id		= $(this).data('pinjaman');
		 var	nomor		= $(this).data('nomor1');
         var	harga	= $("#pot_pinjaman"+nomor).val();
		 
		$.ajax({
			type:'POST',
			url:base_url+'salarycount/update_pinjaman/',
			data	: "id="+id+"&harga="+harga,
			success:function(data){
				window.location.href=base_url+'salarycount/search2';
			}
		})
		
	})
	
	$(document).on('blur', '.pph', function(e){
		
		 var	id		= $(this).data('pph');
		 var	nomor		= $(this).data('nomor2');
         var	harga	= $("#pot_pph"+nomor).val();
		 
		$.ajax({
			type:'POST',
			url:base_url+'salarycount/update_pph/',
			data	: "id="+id+"&harga="+harga,
			success:function(data){
				window.location.href=base_url+'salarycount/search2';
			}
		})
		
	})
	
	
	/* Fungsi formatRupiah */
function formatRupiah(angka, prefix){
	var number_string = angka.replace(/[^,\d]/g, '').toString(),
	split   		= number_string.split(','),
	sisa     		= split[0].length % 3,
	rupiah     		= split[0].substr(0, sisa),
	ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
	// tambahkan titik jika yang di input sudah menjadi angka ribuan
	if(ribuan){
		separator = sisa ? '.' : '';
		rupiah += separator + ribuan.join('.');
	}
 
	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
}
	
	
</script>
