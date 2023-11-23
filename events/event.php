<?php
session_start();
include "partials/conectare.php";
include "partials/navbar.php";
require_once "shop/ShoppingCart.php";


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
$speaker_query = "SELECT * FROM speaker WHERE IDEveniment = ?";
$speaker_stmt = $mysqli->prepare($speaker_query);
$speaker_stmt->bind_param("i", $event_id);
$speaker_stmt->execute();
$speaker_result = $speaker_stmt->get_result();




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
    <style>
        .card: 3rem;
    </style>
</head>
<body>
<div class="container mt-4">
    <h2>Detalii eveniment: <?php echo htmlspecialchars($event_data['titlu']) ; ?></h2>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><a href="/proiect/events/detalii/generale.php?id=<?php echo $_GET['id']?>">Informatii eveniment</a></h5>
            <p class="card-text">Organizator: <?php echo htmlspecialchars($event_data['nume']); ?></p>
            <p class="card-text">Descriere: <?php echo $event_data['descriere']; ?></p>
            <p class="card-text">Locatie: <?php echo $event_data['locatie']; ?></p>
            <p class="card-text">Data Inceput: <?php echo htmlspecialchars($event_data['data_inceput']); ?></p>
            <p class="card-text">Data Sfarsit: <?php echo htmlspecialchars($event_data['data_sfarsit']); ?></p>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><a href="/proiect/events/detalii/agenda.php?id=<?php echo $_GET['id']?>">Agenda</a></h5>
            <p class="card-text"><?php echo $event_data['agenda']; ?></p>
        </div>
    </div>

    <h3><a href="/proiect/events/detalii/speakers.php?id=<?php echo $_GET['id']?>">Speakers</a></h3>
    <table class="table">
        <thead>
        <tr>
        </tr>
        </thead>
        <tbody>
        <?php while ($speaker = $speaker_result->fetch_assoc()): ?>
            <tr>
                <td><img class="rounded-circle" height="75px" width="75px" src="/proiect/<?php echo $speaker['poza']; ?>" alt="Card image cap"><span class="h4"> <?php echo htmlspecialchars($speaker['nume']) . ' ' . htmlspecialchars($speaker['prenume']); ?></span></td>

            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <h3><a href="/proiect/events/detalii/colaboratori.php?id=<?php echo $_GET['id']?>">Colaboratori</a></h3>
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
                <td><?php echo $colab['nume']; ?></td>
                <td><?php echo $colab['tip']; ?></td>
                <td><?php echo $colab['tip_parteneriat']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
        <?php
        $shoppingCart = new ShoppingCart();
        $product_array = $shoppingCart->getAllProduct($event_id);
        if (! empty($product_array)) {
            ?>
    <h3><a href="/proiect/events/detalii/bilete.php?id=<?php echo $_GET['id']?>">Bilete</a></h3>
    <table class="table">
        <thead>
        <tr>
            <th>Tip</th>
            <th>Pret</th>
            <th>Cantitate</th>
            <th></th>
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
                        <td> <input class='btn btn-success' type="submit" value="Cumpara"
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
</body>
</html>
<?php
ob_end_flush();
?>
