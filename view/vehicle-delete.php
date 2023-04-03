<?php
if (!($_SESSION['loggedin'] && intval($_SESSION['clientData']['clientLevel']) > 1)) {
    header('location: /phpmotors/');
} 

?><!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
	 echo "delete $invInfo[invMake] $invInfo[invModel]";} 	elseif(isset($invMake) && isset($invModel)) { 
		echo "Delete $invMake $invModel"; }?>| PHP Motors</title>
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
            <h1 class='delete-vehicle-h1'><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
	echo "Delete $invInfo[invMake] $invInfo[invModel]";} 
elseif(isset($invMake) && isset($invModel)) { 
	echo "Delete $invMake $invModel"; }?></h1>
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
            <form action='/phpmotors/vehicles/' method='post' name='delete-vehicle' id='delete-vehicle' class='delete-vehicle'>
                
                <div class='formbox'>
                    <label for='invMake'>Make</label>
                    <input type='text' id='invMake' name='invMake' readonly <?php if(isset($invMake)){ echo "value='$invMake'"; } elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?> >
                </div>
                <div class='formbox'>
                    <label for='invModel'>Model</label>
                    <input type='text' id='invModel' name='invModel' readonly <?php if(isset($invModel)){ echo "value='$invModel'"; } elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?> >
                </div>
                <div class='formbox'>
                    <label for='invDescription'>Description</label>
                    <textarea name='invDescription' id='invDescription' cols='30' rows='3' readonly><?php if(isset($invDescription)){ echo $invDescription; } elseif(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }?></textarea>
                </div>
            

                <button type='submit' id='delete-vehicle-btn'>Delete vehicle</button>
                <input type='hidden' name='action' value='deleteVehicle'>
                <input type="hidden" name="invId" value="
                <?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} ?>
                ">
            </form>
        </main>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php' ?>
        </footer>
    </div>
    <script src="/phpmotors/js/main.js"></script>
</body>

</html>