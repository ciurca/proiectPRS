<?php
include "../conectare.php";
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: http://localhost/proiect/admin');
    exit;
}
$error='';
if (isset($_POST['submit']))
{


// preluam datele de pe formular
    $titlu = htmlentities($_POST['titlu'], ENT_QUOTES);
    $descriere= htmlentities($_POST['descriere'], ENT_QUOTES);
    $data_inceput = DateTime::createFromFormat('Y-m-d', $_POST['data_inceput'])->format('Y-m-d');
    $data_sfarsit = DateTime::createFromFormat('Y-m-d', $_POST['data_sfarsit'])->format('Y-m-d');
    $agenda = htmlentities($_POST['agenda'], ENT_QUOTES);
    $locatie = htmlentities($_POST['locatie'], ENT_QUOTES);
    $IDOrganizator= $_SESSION["id"];
// verificam daca sunt completate
    if ($titlu == '' || $data_inceput == '' || $data_sfarsit == '' || $locatie == '' || $IDOrganizator == '')
    {
// daca sunt goale se afiseaza un mesaj
        $error = 'ERROR: Campuri goale!';
    } else {
// insert
        if ($stmt = $mysqli->prepare("INSERT into eveniment (titlu, descriere, data_inceput, data_sfarsit, agenda, locatie, IDOrganizator) VALUES (?, ?, ?, ?, ?, ?, ?)"))
        {
            $stmt->bind_param("ssssssi", $titlu, $descriere,$data_inceput,$data_sfarsit,$agenda,$locatie,$IDOrganizator);
            $stmt->execute();
            $stmt->close();
        }
// eroare le inserare
        else
        {
            echo "ERROR: Nu se poate executa insert.";
        }
    }
}
// se inchide conexiune mysqli
$mysqli->close();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head> <title><?php echo "Inserare inregistrare"; ?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head> <body>
<h1><?php echo "Inserare inregistrare"; ?></h1>
<?php if ($error != '') {
    echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error."</div>";} ?>
<form action="" method="post">
    <div>
        <strong>Titlu: </strong> <input type="text" name="titlu" value=""/><br/>
        <strong>Descriere: </strong> <input type="text" name="descriere" value=""/><br/>
        <strong>Data Inceput: </strong> <input type="date" name="data_inceput" value=""/><br/>
        <strong>Data Sfarsit: </strong> <input type="date" name="data_sfarsit" value=""/><br/>
        <strong><label for="agenda">Agenda:</label></strong><br>
        <textarea id="agenda" name="agenda" rows="4" cols="50"></textarea>
        <br>
        <strong>Locatie: </strong> <input type="text" name="locatie" value=""/><br/>
        <br/>
        <input type="submit" name="submit" value="Submit" />
        <a href="Vizualizare.php">Index</a>
    </div></form></body></html>
