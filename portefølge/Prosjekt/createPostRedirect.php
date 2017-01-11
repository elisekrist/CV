<?php
include "functions.php";
include "database.php";
head();
headers();

$cat = $_POST['cat'];
$subcat = $_POST['subcat'];

$connection = connect(); //kobler til database

$t = $_POST['thread'];
$lp = $_POST['lastpage'];
$text = $_POST['text'];
echo "<main>";
if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] == ""){
    echo "ERROR: not logged in";
}
else if ($text == ""){
    echo "ERROR: textfield is empty";
}
else {
    $user = $_SESSION["loggedIn"];
    $sql = "CALL addPost('$text','$user','$t')";  //legger ny post inn i database
    $query = mysqli_query($connection, $sql);
    if ($query){
        header("Location: thread.php?cat=$cat&subcat=$subcat&t=$t&p=$lp");
    }
    else {
        echo "Error: " . "<br>" . $connection->error;
    }
}
echo "</main>";
footer();
?>