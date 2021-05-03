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
                                <option value="dog">Dog</option>
                                <option value="cat">Cat</option>
                            </select>
                        </div>


                        <div class="p-3 text-center">
                            <input type="hidden" name="action_type" value=<?= "select" ?>></input>
                            <input class="btn btn-primary m-2 text-center" type="submit" value="Register">
                        </div>

                    </form>
                </div>

                <?php
                if (isset($_POST['petName'])) {

                // create pet name in db
                $registerResults = $conn->query("insert into pet (name, species, person) values 
                                                ('" . $_POST['petName'] . "',
                                                '" . $_POST['species'] . "',
                                                '" . $_SESSION['email'] . "');");

                if ($registerResults) {
                    echo "Pet Added!!!";

                    // Add newly created pet to session list of pets for this user
                    $userPetResults = $conn->query("select * from pet where person='" . $_SESSION['email'] . "';");
                    $_SESSION['pets'] = array();
                    while ($row = $userPetResults->fetch_assoc()) {
                        array_push($_SESSION['pets'], $row);
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