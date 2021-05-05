<?php
    include "../login/checkSession.php";

    include "../components/head.php";

    include "../components/navbar.php";
    include '../db/connect_to_db.php';
    
    $conn = get_db_connection("csc335");

    if (isset($_POST['action_type'])) {
        $attendResults = $conn->query("insert into attendee (meetupID, person, maybeAttending) values 
                                ('" . $_POST['meetupID'] . "',
                                '" . $_SESSION['email'] . "',
                                " . 1 . ");");
        echo $attendResults;
    }
?>


<div class="container">
<div class="display-4">Meetups</div>
<a class="btn btn-primary m-2 p-2" href="addMeetup.php">Add Meetup</a>
<?php



    $meetupResults = $conn->query("select * from meetup;");

    while ($row = $meetupResults->fetch_assoc()) {

        $attendeeResults = $conn->query("select * from attendee where meetupID=" . $row['meetupID'] . ";");



        echo "<div class='border p-3 m-3' style='background-color:rgb(235,235,255);'>";
        echo "<div class='row'>";
        echo "<div class='col-8'>";
        echo "<h3>Meetup Name:</h3> <h2 class='text-primary font-weight-bold'>" . $row['name'] . "</h2>";
        echo "<h3>Creator:</h3> <h4 class='text-primary font-weight-bold'>" . $row['creator'] . "</h4>";
        echo "<h3>Description:</h3><div class='border m-2 p-2'> <h4 class='text-secondary'>" . $row['description'] . "</h4></div>";
        echo "<div>Date:</div> <h5 class='text-primary font-weight-bold'>" . $row['_date'] . "</h5>";
        echo "<div>Time:</div> <h5 class='text-primary font-weight-bold'>" . $row['_time'] . "</h5>";
        echo "<div>Duration:</div> <h5 class='text-primary font-weight-bold'>" . $row['duration'] . "</h5>";
        echo "<div>Country:</div> <h5 class='text-primary font-weight-bold'>" . $row['country'] . "</h5>";
        echo "<div>State:</div> <h5 class='text-primary font-weight-bold'>" . $row['state'] . "</h5>";
        echo "</div>";
        echo "<div class='col-4 border p-2 text-center' style='background-color:azure;'>";
        echo "<form method='POST' action='' class='form-group'>";
        echo "<button type='submit' class='w-100 btn btn-success'>Attend</button>";
        echo "<input type='hidden' name='action_type' value=<?='select'?></input>";
        echo "<input type='hidden' name='meetupID' value=" . $row['meetupID'] . "></input>";
        echo "</form>";

        echo "<h3>Attendees:</h3>";
        while ($row = $attendeeResults->fetch_assoc()) {
            echo "<a href='/petSocialMedia/main/userProfile.php?user=" . $row['person'] . "' class='btn btn-primary'>" . $row['person'] . "</a>";
        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }

?>

</div>




<?php
include "../components/jsDependencies.php";
?>

</body>
</html>