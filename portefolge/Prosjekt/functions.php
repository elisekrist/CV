<?php
session_start();
function head() //metode for å sette inn standard metadata på forum
{
    echo "
    <!DOCTYPE html>
    <html lang=\"no\">
	<head>
    	<link href=\"styles.css\" rel=\"stylesheet\" type=\"text/css\">
    	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<script src=\"check.js\"></script>
		<title>Prosjekt</title>
		<meta charset=\"UTF-8\">
		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
		<meta name=\"description\" content=\"bla bla bla.\">
		<meta name=\"keywords\" content=\"stuff, ting, blabla\">
		<meta name=\"author\" content=\"a\">
	</head>
	";
}

function headers() //metode setter standard topp på forum
{
    if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] == "") //sjekker om du er logger inn
    {
    echo "
    <header>
		<figure><a href=\"index.php\"><img id=\"start\" src=\"images/logo.jpg\" alt=\"Logo\"></a></figure>
		<table>
		    <tr>
		        <td>
                    <h1>Welcome to the forum!</h1>
                </td>
                <td>
		            <form id=\"form1\" action=\"loginRedirect.php\" method=\"POST\" onsubmit=\"return checkLogin()\">
			            <div>
				            <label>Username:</label>
				            <input id=\"username\" type=\"text\" name=\"username\">
			            </div>
			            <div>
				            <label>Password:</label>
				            <input id=\"password\" type=\"password\" name=\"password\">
			            </div>
			            <div>
				            <input id=\"login\" type=\"submit\" value=\"Login\">
				            <a href=\"createUser.php\" id=\"createUser\">Create User</a>
			            </div>
			            <div><p id=\"loginMessage\"></p></div>
		            </form>
                </td>
            </tr>
        </table>
	</header>
	";

    }
    else
    {
        $username = $_SESSION["loggedIn"];
        $hasUnreadMessages = $_SESSION["hasUnreadMessages"];
        echo"
        <header>
        <figure><a href=\"index.php\"><img src=\"images/logo.jpg\" alt=\"Logo\"></a></figure>
        <div>
            <h1>Welcome to the forum!</h1>
                <table id=\"userPane\">
                    <tr>
                        <td><h2 id=\"user\">$username</h2></td>
                        <td><a href=\"pm.php?p=1\">
                        ";
                        if($hasUnreadMessages == 1)
                            echo"<img class=\"iconImg\" src=\"images/pmUnread.jpg\" alt=\"PM\">";
                        else
                            echo"<img class=\"iconImg\" src=\"images/pm.jpg\" alt=\"PM\">";
                        echo"
                            </a>
                        </td>
                        <td><a href=\"settings.php\"><img class=\"iconImg\" src=\"images/settings.jpg\" alt=\"Settings\"></a></td>
                        <td><a href=\"logOutRedirect.php\" id=\"logOut\">Logout</a></td>
                    </tr>
                </table>
            </div>
        </header>
        ";
    }
}

function footer() //setter standard footer på forumet.
{
    include_once "database.php";
    $connection2 = connect();

    $sql = "SELECT COUNT(*) AS totalThreads FROM Thread";
    $query = mysqli_query($connection2, $sql);
    $row = mysqli_fetch_array($query);
    $totalThreads = $row['totalThreads'];

    $sql2 = "SELECT COUNT(*) AS totalPosts FROM Post";
    $query2 = mysqli_query($connection2, $sql2);
    $row2 = mysqli_fetch_array($query2);
    $totalPosts = $row2['totalPosts'];

    $sql3 = "SELECT COUNT(*) AS totalUsers FROM User";
    $query3 = mysqli_query($connection2, $sql3);
    $row3 = mysqli_fetch_array($query3);
    $totalUsers = $row3['totalUsers'];

    echo "
    <footer>
        <div>
            <div class='footer'><p>Total threads: $totalThreads,&nbsp;&nbsp; total posts: $totalPosts,&nbsp;&nbsp; total members: $totalUsers</p></div>
            <div class='footer'><a onclick='goToTop()'>&uarr;<br>go to top</a></div>
            <div class='leftFooter'><h4>Copyright</h4><p>Håkon Mølstre<br>Elise Kristiansen<br>Håvard Torp Helmersen<p></div>
            <div class='rightFooter'><h4><a href='pm.php?p=1'>Site administrators<br>and members&nbsp;&nbsp;&nbsp;</a></h4></div>
            
            <div class='bottomFooter'><p>All times are CEST +1</p></div>
        </div>
        
    </footer>
    </html>
    ";
}