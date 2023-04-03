<?php
if (!$_SESSION['loggedin']) {
    header('location: /phpmotors/');
}
$clientFirstname = $_SESSION['clientData']['clientFirstname'];
$clientLastname = $_SESSION['clientData']['clientLastname'];
$clientEmail = $_SESSION['clientData']['clientEmail'];
$clientLevel = $_SESSION['clientData']['clientLevel'];
$clientId = $_SESSION['clientData']['clientId'];
if(isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Update | PHP Motors</title>
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
            <h1>Manage Account</h1>

            <form action="/phpmotors/accounts/" method="post" name="update-info" id="update-info" class="update-info">
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
                <h2>Update Account</h2>
                <div class="formbox">
                    <label for="fname">Firstname</label>
                    <input type="text" id="fname" name="clientFirstname" <?php if (isset($clientFirstname)) {
                                                                                echo "value='$clientFirstname'";
                                                                            }  ?> required>
                </div>
                <div class="formbox">
                    <label for="lname">Lastname</label>
                    <input type="text" id="lname" name="clientLastname" <?php if (isset($clientLastname)) {
                                                                            echo "value='$clientLastname'";
                                                                        }  ?> required>
                </div>
                <div class="formbox">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="clientEmail" <?php if (isset($clientEmail)) {
                                                                            echo "value='$clientEmail'";
                                                                        }  ?> required>
                </div>

                <button type="submit" name="submit" id="update-info-btn">Update Info</button>
                <!-- Add the action name - value pair -->
                <input type="hidden" name="action" value="updateInfo">
                <input type="hidden" name="clientId" value="
                    <?php if (isset($clientId)) {
                        echo $clientId;
                    } ?>">
            </form>
            <br>
            <br>
            <form action="/phpmotors/accounts/" method="post" name="update-password-form" id="update-password-form" class="update-password-form">
                <?php
                if(isset($_SESSION['pass_fail_message'])) {
                    echo $_SESSION['pass_fail_message'];
                }                
                ?>
                <h2>Update Password</h2>
                
                <span class="password-hint"><em>Passwords must be atleast 8 characters and contain at least 1 number, 1 capital letter and 1 special character</em></span>
                <p>*note your original password will be changed.</p>
                <div class="formbox">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                </div>
                <button type="submit" name="submit" id="update-password-btn">Update Password</button>
                <!-- Add the action name - value pair -->
                <input type="hidden" name="action" value="updatePassword">
                <input type="hidden" name="clientId" value="
                    <?php if (isset($clientId)) {
                        echo $clientId;
                    } ?>">
            </form>
        </main>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php' ?>
        </footer>
    </div>
    <script src="/phpmotors/js/main.js"></script>
</body>

</html>
<?php unset($_SESSION['message']); ?>