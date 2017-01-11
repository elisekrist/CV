<?php
include "functions.php";
include "database.php";
head();
headers();

$cat = $_GET['cat'];
$subcat = $_GET['subcat'];

$connection = connect();

$t = $_GET['t'];
$p = $_GET['p'];
echo "<main>";
if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] != "" && $_SESSION["admin"]){ //sjekker at du er logget inn og er admin
    $sql = "CALL deleteThread('$t')"; //sletter tråden fra databsen og alle tilhørende poster
    $query = mysqli_query($connection, $sql);
    if ($query){
        header("Location: subcategory.php?cat=$cat&subcat=$subcat&page=$p");
    }
    else {
        echo "Error: " . "<br>" . $connection->error;
    }
}
echo "</main>";
footer();
?>