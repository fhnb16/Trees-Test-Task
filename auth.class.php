<?php
//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start(); //Запускаем сессии
class AuthClass
{

    /**
     * Проверяет, авторизован пользователь или нет
     * Возвращает true если авторизован, иначе false
     * @return boolean
     */
    public function isAuth()
    {
        if (isset($_SESSION["is_auth"]))
        { //Если сессия существует
            return $_SESSION["is_auth"]; //Возвращаем значение переменной сессии is_auth (хранит true если авторизован, false если не авторизован)
            
        }
        else return false; //Пользователь не авторизован, т.к. переменная is_auth не создана
        
    }

    /**
     * Авторизация пользователя
     * @param string $login
     * @param string $passwors
     */
    public function auth($dblink, $login, $password)
    {

        $salt = "meow"; // Соль для пароля

        $passHashSalt = md5($password . $salt);

        $query = "SELECT * FROM `internet-clients_users` WHERE `username` = '" . $login . "' AND `password` = '" . $passHashSalt . "' LIMIT 1";

        $result = $dblink->query($query);

        $dblink->close();

        $assoc = $result->fetch_assoc();

        if ($result->num_rows > 0)
        {
            // user+password found
            $_SESSION["is_auth"] = true; //Делаем пользователя авторизованным
            $_SESSION["login"] = $assoc["username"]; //Записываем в сессию логин пользователя
            $_SESSION["role"] = $assoc["role"]; //Записываем в сессию права пользователя
            $_SESSION["email"] = $assoc["email"]; //Записываем в мыло права пользователя
            return true;
        }
        else
        {
            $_SESSION["is_auth"] = false;
            return false;
        }
    }

    /**
     * Метод возвращает логин авторизованного пользователя
     */
    public function getLogin()
    {
        if ($this->isAuth())
        { //Если пользователь авторизован
            return $_SESSION["login"]; //Возвращаем логин, который записан в сессию
            
        }
    }
    public function getRole()
    {
        if ($this->isAuth())
        { //Если пользователь авторизован
            return $_SESSION["role"]; //Возвращаем логин, который записан в сессию
            
        }
    }
    public function getEmail()
    {
        if ($this->isAuth())
        { //Если пользователь авторизован
            return $_SESSION["email"]; //Возвращаем логин, который записан в сессию
            
        }
    }

    public function out()
    {
        $_SESSION = array(); //Очищаем сессию
        session_destroy(); //Уничтожаем
        
    }
}

$auth = new AuthClass();

if (isset($_GET["is_exit"]))
{ //Если нажата кнопка выхода
    if ($_GET["is_exit"] == 1)
    {
        $auth->out(); //Выходим
        header("Location: index.php?is_exit=0"); //Редирект после выхода
        
    }
}

?>
