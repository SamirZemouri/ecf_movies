<?php

require_once('../connect.php');

$req_insert_categories = "INSERT INTO categories (`category`) SELECT * FROM (SELECT :category AS `category`) AS temp WHERE NOT EXISTS ( SELECT `category` FROM categories WHERE `category` = :category )";

$req_cat = $db->prepare($req_insert_categories);

$file = fopen('./film.csv','r');
if ($file !==FALSE) {
    while(($row = fgetcsv($file, null, ";", "'", "\n"))!== FALSE){
        // L'erreur est dans la sélection de la colonne dans le CSV, les catégories se trouvent dans le "row[2]" et non dans le "row[3].
        $one_cat = explode (",", $row[2]);
        for ($i=0; $i < count($one_cat) ; $i++) { 
            // L'erreur était dans le bindValue, il faut "bind" :category et non :categories.
            $req_cat->bindValue(':category', $one_cat[$i], PDO::PARAM_STR);
            print count($one_cat);
            $req_cat->execute();
        }
    }
}