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
                        $result = $conn->query("SELECT * FROM person");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?> 
                                <li>
                                <?php 
                                    echo $row['firstName'] . " " . $row['lastName'] . "<br>" . $row['email'];
                                    
                                    
                                ?>
                                <form action="" method="POST">
                                <button type="submit" class="btn btn-success">Send Friend Request</button>
                                <input type='hidden' name='friendID' value="<?php echo $row['email']; ?>"></input>
                                </form>
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
    $result = $conn->query("INSERT INTO friends (friendOne, friendTwo) VALUES ('" . $_SESSION['email'] . "','" . $_POST['friendID'] . "');");
}


include "../components/jsDependencies.php";
    ?>
    
</body>

</html>