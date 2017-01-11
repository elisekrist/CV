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
$nr = $_GET['nr'];
echo "<main>";
if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] != "" && $_SESSION["admin"]){ //sjekker at du er logget inn og er admin
    $sql = "CALL deletePost($nr)"; //sletter posten fra database
    $query = mysqli_query($connection, $sql);
    if ($query){
        header("Location: thread.php?cat=$cat&subcat=$subcat&t=$t&p=$p");
    }
    else {
        echo "Error: " . "<br>" . $connection->error;
    }
}
echo "</main>";
footer();
?>