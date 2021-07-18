<?php
$this->load->view('include/side_menu'); 
?>    
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?=$title;?></h3>
		<div class="box-tool pull-right">
		<?php
			if($akses_menu['create']=='1'){
		?>
		  
		  <?php
			}
		  ?>
		</div>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr class='bg-blue'>
					<th class="text-center">Option</th>
					<!--<th class="text-center">Foto</th> -->
					<th class="text-center">Id</th>
					<th class="text-center">NIK</th>
					<th class="text-center">Name</th>
					<th class="text-center">Hometown</th>
					<th class="text-center">Birthday</th>
					<th class="text-center">Gender</th>
					<th class="text-center">Religion</th>
					<th class="text-center">Nationality</th>
					<th class="text-center">Stay Address</th>
					<th class="text-center">Id Card Address</th>
					<th class="text-center">Marital Status</th>
					<th class="text-center">Company</th>
					<th class="text-center">Division</th>
					<th class="text-center">Departement</th>
					<th class="text-center">Title</th>
					<th class="text-center">First Contract</th>
					<th class="text-center">First Contract Start Date</th>
					<th class="text-center">First Contract Latest Date</th>
					<th class="text-center">Second Contract</th>
					<th class="text-center">Second Contract Start Date</th>
					<th class="text-center">Second Contract Latest Date</th>
					<th class="text-center">Third Contract</th>
					<th class="text-center">Third Contract Start Date</th>
					<th class="text-center">Third Contract Latest Date</th>
					<th class="text-center">Permanent </th>
					<th class="text-center">Permanent Start Date</th>
					<th class="text-center">Work Start</th>
					<th class="text-center">Length of Working</th>
					<th class="text-center">Employee Status</th>
					<th class="text-center">Contract Latest Date </th>
					<th class="text-center">Contract Remaining </th>
					<th class="text-center">Status Aktif</th>
					<th class="text-center">Modified By</th>
					<th class="text-center">Modified Date</th>
					
				</tr>
			</thead>
			<tbody>
			  <?php 
			  if($row){
					$int	=0;
					foreach($row as $datas){
						$int++;
						
						$th='Th';
						$bl='Bln';
						
					
						
						$awal  = date_create($datas->hiredate);
						$akhir = date_create(); // waktu sekarang
						$diff  = date_diff( $awal, $akhir );
						
						$startdate=$datas->hiredate;
						
						if ($startdate=='0000-00-00'){
							
						$tahun = '0';
						$bulan = '0';
						$hari  = '0';
						
						}else{
							
						$tahun = $diff->y;
						$bulan = $diff->m;
						$hari  = $diff->d;
						};
						
						 $agama = $datas->relid;
						 $jk    = $datas->genderid;
						 
						 $permanent    		= $datas->permanent_id;
						 $firstcontract   	= $datas->firstcontract_id;
						 $secondcontract	= $datas->secondcontract_id;
						 $thirdcontract		= $datas->thirdcontract_id;
						 
						 
						if($permanent ==='CTR004'){
						
						$akhirkontrak  	= date_create($datas->thirdcontractlatest_date);
						$sekarang 		= date_create(); // waktu sekarang
						$sisakontrak	= date_diff( $sekarang, $akhirkontrak );
						$sisakontrakbln	= '0';
						$sisakontrakth	= '0';
						
						$status='Tetap';
						$tglkontrak='0000-00-00';
						}
						elseif($thirdcontract==='CTR003')
						{
						
						$akhirkontrak  	= date_create($datas->thirdcontractlatest_date);
						$sekarang 		= date_create(); // waktu sekarang
						$sisakontrak	= date_diff( $sekarang, $akhirkontrak );
						$sisakontrakbln	= $sisakontrak->m;
						$sisakontrakth	= $sisakontrak->y;	
						$status='Kontrak Ketiga';
						$tglkontrak= $datas->thirdcontractlatest_date;
						}
						elseif($secondcontract==='CTR002')
						{
							
						$akhirkontrak  	= date_create($datas->secondcontractlatest_date);
						$sekarang 		= date_create(); // waktu sekarang
						$sisakontrak	= date_diff( $sekarang, $akhirkontrak );
						$sisakontrakbln	= $sisakontrak ->m;
						$sisakontrakth	= $sisakontrak->y;	
						$status='Kontrak Kedua';
						$tglkontrak= $datas->secondcontractlatest_date;
						}
						elseif($firstcontract==='CTR001')
						{
						
						$akhirkontrak  	= date_create($datas->firstcontractlatest_date);
						$sekarang 		= date_create(); // waktu sekarang
						$sisakontrak	= date_diff( $sekarang, $akhirkontrak );
						$sisakontrakbln	= $sisakontrak ->m;
						$sisakontrakth	= $sisakontrak->y;	
						$status='Kontrak Pertama';
						$tglkontrak= $datas->firstcontractlatest_date;
						}
						
						elseif($firstcontract=='0' && $secondcontract=='0' && $thirdcontract=='0' && $permanent =='0' )
						
						{
						$status='Belum Kontrak';
						$tglkontrak= '0000-00-00';
						}
						
						
						 if ($jk==='L'){
						$genderid='Laki-laki';
						}
						elseif($jk==='P')
						{
						$genderid='Perempuan';	
						}
						 
						 
						 
						if ($agama=='1'){
						$religi='Islam';	
						}
						elseif($agama=='2')
						{
							$religi='Katolik';
						}
						elseif($agama=='3')
						{
							$religi='Kristen';
						}
						elseif($agama=='4')
						{
							$religi='Hindu';
						}
						elseif($agama=='5')
						{
							$religi='Budha';
						}  
						elseif($agama=='6')
						{
							$religi='Kong Hu Chu';
						}
						
						
						
						
						
						
						
							echo"<tr>";
							echo"<td align='center'>";
								if($akses_menu['update']=='1'){
									echo"<a href='".site_url('calibrasichange/ubahstatus/'.$datas->id)."' class='btn btn-sm btn-primary' title='Change Status' data-role='qtip'><i class='fa fa-edit'></i></a>";
								}									
								if($akses_menu['update']=='1'){
								echo"<a href='".site_url('calibrasichange/division/'.$datas->id)."' class='btn btn-sm btn-success' title='Change Division' data-role='qtip'><i class='fa fa-institution'></i></a>";
								}
								if($akses_menu['update']=='1'){
								echo"<a href='".site_url('calibrasichange/grade/'.$datas->id)."' class='btn btn-sm btn-warning' title='Change Grade' data-role='qtip'><i class='fa fa-signal'></i></a>";
								}
							echo"</td>";	

							//echo"<td align='left'><img  src='".site_url('./assets/img/'.$datas->image)."'></td>";							
							echo"<td align='left'>".$datas->id."</td>";
							echo"<td align='left'>".$datas->nik."</td>";
							echo"<td align='left'>".$datas->name."</td>";
							echo"<td align='left'>".$datas->hometown."</td>";
							echo"<td align='left'>".$datas->birthday."</td>";
							echo"<td align='left'>".$genderid."</td>";
							echo"<td align='left'>".$religi."</td>";
							echo"<td align='left'>".$datas->nationality."</td>";
							echo"<td align='left'>".$datas->address."</td>";
							echo"<td align='left'>".$datas->idcard_address."</td>";
							echo"<td align='left'>".$datas->marital_status."</td>";
							echo"<td align='left'>".$datas->company_name."</td>";
							echo"<td align='left'>".$datas->division_name."</td>";
							echo"<td align='left'>".$datas->department_name."</td>";
							echo"<td align='left'>".$datas->title_name."</td>";
							echo"<td align='left'>".$datas->firstcontract."</td>";
							echo"<td align='left'>".$datas->firstcontractstart_date."</td>";
							echo"<td align='left'>".$datas->firstcontractlatest_date."</td>";
							echo"<td align='left'>".$datas->secondcontract."</td>";
							echo"<td align='left'>".$datas->secondcontractstart_date."</td>";
							echo"<td align='left'>".$datas->secondcontractlatest_date."</td>";
							echo"<td align='left'>".$datas->thirdcontract."</td>";
							echo"<td align='left'>".$datas->thirdcontractstart_date."</td>";
							echo"<td align='left'>".$datas->thirdcontractlatest_date."</td>";
							echo"<td align='left'>".$datas->permanent."</td>";
							echo"<td align='left'>".$datas->permanentstart_date."</td>";
							echo"<td align='left'>".tgl_indo($datas->hiredate)."</td>";
							echo"<td align='left'>".$tahun."". $th.",". $bulan."". $bl.""."</td>";
							echo"<td align='left'>".$status."</td>";
							echo"<td align='left'>".tgl_indo($tglkontrak)."</td>";
							echo"<td align='left'>".$sisakontrakth."". $th.",".$sisakontrakbln."". $bl."</td>";
							echo"<td align='left'>".$datas->flag_active."</td>";
							echo"<td align='left'>".$datas->modified_by."</td>";
							echo"<td align='left'>".$datas->modified."</td>";
						echo"</tr>";
					}
			  }
			  ?>
			</tbody>
			<tfoot>
				<tr class='bg-blue'>
					<th class="text-center">Option</th>
					<!--<th class="text-center">Foto</th> -->
					<th class="text-center">Id</th>
					<th class="text-center">NIK</th>
					<th class="text-center">Name</th>
					<th class="text-center">Hometown</th>
					<th class="text-center">Birthday</th>
					<th class="text-center">Gender</th>
					<th class="text-center">Religion</th>
					<th class="text-center">Nationality</th>
					<th class="text-center">Stay Address</th>
					<th class="text-center">Id Card Address</th>
					<th class="text-center">Marital Status</th>
					<th class="text-center">Company</th>
					<th class="text-center">Division</th>
					<th class="text-center">Departement</th>
					<th class="text-center">Title</th>
					<th class="text-center">First Contract</th>
					<th class="text-center">First Contract Start Date</th>
					<th class="text-center">First Contract Latest Date</th>
					<th class="text-center">Second Contract</th>
					<th class="text-center">Second Contract Start Date</th>
					<th class="text-center">Second Contract Latest Date</th>
					<th class="text-center">Third Contract</th>
					<th class="text-center">Third Contract Start Date</th>
					<th class="text-center">Third Contract Latest Date</th>
					<th class="text-center">Permanent </th>
					<th class="text-center">Permanent Start Date</th>
					<th class="text-center">Work Start</th>
					<th class="text-center">Length of Working</th>
					<th class="text-center">Employee Status</th>
					<th class="text-center">Contract Latest Date </th>
					<th class="text-center">Contract Remaining </th>
					<th class="text-center">Status Aktif</th>
					<th class="text-center">Modified By</th>
					<th class="text-center">Modified Date</th>
					
				</tr>
			</tfoot>
		</table>
	</div>
	<!-- /.box-body -->
 </div>
  <!-- /.box -->

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
	
	
</script>
