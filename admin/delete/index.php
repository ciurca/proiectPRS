<?php
// conectare la baza de date database
include("../partials/conectare.php");
include("../partials/auth_check.php");
$event_id = isset($_GET['id']) ? $_GET['id'] : null;
if ($event_id) {
    $query = "SELECT IDOrganizator FROM eveniment WHERE id = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row && $_SESSION['id'] != $row['IDOrganizator']) {
            header('Location: /proiect/admin/');
            exit; // Don't forget to exit after sending the header
        }
    } else {
        // Handle error - prepare failed
        error_log('Prepare failed: ' . $mysqli->error);
    }
} else {
    // Handle error - events ID not set
    header('Location: /proiect/admin/');
    exit;
}
// se verifica daca id a fost primit
include "../partials/navbar.php";
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
// preluam variabila 'id' din URL
    $id = $_GET['id'];
    $query_exist = "SELECT id FROM eveniment WHERE id = ?";
    if ($stmt = $mysqli->prepare($query_exist)) {
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row) {
            if ($stmt = $mysqli->prepare("DELETE FROM eveniment WHERE id = ? LIMIT 1"))
            {
                $stmt->bind_param("i",$id);
                $stmt->execute();
                $stmt->close();
                echo "<div class='container mt-5 alert alert-success' role='alert'>Evenimentul a fost sters!</div>";
                echo "<div class='container mt-5'><a class='btn btn-primary' href='/proiect/admin/event.php'>Acasa</a></div>";
            }
        } else {
            echo "<div class='alert alert-warning container mt-5'>Evenimentul nu exista.</div>";
            echo "<div class='container mt-5'><a class='btn btn-primary' href='/proiect/admin/event.php'>Acasa</a></div>";
        }
    }

    $mysqli->close();

}
?>

