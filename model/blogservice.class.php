<?php

class BlogService {
    function insertBlog($blogName) {
        try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO blog (id_korisnik, ime_blog, blog_timestamp) VALUES (:id_korisnik, :ime_blog, :blog_timestamp)');
			$date = date('Y-m-d H:i:s');

			$st->execute(array(
				'id_korisnik' => $_SESSION['user_id'],
				'ime_blog' => $blogName,
				'blog_timestamp' => $date,
			));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
    }

    function getBlogsFromLoggedInUser() {
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM blog WHERE id_korisnik=:id');
            $st->execute(array( 'id' => $_SESSION['user_id'] ));
        }
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

        $arr = array();
		while( $row = $st->fetch() ) $arr[] = new Blog($row['id_blog'], $row['id_korisnik'], $row['ime_blog'], $row['blog_timestamp']);

        return $arr;
    }

    function getBlogAnnouncement($blogId) {
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM objava WHERE id_blog=:id');
            $st->execute(array( 'id' => $blogId ));
        }
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

        $arr = array();
		while( $row = $st->fetch() ) $arr[] = new Objava($row['id_objava'], $row['id_blog'], $row['id_korisnik'], $row['$sadrzaj_objava'], $row['objava_timestamp']);

        return $arr;
    }
}
?>