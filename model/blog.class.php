<?php

class Blog
{
    protected $id_blog, $id_korisnik, $ime_blog, $blog_timestamp;

    function __construct($id_blog, $id_korisnik, $ime_blog, $blog_timestamp)
    {
        $this->id_blog = $id_blog;
        $this->id_korisnik = $id_korisnik;
        $this->ime_blog = $ime_blog;
        $this->blog_timestamp = $blog_timestamp;
    }

    function __get($prop) { return $this->$prop; }
    function __set($prop, $val) { $this->$prop = $val; return $this; }
}

?>