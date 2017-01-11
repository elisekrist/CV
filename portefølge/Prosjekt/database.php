<?php

function connect() //metode for å koble til database, returnerer database tilkoblingen
{
    $server  = 'localhost';
    $username  = 'root';
    $password = '';
    $database = 'v16grdb3';
    $connection = mysqli_connect($server, $username, $password, $database);

    if (mysqli_connect_errno())
    {
        echo "<p>Connection failed</p>" . mysqli_connect_error();
        exit();
    }
    mysqli_set_charset($connection, "utf8");

    return $connection;
}

?>