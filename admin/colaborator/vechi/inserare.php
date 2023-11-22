<?php
include("../partials/conectare.php");
include("../partials/auth_check.php");
$error='';
if (isset($_POST['submit']))
{
    $nume = htmlentities($_POST['nume'], ENT_QUOTES);
    $email = htmlentities($_POST['email'], ENT_QUOTES);
    $telefon = htmlentities($_POST['telefon'], ENT_QUOTES);
    $tip = htmlentities($_POST['tip'], ENT_QUOTES);
    $suma = htmlentities($_POST['suma'] , ENT_QUOTES);
    $premii = htmlentities($_POST['premii'] , ENT_QUOTES);
    $tip_parteneriat = htmlentities($_POST['tip_parteneriat'], ENT_QUOTES);


    if ($nume == '' || $email == '' || $telefon == '' || $tip == '' || $suma == '' || $premii == '' || $tip_parteneriat == '')
    {
        echo "<div> ERROR: Completati campurile obligatorii!</div>";
    }else
    {
        if ($stmt = $mysqli->prepare("INSERT into colaborator (nume, email, telefon, tip, suma, premii, tip_parteneriat) VALUES (?, ?, ?, ?, ?, ?, ?)"))
        {
            $stmt->bind_param("sssssss", $nume, $email,$telefon,$tip, $suma, $premii, $tip_parteneriat);
            $stmt->execute();
            $stmt->close();
        }
        else
        {echo "ERROR: nu se poate executa update.";}
    }
}
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
        <strong>Nume: </strong> <input type="text" name="nume" value="" required/><br/>
        <strong>Email: </strong> <input type="text" name="email" value="" /><br/>
        <strong>Telefon: </strong> <input type="text" name="telefon" value="" /><br/>
        <strong>Tip: </strong> <input type="text" name="tip" value="" /><br/>
        <strong>Suma: </strong> <input type="text" name="suma" value="" /><br/>
        <strong>Premii: </strong> <input type="text" name="premii" value="" /><br/>
        <strong>Tip de parteneriat: </strong> <input type="text" name="tip_parteneriat" value="" /><br/>
        <br/>
        <input type="submit" name="submit" value="Submit" />
        <a href="/proiect/admin/colaborator">Index</a>
    </div>
</form>
</body>
</html>
