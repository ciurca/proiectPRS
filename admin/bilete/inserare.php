<?php
include("../partials/conectare.php");
include('../partials/auth_check.php');
include('../partials/navbar.php');
$error='';
if (isset($_POST['submit']))
{
        $tip = htmlentities($_POST['tip'], ENT_QUOTES);
        $pret = htmlentities($_POST['pret'], ENT_QUOTES);
        $IDEveniment = htmlentities($_POST['IDEveniment'], ENT_QUOTES);

    if ($tip == '' || $pret == ''||$IDEveniment=='')
        {
            echo "<div> ERROR: Completati campurile obligatorii!</div>";
        }else
        {
            if ($stmt = $mysqli->prepare("INSERT into bilet (tip, pret, IDEveniment) VALUES (?, ?, ?)"))
            {
                $stmt->bind_param("sii", $tip, $pret,$IDEveniment);
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
            <label for="tip">Tip:</label>
            <input type="text" class="form-control" name="tip" id="tip" value="" />
        </div>
        <div class="form-group">
            <label for="pret">Pret:</label>
            <input type="text" class="form-control" name="pret" id="pret" value="" />
        </div>
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

        $dropdown_stmt->close();
        if (isset($current_event_stmt)) {
            $current_event_stmt->close();
        }
        $mysqli->close();
        ?>
        <br/>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        <a href="index.php" class="btn btn-secondary">Acasa Bilete</a>
    </div>
</form>
</div>
</body>
</html>