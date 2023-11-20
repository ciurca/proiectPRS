<?php
include("../partials/conectare.php");
include('../partials/auth_check.php');
include('../partials/navbar.php');

$error = '';

if (!empty($_POST['idOrganizator'])) {
    if (isset($_POST['submit'])) {
        if (is_numeric($_POST['idOrganizator'])) {
            $id = $_POST['idOrganizator'];
            $nume = htmlentities($_POST['nume'], ENT_QUOTES);
            $prenume = htmlentities($_POST['prenume'], ENT_QUOTES);
            $email = htmlentities($_POST['email'], ENT_QUOTES);
            $telefon = htmlentities($_POST['telefon'], ENT_QUOTES);
            $IDEveniment = htmlentities($_POST['IDEveniment'], ENT_QUOTES);

            if ($nume == '' || $prenume == '' || $email == '' || $telefon == '') {
                $error = "ERROR: Completati campurile obligatorii!";
            } else {
                if ($stmt = $mysqli->prepare("UPDATE speaker SET nume=?, prenume=?, email=?, telefon=?, IDEveniment=? WHERE id='".$id."'")) {
                    $stmt->bind_param("ssssi", $nume, $prenume, $email, $telefon, $IDEveniment);
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
    <title><?php if ($_GET['id'] != '') { echo "Modificare speaker"; } ?></title>
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
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
            <?php
            if ($result = $mysqli->query("SELECT nume, prenume, email, telefon, IDEveniment FROM speaker where id='".$_GET['id']."'")) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_object(); ?>
                    <div class="form-group">
                        <label for="nume">Nume:</label>
                        <input type="text" class="form-control" name="nume" id="nume" value="<?php echo htmlspecialchars($row->nume); ?>" />
                    </div>
                    <div class="form-group">
                        <label for="prenume">Prenume:</label>
                        <input type="text" class="form-control" name="prenume" id="prenume" value="<?php echo htmlspecialchars($row->prenume); ?>" />
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($row->email); ?>" />
                    </div>

                    <div class="form-group">
                        <label for="telefon">Telefon:</label>
                        <input type="text" class="form-control" name="telefon" id="telefon" value="<?php echo htmlspecialchars($row->telefon); ?>" />
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
        <a href="index.php" class="btn btn-secondary">Acasa Speakers</a>
    </div>
</div>
</form>
</body>
</html>
