<?php
include "functions.php";
include "database.php";
head();
headers();

$cat = $_POST['cat'];
$subcat = $_POST['subcat'];

$connection = connect(); //kobler til database

$t = $_POST['thread'];
$text = $_POST['text'];
$subcat = $_POST['subcat'];
echo "<main>";
if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] == ""){
    echo "ERROR: not logged in";
}
else if ( $t == "" || $text == ""){
    echo "ERROR: name or textfield is empty";
}
else {
    $user = $_SESSION["loggedIn"];
    $sql = "CALL addThread('$t','$text','$subcat','$user')"; //legger ny thread inn i database
    $query = mysqli_query($connection, $sql);
    if ($query){
        header("Location: thread.php?cat=$cat&subcat=$subcat&t=$t&p=1");
    }
    else {
        echo "Error: " . "<br>" . $connection->error;
    }
}
echo "</main>";
footer();
?>