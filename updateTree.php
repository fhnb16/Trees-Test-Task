<?

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

header('Content-Type: application/json');

require_once('./config/connect.php');

require_once('./auth.class.php');

$data = json_decode(file_get_contents('php://input'), true);

if((!isset($data) && !isset($data['task']))){
  header("Location: index.php");
}

if(!$auth->isAuth()){
  die('{"status":"error", "message":"You are not logged!"}');
}

$query = "";

switch($data['task']){
	case "add": 
	break;
	case "remove": $query .= "DELETE FROM `internet-clients_datatrees` WHERE `id`='".$dblink->real_escape_string(htmlspecialchars($data["id"]))."';";
	break;
	case "update": $query .= "UPDATE `internet-clients_datatrees` SET `".$dblink->real_escape_string(htmlspecialchars($data["property"]))."`='".$dblink->real_escape_string(htmlspecialchars($data["value"]))."' WHERE `id`='".$dblink->real_escape_string(htmlspecialchars($data["id"]))."';";
	break;
	default: die('{"status":"error", "message":"Wrong parameter: "'.$data['task'].'}');
	break;
}

$result = $dblink->query($query);

$dblink->close();

if($result){
  die('{"status":"success", "message":"Success updated!"}');
}else{
  die('{"status":"error", "message":"'.$dblink->error.'}"');
}








?>