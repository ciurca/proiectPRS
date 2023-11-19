<?php
include '../partials/auth_check.php';
include '../partials/conectare.php';

$error = '';

if (!empty($_POST['id'])) {
    if (isset($_POST['submit'])) {
        if (is_numeric($_POST['id'])) {
            $id = $_POST['id'];
            $NUMAR = htmlentities($_POST['NUMAR'], ENT_QUOTES);
            $data_semnarii = htmlentities($_POST['data_semnarii'], ENT_QUOTES);
            $tip = htmlentities($_POST['tip'], ENT_QUOTES);
            $IDColaborator = htmlentities($_POST['IDColaborator'], ENT_QUOTES);
            $IDEveniment= htmlentities($_POST['IDEveniment'], ENT_QUOTES);


            if ($NUMAR == '' || $data_semnarii == '' || $tip == '' ) {
                $error = "ERROR: Completati campurile obligatorii!";
            } else {
                if ($stmt = $mysqli->prepare("UPDATE contract SET NUMAR=?, data_semnarii=?, tip=?, IDColaborator=?, IDEveniment=?  WHERE id='".$id."'")) {
                    $stmt->bind_param("sssii", $NUMAR, $data_semnarii, $tip, $IDColaborator, $IDEveniment);
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
            if ($result = $mysqli->query("SELECT NUMAR, data_semnarii, tip FROM contract where id='".$_GET['id']."'")) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_object(); ?>
                    </p>
                    <strong>Numar: </strong> <input type="text" name="NUMAR" value="<?php echo $row->NUMAR; ?>" /><br/>
                    <strong>Data semnarii: </strong> <input type="date" name="data_semnarii" value="<?php echo $row->data_semnarii; ?>" /><br/>
                    <strong>Tip: </strong> <input type="text" name="tip" value="<?php echo $row->tip; ?>" /><br/>
                    <?php
                    $dropdown_stmt = $mysqli->prepare("SELECT id, nume FROM colaborator ORDER BY id");
                    $dropdown_stmt->execute();
                    $dropdown_result = $dropdown_stmt->get_result();

                    echo "<div class='form-group'>";
                    echo "<label for='IDColaborator'>Colaborator</label>";
                    echo "<select class='form-control' name='IDColaborator'>";
                    if ($row->IDColaborator) {
                        $current_event_stmt = $mysqli->prepare("SELECT nume FROM colaborator WHERE id = ?");
                        $current_event_stmt->bind_param("i", $row->IDColaborator);
                        $current_event_stmt->execute();
                        $current_event_result = $current_event_stmt->get_result();
                        if ($current_event_result->num_rows > 0) {
                            $current_event_row = $current_event_result->fetch_assoc();
                            echo "<option value='" . htmlspecialchars($row->IDColaborator) . "' selected>" . htmlspecialchars($current_event_row['nume']) . "</option>";
                        }
                    }

                    echo "<option value=''>Alege Colaboratorul</option>";
                    while ($dropdown_row = $dropdown_result->fetch_object()) {
                        echo "<option value='" . htmlspecialchars($dropdown_row->id) . "'>" . htmlspecialchars($dropdown_row->nume) . "</option>";
                    }
                    echo "</select></div>";

                    $dropdown_stmt->close();
                    if (isset($current_event_stmt)) {
                        $current_event_stmt->close();
                    }
                    ?>
                    <?php
                    $dropdown_stmt = $mysqli->prepare("SELECT id, titlu FROM eveniment WHERE IDOrganizator = ? ORDER BY id");
                    $dropdown_stmt->bind_param("i", $_SESSION['id']);
                    $dropdown_stmt->execute();
                    $dropdown_result = $dropdown_stmt->get_result();

                    echo "<div class='form-group'>";
                    echo "<label for='IDEveniment'>Eveniment</label>";
                    echo "<select class='form-control' name='IDEveniment'>";
                    if ($row->IDEveniment) {
                        $current_event_stmt = $mysqli->prepare("SELECT titlu FROM eveniment WHERE id = ?");
                        $current_event_stmt->bind_param("i", $row->IDEveniment);
                        $current_event_stmt->execute();
                        $current_event_result = $current_event_stmt->get_result();
                        if ($current_event_result->num_rows > 0) {
                            $current_event_row = $current_event_result->fetch_assoc();
                            echo "<option value='" . htmlspecialchars($row->IDEveniment) . "' selected>" . htmlspecialchars($current_event_row['titlu']) . "</option>";
                        }
                    }

                    echo "<option value=''>Alege Evenimentul</option>";
                    while ($dropdown_row = $dropdown_result->fetch_object()) {
                        echo "<option value='" . htmlspecialchars($dropdown_row->id) . "'>" . htmlspecialchars($dropdown_row->titlu) . "</option>";
                    }
                    echo "</select></div>";

                    $dropdown_stmt->close();
                    if (isset($current_event_stmt)) {
                        $current_event_stmt->close();
                    }
                    ?>
                <?php }}} ?>
        <br />
        <input type="submit" name="submit" value="Submit" class="btn btn-primary" />
        <a href="index.php/proiect/admin/contract" class="btn btn-secondary">Index</a>
    </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

