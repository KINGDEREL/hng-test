<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "project";

// Create connection to database
$con = mysqli_connect($servername, $username, $password, $db);

// Check connection status
if (!$con) {
    die ("Connection Failed: ". mysqli_connect_error());
}
?>

<!--INSERT INTO `tbl_product` (`id`, `item_name`, `item_image`, `item_price`) VALUES (NULL, 'Brown Brogues', 'brown_brogues.jpg', '8000'), (NULL, 'Starwars Top Trooper', 'nikon_starwars_top_trooper.jpg', '17000'), (NULL, 'Benassi Slides', 'nike_benassi_slides.jpg', '12000'), (NULL, 'Burton Men''s Trouser', 'burton_menswear.jpg', '6500'), (NULL, 'Rayban Round Glasses', 'rayban_round_glasses.jpg', '7500');-->
