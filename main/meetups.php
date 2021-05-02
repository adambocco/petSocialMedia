<?php
    include "../login/checkSession.php";

    include "../components/head.php";

    include "../components/navbar.php";


?>

<h1>Meetups</h1>
<a href="addMeetup.php">Add Meetup</a>
<div class="container">
<?php

    include '../db/connect_to_db.php';
    
    $conn = get_db_connection("csc335");

    $meetupResults = $conn->query("select * from meetup;");

    while ($row = $meetupResults->fetch_assoc()) {

        $attendeeResults = $conn->query("select * from attendee where meetupID=" . $row['meetupID'] . ";");



        echo "<div class='border p-3 m-3'>";
        echo "<div class='row'>";
        echo "<div class='col'>";
        echo "<h2>Meetup Name:</h2> <h3 class='text-primary font-weight-bold'>" . $row['name'] . "</h3>";
        echo "<h3>Creator:</h3> <h4 class='text-danger font-weight-bold'>" . $row['creator'] . "</h4>";
        echo "<h3>Desctiption:</h3> <h4 class='text-secondary'>" . $row['description'] . "</h4>";
        echo "<h3>Date:</h3> <h4 class='text-primary font-weight-bold'>" . $row['_date'] . "</h4>";
        echo "<h3>Time:</h3> <h4 class='text-primary font-weight-bold'>" . $row['_time'] . "</h4>";
        echo "<h3>Duration:</h3> <h4 class='text-primary font-weight-bold'>" . $row['duration'] . "</h4>";
        echo "<h3>Country:</h3> <h4 class='text-primary font-weight-bold'>" . $row['country'] . "</h4>";
        echo "<h3>State:</h3> <h4 class='text-primary font-weight-bold'>" . $row['state'] . "</h4>";
        echo "</div>";
        echo "<div class='col'>";
        echo "<form method='POST' action='' class='form-group'>";
        echo "<button type='submit' class='btn btn-success'>Attend</button>";
        echo "<input type='hidden' name='action_type' value=<?='select'?></input>";
        echo "<input type='hidden' name='meetupID' value=" . $row['meetupID'] . "></input>";
        echo "</form>";

        echo "<h2>Attendees:</h2>";
        while ($row = $attendeeResults->fetch_assoc()) {
            echo "<p>" . $row['person']  . "</p>";
        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }

    if (isset($_POST['action_type'])) {
        $attendResults = $conn->query("insert into attendee (meetupID, person, maybeAttending) values 
                                ('" . $_POST['meetupID'] . "',
                                '" . $_SESSION['email'] . "',
                                " . 1 . ");");
        echo $attendResults;
    }

?>

</div>




<?php
include "../components/jsDependencies.php";
?>

</body>
</html>