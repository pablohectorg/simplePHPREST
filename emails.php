<?php

		include("database.php");

		$db = new Database();

		$requestMethod = $_SERVER["REQUEST_METHOD"];

		switch($requestMethod){
				case 'GET':
					if(!empty($_GET["id"])){
						$emailId = intval($_GET["id"]);
						getemails($db, $emailId);
					}else{
		        getemails($db);
					}
					break;

				case 'POST':
					$data['contact_id'] = $_POST['contact_id'];
					$data['email'] = $_POST['email'];
					if(!empty($_GET["id"])){
						$emailId = intval($_GET["id"]);
						updateemail($db, $emailId, $data);
					}else{

			      createemail($db, $data);
					}
					break;

				case 'DELTE':
					if(!empty($_GET["id"])){
						$emailId = intval($_GET["id"]);
						deleteemail($db, $emailId);
					}
					break;

				default:
					http_response_code(405);
					break;
		}


function getemails($db, $emailId = false){
		if($emailId) $emailFilter['email_id'] = $emailId;

		$email = $db->get('email', $emailFilter);
		echo json_encode($email);
}

function createemail($db, $data){
		$result = $db->insert('email', $data);
		if($result){
			$response['status'] = 'success';
			$response['email'] = $data;
			echo json_encode($response);
		}else{
			$response['status'] = 'error';
			echo json_encode($response);
		}
}

function updateemail($db, $emailId, $data){
		$emailFilter['email_id'] = $emailId;
		$result = $db->update('email', $emailFilter, $data);
		if($result){
			$response['status'] = 'success';
			$response['email'] = $data;
			echo json_encode($response);
		}else{
			$response['status'] = 'error';
			echo json_encode($response);
		}
}

function deleteemail($db, $emailId){
	$emailFilter['email_id'] = $emailId;
	$email = $db->delete('email', $emailFilter);
}
?>
