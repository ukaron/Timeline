<?php
require_once ('./application/models/model_new_admin.php');
class Model_Moder extends Model
{
    public $login;
    private $pass;
    private $maxLenPass = 16;
    private $minLenPass = 8;


    public function check_moder()
    {
        $this->login = $_SESSION['user'];
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT * FROM moderators WHERE login_m = ? AND conf_m = ?");
        $query->execute(array($this->login, true));
        if (($row_1 = $query->fetch()) == true)
            return true;
        $query = $connect->DBH->prepare("SELECT * FROM admins WHERE login_a = ? AND conf_a = ?");
        $query->execute(array($this->login, true));
        if (($row_1 = $query->fetch()) == true)
            return true;
        return false;
    }

    public function change_pass($new_pass)
    {
        $this->pass = $new_pass;
        if (($this->checkPassword()) == true)
        {
            $login = $_SESSION['user'];
            $connect = new connectBD();
            $connect->connect();
            $passHash = hash(sha256, $this->pass);
            $conf = $connect->DBH->prepare("UPDATE moderators SET conf_m = ? WHERE login_m = ?");
            $conf->execute(array('1', $this->login));
            $add = $connect->DBH->prepare("UPDATE moderators SET pass_m = ? WHERE login_m = ?");
            $add->execute(array($passHash, $login));
            if ($add == true)
                return true;
            else
                return false;
        }
        else
            return false;
    }

    public function checkPassword()
    {

        if (strlen($this->pass) >= $this->minLenPass && strlen($this->pass) <= $this->maxLenPass)
        {
            $incorrectSymbol = "!@\"#№;$%^:&?\*()-_+=/|\`.,";
            $reg = "/^[a-zA-Z0-9]+$/";
            $bool = false;
            for ($i = 0; $i < strlen($this->pass); $i++ )
            {
                for ($j = 0; $j < strlen($incorrectSymbol); $j++)
                    if ($this->pass[$i] == $incorrectSymbol[$j])
                        $bool = true;
            }
            if ($bool == false)
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

    public function new_tag($tag_name)
    {
        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT * FROM tags WHERE tag_name = ? ;");
        $find->execute(array($tag_name));
        if (($row_1 = $find->fetch()) != true)
        {
            $add = $connect->DBH->prepare("INSERT INTO tags (tag_name) VALUES ('$tag_name');");
            $add->execute();
            if ($add == true)
                return "New tag has been created";
        }
        return "Such a tag already exists";
    }

    public function new_news($news_name, $news_info)
    {
        $this->login = $_SESSION['user'];
        $connect = new connectBD();
        $connect->connect();
        $add = $connect->DBH->prepare("INSERT INTO news (subj, author_login, public_date, info ) VALUES ('$news_name', '$this->login', NOW(),'$news_info');");
        $add->execute();
        if ($add == true)
        {
            $find = $connect->DBH->prepare("SELECT * FROM news WHERE author_login = ? ORDER BY public_date DESC;");
            $find->execute(array($this->login));
            $row = $find->fetchAll();
            return $row[0];
        }
        return "Error";
    }

    public function edit_news($news_id)
    {
        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT * FROM news WHERE news_id = ? ;");
        $find->execute(array($news_id));
        $row = $find->fetchAll();
        $row[0]['tags'] = $this->get_tags_name_by_news_id($row[0]['news_id']);
        return $row[0];
    }


    public function get_tags_name_by_news_id($news_id)
    {
        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT tag_id FROM link_news_tag WHERE news_id = ? ;");
        $find->execute(array($news_id));
        $tags = $find->fetchAll();
        foreach ($tags as $tag_id)
        {
        $content[] = $this->get_tag_name_by_tag_id($tag_id);
        }
        return $content;
    }
    public function get_tag_name_by_tag_id($tag_id)
    {
        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT tag_name FROM tags WHERE tag_id = ? ;");
        $find->execute(array($tag_id[0]));
        $tags_name = $find->fetch();
        return $tags_name;
    }
    public function get_tag_id_by_tag_name($tag_name)
    {
        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT tag_id FROM tags WHERE tag_name = ? ;");
        $find->execute(array($tag_name[0]));
        $tags_id = $find->fetch();
        return $tags_id;
    }

    public function handler($start_from)
    {
        $this->login = $_SESSION['user'];
        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT * FROM news WHERE author_login = ? ORDER BY public_date DESC LIMIT $start_from, 10 ; ");
        $find->execute(array($this->login));
        $row = $find->fetchAll();
        $content[] = $row;
        echo json_encode($content[0]);
    }
    public function get_my_news()
    {
        $this->login = $_SESSION['user'];
        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT * FROM news WHERE author_login = ? ORDER BY public_date DESC LIMIT 10;");
        $find->execute(array($this->login));
        $row = $find->fetchAll();
        $content[] = $row;
        return $content;
    }

    public function add_tag_for_news($news_id, $tag_name)
    {
        $tag_id = $this->get_tag_id_by_tag_name($tag_name);
        if (!isset($tag_id))
        {
            $this->new_tag($tag_name);
            $tag_id = $this->get_tag_id_by_tag_name($tag_name);
            $connect = new connectBD();
            $connect->connect();
            $add = $connect->DBH->prepare("INSERT INTO link_news_tag (news_id, tag_id)
                                            VALUES ('$news_id','$tag_id');");
            $add->execute();
            $add->fetchAll();
            if ($add == true)
            {
                return $tag_name;
            }
            return false;
        }
        return "ERROR";
    }
}