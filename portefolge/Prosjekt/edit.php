<?php
include "functions.php";
include "database.php";
head();
headers();

$cat = $_GET['cat'];
$subcat = $_GET['subcat'];

$connection = connect(); //kobler til database

$type = $_GET['type'];
$t = $_GET['t'];
if ($type == "post"){ //sjekker om det er en post du vil endre på og fikser sql ut ifra det
    $p = $_GET['p'];
    $nr = $_GET['nr'];
    $sql = "SELECT post FROM Post WHERE postNr = '$nr'";
}
else {
    $p = 1;
    $nr = null;
    $sql = "SELECT post FROM Thread WHERE name = '$t'";
}
//henter teksten til posten/tråden fra databasen
$query = mysqli_query($connection,$sql);
$result = mysqli_fetch_array($query);
$text = $result['post'];

echo "
<main>
    <form class='editform' action='editRedirect.php' method='POST'>
        <textarea name='text' rows='15' cols='90'>$text</textarea>
        <input type='submit' value='Edit' class='submit'>
        <input name='t' type='hidden' value='$t'>
        <input name='p' type='hidden' value='$p'>
        <input name='nr' type='hidden' value='$nr'>
        <input name='cat' type='hidden' value='$cat'>
        <input name='subcat' type='hidden' value='$subcat'>
    </form>
</main>
";

footer();
?>