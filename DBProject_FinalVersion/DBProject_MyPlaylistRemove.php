

<!DOCTYPE HTMl>
<html>
<head>
<?php
    include("pdo_connect.php");
    include("DBProject_AccountLoginBackend.php");
    
    if(!$db){
        echo "could not connect to the database.";
        exit();
    }
   ?>
</head>
<body>
<?php

    if(!(isset($_GET['album_id'])) || empty($_GET['album_id'])){
        echo "Thats wierd... no album ID has been selected. Please try again. <br>";
        echo"<button onclick='history.back()'>Go Back To Results</button>";
        exit(); 
    }

    if(!(isset($_SESSION['user_id'])) || empty($_SESSION['user_id'])){
        echo "Thats wierd... no user ID has been found. Please try again. <br>";
        echo"<button onclick='history.back()'>Go Back To Results</button>";
        exit(); 
    }
    if(!(isset($_GET['title'])) || empty($_GET['title'])){
        echo "Thats wierd... this album had no title. Please try again. <br>";
        echo"<button onclick='history.back()'>Go Back To Results</button>";
        exit(); 
    }

    $album_id = $_GET['album_id'];
    $user_id = $_SESSION['user_id'];
    $title = $_GET['title'];

    $removeAlbum = 'delete from playlists where album_id = ? and user_id = ?';  
    
    $statement = $db->prepare($removeAlbum);
    $statement->bindParam(1, $album_id);
    $statement->bindParam(2, $user_id);
    $statement->execute();
    

    echo"The album '{$title}' has been removed from your playlist. <br>";
    echo"<button onclick='history.back()'>Go Back To Playlist</button>";
    

    ?>


    </body>
    </html>
