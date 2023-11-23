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
<div class="container mt-5">
<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Agenda</h5>
        <p class="card-text"><?php echo htmlspecialchars($event_data['agenda']); ?></p>
    </div>
</div>
    <a href="/proiect/events/event.php?id=<?php echo $_GET['id'];?>" class="btn btn-primary">Inapoi la eveniment</a>
</div>
</body>
</html>
<?php
ob_end_flush();
?>
