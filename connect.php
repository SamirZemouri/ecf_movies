<?php 

$host = 'localhost';
$dbname = 'movies-ecf';
$username = 'phpmyadmin';
$password ='Kazuya529892';


try 
{
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) 
{
    echo "Erreur :" . $e->getMessage();
}

















// catch (PDOException $e) 
// {
//  print "Erreur :" . $e->getMessage() . "<br/>";
//  die;
// }


?>