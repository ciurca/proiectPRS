<?php
include("../partials/conectare.php");
include('../partials/auth_check.php');
include('../partials/navbar.php');

$error = '';

    if (isset($_POST['submit'])) {
            $id = $_GET['id'];
            $IDEveniment = htmlentities($_POST['IDEveniment'], ENT_QUOTES);
            $tip = htmlentities($_POST['tip'], ENT_QUOTES);
            $pret = htmlentities($_POST['pret'], ENT_QUOTES);

            if ($IDEveniment == '' || $tip == '' || $pret == '') {
                $error = "ERROR: Completati campurile obligatorii!";
            } else {
                if ($stmt = $mysqli->prepare("UPDATE bilet SET tip=?, pret=?, IDEveniment=? WHERE id='".$id."'")) {
                    $stmt->bind_param("sdi", $tip, $pret, $IDEveniment);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    $error = "ERROR: nu se poate executa update.";
                }
            }
        }
?>

<html>
<head>
    <title><?php if ($_GET['id'] != '') { echo "Modificare bilet"; } ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
</head>
<body>
<div class="container mt-5">

<h1><?php if ($_GET['id'] != '') { echo "Modificare inregistrare"; } ?></h1>
<?php if ($error != '') {
    echo "<div style='padding: 4px; border: 1px solid red; color: red'>" . $error . "</div>";
} ?>
<form action="" method="post">
    <div>
        <?php if ($_GET['id'] != '') { ?>
            <input type="hidden" name="idBilet" value="<?php echo $_GET['id']; ?>" />
            <?php
            if ($result = $mysqli->query("SELECT tip, pret, IDEveniment FROM bilet where id='".$_GET['id']."'")) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_object(); ?>
                    <div class="form-group">
                        <label for="tip">Tip:</label>
                        <input type="text" class="form-control" name="tip" id="tip" value="<?php echo htmlspecialchars($row->tip); ?>" />
                    </div>
                    <div class="form-group">
                        <label for="pret">Pret:</label>
                        <input type="text" class="form-control" name="pret" id="pret" value="<?php echo htmlspecialchars($row->pret); ?>" />
                    </div>

                    <?php
                    $dropdown_stmt = $mysqli->prepare("SELECT id, titlu FROM eveniment WHERE IDOrganizator = ? ORDER BY id");
                    $dropdown_stmt->bind_param("i", $_SESSION['idOrganizator']);
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
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        <a href="index.php" class="btn btn-secondary">Acasa Bilete</a>
    </div>
</div>
</form>
</body>
</html>
