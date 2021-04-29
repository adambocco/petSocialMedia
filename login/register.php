<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous" />

    <title>Document</title>
</head>

<body>


    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Pet Social Media</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- NAVBAR -->

    <div class="container">
        <?php

        include '../db/connect_to_db.php';

        $conn = get_db_connection("csc335");

        ?>


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
                
                // If the email is not taken, create a new user
                $registerResults = $conn->query("insert into users (email, password, firstName, lastName, createdAt) values 
                                                ('" . $_POST['email'] . "',
                                                '" . $_POST['password1'] . "',
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
    ?>


        
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>