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
            
                </ul>
                <a href="addPet.php">Add a Pet</a>
            </div>
        </div>
    </div>
</div>