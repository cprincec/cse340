<?php
// if (!$_SESSION['loggedin']) {
//     header('location: /phpmotors/');
// }

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
    <title>Image Management | PHP Motors</title>
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

            <h1>Image Management</h1>
            <p>Choose one of the options below:</p>
            <h2>Add New vehicle Image</h2>
            <?php
            if (isset($message)) {
                echo $message;
            } ?>

            <form action="/phpmotors/uploads/" method="post" enctype="multipart/form-data" class="img-mangt-form">
                <label for="invItem">Vehicle</label>
                <?php echo $prodSelect; ?>
                <fieldset>
                    <div class="formbox">

                        <label>Is this the main image for the vehicle?</label>
                        <label for="priYes" class="pImage">Yes</label>
                        <input type="radio" name="imgPrimary" id="priYes" class="pImage" value="1">
                        <label for="priNo" class="pImage">No</label>
                        <input type="radio" name="imgPrimary" id="priNo" class="pImage" checked value="0">
                    </div>
                    <div class="formbox">
                        <label>Upload Image:</label>
                        <input type="file" name="file1">
                    </div>
                </fieldset>

                <input type="submit" class="regbtn" value="Upload">
                <input type="hidden" name="action" value="upload">


            </form>
            <hr>
            <h2>Existing Images</h2>
            <p class="notice">If deleting an image, delete the thumbnail too and vice versa.</p>
            <?php
            if (isset($imageDisplay)) {
                echo $imageDisplay;
            } ?>


        </main>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php' ?>
        </footer>
    </div>
    <script src="/phpmotors/js/main.js"></script>
</body>

</html>
<?php unset($_SESSION['message']); ?>