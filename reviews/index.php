<?php
// This is the reviews controller

// Start a session
session_start();

// Get the reviews model
require_once "../model/reviews-model.php";
// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the vehicles model
require_once '../model/vehicles-model.php';
//  Get the functions library
require_once '../library/functions.php';
// Get the uploads model
require_once '../model/uploads-model.php';

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

$action = filter_input(INPUT_POST, 'action');

if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}


switch ($action) {
    case 'add-review':
        // Get details from the review form
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reviewText = filter_input(INPUT_POST, 'writeReview', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // check if review text field is empty 
        if (empty($reviewText)) {
            $message = "<p class='notice'>Type a review before submitting. <span class='close-notice'>X</span></p>";
            // Load the page content
            $vehicle = getVehicleByInvId($invId);
            $thumbnailsArray = getThumbnailByVehicleId($invId);
            $thumbnails = buildThumbnails($thumbnailsArray);
            $formattedPrice = number_format($vehicle['invPrice']);
            $vehicleDetailsDisplay = buildVehicleDetailsDisplay($vehicle, $formattedPrice);
            $reviews = getReviewsByInvId($invId);
            if ($reviews) {
                $reviewsHTML = displayReviews($reviews);
            } else {
                $reviewsHTML = "<p class='notice'>Be the first to write a review.</p>";
            }
            include '../view/vehicle-detail.php';
            exit;
        }
        
        $addReview = addReview($invId, $clientId, $reviewText);
        if (!$addReview) {
            $message = "<p class='notice'>Review not added. Try again. <span class='close-notice'>X</span></p>";
            // Load the page content
            $vehicle = getVehicleByInvId($invId);
            $thumbnailsArray = getThumbnailByVehicleId($invId);
            $thumbnails = buildThumbnails($thumbnailsArray);
            $formattedPrice = number_format($vehicle['invPrice']);
            $vehicleDetailsDisplay = buildVehicleDetailsDisplay($vehicle, $formattedPrice);
            $reviews = getReviewsByInvId($invId);
            if ($reviews) {
                $reviewsHTML = displayReviews($reviews);
            } else {
                $reviewsHTML = "<p class='notice be-first'>Be the first to write a review.<span class='close-notice'>X</span></p>";
            }
            include '../view/vehicle-detail.php';
        } else {
            $_SESSION['message'] = "<p class='notice'>Review added. Thanks for your review.<span class='close-notice'>X</span></p>";
        }

        // Load the page content
        $vehicle = getVehicleByInvId($invId);
        $thumbnailsArray = getThumbnailByVehicleId($invId);
        $thumbnails = buildThumbnails($thumbnailsArray);
        $formattedPrice = number_format($vehicle['invPrice']);
        $vehicleDetailsDisplay = buildVehicleDetailsDisplay($vehicle, $formattedPrice);
        $reviews = getReviewsByInvId($invId);
        if ($reviews) {
            $reviewsHTML = displayReviews($reviews);
        } else {
            $reviewsHTML = "<p class='notice'>Be the first to write a review</p>";
        }
        header("location: /phpmotors/vehicles/?action=vehicleDetails&invId=$invId#reviews");
        break;

    case 'edit-review':
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['aClientReview'] = getReviewsByReviewId($reviewId);
        if (!(count($_SESSION['aClientReview']))) {
            $message = "<p class='notice'>Review not found.<span class='close-notice'>X</span></p>";
            include '../view/admin.php';
            exit;
        }
        include '../view/update-review.php';
        break;

    case 'submit-edit-review':
        // $clientReviews = getReviewsByReviewId($reviewId);
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reviewText = filter_input(INPUT_POST, 'update-review', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // exit;
        if (empty($reviewText)) {
            $message = "<p class='notice'>Write a review before submitting. <span class='close-notice'>X</span></p>";
            include '../view/update-review.php';
            exit;
        }
        $updatedReview = updateReview($reviewId, $reviewText);
        if ($updatedReview === false) {
            $message = "<p class='notice'>Update failed. Try again. <span class='close-notice'>X</span></p>";
            include '../view/update-review.php';
            exit;
        }elseif (($updatedReview === 0)) {
            $_SESSION['message'] = "<p class='notice'> No new changes made to your review on " . $_SESSION['aClientReview'][0]['invMake'] . " " .
            $_SESSION['aClientReview'][0]['invModel'] . ".<span class='close-notice'>X</span></p>";                  
        } else {
            $_SESSION['message'] = "<p class='notice'> Review on " . $_SESSION['aClientReview'][0]['invMake'] . " " .
            $_SESSION['aClientReview'][0]['invModel'] . " updated successfully.<span class='close-notice'>X</span></p>";    
        }
        $_SESSION['aClientReview'] = getReviewsByReviewId($reviewId);
       header('location: /phpmotors/reviews/');
        break;

    case 'delete-review':
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $_SESSION['clientReviews'] = getReviewsByReviewId($reviewId);
        // check if review is not found and deliver the error page
        if(!$_SESSION['clientReviews'][0]) {
            header('location: /phpmotors/view/500.php');
        }
        // $clientReviews = getReviewsByClientId($_SESSION['clientData']['clientId']);
        // $clientReviewsHtml = displayClientReviews($clientReviews);
        include '../view/delete-review.php';
        break;
    case 'submit-delete-review':
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $deletedReview = deleteReview($reviewId);
        if (!$deletedReview) {
            $message = "<p class='notice'>Delete failed. Try again.<span class='close-notice'>X</span></p>";
            include '../view/delete-review.php';
            exit;
        }

        $_SESSION['message'] = "<p class='notice'>Review on " . $_SESSION['clientReviews'][0]['invMake']
            . " " . $_SESSION['clientReviews'][0]['invModel'] . " Deleted.<span class='close-notice'>X</span></p>";
        // load reviews by loggedin client
        header('location: /phpmotors/reviews/');
        break;
    default:

        if ($_SESSION['loggedin']) {
            include '../view/admin.php';
        } else {
            header('location: /phpmotors/');
        }
        break;
}
