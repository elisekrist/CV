<?php
include "functions.php";
include "database.php";
head();
headers();

$connection = connect();

$setting = $_GET['setting'];
$username = $_SESSION["loggedIn"];

if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] == ""){
    echo "ERROR: not logged in";
}
else if ($setting == ""){
    echo "ERROR: no setting specified";
}
else {
    if ($setting == 'avatar') { //sjekker hva du vil endre, informasjon blir hentet og sql satt utifra det
        $target_file = "images/uploads/$username.png";
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


        // Fjern gammel fil om stien innerholder en fra før av
        if (file_exists($target_file)) {
            unlink("$target_file");
        }

        // Tillat bestemte filformat
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Sorry, only JPG, JPEG and PNG files are allowed.";
            $uploadOk = 0;
        }

        // Avgrens max filstørrelse
        if ($_FILES['filename']['size'] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // om error har inntruffet, avbryt
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            header("Location: settings.php");
            return;
        // Er alt ok, prøv å laste opp fila
        } else {
            if (move_uploaded_file($_FILES['filename']['tmp_name'], $target_file)) {

                echo 'The file '. basename($_FILES['filename']['name']). ' has been uploaded.';
                header("Location: settings.php");
                return;
                //$sql = "UPDATE User SET avatar = '$target_file' WHERE username = '$username'";

            } else {
                echo 'Sorry, there was an error uploading your file.';
                header("Location: settings.php");
                return;
            }
        }
    }

    else if($setting == 'password') {
        $password = $_POST['newpassword'];
        $password2 = $_POST['newpassword2'];
        $oldpassword = $_POST['oldpassword'];
        if($password == $password2 && strlen($password) >= 6 && strlen($password) <= 20)
            $sql = "UPDATE User SET password = '$password' WHERE username = '$username' AND password = '$oldpassword'";
        else {
            echo "Error: " . "<br>" . $connection->error;
            header("Location: settings.php");
            return;
        }
    }
    else if($setting == 'mail') {
        $password = $_POST['password'];
        $mail = $_POST['newemail'];
        if ($password != "" && $mail != "") {
            $sql = "UPDATE User SET mail = '$mail' WHERE username = '$username' AND password = '$password'";
        } else {
            echo "Error: " . "<br>" . $connection->error;
            header("Location: settings.php");
            return;
        }
    }

        $query = mysqli_query($connection, $sql);
        if ($query) {
            header("Location: settings.php");
        }
        else {
            echo "Error: " . "<br>" . $connection->error;
        }
}

footer();