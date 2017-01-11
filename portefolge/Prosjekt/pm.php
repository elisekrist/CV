<?php
include "database.php";
include "functions.php";
head();
headers();

if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] == "") {
    echo"You must be logged in to enter this page.";
    header("Location: index.php");
}

$connection = connect(); //kobler til database
$username = $_SESSION["loggedIn"];

$sql = "SELECT * FROM User";
$query = mysqli_query($connection, $sql);
// genererer sidetall
$rowCount = mysqli_num_rows($query);
$lastpage = $rowCount/10+1;
$p = $_GET['p'];
$pagesstring = "";
settype($lastpage,"int");

if ($p > 1){
    $temp = $p-1;
    $pagesstring .= "<a href='pm.php?p=$temp'>prev</a>|";
}
$teller = 1;
while ($teller <= $lastpage){
    if ($teller == $p){
        $pagesstring .= "|$teller|";
    }
    else if ($teller < 3) {
        $pagesstring .= "|<a href='pm.php?p=$teller'>$teller</a>|";
    }
    else if ($teller > $lastpage-2) {
        $pagesstring .= "|<a href='pm.php?p=$teller'>$teller</a>|";
    }
    else if ($teller < $p+3 && $teller > $p-3){
        $pagesstring .= "|<a href='pm.php?p=$teller'>$teller</a>|";
    }
    $teller++;
}
if ($p < $lastpage){
    $temp = $p+1;
    $pagesstring .= "<a href='pm.php?p=$temp'>next</a>|";
}
// hopper over database resultater fram til resultatene relevant for siden
$teller = 0;
while($teller/10 < $p-1){
    $row = mysqli_fetch_array($query);
    $teller++;
}

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
	    <h2>Personal messages</h2>
		<form action='createPMRedirect.php' method='POST'>
			<p>To:</p><br><input id='toUser' type='text' name='toUser'><br>
			<textarea id='text' name='text' onfocus='clearContents(this)'>Write your message here</textarea>
			<input type='submit' name='submit' id='submit'>
		</form>
		

	</div>

    <pre class='pagestring' > $pagesstring</pre >
    <div>
	    <table class='membersTable'>
            <tr>
			    <th><label>User</label></th>
			    <th class='hideMedium'><label>Role</label></th>
			    <th><label>Last message</label></th>
			    <th class='hideSmall'><label> </label></th>
            </tr>
";
// henter og skriver ut meldinger
while($row = mysqli_fetch_array($query)) {
    $username2 = $row['username'];
    $role = $row['admin'];


    $avatar = ""; //setter avatar bilde
    if(file_exists("images/uploads/$username2.png"))
        $avatar = "images/uploads/$username2.png";
    else
        $avatar = "images/genericAvatar.jpg";

    $sql2 = "SELECT * FROM PersonalMessage WHERE fra = '$username' AND til = '$username2' OR fra = '$username2' AND til = '$username' ORDER BY sent DESC";
    $query2 = mysqli_query($connection, $sql2);
    $row2 = mysqli_fetch_array($query2);
    $pm = $row2['message'];

    // nedjustere strenglengden om den er for stor for å vises på PM, klikke på meldingen for å få hele
    if(strlen($pm) > 30)
        $pm = substr($pm, 0, 100). "...";

    if($role == '1') //setter rollen til brukeren
        $role = 'Administrator';
    else
        $role = 'Member';


    echo "
            <tr>
                <td>
                    <p><a onclick=\"editElement('toUser', '$username2')\">$username2</a></p>
                </td>
                <td class='hideMedium'>
                    <p>$role</p>                
                </td>
                <td>
                    <p><a href='messages.php?user=$username2'>$pm</a></p>
                </td>
                <td class='hideSmall'>
                    <img src='$avatar' alt=''>
                </td>
           </tr>
    ";

    if ($teller/10 == $p){ //skriver bare ut resultatene for denne siden
        break;
    }
    $teller++;
}
echo "
	    </table>
	</div>
    <pre class='pagestring' > $pagesstring</pre >
</main>
";

footer();