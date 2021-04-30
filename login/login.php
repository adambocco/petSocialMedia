<?php

include '../db/connect_to_db.php';

$conn = get_db_connection("csc335");

$loginFailed = false;

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pass1 = crypt($_POST["password"], '$1$somethin$');
    
    $passResult = $userResults = $conn->query("select * from person where email='" . $_POST['email'] . "';");
    
    if ($passResult->num_rows > 0) {
        $userAssoc = $passResult->fetch_assoc();
        if ($pass1 == $userAssoc['password']) {
            
            $_SESSION["email"] = $_POST['email'];
            $_SESSION["pass"] = $_POST['password'];
            $_SESSION["firstName"] = $userAssoc['firstName'];
            $_SESSION["lastName"] = $userAssoc['lastName'];

            header("Location: /petSocialMedia/user/dashboard.php");
        } else {
            $loginFailed = true;
        }
    } 

    if ($loginFailed == true) {
        session_unset(); 
        session_destroy(); 
        $_SESSION = array();
    }
    //now compare this md5 hash with the stored hashed password for this user (if this user exists)


} 

    // //remove all session variables
    // session_unset();

    // // destroy the session 
    // session_destroy();
    // $loggedIn = false;
    // echo $loggedIn;

    include "../components/head.php";
    include "../components/navbar.php";

?>

    <div class="container">
        <div class="row">
            <div class="col p-3">
                <form action="login.php" method="POST" class="form-group">
                    <?php
                        if ($loginFailed) {
                            echo "<p class='text-danger font-weight-bold'>Username or password incorrect.</p>";
                        }
                    ?>
                    <p>Please Log in:
                        <br />
                        <span class="input-group-text">Email <input class="form-control" type="Text" name="email" /> </span>
                        <br>
                        <br />
                        <span class="input-group-text">Password <input class="form-control" type="password" name="password" /> </span>
                    </p>
                    <div class="text-center"><input class="btn btn-primary" type="Submit" value="Log in" /></div>
                </form>
            </div>
        </div>
    </div>
