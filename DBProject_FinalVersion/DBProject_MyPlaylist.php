<!DOCTYPE HMTL>
<html>
</head>
    <meta charset="utf-8">
    <title> Select Result </title>
    <link rel="stylesheet" href="DBProject_Style.css">
    <?php
        include("pdo_connect.php");
        include("DBProject_AccountLoginBackend.php");

        if(!$db){
            echo "could not connect to the database.";
            exit();
        }

    ?>
</head>
<body style='background-color: #2E3047;'>
    <?php

    if(empty($_SESSION['user_id']) || !(isset($_SESSION['user_id'])) ){
        echo "Thats not normal... some how there is no user id. Please log out and log back in";
        exit();
    }

    $user_id = $_SESSION['user_id'];

    $getPlaylist ="select albums.album_id, albums.title, artists.art_name, albums.year_of_pub from albums, artists, playlists where artists.artist_id = albums.album_id and playlists.album_id = albums.album_id and playlists.user_id = ? "; 
    $statement = $db->prepare($getPlaylist);
    $statement->bindParam(1, $user_id);
    $statement->execute();

    $searchResult = $statement->fetchAll(PDO::FETCH_ASSOC);
    $rows = count($searchResult);
    ?>
        <div class='list-background'>
        <h1 style='text-align: center; margin-bottom: 0px'>Library Of Music Discographies</h1> 
        <h2 style="text-align: center; margin-bottom: 0px">Favorites List</h2>

        <?php 
            echo "<h3 style='text-align: center; margin-bottom: 0px'>List Size: {$rows}</h3>";
            if($rows == 0){
            echo "<h3 style='text-align: center; margin-bottom: 0px; color: white;'>It looks like your playlist is empty. Go add music to it!</h1>";
            echo"<button type='button' style='background-color: #24a0ed; margin-left: 350px; width: 100px; height: 30px; margin-top: 30px; margin-bottom: -80px;'><a href='DBProject_MainMenu.php' style='text-decoration: none;'>Back</a></button>";
            }
            echo"<ul class='firstResult-list'>";
            foreach($searchResult as $albums){
                echo"<li>Title: {$albums['title']}</li>";
                
                if(!(empty($albums['art_name']))){
                    echo"<ul><li>Artist: {$albums['art_name']}</li>";
                }
                else{  
                    echo"<ul><li>Artist: N/A</li>";
                }
                
                
                if(!(empty($albums['genre']))){
                    echo"<li>Genre: {$albums['genre']}</li>";
                }
                else{
                    echo"<li>Genre: N/A </li>";
                }

                if(!(empty($albums['year_of_pub']))){
                    echo"<li>Year: {$albums['year_of_pub']}</li>";
                }
                else{
                    echo"<li>Year: N/A</li>";
                }
                 
    
                echo"<li><a href='DBProject_MyPlaylistRemove.php/?album_id={$albums['album_id']}&title={$albums['title']}' >Remove From Playlist</a></li></ul>";
                echo"<br>";
            }
            echo"</ul>";
            echo"</div>";
            ?>
</body>
</html>