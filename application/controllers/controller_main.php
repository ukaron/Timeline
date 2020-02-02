<?php
class Controller_Main extends Controller
{

    function __construct()
    {
        $this->model = new Model_Main();
        $this->view = new View();
    }

    function action_index()
    {
        $data = $this->model->get_content();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }


    function action_logout()
    {
        session_start();
        session_destroy();
        header('Location:/');
    }

    function action_handler()
    {
        $start_from = $_POST['start_from'];
        $this->model->handler($start_from);
    }

    function action_show_tag()
    {
        if (isset($_GET['tag']))
        {
            $tag_id = $_GET['tag'];
            $page = $_GET['page'];
            $data = $this->model->get_news_by_tag_id($tag_id, $page);
            if (isset($data))
                $this->view->generate('show_tag_view.php', 'template_view.php', $data);
        }
    }
}
