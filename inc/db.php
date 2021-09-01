<?php
// Connection à la base de données
$pdo = new PDO('mysql:dbname=Bdd_members;host=localhost', 'root', '');
//Gérer les eventuelles erreurs
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
