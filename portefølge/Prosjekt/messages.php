<?php
include "database.php";
include "functions.php";
head();
headers();

if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] == "") {
    echo"You must be logged in to enter this page.";
    header("Location: index.php");
}

$connection = connect(); //database tilkobling
$username = $_SESSION["loggedIn"];

$username2 = $_GET['user'];

echo"
<main>
    <div>
	    <table>
            <tr>
                <td>
                    <a href=\"index.php\"><img class=\"iconImg\" src=\"images/home.jpg\" alt=\"Home\"></a>
                </td>
                <td>
                     <label><b>&rarr;</b></label>
                </td>
                <td>
                    <a href=\"pm.php?p=1\"><img class=\"iconImg\" src=\"images/pm.jpg\" alt=\"PM\"></a>
                </td>
            </tr>
	    </table>
	</div>
	<div class='messageForm'>
	    <h2><a href='pm.php?p=1'> &larr; </a>Personal messages with $username2</h2>
		<form action='createPMRedirect.php' method='POST'>
			<p>To:</p><br><input id='toUser' type='text' name='toUser' value='$username2'><br>
			<textarea id='text' name='text' onfocus='clearContents(this)'>Write your message here</textarea>
			<input type='submit' name='submit' id='submit'>
		</form>
	</div>

    <div>
	    <table class='membersTable'>
            <tr>
			    <th><p class='leftText'>Message</p></th>
			    <th><p class='rightText'>Date</p></th>
            </tr>
";
//henter meldinger fra databasen og skriver de ut.
$sql = "SELECT * FROM PersonalMessage WHERE fra = '$username' AND til = '$username2' OR fra = '$username2' AND til = '$username' ORDER BY sent DESC";
$query = mysqli_query($connection, $sql);

while($row = mysqli_fetch_array($query)) {
    $message = $row['message'];
    $date = $row['sent'];
    $from = $row['fra'];
    $direction = ' ';
    if($from == $username2)
        $direction = '&larr;';
    else
        $direction = '&rarr;';

    echo "
            <tr>
                <td>
                    <p class='leftText'>$direction $message</p>
                </td>
                <td>
                    <p class='rightText'>$date</p>
                </td>
           </tr>
    ";
}
//setter ulest meldinger til false i session variabelen og i databasen
$sql2 = "UPDATE User SET hasunreadmessage = '0' WHERE '$username' = username";
$query2 = mysqli_query($connection, $sql2);
mysqli_fetch_array($query);
$_SESSION["hasUnreadMessages"] = '0';

echo"
	    </table>
	</div>
</main>
";

footer();