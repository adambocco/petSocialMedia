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
    <!-- NAVBAR -->

    <div class="container">

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

                <div class="p-3 text-center">
                    <input type="hidden" name="action_type" value=<?="select"?>></input>
                    <input class="btn btn-primary m-2 text-center" type="submit" value="Register">
                </div>

            </form>
        </div>

    </div>
    <?php
        if (isset($_POST['email'])) {
            
            // Check if email entered by user exists in the database
            $userResults = $conn->query("select * from users where email='" . $_POST['email'] . "';");

            if ($userResults->num_rows > 0) {
                echo "EMAIL TAKEN";
            } else {
                
                $pass = crypt($_POST['password1'], '$1$somethin$');

                // If the email is not taken, create a new user
                $registerResults = $conn->query("insert into users (email, password, firstName, lastName, createdAt) values 
                                                ('" . $_POST['email'] . "',
                                                '" . $pass . "',
                                                '" . $_POST['firstName'] . "',
                                                '" . $_POST['lastName'] . "',
                                                curdate());");

                if ($registerResults) {
                    echo "Registration successful!";
                } else {
                    echo "Something went wrong...";
                }
            }
        }
    include "../components/jsDependencies.php";
    ?>



    
</body>

</html>