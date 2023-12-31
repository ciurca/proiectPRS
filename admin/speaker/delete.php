<?php
include("../partials/conectare.php");
include('../partials/auth_check.php');

include "../partials/navbar.php";
$speaker_id = isset($_GET['id']) ? $_GET['id'] : null;
if ($speaker_id) {
    $query = "
        SELECT eveniment.IDOrganizator 
        FROM speaker 
        INNER JOIN eveniment ON speaker.IDEveniment = eveniment.id 
        WHERE speaker.id = ?
    ";

    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $speaker_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row && $_SESSION['idOrganizator'] != $row['IDOrganizator']) {
                header('Location: /proiect/admin/');
                exit;
            }
        } else {
            header('Location: /proiect/admin/');
            exit;
        }
    } else {
        error_log('Prepare failed: ' . $mysqli->error);
    }
} else {
    header('Location: /proiect/admin/');
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id']))
{
// preluam variabila 'id' din URL
    $id = $_GET['id'];
// stergem inregistrarea cu ib=$id
    if ($stmt = $mysqli->prepare("DELETE FROM speaker WHERE id = ? LIMIT 1"))
    {
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $stmt->close();
        echo "<div class='container mt-5 alert alert-success' role='alert'>Speaker-ul a fost sters!</div>";
        echo "<div class='container mt-5'><a class='btn btn-primary' href='/proiect/admin/speaker'>Acasa</a></div>";
    }
    else
    {
        echo "ERROR: Nu se poate executa delete.";
        echo "<div class='alert alert-warning container mt-5'>Evenimentul nu exista.</div>";
        echo "<div class='container mt-5'><a class='btn btn-primary' href='/proiect/admin/event.php'>Acasa</a></div>";
    }
    $mysqli->close();
}
?>
