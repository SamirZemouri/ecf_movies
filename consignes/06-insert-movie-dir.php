<?php

require_once('../connect.php');

$req_insert_movies_directors = "INSERT INTO directors_has_infos_movies (`directors_id`, `infos_movies_id`) VALUES (:id_dir, :id_movies)";

$req_select_id_movie = "SELECT id FROM infos_movies WHERE title = :title";
$req_select_id_dir = "SELECT id FROM directors WHERE director_name = :dir_name";

$req_get_id_movie = $db->prepare($req_select_id_movie);
$req_get_id_dir = $db->prepare($req_select_id_dir);
$req_movie_dir = $db->prepare($req_insert_movies_directors);

$file = fopen('./film.csv','r');
if ($file !==FALSE) {
    while(($row = fgetcsv($file, null, ";", "'", "\n"))!== FALSE){

        $req_get_id_movie->bindValue(':title', $row[0], PDO::PARAM_STR);
        $req_get_id_movie->execute();
        $id_movie = $req_get_id_movie->fetch(PDO::FETCH_ASSOC);

        // Correction de l'offset ciblé et ajout de la boucle for pour séparer les réalisateurs qui sont sur le même film.
        $one_dir = explode (",", $row[3]);
        for ($i=0; $i < count($one_dir) ; $i++) { 
            $req_get_id_dir->bindValue(':dir_name', $one_dir[$i], PDO::PARAM_STR);
            $req_get_id_dir->execute();
            $id_dir = $req_get_id_dir->fetch(PDO::FETCH_ASSOC);

            $req_movie_dir->bindValue('id_dir', $id_dir["id"], PDO::PARAM_INT);
            $req_movie_dir->bindValue('id_movies', $id_movie["id"], PDO::PARAM_INT);
            $req_movie_dir->execute();
        }
    }
}
