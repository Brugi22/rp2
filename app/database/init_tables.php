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

try {
    $korisnici = [
        [1,'dina_sabol08', 'dina.sabol28@gmail.com', 'Abcde12345..', 'Dina', 'Sabol'],
        [2,'lucfuc34', 'lucija.lesjak@gmail.com', 'AbrakaDabra', 'Lucija', 'Lesjak'],
        [3,'matkicslatkic', 'matkosimic33@gmail.com', 'AbPll,.65', 'Matko', 'Šimić'],
        [4,'brunobanani', 'silajb@gmail.com', 'erfTvc76.', 'Bruno', 'Silaj'],
        [5,'luka103', 'tomic.luka103@gmail.com', 'Diwq.,a34', 'Luka', 'Tomić'],
        [6,'llisjak', 'llisjak34@gmail.com', 'kuzG6FIU', 'Laura', 'Lisjak'],
        [7,'cvjetuljak', 'ines.blaskovic8@gmail.com', 'drfFPOE64', 'Ines', 'Blašković'],
        [8,'ella_pčela', 'ela.pcela342@gmail.com', 'sdgfrsd442.', 'Ela', 'Zrinski'],
        [9,'marac.komarac', 'marko23@gmail.com', 'POJre534', 'Marko', 'Siladi'],
        [10,'leomessi23', 'habijancek@gmail.com', 'A539zGRESOIH', 'Leon', 'Habijan'],
        [11,'andi.paler', 'andi.paler@gmail.com', 's45t!=sfse', 'Andreja', 'Paler'],
        [12,'matekova', 'kovacic_mateo@gmail.com', 'aegrdfn43W487', 'Mateo', 'Kovačić'],
        [13,'izakovaaa', 'izabela_lunilou@gmail.com', 'sf435.,jnf', 'Izabela', 'Kovačević'],
        [14,'sveti.petar', 'sikpero@gmail.com', 'sg54.,edgt', 'Pero', 'Sikirić'],
        [15,'lana18', 'lana188@gmail.com', 'Sfdte3546.', 'Lana', 'Biželj'],
        [16,'drogica_nogica', 'dinodvornik@gmail.com', 'dsgpgiser345', 'Dino', 'Dvornik'],
        [17,'liftuša', 'jelemarin.@gmail.com', 'Swef542e5..', 'Jelena', 'Marinović'],
        [18,'dorica505', 'dorapredojevic@gmail.com', 'Abcdesrga.', 'Dora', 'Predojević'],
        [19,'augusta_xvi', 'pamela_xvi@gmail.com', 'srt45shrtd', 'Pamela', 'Augustinović'],
        [20,'rent4style', 'rent4style@gmail.com', 'Abgsd4525tg', 'Matea', 'Miljan']
    ];

    $st = $db->prepare('INSERT INTO korisnik (id_korisnik, username, email, password, ime_korisnik, prezime_korisnik) VALUES (:id_korisnik, :username, :email, :password, :ime_korisnik, :prezime_korisnik)');
    foreach ($korisnici as $korisnik) {
        $st->execute(array(
            'id_korisnik' => $korisnik[0],
            'username' => $korisnik[1],
            'email' => $korisnik[2],
            'password' => password_hash($korisnik[3], PASSWORD_DEFAULT),
            'ime_korisnik' => $korisnik[4],
            'prezime_korisnik' => $korisnik[5]
        ));
    }

    echo "Ubacio podatke u tablicu korisnik.<br />";
} catch (PDOException $e) {
    exit("PDO error [insert korisnik]: " . $e->getMessage());
}

