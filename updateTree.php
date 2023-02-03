<?

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require_once('./config/connect.php');

require_once('./auth.class.php');

if((!isset($_POST['id']) && !isset($_POST['task'])) || !$auth->isAuth()){
  header("Location: index.php");
}

header('Content-Type: application/json');

die('{"status":"success"}');








?>