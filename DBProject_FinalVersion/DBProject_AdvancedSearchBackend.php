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

	$methodTypeone = '';
    $searchEntryone = '';
	$methodTypetwo = '';
    $searchEntrytwo = '';
    $header1 = '';
    $query1 = '';
	$header2 = '';
    $query2 = '';
	

		//Method and Entry 1:
		if(!(isset($_POST['entryone'])) || (empty(trim($_POST['entryone']))) ){
			echo "<p style='color: white'>Invalid search entry. Please go back and try again. </p>";
			exit();
		} else{
            $searchEntryone = $_POST['entryone'];
        } 

        if($_POST['methodone'] == 'Default'){
            echo "<p style='color: white'> No search method selected. Please go back and try again. </p>";
            exit();
        } else{
            $methodTypeone = $_POST['methodone']; 
        }
		//End 1
	
		//Method and Entry 2:
		if(!(isset($_POST['entrytwo'])) || (empty(trim($_POST['entrytwo']))) ){
			echo "<p style='color: white'>Invalid search entry. Please go back and try again. </p>";
			exit();
		} else{
			$searchEntrytwo = $_POST['entrytwo'];
		} 

		if($_POST['methodtwo'] == 'Default'){
			echo "<p style='color: white'> No search method selected. Please go back and try again. </p>";
			exit();
		} else{
			$methodTypetwo = $_POST['methodtwo']; 
		}
		//End 2
 ?>
    <?php

	//Require users to choose different values among three Search Methods
	//If same values among methods
	if($_POST['methodtwo'] == $_POST['methodone']){
		echo "<p style='color: white'> Search methods cannot be the same! </p>";
		exit();
	//If selected methods are different
	} else{ 
	
	//Query for methodTypeone for Entry 1:
    switch($methodTypeone){
        case ($methodTypeone == 'title'):
            $searchEntryone = '%' . $searchEntryone .'%';  //Not sure in here
            $query1 = "select distinct albums.album_id, albums.title, artists.art_name, albums.year_of_pub, albums.genre from albums, artists where albums.title like ?";
            $header1 = "Showing albums with '{$searchEntryone}' in title";
            break;

        case ($methodTypeone == 'art_name'):
            $searchEntryone = "%" . $searchEntryone ."%"; 
            $query1 = "select distinct albums.album_id, albums.title, artists.art_name, albums.year_of_pub, albums.genre from albums, artists where artists.art_name like ?"; 
            $header1 = "Showing albums made by '{$searchEntryone}'";
            break;

        case ($methodTypeone == 'genre'): 
            $query1 = "select albums.album_id, albums.title, artists.art_name, albums.year_of_pub, albums.genre from albums, artists where albums.genre like ?";
            $header1 = "Showing '{$searchEntryone}' genre albums";
            break;

        case ($methodTypeone == 'year_of_pub'):
            $query1 = "select distinct albums.album_id, albums.title, artists.art_name, albums.year_of_pub, albums.genre from albums, artists where albums.year_of_pub = ?";
            $header1 = "Showing albums released in '{$searchEntryone}'";
            break;

        case ($methodTypeone == 'MTV'):
            $query1 = "select albums.album_id, albums.title, artist.art_name, albums.year_of_pub, albums.genre from albums, artists, ratings where ratings.mtv_critic = ? and albums.rating_id = ratings.rating_id"; 
            $header1 = "Showing albums with MTV score of '{$searchEntryone}'";
            break;

        case ($methodTypeone == 'RollingStone'):
            $query1 = "select albums.album_id, albums.title, artist.art_name, albums.year_of_pub, albums.genre from albums, artists, ratings where ratings.rolling_stone_critic = ? and albums.rating_id = ratings.rating_id"; 
            $header1 = "Showing albums with Rolling Stone score of '{$searchEntryone}'";
            break;  
        };
		
	//Merge Query for methodTypeone to Query for methodTypetwo and Header to Header
	//$removeOrderByInQuery1 = str_replace(array('order by albums.title'), ' ', $query1);
	
	switch($methodTypetwo){
        case ($methodTypetwo == 'title'):
            $searchEntrytwo = '%' . $searchEntrytwo .'%';  
            $query2 = " and albums.title like ? and albums.artist_id = artists.artist_id";
            $header2 = " with '{$searchEntrytwo}' in title";
            break;

        case ($methodTypetwo == 'art_name'):
            $searchEntrytwo = "%" . $searchEntrytwo ."%"; 
            $query2 = " and artists.art_name like ? and albums.artist_id = artists.artist_id"; 
            $header2 = " made  by '{$searchEntrytwo}'";
            break;

        case ($methodTypetwo == 'genre'): 
            $query2 = " and albums.genre like ? and albums.artist_id = artists.artist_id";
			//$query2 = substr_replace($query1, " and where albums.genre like ? " ,85,0);
            $header2 = " showing '{$searchEntrytwo}' genre albums";
            break;

        case ($methodTypetwo == 'year_of_pub'):
            $query2 = " and albums.year_of_pub = ? and albums.artist_id = artists.artist_id";
			//$query2 = substr_replace($query1, " and where albums.year_of_pub = ? and albums.artist_id = artists.artist_id " ,85,0);
            $header2 = " released in '{$searchEntrytwo}'";
            break;

        case ($methodTypetwo == 'MTV'):
            $query2 = " and ratings.mtv_critic = ? and albums.rating_id = ratings.rating_id and albums.artist_id = artists.artist.id"; 
            $header2 = " with MTV score of '{$searchEntrytwo}'";
            break;

        case ($methodTypetwo == 'RollingStone'):
            $query2 = " and ratings.rolling_stone_critic = ? and albums.rating_id = ratings.rating_id and albums.artist_id = artists.artist.id"; 
            $header2 = " with Rolling Stone score of '{$searchEntrytwo}'";
            break;  
        };	//End methodTypeone + methodTypetwo
	
	//Merge Query for methodTypetwo to Query for methodTypethree and Header to Header	
    
        $request = $query1 . $query2;
        $statement = $db->prepare($request);
        $statement->bindParam(1,$searchEntryone);
        $statement->bindParam(2,$searchEntrytwo);
        $statement->execute();

        $searchResult = $statement->fetchAll(PDO::FETCH_ASSOC);
        $rows = count($searchResult);

        $header1 = str_replace('%', '', $header1);
        $header2 = str_replace('%','', $header2);
        $header2 = $header1.$header2; 
	
       
        ?>
<form action="DBProject_SearchResults" method="get">
    <div class='list-background'>
    <h1 style='text-align: center; margin-bottom: 0px'> Library Of Music Discographies</h1> 
    <?php
	
        if($rows == 0){
            echo "<h3 style='text-align: center; margin-bottom: 0px; font-size: 16px;'>{$header2}</h3>";
            echo "<h3 style='text-align: center;'> Your search result is empty. Please try a different search request.</h3>"; 
			echo "<a href='DBProject_AdvancedSearch.php' style='text-decoration: none; margin-right: 100px; margin-left: 50px; font-size: 20px;'>Back to Advanced Search</a>";
            echo "<a href='DBProject_Logout.php' style='text-decoration: none; margin-left: 100px; font-size: 20px;'>Logout</a>";
            exit();
        }


        echo "<h2 style='text-align: center; margin-bottom: 0px'>{$header2}</h2>";
        echo "<h3 style='text-align: center; margin-bottom: 0px'>Pulled {$rows} results</h3>";
        
	}
    ?>  
        <button type="button" style="background-color: #24a0ed; margin-left: 580px; width: 90px;"><a href="DBProject_AdvancedSearch.php" style="text-decoration: none; color: white;">Back</a></button>
        <button type="button" style="background-color: #b23b3b; margin-left: 580px; width: 90px;"><a href="DBProject_Logout.php" style="text-decoration: none; color: white;">Logout</a></button>
        <ul class='firstResult-list'>
        <?php 
        foreach($searchResult as $albums){
            echo"<li>Title: {$albums['title']}</li>";
            
            if(!(empty($albums['art_name']))){
                echo"<ul><li>Artist: {$albums['art_name']}</li>";
            }else {  
                echo"<ul><li>Artist: N/A</li>";
            }


            if(!(empty($albums['year_of_pub']))){
                echo"<li>Year: {$albums['year_of_pub']}</li>";
            }else {
                echo"<li>Year: N/A</li>";
            }

            if(!(empty($albums['genre']))){
                echo"<li> Genre: {$albums['genre']}</li>";
            }else {
                echo"<li> Genre: N/A</li>"; 
            }
             

            echo"<li><a href='DBProject_MyPlaylistAdd.php/?album_id={$albums['album_id']}&title={$albums['title']}'>Add To Favorites</a></li></ul>";
            echo"<br>";
        }
        echo"</ul>";
        echo"</div>";
    
        ?>
</form>