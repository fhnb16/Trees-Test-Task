<?

require_once ('./config/connect.php');

require_once ('./auth.class.php');

if (!isset($_POST['login']))
{
    header("Location: index.php");
}

if (isset($_POST["login"]) && isset($_POST["pass"]) && !empty($_POST["login"]) && !empty($_POST["pass"]))
{ //Если логин и пароль были отправлены
    if (!$auth->auth($dblink, $dblink->real_escape_string(htmlspecialchars($_POST["login"])) , $dblink->real_escape_string(htmlspecialchars($_POST["pass"]))))
    {
        //Если логин и пароль введен не правильно
        header('Content-Type: application/json');
        die('{"result":"403","message":"Wrong login/password"}');
    }
    else
    {
        header('Content-Type: application/json');
        die('{"result":"200"}');
    }
}
else
{
    header('Content-Type: application/json');
    die('{"result":"403","message":"Empty login/password"}');
}

?>
