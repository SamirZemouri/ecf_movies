<?php
// Réaliser une requête qui permet de récupérer tous les titres des films

require_once('../../connect.php');

$req_title =$db->prepare('SELECT title FROM infos_movies');
$req_title->execute();

$all_title = $req_title->fetchAll(PDO::FETCH_ASSOC);
?>
