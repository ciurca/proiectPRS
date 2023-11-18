<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register</title>
</head>
<body>
<?php include "../partials/navbar.php" ?>
<div class="login container mt-5">
    <h1>Inregistrare Organizator</h1>
    <form action="registration.php" method="post" class="mt-4">
        <div class="mb-3">
            <input type="text" class="form-control" name="nume" placeholder="Nume Organizator" id="nume" required>
        </div>
        <div class="mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email" id="email" required>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" name="phone" placeholder="Telefon" id="phone" required>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>

</div>
</body>
</html>