<?php
include("conectare.php");
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pagina proiect parolata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body class="loggedin">
<nav class="navtop">
    <div>
        <h1>Eventify</h1>
        <a href="profile.php?id=<?=$_SESSION['id']?>"> <i class="fas fa-user circle"></i>Profile</a><br>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
</nav>
<div class="content">
    <p>Bine ati revenit, <?=$_SESSION['name']?>!</p>
    <h2>Evenimentele tale</h2>
    <?php
    if ($result = $mysqli->query("SELECT * FROM eveniment WHERE IDOrganizator =" . $_SESSION['id'] . " ORDER BY ID"))
    { // Afisare inregistrari pe ecran
    if ($result->num_rows > 0) {
        // afisarea inregistrarilor intr-o table
        echo "<table border='1' cellpadding='10'>";
        // antetul tabelului
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Titlu</th><th>Descriere</th><th>Data Inceput</th><th>Data Sfarsit</th><th>Agenda</th><th>Locatie</th><th></th><th></th></tr>";
        while ($row = $result->fetch_object()) {
            // definirea unei linii pt fiecare inregistrare
            echo "<tr>";
            echo "<td>" . $row->ID . "</td>";
            echo "<td>" . $row->titlu . "</td>";
            echo "<td>" . $row->descriere . "</td>";
            echo "<td>" . $row->data_inceput . "</td>";
            echo "<td>" . $row->data_sfarsit . "</td>";
            echo "<td>" . $row->agenda . "</td>";
            echo "<td>" . $row->locatie . "</td>";
            echo "<td><a href='Modificare.php?id=" . $row->ID . "'>Modificare</a></td>";
            echo "<td><a href='Stergere.php?id=" . $row->ID . "'>Stergere</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

        // daca nu sunt inregistrari se afiseaza un rezultat de eroare
    else
    {
    echo "Nu sunt inregistrari in tabela!";
    }
    }
    // eroare in caz de insucces in interogare
    else
    { echo "Error: " . $mysqli->error; }
    // se inchide
    $mysqli->close();
    ?>
    <a href="Inserare.php">Adaugarea unei noi inregistrari</a>
    <br>
    <a href="/proiect/admin/create"><i class="fas fa-calendar"></i>Creeaza un nou eveniment</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
</div>
</body>
</html>
