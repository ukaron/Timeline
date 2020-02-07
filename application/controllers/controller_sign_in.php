<?php
class Controller_Sign_In extends Controller
{
    function action_index()
    {
        $this->model = new Model_Sign_In();
        if (isset($_POST['login']) && isset($_POST['pass'])) {
            $user = array(
                'login' => $_POST['login'],
                'pass' => hash(sha256, $_POST['pass'])
            );
            $data = $this->model->sign_in($user);
        }
        $this->view->generate('sign_in_view.php', 'template_view.php', $data);
    }

    function action_logout()
    {
        session_start();
        session_destroy();
        header('Location:/');
    }
}
