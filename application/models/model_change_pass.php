<?php
class Model_Change_pass
{
    private $maxLenPass = 16;
    private $minLenPass = 8;
    private $pass;

    public function change_pass($new_pass)
    {
        $this->pass = $new_pass;
        if (($this->checkPassword()) == true)
            {
                $login = $_SESSION['user'];
                $connect = new connectBD();
                $connect->connect();
                $passHash = hash(sha256, $this->pass);
                $add = $connect->DBH->prepare("UPDATE followers SET pass = ?  WHERE login = ?;");
                $add->execute(array($passHash, $login));
                if ($add == true)
                    return "Password has been change". PHP_EOL;
                else
                    return "Error". PHP_EOL;
            }
        else
            return "Password is incorrect". PHP_EOL;
    }

    public function checkPassword()
    {

        if (strlen($this->pass) >= $this->minLenPass && strlen($this->pass) <= $this->maxLenPass)
        {
            $incorrectSymbol = "!@\#№;$%^:&?*()-_+=/|\`.,";
            $reg = "/[a-zA-Z0-9]/";
            $bool = false;
            for ($i = 0; $i < strlen($this->pass); $i++ )
            {
                for ($j = 0; $j < strlen($incorrectSymbol); $j++)
                    if ($this->pass[$i] == $incorrectSymbol[$j])
                        $bool = true;
            }
            if ($bool != true)
            {
                if (preg_match($reg, $this->pass))
                    return true;
                else
                    return false;
            }
        }
        else
            return false;
    }
}