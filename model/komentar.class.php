<?php

class Komentar
{
    protected $id_komentar, $id_objava, $id_korisnik, $sadrzaj_komentar, $komentar_timestamp;

    function __construct($id_komentar, $id_objava, $id_korisnik, $sadrzaj_komentar, $komentar_timestamp)
    {
        $this->id_komentar = $id_komentar;
        $this->id_objava = $id_objava;
        $this->id_korisnik = $id_korisnik;
        $this->sadrzaj_komentar = $sadrzaj_komentar;
        $this->komentar_timestamp = $komentar_timestamp;
    }

    function __get($prop) { return $this->$prop; }
    function __set($prop, $val) { $this->$prop = $val; return $this; }
}

?>
