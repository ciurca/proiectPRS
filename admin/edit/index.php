<?php // connectare bazadedate

include("../partials/conectare.php");
include("../partials/auth_check.php");
// Verificam daca evenimentul este cel al organizatorul pentru a evita modificarile altor useri.
$event_id = isset($_GET['id']) ? $_GET['id'] : null;
if ($event_id) {
    $query = "SELECT IDOrganizator FROM eveniment WHERE id = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Check if the events has an organizer and if the logged-in user is the organizer
        if ($row && $_SESSION['id'] != $row['IDOrganizator']) {
            header('Location: /proiect/admin/');
            exit; // Don't forget to exit after sending the header
        }
    } else {
        // Handle error - prepare failed
        error_log('Prepare failed: ' . $mysqli->error);
    }
} else {
    // Handle error - events ID not set
    header('Location: /proiect/admin/');
    exit;
}

//Modificare datelor
// se preia id din pagina vizualizare
$error='';
if (!empty($_POST['id']))
{ if (isset($_POST['submit']))
{ // verificam daca id-ul din URL este unul valid
    if (is_numeric($_POST['id']))
    { // preluam variabilele din URL/form
        $id = $_POST['id'];
        $titlu = htmlentities($_POST['titlu'], ENT_QUOTES);
        $descriere= htmlentities($_POST['descriere'], ENT_QUOTES);
        $data_inceput= htmlentities($_POST['data_inceput'], ENT_QUOTES);
        $data_sfarsit= htmlentities($_POST['data_sfarsit'], ENT_QUOTES);
        $agenda = htmlentities($_POST['agenda'], ENT_QUOTES);
        $locatie = htmlentities($_POST['locatie'], ENT_QUOTES);
        $IDOrganizator= $_SESSION["id"];
            if ($titlu == '' || $data_inceput == '' || $data_sfarsit == '' || $locatie == '' || $IDOrganizator == '')
            {
// daca sunt goale se afiseaza un mesaj
                $error = 'ERROR: Campuri goale!';
            } else {
                if ($stmt = $mysqli->prepare("UPDATE eveniment SET titlu=?, descriere=?, data_inceput=?, data_sfarsit=?, agenda=?, locatie=?, IDOrganizator=? WHERE id='".$id."'"))
                {
                    $stmt->bind_param("ssssssi", $titlu, $descriere,$data_inceput,$data_sfarsit,$agenda,$locatie,$IDOrganizator);
                    $stmt->execute();
                    $stmt->close();
                }
            else
            {echo "ERROR: nu se poate executa update.";}
        }
    }
// daca variabila 'id' nu este valida, afisam mesaj de eroare
    else
    {echo "id incorect!";} }}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php if ($_GET['id'] != '') { echo "Modificare inregistrare"; }?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
</head>
<body>
<?php include "../partials/navbar.php" ?>
<div class="container mt-5">
    <h1><?php if ($_GET['id'] != '') { echo "Modificare Inregistrare"; }?></h1>
    <?php if ($error != '') {
        echo "<div class='alert alert-danger'>" . $error . "</div>";
    } ?>
    <form action="" method="post">
        <?php if ($_GET['id'] != ''): ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
            <?php
            if ($result = $mysqli->query("SELECT * FROM eveniment WHERE id='".$_GET['id']."'")) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_object();
                    ?>
                    <div class="mb-3">
                        <label for="titlu" class="form-label">Titlu:</label>
                        <input type="text" class="form-control" id="titlu" name="titlu" value="<?php echo htmlspecialchars($row->titlu, ENT_QUOTES); ?>"/>
                    </div>
                    <div class="mb-3">
                        <label for="descriere" class="form-label">Descriere:</label>
                        <input type="text" class="form-control" id="descriere" name="descriere" value="<?php echo htmlspecialchars($row->descriere, ENT_QUOTES); ?>"/>
                    </div>
                    <div class="mb-3">
                        <label for="data_inceput" class="form-label">Data Inceput:</label>
                        <input type="date" class="form-control" id="data_inceput" name="data_inceput" value="<?php echo (new DateTime($row->data_inceput))->format('Y-m-d'); ?>"/>
                    </div>
                    <div class="mb-3">
                        <label for="data_sfarsit" class="form-label">Data Sfarsit:</label>
                        <input type="date" class="form-control" id="data_sfarsit" name="data_sfarsit" value="<?php echo (new DateTime($row->data_sfarsit))->format('Y-m-d'); ?>"/>
                    </div>
                    <div class="mb-3">
                        <label for="agenda" class="form-label">Agenda:</label>
                        <textarea class="form-control" id="agenda" name="agenda" rows="4"><?php echo htmlspecialchars($row->agenda, ENT_QUOTES); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="locatie" class="form-label">Locatie:</label>
                        <input type="text" class="form-control" id="locatie" name="locatie" value="<?php echo htmlspecialchars($row->locatie, ENT_QUOTES); ?>"/>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    <?php
                } else {
                    echo "<div class='alert alert-warning'>Record not found.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Database query error: " . $mysqli->error . "</div>";
            }
            ?>

        <?php endif; ?>

    </form>
</div>
</body>
</html>
