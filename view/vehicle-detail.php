<?php
if ( isset($_SESSION['loggedin'])) {
    $clientFirstname = $_SESSION['clientData']['clientFirstname'];
    $clientLastname = $_SESSION['clientData']['clientLastname'];
    $clientEmail = $_SESSION['clientData']['clientEmail'];
    $clientLevel = $_SESSION['clientData']['clientLevel'];
    $clientId = $_SESSION['clientData']['clientId'];
} 
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "$vehicle[invMake] $vehicle[invModel]"; ?> | PHP Motors, Inc.</title>
    <link rel="icon" type="image/png" href="/phpmotors/images/site/logo.png" >
    <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
</head>

<body>
    <div id="page">
        <header>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php' ?>
        </header>
        <nav>
            <?php echo $navList; ?>
        </nav>
        <main>
            <h1 class="login-signup-h1"><?php if (isset($vehicle)) {
                                            echo "$vehicle[invMake] $vehicle[invModel]";
                                        } ?></h1>
            <?php if (isset($message)) {
                echo $message;
            }
            ?>
            <div class="details">
                <?php if (isset($vehicleDetailsDisplay)) {
                    echo $vehicleDetailsDisplay;
                } ?>
                <?php if (isset($thumbnails)) {
                    echo $thumbnails;
                } ?>
            </div>
            <hr>
            <div id="reviews" class="reviews">
                <h3>Customer Reviews</h3>
                
                <?php if (isset($_SESSION['loggedin'])) {
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                    echo "<h4>Review the " . $vehicle['invMake'] . ' ' . $vehicle['invModel'] . "</h4>";
                    echo "<label for='screen-name'>Screen Name:</label>
                    <input name='screen-name' id='screen-name' value='$clientFirstname[0]$clientLastname' disabled>";
                    echo "<form action='/phpmotors/reviews/' method='post'>
                    <div class='formbox'>
                        <label for='writeReview' class='writeReview'>Write a Review:</label>
                        <textarea name='writeReview' id='writeReview' class='writeReview' cols='30' rows='5' required></textarea>
                    </div>
                    <button type='submit'>Add review</button>
                    <input type='hidden' name='action' value='add-review'>
                    <input type='hidden' name='invId' value='$invId'>
                    <input type='hidden' name='clientId' value='$clientId'>
                </form>";
                } else {
                    echo '<span>You must</span> <a href="/phpmotors/accounts/?action=login">login</a> <span>to add a review</span>';
                } ?>

                <?php if (isset($reviewsHTML)) {
                    echo $reviewsHTML;
                } ?>
            </div>

        </main>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php' ?>
        </footer>
    </div>
    <script src="/phpmotors/js/main.js"></script>
</body>

</html>
<?php unset($_SESSION['message']); ?>