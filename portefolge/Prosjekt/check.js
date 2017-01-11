// Scroll til toppen
function goToTop()
{
    window.scrollTo(500, 0);
}

// Tekstboks med defaultverdi påkaller denne metoden for å cleare verdien
function clearContents(element) {
    if(element.value == 'Write your message here')
        element.value = '';
}

// Viser 1. paramter, gjemmer 2. paramterer
function showElement(show, hide) {
    document.getElementById(show).style.display = 'block';
    document.getElementById(hide).style.display = 'none';
}

// Viser 1. parameter, gjemmer 2. og 3. paramter, og gjemmer 4. paramterer som
// påkalles med Class tags som må gås gjennom i løkke for å endre
function showElements(show, hide1, hide2, link) {
    document.getElementById(show).style.display = 'block';
    document.getElementById(hide1).style.display = 'none';
    document.getElementById(hide2).style.display = 'none';
    var links = document.getElementsByClassName(link);

    var i = links.length;

    while(i--) {
        links[i].style.display = 'none';
    }
}

// Gir 1. paramterer verdi tilsvarende 2. parameter
function editElement(element, value) {

    document.getElementById(element).value = value;
}

function checkCreateUser()
{
    var username = document.getElementById('name').value;
    var mail = document.getElementById('mail').value;
    var age = document.getElementById('age').value;
    var password1 = document.getElementById('password1').value;
    var password2 = document.getElementById('password2').value;

    var error = "";

    // Ingen felt tomme
    if(username == "" || mail == "" || age == "" || password1 == "" || password2 == "")
        error += "Fill all fields<br>";

    // Brukernavn mellom 2-15 i lengde
    if(username.length < 2 || username.length > 15)
    {
        error += "Name must be between 2 and 15 in length<br>";
    }

    // Må inneholde noe tekst
    if(!isNaN(username))
     {
        error += "name must contain letters<br>";
     }

    // Kalle på funskjon som sjekker inntastet mail
    if(!isMail(mail))
        error += "Invalid mail<br>";

    // Alder må være et tall
    if(isNaN(age))
        error += "Age must be a number<br>";
        // Gyldig inntastet tall
    else if(!(age >= 18) || !(age <= 120))
        error += "Must be at least 18 years old<br>";

    // Passordlengde mellom 6 og 20
    if(password1.length < 6 || password1.length > 20)
        error += "Password must be between 6 and 20 in length<br>";

    // Passordene må være like
    if(password1 != password2)
        error += "Both passwords must match<br>";

    // Er ikke errorvariabelen tom, skriv ut melding og return false
    if(error != "")
    {
        var message = document.getElementById('message');
        message.innerHTML = error;
        return false;
    }
    else
        return true;
}

// Mail - Krever tekst etterfulgt av alfakrøll, tekst igjen, punktum, og minst 2 tegn til. Oppgis ingen parameter, brukes id taggen newemail
function isMail(value)
{
    if(value == null)
        value = document.getElementById('newemail').value;
    var pattern = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    return pattern.test(value);
}

// Legger til tekst i html tagget mens innlogging pågår
function checkLogin()
{
    var loginMessage = document.getElementById('loginMessage');
    loginMessage.innerHTML = "Logging in...";
    return true;
}