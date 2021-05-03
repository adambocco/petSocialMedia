<?php
    include "../login/checkSession.php";

    include "../components/head.php";

    include "../components/navbar.php";


?>

<h1>Training</h1>
<a href="addTraining.php">Add Training</a>
<div class="container">
<?php

    include '../db/connect_to_db.php';
    
    $conn = get_db_connection("csc335");

    $meetupResults = $conn->query("select * from training;");

    while ($row = $meetupResults->fetch_assoc()) {

        $attendeeResults = $conn->query("select * from trainee where trainingID=" . $row['trainingID'] . ";");



        echo "<div class='border p-3 m-3'>";
        echo "<div class='row'>";
        echo "<div class='col'>";
        echo "<h2>Trainer:</h2> <h3 class='text-primary font-weight-bold'>" . $row['trainer'] . "</h3>";
        echo "<h3>Desctiption:</h3> <h4 class='text-secondary'>" . $row['description'] . "</h4>";
        echo "<h3>Location:</h3> <h4 class='text-primary font-weight-bold'>" . $row['location'] . "</h4>";
        echo "<h3>Price:</h3> <h4 class='text-primary font-weight-bold'>$" . $row['price'] . "</h4>";
        echo "<h3>Date:</h3> <h4 class='text-primary font-weight-bold'>" . $row['_date'] . "</h4>";
        echo "</div>";
        echo "<div class='col'>";
        echo "<form method='POST' action='' class='form-group'>";




        echo "<select name='petSelect'>";
        $selectedSet = false;
        foreach($_SESSION['pets'] as $pet) {
            if (!$selectedSet) {
                echo "<option selected value=" . $pet['petID'] . ">" . $pet['name'] . "</option>";
                $selectedSet = true;
            } else {
                echo "<option value=" . $pet['petID'] . ">" . $pet['name'] . "</option>";
            }
        }
        echo "</select>";


        echo "<button type='submit' class='btn btn-success'>Sign up!</button>";
        echo "<input type='hidden' value=<?='select'?></input>";
        echo "<input type='hidden' name='trainingID' value=" . $row['trainingID'] . "></input>";
        echo "</form>";

        echo "<h2>Attendees:</h2>";
        while ($row1 = $attendeeResults->fetch_assoc()) {
            $petTraineeResults = $conn->query("select * from pet where petID=" . $row1['pet'] . ";");
            while ($row2 = $petTraineeResults->fetch_assoc()) {
                echo "<p class='font-weight-bold'>" . $row2['name']  . "</p>";
                echo "<p>" . $row2['person']  . "</p>";
                echo "<p class='text-muted'>" . $row2['species']  . "</p>";
            }

        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    if (isset($_POST['petSelect'])) {
        echo $_POST['petSelect'] . "PETSELECT";
        echo $_POST['trainingID'] . "TRAININGID";
        $attendResults = $conn->query("insert into trainee (trainingID, pet) values 
                                ('" . $_POST['trainingID'] . "',
                                '" . $_POST['petSelect'] . "');");
    }

?>

</div>




<?php
include "../components/jsDependencies.php";
?>

</body>
</html>