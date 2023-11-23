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

$query = "
    SELECT colaborator.*
    FROM colaborator
    INNER JOIN contract ON colaborator.ID = contract.IDColaborator
    INNER JOIN eveniment ON contract.IDEveniment = eveniment.ID
    WHERE eveniment.ID = ?
";
if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $colaborators = [];
    while ($row = $result->fetch_assoc()) {
        $colaborators[] = $row;
    }


} else {
    echo "Error preparing statement: " . htmlspecialchars($mysqli->error);
}


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
    <h3>Colaboratori</h3>
    <table class="table">
        <thead>
        <tr>
            <th>Nume</th>
            <th>Tip</th>
            <th>Tip Partener</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($colaborators as $colab): ?>
            <tr>
                <td><?php echo htmlspecialchars($colab['nume']); ?></td>
                <td><?php echo htmlspecialchars($colab['tip']); ?></td>
                <td><?php echo htmlspecialchars($colab['tip_parteneriat']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="/proiect/events/event.php?id=<?php echo $_GET['id'];?>" class="btn btn-primary">Inapoi la eveniment</a>
</div>
</body>
</html>
<?php
ob_end_flush();
?>
