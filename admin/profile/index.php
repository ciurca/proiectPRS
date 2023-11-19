<?php // connectare bazadedate
include("../partials/conectare.php");
include("../partials/auth_check.php");
include("../partials/navbar.php");
if ($_GET['id'] != $_SESSION['id']) {
    header('Location: /proiect/admin/');
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
        $nume = htmlentities($_POST['nume'], ENT_QUOTES);
        $email = htmlentities($_POST['email'], ENT_QUOTES);
        $phone = htmlentities($_POST['phone'], ENT_QUOTES);
// verificam daca numele, prenumele, an si grupa nu sunt goale
        if ($nume == '' || $email == '' || $phone == '')
        { // daca sunt goale afisam mesaj de eroare
            echo "<div> ERROR: Completati campurile obligatorii!</div>";
        }else
        { // daca nu sunt erori se face update name, code, image, price, descriere, categorie
            if ($stmt = $mysqli->prepare("UPDATE organizator SET 
nume=?,email=?,telefon=? WHERE id='".$id."'"))
            {
                $stmt->bind_param("sss", $nume,
                    $email, $phone);
                $stmt->execute();
                $stmt->close();
            }// mesaj de eroare in caz ca nu se poate face update
            else
            {echo "ERROR: nu se poate executa update.";}
        }
    }
// daca variabila 'id' nu este valida, afisam mesaj de eroare
    else
    {echo "id incorect!";} }}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php if ($_GET['id'] != '') { echo "Modificare Profil Organizator"; } ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
<div class="container mt-5">
    <h1><?php if ($_GET['id'] != '') { echo "Modificare Profil Organizator"; }?></h1>
    <?php if ($error != '') {
        echo "<div class='alert alert-danger'>" . $error . "</div>";
    } ?>

    <form action="" method="post">
        <?php if ($_GET['id'] != '') { ?>
        <?php
        if ($result = $mysqli->query("SELECT nume, email, telefon FROM organizator where id='".$_GET['id']."'"))
        {
        if ($result->num_rows > 0)
        { $row = $result->fetch_object();?>
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
            <div class="form-group">
                <label for="nume">Nume:</label>
                <input type="text" class="form-control" name="nume" value="<?php echo $row->nume; ?>"/>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" value="<?php echo $row->email; ?>"/>
            </div>
            <div class="form-group">
                <label for="phone">Telefon:</label>
                <input type="text" class="form-control" name="phone" value="<?php echo $row->telefon; ?>"/>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <a href="../index.php" class="btn btn-secondary">Acasa</a>
        <?php }}} ?>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
