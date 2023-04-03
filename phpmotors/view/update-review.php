<?php
if (!$_SESSION['loggedin']) {
    header('location: /phpmotors/');
}
// $clientFirstname = $_SESSION['clientData']['clientFirstname'];
// $clientLastname = $_SESSION['clientData']['clientLastname'];
// $clientEmail = $_SESSION['clientData']['clientEmail'];
// $clientLevel = $_SESSION['clientData']['clientLevel'];
// load a specific review by loggedin client
// echo "Here is it $reviewId";

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Update | PHP Motors</title>
    <link rel="icon" type="image/png" href="/phpmotors/images/site/logo.png" >
    <link rel="stylesheet" href="../css/style.css" media="screen">
</head>

<body>
    <div id="page">
        <header>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php' ?>
        </header>
        <nav>
            <!-- <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/navigation.php' ?> -->
            <?php echo $navList; ?>
        </nav>
        <main>
            <?php if (isset($message)) {
                echo $message;
            }?>
            <h1><?php echo $_SESSION['aClientReview'][0]['invMake'] . " " . $_SESSION['aClientReview'][0]['invModel']; ?> Review</h1>
            <div class='update-review'>
                <p>Reviewed on <span class="review-date"><?php echo date("j F\, Y", strtotime($_SESSION['aClientReview'][0]['reviewDate'])) ?> </span></p>
                <form method="post" action="/phpmotors/reviews/">
                    <div class="formbox">
                        <label for="update-review">Review Text:</label>
                        <textarea name="update-review" id="update-review" cols="30" rows="5" required><?php echo $_SESSION['aClientReview'][0]['reviewText'] ?></textarea>
                    </div>
                    <button type='submit'>Add review</button>
                        <input type='hidden' name='action' value='submit-edit-review'>
                        <input type='hidden' name='reviewId' value='<?php 
                        echo $reviewId;
                        ?>'>
                </form>
            </div>
        </main>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php' ?>
        </footer>
    </div>
    <script src="/phpmotors/js/main.js"></script>
</body>

</html>
