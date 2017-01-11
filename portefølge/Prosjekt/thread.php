<?php
include "functions.php";
include "database.php";
head();
headers();

$cat = $_GET['cat'];
$subcat = $_GET['subcat'];

$connection = connect(); //database tilkobling
$t = $_GET['t'];
$p = $_GET['p'];
$sql = "SELECT * FROM Thread WHERE name = '$t'"; //henter tråd informasjon
$query = mysqli_query($connection, $sql);

$firstPost = mysqli_fetch_array($query);
$by = $firstPost['Users_username'];
$date = $firstPost['date'];
$post = $firstPost['post'];
$edited = $firstPost['last_edited'];

$avatar = ""; //setter avatar bilde
if(file_exists("images/uploads/$by.png"))
    $avatar = "images/uploads/$by.png";
else
    $avatar = "images/genericAvatar.jpg";

if ($edited != $date){ //setter om last changed dukker opp
    $edited = "last changed: " . $edited;
}
else {
    $edited = "";
}
//setter om du kan edite tråden utifra om du lagde tråden eller om du er admin, hvis du er admin kan du også slette tråden
if (isset($_SESSION["loggedIn"]) && ($_SESSION["loggedIn"] == "$by" || $_SESSION["admin"])){ //setter om du kan edite tråden utifra om du lagdte tråden eller om du er admin
    $edit = "<a href='edit.php?cat=$cat&subcat=$subcat&type=thread&t=$t'>Edit</a>";
    if ($_SESSION["admin"]){
        $edit .= "  <a href='deletethread.php?cat=$cat&subcat=$subcat&type=thread&t=$t&p=1'>Slett</a>";
    }
}
else {
    $edit = "";
}

$sql = "SELECT * FROM Post WHERE '$t' = Thread_name ORDER BY date"; //henter tilhørende poster
$query = mysqli_query($connection, $sql);
//genererer sidetall
$rowCount = mysqli_num_rows($query);
$lastpage = $rowCount/10+1;
$lp = $lastpage+0.1;
settype($lp,"int");
settype($lastpage,"int");

$pagesstring = "";

