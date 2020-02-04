<?php
class Model_Sign_Up extends Model
{
    protected $email_c;
    protected $login_c;
    protected $pass_c;
    protected $maxLenLogin;
    protected $maxLenPass;
    protected $minLenLogin;
    protected $minLenPass;

    function __construct($login,$pass,$mail)
    {
        $this->email_c = htmlspecialchars($mail);
        $this->login_c = htmlspecialchars($login);
        $this->pass_c = htmlspecialchars($pass);
        $this->maxLenLogin = 16;
        $this->maxLenPass = 32;
        $this->minLenLogin = 6;
        $this->minLenPass = 8;
    }

    public function registr()
    {
        if ($this->checkEmailBD() == false)
            return "E-mail already exists". PHP_EOL;
        else
        {
            if ($this->checkLoginBD() == false)
                return "Login already exists" . PHP_EOL;
            else
            {
                if ($this->checkLogin())
                {
                    if ($this->checkPassword())
                    {
                        if ($this->checkEmail())
                        {
                            if (($this->addAccountDB()) == true)
                                return true;
                            else
                                return false;
                        }
                        else
                            return "E-mail is incorrect". PHP_EOL;
                    }
                    else
                        return "Password is incorrect". PHP_EOL;
                }
                else
                    return "Login is incorrect". PHP_EOL;
            }
        }
    }

    public function addAccountDB()
    {
        $connect = new connectBD();
        $connect->connect();
        $passHash = hash(sha256, $this->pass_c);

        $add = $connect->DBH->prepare("INSERT INTO followers (login, pass, email) VALUES (?,?,?);");
        $add->execute(array($this->login_c,$passHash, $this->email_c));
        if ($add == true)
            return true;
        else
            return false;
    }

    public function checkLogin()
    {
        if (strlen($this->login_c) >= $this->minLenLogin && strlen($this->login_c) <= $this->maxLenLogin)
        {
            $incorrectSymbol = "!@\#№;$%^:&?\*()-_+=/|\`.,";
            $reg = "/^[a-zA-Z0-9]+$/";
            $bool = false;
            for ($i = 0; $i < strlen($this->login_c); $i++ )
            {
                for ($j = 0; $j < strlen($incorrectSymbol); $j++)
                    if ($this->login_c[$i] == $incorrectSymbol[$j])
                        $bool = true;
            }
            if ($bool != true) {
                if (preg_match($reg, $this->login_c))
                    return true;
                else
                    return false;
            }
        }
        else
                return false;
    }

    public function checkEmail()
    {
        if (filter_var($this->email_c, FILTER_VALIDATE_EMAIL))
            return true;
        else
            return false;
    }

    public function checkPassword()
    {

        if (strlen($this->pass_c) >= $this->minLenPass && strlen($this->pass_c) <= $this->maxLenPass)
        {
            $incorrectSymbol = "!@\#№;$%^:&?*()-_+=/|\`.,";
            $reg = "/[a-zA-Z0-9]/";
            $bool = false;
            for ($i = 0; $i < strlen($this->pass_c); $i++ )
            {
                for ($j = 0; $j < strlen($incorrectSymbol); $j++)
                    if ($this->pass_c[$i] == $incorrectSymbol[$j])
                        $bool = true;
            }
            if ($bool != true)
            {
                if (preg_match($reg, $this->pass_c))
                    return true;
                else
                    return false;
            }
        }
        else
            return false;
    }

    protected function checkLoginBD()
    {
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT *
                                                FROM news_db.admins, news_db.followers, news_db.moderators
                                                WHERE admins.login_a = ? or followers.login = ? or moderators.login_m = ? ;");
        $query->execute(array($this->login_c,$this->login_c,$this->login_c));
        if (($row_1 = $query->fetch()) == true)
            return false;
        $connect->closeConnect();
        return true;
    }
    protected function checkEmailBD()
    {

        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT * FROM followers WHERE email = ?");
        $query->execute(array($this->email_c));
        if (($row_1 = $query->fetch()) == true)
            return false;
        $connect->closeConnect();
        return true;
    }
}
?>