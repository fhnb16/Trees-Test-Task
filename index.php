<?
  $login = false;
  $role = "guest";

  require_once('./functions/auth.class.php');

  if ($auth->isAuth()) {
    $login = $auth->getLogin();
    $role = $auth->getRole();
  }

  if (!file_exists('./config/config.php'))
  {
    die('Create ./config/config.php with DB credintals based on ./config/config.sample.php.');
  } else {
    require_once('./html/front.php');
  }

?>