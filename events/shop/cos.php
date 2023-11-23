<?php
require_once "ShoppingCart.php";
session_start();
require_once "../partials/navbar.php";
// Dacă utilizatorul nu este conectat redirecționează la pagina de autentificare ...
if (!isset($_SESSION['loggedinParticipant'])) {
    header('Location: /proiect/events/participant/index.php');
    exit;
}
// pt membrii inregistrati
$member_id=$_SESSION['idParticipant'];
$shoppingCart = new ShoppingCart();
if (! empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":if (! empty($_POST["quantity"])) {

            $productResult = $shoppingCart->getProductByCode($_GET["id"]);

 $cartResult = $shoppingCart->getCartItemByProduct($productResult[0]["ID"], $member_id);
            header('Location: /proiect/events/shop/cos.php');

 if (! empty($cartResult)) {
     // Modificare cantitate in cos
     $newQuantity = $cartResult[0]["quantity"] +
         $_POST["quantity"];
     $shoppingCart->updateCartQuantity($newQuantity,
         $cartResult[0]["id"]);
 } else {
     // Adaugare in tabelul cos
     $shoppingCart->addToCart($productResult[0]["ID"],
         $_POST["quantity"], $member_id);
 }
 }
            break;
        case "remove":
            // Sterg o sg inregistrare
            $shoppingCart->deleteCartItem($_GET["id"]);
            header('Location: /proiect/events/shop/cos.php');
            break;
        case "empty":
            // Sterg cosul
            $shoppingCart->emptyCart($member_id);
            header('Location: /proiect/events/shop/cos.php');
            break;
        case 'transfer':
            $shoppingCart->transferTicketsForUser($member_id);
            header('Location: /proiect/events/shop/cos.php');
            break;
    }
}
?>
<HTML>
<HEAD>
    <TITLE>Cos bilete</TITLE>
</HEAD>
<BODY>
<div class="container mt-5">
<div id="shopping-cart">
    <div class="txt-heading">
        <div class="h1">Cos Cumparaturi</div> <a
                id="btnEmpty" href="cos.php?action=empty" class="btn btn-danger"><i class="fas fa-trash"></i> Goleste cosul</a>
    </div>
    <?php
    $cartItem = $shoppingCart->getMemberCartItem($member_id);
    if (! empty($cartItem)) {
    $item_total = 0;
    ?>
    <table cellpadding="10" cellspacing="1">
        <tbody>
        <tr>
            <th style="text-align: left;"><strong>Tip</strong></th>
            <th style="text-align:
right;"><strong>Cantitate</strong></th>
            <th style="text-align:
right;"><strong>Pret</strong></th>
            <th style="text-align:
center;"><strong>Actiune</strong></th>
        </tr>
        <?php
        foreach ($cartItem as $item) {
        ?>
        <tr>
            <td
                    style="text-align: left; border-bottom: #F0F0F0 1px
solid;"><strong><?php echo $item["tip"]; ?></strong></td>
            <td
                    style="text-align: right; border-bottom: #F0F0F0 1px
solid;"><?php echo $item["cantitate"]; ?></td>
            <td
                    style="text-align: right; border-bottom: #F0F0F0 1px
solid;"><?php echo $item["pret"].' lei'; ?></td>
            <td>
<a href="cos.php?action=remove&id=<?php echo $item["cart_id"]; ?>" class="btn btn-danger"> <i class="fas fa-trash"></i></a></td>
        </tr>
            <?php
            $item_total += ($item["pret"] * $item["cantitate"]);
        }
        ?>
        <tr>
            <td colspan="3" align=right><strong>Total:</strong></td>
            <td align=right><?php echo $item_total.' lei'; ?></td>
            <td></td>
        </tr>
        </tbody>
    </table>
        <?php
    }
    ?>
</div>
    <div><a href="/proiect/events" class="btn btn-primary"><i class="fas fa-plus"></i> Adauga bilete </a>
    <a href="cos.php?action=transfer" class="btn btn-success"> <i class="fas fa-shopping-cart"></i> Cumpara</a>
    </div>

</div>

</BODY>
</HTML>