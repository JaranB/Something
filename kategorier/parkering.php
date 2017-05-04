<?php
require_once('../db.php');

if(!isset($_SESSION)){
    session_start();
}
?>

    <!DOCTYPE html>
    <html>

    <?php include '../header.php'; ?>

    <!-- Knapper til steder lastet inn fra databasen - start -->

    <body id="barerimg">
        <div class="container">
            <img class="titelundersider" src="http://localhost/something/bilder/kategoribilder/barerlogo.png" width="300px">
            <div id="undersidor">

                <?php

                    $postsystem = "SELECT DISTINCT postid, tittel, kategori, bildeURL, post FROM steder WHERE kategori=4 ORDER BY postid DESC";
                    $postsystemquery = mysqli_query($connection, $postsystem);

                    $finnpostid = "SELECT postid FROM steder";
                    $postidquery = mysqli_query($connection, $finnpostid);


                    while ($row = mysqli_fetch_array($postsystemquery)) {
                        $tittel = $row['tittel'];
                        $bildeURL = $row['bildeURL'];
                        $post = $row['post'];
                        $postid = $row['postid'];

                        ?>

                    <a href="/something/post.php?postid=<?php echo $postid; ?>">
                        <div class="hexagon hexagonUnderside" id="undersideHex">
                            <div class="hexagon-inni">
                                <div class="hexagonimg" style="background:url(<?php echo $bildeURL; ?>)">

                                </div>
                            </div>
                        </div>
                    </a>
                    <?php   }   ?>
            </div>
        </div>

        <!-- Knapper til steder lastet inn fra databasen - slutt -->

        <?php include '../footer.php';?>

    </body>

    </html>