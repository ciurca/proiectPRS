<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>
<body>
<?php include "../partials/navbar.php" ?>
<div class="login container mt-5">
    <h1>Login</h1>
    <form action="autentificare.php" method="post">
        <div class="form-group mb-3">
            <input type="text" name="username" placeholder="Username Participant"
                   id="username" required class="form-control">
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="Parola"
                   id="password" required class="form-control">
        </div>
        <input class="btn btn-primary" type="submit" value="Login">
    </form>
    <div><a href="/proiect/events/participant/inregistrare.php">Utilizator nou</a></div>
</div>
</body>
</html>