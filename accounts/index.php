<?php

// Create or access a Session
session_start();

// This is the accounts controller

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the functions library
require_once '../library/functions.php';
// Get the reviews model
require_once "../model/reviews-model.php";


// Get the array of classifications
$classifications = getClassifications();
// Build a navigation bar using the $classifications array
$navList = '<ul>';
$navList .= "<li><a href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";
foreach ($classifications as $classification) {
    $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName="
        . urlencode($classification['classificationName']) . "' title='View our $classification[classificationName]
 product line'>$classification[classificationName]</a></li>";
}
$navList .= '</ul>';

// var_dump($classifications);
// 	exit;

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}


switch ($action) {
    case 'register':
        // Filter and store the data
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        $existingEmail = checkExistingEmail($clientEmail);

        // Check for existing email address in the table
        if ($existingEmail) {
            $_SESSION['message'] = '<p class="notice">That email address already exists. Do you want to login instead? <span class="close-notice">X</span></p>';
            include '../view/login.php';
            exit;
        }
        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
            $_SESSION['message'] = '<p class="notice">Please provide information for all empty form fields. <span class="close-notice">X</span></p>';
            include '../view/registration.php';
            exit;
        }

        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        // Send the data to the model
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

        // Check and report the result
        if ($regOutcome === 1) {
            // setcookie('clientFirstname', $clientFirstname, strtotime('+1 year'), '/');
            $_SESSION['message'] = "<p class='notice'>Thanks for registering $clientFirstname. Please use your email and password to login.<span class='close-notice' >X</span></p>";
            header('Location: /phpmotors/accounts/?action=login');

            exit;
        } else {
            $_SESSION['message'] = "<p class='notice'>Sorry $clientFirstname, but the registration failed. Please try again.<span class='close-notice'>X</span></p>";
            include '../view/registration.php';
            exit;
        }
        break;

    case 'Login':
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        // Check for missing data
        if (empty($clientEmail) || empty($checkPassword)) {
            $_SESSION['message'] = '<p class="notice">Please provide information for all empty form fields.<span class="close-notice">X</span></p>';
            include '../view/login.php';
            echo $clientEmail;
            exit;
        }

        // Query the client data based on the email address
        $clientData = getClient($clientEmail);
        // check if user has not registered then redirect to the resgistration view
        if (!$clientData) {
            $_SESSION['message'] = '<p class="notice">An account does not exist for this email. Do you want to register instead? <span class="close-notice">X</span></p>';
            include '../view/login.php';
            exit;
        }

        // Compare the password just submitted against
        // the hashed password for the matching client
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        // If the hashes don't match create an error
        // and return to the login view
        if (!$hashCheck) {
            $_SESSION['message'] = '<p class="notice">Please check your password and try again.<span class="close-notice">X</span></p>';
            include '../view/login.php';
            exit;
        }
        // A valid user exists, log them in
        $_SESSION['loggedin'] = TRUE;
        // Remove the password from the array
        // the array_pop function removes the last
        // element from an array
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;

        if (isset($_SESSION['page-tracker'])) {
            $redirect = $_SESSION['page-tracker'];
            header("location: $redirect");
            exit;
        }

        // load reviews by loggedin client
        $clientReviews = getReviewsByClientId($_SESSION['clientData']['clientId']);
        $clientReviewsHtml = displayClientReviews($clientReviews);

        // Send them to the admin view
        include '../view/admin.php';
        exit;
        break;
    case 'login':
        include '../view/login.php';
        break;

    case 'logout':
        session_destroy();
        header('location: /phpmotors/');
    case 'registration':
        include '../view/registration.php';
        break;

    case 'updateInfo':
        // Filter and store the data
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientEmail =

            $clientEmail = checkEmail($clientEmail);


        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)) {
            $_SESSION['message'] = '<p class="notice">Please provide information for all empty form fields.<span class="close-notice">X</span></p>';
            include '../view/client-update.php';
            exit;
        }

        // check if entered email is different from one in session
        if ($clientEmail != $_SESSION['clientData']['clientEmail']) {
            $existingEmail = checkExistingEmail($clientEmail);
            if ($existingEmail) {
                $_SESSION['mesage'] = '<p class="notice">An account already exists for this email.<span class="close-notice">X</span></p>';
                include '../view/client-update.php';
                exit;
            }
        }

        $updateOutcome = updateClientdata($clientFirstname, $clientLastname, $clientEmail, $clientId);
        if ($updateOutcome) {

            $clientData = getClientById($clientId);
            $_SESSION['clientData'] = $clientData;
            $_SESSION['message'] = '<p>Account updated successfully.</p>';
            header('location: /phpmotors/accounts/');
            exit;
        } else {
            $_SESSION['message'] = '<p class="notice">Something went wrong. Please try again.<span class="close-notice">X</span></p>';
            include '../view/client-update.php';
            exit;
        }
        break;
    case 'updatePassword':
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        // Check for missing data
        if (empty($clientPassword)) {
            $_SESSION['pass_fail_message'] = '<p class="notice">Please provide information for all empty form fields.<span class="close-notice">X</span></p>';
            include '../view/client-update.php';
            exit;
        }
        $checkPassword = checkPassword($clientPassword);
        if (!$checkPassword) {
            $_SESSION['pass_fail_message'] = '<p class="notice">Please match the required password pattern.<span class="close-notice">X</span></p>';
            include '../view/client-update.php';
            exit;
        }
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
        $updatePasswordOutcome = updatePassword($clientId, $hashedPassword);
        if ($updatePasswordOutcome) {
            $clientData = getClientById($clientId);
            $_SESSION['clientData'] = $clientData;
            $_SESSION['message'] = '<p class="notice">Password updated successfully.<span class="close-notice">X</span></p>';
            header('location: /phpmotors/accounts/');
            exit;
        }
        break;
    case 'client-update':
        include '../view/client-update.php';
        break;
    default:
        // load reviews by loggedin client
        $clientReviews = getReviewsByClientId($_SESSION['clientData']['clientId']);
        $clientReviewsHtml = displayClientReviews($clientReviews);
        include '../view/admin.php';
        break;
}
