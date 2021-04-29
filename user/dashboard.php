<?php
    include "../login/checkSession.php";

    include "../components/head.php";

    include "../components/navbar.php";

    echo "<h1>Dashboard Page:</h1>";
    echo "<h3> Hello " . $_SESSION['firstName']
?>