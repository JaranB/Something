<!-- Header som inneholder navigatoren på nettsiden - start -->

<head>
    <meta charset="UTF-8">
    <title>Westerdals Social</title>
    <link rel="stylesheet" href="/something/css/style.css" type="text/css">
</head>
<header>
    <div id="navigator">
        <div id="logo">
            <a href="/something/index.php">
                <img src="http://localhost/something/bilder/newlogowesterdals.png" height="40px">
            </a>
        </div>
        <div id="navKnapper">
            <a href="/something/index.php">Forside</a>
            <div class="dropdownMeny">
                <button class="kategoriKnapp">Kategori &#9660;</button>
                <div class="kategoriMeny">
                    <a href="/something/kategorier/barer.php">Barer</a>
                    <a href="/something/kategorier/restauranter.php">Restauranter</a>
                    <a href="/something/kategorier/parkering.php">Parkering</a>
                    <a href="/something/kategorier/helse.php">Helse</a>
                    <a href="/something/kategorier/transport.php">Transport</a>
                    <a href="/something/kategorier/butikker.php">Butikker</a>
                </div>
            </div>
            <a href="/something/Kart.php">Kart</a>
            <?php


                require_once(dirname(__FILE__) . '/db.php');

                  function loggUtFunksjon() {
                    $_SESSION['LogInStatus'] = false;
                    $_SESSION['admin'] = false;
                    $_SESSION['brukernavn'] = null;
                    header("Location: /something/index.php");
                    die();
                  }

                if(!isset($_SESSION)){
                    session_start();
                }

                  if (isset($_GET['loggUt'])) {
                    loggUtFunksjon();
                  }

                if(isset($_SESSION['LogInStatus']) && $_SESSION['LogInStatus'] == true) {

                    if(isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
                        echo "<a href='/something/adminpanel.php'>Admin</a>";
                    }

                    echo "<a href='/something/minside.php'>Min side</a>";
                    echo "<a href='/something/index.php?loggUt=true'>Logg ut</a>";

                } else {

                    echo "<a href='/something/login.php'>Login</a>";
                    echo "<a href='/something/register.php'>Register</a>";

                }

                ?>
        </div>
    </div>
    <div id="infoMenyInnhold">
        <?php

                if(isset($_SESSION['LogInStatus']) && $_SESSION['LogInStatus'] == true) {
                  echo "<a id='loggetInnSom'>Logget inn som: </a><a>" . $_SESSION['brukernavn']; echo "</a> ";
                }

                 if(isset($_SESSION['avatarURL'])) {

                    $brukernavn = mysqli_real_escape_string($connection, $_SESSION['brukernavn']);

                    $sql = "SELECT avatarURL FROM `brukere` WHERE brukernavn='$brukernavn'";
                    $result1 = mysqli_query($connection, $sql);
                    $row = $result1->fetch_assoc();
                    $avatarURL = $row['avatarURL'];

                     echo "<div id='avatarBildeHeader'><img src='$avatarURL' id='avatarBilde'></div>";
                 }

                ?>
    </div>
</header>
<!-- Header som inneholder navigatoren på nettsiden - slutt -->
