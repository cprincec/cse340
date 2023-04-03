<a href="/phpmotors/">
    <picture><img src="/phpmotors/images/site/logo.png" alt="PHP Motors logo"></picture>
</a>

<?php
if (isset($_SESSION['loggedin'])) {
    $clientFirstname = $_SESSION['clientData']['clientFirstname'];
    echo "<div class='logged-in'> Welcome 
        <a href='/phpmotors/accounts/'>$clientFirstname</a> | " .
        '<a href="/phpmotors/accounts/index.php?action=logout" class="logout">Logout</a>
        </div>';
} else {
    echo "<a href=" . '"/phpmotors/accounts/index.php?action=login"' . ' class="my-account">My Account</a>';
}

?>