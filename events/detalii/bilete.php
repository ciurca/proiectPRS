<?php
session_start();
include "../partials/conectare.php";
include "../partials/navbar.php";
require_once "../shop/ShoppingCart.php";


$event_id = isset($_GET['id']) ? intval($_GET['id']) : null;
if (!$event_id) {
    echo "No events ID provided.";
    exit;
}

ob_start();

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
    <title>Bilete</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
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
    <a href="/proiect/events/event.php?id=<?php echo $_GET['id'];?>" class="btn btn-primary">Inapoi la eveniment</a>
</div>
</body>
</html>
<?php
ob_end_flush();
?>
