<?php
include "database.php";
include "functions.php";
head();
headers();

echo"
<main>
    <div><h4>Checking login.</h4></div>
        ";
        $connection = connect(); //kobler til database

        $username = $_POST['username'];
        $password = $_POST['password'];

        if($username == "" || $password == "") //sjekk om du har skrevet noe inn i brukernavn og passord feltet
        {
            header("Location: index.php");
            exit();
        }

        $sql = "SELECT getPassword('$username') as pw"; //henter passord fra database

        $query = mysqli_query($connection, $sql);
        $result = mysqli_fetch_array($query);

        $sql2 = "SELECT hasUnreadMessage('$username') as pm"; //henter boolean om du har uleste meldinger
        $query2 = mysqli_query($connection, $sql2);
        $result2 = mysqli_fetch_array($query2);

        if($result['pw'] == $password) //sjekker om det er rett passord, om brukeren ikke fins er det også feil
        {
            //sjekker om brukeren er banna
            $sql = "SELECT banEnd FROM Banned WHERE User_username = '$username' AND banEnd > CURDATE() ORDER BY banEnd DESC";
            $query = mysqli_query($connection, $sql);


            if (!$result = mysqli_fetch_array($query)) {
                echo "<p>Successfully logged in as $username.</p>";
                //setter log inn variabler
                $_SESSION["loggedIn"] = $username;
                $_SESSION["hasUnreadMessages"] = $result2['pm'];
                $sql = "SELECT admin FROM User WHERE username = '$username'";
                $query = mysqli_query($connection, $sql);
                $result = mysqli_fetch_array($query);
                $_SESSION["admin"] = $result['admin'];
                header("Location: index.php");
            }
            else {
                echo "<p>you are banned.</p>";
            }
        }
        else
        {
            /*  ?> <script type="text/javascript">failedLogin(); alert("a");</script> <?php  */
            echo "<p>Wrong password.</p>";
            //header("Location: index.php");
        }

        echo"
    </div>
</main>
";

footer();