<?php
if (!$_SESSION['loggedin']) {
    header('location: /phpmotors/');
}
$clientFirstname = $_SESSION['clientData']['clientFirstname'];
$clientLastname = $_SESSION['clientData']['clientLastname'];
$clientEmail = $_SESSION['clientData']['clientEmail'];
$clientLevel = $_SESSION['clientData']['clientLevel'];
// load reviews by loggedin client
$clientReviews = getReviewsByClientId($_SESSION['clientData']['clientId']);
$clientReviewsHtml = displayClientReviews($clientReviews);

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | PHP Motors</title>
    <link rel="icon" type="image/png" href="/phpmotors/images/site/logo.png" >
    <link rel="stylesheet" href="../css/style.css" media="screen">
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
            <?php if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
            }
            ?>
            <h1><?php echo "$clientFirstname $clientLastname"; ?></h1>
            <p>You are logged in:</p>
            <ul class="admin-ul">
                <li>Firstname: <?php echo $clientFirstname ?></li>
                <li>Lastname: <?php echo $clientLastname ?></li>
                <li>Email: <?php echo $clientEmail ?></li>
            </ul>
            <h2> Account Management</h2>
            <p>Use this link to update account information:</p>
            <a href='../accounts/?action=client-update'> Update Account Information</a>
            <?php if ($_SESSION['loggedin'] && $clientLevel > 1) {
                echo "<br> <br> <h2> Inventory Management</h2>
                <p>Use this link to manage the inventory:</p>
                <a href='../vehicles/'> Vehicle Management</a>";
            }

           echo "<br><br> <h2>Manage your product reviews</h2>";
                echo $clientReviewsHtml;
            ?>


        </main>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php' ?>
        </footer>
    </div>
    <script src="/phpmotors/js/main.js"></script>
</body>

</html>
<?php unset($_SESSION['message']); ?>