<?php 
function phpmotorsConnect() {
    $server = "localhost";
    $dbname = "phpmotors";
    $username = "iCloud";
    $password = "[bJl_(9y!K*Yd(Dv";
    $dsn = "mysql:host=$server;dbname=$dbname";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    
    try {
        $link = new PDO($dsn, $username, $password, $options);
        return $link;
    } catch(PDOException $e) {
        header("location: /phpmotors/view/500.php");
        exit;
    }
} 
phpmotorsConnect();

?>