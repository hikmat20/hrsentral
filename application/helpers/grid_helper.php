<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		
		function Enkripsi($sData, $sKey='200881173_limchaemoo'){ 
			$sResult = '';
			for($i=0;$i<strlen($sData);$i++){
				$sChar    = substr($sData, $i, 1);
				$sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
				$sChar    = chr(ord($sChar) + ord($sKeyChar));
				$sResult .= $sChar;
			}
			return Enkripsi_base64($sResult);
		}
		
		function Dekripsi($sData, $sKey='200881173_limchaemoo'){
			$sResult = '';
			$sData   = Dekripsi_base64($sData);
			for($i=0;$i<strlen($sData);$i++){
				$sChar    = substr($sData, $i, 1);
				$sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
				$sChar    = chr(ord($sChar) - ord($sKeyChar));
				$sResult .= $sChar;
			}
			return $sResult;
		}
		
		function Enkripsi_base64($sData){
			$sBase64 = base64_encode($sData);
			return strtr($sBase64, '+/', '-_');
		}
		
		function Dekripsi_base64($sData){
			$sBase64 = strtr($sData, '-_', '+/');
			return base64_decode($sBase64);
		}
		
		function history($desc=NULL){
			$CI 			=& get_instance();
			$path			= $CI->uri->segment(1);
			$data_session	= $CI->session->userdata;
			$userID			= $data_session['User']['username'];
			$Date			= date('Y-m-d H:i:s');
			$IP_Address		= $CI->input->ip_address();
			
			$DataHistory=array();
			$DataHistory['user_id']		= $userID;
			$DataHistory['path']		= $path;
			$DataHistory['description']	= $desc;
			$DataHistory['ip_address']	= $IP_Address;
			$DataHistory['created']		= $Date;		
			$CI->db->insert('histories',$DataHistory);
		}
		
			
		function cryptSHA1($fields){
			$key			='-chaemoo173';
			$Encrpt_Kata	= sha1($fields.$key);
			return $Encrpt_Kata;
		}
		
		function getRomawi($bulan){
			$month	= intval($bulan);
			switch($month){
				case "1":
					$romawi	='I';	
					break;
				case "2":
					$romawi	='II';	
					break;
				case "3":
					$romawi	='III';	
					break;
				case "4":
					$romawi	='IV';	
					break;
				case "5":
					$romawi	='V';	
					break;
				case "6":
					$romawi	='VI';	
					break;
				case "7":
					$romawi	='VII';	
					break;
				case "8":
					$romawi	='VIII';	
					break;
				case "9":
					$romawi	='IX';	
					break;
				case "10":
					$romawi	='X';	
					break;
				case "11":
					$romawi	='XI';	
					break;
				case "12":
					$romawi	='XII';	
					break;
			}
			return $romawi;
		}
		
		function getColsChar($colums)
		{
			// Palleng by jester
			
			if($colums>26)
			{
				$modCols = floor($colums/26);
				$ExCols = $modCols*26;
				$totCols = $colums-$ExCols;
				
				if($totCols==0)
				{
					$modCols=$modCols-1;
					$totCols+=26;
				}
				
				$lets1 = getLetColsLetter($modCols);
				$lets2 = getLetColsLetter($totCols);
				return $letsi = $lets1.$lets2;
			}
			else
			{
				$lets = getLetColsLetter($colums);
				return $letsi = $lets;
			}
		}

		function getLetColsLetter($numbs){
		// Palleng by jester
			switch($numbs){
				case 1:
				$Chars = 'A';
				break;
				case 2:
				$Chars = 'B';
				break;
				case 3:
				$Chars = 'C';
				break;
				case 4:
				$Chars = 'D';
				break;
				case 5:
				$Chars = 'E';
				break;
				case 6:
				$Chars = 'F';
				break;
				case 7:
				$Chars = 'G';
				break;
				case 8:
				$Chars = 'H';
				break;
				case 9:
				$Chars = 'I';
				break;
				case 10:
				$Chars = 'J';
				break;
				case 11:
				$Chars = 'K';
				break;
				case 12:
				$Chars = 'L';
				break;
				case 13:
				$Chars = 'M';
				break;
				case 14:
				$Chars = 'N';
				break;
				case 15:
				$Chars = 'O';
				break;
				case 16:
				$Chars = 'P';
				break;
				case 17:
				$Chars = 'Q';
				break;
				case 18:
				$Chars = 'R';
				break;
				case 19:
				$Chars = 'S';
				break;
				case 20:
				$Chars = 'T';
				break;
				case 21:
				$Chars = 'U';
				break;
				case 22:
				$Chars = 'V';
				break;
				case 23:
				$Chars = 'W';
				break;
				case 24:
				$Chars = 'X';
				break;
				case 25:
				$Chars = 'Y';
				break;
				case 26:
				$Chars = 'Z';
				break;
			}

			return $Chars;
		}

		function getColsLetter($char){
		//	Palleng by jester
			$len = strlen($char);
			if($len==1)
			{
				$numb = getLetColsNumber($char);
			}
			elseif($len==2)
			{
				$i=1;
				$j=0;
				$jm=1;
				while($i<$len)
				{
					$let_fst = substr($char, $j,1);
					$dv = getLetColsNumber($let_fst);
					$jm = $dv * 26;
					
					$i++;
					$j++;
				}
				$let_last = substr($char, $j,1);
				$numb = $jm + getLetColsNumber($let_last);
			}
			
			return $numb;
		}
		
		function getLetColsNumber($char)
		{
			// Palleng by jester
			
			switch($char){
				case 'A':$numb = 1;break;
				case 'B':$numb = 2;break;
				case 'C':$numb = 3;break;
				case 'D':$numb = 4;break;
				case 'E':$numb = 5;break;
				case 'F':$numb = 6;break;
				case 'G':$numb = 7;break;
				case 'H':$numb = 8;break;
				case 'I':$numb = 9;break;
				case 'J':$numb = 10;break;
				case 'K':$numb = 11;break;
				case 'L':$numb = 12;break;
				case 'M':$numb = 13;break;
				case 'N':$numb = 14;break;
				case 'O':$numb = 15;break;
				case 'P':$numb = 16;break;
				case 'Q':$numb = 17;break;
				case 'R':$numb = 18;break;
				case 'S':$numb = 19;break;
				case 'T':$numb = 20;break;
				case 'U':$numb = 21;break;
				case 'V':$numb = 22;break;
				case 'W':$numb = 23;break;
				case 'X':$numb = 24;break;
				case 'Y':$numb = 25;break;
				case 'Z':$numb = 26;break;
			}
			
			return $numb;
		}
	
		function getAcccesmenu($controller=NULL){
			$CI 			=& get_instance();
			$data_session	= $CI->session->userdata;
			$group			= $data_session['User']['group_id'];
			$Action=array();
			if($group=='1'){
				$action["read"]		= 1;
				$action["create"]	= 1;
				$action["update"]	= 1; 
				$action["delete"]	= 1;
				$action["download"]	= 1;
				$action["approve"]	= 1;
			}else{
				$qMenu		= $CI->db->get_where('menus',array('path'=>$controller));
				$dataMenu	= $qMenu->result();
				if($qMenu->num_rows() > 0){				
					$qAccess	= $CI->db->get_where('group_menus',array('menu_id'=>$dataMenu[0]->id,'group_id'=>$group));
					$DataAccess	= $qAccess->result();
					if($DataAccess){
						$action["read"]=(isset($DataAccess[0]->read) && $DataAccess[0]->read)?$DataAccess[0]->read:0;
						$action["create"]=(isset($DataAccess[0]->create) && $DataAccess[0]->create)?$DataAccess[0]->create:0;
						$action["update"]=(isset($DataAccess[0]->update) && $DataAccess[0]->update)?$DataAccess[0]->update:0;
						$action["delete"]=(isset($DataAccess[0]->delete) && $DataAccess[0]->delete)?$DataAccess[0]->delete:0;
						$action["download"]=(isset($DataAccess[0]->download) && $DataAccess[0]->download)?$DataAccess[0]->download:0;
						$action["approve"]=(isset($DataAccess[0]->approve) && $DataAccess[0]->approve)?$DataAccess[0]->approve:0;
					}
				}
				
			}		
			return $action;
		}

		function generate_tree($data=array(),$depth=0,$nilai=array()){
			$ArrDept=array(0=>10,1=>40,2=>70,3=>100);
			if(isset($data) && $data){
				foreach($data as $key=>$value){
					echo create_datas($value,$ArrDept[$depth],$nilai);
					if(array_key_exists('child',$value)){
						generate_tree($value['child'],($depth + 1),$nilai);	
					}
				}
			}
		}
		function create_datas($value=array(),$padding=NULL,$data=array()){				
				$template='<tr>';
				$state['read']		= (isset($data[$value['id']]['read']) && $data[$value['id']]['read'] == 1) ? ' checked="checked"' : '';
				$state['create']	= (isset($data[$value['id']]['create']) && $data[$value['id']]['create'] == 1) ? ' checked="checked"' : '';
				$state['update']	= (isset($data[$value['id']]['update']) && $data[$value['id']]['update'] == 1) ? ' checked="checked"' : '';
				$state['delete']	= (isset($data[$value['id']]['delete']) && $data[$value['id']]['delete'] == 1) ? ' checked="checked"' : '';
				$state['download']	= (isset($data[$value['id']]['download']) && $data[$value['id']]['download'] == 1) ? ' checked="checked"' : '';
				$state['approve']	= (isset($data[$value['id']]['approve']) && $data[$value['id']]['approve'] == 1) ? ' checked="checked"' : '';
				$template.=		'<td align="left" style="padding-left:'.$padding.'px;"><input type="hidden" name="tree['.$value['id'].'][menu_id]" value="'.$value['id'].'">  '.$value['name'].'</td>';
				$template.=		'<td align="center"><input type="checkbox" id="read'.$value['id'].'" class="minimal" name="tree['.$value['id'].'][read]" value="1"'.$state['read'].'></td>';
				$template.=		'<td align="center"><input type="checkbox" id="create'.$value['id'].'" class="minimal" name="tree['.$value['id'].'][create]" value="1"'.$state['create'].'></td>';
				$template.=		'<td align="center"><input type="checkbox" id="update'.$value['id'].'" class="minimal" name="tree['.$value['id'].'][update]" value="1"'.$state['update'].'></td>';
				$template.=		'<td align="center"><input type="checkbox" id="delete'.$value['id'].'" class="minimal" name="tree['.$value['id'].'][delete]" value="1"'.$state['delete'].'></td>';
				$template.=		'<td align="center"><input type="checkbox" id="approve'.$value['id'].'" class="minimal" name="tree['.$value['id'].'][approve]" value="1"'.$state['approve'].'></td>';
				$template.=		'<td align="center"><input type="checkbox" id="download'.$value['id'].'" class="minimal" name="tree['.$value['id'].'][download]" value="1"'.$state['download'].'></td>';
				$template.='</tr>';
			//echo $template;
			return $template;
		}
		
		function group_menus_access(){
			$CI 			=& get_instance();
			$data_session	= $CI->session->userdata;
			$groupID		= $data_session['User']['group_id'];
			
			$ArrMenu	= array();
			if($groupID=='1'){
				$Query	= "SELECT * FROM menus WHERE flag_active='1' ORDER BY parent_id,weight,id ASC";
			}else{
				$Query	= "SELECT menus.* FROM menus INNER JOIN group_menus ON menus.id=group_menus.menu_id WHERE menus.flag_active='1' AND group_menus.group_id='$groupID' ORDER BY menus.parent_id,menus.weight,menus.id ASC";
			}
			
			$jumlah		= $CI->db->query($Query)->num_rows();		
			
			if($jumlah > 0){
				$hasil		= $CI->db->query($Query)->result_array();
				
				foreach($hasil as $key=>$val){
					$ArrMenu[$key]['Menu']['id']		= $val['id'];
					$ArrMenu[$key]['Menu']['name']		= $val['name'];
					$ArrMenu[$key]['Menu']['path']		= $val['path'];
					$ArrMenu[$key]['Menu']['parent_id']	= $val['parent_id'];
					$ArrMenu[$key]['Menu']['weight']	= $val['weight'];
					$ArrMenu[$key]['Menu']['icon']		= $val['icon'];				
				}
			}
			$Menus	= rebuild_structure($ArrMenu);
			return $Menus;
		}			
		
			
		//echo"<pre>";print_r($Menus);	exit;
			
		
		function rebuild_structure($data){
			$childs = array();

			foreach($data as &$item){
				$childs[$item['Menu']['parent_id']][] = &$item['Menu'];
				unset($item);
			}
			
			foreach($data as &$item){
				if (isset($childs[$item['Menu']['id']])){
					$item['Menu']['child'] = $childs[$item['Menu']['id']];
					unset($childs[$item['Menu']['id']]);
				}
			}

		//	pr($childs);exit;
		//	menu that has no parent, append it as parent
			if(count($childs) > 0){
				foreach($childs as $key => $child){
					if($key != 0){
						$childs[0][] = $child[0];
						unset($childs[$key]);
					}
				}
			}

			return isset($childs[0]) ? $childs[0] : array();
		}
		
		function render_left_menus($fixed_structure=array(),$dept=0){
			//if first render echo wrapper
			if($dept==0){
				echo '<ul class="sidebar-menu" id="menu">';
				echo '<li class="header">MAIN NAVIGATION</li>';
			}
			
			//loop children
			foreach($fixed_structure as $key=>$value){			
				$path=$value['path']==''?'#':base_url().'index.php/'.strtolower($value['path']);
				$icons=$value['icon'];			
				
				if(array_key_exists('child',$value)){
					echo'<li class="treeview"><a href="'.$path.'"><i class="fa '.$icons.'"></i>'.$value['name'].'<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
					echo('<ul class="treeview-menu">');
					render_left_menus($value['child'],$dept+1);
					echo('</ul>');
				}else{
					echo'<li class="treeview"><a href="'.$path.'"><i class="fa '.$icons.'"></i>'.$value['name'].'</a>';
				}
				echo('</li>');
			}
			if($dept==0)echo('</ul>');	
		}
		
		function group_access($groupID){
			$CI 			=& get_instance();
			$data_session	= $CI->session->userdata;
			//$groupID		= $data_session['User']['group_id'];
			$MenusAccess	= array();
			$Query	= "SELECT menus.*,group_menus.id AS kode_group,group_menus.read,group_menus.create,group_menus.update,group_menus.delete,group_menus.approve,group_menus.download FROM menus LEFT JOIN group_menus ON menus.id=group_menus.menu_id AND group_menus.group_id='$groupID' WHERE menus.flag_active='1' ORDER BY menus.parent_id,menus.weight,menus.id ASC";
			
			$jumlah		= $CI->db->query($Query);
			//echo"ono bro ".$jumlah;exit;
			if($jumlah->num_rows() > 0){
				$hasil		= $jumlah->result_array();
				
				foreach($hasil as $key=>$val){
					if($groupID=='1'){
						$MenusAccess[$val['id']]['read']=1;	
						$MenusAccess[$val['id']]['create']=1;
						$MenusAccess[$val['id']]['update']=1;
						$MenusAccess[$val['id']]['delete']=1;
						$MenusAccess[$val['id']]['approve']=1;
						$MenusAccess[$val['id']]['download']=1;
					}else{
						if(isset($val['kode_group']) && $val['kode_group']){
							$MenusAccess[$val['id']]['read']=$val['read'];	
							$MenusAccess[$val['id']]['create']=$val['create'];
							$MenusAccess[$val['id']]['update']=$val['update'];
							$MenusAccess[$val['id']]['delete']=$val['delete'];
							$MenusAccess[$val['id']]['approve']=$val['approve'];
							$MenusAccess[$val['id']]['download']=$val['download'];
						}
					}
								
				}
			}
			
			return $MenusAccess;
		}			
		function reconstruction_tree($parent_id=0,$data=array()){
			$menus=array();
			foreach($data as $key=>$value){
				$index=count($menus);
				if($value['parent_id']==$parent_id){
					$menus[$index]=$value;
					if(count($value) >1){
						$menus[$index]['detail']=$value;	
					}
					//unset print
					unset($data[$key]);
					if($child=reconstruction_tree($value['id'],$data)){
						$menus[$index]['child']=$child;	
					}
				}
			}
			return $menus;
		}
		function implode_data($data=array(),$key='key'){
			if(strtolower($key)=='key'){
				$det_imp	="";
				foreach($data as $key=>$val){
					if(!empty($det_imp))$det_imp.="','";
					$det_imp	.=$key;
				}
			}else{
				$det_imp	=implode("','",$data);
			}
			return $det_imp;
		}
		function getExtension($str) {
			 $i = strrpos($str,".");
			 if (!$i) { return ""; } 

			 $l = strlen($str) - $i;
			 $ext = substr($str,$i+1,$l);
			 return $ext;
		}
		
		function company_access($Fields=''){
			$CI 			=& get_instance();			
			$data_session	= $CI->session->userdata;			
			$DataReturn		= '';
			if($Fields){
				$GroupId	= $data_session['User']['group_id'];
				if($GroupId !=1){
					if($GroupId == 2){
						if(strtolower($Fields)=='company'){
							$DataReturn		= $data_session['Employee']['company_id'];
						}else if(strtolower($Fields)=='division'){
							$DataReturn		= $data_session['Employee']['division_id'];
						}else if (strtolower($Fields)=='department'){
							$DataReturn		= $data_session['Employee']['department_id'];
						}else if(strtolower($Fields)=='title'){
							$DataReturn		= $data_session['Employee']['title_id'];
						}
					}else{
						if(strtolower($Fields)=='company'){
							$Tables		= 'company_id';
						}else if(strtolower($Fields)=='division'){
							$Tables		= 'division_id';
						}else if (strtolower($Fields)=='department'){
							$Tables		= 'department_id';
						}else if(strtolower($Fields)=='title'){
							$Tables		= 'title_id';
						}
						
						$Query_Data		= "SELECT DISTINCT(".$Tables.") FROM group_companies WHERE group_id='".$GroupId."'";
						$Pros_Data		= $CI->db->query($Query_Data);
						$num_Datas		= $Pros_Data->num_rows();
						if($num_Datas > 0){
							$Datas		= $Pros_Data->result_array();
							foreach($Datas as $key=>$val){
								if(!empty($DataReturn))$DataReturn .= ',';
								$DataReturn			.=$val[$Tables];	
							}
						}
						
					}
				}
			}
			return $DataReturn;
		}
		
		function Company_Tree_Access(){
			$CI 			=& get_instance();
			$Arr_Balik		= $sect_status	= $sect_id	= $sect_name	= $group_pt	= $group_div = $group_dept = array();
			$loop			= 0;
			$Data_Comp		= $CI->db->get('companies')->result_array();
			if($Data_Comp){
				foreach($Data_Comp as $keyC=>$valC){
					$loop++;
					$Company_Id				= $valC['id'];
					$Company_Name			= $valC['name'];
					$sect_status[$loop]		= 'company';
					$sect_id[$loop]			= $Company_Id;
					$sect_name[$loop]		= $Company_Name;
					$group_pt[$loop]		= $Company_Id;
					
					// get data Divisi
					$WHR_Div		= array(
						'company_id'	=> $Company_Id
					);
					$Data_Div		= $CI->db->get_where('divisions',$WHR_Div)->result_array();
					if($Data_Div){
						foreach($Data_Div as $keyD=>$valD){
							$loop++;
							$Division_Id			= $valD['id'];
							$Division_Name			= $valD['name'];
							$sect_status[$loop]		= 'division';
							$sect_id[$loop]			= $Division_Id;
							$sect_name[$loop]		= $Division_Name;
							$group_pt[$loop]		= $Company_Id;
							$group_div[$loop]		= $Division_Id;
							
							// get data Department
							$WHR_Dept		= array(
								'company_id'		=> $Company_Id,
								'division_id'		=> $Division_Id
							);
							$Data_Dept		= $CI->db->get_where('departments',$WHR_Dept)->result_array();
							if($Data_Dept){
								foreach($Data_Dept as $keyE=>$valE){
									$loop++;
									$Depart_Id				= $valE['id'];
									$Depart_Name			= $valE['name'];
									$sect_status[$loop]		= 'department';
									$sect_id[$loop]			= $Depart_Id;
									$sect_name[$loop]		= $Depart_Name;
									$group_pt[$loop]		= $Company_Id;
									$group_div[$loop]		= $Division_Id;
									$group_dept[$loop]		= $Depart_Id;
									
									// get data Title
									$WHR_Title		= array(
										'company_id'		=> $Company_Id,
										'division_id'		=> $Division_Id,
										'department_id'		=> $Depart_Id
									);
									$Data_Title		= $CI->db->get_where('titles',$WHR_Title)->result_array();
									if($Data_Title){
										foreach($Data_Title as $keyF=>$valF){
											$loop++;
											$Title_id				= $valF['id'];
											$Title_Name				= $valF['name'];
											$sect_status[$loop]		= 'title';
											$sect_id[$loop]			= $Title_id;
											$sect_name[$loop]		= $Title_Name;
											$group_pt[$loop]		= $Company_Id;
											$group_div[$loop]		= $Division_Id;
											$group_dept[$loop]		= $Depart_Id;
										}
									}
								}
							}
						}
					}
				}
			}
			
			$Arr_Balik	= array(
				'sectionstatus'		=> $sect_status,
				'sectionid'			=> $sect_id,
				'sectionname'		=> $sect_name,
				'grppt'				=> $group_pt,
				'grpdiv'			=> $group_div,
				'grpdept'			=> $group_dept
			);
			
			return $Arr_Balik;
		}
		
		function Company_Access_Group($kode=''){
			$CI 			=& get_instance();
			$WHERE			= array(
				'group_id'		=> $kode
			);
			$Arr_Return		= array();
			$Arr_Comp		= $Arr_Div	= $Arr_Dept = $Arr_Title	= array();
			$Data_Akses		= $CI->db->get_where('group_companies',$WHERE)->result_array();
			if($Data_Akses){
				foreach($Data_Akses as $keyA=>$valA){
					$Comp_Id		= $valA['company_id'];
					$Div_Id			= $valA['division_id'];
					$Dept_Id		= $valA['department_id'];
					$Title_Id		= $valA['title_id'];
					
					if(!in_array($Comp_Id,$Arr_Comp)){
						$intA				= count($Arr_Comp) + 1;
						$Arr_Comp[$intA]	= $Comp_Id;
					}
					
					if(!in_array($Div_Id,$Arr_Div)){
						$intB				= count($Arr_Div) + 1;
						$Arr_Div[$intB]		= $Div_Id;
					}
					
					if(!in_array($Dept_Id,$Arr_Dept)){
						$intC				= count($Arr_Dept) + 1;
						$Arr_Dept[$intC]		= $Dept_Id;
					}
					
					if(!in_array($Title_Id,$Arr_Title)){
						$intD				= count($Arr_Title) + 1;
						$Arr_Title[$intD]	= $Title_Id;
					}
					
				}
				unset($Data_Akses);
				if($Arr_Comp){
					$Arr_Return['ArrComp']		= $Arr_Comp;
				}
				if($Arr_Div){
					$Arr_Return['ArrDiv']		= $Arr_Div;
				}
				if($Arr_Dept){
					$Arr_Return['ArrDept']		= $Arr_Dept;
				}
				if($Arr_Title){
					$Arr_Return['ArrTitle']		= $Arr_Title;
				}
				
				unset($Arr_Comp);
				unset($Arr_Div);
				unset($Arr_Dept);
				unset($Arr_Title);
			}
			
			return $Arr_Return;
		}
		
	
	function tahun($tgl){
			$tahun = substr($tgl,0,4);
			return $tahun;		 
	}	
	
	function tgl_indo($tgl){
			$tanggal = substr($tgl,8,2);
			$bulan =substr($tgl,5,2);
			$tahun = substr($tgl,0,4);
			return $tanggal.'/'.$bulan.'/'.$tahun;		 
	}	

	function getBulan($bln){
				switch ($bln){
					case 1: 
						return "Januari";
						break;
					case 2:
						return "Februari";
						break;
					case 3:
						return "Maret";
						break;
					case 4:
						return "April";
						break;
					case 5:
						return "Mei";
						break;
					case 6:
						return "Juni";
						break;
					case 7:
						return "Juli";
						break;
					case 8:
						return "Agustus";
						break;
					case 9:
						return "September";
						break;
					case 10:
						return "Oktober";
						break;
					case 11:
						return "November";
						break;
					case 12:
						return "Desember";
						break;
				}
			} 
			
		function tgl_indojam($tgl){
			$tanggal2 = substr($tgl,8,2);
			$bulan2 =substr($tgl,5,2);
			$tahun2 = substr($tgl,0,4);
			$jam = substr($tgl,11,2);
			$menit = substr($tgl,14,2);
			
			return $tanggal2.'/'.$bulan2.'/'.$tahun2.' '.$jam.':'.$menit;		 
		}
		
		function jin_date_sql($date){
	$exp = explode('/',$date);
	if(count($exp) == 3) {
		$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
	}
	return $date;
}
 
function jin_date_str($date){
	$exp = explode('-',$date);
	if(count($exp) == 3) {
		$date = $exp[2].'/'.$exp[1].'/'.$exp[0];
	}
	return $date;
}	
?>