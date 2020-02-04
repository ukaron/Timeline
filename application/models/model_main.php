<?php
class Model_Main extends Model
{
    public $page;

    public function get_content()
    {
        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT * FROM news_db.news WHERE status=1 ORDER BY public_date DESC LIMIT 10;");
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
        $find = $connect->DBH->prepare("SELECT tag_name, tags.tag_id FROM news_db.link_news_tag
                                          INNER JOIN news_db.tags ON news_db.link_news_tag.tag_id = tags.tag_id
                                         INNER JOIN news_db.news n on news_db.link_news_tag.news_id = n.news_id
                                         WHERE n.news_id = ?");
        $find->execute(array($news_id));
        $tags[] = $find->fetchAll();
        return $tags[0];
    }

    public function handler($start_from)
    {
        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT news_id, subj, info, public_date FROM news_db.news ORDER BY public_date DESC LIMIT $start_from, 10 ");
        $find->execute();
        $row = $find->fetchAll();
        $content = $row;
        for ($i = 0, $j = 5; $i < count($content); $i++, $j++)
            $content[$i]['tag_name'] = $this->get_tags_by_news_id($content[$i]['news_id']);
        echo json_encode($content);
    }

    public function get_news_by_tag_id($tag_id, $page)
    {

        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT subj,info, public_date, n.news_id  FROM news_db.link_news_tag
                                        INNER JOIN news_db.tags ON news_db.link_news_tag.tag_id = tags.tag_id
                                        INNER JOIN news_db.news n on news_db.link_news_tag.news_id = n.news_id
                                        WHERE tags.tag_id = ? ORDER BY public_date DESC ;");
        $find->execute(array($tag_id));
        $count_page = $find->rowCount();
        $row = $find->fetchAll();
        $content = $row;
        for ($i = 0; $i < count($content) ; $i++)
            $content[$i]['tag_name'] = $this->get_tags_by_news_id($content[$i]['news_id']);
        $content['pages'] = $this->get_pagination($page, $count_page);
        $content['tag_id'] = $tag_id;
        return $content;
    }

    public function get_pagination($page, $count_news)
    {
        $news_in_page = 3; //кол-во новостей отображаемых на странице
        if (isset($page))
        {
            $count_page = ceil((int)$count_news/(int)$news_in_page);
            return (array('news_in_page'=> $news_in_page,
                'count_page' => $count_page,
            'count_news' => $count_news ));
        }
    }
}



