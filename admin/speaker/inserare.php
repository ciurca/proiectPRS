<?php
include("../partials/conectare.php");
include('../partials/auth_check.php');
include('../partials/navbar.php');
$error='';
if (isset($_POST['submit']))
{
        $nume = htmlentities($_POST['nume'], ENT_QUOTES);
        $prenume = htmlentities($_POST['prenume'], ENT_QUOTES);
        $email = htmlentities($_POST['email'], ENT_QUOTES);
        $telefon = htmlentities($_POST['telefon'], ENT_QUOTES);
        $IDEveniment = htmlentities($_POST['IDEveniment'], ENT_QUOTES);

        if ($nume == '' || $prenume == ''||$email==''||$telefon=='')
        {
            echo "<div> ERROR: Completati campurile obligatorii!</div>";
        }else
        {
            if ($stmt = $mysqli->prepare("INSERT into speaker (nume, prenume, email, telefon, IDEveniment) VALUES (?, ?, ?, ?, ?)"))
            {
                $stmt->bind_param("ssssi", $nume, $prenume,$email,$telefon, $IDEveniment);
                $stmt->execute();
                $stmt->close();
            }
            else
            {echo "ERROR: nu se poate executa update.";}
        }
    }
    ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head> <title><?php echo "Inserare inregistrare"; ?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head> <body>
<div class="container mt-5">

<h1><?php echo "Inserare inregistrare"; ?></h1>
<?php if ($error != '') {
    echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error."</div>";} ?>
<form action="" method="post">
    <div>
        <div class="form-group">
            <label for="nume">Nume:</label>
            <input type="text" class="form-control" name="nume" id="nume" value="" />
        </div>
        <div class="form-group">
            <label for="prenume">Prenume:</label>
            <input type="text" class="form-control" name="prenume" id="prenume" value="" />
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" id="email" value="" />
        </div>

        <div class="form-group">
            <label for="telefon">Telefon:</label>
            <input type="text" class="form-control" name="telefon" id="telefon" value="" />
        </div>
        <?php
        $dropdown_stmt = $mysqli->prepare("SELECT id, titlu FROM eveniment WHERE IDOrganizator = ? ORDER BY id");
        $dropdown_stmt->bind_param("i", $_SESSION['idOrganizator']);
        $dropdown_stmt->execute();
        $dropdown_result = $dropdown_stmt->get_result();
        echo "<div class='form-group'>";
        echo "<label for='IDEveniment'>Eveniment</label>";
        echo "<select class='form-control' name='IDEveniment'>";
        echo "<option value=''>Alege Eveniment</option>";
        while ($dropdown_row = $dropdown_result->fetch_object()) {
            echo "<option value='" . htmlspecialchars($dropdown_row->id) . "'>" . htmlspecialchars($dropdown_row->titlu) . "</option>";
        }
        echo "</select></div>";

        // Clean up
        $dropdown_stmt->close();
        if (isset($current_event_stmt)) {
            $current_event_stmt->close();
        }
        $mysqli->close();
        ?>
        <br/>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        <a href="index.php" class="btn btn-secondary">Acasa Speakers</a>
    </div>
</form>
</div>
</body>
</html>