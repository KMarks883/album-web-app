


<?php
    include("pdo_connect.php");
    include("DBProject_AccountLoginBackend.php");

    if(!$db){
        echo "could not connect to the database.";
        exit();
    }
    if(empty($_SESSION['user_id']) || !(isset($_SESSION['user_id']))){
        echo "Could not pull session user id. Please try logging in again <br>";
        echo"<button onclick='history.back()'>Go Back To Results</button>";
        exit();
    }

    if(!(isset($_GET['album_id'])) || empty($_GET['album_id'])){
        echo "Thats wierd... no album ID has been selected. Please try again. <br>";
        echo"<button onclick='history.back()'>Go Back To Results</button>";
        exit(); 
    }

    $album_id = $_GET['album_id'];
    $user_id = $_SESSION['user_id'];
    $title = $_GET['title'];

    $checkIfExists = 'select album_id from playlists where album_id = ? and user_id = ?';
    $addAlbum = 'insert into playlists values(?, ?)';  
    $displayAlbum = 'select title, art_name from albums, artists where ';
    
    $statement = $db->prepare($checkIfExists);
    $statement->bindParam(1, $album_id);
    $statement->bindParam(2, $user_id);
    $statement->execute();

    $searchResult = $statement->fetchAll(PDO::FETCH_ASSOC);
    if(count($searchResult) >= 1){
        echo"you have already placed this album in your playlist. Please select a different album <br>"; 
        echo"<button onclick='history.back()'>Go Back</button>";
    }else{
        $statement = $db->prepare($addAlbum);
        $statement->bindParam(1, $user_id);
        $statement->bindParam(2, $album_id);
        $statement->execute();

        echo"The album '{$title}' has been added to your playlist.<br>";
        echo"<button onclick='history.back()'>Go Back To Results</button>";
    }


    ?>
