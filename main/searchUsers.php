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
        <h3>Users:</h3>
            <div class="card">

                <ul>
                    <?php 
                    
                    // selecting pets only from person logged in, displaying in list
                        $userFriends = $conn->query("SELECT * FROM friends WHERE friendOne='" . $_SESSION['email'] . "' OR friendTwo='" . $_SESSION['email'] . "';");
                        $friendsEmailArray = array();
                        while ($row = $userFriends->fetch_assoc()) {
                            if ($row['friendTwo'] == $_SESSION['email']) {
                                array_push($friendsEmailArray, $row['friendOne']);
                            } else {
                                array_push($friendsEmailArray, $row['friendTwo']);
                            }
                        }

                        $result = $conn->query("SELECT * FROM person");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                if (($row['email'] == $_SESSION['email'])) {
                                    continue;
                                }
                                ?> 
                                <li>
                                <?php 
                                    echo $row['firstName'] . " " . $row['lastName'] . "<br>" . $row['email'];
                                    
                                    
                                ?>
                                <?php 
                                    if (!in_array($row['email'], $friendsEmailArray)) {
                                        echo "<form action='' method='POST'>";
                                        echo "<button type='submit' class='btn btn-success'>Send Friend Request</button>";
                                        echo "<input type='hidden' name='friendID' value=" . $row['email'] . "></input>";
                                        echo "</form>";
                                    
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
if (isset($_POST['friendID'])) {
    $result = $conn->query("INSERT INTO friends (friendOne, friendTwo) VALUES ('" . $_POST['friendID'] . "','" . $_SESSION['email'] . "');");
}


include "../components/jsDependencies.php";
    ?>
    
</body>

</html>