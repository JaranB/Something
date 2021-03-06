<?php

require_once(dirname(__FILE__) . '/db.php');

if(!isset($_SESSION)){
    session_start();
}

if ($_SESSION['LogInStatus'] == false) {
    header("Location: ./index.php");
    die();
}

$brukernavn = mysqli_real_escape_string($connection, $_SESSION['brukernavn']);
$sql = "SELECT avatarURL FROM `brukere` WHERE brukernavn='$brukernavn'";
$result1 = mysqli_query($connection, $sql);
$row = $result1->fetch_assoc();
$avatarURLSession = $_SESSION['avatarURL'];

if(isset($_POST['endreBruker'])) {

    $eksiterendePassord = md5($_POST['eksisterendePassord']);
    $nyttPassord = md5($_POST['passordEndre']);
    $nyEPost = $_POST['epostEndre'];
    $nyAvatarURL = $_POST['settAvatar'];
	$sql = "SELECT * FROM `brukere` WHERE brukernavn='$brukernavn'";
    $result1 = mysqli_query($connection, $sql);
    $row = $result1->fetch_assoc();

    if($row['brukernavn'] == $_SESSION['brukernavn']){
            if(!empty($_POST['passordEndre'])){
                $byttPassord = "UPDATE brukere SET passord='$nyttPassord' WHERE brukernavn='$brukernavn' AND passord='$eksiterendePassord'";
                $result = mysqli_query($connection, $byttPassord);
                $smsg = "Passord endret!";
                }

            if(!empty($_POST['epostEndre'])){
                $byttEPost = "UPDATE brukere SET epost='$nyEPost' WHERE brukernavn ='$brukernavn'";
                $result = mysqli_query($connection, $byttEPost);
                $_SESSION['epost'] = $nyEPost;
                $smsg = "E-Post endret!";
            }

            if(!empty($_POST['settAvatar'])){
                $byttAvatar = "UPDATE brukere SET avatarURL='$nyAvatarURL' WHERE brukernavn ='$brukernavn'";
                $result = mysqli_query($connection, $byttAvatar);
                $_SESSION['avatarURL'] = $nyAvatarURL;
                $smsg = "Avatar satt!";
            }

            }else{
                $smsg = "Fyll inn riktig informasjon i minst ett felt!";
}

}

?>

    <!DOCTYPE html>
    <html>

    <?php include 'header.php';?>

    <body>

        <div id="container">
            <?php if(isset($smsg)){ ?>
            <div class="varsel" role="alert">
                <?php echo $smsg; ?> </div>
            <?php } ?>
            <?php if(isset($fmsg)){ ?>
            <div class="varsel" role="alert">
                <?php echo $fmsg; ?> </div>
            <?php } ?>

            <div class="trippelPanel center">
                <div class="item">
                    <form class="panel" method="POST">
                        <h2>Dine instillinger: </h2>
                        <br>
                        <a>Ditt brukernavn: </a>
                        <?php echo $_SESSION['brukernavn']; ?>
                        <br>
                        <a>Din E-Post: </a>
                        <?php echo $_SESSION['epost']; ?>
                        <br>
                        <a>Ditt Avatar: </a>
                        <br>
                        <?php echo "<img src='$avatarURLSession' id='avatarBilde'>"; ?>
                        <br>
                        <a>Bytt passord:</a>
                        <br>
                        <input type="password" name="eksisterendePassord" class="" placeholder="Eksisterende passord">
                        <br>
                        <input type="password" name="passordEndre" class="" placeholder="Nytt passord">
                        <br>
                        <a>Bytt E-Post:</a>
                        <br>
                        <input type="text" name="epostEndre" class="" placeholder="Ny E-Post">
                        <br>
                        <a>Avatar URL:</a>
                        <br>
                        <input type="text" name="settAvatar" class="" placeholder="Skriv inn URL til avataret">
                        <br>
                        <button type="submit" name="endreBruker">Endre</button>
                    </form>

                    <div class="panel">
                        <h2>Dine favoritter: </h2>
                        <br>

                        <?php

                $postsystem = "SELECT DISTINCT steder.postid, steder.tittel, steder.kategori, steder.bildeURL, steder.post, favoritter.favorittID, favoritter.brukernavn FROM steder, favoritter WHERE steder.postid=favoritter.favorittID";
                $postsystemquery = mysqli_query($connection, $postsystem);


                while ($row = mysqli_fetch_array($postsystemquery)) {
                    $tittel = $row['tittel'];
                    $bildeURL = $row['bildeURL'];
                    $post = $row['post'];
                    $postid = $row['postid'];
                    $favorittid = $row['favorittID'];
                    $favorittBrukernavn = $row['brukernavn'];
                    $brukernavn = $_SESSION['brukernavn'];

                    if(($favorittid == $postid) && ($favorittBrukernavn == $brukernavn)) { ?>

                            <p><a href="/something/funksjoner/slett.php?postid=<?php echo $postid; ?>" class="funksjonSymboler">&#9734</a></p>
                            <h2>
                                <?php echo $tittel; ?>
                            </h2>
                            <p class="kommentarFavoritt">
                                <?php echo $post; ?>
                                <br>
                            </p>
                            <?php

                    }
                } ?>

                    </div>

                    <div class="panel">
                        <h2>Dine kommentarer: </h2>
                        <br>

                        <?php

                    $brukernavn = $_SESSION['brukernavn'];
                    $kommentarsystem = "SELECT DISTINCT kommentarer.kommentarid, kommentarer.postid, kommentarer.kommentar, kommentarer.brukernavn, steder.postid, steder.tittel FROM kommentarer, steder WHERE (brukernavn='$brukernavn') AND (kommentarer.postid=steder.postid) ORDER BY kommentarid DESC";
                    $kommentarsystemquery = mysqli_query($connection, $kommentarsystem);

                    $finnkommentarid = "SELECT kommentarid FROM steder";
                    $kommentaridquery = mysqli_query($connection, $finnkommentarid);

                    while ($row = mysqli_fetch_array($kommentarsystemquery)) {
                        $kommentar = $row['kommentar'];
                        $kommentarid = $row['kommentarid'];
                        $tittel = $row['tittel'];


                        if(isset($_SESSION['admin']) && $_SESSION['admin'] == true || isset($_SESSION['brukernavn']) && $_SESSION['brukernavn'] == $brukernavn) {

                         ?>
                            <a href="/something/funksjoner/slett.php?kommentarid=<?php echo $kommentarid; ?>" class="funksjonSymboler">&#x2717</a>

                            <?php } ?>
                            <br>
                            <p>
                                <?php echo $tittel ?> </p>

                            <p class="kommentarBorder">
                                <?php echo $kommentar; ?>
                                <br>
                            </p>
                            <?php } ?>

                    </div>

                </div>
            </div>
        </div>

        <?php include 'footer.php';?>

    </body>

    </html>
