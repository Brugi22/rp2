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
                MATCH (a:User {id: $followerId}), (b:User {id: $followeeId})
                CREATE (a)-[:FOLLOWS]->(b)';
            $db->sendCypherQuery($query, ['followerId' => $followerId, 'followeeId' => $followeeId]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function getFollowedUsers($userId)
    {
        try {
            $db = DBGraph::getConnection();
            $query = '
                MATCH (a:User {id: {userId}})-[:FOLLOWS]->(b:User)
                RETURN b.id AS id, b.username AS username';
            $parameters = ['userId' => $userId];
            $result = $db->sendCypherQuery($query, $parameters)->getResult();

            $followedUsers = [];
            foreach ($result->getNodes() as $node) {
                $followedUsers[] = [
                    'id' => $node->getProperty('id'),
                    'username' => $node->getProperty('username')
                ];
            }

            return $followedUsers;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }

    public function getUsers()
    {
        try {
            $db = DBGraph::getConnection();

            $query = '
                MATCH (u:User)
                WHERE u.id <> $userId AND NOT EXISTS {
                    MATCH (:User {id: $userId})-[:FOLLOWS]->(u)
                }
                RETURN u.id AS id, u.username AS username
            ';
            $parameters = ['userId' => $_SESSION['user_id']];
            $result = $db->sendCypherQuery($query, $parameters)->getResult();
            echo var_dump($result);

            $users = [];
            foreach ($result->getNodes() as $node) {
                $users[] = [
                    'id' => $node->getProperty('id'),
                    'username' => $node->getProperty('username')
                ];
            }

            return $users;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }
}
?>