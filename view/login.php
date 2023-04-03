<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PHP Motors</title>
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
            <h1 class="login-signup-h1">Sign In</h1>
            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
            }
            ?>
            <form action="/phpmotors/accounts/" method="post" name="login" id="login" class="login-signup">
                <div class="formbox">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="clientEmail" <?php if (isset($clientEmail)) {echo "value='$clientEmail'";}  ?> required>
                </div>
                <span class="password-hint"><em>Passwords must be atleast 8 characters and contain at least 1 number, 1 capital letter and 1 special character</em></span>
                <div class="formbox">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="clientPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
                </div>

                <button type="submit" id="login-btn">LOGIN</button>

                <div class="login-signup-a-div">No Account? <a href="/phpmotors/accounts/index.php/?action=registration" id="login-signup-link" class="login-signup-a">Register</a> </div>
                <input type="hidden" name="action" value="Login">
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