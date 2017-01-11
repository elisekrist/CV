<?php
include "functions.php";
include "database.php";
head();
headers();

$connection = connect(); //kobler til database

$fromUser = $_SESSION['loggedIn'];
$toUser = $_POST['toUser'];
$text = $_POST['text'];

if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] == "") {
    echo "ERROR: not logged in";
}
else if ( $toUser == "" || $text == "") {
    echo "ERROR: name or textfield is empty";
}
else if ( $toUser == $fromUser) {
    echo "ERROR: cannot message with yourself!";
}
else {
    $user = $_SESSION["loggedIn"];
    $sql = "CALL pm('$fromUser','$toUser', '$text')";  //legger ny PM inn i databasen
    $query = mysqli_query($connection, $sql);
    if ($query) {
        header("Location: pm.php?p=1");
    }
    else {
        echo "Error: " . "<br>" . $connection->error;
    }
}

footer();
?>