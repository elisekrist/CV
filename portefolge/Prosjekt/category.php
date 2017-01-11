<?php
include "functions.php";
include "database.php";
head();
headers();

$connection = connect(); //kobler til database
$catName = $_GET['cat'];
$sql = "SELECT * FROM Category WHERE name = '$catName'";   //henter kategori beskrivelse fra database
$query = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($query);
$desc = $row['description'];

$sql = "SELECT * FROM Subcategory WHERE '$catName' = Category_name"; //henter subkategorier som hører til kategorien
$query = mysqli_query($connection, $sql);



echo "

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
                    <Label><a href=\"category.php?cat=$catName\">$catName</a></Label>
                </td>
            </tr>
	    </table>
	</div>

     <div class='category'><h2>$catName</h2>
     <p class='desc1'>$desc</p>";

    while ($row = mysqli_fetch_array($query)) { //henter ut subkategori en og en og skriver dem ut
        $subCatName = $row['name'];
        $desc = $row['description'];

        echo "<div class='subcategory'><a href='subcategory.php?cat=$catName&subcat=$subCatName&page=1'><h3>$subCatName</h3></a>
            <p class='desc2'>$desc</p>";


        echo "
            <div class='cat-forum'>
            <table>
            <tr>
			    <th class='thread'><label>Title</label></th>
			    <th class='last'><label>Author</label></th>
			    <th class='date'><label>Date</label></th>
            </tr>
        ";

        $sql2 = "SELECT * FROM Thread WHERE '$subCatName' = Subcategory_name ORDER BY last_post DESC";
        $query2 = mysqli_query($connection, $sql2);

        $teller = 0;

        while ($row2 = mysqli_fetch_array($query2)) { //skriver ut 5 første trådene i subkategorien
            $threadName = $row2['name'];
            $lastPostDate = $row2['date'];
            $user = $row2['Users_username'];

            echo "
                <tr>
                    <td><a href='thread.php?cat=$catName&subcat=$subCatName&t=$threadName&p=1'>$threadName</a></td>
                    <td class='last'><p><a href='thread.php?cat=$catName&subcat=$subCatName&t=$threadName&p=1'>$user</a></p></td> 
                    <td class='date'><p>$lastPostDate</p></td>
                </tr>
            ";

            $teller++;
            if ($teller > 4) {
                break;
            }
        }
        echo"</table></div></div>";
    }
    echo"</div></main>";

footer();