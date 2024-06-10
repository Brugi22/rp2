<?php

class Objava
{
    protected $id_objava, $id_blog, $id_korisnik, $sadrzaj_objava, $objava_timestamp;

    function __construct($id_objava, $id_blog, $id_korisnik, $sadrzaj_objava, $objava_timestamp)
    {
        $this->id_objava = $id_objava;
        $this->id_blog = $id_blog;
        $this->id_korisnik = $id_korisnik;
        $this->sadrzaj_objava = $sadrzaj_objava;
        $this->objava_timestamp = $objava_timestamp;
    }

    function __get($prop) { return $this->$prop; }
    function __set($prop, $val) { $this->$prop = $val; return $this; }
}

?>
