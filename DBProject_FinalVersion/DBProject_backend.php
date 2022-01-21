<!DOCTYPE HMTL>
<html>
<head>    
    <meta charset="utf-8">
    <title> Select Result </title>
    <link rel="stylesheet" href="DBProject_Style.css">
</head>
<body style="background-color: #2E3047">
<?php
    include('pdo_connect.php');
    
    if(!$db){
        echo "could not connect to the database.";
        exit();
    }


    $methodType = '';
    $searchEntry = '';
    $header = '';
    $query = '';


        if(!(isset($_POST['entry'])) || (empty(trim($_POST['entry']))) ){
            echo "<p style='color: white'>Invalid search entry. Please go back and try again. </p>";
            exit();
        } else{
            $searchEntry = $_POST['entry'];
        } 

        if($_POST['method'] == 'Default'){
            echo "<p style='color: white'> No search method selected. Please go back and try again. </p>";
            exit();
        } else{
            $methodType = $_POST['method']; 
        }


 ?>
    <?php

    switch($methodType){

        case ($methodType == 'title'):
            $searchEntry = '%' . $searchEntry .'%';  
            $query = "select distinct albums.album_id, albums.title, artists.art_name, albums.year_of_pub from albums, artists where albums.title like ? and albums.artist_id = artists.artist_id";
            $header = "Showing Albums With '{$searchEntry}' In Title";
            break;

        case ($methodType == 'art_name'):
            $searchEntry = "%" . $searchEntry ."%"; 
            $query = "select albums.album_id, albums.title, artists.art_name, albums.year_of_pub from albums, artists where artists.art_name like ? and artists.artist_id = albums.album_id"; 
            $header = "Showing Albums Made By Artists with '{$searchEntry}' in title";
            break;

        case ($methodType == 'genre'):
            $query = "select distinct albums.album_id, albums.title, artists.art_name, albums.year_of_pub from albums, artists where albums.genre like ? and albums.album_id = artists.artist_id order by albums.title;";
            $header = "Showing '{$searchEntry}' Genre Albums";
            break;

        case ($methodType == 'year_of_pub'):
            $query = "select distinct albums.album_id, albums.title, artists.art_name from albums, artists where albums.year_of_pub = ? and albums.artist_id = artists.artist_id order by albums.title";
            $header = "Showing Albums Released In {$searchEntry}";
            break;

        case ($methodType == 'MTV'):
            $query = "select albums.album_id, albums.title, artist.art_name, albums.year_of_pub from albums, artists, ratings where ratings.mtv_critic = ? and albums.artist_id = artists.artist.id and albums.rating_id = ratings.rating_id order by albums.title"; 
            $header = "Showing Albums With MTV Score Of {$searchEntry}";
            break;

        case ($methodType == 'RollingStone'):
            $query = "select albums.album_id, albums.title, artist.art_name, albums.year_of_pub from albums, artists, ratings where ratings.rolling_stone_critic = ? and albums.artist_id = artists.artist.id and albums.rating_id = ratings.rating_id order by albums.title"; 
            $header = "Showing Albums With Rolling Stone Score of {$searchEntry}";
            break;  
        };
        
        $limit = 0; 

        $statement = $db->prepare($query);
        $statement->bindParam(1,$searchEntry);
        $statement->execute();

       $searchResult = $statement->fetchAll(PDO::FETCH_ASSOC);
       $rows = count($searchResult);
       $header = str_replace('%','', $header);
       
        ?>
<form action="DBProject_SearchResults" method="get">
    <div class='list-background'>
    <h1 style='text-align: center; margin-bottom: 0px'> Library Of Music Discographies</h1> 
    <?php
        if($rows == 0){
            echo "<h2 style='text-align: center; margin-bottom: 0px'>{$header}</h2>";
            echo "<h3 style='text-align: center;'> Your search result is empty. Please try a different search request.</h3>"; 
            echo "<a href='DBProject_Logout.php' style='text-decoration: none; margin-left: 700px; font-size: 20px;'>Logout</a>";
            exit();
        }

        
        echo "<h2 style='text-align: center; margin-bottom: 0px'>{$header}</h2>";
        echo "<h3 style='text-align: center; margin-bottom: 0px'>Pulled {$rows} results</h3>";
        ?>
        <button type="button" style="background-color: #b23b3b; margin-left: 580px; width: 90px;"><a href="DBProject_Logout.php" style="text-decoration: none; color: white;">Logout</a></button>
        <ul class='firstResult-list'>
        <?php 
        foreach($searchResult as $albums){
            echo"<li>Title: {$albums['title']}</li>";
            
            if(!(empty($albums['art_name']))){
                echo"<ul><li>Artist: {$albums['art_name']}</li>";
            }
            else{  
                echo"<ul><li>Artist: N/A</li>";
            }


            if($methodType != 'year_of_pub'){
                if(!(empty($albums['year_of_pub']))){
                    echo"<li>Year: {$albums['year_of_pub']}</li>";
                }
                else{
                    echo"<li>Year: N/A</li>";
                }
            } 

            echo"<li><a href='DBProject_MyPlaylistAdd.php/?album_id={$albums['album_id']}&title={$albums['title']}'>Add To Favorites</a></li></ul>";
            echo"<br>";
        }
        echo"</ul>";
        echo"</div>";
    
        ?>
</form>
</body>
</html>