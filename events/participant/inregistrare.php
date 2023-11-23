<?php include "../partials/navbar.php" ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register</title>
</head>
<body>
<div class="login container mt-5">
    <h1>Inregistrare Participant</h1>
    <form action="registration.php" method="post" class="mt-4" autocomplete="off">
        <div class="mb-3">
            <input type="text" class="form-control" name="username" placeholder="Username Participant" id="username" required>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" name="nume" placeholder="Nume Participant" id="nume" required>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" name="prenume" placeholder="Prenume Participant" id="prenume" required>
        </div>
        <div class="mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email" id="email" required>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" id="password" required>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" name="telefon" placeholder="Telefon" id="telefon" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>

</div>
</body>
</html>