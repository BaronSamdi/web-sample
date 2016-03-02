<?php

namespace admin;

require_once __DIR__ . '/../DataRetrieval/Database_Client.php';
require_once __DIR__ . '/../../includes/constants.php';
require_once __DIR__ . '/../ExceptionHandling/ExceptionHandler.php';

use DataRetrieval\Database_Client;



class Admin {
	
	
	public static function validate_admin_login($username, $password){
		if(strcmp($username, ADMIN_LOGIN_USERNAME) == 0 && strcmp($password, ADMIN_LOGIN_PASSWORD) == 0){
			$_SESSION[ADMIN_IS_LOGGED_IN] = 'true';
			header('location: '. ADMIN_BASE_URL);
		}
		else 
			return "Nope. Try again.";			
	}
	
	
	
	public static function get_Admin_Info_By_userID($userID) {
	
		$html = "";
		$result = Database_Client::get_user_Info_By_userID($userID);
	
		// If database query threw Exception
		if ( !$result ) {
			echo 
					'<div class="container">
						<div class="row">
						<h3 style="text-align:center;">Query resulted in error</h3>						
					</div></div>';
		}
		else {
			$html = self::add_query_by_email_or_uid_table_data($result);
				
			echo $html;
		}	
	}
	
	
	public static function get_Admin_Info_By_Email($email) {
	
		$html = "";
		$result = Database_Client::get_User_Info_By_Email($email);
	
		// If database query threw Exception
		if ( !$result ) {
			echo '<div class="container">
						<div class="row">
						<h3 style="text-alin:center;">Query resulted in error</h3>
					</div></div>';
		}
		else {
			$html = self::add_query_by_email_or_uid_table_data($result);
				
			echo $html;
		}
	}
	
	
	public static function get_Admin_Info_By_Name($name) {
	
		// TBD
	}
	
	
	public static function add_query_by_email_or_uid_table_data($query_res){
		
		$html = "";
		$usersArr = array();
		$table_index = 0;
		
		if($query_res['Count'] == 0){
			return '<div class="container">
							<div class="row">
							<h3 style="text-align:center;">No results found</h3>						
						</div></div>';
		}
		
		
		foreach($query_res['Items'] as $item){
		
		
			$html = '<script>
						$(document).ready(function(){
						    $("#table'.$table_index.'").dataTable({
								"lengthMenu": [[25, 50, -1], [25, 50, "All"]],
								paging: false,
								bFilter: false,
						    	bInfo : false
							});
						});
						</script>
					<div class="container">
							<div class="row">
							<h2 style="text-align:center;">User Info</h2>
						    <br>
							<table class="table table-bordered stripe" id="table'.$table_index.'">
									<thead>
									<tr><th>UserId</th>
									<th>E-mail</th>
									<th>Name</th>
									<th>Last Launch</th>
									<th>App ver</th>
									<th>BackupPlan</th>
									<th>Device</th>
									</tr>
							</thead>
							<tbody>';						
					
				$html .=
				'<tr class="inner">';
				if(isset($item[MEMBER_USER_ID]['S']))
		             $html .= '<td>'.$item[MEMBER_USER_ID]['S'].'</td>';
				else
					$html .= '<td> --- </td>';
				
				if(isset($item[MEMBER_USER_EMAIL]['S']))
					$html .= '<td>'.$item[MEMBER_USER_EMAIL]['S'].'</td>';
				else
					$html .= '<td> --- </td>';
											             	             		
					
				if(isset($item[MEMBER_FIRST_NAME]['S'])){
					$html .=  '<td>'.$item[MEMBER_FIRST_NAME]['S'].' '.$item[MEMBER_LAST_NAME]['S'].'</td>';
				}
				else if(isset($item[MEMBER_FB_NAME]['S'])){
					$html .=  '<td>'.$item[MEMBER_FB_NAME]['S'].'</td>';
				}
				else 
					$html .=  '<td> --- </td>';
					
				if(isset($item[MEMBER_LAST_LAUNCH_DATE]['N']))
					$html .= '<td>'.date('Y-m-d h:i:s',$item[MEMBER_LAST_LAUNCH_DATE]['N']).'</td>';
				else
					$html .= '<td> --- </td>';
				
				if(isset($item[MEMBER_APP_VERSION]['S']))
					$html .= '<td>'.$item[MEMBER_APP_VERSION]['S'].'</td>';
				else
					$html .= '<td> --- </td>';
				
				if(isset($item[MEMBER_BACKUP_PLAN]['S']))
					$html .= '<td>'.$item[MEMBER_BACKUP_PLAN]['S'].'</td>';
				else
					$html .= '<td> --- </td>';
				
				if(isset($item[MEMBER_DEVICE]['S']))
					$html .= '<td>'.$item[MEMBER_DEVICE]['S'].'</td>';
				else
					$html .= '<td> --- </td>';
					
						
				
				$html .=  '</tr></tbody>
						        </table>
							</div></div>';
			
				$table_index += 1;
								
				$html .='<br>';
						
				$html .= '<script>
							$(document).ready(function(){
							    $("#table'.$table_index.'").dataTable({
									"lengthMenu": [[25, 50, -1], [25, 50, "All"]],
									paging: false,
									bFilter: false,
							    	bInfo : false
								});
							});
							</script>
						<div class="container">
								<div class="row">						
								<table class="table table-bordered stripe" id="table'.$table_index.'">
										<thead>
										<tr>
										<th>Country</th>
										<th>Verified</th>
										<th>Events</th>
										<th>UploadInProgress</th>
										<th>AppName</th>
										<th>Upgraded</th>
										</tr>
								</thead>
								<tbody>';
				
		
				$html .= '<tr class="inner">';
				
				if(isset($item[MEMBER_COUNTRY]['S']))
					$html .= '<td>'.$item[MEMBER_COUNTRY]['S'].'</td>';
				else
					$html .= '<td> --- </td>';
				
				if(isset($item[MEMBER_VERIFIED]['N']))
					$html .= '<td>'.$item[MEMBER_VERIFIED]['N'].'</td>';
				else
					$html .= '<td> --- </td>';
						
				if(isset($item[MEMBER_EVENTS]['S']))
					$html .= '<td>'.$item[MEMBER_EVENTS]['S'].'</td>';
				else
					$html .= '<td> --- </td>';
				
				if(isset($item[MEMBER_UPLOAD_IN_PROGRESS]['N']))
					$html .= '<td>'.$item[MEMBER_UPLOAD_IN_PROGRESS]['N'].'</td>';
				else
					$html .= '<td> --- </td>';
				
				if(isset($item[MEMBER_APP_NAME]['S']))
					$html .= '<td>'.$item[MEMBER_APP_NAME]['S'].'</td>';
				else
					$html .= '<td> --- </td>';
				
				if(isset($item[MEMBER_UPGRADED]['N']))
					$html .= '<td>'.$item[MEMBER_UPGRADED]['N'].'</td>';
				else
					$html .= '<td> --- </td>';
					
				
				$html .=  '</tr></tbody>
						        </table>
							</div></div>';
				
				$table_index += 1;
				
			
				
				$result = Database_Client::get_Albums_By_UserID($item[MEMBER_USER_ID]['S']);
				if ( !$result )
					continue;
				
					$html .='<br><br>
					<script>
						$(document).ready(function(){
						    $("#table'.$table_index.'").dataTable({
									"lengthMenu": [[25, 50, -1], [25, 50, "All"]],
						    		paging: false
								});
						});
						</script>
						<div class="container">
							<div class="row">
							<h2 style="text-align:center;">Albums</h2>
							<table class="table table-bordered stripe" id="table'.$table_index.'">
									<thead>
									<tr>
									<th>AlbumID</th>
									<th>Album Title</th>
									<th>Number of photos</th>
									<th>Year</th>
									</tr>
							</thead>
							<tbody>';
					
				foreach($result['Items'] as $album){
					$html .= '<tr class="inner">';
	
					if(isset($album[MEMBER_ALBUM_ID]['S']))
						$html .= '<td>'.$album[MEMBER_ALBUM_ID]['S'].'</td>';
					else
						$html .= '<td> --- </td>';
					
					if(isset($album[MEMBER_ALBUM_TITLE]['S']))
						$html .= '<td>'.$album[MEMBER_ALBUM_TITLE]['S'].'</td>';
					else
						$html .= '<td> --- </td>';
				            			           
		
					$photos_res = Database_Client::get_Extracted_Shots_By_Album_ID($item[MEMBER_USER_ID]['S'], $album[MEMBER_ALBUM_ID]['S']);
					if ( !$photos_res )
						$html .= '<td>query error</td>';
					else {
						$html .= '<td>'. $photos_res['Count'] . '</td>';
					}
					
					if(isset($album[MEMBER_ALBUM_YEAR]['N']))
						$html .= '<td>'.$album[MEMBER_ALBUM_YEAR]['N'].'</td>';
					else
						$html .= '<td> --- </td>';								
					
					$html .= '</tr>';
	
				}
		
				$html .= '</tbody>
					        </table>
						</div></div>';
					
			
			}
		
		return $html;
	
	}	

}		
	