<?php
//On recupère le id et le token de l'utilisateur
$userId = $_GET['id'];
$token = $_GET['token'];
//connection bdd
require_once('inc/db.php');
//Requête vers la bdd pour récuperer le token
$req = $pdo->prepare("SELECT confirmation_token FROM users WHERE id = ?");
$req->execute([$userId]);

$userId = $req->fetch();

if ($user && $user->confirmation_token == $token) {
    session_start();
    //requête pour mettre à jour le token de l'utilisateur à chaque connexion
    $req = $pdo->prepare("UPDATE username SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?");
    $req->execute([$iserId]);
    $_SESSION['auth'] = $user;
    header('Location: account.php');
} else {
    die('pas Ok');
}
