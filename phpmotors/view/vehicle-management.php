<?php
if (!($_SESSION['loggedin'] && intval($_SESSION['clientData']['clientLevel']) >= 2)) {
    header('location: /phpmotors/');
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
   }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Management | PHP Motors</title>
    <link rel="icon" type="image/png" href="/phpmotors/images/site/logo.png" >
    <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
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
            <h1 class="vehicle-mgt-h1">Vehicle Management</h1>
            <ul class="add-class-ul">
                <li class="add-class-li"><a href="/phpmotors/vehicles/?action=addClassification">Add classification</a></li>
                <li class="add-vehicle-li"><a href="/phpmotors/vehicles/?action=add_vehicle">Add Vehicle</a></li>
            </ul>



            <?php
            if (isset($message)) {
                echo $message;
            }
            if (isset($classificationList)) {
                echo '<h2>Vehicles By Classification</h2>';
                echo '<p>Choose a classification to see those vehicles</p>';
                echo $classificationList;
            }
            ?>
            <noscript>
                <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
            </noscript>
            <table id="inventoryDisplay"></table>
        </main>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php' ?>
        </footer>
    </div>
    <script src="../js/inventory.js"></script>
    <script src="/phpmotors/js/main.js"></script>
</body>

</html>
<?php unset($_SESSION['message']); ?>