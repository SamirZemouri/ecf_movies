<?php

require_once('../connect.php');

$req_insert_years = "INSERT INTO release_years (release_year) SELECT * FROM (SELECT :release_year AS release_year) AS temp WHERE NOT EXISTS ( SELECT release_year FROM release_years WHERE release_year = :release_year )";

$req_year = $db->prepare($req_insert_years);

$file = fopen('./film.csv','r');
if ($file !==FALSE) {
    while(($row = fgetcsv($file, null, ";", "'", "\n"))!== FALSE){
        $req_year->bindValue(':release_year', $row[1], PDO::PARAM_INT);
        $req_year->execute();
    }
}