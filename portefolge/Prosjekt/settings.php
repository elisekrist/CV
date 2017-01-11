<?php
include 'functions.php';
include 'database.php';
head();

headers();

if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] == "") {
    echo"You must be logged in to enter this page.";
    header("Location: index.php");
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
                    <a href=\"settings.php\"><img class=\"iconImg\" src=\"images/settings.jpg\" alt=\"PM\"></a>
                </td>
            </tr>
	    </table>
	</div>";

$connection = connect(); //database tilkobling
$username = $_SESSION["loggedIn"];
$sql = "SELECT * FROM User WHERE '$username' = username"; //henter bruker informasjon
$query = mysqli_query($connection, $sql);

$row = mysqli_fetch_array($query);
$mail = $row['mail'];
$age = $row['age'];

$avatar = ""; //setter avatar bilde
if(file_exists("images/uploads/$username.png")) {
    $avatar = "images/uploads/$username.png";
}
else
    $avatar = "images/genericAvatar.jpg";

echo "
     <div class='settings'><h2>Settings</h2>
     		<img id='settingsImage' alt='$username' src='$avatar'>
            <p><br>Username: $username</p>
            <p><br>E-mail: $mail</p>
            <p><br>Age: $age</p>
            

     <div class='change'>
    <label class='links'><a href=\"#\" onclick=\"showElements('changeAvatar', 'changePassword', 'changeMail', 'links');\"><br><br>Change avatar<br></a></label>
	</div>
		<div id='changeAvatar' style=\"display: none;\">
		    <h3>Change avatar</h3>
			<form method ='post' action='editURedirect.php?setting=avatar' enctype='multipart/form-data'>
				<p>Choose file:</p><input type='file' name='filename' size='10'>
				<br><input type='submit' value='Upload' class='submit'>
			</form>
		<label><br>&larr;<a href=\"settings.php\">Back</a></label>
		</div>


	<div class='change'>
    <label class='links'><a href=\"#\" onclick=\"showElements('changePassword', 'changeMail', 'changeAvatar', 'links');\"><br><br>Change password<br></a></label>
	</div>

		<div id='changePassword' style=\"display: none;\">
		    <h3>Change password</h3>
		    <form method='post' action='editURedirect.php?setting=password' enctype='multipart/form-data'>
			    <p>New password</p><input type='password' name='newpassword' />
			    <p>Repeat new password</p><input type='password' name='newpassword2' />
			    <p>Old password</p><input type='password' name='oldpassword' /><br>
			    <input type='submit' value='Submit' class='submit'>
		    </form>
		<label><a href=\"settings.php\"><br>&larr; Back</a></label>
		</div>

	<div class='change'>
    <label class='links'><a href=\"#\" onclick=\"showElements('changeMail', 'changePassword', 'changeAvatar', 'links');\"><br><br>Change e-mail<br></a></label>
    </div>

		<div id='changeMail' style=\"display: none;\">
		
		    <h3>Change e-mail</h3>
		    <form method='post' action='editURedirect.php?setting=mail' enctype='multipart/form-data' onsubmit=\"return isMail()\">
			    <p>New e-mail</p><input id ='newemail' type='text' name='newemail' />
			    <p>Password</p><input type='password' name='password' /> <br>
		    <input type='submit' value='Submit' class='submit'>
		    </form>
		<label><a href=\"settings.php\"><br>&larr; Back</a></label>
		</div>
";

echo "
	</div>
</main>
";

footer();
?>