if ($p > 1){
    $temp = $p-1;
    $pagesstring .= "<a href='thread.php?cat=$cat&subcat=$subcat&t=$t&p=$temp'>prev</a>|";
}
$teller = 1;
while ($teller <= $lastpage){
    if ($teller == $p){
        $pagesstring .= "|$teller|";
    }
    else if ($teller < 3) {
        $pagesstring .= "|<a href='thread.php?cat=$cat&subcat=$subcat&t=$t&p=$teller'>$teller</a>|";
    }
    else if ($teller > $lastpage-2) {
        $pagesstring .= "|<a href='thread.php?cat=$cat&subcat=$subcat&t=$t&p=$teller'>$teller</a>|";
    }
    else if ($teller < $p+3 && $teller > $p-3){
        $pagesstring .= "|<a href='thread.php?cat=$cat&subcat=$subcat&t=$t&p=$teller'>$teller</a>|";
    }
    $teller++;
}
if ($p < $lastpage){
    $temp = $p+1;
    $pagesstring .= "<a href='thread.php?cat=$cat&subcat=$subcat&t=$t&p=$temp'>next</a>|";
}
//skript delen gjør at new post knappen får create post delen av siden til å vise seg og scroller ned siden
echo"
<main>
<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js\"></script>
<script src=\"//cdn.jsdelivr.net/jquery.scrollto/2.1.2/jquery.scrollTo.min.js\"></script>
<script>
$(document).ready(function(){

    $(\".post\").click(function(){
        $(\"#newpost\").show();
        $.scrollTo(document.getElementById('newpost'));
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
                    <a href=\"category.php?cat=$cat\"><Label>$cat</Label></a>
                </td>
                <td>
                     <label><b>&rarr;</b></label>
                </td>
                <td>
                    <a href=\"subcategory.php?cat=$cat&subcat=$subcat&page=1\"><Label>$subcat</Label></a>
                </td>
                <td>
                     <label><b>&rarr;</b></label>
                </td>
                <td>
                    <Label><a href='thread.php?cat=$cat&subcat=$subcat&t=$t&p=1'>$t</a></Label>
                </td>
            </tr>
	    </table>
	</div>
	";

echo"
    <div class='category'><h2>$t</h2>
        <div class='forumpostersiden'>";
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] != "") {
            echo "<button class='post' type = 'button' value = 'Reply' > Reply</button >";
        }
        echo " <pre class='pagestring' > $pagesstring</pre >
            <table> 
                <tbody>
                    <tr>
                        <td class='threadDate'>
                            <Label>$date</Label>
                        </td>
                        <td>
                            <Label></Label>
                        </td>
                    </tr>
                    <tr>
                        <td class='threadUser'>
                            <h3>$by</h3><img src='$avatar'>
                        </td>
                        <td class='threadPost'>
                            <div><p>$post</p></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>$edit</div>
                        </td>
                        <td>
                            <div>$edited</div>
                        </td>

                    </tr>
                </tbody>
            </table>
            
";


// hopper over poster til du er på rett side
$teller = 0;
while($teller/10 < $p-1){
    $row = mysqli_fetch_array($query);
    $teller++;
}
// skriver ut poster for siden
while ($row = mysqli_fetch_array($query)) {
    $by = $row['User_username'];
    if ($by == null){ //sql resultatet inneholdt en row som bare var null på slutten
        break;
    }
    $date = $row['date'];
    $post = $row['post'];
    $number = $row['postNr'];
    $edited = $row['last_edited'];

    $avatar = ""; //setter avatar bilde
    if(file_exists("images/uploads/$by.png"))
        $avatar = "images/uploads/$by.png";
    else
        $avatar = "images/genericAvatar.jpg";

    if ($edited != $date){ //setter om last changed dukker opp
        $edited = "last changed: " . $edited;
    }
    else {
        $edited = "";
    }
    //setter om du kan edite posten utifra om du lagde posten eller om du er admin, hvis du er admin kan du også slette posten
    if (isset($_SESSION["loggedIn"]) && ($_SESSION["loggedIn"] == "$by" || $_SESSION["admin"])){
        $edit = "<a href='edit.php?cat=$cat&subcat=$subcat&type=post&t=$t&nr=$number&p=$p'>Edit</a>";
        if ($_SESSION["admin"]){
            $edit .= "  <a href='deletepost.php?cat=$cat&subcat=$subcat&t=$t&nr=$number&p=$p'>Slett</a>";
        }
    }
    else {
        $edit = "";
    }

    echo "
            <table>
                <tbody>
                    <tr>
                        <td class='threadDate'>
                            <Label>$date</Label>
                        </td>
                        <td>
                            <Label></Label>
                        </td>
                    </tr>
                    <tr>
                        <td class='threadUser'>
                            <h3>$by</h3><img src='$avatar'>
                        </td>
                        <td class='threadPost'>
                            <div><p>$post</p></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>$edit</div>
                        </td>
                        <td>
                            <div>$edited</div>
                        </td>

                    </tr>
                </tbody>
            </table>
            ";
    if ($teller/10 == $p){
        break;
    }
    $teller++;
}

if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] != "") {
    echo "<button class='post' type = 'button' value = 'Reply' > Reply</button >";
}
// create post delen er gjemt fram til new post knappen blir trykt på
echo " <pre class='pagestring' > $pagesstring</pre >
            <form class='form' name='form2' action='createPostRedirect.php' method='POST'>
            <table id='newpost' style='display: none'>
                <tbody>
                    <tr>
                        <td>
                            <textarea name='text'></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td><input id='reply' type='submit' value='Post'></td>
                    </tr>
                </tbody>
                <input type='hidden' name='thread' value='$t'>
                <input type='hidden' name='lastpage' value='$lp'>
                <input name='cat' type='hidden' value='$cat'>
                <input name='subcat' type='hidden' value='$subcat'>
            </table>
            </form>
        </div>
    </div>
</main>
";
footer();