<?php

include_once 'src/PeselValidator.php';

function returnWithMessage($type, $message)
{
    session_start();
    $_SESSION['message']['type'] = $type;
    $_SESSION['message']['content'] = $message;
    header("Location: index.php");
    die();
}

//get pesel from form and pass to validation
if (isset($_POST['peselSubmit']) && !empty($_POST['pesel'])) {

    $validator = new PeselValidator();
    $isPeselValid = $validator->isValid($_POST['pesel']);

    if ($isPeselValid) {
        returnWithMessage('success', 'Pesel poprawny');
    } else {
        returnWithMessage('error', 'Pesel niepoprawny');
    }
} else {
    returnWithMessage('error', 'Wprowadź PESEL');
}
