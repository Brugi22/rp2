<?php

class Korisnik
{
    protected $id_korisnik, $username, $email, $password, $ime_korisnik, $prezime_korisnik;

    function __construct($id_korisnik, $username, $email, $password, $ime_korisnik, $prezime_korisnik)
    {
        $this->id_korisnik = $id_korisnik;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->ime_korisnik = $ime_korisnik;
        $this->prezime_korisnik = $prezime_korisnik;
    }

    function __get($prop) { return $this->$prop; }
    function __set($prop, $val) { $this->$prop = $val; return $this; }
}

?>
