

<!DOCTYPE HTML> 
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Basic Album Search</title>
    <link rel="stylesheet" href="DBProject_Style.css">
    <?php
        include("DBProject_AccountLoginBackend.php");
        if(empty($_SESSION['user_id']) || !(isset($_SESSION['user_id'])) ){
            echo"You logged out already. Please login to return to the menu. </br>"; 
            echo "<button type='button' style='background-color:#24a0ed; width: 90px;'><a href='DBProject_Login.html' style='text-decoration: none;'>Login Menu</a></button>";
            exit();
        }

    ?>
</head>


<body style="background-color: #2E3047">
<form class="flexbox-menuform" action="DBProject_backend.php" method='post'> <!-- container for the full flexbox-->
    <h1 style="text-align: center; margin-bottom: 0px"> Library of Music Discographies </h1>
    <h2 style="text-align: center; margin-bottom: 0px; margin-right: 40px;">Basic Album Search</h2>
    <div class="fieldbox" style="padding-bottom: 40px;">
        <header>
        Enter Search Fields
        <button type="button" style="background-color: #b23b3b; margin-left: 600px; width: 90px;"><a href="DBProject_Logout.php" style="text-decoration: none; color: white;">Logout</a></button>
        </header>
        *Some basic searches can take a while.<br>
            <label for="method" style="margin-top: 0px">Search By</label>
                <select name="method">
                    <option value="Default">--Select Search Method--</option>
                    <option value="genre">Genre</option>
                     <option value="art_name">Artist Name</option>
                    <option value="title">Album Title</option>
                    <option value="year_of_pub">Year Of Publication</option>
                     <option value="MTV">MTV Critic Scores</option>
                     <option value="RollingStone">Rolling Stone Critic Scores</option>
                </select><br><br>

            <label for="entry" style="margin-left: 490px;" id="entry">Entry</label><br>
                <input type="text" name="entry" placeholder="Enter Search Field" required><br>

            <button type="submit" style="background-color:#24a0ed; margin-bottom: 0px; margin-left: 425px; width: 90px;">Submit</button>
            <button type="reset" style="background-color:#24a0ed; margin-bottom: 0px; margin-left:  0px; width: 90px;">Reset</button>
            <button type="button" style="background-color:#24a0ed; margin-bottom: 0px; margin-left: 425px; width: 90px;"><a href="DBProject_AdvancedSearch.php" style="text-decoration: none;">Adv. Search</a></button>
            <button type="button" style="background-color:#24a0ed; margin-bottom: 0px; margin-left: 0px; width: 90px;"><a href='DBProject_MainMenu.php' style='text-decoration: none;'>Go Home</a></button>
        
    </div>
    </form>   
</body>
</html>