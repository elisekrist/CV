<?php
include "database.php";
include "functions.php";
head();
$_SESSION["loggedIn"] = "";
headers();
echo"
<main>
    <p>Redirecting...............................</p>
</main>
";
header("Location: index.php");
footer();