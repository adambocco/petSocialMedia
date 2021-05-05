<?php
    include "../login/checkSession.php";

    include "../components/head.php";

    include "../components/navbar.php";


?>

<?php
    include '../db/connect_to_db.php';
    $conn = get_db_connection("csc335");


    if (isset($_POST['meetupName']) && isset($_POST['meetupDescription']) && isset($_POST['meetupDate']) && isset($_POST['meetupTime'])
     && isset($_POST['meetupDuration']) && isset($_POST['meetupCountry']) && isset($_POST['meetupState'])) {
            
        // Check if email entered by user exists in the database
        $userResults = $conn->query("select * from meetup where name='" . $_POST['meetupName'] . "';");

        if ($userResults->num_rows > 0) {
            echo "Meetup Name Taken";
        } else {
            // If the email is not taken, create a new user
            $meetupAddResults = $conn->query("insert into meetup (creator, name, description, _date, _time, duration, country, state) values 
                                            ('" . $_SESSION['email'] . "',
                                            '" . $_POST['meetupName'] . "',
                                            '" . $_POST['meetupDescription'] . "',
                                            '" . $_POST['meetupDate'] . "',
                                            '" . $_POST['meetupTime'] . "',
                                            '" . $_POST['meetupDuration'] . "',
                                            '" . $_POST['meetupCountry'] . "',
                                            '" . $_POST['meetupState'] . "');");

            if ($meetupAddResults) {
                echo "Meetup successfully added!";
                header("Location: /petSocialMedia/main/meetups.php");
            } else {
                echo "Something went wrong...";
            }
        }
    }
?>

<div class="container">

    <div class="display-4">Add a Meetup: </div>

    <div class="border p-2 m-2" style="background-color:azure;">
        <form method="POST" action="" class="form-group">

            <div class="p-3">
                <label class="input-group-text" for="meetupName">Meetup Name</label>
                <input class="form-control" id="meetupName" name="meetupName" type="text">
            </div>

            <div class="p-3">
                <label class="input-group-text" for="meetupDescription">Meetup Description</label>
                <input class="form-control" id="meetupDescription" name="meetupDescription" type="text">
            </div>

            <div class="p-3">
                <label class="input-group-text" for="meetupDate">Meetup Date </label>
                <input class="form-control" id="meetupDate" name="meetupDate" type="date">
            </div>

            <div class="p-3">
                <label class="input-group-text" for="meetupTime">Meetup Time </label>
                <input class="form-control" id="meetupTime" name="meetupTime" type="time">
            </div>

            <div class="p-3">
                <label class="input-group-text" for="meetupDuration">Meetup Duration </label>
                <input class="form-control" id="meetupDuration" name="meetupDuration" type="number">
            </div>

            <div class="p-3">
                <label class="input-group-text" for="meetupCounty">Meetup Country </label>
                <input class="form-control" id="meetupCountry" name="meetupCountry" type="text">
            </div>

            <div class="p-3">
                <label class="input-group-text" for="meetupState">Meetup State </label>
                <input class="form-control" id="meetupState" name="meetupState" type="text">
            </div>

            <div class="p-3 text-center">
                <input type="hidden" name="action_type" value=<?="select"?>></input>
                <input class="btn btn-primary m-2 text-center" type="submit" value="Create Meetup">
            </div>

        </form>
    </div>

</div>



<?php
include "../components/jsDependencies.php";
?>

</body>
</html>