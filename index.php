<?php
$request_method = $_SERVER['REQUEST_METHOD'];
$response = array();
switch ($request_method) {
	case 'GET':
		response(doGet());
		break;
		case 'PUT':
		response(doPut());
		break;
		case 'POST':
		response(doPost());
		break;
		case 'DELETE':
		response(doDelete());
		break;
	
	
}
function doGet(){
	if (@$_GET['id']) {
		@$id = $_GET['id'];
		$where = "where id =".$id ;
	}else{
		$id = 0;
		$where = "";
	}
$dbconnect = mysqli_connect("localhost","root","","bjb");
$query = mysqli_query($dbconnect,"SELECT * FROM sign_up".$where);
while($data = mysqli_fetch_assoc($query)){;
$response[] = array("id" => $data['id'],"name" => $data['name'],"email" => $data['email']);
}
return $response;
}
function doput(){
parse_str(file_get_contents('php://input'),$_PUT);
if ($_PUT) {
		
$dbconnect = mysqli_connect("localhost","root","","bjb");
$query = mysqli_query($dbconnect,"UPDATE sign_up SET  name= '".$_PUT['name']."', email= '".$_PUT['email']."' where id = '".$_GET['id']."'");
if($query == true){

	$response = array("message" => "Success update");

}
else{
	$response = array("message"=>"Failed");
}
}
return $response;
}
function doPost(){

if ($_POST) {
		
$dbconnect = mysqli_connect("localhost","root","","bjb");
$query = mysqli_query($dbconnect,"INSERT INTO sign_up (name,email) values ('".$_POST['name']."','".$_POST['email']."')");
if($query == true){

	$response = array("message" => "Success");

}
else{
	$response = array("message"=>"Failed");
}
}
return $response;

}
function doDelete(){
if (@$_GET['id']) {
$dbconnect = mysqli_connect("localhost","root","","bjb");
$query = mysqli_query($dbconnect,"DELETE FROM sign_up where id = '".$_GET['id']."'");
if($query == true){

	$response = array("message" => "Deleted");

}
else{
	$response = array("message"=>"Failed");
}

}
return $response; 
}
function response($response){
echo json_encode(array("Status" =>"200","data"=>$response));
}
?>
