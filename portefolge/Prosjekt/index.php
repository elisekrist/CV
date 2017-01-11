<?php
include "functions.php";
include "database.php";
head();
headers();

$connection = connect(); //database tilkobling
$sql = "SELECT * FROM Category";
$query = mysqli_query($connection, $sql);

echo"
<main>
	<div>
	    <table>
            <tr>
                <td>
                    <a href=\"index.php\"><img class=\"iconImg\" src=\"images/home.jpg\" alt=\"Home\"></a>
                </td>
                <td>
            </tr>
	    </table>
	</div>
";

while ($row = mysqli_fetch_array($query)) { //henter kategorier
    $catName = $row['name'];
    $desc = $row['description'];
    
    echo "<div class=\"category\"><h2><a href='category.php?cat=$catName'>$catName</a></h2>
            <p class='desc1'>$desc</p>";

    $sql2 = "SELECT * FROM Subcategory WHERE Category_name = '$catName'";
    $query2 = mysqli_query($connection, $sql2);

    while ($row2 = mysqli_fetch_array($query2)) { //henter subkategorier
        $subCatName = $row2['name'];
        $subCatDescription = $row2['description'];

        echo "<div class='article'><section><h3><a href='subcategory.php?cat=$catName&subcat=$subCatName&page=1'>$subCatName</a></h3><p class='desc2'>$subCatDescription</p></section>";

        $sql3 = "SELECT * FROM Thread WHERE '$subCatName' = Subcategory_name ORDER BY last_post DESC";
        $query3 = mysqli_query($connection, $sql3);

        $row3 = mysqli_fetch_array($query3);
        $threadName = $row3['name'];
        $lastPost = $row3['last_post'];
        $user = $row3['Users_username'];

        echo "<aside><p><a href='thread.php?cat=$catName&subcat=$subCatName&t=$threadName&p=1'>$threadName</a> last posted: $lastPost<br>user: $user</p></aside></div>";
    }
    echo"
    </div>
    ";
}

echo"
</main>
";

footer();