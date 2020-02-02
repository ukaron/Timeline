<?php
class Controller_Change_Pass extends Controller
{
    public $pass;

    function action_index()
    {
        $this->model = new Model_Change_pass();
        if (isset($_POST['pass']))
        {
            $new_pass = $_POST['pass'];
            $data = $this->model->change_pass($new_pass);
        }
        $this->view->generate('change_pass_view.php', 'template_view.php', $data);
    }

}