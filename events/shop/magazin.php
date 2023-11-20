<?php
require_once "ShoppingCart.php";?>
<HTML>
<HEAD>
    <TITLE>Creare cos cumparaturi </TITLE>
    <link href="style.css" type="text/css" rel="stylesheet" />
</HEAD>
<BODY>
<div id="product-grid">
    <div class="txt-heading"><div class="txt-heading label">Products</div></div>
    <?php
    $shoppingCart = new ShoppingCart();
    $query = "SELECT * FROM bilet";
    $product_array = $shoppingCart->getAllProduct($query);
    if (! empty($product_array)) {
    foreach ($product_array as $key => $value) {
    ?>
    <div class="product-item">
        <form method="post" action="/proiect/events/shop/cos.php?action=add&id=<?php
        echo $value['ID'];?>">

            <div>
                <strong><?php echo $value["tip"];
                    ?></strong>
            </div>
            <div class="product-price"><?php echo
                    "$".$product_array[$key]["pret"]; ?></div>
            <div>
                <input type="text" name="quantity" value="1" size="2" />
                <input type="submit" value="Add to cart"
                       class="btnAddAction" />
            </div>
        </form>
    </div>
        <?php
    }
    }
    ?>
</div>
</BODY>
</HTML>