try {
    $blogovi = [
        [1,1,'Štikla kafa kravata','2018-03-15'],
        [2,8,'Smart Passive Income','2021-07-25'],
        [3,10,'Tim.blog','2022-01-11'],
        [4,6,'Fitt by Laura','2019-10-16'],
        [5,18,'Uvrnuti Šotovi','2023-01-11'],
        [6,4,'Socialmediaexaminer','2022-12-01'],
        [7,5,'vjetarugranama','2020-10-03'],
        [8,20,'Lifestyle','2017-07-17'],
        [9,7,'Putovanja','2015-05-15'],
        [10,1,'Gastro','2022-04-15']
    ];

    $st = $db->prepare('INSERT INTO blog (id_blog, id_korisnik, ime_blog, blog_timestamp) VALUES (:id_blog, :id_korisnik, :ime_blog, :blog_timestamp)');
    foreach ($blogovi as $blog) {
        $st->execute(array(
            'id_blog' => $blog[0],
            'id_korisnik' => $blog[1],
            'ime_blog' => $blog[2],
            'blog_timestamp' => $blog[3]
        ));
    }

    echo "Ubacio podatke u tablicu blog.<br />";
} catch (PDOException $e) {
    exit("PDO error [insert blog]: " . $e->getMessage());
}

try {
    $objave = [
        [1,1,1,'Danas sam ispijala kavu s prijateljicom.', '2018-03-15'],
        [2,1,1,'Naučila sam puno korisnih savjeta za pasivni prihod.', '2021-07-25'],
        [3,1,1,'Nova objava na Tim.blogu je vrhunska!', '2022-01-11'],
        [4,1,1,'Danas sam objavila novi trening program.', '2019-10-16'],
        [5,2,8,'Isprobajte ovaj recept za uvrnuti šot!', '2023-01-11'],
        [6,2,8,'Saznajte najnovije trendove u društvenim mrežama.', '2022-12-01'],
        [7,2,8,'Moja avantura na vjetru i granama je nezaboravna.', '2020-10-03'],
        [8,3,10,'Nova objava na mom blogu o životnom stilu!', '2017-07-17'],
        [9,3,10,'Ovo je bila najbolja avantura u mom životu!', '2015-05-15'],
        [10,4,6,'Najnoviji recepti za ukusne gastro delicije.', '2022-04-15']
    ];

    $st = $db->prepare('INSERT INTO objava (id_objava, id_blog, id_korisnik, sadrzaj_objava, objava_timestamp) VALUES (:id_objava, :id_blog, :id_korisnik, :sadrzaj_objava, :objava_timestamp)');
    foreach ($objave as $objava) {
        $st->execute(array(
            'id_objava' => $objava[0],
            'id_blog' => $objava[1],
            'id_korisnik' => $objava[2],
            'sadrzaj_objava' => $objava[3],
            'objava_timestamp' => $objava[4]
        ));
    }

    echo "Ubacio podatke u tablicu objava.<br />";
} catch (PDOException $e) {
    exit("PDO error [insert objava]: " . $e->getMessage());
}
try {
    $komentari = [
        [1,1,10,'Odlična objava, potpuno se slažem!','2018-03-16'],
        [2,1,17,'Hvala na dijeljenju ovih savjeta.','2021-07-26'],
        [3,1,5,'Svaka objava na Tim.blogu je inspirativna.','2022-01-12'],
        [4,1,9,'Super trening, jedva čekam isprobati!','2019-10-17'],
        [5,1,19,'Obožavam uvrnute šotove, definitivno ću probati recept!','2023-01-12'],
        [6,2,15,'Tvoji savjeti su mi uvijek korisni.','2022-12-02'],
        [7,2,3,'Prekrasna priča, hvala što si je podijelila s nama!','2020-10-04'],
        [8,2,1,'Tvoj blog o životnom stilu mi je omiljen!','2017-07-18'],
        [9,3,17,'Zvuči kao nevjerojatna avantura!','2015-05-16'],
        [10,3,13,'Ovaj recept moram isprobati već danas!','2022-04-16']
    ];

    $st = $db->prepare('INSERT INTO komentar (id_komentar, id_objava, id_korisnik, sadrzaj_komentar, komentar_timestamp) VALUES (:id_komentar, :id_objava, :id_korisnik, :sadrzaj_komentar, :komentar_timestamp)');
    foreach ($komentari as $komentar) {
        $st->execute(array(
            'id_komentar' => $komentar[0],
            'id_objava' => $komentar[1],
            'id_korisnik' => $komentar[2],
            'sadrzaj_komentar' => $komentar[3],
            'komentar_timestamp' => $komentar[4]
        ));
    }

    echo "Ubacio podatke u tablicu komentar.<br />";
} catch (PDOException $e) {
    exit("PDO error [insert komentar]: " . $e->getMessage());
}
