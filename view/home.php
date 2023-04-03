<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | PHP Motors</title>
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
            <h1>Welcome to PHP Motors!</h1>
            <div class="banner">
                <section class="banner-desc">
                    <h2>DMC Delorean</h2>
                    <p>3 Cup holders <br>Superman doors<br>Fuzzy dice!</p>
                </section>
                <picture class="banner-picture"><img src="/phpmotors/images/vehicles/delorean.jpg" alt="photo of DMC Delorean"></picture>
                <button id="call-to-action">Own Today</button>
            </div>
            <div class="main-sections">
                <section class="dmc-delorean-reviews">
                    <h3>DMC Delorean Reviews</h3>
                    <ul>
                        <li>"So fast its almost like traveling in time." (4/5)</li>
                        <li>"Coolest ride on the road." (4/5)</li>
                        <li>"I'm feeling Marty McFly!" (5/5)</li>
                        <li>"The most futuristic ride of our day." (4.5/5)</li>
                        <li>"80's living and I love it!." (5/5)</li>
                    </ul>
                </section>
                <section class="delorean-upgrades">
                    <h3>DMC Delorean Upgrades</h3>
                    <div class="upgrades">
                        <div>
                            <picture class="figure"><img src="/phpmotors/images/upgrades/flux-cap.png" alt="Flux capacitor Image"></picture>
                            <p class="figcaption"><a href="#">Flux Capacitor</a></p>
                        </div>
                        <div>
                            <picture class="figure"><img src="/phpmotors/images/upgrades/flame.jpg" alt="Flame decals image"></picture>
                            <p class="figcaption"><a href="#">Flame Decals</a></p>
                        </div>
                        <div>
                            <picture class="figure"><img src="/phpmotors/images/upgrades/bumper_sticker.jpg" alt="Bumper sticker image"></picture>
                            <p class="figcaption"><a href="#">Bumper Stickers</a></p>
                        </div>
                        <div>
                            <picture class="figure"><img src="/phpmotors/images/upgrades/hub-cap.jpg" alt="Hub cap image"></picture>
                            <p class="figcaption"><a href="#">Hub Caps</a></p>
                        </div>
                    </div>
                </section>
            </div>
        </main>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php' ?>
        </footer>
    </div>
    <script src="/phpmotors/js/main.js"></script>
</body>

</html>