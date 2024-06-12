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

    function getBlogsFromUser($userId) {
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM blog WHERE id_korisnik=:id');
            $st->execute(array( 'id' => $userId ));
        }
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

        $arr = array();
		while( $row = $st->fetch() ) $arr[] = new Blog($row['id_blog'], $row['id_korisnik'], $row['ime_blog'], $row['blog_timestamp']);

        return $arr;
    }

    function hideForm($blogId) {
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id_korisnik FROM blog WHERE id_blog=:id');
            $st->execute(array( 'id' => $blogId ));
        }
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

        $row = $st->fetch();

        if($row['id_korisnik'] == $_SESSION['user_id']) return false;
        else return true;
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
		while( $row = $st->fetch() ) $arr[] = new Objava($row['id_objava'], $row['id_blog'], $row['id_korisnik'], $row['sadrzaj_objava'], $row['objava_timestamp']);

        return $arr;
    }

    function insertBlogAnnouncement($announcement, $blogId) {
        try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO objava (id_blog, id_korisnik, sadrzaj_objava, objava_timestamp) VALUES (:id_blog, :id_korisnik, :sadrzaj_objava, :objava_timestamp)');
			$date = date('Y-m-d H:i:s');

			$st->execute(array(
                'id_blog' => $blogId,
				'id_korisnik' => $_SESSION['user_id'],
				'sadrzaj_objava' => $announcement,
				'objava_timestamp' => $date,
			));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
    }

    function getBlogComments() {
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM komentar');
            $st->execute();
        }
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

        $arr = array();
		while( $row = $st->fetch() ) $arr[] = new Komentar($row['id_komentar'], $row['id_objava'], $row['id_korisnik'], $row['sadrzaj_komentar'], $row['komentar_timestamp']);

        return $arr;
    }

    function insertComment($comment, $announcementId) {
        try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO komentar (id_objava, id_korisnik, sadrzaj_komentar, komentar_timestamp) VALUES (:id_objava, :id_korisnik, :sadrzaj_komentar, :komentar_timestamp)');
			$date = date('Y-m-d H:i:s');

			$st->execute(array(
                'id_objava' => $announcementId,
				'id_korisnik' => $_SESSION['user_id'],
				'sadrzaj_komentar' => $comment,
				'komentar_timestamp' => $date,
			));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
    }

    public function createUser($id, $username)
    {
        try {
            $db = DBGraph::getConnection();
            $query = 'CREATE (u:User {id: $id, username: $username})';
            $db->sendCypherQuery($query, ['id' => $id, 'username' => $username]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage() . "\n";
        }
    }

    public function createFollowsRelationship($followerId, $followeeId)
    {
        try {
            $db = DBGraph::getConnection();
            $query = '
                MATCH (a:User {id: "' . $followerId . '"}), (b:User {id: "' . $followeeId . '"})
                CREATE (a)-[:FOLLOWS]->(b)';
            $db->sendCypherQuery($query);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function getFollowedUsers($userId)
    {
        try {
            $db = DBGraph::getConnection();
            $query = '
                MATCH (a:User {id: "' . $userId . '"})-[:FOLLOWS]->(b:User)
                RETURN b.id AS id, b.username AS username';
            $result = $db->sendCypherQuery($query)->getResult();

            $users = [];
            $tableFormat = $result->getTableFormat();

            foreach ($tableFormat as $row) {
                $user = [];
                if (isset($row['id']) && isset($row['username'])) {
                    $user['id'] = (string)$row['id'];
                    $user['username'] = (string)$row['username'];
                    $users[] = $user;
                }
            }

            return $users;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }

    public function getUsers()
    {
        try {
            $db = DBGraph::getConnection();

            $userId = $_SESSION['user_id']; 
            $query = '
                MATCH (u:User)
                WHERE u.id <> "' . $userId . '" AND NOT EXISTS {
                    MATCH (:User {id: "' . $userId . '"})-[:FOLLOWS]->(u)
                }
                RETURN u.id AS id, u.username AS username
            ';
            
            $result = $db->sendCypherQuery($query)->getResult();

            $users = [];
            $tableFormat = $result->getTableFormat();

            foreach ($tableFormat as $row) {
                $user = [];
                if (isset($row['id']) && isset($row['username'])) {
                    $user['id'] = (string)$row['id'];
                    $user['username'] = (string)$row['username'];
                    $users[] = $user;
                }
            }

            return $users;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }
}
?>