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
            <h3>Hello, <?php echo $_SESSION['firstName'] ?></h3>
            <div class="card">
                <h3>Add a Pet:</h3>


                <div>
                    <form method="POST" action="" class="form-group">

                        <div class="p-3">
                            <label class="input-group-text" for="petName">Enter Pet Name: </label>
                            <input class="form-control" id="petName" name="petName" type="petName">
                        </div>

                        <div class="p-3">
                            <select name="species" id="species">
                                <option selected value="dog">Dog</option>
                                <option value="cat">Cat</option>
                            </select>
                        </div>

                        <div class="p-3">
                            <label class="input-group-text" for="aboutMe">About Me </label>
                            <input class="form-control" id="aboutMe" name="aboutMe" type="aboutMe">
                        </div>

                        <div class="p-3">
                            <label class="input-group-text" for="country">Country </label>
                            <input class="form-control" id="country" name="country" type="country">
                        </div>

                        <div class="p-3">
                            <label class="input-group-text" for="state">State </label>
                            <input class="form-control" id="state" name="state" type="state">
                        </div>

                        <div class="p-3">
                            <label class="input-group-text" for="town">Town </label>
                            <input class="form-control" id="town" name="town" type="town">
                        </div>

                        <div class="p-3 text-center">
                            <input type="hidden" name="action_type" value=<?= "select" ?>></input>
                            <input class="btn btn-primary m-2 text-center" type="submit" value="Add Pet Info">
                        </div>

                    </form>
                </div>


                <?php

                // Add Pet
                if (isset($_POST['petName']) && isset($_POST['species'])) {

                    // create pet name in db
                    $registerResults = $conn->query("insert into pet (name, species, person) values 
                                                ('" . $_POST['petName'] . "',
                                                '" . $_POST['species'] . "',
                                                '" . $_SESSION['email'] . "');");

                    if ($registerResults) {
                        echo "Pet Added!!!";
                        $last_id = $conn->insert_id;
                        echo "Last inserted pet ID:" . $last_id;
                        // Add newly created pet to session list of pets for this user
                        $userPetResults = $conn->query("select * from pet where person='" . $_SESSION['email'] . "';");
                        $_SESSION['pets'] = array();
                        while ($row = $userPetResults->fetch_assoc()) {
                            array_push($_SESSION['pets'], $row);
                        }
                        // Add Bio

                        if (isset($_POST['aboutMe']) && isset($_POST['country']) && isset($_POST['state']) && isset($_POST['town'])) {

                            // create pet name in db
                            $registerResults = $conn->query("insert into bio (pet, aboutMe, country, state, town) values 
                        ('" . $last_id . "',
                        '" . $_POST['aboutMe'] . "',
                        '" . $_POST['country'] . "',
                        '" . $_POST['state'] . "',
                        '" . $_POST['town'] . "');");

                            if ($registerResults) {
                                echo "Bio Added!!!";
                            } else {
                                echo "Something went wrong...";
                            }
                        }
                    } else {
                        echo "Something went wrong...";
                    }
                }

                include "../components/jsDependencies.php";
                ?>





            </div>
        </div>
    </div>
</div>