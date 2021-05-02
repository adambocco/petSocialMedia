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
                                ?> 
                                <li><?php echo $row['name'];?></li>
                                <?php
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
</div>