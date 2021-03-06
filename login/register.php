<?php


include '../db/connect_to_db.php';

$conn = get_db_connection("csc335");

?>

<!DOCTYPE html>
<html lang="en">

<?php
    include "../components/head.php";
?>

<body>


    <!-- NAVBAR -->
    <?php
        include "../components/navbar.php";
    ?>
    <div class="container">
    <?php

        if (isset($_POST['email'])) {
            
            // Check if email entered by user exists in the database
            $userResults = $conn->query("select * from person where email='" . $_POST['email'] . "';");

            if ($userResults->num_rows > 0) {
                echo "EMAIL TAKEN";
            } else {
                
                $pass = crypt($_POST['password1'], '$1$somethin$');

                $registerResults = null;
                if (isset($_POST['isAdmin']) and isset($_POST['adminPasscode'])) {
                    if ($_POST['adminPasscode'] == '123') {
                        $registerResults = $conn->query("insert into person (email, password, firstName, lastName, isAdmin) values 
                        ('" . $_POST['email'] . "',
                        '" . $pass . "',
                        '" . $_POST['firstName'] . "',
                        '" . $_POST['lastName'] . "',1);");
                        echo "<h4>ADMIN ACCOUNT CREATED!</h4>";
                    }
                    else {
                        echo "<h4>WRONG ADMIN PASSCODE!</h4>";
                    }
                }
                else {
                    $registerResults = $conn->query("insert into person (email, password, firstName, lastName) values 
                    ('" . $_POST['email'] . "',
                    '" . $pass . "',
                    '" . $_POST['firstName'] . "',
                    '" . $_POST['lastName'] . "');");
                }
                // If the email is not taken, create a new user


                if ($registerResults) {
                    echo "<div class='text-success font-weight-bold'>Registration successful!</div>";
                    echo "<a class='btn btn-info m-4' href='/petSocialMedia/login/login.php'>Go To Login!</a>";
                } else {
                    echo "Something went wrong...";
                }
            }
        }
    ?>
    <!-- NAVBAR -->



        <div>
            <form method="POST" action="" class="form-group">

                <div class="p-3">
                    <label class="input-group-text" for="email">Enter Email Address: </label>
                    <input class="form-control" id="email" name="email" type="email">
                </div>

                <div class="p-3">
                    <label class="input-group-text" for="firstName">Enter First Name: </label>
                    <input class="form-control" id="firstName" name="firstName" type="text">
                </div>

                <div class="p-3">
                    <label class="input-group-text" for="lastName">Enter Last Name: </label>
                    <input class="form-control" id="lastName" name="lastName" type="text">
                </div>

                <div class="p-3">
                    <label class="input-group-text" for="password1">Enter a Password: </label>
                    <input class="form-control" id="password1" name="password1" type="password">
                </div>

                <div class="p-3">
                    <label class="input-group-text" for="password2">Enter Password Again: </label>
                    <input class="form-control" id="password2" name="password2" type="password">
                </div>

                <div class="p-3">
                    <label class="input-group-text" for="isAdmin">Admin Account? : </label>
                    <input class="form-control" id="isAdmin" name="isAdmin" type="checkbox">
                </div>

                <div class="p-3">
                    <label class="input-group-text" for="adminPasscode">Admin Account Creation Code (psst.. it's '123'): </label>
                    <input class="form-control" id="adminPasscode" name="adminPasscode" type="password">
                </div>

                <div class="p-3 text-center">
                    <input type="hidden" name="action_type" value=<?="select"?>></input>
                    <input class="btn btn-primary m-2 text-center" type="submit" value="Register">
                </div>

            </form>
        </div>

    </div>
    <?php
    include "../components/jsDependencies.php";
    ?>
    
</body>

</html>