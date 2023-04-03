<?php
// Create or access a Session
session_start();

// This code keeps track of the users current page.
// This allows us to easily direct user to the page they were 
// viewing incase they decide to login.
// An example is when the user is on the vehicle details veiw.
// If he wants to write the review, the user will have to login to do so.
// to make sure the user is taken back to that review page after loggin in,
// this code comes into to allow that happen.
$_SESSION['page-tracker'] = $_SERVER['REQUEST_URI'];


// This is the vehicles controller

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the vehicles model
require_once '../model/vehicles-model.php';
//  Get the functions library
require_once '../library/functions.php';
//  Get the uploads model
require_once '../model/uploads-model.php';
// Get the reviews model
require_once '../model/reviews-model.php';


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


    case 'addClassification':
        include '../view/add_classification.php';
        break;

    case 'add-classification':
        // Filter the data from add classification form;
        $classificationName = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        // Check if user did not enter any data.
        if (empty($classificationName)) {
            $message = '<p class="notice">Please enter a classification <span class="close-notice">X</span></p>';
            include '../view/add_classification.php';
            exit;
        }
        // Capitalise first letter.
        $classificationName = ucfirst($classificationName);
        // Insert data into the database.
        $outcome = addClassification($classificationName);
        // Check if insertion was successful and display necessary message
        if ($outcome === 1) {
            header("location: /phpmotors/vehicles/");
            // include '../view/vehicle-management.php';
        } else {
            $message = '<p class="notice">Failed. Please try again.<span class="close-notice">X</span></p>';
            include '../view/add_classification.php';
        }
        break;

    case 'add_vehicle':
        include '../view/add_vehicle.php';
        break;

    case 'add-vehicle':

        // Filter the data from add classification form;

        $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invModel =  trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_ALLOW_FRACTION));
        $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_NUMBER_INT));
        $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        $invStock = validatePositiveNum($invStock);

        // Check if user did not enter any data.
        if (
            empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) ||
            empty($invThumbnail) || empty($invStock) || empty($invColor)
        ) {
            $message = '<p class="notice">Please provide information for all empty form fields.<span class="close-notice">X</span></p>';
            include '../view/add_vehicle.php';
            exit;
        }

        // Capitalise first letters.
        $invMake = ucfirst($invMake);
        $invModel = ucfirst($invModel);
        // Insert data into the database.
        $outcome = addVehicle($classificationId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor);
        // Check if insertion was successful and display necessary message
        if ($outcome === 1) {
            $message = "<p class='notice'>$invModel added successfully.<span class='close-notice'>X</span></p>";
            include '../view/add_vehicle.php';
            exit;
        } else {
            $message = '<p class="notice"><?php "$invModel not added. Try again." ?><span class="close-notice">X</span></p>';
            include '../view/add_vehicle.php';
            exit;
        }
        break;


    case 'vehicles':
        include '../view/vehicles.php';
        break;

        /* * ********************************** 
* Get vehicles by classificationId 
* Used for starting Update & Delete process 
* ********************************** */
    case 'getInventoryItems':
        // Get the classificationId 
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        // Fetch the vehicles by classificationId from the DB 
        $inventoryArray = getInventoryByClassification($classificationId);
        // Convert the array to a JSON object and send it back 
        // var_dump($inventoryArray);
        echo json_encode($inventoryArray);
        // echo json_encode($inventoryArray);
        break;

    case 'mod':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
            $message = '<p class="notice">Sorry, no vehicle information could be found.<span class="close-notice">X</span></p>';
        }
        include '../view/vehicle-update.php';
        break;

    case 'updateVehicle':
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        if (empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)) {
            $message = '<p class="notice">Please complete all information for the update! Double check the classification of the item. <span class="close-notice">X</span></p>';
            include '../view/vehicle-update.php';
            exit;
        }
        $updateResult = updateVehicle($classificationId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $invId);
        if ($updateResult) {
            echo $updateResult;
            $message = "<p class='notice'> $updateResult Congratulations, the $invMake $invModel was successfully updated.<span class='close-notice'>X</span></p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class='notice'>Error. The vehicle was not updated.<span class='close-notice'>X</span></p>";
            include '../view/vehicle-update.php';
            exit;
        }
        break;

    case 'del':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
            $message = '<p class="notice">Sorry, no vehicle information could be found.<span class="close-notice">X</span></p>';
            exit;
        }
        include '../view/vehicle-delete.php';

        break;
    case 'deleteVehicle':
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        $deleteResult = deleteVehicle($invId);
        if ($deleteResult) {
            $message = "<p class='notice'>Congratulations the, $invMake $invModel was	successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class='notice'>Error: $invMake $invModel was not
            deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        }
        break;
    case 'classification':
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vehicles = getVehiclesByClassification($classificationName);
        if (!count($vehicles)) {
            $message = "<p class='notice'>Sorry, no $classificationName vehicles could be found.<span class='close-notice'>X</span></p>";
        } else {
            $vehicleDisplay = buildVehiclesDisplay($vehicles);
        }
        include '../view/classification.php';

        break;

    case 'vehicleDetails':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $vehicle = getVehicleByInvId($invId);
        $thumbnailsArray = getThumbnailByVehicleId($invId);
        $thumbnails = buildThumbnails($thumbnailsArray);
        $formattedPrice = number_format($vehicle['invPrice']);
        
        if (!count($vehicle)) {
            $message = "<p class='notice'>Sorry, vehicle could be found.<span class='close-notice'>X</span></p>";
        } else {
            $vehicleDetailsDisplay = buildVehicleDetailsDisplay($vehicle, $formattedPrice);
            $reviews = getReviewsByInvId($invId);
            if ($reviews) {
                $reviewsHTML = displayReviews($reviews);
            } else {
                $reviewsHTML = "<p class='notice be-first'>Be the first to write a review</p>";
            }
        }
        include '../view/vehicle-detail.php';


        break;

    default:
        $classificationList = buildClassificationList($classifications);
        include '../view/vehicle-management.php';
        break;
}
