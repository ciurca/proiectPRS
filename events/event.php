<?php
// Connection code goes here
session_start();
include "partials/conectare.php";
include "partials/navbar.php";
require_once "shop/ShoppingCart.php";


// Check if an events ID has been provided
$event_id = isset($_GET['id']) ? intval($_GET['id']) : null;
if (!$event_id) {
    echo "No events ID provided.";
    exit;
}

// Start output buffering
ob_start();

// Query for events details
$event_query = "SELECT * FROM eveniment WHERE id = ?";
$event_stmt = $mysqli->prepare($event_query);
$event_stmt->bind_param("i", $event_id);
$event_stmt->execute();
$event_result = $event_stmt->get_result();
$event_data = $event_result->fetch_assoc();

// Check if events exists
if (!$event_data) {
    echo "Event not found.";
    exit;
}
// Query for speakers of the events
$speaker_query = "SELECT * FROM speaker WHERE IDEveniment = ?";
$speaker_stmt = $mysqli->prepare($speaker_query);
$speaker_stmt->bind_param("i", $event_id);
$speaker_stmt->execute();
$speaker_result = $speaker_stmt->get_result();



// First, make sure $event_id is properly initialized from $_GET or other sources.

$query = "
    SELECT colaborator.*
    FROM colaborator
    INNER JOIN contract ON colaborator.ID = contract.IDColaborator
    INNER JOIN eveniment ON contract.IDEveniment = eveniment.ID
    WHERE eveniment.ID = ?
";
if ($stmt = $mysqli->prepare($query)) {
    // Bind the events ID and the session ID (IDOrganizator) to the prepared statement.
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the results.
    $colaborators = [];
    while ($row = $result->fetch_assoc()) {
        $colaborators[] = $row;
    }

        // Now you have an array of colaborators for the given eveniment.
        // You can loop through this array to display the colaborator data.

    } else {
        // Handle error - prepare failed
        echo "Error preparing statement: " . htmlspecialchars($mysqli->error);
}

// Query for speakers of the events
$bilet_query= "SELECT * FROM bilet WHERE IDEveniment = ?";
$bilet_stmt = $mysqli->prepare($bilet_query);
$bilet_stmt->bind_param("i", $event_id);
$bilet_stmt->execute();
$bilet_result = $bilet_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($event_data['titlu']); ?> - Detalii</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Event Details: <?php echo htmlspecialchars($event_data['titlu']) ; ?></h2>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Event Information</h5>
            <p class="card-text">Description: <?php echo htmlspecialchars($event_data['descriere']); ?></p>
            <p class="card-text">Location: <?php echo htmlspecialchars($event_data['locatie']); ?></p>
            <p class="card-text">Date Start: <?php echo htmlspecialchars($event_data['data_inceput']); ?></p>
            <p class="card-text">Date End: <?php echo htmlspecialchars($event_data['data_sfarsit']); ?></p>
        </div>
    </div>

    <h3>Speakers</h3>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Prename</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($speaker = $speaker_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($speaker['nume']); ?></td>
                <td><?php echo htmlspecialchars($speaker['prenume']); ?></td>
                <td><?php echo htmlspecialchars($speaker['email']); ?></td>
                <td><?php echo htmlspecialchars($speaker['telefon']); ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <h3>Colaboratori</h3>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
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
        <?php
        $shoppingCart = new ShoppingCart();
        $product_array = $shoppingCart->getAllProduct($event_id);
        if (! empty($product_array)) {
            ?>
    <h3>Bilete</h3>
    <table class="table">
        <thead>
        <tr>
            <th>Tip</th>
            <th>Pret</th>
            <th>Cantitate</th>
            <th>Cumpara</th>
        </tr>
        </thead>
        <?php
            foreach ($product_array as $key => $value) {
                ?>
                    <form method="post" action="/proiect/events/shop/cos.php?action=add&id=<?php
                    echo $value['ID'];?>">

                        <tr>
                            <td><?php echo $value["tip"];
                                ?></td>
                            <td><?php echo
                                    $product_array[$key]["pret"] . " lei"; ?>
                                </td>
                            <td><input type="text" name="quantity" value="1" size="2" /> </td>
                        <td> <input type="submit" value="Add to cart"
                                       class="btnAddAction" /></td>
                        </tr>
                    </form>
                </div>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
<?php
// End output buffering and output everything
ob_end_flush();
?>
