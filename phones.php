<?php

		include("database.php");

		$db = new Database();

		$requestMethod = $_SERVER["REQUEST_METHOD"];

		switch($requestMethod){
				case 'GET':
					if(!empty($_GET["id"])){
						$phoneId = intval($_GET["id"]);
						getphones($db, $phoneId);
					}else{
		        getphones($db);
					}
					break;

				case 'POST':
					$data['contact_id'] = $_POST['contact_id'];
					$data['phone'] = $_POST['phone'];
					if(!empty($_GET["id"])){
						$phoneId = intval($_GET["id"]);
						updatePhone($db, $phoneId, $data);
					}else{

			      createPhone($db, $data);
					}
					break;

				case 'DELTE':
					if(!empty($_GET["id"])){
						$phoneId = intval($_GET["id"]);
						deletePhone($db, $phoneId);
					}
					break;

				default:
					http_response_code(405);
					break;
		}


function getPhones($db, $phoneId = false){
		if($phoneId) $phoneFilter['phone_id'] = $phoneId;

		$phone = $db->get('phone', $phoneFilter);
		echo json_encode($phone);
}

function createPhone($db, $data){
		$result = $db->insert('phone', $data);
		if($result){
			$response['status'] = 'success';
			$response['phone'] = $data;
			echo json_encode($response);
		}else{
			$response['status'] = 'error';
			echo json_encode($response);
		}
}

function updatePhone($db, $phoneId, $data){
		$phoneFilter['phone_id'] = $phoneId;
		$result = $db->update('phone', $phoneFilter, $data);
		if($result){
			$response['status'] = 'success';
			$response['phone'] = $data;
			echo json_encode($response);
		}else{
			$response['status'] = 'error';
			echo json_encode($response);
		}
}

function deletePhone($db, $phoneId){
	$phoneFilter['phone_id'] = $phoneId;
	$phone = $db->delete('phone', $phoneFilter);
}
?>
