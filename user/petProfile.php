
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

                $bioResults = $conn->query("SELECT * FROM bio WHERE pet='" . htmlspecialchars($_GET["pet"]) . "'");
                $bioAssoc = $bioResults -> fetch_assoc();

                if ($bioAssoc) {

                    echo "<div class='border p-3 m-3'>";
                    echo "<div class='row'>";
                    echo "<div class='col'>";
                    echo "<h2>About Me:</h2> <h3 class='text-primary font-weight-bold'>" . $bioAssoc['aboutMe'] . "</h3>";
                    echo "<h3>Country</h3> <h4 class='text-danger font-weight-bold'>" . $bioAssoc['country'] . "</h4>";
                    echo "<h3>State</h3> <h4 class='text-secondary'>" . $bioAssoc['state'] . "</h4>";
                    echo "<h3>Town</h3> <h4 class='text-primary font-weight-bold'>" . $bioAssoc['town'] . "</h4>";
                    echo "</div>";
                    echo "</div>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                    
                } else {
                    echo "No Bio Info Found";
                }

            ?>
            
        </div>
        <a href="addBio.php?petid=<?php echo $petAssoc['petID'] ?>">Edit Bio</a>
    </div>
    

</div>
<?php
include "../components/jsDependencies.php";
    ?>
    
</body>

</html>
