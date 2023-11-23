<?php
require_once "DBController.php";
class ShoppingCart extends DBController
{
    function getAllProduct($event_id)
    {
        $query = "SELECT * FROM bilet WHERE IDEveniment = $event_id";

        $productResult = $this->getDBResult($query);
        return $productResult;
    }
    function getMemberCartItem($client_id)
    {
        $query = "SELECT bilet.*, istoric_comenzi.id as 
cart_id,istoric_comenzi.cantitate FROM bilet, istoric_comenzi WHERE 
 bilet.ID = istoric_comenzi.IDBilet AND istoric_comenzi.IDClient= ?";
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $client_id
            )
        );

        $cartResult = $this->getDBResult($query, $params);
        return $cartResult;
    }
    function getProductByCode($product_code)
    {
        $query = "SELECT * FROM bilet WHERE ID=?";

        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $product_code
            )
        );

        $productResult = $this->getDBResult($query, $params);
        return $productResult;
    }
    function getCartItemByProduct($product_id, $client_id)
    {
        $query = "SELECT * FROM istoric_comenzi WHERE ID = ? AND 
IDClient = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $product_id
            ),
            array(
                "param_type" => "i",
                "param_value" => $client_id
            )
        );
        $cartResult = $this->getDBResult($query, $params);
        return $cartResult;
    }
    function addToCart($product_id, $quantity, $client_id)
    {
        $query = "INSERT INTO istoric_comenzi (IDBilet,IDClient,cantitate) 
VALUES (?, ?, ?)";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $product_id
            ),
            array(
                "param_type" => "i",
                "param_value" => $client_id
            ),
            array(
                "param_type" => "i",
                "param_value" => $quantity
            )
        );

        $this->updateDB($query, $params);
    }
    function updateCartQuantity($quantity, $cart_id)
    {
        $query = "UPDATE istoric_comenzi SET cantitate = ? WHERE id= ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $quantity
            ),
            array(
                "param_type" => "i",
                "param_value" => $cart_id
            )
        );
        $this->updateDB($query, $params);
    }
    function deleteCartItem($cart_id)
    {
        $query = "DELETE FROM istoric_comenzi WHERE id = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $cart_id
            )
        );

        $this->updateDB($query, $params);
    }
    function emptyCart($client_id)
    {
        $query = "DELETE FROM istoric_comenzi WHERE IDClient = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $client_id
            )
        );

        $this->updateDB($query, $params);
    }
    function transferTicketsForUser($userID) {
        $query = "SELECT IDBilet, cantitate FROM istoric_comenzi WHERE IDClient = ?";
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $userID
            )
        );
        $tickets = $this->getDBResult($query, $params);

        if (!empty($tickets)) {
            foreach ($tickets as $ticket) {
                $idBilet = $ticket['IDBilet'];
                $quantity = $ticket['cantitate'];

                for ($i = 0; $i < $quantity; $i++) {
                    $insertQuery = "INSERT INTO bilet_individual (IDBilet, IDParticipant) VALUES (?, ?)";
                    $insertParams = array(
                        array(
                            "param_type" => "i",
                            "param_value" => $idBilet
                        ),
                        array(
                            "param_type" => "i",
                            "param_value" => $userID
                        )
                    );
                    $this->updateDB($insertQuery, $insertParams);
                }
            }
        }
        $this->emptyCart($userID);
        header("Location: /proiect/events/participant/bilete.php");
    }
}