<?php 
if (!($_SESSION['loggedin'] && intval($_SESSION['clientData']['clientLevel']) > 1)) {
    header('location: /phpmotors/');
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Classification | PHP Motors</title>
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
            <h1 class="add-classification-h1">Add classification</h1>
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
            <form action="/phpmotors/vehicles/" method="post" name="add-classification" id="add-classification" class="add-classification">
                <div class="formbox">
    
                    <label for="classification-name">Classification Name</label>
                    <span class="hint">* Classification Name cannot be more than 30 characters.</span>
                    <input type="text" id="classification-name" name="classificationName" maxlength="30" <?php if(isset($classificationName)){echo "value='$classificationName'";}  ?> required>
                </div>
                <button type="submit" id="add-classification-btn">Add classification</button>
                <input type="hidden" name="action" value="add-classification">
            </form>
        </main>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php' ?>
        </footer>
    </div>
    <script src="/phpmotors/js/main.js"></script>
</body>

</html>