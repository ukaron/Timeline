<?php
class Model_Sign_In extends Model
{
    public $login;
    public $pass;

    public function sign_in($user)
    {
        session_start();
        if ($this->check_admin($user))
        {
            $_SESSION['admin'] = $this->login;
            $_SESSION['user'] = $this->login;
            $_SESSION['status'] = "admin";
            header('Location:/admin');
        }
        elseif ($this->check_moderator($user))
        {
            $_SESSION['moderator'] = $this->login;
            $_SESSION['user'] = $this->login;
            $_SESSION['status'] = "moder";
            header('Location:/moder');
        }
        elseif ($this->check_user($user))
        {
            $_SESSION['user'] = $this->login;
            $_SESSION['status'] = "user";
            header('Location:/');
        }
        else
            return "Wrong login or password";
    }

    public function check_admin($user)
    {
        $this->login = $user['login'];
        $this->pass = $user['pass'];
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT login_a FROM news_db.admins WHERE login_a=?
                                                                            AND pass_a = ?;");
        $query->execute(array($this->login, $this->pass));
        if (($row_1 = $query->fetch()) == true)
            return true;
        else
            return false;
    }

    public function check_moderator($user)
    {
        $this->login = $user['login'];
        $this->pass = $user['pass'];
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT login_m FROM news_db.moderators WHERE login_m = ?
                                                                            AND pass_m = ?;");
        $query->execute(array($this->login, $this->pass));
        if (($row_1 = $query->fetch()) == true)
            return true;
        else
            return false;
    }
    public function check_user($user)
    {
        $this->login = $user['login'];
        $this->pass = $user['pass'];
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT login FROM news_db.followers WHERE login= ?
                                                                            AND pass = ?;");
        $query->execute(array($this->login, $this->pass));
        if (($row_1 = $query->fetch()) == true)
            return true;
        else
            return false;
    }

}