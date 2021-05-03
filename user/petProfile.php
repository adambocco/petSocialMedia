
<?php
    include '../db/connect_to_db.php';

    $conn = get_db_connection("csc335");

    include "../login/checkSession.php";

    include "../components/head.php";

    include "../components/navbar.php";

    $result = $conn->query("SELECT * FROM pet WHERE petID='" . htmlspecialchars($_GET["pet"]) . "'");
?>
<div class="container">
    <div class="row">
        <div class="col">
            <?php
                $petAssoc = $result -> fetch_assoc();
                echo "<h1>" . $petAssoc['name'] . "</h1>";
                echo "<h3> Species: " . $petAssoc['species'] . "</h3>";
                echo "<h2> Bio: </h2>";
                // TODO put bio here
            ?>
        </div>
    </div>

</div>
<?php
include "../components/jsDependencies.php";
    ?>
    
</body>

</html>
