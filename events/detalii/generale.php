<?php
session_start();
include "../partials/conectare.php";
include "../partials/navbar.php";


$event_id = isset($_GET['id']) ? intval($_GET['id']) : null;
if (!$event_id) {
    echo "No events ID provided.";
    exit;
}

ob_start();

$event_query = "SELECT eveniment.*, organizator.nume FROM eveniment INNER JOIN organizator on eveniment.IDOrganizator = organizator.ID WHERE eveniment.ID = ?";
$event_stmt = $mysqli->prepare($event_query);
$event_stmt->bind_param("i", $event_id);
$event_stmt->execute();
$event_result = $event_stmt->get_result();
$event_data = $event_result->fetch_assoc();

if (!$event_data) {
    echo "Event not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($event_data['titlu']); ?> - Detalii</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card: 3rem;
    </style>
</head>
<body>
<div class="container mt-4">
    <h2>Detalii eveniment: <?php echo $event_data['titlu'] ; ?></h2>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Informatii eveniment</h5>
            <p class="card-text">Organizator: <?php echo $event_data['nume']; ?></p>
            <p class="card-text">Descriere: <?php echo $event_data['descriere']; ?></p>
            <p class="card-text">Locatie: <?php echo $event_data['locatie']; ?></p>
            <p class="card-text">Data Inceput: <?php echo $event_data['data_inceput']; ?></p>
            <p class="card-text">Data Sfarsit: <?php echo $event_data['data_sfarsit']; ?></p>
        </div>
        <a href="/proiect/events/event.php?id=<?php echo $_GET['id'];?>" class="btn btn-primary">Inapoi la eveniment</a>
</div>
</body>
</html>
<?php
ob_end_flush();
?>
