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

$speaker_query = "SELECT * FROM speaker WHERE IDEveniment = ?";
$speaker_stmt = $mysqli->prepare($speaker_query);
$speaker_stmt->bind_param("i", $event_id);
$speaker_stmt->execute();
$speaker_result = $speaker_stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Speakers</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Speakers</h3>
    <table class="table">
        <thead>
        <tr>
        </tr>
        </thead>
        <tbody>
        <?php while ($speaker = $speaker_result->fetch_assoc()): ?>
            <tr>
                <td><img class="rounded-circle" height="75px" width="75px" src="/proiect/<?php echo htmlspecialchars($speaker['poza']); ?>" alt="Card image cap"><span class="h4"> <?php echo htmlspecialchars($speaker['nume']) . ' ' . htmlspecialchars($speaker['prenume']); ?></span></td>

            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
        <a href="/proiect/events/event.php?id=<?php echo $_GET['id'];?>" class="btn btn-primary">Inapoi la eveniment</a>
    </div>
</body>
</html>
<?php
ob_end_flush();
?>
