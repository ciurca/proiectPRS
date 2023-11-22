<!-- my_tickets.php -->
<?php
include("../partials/conectare.php");
include('../partials/auth_check.php');


include('../partials/navbar.php');

$query ="SELECT bilet_individual.ID, bilet.tip, eveniment.titlu
        FROM bilet_individual
        INNER JOIN bilet ON bilet_individual.IDBilet = bilet.ID
        INNER JOIN eveniment ON bilet.IDEveniment = eveniment.ID
        WHERE bilet_individual.IDParticipant = ?";

if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("i", $_SESSION['idParticipant']);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<div class='container mt-5'>";
    echo "<h3>Biletele asociate contului</h3>";
    echo "<table class='table'>";
    echo "<thead><tr><th>ID</th><th>Tip bilet</th><th>Titlu Eveniment</th></tr></thead>";
    echo "<tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['tip']) . "</td>";
        echo "<td>" . htmlspecialchars($row['titlu']) . "</td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
    echo "</div>";

    $stmt->close();
} else {
    echo "Error preparing statement: " . htmlspecialchars($mysqli->error);
}
?>