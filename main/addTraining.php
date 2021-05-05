<?php
    include "../login/checkSession.php";

    include "../components/head.php";

    include "../components/navbar.php";


?>

<?php
    include '../db/connect_to_db.php';
    $conn = get_db_connection("csc335");


    if (isset($_POST['price']) && isset($_POST['description']) && isset($_POST['date']) && isset($_POST['price'])) {
            
        echo ("insert into training (trainer, location, description, price, _date) values 
        ('" . $_SESSION['email'] . "',
        '" . $_POST['location'] . "',
        '" . $_POST['description'] . "',
        '" . $_POST['price'] . "',
        '" . $_POST['date'] . "');");
        // If the email is not taken, create a new user
        $meetupAddResults = $conn->query("insert into training (trainer, location, description, price, _date) values 
                                        ('" . $_SESSION['email'] . "',
                                        '" . $_POST['location'] . "',
                                        '" . $_POST['description'] . "',
                                        '" . $_POST['price'] . "',
                                        '" . $_POST['date'] . "');");

        if ($meetupAddResults) {
            echo "Training successfully added!";
            header("Location: /petSocialMedia/main/training.php");
        } else {
            echo "Something went wrong...";
        }
        
    } 
?>

<div class="container">

    <div class="display-4 m-2 p-2">
        Add Training
    </div>

    <div class="border m-2 p-2" style="background-color:azure;">
        <form method="POST" action="" class="form-group">

            <div class="p-3">
                <label class="input-group-text" for="location">Location</label>
                <input class="form-control" id="location" name="location" type="text">
            </div>

            <div class="p-3">
                <label class="input-group-text" for="description">Description</label>
                <input class="form-control" id="description" name="description" type="text">
            </div>

            <div class="p-3">
                <label class="input-group-text" for="date">Date</label>
                <input class="form-control" id="date" name="date" type="date">
            </div>

            <div class="p-3">
                <label class="input-group-text" for="price">Price</label>
                <input class="form-control" id="price" name="price" type="number">
            </div>


            <div class="p-3 text-center">
                <input type="hidden" name="action_type" value=<?="select"?>></input>
                <input class="btn btn-primary m-2 text-center" type="submit" value="Create Training">
            </div>

        </form>
    </div>

</div>








<?php
include "../components/jsDependencies.php";
?>

</body>
</html>