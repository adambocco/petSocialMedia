<?php


include '../db/connect_to_db.php';
$loginFailed = false;
$conn = get_db_connection("csc335");
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION["email"] = $_POST['email'];
    $_SESSION["pass"] = $_POST['password'];

    $pass1 = crypt($_SESSION["pass"], '$1$somethin$');
    
    $passResult = $userResults = $conn->query("select password from users where email='" . $_POST['email'] . "';");

    if ($passResult->num_rows > 0) {
        if ($pass1 == $passResult->fetch_assoc()['password']) {
            echo "PASSWORDS MATCH!";
            header("Location: /petSocialMedia/user/home.php");
        } else {
            $loginFailed = true;
            session_unset(); 
            session_destroy(); 
            $_SESSION = array();
        }
    } 
    else {
        $loginFailed = true;
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
