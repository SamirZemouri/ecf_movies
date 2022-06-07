<?php

require_once('../connect.php');

$req_insert_movies = "INSERT INTO infos_movies (`title`, `release_years_id`) SELECT * FROM (SELECT :title AS `title`, :release AS release_years_id) AS temp WHERE NOT EXISTS ( SELECT `title` FROM infos_movies WHERE `title` = :title )";

$req_select_id_year = "SELECT id FROM `release_years` WHERE release_year = :year_movie";

$req_movies = $db->prepare($req_insert_movies);
$req_get_id_year = $db->prepare($req_select_id_year);

$file = fopen('./film.csv','r');
if ($file !==FALSE) {
    while(($row = fgetcsv($file, null, ";", "'", "\n"))!== FALSE){

        $req_get_id_year->bindValue(':year_movie', $row[1], PDO::PARAM_INT);
        $req_get_id_year->execute();
        $id_year = $req_get_id_year->fetch(PDO::FETCH_ASSOC);

        $req_movies->bindValue(':title', $row[0], PDO::PARAM_STR);
        // Il faut mettre ":release" à la place de ":year_movie" et rajouter "['id']" derrière "$id_year".
        $req_movies->bindValue(':release', $id_year['id'], PDO::PARAM_INT);
        $req_movies->execute();
    }
}
