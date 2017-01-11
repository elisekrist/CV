<?php
include "functions.php";
include "database.php";
head();
headers();

$cat = $_POST['cat'];
$subcat = $_POST['subcat'];

$connection = connect(); //kobler til database

$t = $_POST['t'];
$p = $_POST['p'];
$text = $_POST['text'];
$nr = $_POST['nr'];
echo "<main>";
if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] == ""){
    echo "ERROR: not logged in";
}
else if ($text == ""){
    echo "ERROR: textfield is empty";
}
else {
    if ($nr != null){ //setter sql basert på om det er tråd eller post som skal endres
        $sql = "CALL editPost('$text','$nr')";
    }
    else {
        $sql = "CALL editThread('$t','$text')";
    }

    $query = mysqli_query($connection, $sql); //oppdaterer post/tråd i databasen med ny tekst
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