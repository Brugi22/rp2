<?php

class LogInService {
    function validate($username, $password) {
        try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_korisnik, password FROM korisnik WHERE username=:username');
			$st->execute( array( 'username' => $username ) );
            $row = $st->fetch();
            if($row && password_verify($password, $row['password'])){
                $_SESSION['username'] = $username;
			    $_SESSION['user_id'] = $row['id_korisnik'];
                return true;
            }
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

        return false;
    }

    function validate_register($username, $password, $email, $first_name, $last_name) {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        try {
            $db = DB::getConnection();

            $st = $db->prepare('SELECT * FROM korisnik WHERE username=:username OR email=:email');
            $st->execute(array('username' => $username, 'email' => $email));
            if ($st->rowCount() > 0) {
                return false;
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $st = $db->prepare('INSERT INTO korisnik (username, email, password, ime_korisnik, prezime_korisnik) VALUES (:username, :email, :password, :first_name, :last_name)');
            $st->execute(array(
                'username' => $username,
                'email' => $email,
                'password' => $hashed_password,
                'first_name' => $first_name,
                'last_name' => $last_name
            ));

            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $db->lastInsertId();

            return true;
        } catch (PDOException $e) {
            exit('PDO error ' . $e->getMessage());
        }

    }
}