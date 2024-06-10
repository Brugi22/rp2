<?php

require_once 'db.class.php';

$db = DB::getConnection();

$has_tables = false;

try {
    $st = $db->prepare('SELECT 1 FROM information_schema.tables WHERE table_name = :tblname');
    
    $st->execute(array('tblname' => 'korisnik'));
    if ($st->rowCount() > 0) $has_tables = true;

    $st->execute(array('tblname' => 'blog'));
    if ($st->rowCount() > 0) $has_tables = true;

    $st->execute(array('tblname' => 'objava'));
    if ($st->rowCount() > 0) $has_tables = true;

    $st->execute(array('tblname' => 'komentar'));
    if ($st->rowCount() > 0) $has_tables = true;

} catch (PDOException $e) {
    exit("PDO error [check tables]: " . $e->getMessage());
}

if ($has_tables) {
    exit('Tablice korisnik / blog / objava / komentar već postoje. Obrišite ih pa probajte ponovno.');
}

try {
    $st = $db->prepare(
        'CREATE TABLE IF NOT EXISTS korisnik (
            id_korisnik SERIAL NOT NULL PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(30) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            ime_korisnik VARCHAR(50) NOT NULL,
            prezime_korisnik VARCHAR(50) NOT NULL
        )'
    );
    $st->execute();

    $st = $db->prepare('CREATE INDEX korisnik_indx ON korisnik (username) INCLUDE (ime_korisnik, prezime_korisnik)');
    $st->execute();

    echo "Napravio tablicu korisnik.<br />";
} catch (PDOException $e) {
    exit("PDO error [create korisnik]: " . $e->getMessage());
}

try {
    $st = $db->prepare(
        'CREATE TABLE IF NOT EXISTS blog (
            id_blog SERIAL NOT NULL PRIMARY KEY,
            id_korisnik SERIAL NOT NULL,
            ime_blog VARCHAR(200) NOT NULL,
            blog_timestamp TIMESTAMP NOT NULL,
            CONSTRAINT fk_blog FOREIGN KEY (id_korisnik) REFERENCES korisnik(id_korisnik) ON DELETE CASCADE
        )'
    );
    $st->execute();

    $st = $db->prepare('CREATE INDEX blog_indx ON blog (id_korisnik)');
    $st->execute();

    echo "Napravio tablicu blog.<br />";
} catch (PDOException $e) {
    exit("PDO error [create blog]: " . $e->getMessage());
}

try {
    $st = $db->prepare(
        'CREATE TABLE IF NOT EXISTS objava (
            id_objava SERIAL NOT NULL PRIMARY KEY,
            id_blog SERIAL NOT NULL,
            id_korisnik SERIAL NOT NULL,
            sadrzaj_objava VARCHAR(10000) NOT NULL,
            objava_timestamp TIMESTAMP NOT NULL,
            CONSTRAINT fk_objava_blog FOREIGN KEY (id_blog) REFERENCES blog(id_blog) ON DELETE CASCADE,
            CONSTRAINT fk_objava_korisnik FOREIGN KEY (id_korisnik) REFERENCES korisnik(id_korisnik) ON DELETE CASCADE
        )'
    );
    $st->execute();

    $st = $db->prepare('CREATE INDEX objava_indx ON objava (id_blog, id_korisnik)');
    $st->execute();

    echo "Napravio tablicu objava.<br />";
} catch (PDOException $e) {
    exit("PDO error [create objava]: " . $e->getMessage());
}

try {
    $st = $db->prepare(
        'CREATE TABLE IF NOT EXISTS komentar (
            id_komentar SERIAL NOT NULL PRIMARY KEY,
            id_objava SERIAL NOT NULL,
            id_korisnik SERIAL NOT NULL,
            sadrzaj_komentar VARCHAR(10000) NOT NULL,
            komentar_timestamp TIMESTAMP NOT NULL,
            CONSTRAINT fk_komentar_objava FOREIGN KEY (id_objava) REFERENCES objava(id_objava) ON DELETE CASCADE,
            CONSTRAINT fk_komentar_korisnik FOREIGN KEY (id_korisnik) REFERENCES korisnik(id_korisnik) ON DELETE CASCADE
        )'
    );
    $st->execute();

    $st = $db->prepare('CREATE INDEX komentar_indx ON komentar (id_korisnik)');
    $st->execute();

    echo "Napravio tablicu komentar.<br />";
} catch (PDOException $e) {
    exit("PDO error [create komentar]: " . $e->getMessage());
}