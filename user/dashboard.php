<?php
    include '../db/connect_to_db.php';

    $conn = get_db_connection("csc335");

    include "../login/checkSession.php";

    include "../components/head.php";

    include "../components/navbar.php";


?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Dashboard</h1>
            <h3>Hello, <?php echo $_SESSION['firstName']?></h3>
            <div class="card">
                <h3>Your pets:</h3>
                <ul>
                    <?php 
                    
                    // selecting pets only from person logged in, displaying in list
                        $result = $conn->query("SELECT * FROM pet WHERE person='{$_SESSION['email']}'");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                echo "<a class='d-block' href='/petSocialMedia/user/petProfile.php?pet=" . $row['petID'] . "'>" . $row['name'] . "</li>";

                            }
                        } else {
                            echo "No Pets!";
                        }
                    ?>
                </ul>
                <a href="addPet.php">Add a Pet</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h1>Friends</h1>
            <?php

            $friendsResult = $conn->query("SELECT * FROM friends WHERE friendOne='{$_SESSION['email']}'");
            if ($friendsResult->num_rows > 0) {
                while ($row = $friendsResult->fetch_assoc()) {
                    if ($row['accepted'] != 0) {

                    ?> 
                    <li><?php echo $row['friendTwo'];?></li>
                    <?php
                    }
                }
            } else {
                echo "No Friends!";
            }

            ?>
        </div>

        <div class="col">
            <h1>Friend Requests</h1>
            <?php

                $friendsResult = $conn->query("SELECT * FROM friends WHERE friendOne='{$_SESSION['email']}'");
                if ($friendsResult->num_rows > 0) {
                    while ($row = $friendsResult->fetch_assoc()) {
                        if ($row['accepted'] == 0) {

                        ?> 
                        <li><?php 
                            echo $row['friendTwo'];
                            echo "<form action='' method='POST'>";
                            echo "<button type='submit'>Accept</button>";
                            echo "<input type='hidden' name='acceptFriend' value=" . $row['friendTwo'] . "></input>";
                            echo "</form>";
                            ?></li>
                        <?php
                        }
                    }
                } else {
                    echo "No Friend Requests!";
                }

                if (isset($_POST['acceptFriend'])) {
                    $friendsResult = $conn->query("UPDATE friends SET accepted=1 WHERE friendOne='{$_SESSION['email']}' and friendTwo='{$_POST['acceptFriend']}';");
                }

            ?>
    
        </div>

    </div>
    <div class="row">
        <div class="col">
            <h1>News Feed</h1>
            
    
        </div>
    </div>

</div>
<?php
include "../components/jsDependencies.php";
    ?>
    
</body>

</html>