<!DOCTYPE html>
<html>
<head>
    <title>Main Menu</title>
    <?php
    include('DBProject_AccountLoginBackend.php');
    
    if(empty($_SESSION['username']) || !(isset($_SESSION['username'])) ){
        echo"You logged out already. Please login to return to the menu. </br>"; 
        echo "<button type='button' style='background-color:#24a0ed; width: 90px;'><a href='DBProject_Login.html' style='text-decoration: none;'>Login Menu</a></button>";
            exit();
    }

    $username = $_SESSION['username'];

    echo "<link rel='stylesheet' href='DBProject_Style.css'>"; //Sometimes, php causes the Styling to act werid, and is fixed by including style sheet via php. 
    ?>
</head>
<body>
    <body style="background-color: #2E3047">
        <div class="flexbox-menuform"> <!-- container for the full flexbox-->
            <h1 style="text-align: center; margin-bottom: 0px">Library of Music Discographies</h1>
            <?php echo "<h2 style='text-align: center; margin-bottom: 0px'>Welcome, {$username}!</h2><br>"; ?>
            <div class="fieldbox" style="padding-bottom: 30px;">
            <h3 style="text-align: center; margin-bottom: 0px;">Main Menu</h3>
        
            <button type="reset" style="background-color:#24a0ed; margin-bottom: 0px; margin-left: 425px; width: 120px;"><a href='DBProject_SearchInput.php' style='text-decoration: none;'>Basic Search</a></button>
            <button type="reset" style="background-color:#24a0ed; margin-bottom: 0px; margin-left: 0px; width: 120px;"><a href='DBProject_AdvancedSearch.php' style='text-decoration: none;'>Adv. Search</a></button>
            <button type="button" style="background-color:#24a0ed; margin-bottom: 0px; margin-left: 485px; width: 120px;"><a href='DBProject_MyPLaylist.php' style='text-decoration: none;'>My Favorites</a></button>
            <button type="button" style="background-color: #b23b3b; margin-left: 500px; width: 90px;"><a href="DBProject_Logout.php" style="text-decoration: none; color: white;">Logout</a></button>
            </div>
            <p style="text-align: center; margin-bottom: 0px;">This website offers a large discrography of 100,000 albums and 90,000 artists to look through! </p>
            <p style="text-align: center; margin-bottom: 0px;">You can add any albums you like to your favorites! Simply search for the album and select the add link associated with it.</p>
            <p style="text-align: center;  margin-bottom: 0px;"> If you want to remove a album, navigate to your favorites list and click the remove link associated with it.</p><br>
            <p style="text-align: center; margin-bottom: 0px;"><b><i>Notice:</b></i> If a button does not seem to be working, make sure you are clicking on the <u>text inside of it.</u></p>
        </div> 
</body>
</html>