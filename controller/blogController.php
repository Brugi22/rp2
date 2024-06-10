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
        $this->registry->template->show( 'announcements' );
    }
}; 

?>