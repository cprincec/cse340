<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-up | PHP Motors</title>
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
            <h1 class="login-signup-h1">Sign Up</h1>
            <?php 
            if (isset($message)) {
                echo $message;
            }
            ?>
            <form action="/phpmotors/accounts/index.php" method="post" name="signup" id="signup" class="login-signup">
                <div class="formbox">
                    <label for="fname">Firstname</label>
                    <input type="text" id="fname" name="clientFirstname" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";}  ?> required>
                </div>
                <div class="formbox">
                    <label for="lname">Lastname</label>
                    <input type="text" id="lname" name="clientLastname" <?php if(isset($clientLastname)){echo "value='$clientLastname'";}  ?> required>
                </div>
                <div class="formbox">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?> required>
                </div>
                <span class="password-hint"><em>Passwords must be atleast 8 characters and contain at least 1 number, 1 capital letter and 1 special character</em></span>
                <div class="formbox">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                </div>
                <button type="submit" name="submit" id="signup-btn">REGISTER</button>
                <!-- Add the action name - value pair -->
                <input type="hidden" name="action" value="register">

                <div class="login-signup-a-div">Already a member? <a href="/phpmotors/accounts/index.php/?action=login" class="login-signup-a">Login</a> </div>
            </form>
        </main>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php' ?>
        </footer>
    </div>
    <script src="/phpmotors/js/main.js"></script>
</body>

</html>