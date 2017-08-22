<?php
    include "db.php";
    session_start();

    // Adding to cart functionality
    if (isset($_POST["addToCart"])) {
        if (isset($_SESSION["shopping_cart"])) {
            $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
            if (!in_array($_GET["id"], $item_array_id)) {
                $count = count($_SESSION["shopping_cart"]);

                $item_array = array(
                    'item_id' => $_GET["id"],
                    'item_name' => $_POST["hidden_name"],
                    'item_price' => $_POST["hidden_price"],
                    'item_quantity' => $_POST["quantity"]
                );

                $_SESSION["shopping_cart"][$count] = $item_array;

                echo "
                    <br><br><br>
                    <div class = 'alrt text-center col-md-4 alert alert-success'>
                        <a href = '' class = 'close' data-dismiss = 'alert' aria-label = 'close'>&times;</a>
                            <b>😍 You don add am to your carton</b>                           
                    </div>
                ";
                //echo "<script>window.location='index.php'</script>";
            } else {
                echo "
                    <br><br><br>
                    <div class = 'alrt text-center col-md-4 alert alert-warning'>
                        <a href = '' class = 'close' data-dismiss = 'alert' aria-label = 'close'>&times;</a>
                            <b>😞 You don add am before...go continue your shopping</b>                           
                    </div>
                ";
                //  echo "<script>window.location='index.php'</script>";
            }
        } else {
            $item_array = array(
                'item_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'item_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"]
            );
            $_SESSION["shopping_cart"][0] = $item_array;
        }
    }

// Deleting from cart functionality
    if (isset($_GET["action"])) {
        if ($_GET["action"] == "delete") {
            foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                unset($_SESSION["shopping_cart"]["$keys"]);
                echo "
                    <br><br><br>
                    <div class = 'alrt text-center col-md-4 alert alert-warning'>
                        <a href = '' class = 'close' data-dismiss = 'alert' aria-label = 'close'>&times;</a>
                            <b>😞 You don remove am</b>                           
                    </div>
                ";
                //  echo "<script>window.location='index.php'</script>";
            }
        }
    }
?>

<!doctype html>
<html>
    <head>
        <title>Simple Shopping Cart</title>

        <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="assets/css/style.css" type="text/css">

        <script src="assets/js/jquery-3.2.0.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/main.js"></script>

    </head>
    <body>
        <div class="container">
            <h3 class="text-center">Shopping Cart</h3><br>
            <?php
                $query = "SELECT * FROM cart ORDER BY /*id ASC ORDER by*/ RAND()";
                $result = mysqli_query($con, $query);
                $count = mysqli_num_rows($result);

                if ($count> 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $itemId = $row["id"];
                        $itemName = $row["item_name"];
                        $itemImage = $row["item_image"];
                        $itemPrice = $row["item_price"];

                        ?>
                            <div class="col-md-3">
                                <form method="post" action="index.php?action=add&id=<?php echo $itemId ?>">
                                    <div class="panel panel-info">
                                        <div class="panel-heading"><?php echo $itemName ?></div>
                                        <div class="panel-body ovr-hddn">
                                            <img src="assets/img/<?php echo $itemImage ?>" class="img-responsive">
                                            <h6 class="text-info"><?php echo $itemImage ?></h6>
                                            <input type="text" name="quantity" class="form-control" value="1">
                                            <input type="hidden" name="hidden_name" value="<?php echo $itemName ?>">
                                            <input type="hidden" name="hidden_price" value="<?php echo $itemPrice ?>">
                                        </div>
                                        <div class="item_price text-center panel-heading">
                                            <input type="submit" name="addToCart" class="btn btn-xs btn-success" value="Add to Cart">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php
                    }
                }
            ?>
            <div style="clear: both"></div>
            <br>
            <h3>Order Details</h3>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Item Name</th>
                        <th width="10%">Quantity</th>
                        <th width="20%">Price</th>
                        <th width="15%">Total</th>
                        <th width="5%">Action</th>
                    </tr>
                    <?php
                        if (!empty($_SESSION["shopping_cart"])) {
                            $total = 0;
                            foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                    ?>
                        <tr>
                            <td><?php echo $values["item_name"];?></td>
                            <td><?php echo $values["item_quantity"];?></td>
                            <td><?php echo $values["item_price"];?></td>
                            <td><?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td>
                            <td><a href="index.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class = "text-danger">Remove</span></a></td>
                        </tr>
                    <?php
                            $total = $total + ($values["item_quantity"] * $values["item_price"]);
                        }
                    ?>
                        <tr>
                            <td colspan="3" align="right">Total</td>
                            <td align="right">₦ <?php echo number_format($total, 2); ?></td>
                        </tr>
                    <?php
                        }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>
