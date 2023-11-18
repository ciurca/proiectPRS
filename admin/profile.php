<?php // connectare bazadedate
include("conectare.php");
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: http://localhost/proiect/admin');
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
    {echo "id incorect!";} }}?>
<html> <head><title> <?php if ($_GET['id'] != '') { echo "Modificare Profil Organizator"; }?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8"/></head>
<body>
<h1><?php if ($_GET['id'] != '') { echo "Modificare Profil Organizator"; }?></h1>
<?php if ($error != '') {
    echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error."</div>";} ?>
<form action="" method="post">
    <div>
        <?php if ($_GET['id'] != '') { ?>
        <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
        <p>ID: <?php echo $_GET['id'];
            if ($result = $mysqli->query("SELECT nume, email, telefon FROM organizator where id='".$_GET['id']."'"))
            {
            if ($result->num_rows > 0)
            { $row = $result->fetch_object();?></p>
        <strong>Nume: </strong> <input type="text" name="nume" value="<?php echo$row->nume;
        ?>"/><br/>
        <strong>Email: </strong> <input type="email" name="email" value="<?php echo$row->email;
        ?>"/><br/>
        <strong>Telefon: </strong> <input type="text" name="phone" value="<?php echo$row->telefon;}}}
        ?>"/><br/>
        <br/>
        <input type="submit" name="submit" value="Submit" />
        <a href="home.php">Acasa</a>
    </div></form>
</body> </html>