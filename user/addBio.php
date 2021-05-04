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
            <h2>Edit Pet Bio</h2>
            <div class="card">
                <h3>Edit Pet Bio:</h3>


                <div>
                    <form method="POST" action="" class="form-group">

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
                            <input class="btn btn-primary m-2 text-center" type="submit" value="Add Bio">
                        </div>

                    </form>
                </div>

                <?php
                if (isset($_POST['aboutMe'])) {
               
                // create bio name in db

                $registerResults = $conn->query("insert into bio (pet, aboutMe, country, state, town) values 
                                                ('" . $_GET['petid'] . "',
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
                
                include "../components/jsDependencies.php";
                ?>





            </div>
        </div>
    </div>
</div>