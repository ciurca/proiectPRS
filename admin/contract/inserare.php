<?php
include '../partials/auth_check.php';
include '../partials/conectare.php';
$error='';
if (isset($_POST['submit']))
{
    $NUMAR = htmlentities($_POST['NUMAR'], ENT_QUOTES);
    $data_semnarii = htmlentities($_POST['data_semnarii'], ENT_QUOTES);
    $tip = htmlentities($_POST['tip'], ENT_QUOTES);
    $IDColaborator = htmlentities($_POST['IDColaborator'], ENT_QUOTES);
    $IDEveniment= htmlentities($_POST['IDEveniment'], ENT_QUOTES);

    if ($NUMAR == '' || $data_semnarii == ''||$tip=='')
    {
        echo "<div> ERROR: Completati campurile obligatorii!</div>";
    }else
    {
        if ($stmt = $mysqli->prepare("INSERT into contract (NUMAR, data_semnarii, tip, IDColaborator, IDEveniment) VALUES (?, ?, ?, ?, ?)"))
        {
            $stmt->bind_param("sssii", $NUMAR, $data_semnarii, $tip, $IDColaborator, $IDEveniment);
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
<h1><?php echo "Inserare inregistrare"; ?></h1>
<?php if ($error != '') {
    echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error."</div>";} ?>
<form action="" method="post">
    <div>
        <strong>Numar: </strong> <input type="text" name="NUMAR" value=""/><br/>
        <strong>Data semnarii: </strong> <input type="date" name="data_semnarii" value=""/><br/>
        <strong>Tip: </strong> <input type="text" name="tip" value=""/><br/>
        <?php
        $dropdown_stmt = $mysqli->prepare("SELECT id, nume FROM colaborator ORDER BY id");
        $dropdown_stmt->execute();
        $dropdown_result = $dropdown_stmt->get_result();
        echo "<div class='form-group'>";
        echo "<label for='IDColaborator'>Colaborator</label>";
        echo "<select class='form-control' name='IDColaborator'>";
        echo "<option value=''>Alege Colaborator</option>";
        while ($dropdown_row = $dropdown_result->fetch_object()) {
            echo "<option value='" . htmlspecialchars($dropdown_row->id) . "'>" . htmlspecialchars($dropdown_row->nume) . "</option>";
        }
        echo "</select></div>";

        // Clean up
        $dropdown_stmt->close();
        if (isset($current_event_stmt)) {
            $current_event_stmt->close();
        }
        ?>
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
        <input type="submit" name="submit" value="Submit" />
        <a href="/proiect/admin/contract">Index</a>
    </div>
</form>
</body>
</html>
