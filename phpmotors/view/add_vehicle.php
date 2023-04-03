<?php
if (!($_SESSION['loggedin'] && intval($_SESSION['clientData']['clientLevel']) > 1)) {
    header('location: /phpmotors/');
} 
// Build classification list dropdown menu
$classificationList = "<label for='classificationId'>Choose a classification:</label>
<select id='classificationId' name='classificationId'>";
foreach ($classifications as $classification) {
    $classificationList .= '<option value=' . urldecode($classification['classificationId']);
    if (isset($classificationId)) {
        if ($classification['classificationId'] == $classificationId) {
            $classificationList .= ' selected ';
        }
    }
    $classificationList .= ">$classification[classificationName]</option>";
}
$classificationList .= '</select>';
// echo "$classificationList";


?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Add Vehicle | PHP Motors</title>
    <link rel="icon" type="image/png" href="/phpmotors/images/site/logo.png" >
    <link rel='stylesheet' href='/phpmotors/css/style.css' media='screen'>
</head>

<body>
    <div id='page'>
        <header>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php' ?>
        </header>
        <nav>

            <!-- <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/navigation.php' ?> -->
            <?php echo $navList;
            ?>
        </nav>
        <main>
            <h1 class='add-vehicle-h1'>Add vehicle</h1>
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
            <form action='/phpmotors/vehicles/' method='post' name='add-vehicle' id='add-vehicle' class='add-vehicle'>
                <div class='formbox'>
                    <?php echo $classificationList ?>
                </div>

                <div class='formbox'>
                    <label for='invMake'>Make</label>
                    <input type='text' id='invMake' name='invMake' <?php if (isset($invMake)) {
                                                                        echo "value='$invMake'";
                                                                    }
                                                                    ?> required>
                </div>
                <div class='formbox'>
                    <label for='invModel'>Model</label>
                    <input type='text' id='invModel' name='invModel' <?php if (isset($invModel)) {
                                                                            echo "value='$invModel'";
                                                                        }
                                                                        ?> required>
                </div>
                <div class='formbox'>
                    <label for='invDescription'>Description</label>
                    <textarea name='invDescription' id='invDescription' cols='30' rows='3' required><?php if (isset($invDescription)) {
                                                                                                        echo "value='$invDescription'";
                                                                                                    }
                                                                                                    ?></textarea>
                </div>
                <div class='formbox'>
                    <label for='invImage'>Image Path</label>
                    <input type='text' id='invImage' name='invImage' value='/phpmotors/images/no-image.png' required>
                </div>
                <div class='formbox'>
                    <label for='invThumbnail'>Thumbnail Path</label>
                    <input type='text' id='invThumbnail' name='invThumbnail' value='/phpmotors/images/no-image.png' required>
                </div>
                <div class='formbox'>
                    <label for='invPrice'>Price</label>
                    <input type='number' id='invPrice' name='invPrice' min='1' step='any' <?php if (isset($invPrice)) {
                                                                                                echo "value='$invPrice'";
                                                                                            }
                                                                                            ?> required>
                </div>
                <div class='formbox'>
                    <label for='invStock'>Stock</label>
                    <input type='number' id='invStock' min='1' name='invStock' <?php if (isset($invMake)) {
                                                                                    echo "value='$invStock'";
                                                                                }
                                                                                ?> required>
                </div>
                <div class='formbox'>
                    <label for='invColor'>Color</label>
                    <input type='text' id='invColor' name='invColor' <?php if (isset($invMake)) {
                                                                            echo "value='$invColor'";
                                                                        }
                                                                        ?> required>
                </div>

                <button type='submit' id='add-vehicle-btn'>Add vehicle</button>
                <input type='hidden' name='action' value='add-vehicle'>
            </form>
        </main>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php' ?>
        </footer>
    </div>
    <script src="/phpmotors/js/main.js"></script>
</body>

</html>