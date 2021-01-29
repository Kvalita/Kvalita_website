<?php
if (isset($_POST['Email'])) {

    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "erik.beijleveld@kvalita.nl";
    $email_subject = "Contact formulier ingevuld via de website";

    function problem($error)
    {
        echo "Sorry, maar niet alle velden zijn ingevuld.";
        echo "Deze errors verschijnen hieronder.<br><br>";
        echo $error . "<br><br>";
        echo "Ga terug en probeer het opnieuw<br><br>";
        die();
    }

    // validation expected data exists
    if (
        !isset($_POST['Voornaam']) ||
        !isset($_POST['Achternaam']) ||
        !isset($_POST['Email']) ||
        !isset($_POST['Uw bericht'])
    ) {
        problem('Sorry, maar niet alle velden zijn ingevuld');
    }

    $Voornaam = $_POST['Voornaam']; // required
    $Achternaam = $_POST['Achternaam']; // required
    $Email = $_POST['Email']; // required
    $Uw_Bericht = $_POST['Uw Bericht']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $Email)) {
        $error_message .= 'Je emailadres is niet volledig.<br>';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $Voornaam)) {
        $error_message .= 'De naam die je hebt ingevoerd voldoet niet aan de eisen.<br>';
    }

    if (strlen($Uw_Bericht) < 2) {
        $error_message .= 'Het bericht die je hebt ingevuld voldoet niet aan de eisen.<br>';
    }

    if (strlen($error_message) > 0) {
        problem($error_message);
    }

    $email_message = "Form details below.\n\n";

    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $email_message .= "Name: " . clean_string($name) . "\n";
    $email_message .= "Email: " . clean_string($email) . "\n";
    $email_message .= "Message: " . clean_string($message) . "\n";

    // create email headers
    $headers = 'From: ' . $email . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);
?>

    <!-- include your success message below -->

    Bedankt voor je bericht. Je zal snel van ons horen.

<?php
}
?>