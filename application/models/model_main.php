<?php
class Model_Main extends Model
{
    public $page;

    public function get_content()
    {
        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT * FROM news ORDER BY public_date DESC LIMIT 10;");
        $find->execute();
        $row = $find->fetchAll();
        $content = $row;
        for ($i = 0; $i < count($content); $i++)
            $content[$i]['tag_name'] = $this->get_tags_by_news_id($content[$i]['news_id']);
        return $content;
    }

    public function get_tags_by_news_id($news_id)
    {
        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT tag_name, tags.tag_id FROM link_news_tag
                                          INNER JOIN tags ON link_news_tag.tag_id = tags.tag_id
                                         INNER JOIN news n on link_news_tag.news_id = n.news_id
                                         WHERE n.news_id = ?");
        $find->execute(array($news_id));
        $tags[] = $find->fetchAll();
        return $tags[0];
    }

    public function handler($start_from)
    {
        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT news_id, subj, info, public_date FROM news ORDER BY public_date DESC LIMIT $start_from, 10 ");
        $find->execute();
        $row = $find->fetchAll();
        $content = $row;
        for ($i = 0, $j = 5; $i < count($content); $i++, $j++)
            $content[$i]['tag_name'] = $this->get_tags_by_news_id($content[$i]['news_id']);
        echo json_encode($content);
    }

    public function get_news_by_tag_id($tag_id, $page)
    {
        $this->page = $page;
        $num = 3;
        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT subj,info, public_date, n.news_id  FROM link_news_tag
                                      INNER JOIN tags ON link_news_tag.tag_id = tags.tag_id
                                      INNER JOIN news n on link_news_tag.news_id = n.news_id
WHERE tags.tag_id = ? ORDER BY public_date DESC ;");
        $find->execute(array($tag_id));
        $row = $find->fetchAll();
        $content = $row;
        for ($i = 0; $i < count($content); $i++)
            $content[$i]['tag_name'] = $this->get_tags_by_news_id($content[$i]['news_id']);
        $total = intval(($connect - 1) / $num) + 1;
        $this->page = intval($page);
        if (empty($this->page) or $this->page < 0)
            $this->page = 1;
        if ($this->page > $total)
            $this->page = $total;
        $start = $this->page * $num - $num;
        $find = $connect->DBH->prepare("SELECT subj,info, public_date, n.news_id  FROM link_news_tag
                                      INNER JOIN tags ON link_news_tag.tag_id = tags.tag_id
                                      INNER JOIN news n on link_news_tag.news_id = n.news_id
                                        WHERE tags.tag_id = ? ORDER BY public_date DESC LIMIT $start, $num;");
        $find->execute(array($tag_id));
        $row = $find->fetchAll();
        $content[] = $row;
        return $content;
    }

}



