<?php

require_once 'db.class.php';

$db = DB::getConnection();

try {
    $korisnici = [
        [1, 'dina_sabol08', 'dina.sabol28@gmail.com', 'Abcde12345..', 'Dina', 'Sabol'],
        [2, 'lucfuc34', 'lucija.lesjak@gmail.com', 'AbrakaDabra', 'Lucija', 'Lesjak'],
        [3, 'matkicslatkic', 'matkosimic33@gmail.com', 'AbPll,.65', 'Matko', 'Šimić'],
        [4, 'brunobanani', 'silajb@gmail.com', 'erfTvc76.', 'Bruno', 'Silaj'],
        [5, 'luka103', 'tomic.luka103@gmail.com', 'Diwq.,a34', 'Luka', 'Tomić'],
        [6, 'llisjak', 'llisjak34@gmail.com', 'kuzG6FIU', 'Laura', 'Lisjak'],
        [7, 'cvjetuljak', 'ines.blaskovic8@gmail.com', 'drfFPOE64', 'Ines', 'Blašković'],
        [8, 'ella_pčela', 'ela.pcela342@gmail.com', 'sdgfrsd442.', 'Ela', 'Zrinski'],
        [9, 'marac.komarac', 'marko23@gmail.com', 'POJre534', 'Marko', 'Siladi'],
        [10, 'leomessi23', 'habijancek@gmail.com', 'A539zGRESOIH', 'Leon', 'Habijan'],
        [11, 'andi.paler', 'andi.paler@gmail.com', 's45t!=sfse', 'Andreja', 'Paler'],
        [12, 'matekova', 'kovacic_mateo@gmail.com', 'aegrdfn43W487', 'Mateo', 'Kovačić'],
        [13, 'izakovaaa', 'izabela_lunilou@gmail.com', 'sf435.,jnf', 'Izabela', 'Kovačević'],
        [14, 'sveti.petar', 'sikpero@gmail.com', 'sg54.,edgt', 'Pero', 'Sikirić'],
        [15, 'lana18', 'lana188@gmail.com', 'Sfdte3546.', 'Lana', 'Biželj'],
        [16, 'drogica_nogica', 'dinodvornik@gmail.com', 'dsgpgiser345', 'Dino', 'Dvornik'],
        [17, 'liftuša', 'jelemarin.@gmail.com', 'Swef542e5..', 'Jelena', 'Marinović'],
        [18, 'dorica505', 'dorapredojevic@gmail.com', 'Abcdesrga.', 'Dora', 'Predojević'],
        [19, 'augusta_xvi', 'pamela_xvi@gmail.com', 'srt45shrtd', 'Pamela', 'Augustinović'],
        [20, 'rent4style', 'rent4style@gmail.com', 'Abgsd4525tg', 'Matea', 'Miljan']
    ];

    $st = $db->prepare('INSERT INTO korisnik (id_korisnik, username, email, password, ime_korisnik, prezime_korisnik) VALUES (?, ?, ?, ?, ?, ?)');
    foreach ($korisnici as $korisnik) {
        $st->execute([
            $korisnik[0],
            $korisnik[1],
            $korisnik[2],
            password_hash($korisnik[3], PASSWORD_DEFAULT),
            $korisnik[4],
            $korisnik[5]
        ]);
    }

    echo "Ubacio podatke u tablicu korisnik.<br />";
} catch (PDOException $e) {
    exit("PDO error [insert korisnik]: " . $e->getMessage());
}

