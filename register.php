<?php require_once('inc/header.php'); ?>
<?php require_once('inc/functions.php'); ?>


<?php

if (!empty($_POST)) {
    // Variables
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password_confirm'];
    // Tableau d'erreurs
    $errors = array();
    // Connection avec la bdd
    require_once('inc/db.php');
    // Vérification des champs saisi + message d'erreur
    if (empty($username) || !preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $errors['username'] = "Votre pseudo n'est pas valide (alphanumérique) !";
    } else {
        $req = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $req->execute([$username]);
        $user = $req->fetch();
        if ($user) {
            $errors['username'] = "Ce pseudo existe déjà !";
        }
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Votre mail n'est pas valide";
    } else {
        $req = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $req->execute([$email]);
        $user = $req->fetch();
        if ($user) {
            $errors['email'] = "Cet email existe déjà !";
        }
    }
    if (empty($password) || $password != $passwordConfirm) {
        $errors['password'] = "Votre mot de passe n'est pas valide";
    }
    if (empty($errors)) {
        $password = password_hash($password, PASSWORD_BCRYPT); //sécuriser le mot de passe
        $req = $pdo->prepare("INSERT INTO users SET username = ?, password = ?, email = ?"); //pre=éparation requête
        $req->execute([$username, $password, $email]);
        die('Votre compte a bien été crée');
    }
}
?>



<h1>S'inscrire </h1>

<?php if (empty($errors)) : ?>
<div class="alert alert-danger">
    <p>Vous n'avez pas rempli le formulaire correctement !</p>
    <ul>
        <?php foreach ($errors as $error) : ?>
        <li><?= $error; ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
<form action="#" method="POST">
    <div class="form-group">
        <label for="">Pseudo</label>
        <input type="text" name="username" id="username" class="form-control" />
    </div>
    <div class="form-group">
        <label for="">Email</label>
        <input type="email" name="email" id="email" class="form-control" />
    </div>
    <div class="form-group">
        <label for="">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control" />
    </div>
    <div class="form-group">
        <label for="">Confirmez votre mot de passe</label>
        <input type="password" name="password_confirm" id="password_confirm" class="form-control" />
    </div>
    <button type="submit" class="btn btn-primary">M'inscrire</button>
</form>


<?php require_once("inc/footer.php"); ?>