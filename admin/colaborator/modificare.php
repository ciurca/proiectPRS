<?php
include '../partials/auth_check.php';
include("../partials/conectare.php");

$error = '';

if (!empty($_POST['idOrganizator'])) {
    if (isset($_POST['submit'])) {
        if (is_numeric($_POST['idOrganizator'])) {
            $id = $_POST['idOrganizator'];
            $nume = htmlentities($_POST['nume'], ENT_QUOTES);
            $email = htmlentities($_POST['email'], ENT_QUOTES);
            $telefon = htmlentities($_POST['telefon'], ENT_QUOTES);
            $tip = htmlentities($_POST['tip'], ENT_QUOTES);
            $suma = htmlentities($_POST['suma'], ENT_QUOTES);
            $premii = htmlentities($_POST['premii'], ENT_QUOTES);
            $tip_parteneriat = htmlentities($_POST['tip_parteneriat'], ENT_QUOTES);

            if ($nume == '' || $email == '' || $telefon == '' || $tip == '' || $suma == '' || $premii == '' || $tip_parteneriat == '') {
                $error = "ERROR: Completati campurile obligatorii!";
            } else {
                if ($stmt = $mysqli->prepare("UPDATE colaborator SET nume=?, email=?, telefon=?, tip=?, suma=?, premii=?, tip_parteneriat=? WHERE id='".$id."'")) {
                    $stmt->bind_param("sssssss", $nume, $email, $telefon, $tip, $suma, $premii, $tip_parteneriat);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    $error = "ERROR: nu se poate executa update.";
                }
            }
        } else {
            $error = "id incorect!";
        }
    }
}
?>

<html>
<head>
    <title><?php if ($_GET['id'] != '') { echo "Modificare inregistrare"; } ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<h1><?php if ($_GET['id'] != '') { echo "Modificare inregistrare"; } ?></h1>
<?php if ($error != '') {
    echo "<div style='padding: 4px; border: 1px solid red; color: red'>" . $error . "</div>";
} ?>
<form action="" method="post">
    <div>
        <?php if ($_GET['id'] != '') { ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
            <p>id: <?php echo $_GET['id'];
            if ($result = $mysqli->query("SELECT nume ,email ,telefon, tip, suma, premii, tip_parteneriat FROM colaborator where id='".$_GET['id']."'")) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_object(); ?>
                    </p>
                    <strong>Nume: </strong> <input type="text" name="nume" value="<?php echo $row->nume; ?>" /><br/>
                    <strong>Email: </strong> <input type="text" name="email" value="<?php echo $row->email; ?>" /><br/>
                    <strong>Telefon: </strong> <input type="text" name="telefon" value="<?php echo $row->telefon; ?>" /><br/>
                    <strong>Tip: </strong> <input type="text" name="tip" value="<?php echo $row->tip; ?>" /><br/>
                    <strong>Suma: </strong> <input type="text" name="suma" value="<?php echo $row->suma; ?>" /><br/>
                    <strong>Premii: </strong> <input type="text" name="premii" value="<?php echo $row->premii; ?>" /><br/>
                    <strong>Tip de parteneriat: </strong> <input type="text" name="tip_parteneriat" value="<?php echo $row->tip_parteneriat; ?>" /><br/>
                <?php }}} ?>
        <br />
        <input type="submit" name="submit" value="Submit" class="btn btn-primary" />
        <a href="/proiect/admin/colaborator" class="btn btn-secondary">Index</a>
    </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>