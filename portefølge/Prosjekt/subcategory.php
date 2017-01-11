<?php
include "functions.php";
include "database.php";
head();
headers();

$connection = connect(); //database tilkobling
$catName = $_GET['cat'];
$subcat = $_GET['subcat'];
$page = $_GET['page'];
$sql = "SELECT * FROM Subcategory WHERE name = '$subcat'"; //henter subkategorier
$query = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($query);
$desc = $row['description'];

$sql = "SELECT * FROM Thread WHERE '$subcat' = Subcategory_name ORDER BY last_post DESC"; //henter tråder som hører til subkategori, sortert på sist post
$query = mysqli_query($connection, $sql);
// genererer sidetall
$rowCount = mysqli_num_rows($query);
$lastpage = $rowCount/10+1;
settype($lastpage,"int");

$pagesstring = "";

if ($page > 1){
    $temp = $page-1;
    $pagesstring .= "<a href='subcategory.php?cat=$catName&subcat=$subcat&page=$temp'>prev</a>|";
}
$teller = 1;
while ($teller <= $lastpage){
    if ($teller == $page){
        $pagesstring .= "|$teller|";
    }
    else if ($teller < 3) {
        $pagesstring .= "|<a href='subcategory.php?cat=$catName&subcat=$subcat&page=$teller'>$teller</a>|";
    }
    else if ($teller > $lastpage-2) {
        $pagesstring .= "|<a href='subcategory.php?cat=$catName&subcat=$subcat&page=$teller'>$teller</a>|";
    }
    else if ($teller < $page+3 && $teller > $page-3){
        $pagesstring .= "|<a href='subcategory.php?cat=$catName&subcat=$subcat&page=$teller'>$teller</a>|";
    }
    $teller++;
}
if ($page < $lastpage){
    $temp = $page+1;
    $pagesstring .= "<a href='subcategory.php?cat=$catName&subcat=$subcat&page=$temp'>next</a>|";
}
//skript delen gjør at new thread knappen får create thread delen av siden til å vise seg og scroller ned siden
echo "

<main>
<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js\"></script>
<script src=\"//cdn.jsdelivr.net/jquery.scrollto/2.1.2/jquery.scrollTo.min.js\"></script>
<script>
$(document).ready(function(){

    $(\".nthread\").click(function(){
        $(\"#newthread\").show();
        $.scrollTo(document.getElementById('newthread'));
    });
});
</script>
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
                    <Label><a href=\"category.php?cat=$catName\">$catName</a></Label>
                </td>
                <td>
                     <label><b>&rarr;</b></label>
                </td>
                <td>
                    <Label><a href=\"subcategory.php?cat=$catName&subcat=$subcat&page=1\">$subcat</a></Label>
                </td>
            </tr>
	    </table>
	</div>


     <div class='category'><h2>$subcat</h2>
     <p>$desc</p>";
    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] != ""){ //hvis du er logget inn kan du lage nye tråder
        echo"<button class='nthread' type='button'>New Thread</button> ";
    }
        echo "<pre class='pagestring'>$pagesstring</pre>
           <div class='forum'>
            <table>
			  <tr>
			    <th class='thread'><label>Title</label></th>
			    <th class='last'><label>Author</label></th>
			    <th class='date'><label>Last post</label></th>
			  </tr>
";
// hopper over tråder til du er på rett side
$teller = 0;
while($teller/10 < $page-1){
    $row = mysqli_fetch_array($query);
    $teller++;
}
// skriver ut tråder for siden
while ($row = mysqli_fetch_array($query)) {
    $threadName = $row['name'];
    $lastPostDate = $row['date'];
    $user = $row['Users_username'];

    echo "
        <tr>
            <td><a href='thread.php?cat=$catName&subcat=$subcat&t=$threadName&p=1'>$threadName</a></td>
            <td><p><a href='thread.php?cat=$catName&subcat=$subcat&t=$threadName&p=1'>$user</a></p></td> 
            <td><p>$lastPostDate</p></td>
        </tr>
    ";
    if ($teller/10 == $page){ // 10 tråder per side
        break;
    }
    $teller++;
    }

    echo"
			</table>
        </div>
        ";
if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] != ""){ //hvis du er logget inn kan du lage nye tråder
        echo"<button class='nthread' type='button'>New Thread</button> ";
    }
        echo"
    </div>";
    // create thread delen av sida er gjemt fram til new thread knappen er trykt
    echo" <pre class='pagestring'>$pagesstring</pre>
    <form class='form' name='form2' action='createThreadRedirect.php' method='POST'>
        <table id='newthread' style='display: none'>
                <tbody>
                    <tr>
                        <td>
                            <label>Thread name: </label><input name='thread' id='thread' type='text'>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <textarea name='text' id='text' rows='15' cols='90'></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td><input id='submit' type='submit' value='Create thread'></td>
                    </tr>
                </tbody>
        </table>
        <input name='subcat' type='hidden' value='$subcat'>
        <input name='cat' type='hidden' value='$catName'>
     </form>
</main>
";

footer();