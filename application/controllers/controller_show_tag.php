<?php
class Controller_Show_tag extends Controller
{

    function __construct()
    {
        $this->model = new Model_Show_Tag();
        $this->view = new View();
    }

    function action_index()
    {
            $tag_id = $_GET['tag'];
            $data = $this->model->get_news_by_tag_id($tag_id);
            if (isset($data))
                $this->view->generate('show_tag_view.php', 'template_view.php', $data);
    }

}