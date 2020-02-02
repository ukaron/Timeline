<?php
class Controller_Sign_Up extends Controller
{
    function __construct()
    {
        $this->view = new View();
    }

    function action_index()
    {
            $this->view->generate('sign_up_view.php', 'template_view.php');
    }

    function action_registr()
    {
        if (isset($_POST))
        {
            if (!strcmp($_POST['pass'], $_POST['pass_1']))
            {
                $login = $_POST['login'];
                $pass = $_POST['pass'];
                $email = $_POST['email'];
                $this->model = new Model_Sign_Up($login, $pass, $email);
                $data = $this->model->registr();
                if (is_bool($data) && $data == true)
                    $this->view->generate('sign_up_ok_view.php', 'template_view.php');
            }
            else
                $data = "Passwords do not match";
        }
        $this->view->generate('sign_up_view.php', 'template_view.php', $data);
    }

}