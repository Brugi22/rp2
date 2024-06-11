<?php 

class BlogController extends BaseController
{
	public function index() 
	{
        $bs = new BlogService();
        $this->registry->template->blogs = $bs -> getBlogsFromLoggedInUser();
        $this->registry->template->show( 'new_blog' );
	}

    public function create_new_blog()
    {
        $bs = new BlogService();
        $bs -> insertBlog($_POST['blogName']);
        $this->registry->template->blogs = $bs -> getBlogsFromLoggedInUser();
        $this->registry->template->show( 'new_blog' );
    }

    public function blog_announcuments()
    {
        $bs = new BlogService();
        $this->registry->template->announcements = $bs -> getBlogAnnouncement($_GET['id_blog']);
        $this->registry->template->comments = $bs -> getBlogComments();
        $this->registry->template->blog_id = $_GET['id_blog'];
        $this->registry->template->show( 'announcements' );
    }

    public function create_new_announcement()
    {
        $bs = new BlogService();
        $bs -> insertBlogAnnouncement($_POST['new_announcement'], $_GET['id_blog']);
        $this->registry->template->announcements = $bs -> getBlogAnnouncement($_GET['id_blog']);
        $this->registry->template->comments = $bs -> getBlogComments();
        $this->registry->template->blog_id = $_GET['id_blog'];
        $this->registry->template->show( 'announcements' );
    }

    public function add_comment()
    {
        $bs = new BlogService();
        $bs -> insertComment($_POST['new_comment'], $_GET['id_objava']);
        $this->registry->template->announcements = $bs -> getBlogAnnouncement($_GET['id_blog']);
        $this->registry->template->comments = $bs -> getBlogComments();
        $this->registry->template->show( 'announcements' );
    }

    public function users()
    {
        $bs = new BlogService();
        $this->registry->template->users = $bs -> getUsers();
        $this->registry->template->show( 'users' );
    }

    public function follow_user()
    {
        $bs = new BlogService();
        $bs -> createFollowsRelationship($_SESSION['user_id'], $_GET['user_id']);
        $this->registry->template->users = $bs -> getUsers();
        $this->registry->template->show( 'users' );
    }

}; 

?>