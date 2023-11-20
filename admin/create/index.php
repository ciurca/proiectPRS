<?php
include "../partials/conectare.php";
include "../partials/auth_check.php";
// We need to use sessions, so you should always start sessions using the below code.
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
    $IDOrganizator= $_SESSION['idOrganizator'];
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
            header('Location: /proiect/admin/');
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Inserare inregistrare</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<?php include '../partials/navbar.php';?>
<div class="container mt-5">
    <h1>Creare eveniment nou</h1>
    <?php if ($error != ''): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="form-group">
            <label for="titlu">Titlu:</label>
            <input type="text" class="form-control" id="titlu" name="titlu" value=""/>
        </div>
        <div class="form-group">
            <label for="descriere">Descriere:</label>
            <input type="text" class="form-control" id="descriere" name="descriere" value=""/>
        </div>
        <div class="form-group">
            <label for="data_inceput">Data Inceput:</label>
            <input type="date" class="form-control" id="data_inceput" name="data_inceput" value=""/>
        </div>
        <div class="form-group">
            <label for="data_sfarsit">Data Sfarsit:</label>
            <input type="date" class="form-control" id="data_sfarsit" name="data_sfarsit" value=""/>
        </div>
        <div class="form-group">
            <label for="agenda">Agenda:</label>
            <textarea class="form-control" id="agenda" name="agenda" rows="4"></textarea>
        </div>
        <div class="form-group">
            <label for="locatie">Locatie:</label>
            <input type="text" class="form-control" id="locatie" name="locatie" value=""/>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        <a class="btn btn-secondary" href="Vizualizare.php">Index</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
