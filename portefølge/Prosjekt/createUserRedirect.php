<?php
include "functions.php";
include "database.php";
head();
headers();

echo"
<main>
    <div><h4>Info.</h4></div>
    <div id=\"newUserForm\">
        ";

        $connection = connect();

        $username = $_POST['name'];
        $mail = $_POST['mail'];
        $age = $_POST['age'];
        $password = $_POST['password1'];

        // Tester som redirecter til frontpage om innverdiene er ugyldige, i tilfelle vedkommende har klart
        // å bypasse javascipt testene.

        if($username == "" || $mail == "" || $age == "" || $password == "") {
            header("Location: index.php");
            return;
        }

        if(is_nan($age)) {
            header("Location: index.php");
            return;
        }

        else if(!($age >= 18) || !($age <= 120)) {
            header("Location: index.php");
            return;
}

        if(strlen($password) < 6 || strlen($password) > 20) {
            header("Location: index.php");
            return;
}

        $result = "CALL createUser('$username', '$mail', '$age', '$password')"; //legger ny bruker inn i databasen

        if ($connection->query($result))
        {
            $_SESSION["loggedIn"] = $username; //logger ny bruker inn
            $_SESSION["hasUnreadMessages"] = false;
            $_SESSION["admin"] = false;
            mail($mail, "Forum registration", "Welcome to the forum, " . $username . "."); //sender velkommen e-mail(funker ikke lokalt)
            header("Location: index.php");
        }
        else
            echo "Error: " . "<br>" . $connection->error;

        mysqli_close($connection);
        echo"
    </div>
</main>
";

footer();
?>