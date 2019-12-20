<?php

		include("database.php");

		$db = new Database();

		$requestMethod = $_SERVER["REQUEST_METHOD"];

		switch($requestMethod){
				case 'GET':
					if(!empty($_GET["id"])){
						$contactId = intval($_GET["id"]);
						getContacts($db, $contactId);
					}else{
		        getContacts($db);
					}
					break;

				case 'POST':
					$data['first_name'] = $_POST['first_name'];
					$data['surname'] = $_POST['surname'];
					if(!empty($_GET["id"])){
						$contactId = intval($_GET["id"]);
						updateContact($db, $contactId, $data);
					}else{

			      createContact($db, $data);
					}
					break;

				case 'DELTE':
					if(!empty($_GET["id"])){
						$contactId = intval($_GET["id"]);
						deleteContact($db, $contactId);
					}
					break;

				default:
					http_response_code(405);
					break;
		}


function getContacts($db, $contactId = false){
		if($contactId) $contactFilter['contact_id'] = $contactId;

		$contact = $db->get('contact', $contactFilter);
		echo json_encode($contact);
}

function createContact($db, $data){
		$result = $db->insert('contact', $data);
		if($result){
			$response['status'] = 'success';
			$response['contact'] = $data;
			echo json_encode($response);
		}else{
			$response['status'] = 'error';
			echo json_encode($response);
		}
}

function updateContact($db, $contactId, $data){
		$contactFilter['contact_id'] = $contactId;
		$result = $db->update('contact', $contactFilter, $data);
		if($result){
			$response['status'] = 'success';
			$response['contact'] = $data;
			echo json_encode($response);
		}else{
			$response['status'] = 'error';
			echo json_encode($response);
		}
}

function deleteContact($db, $contactId){
	$contactFilter['contact_id'] = $contactId;
	$contact = $db->delete('contact', $contactFilter);
}
?>
