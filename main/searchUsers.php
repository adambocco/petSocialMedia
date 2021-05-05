<?php
    include '../db/connect_to_db.php';

    $conn = get_db_connection("csc335");

    include "../login/checkSession.php";

    include "../components/head.php";

    include "../components/navbar.php";

    if (isset($_POST['friendID'])) {
        $result = $conn->query("INSERT INTO friends (friendOne, friendTwo) VALUES ('" . $_POST['friendID'] . "','" . $_SESSION['email'] . "');");
    }
    

?>
<div class="container">
    <div class="row">
        <div class="col">
        <div class="display-4 m-2 p-2">Search All Users:</div>
            <div class="">

                <ul>
                    <?php 
                    
                    // selecting pets only from person logged in, displaying in list
                        $userFriends = $conn->query("SELECT * FROM friends WHERE friendOne='" . $_SESSION['email'] . "' OR friendTwo='" . $_SESSION['email'] . "';");
                        $friendsEmailArray = array();
                        $friendsAcceptedArray = array();
                        while ($row = $userFriends->fetch_assoc()) {
                            if ($row['friendTwo'] == $_SESSION['email']) {
                                array_push($friendsEmailArray, $row['friendOne']);
                            } else {
                                array_push($friendsEmailArray, $row['friendTwo']);
                            }
                            if ($row['accepted'] == 1) {
                                array_push($friendsAcceptedArray, 1);
                            } else {
                                array_push($friendsAcceptedArray, 0);
                            }
                        }

                        $result = $conn->query("SELECT * FROM person");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                if (($row['email'] == $_SESSION['email'])) {
                                    continue;
                                }
                                ?> 
                                <li class="border p-2 m-2">
                                <?php 
                                    echo "<span class='font-weight-bold'>" . $row['firstName'] . " " . $row['lastName'] . "</span><br>" . $row['email'];
                                    
                                    
                                ?>
                                <?php 
                                    if (!in_array($row['email'], $friendsEmailArray)) {
                                        echo "<form action='' method='POST'>";
                                        echo "<button type='submit' class='btn btn-success'>Send Friend Request</button>";
                                        echo "<input type='hidden' name='friendID' value=" . $row['email'] . "></input>";
                                        echo "</form>";
                                    
                                    } 

                                    else {
                                        if ($friendsAcceptedArray[array_search($row['email'], $friendsEmailArray)]) {
                                            echo "<div class='font-weight-bold text-success'>Friend</div>";
                                        } else {
                                            echo "<div class='font-weight-bold text-info'>Pending Friend</div>";
                                        }
                                    }
                                    echo "<a href='/petSocialMedia/main/userProfile.php?user=" . $row['email'] . "' class='btn btn-primary'>Visit Page</a>";
                                ?>
                                </li>
                                <?php
                            }
                        } else {
                            echo "No Users!";
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php

include "../components/jsDependencies.php";
    ?>
    
</body>

</html>