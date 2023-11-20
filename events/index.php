<?php
session_start();
include "partials/conectare.php"; // Replace with the path to your database connection script
include "partials/navbar.php";

$query = "SELECT eveniment.id, eveniment.titlu, eveniment.data_inceput, eveniment.data_sfarsit, organizator.nume AS organizer_name FROM eveniment INNER JOIN organizator ON eveniment.IDOrganizator = organizator.ID ORDER BY eveniment.id";

$result = $mysqli->query($query);

if (!$result) {
    die("Database query failed: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Events</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>All Events</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Title</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Organizer</th>
            <th>Details</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($event = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($event['titlu']); ?></td>
                <td><?php echo htmlspecialchars($event['data_inceput']); ?></td>
                <td><?php echo htmlspecialchars($event['data_sfarsit']); ?></td>
                <td><?php echo htmlspecialchars($event['organizer_name']); ?></td>
                <td>
                    <a href="/proiect/events/event.php?id=<?php echo $event['id']; ?>" class="btn btn-info">View Details</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
