<?php 

class LogInController extends BaseController
{
	public function index() 
	{
		$this->registry->template->show( 'login' );
	}

	public function validate() 
	{
		$lis = new LogInService();
        if(isset($_POST['username']) && isset($_POST['password']) && $lis->validate($_POST['username'], $_POST['password'])) {
            header( 'Location: ' . __SITE_URL . '/blogs.php?rt=blog' );
			exit();
        }else {
            header( 'Location: ' . __SITE_URL . '/blogs.php?rt=login' );
			exit();
        }
	}

	public function register() 
	{
		$this->registry->template->show( 'register' );
	}

	public function register_validate() {
        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['last_name'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];

            $lis = new LogInService();
            if ($lis->validate_register($username, $password, $email, $first_name, $last_name)) {
                header( 'Location: ' . __SITE_URL . '/blogs.php?rt=blog' );
				exit();
            } else {
                header( 'Location: ' . __SITE_URL . '/blogs.php?rt=login/register' );
				exit();
            }
        } else {
            header( 'Location: ' . __SITE_URL . '/blogs.php?rt=login/register' );
			exit();
        }
    }
}; 

?>