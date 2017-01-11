<?php
include "functions.php";
head();
headers();

echo"
<main>
    <div>
	    <table>
            <tr>
                <td>
                    <a href=\"index.php\"><img class=\"iconImg\" src=\"images/home.jpg\" alt=\"Home\"></a>
                </td>
                <td>
                     <label>&rarr;</label>
                </td>
                <td>
                    <label><a href=\"createUser.php\">Create new user</a></label>
                </td>
            </tr>
	    </table>
	</div>
    <div><h4>Fill your information in the form below.</h4></div>
    <div id=\"newUserForm\">
    <div><p id=\"message\">Click the button when ready.</p></div>
        <form class=\"form\" name=\"form2\" action=\"createUserRedirect.php\" method=\"POST\" onsubmit=\"return checkCreateUser()\">

            <div class=\"field\">
                <Label class=\"textField\">Username:</Label><input type=\"text\" name=\"name\" id=\"name\">
            </div>

            <div class=\"field\">
                <Label class=\"textField\">Mail:</Label><input type=\"text\" name=\"mail\" id=\"mail\">
            </div>

            <div class=\"field\">
                <Label class=\"textField\">Age:</Label><input type=\"text\" name=\"age\" id=\"age\">
            </div>

            <div class=\"field\">
                <Label class=\"textField\">Password:</Label><input type=\"password\" name=\"password1\" id=\"password1\">
            </div>

            <div class=\"field\">
                <Label class=\"textField\">Repeat password:</Label><input type=\"password\" name=\"password2\" id=\"password2\">
            </div>
            <br>
            <br>
            <div class=\"bottom\">
                <input id=\"submit\" type=\"submit\" value=\"Create user\">
            </div>
        </form>
    </div>
</main>
";

footer();
?>