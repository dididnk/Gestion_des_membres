<?php

require_once('inc/functions.php');
if (!empty($_POST)) {
    // Variables
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password_confirm'];
    $lenght = 60;
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
        $req = $pdo->prepare("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?"); //pre=éparation requête
        $password = password_hash($password, PASSWORD_BCRYPT); //sécuriser le mot de passe
        $token = str_random($lenght);
        $req->execute([$username, $password, $email, $token]);
        $userId = $pdo->lastInsertId();
        mail($email, "Confirmation de votre compte", "Pour valider votre compter, merci de cliquer sur ce lien\n\nhttp://localhost/projet/PHP/Site_Livre/confirm.php?id=$userId&token=$token");
        header('Location: login.php');
        exit();
    }
}
?>


<?php require_once('inc/header.php'); ?>
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