try {
    $blogovi = [
        [1, 1, 'Štikla kafa kravata', '2018-03-15'],
        [2, 8, 'Smart Passive Income', '2021-07-25'],
        [3, 10, 'Tim.blog', '2022-01-11'],
        [4, 6, 'Fitt by Laura', '2019-10-16'],
        [5, 18, 'Uvrnuti Šotovi', '2023-01-11'],
        [6, 4, 'Socialmediaexaminer', '2022-12-01'],
        [7, 5, 'vjetarugranama', '2020-10-03'],
        [8, 20, 'Lifestyle', '2017-07-17'],
        [9, 7, 'Putovanja', '2015-05-15'],
        [10, 1, 'Gastro', '2022-04-15']
    ];

    $st = $db->prepare('INSERT INTO blog (id_blog, id_korisnik, ime_blog, blog_timestamp) VALUES (?, ?, ?, ?)');
    foreach ($blogovi as $blog) {
        $st->execute([
            $blog[0],
            $blog[1],
            $blog[2],
            $blog[3]
        ]);
    }

    echo "Ubacio podatke u tablicu blog.<br />";
} catch (PDOException $e) {
    exit("PDO error [insert blog]: " . $e->getMessage());
}

try {
    $objave = [
        [1, 1, 1, 'Danas sam ispijala kavu s prijateljicom.', '2018-03-15'],
        [2, 1, 1, 'Naučila sam puno korisnih savjeta za pasivni prihod.', '2021-07-25'],
        [3, 1, 1, 'Nova objava na Tim.blogu je vrhunska!', '2022-01-11'],
        [4, 1, 1, 'Danas sam objavila novi trening program.', '2019-10-16'],
        [5, 2, 8, 'Isprobajte ovaj recept za uvrnuti šot!', '2023-01-11'],
        [6, 2, 8, 'Saznajte najnovije trendove u društvenim mrežama.', '2022-12-01'],
        [7, 2, 8, 'Moja avantura na vjetru i granama je nezaboravna.', '2020-10-03'],
        [8, 3, 10, 'Nova objava na mom blogu o životnom stilu!', '2017-07-17'],
        [9, 3, 10, 'Ovo je bila najbolja avantura u mom životu!', '2015-05-15'],
        [10, 4, 6, 'Najnoviji recepti za ukusne gastro delicije.', '2022-04-15']
    ];

    $st = $db->prepare('INSERT INTO objava (id_objava, id_blog, id_korisnik, sadrzaj_objava, objava_timestamp) VALUES (?, ?, ?, ?, ?)');
    foreach ($objave as $objava) {
        $st->execute([
            $objava[0],
            $objava[1],
            $objava[2],
            $objava[3],
            $objava[4]
        ]);
    }

    echo "Ubacio podatke u tablicu objava.<br />";
} catch (PDOException $e) {
    exit("PDO error [insert objava]: " . $e->getMessage());
}

try {
    $komentari = [
        [1, 1, 10, 'Odlična objava, potpuno se slažem!', '2018-03-16'],
        [2, 1, 17, 'Hvala na dijeljenju ovih savjeta.', '2021-07-26'],
        [3, 1, 5, 'Svaka objava na Tim.blogu je inspirativna.', '2022-01-12'],
        [4, 1, 9, 'Super trening, jedva čekam isprobati!', '2019-10-17'],
        [5, 1, 19, 'Obožavam uvrnute šotove, definitivno ću probati recept!', '2023-01-12'],
        [6, 2, 15, 'Tvoji savjeti su mi uvijek korisni.', '2022-12-02'],
        [7, 2, 3, 'Prekrasna priča, hvala što si je podijelila s nama!', '2020-10-04'],
        [8, 2, 1, 'Tvoj blog o životnom stilu mi je omiljen!', '2017-07-18'],
        [9, 3, 17, 'Zvuči kao nevjerojatna avantura!', '2015-05-16'],
        [10, 3, 13, 'Ovaj recept moram isprobati već danas!', '2022-04-16']
    ];

    $st = $db->prepare('INSERT INTO komentar (id_komentar, id_objava, id_korisnik, sadrzaj_komentar, komentar_timestamp) VALUES (?, ?, ?, ?, ?)');
    foreach ($komentari as $komentar) {
        $st->execute([
            $komentar[0],
            $komentar[1],
            $komentar[2],
            $komentar[3],
            $komentar[4]
        ]);
    }

    echo "Ubacio podatke u tablicu komentar.<br />";
} catch (PDOException $e) {
    exit("PDO error [insert komentar]: " . $e->getMessage());
}
