<?php
include "../login/checkSession.php";

include "../components/head.php";

include "../components/navbar.php";

include '../db/connect_to_db.php';

$conn = get_db_connection("csc335");

if (isset($_POST['commentPostID'])) {
    $postCommentResult = $conn->query("INSERT INTO comment (body, postID, person) VALUES ('" . $_POST['commentPostBody'] . "','" . $_POST['commentPostID'] . "','" . $_SESSION['email'] . "');");

}
if (isset($_POST['commentDelete'])) {
    $postCommentResult = $conn->query("DELETE FROM comment WHERE commentID =" . $_POST['commentDelete'] . ";");

}


$userEmail = htmlspecialchars($_GET["user"]);

$userResults = ($conn->query("select * from person where email='" . $userEmail . "';"))->fetch_assoc();

echo "<div class='container'>";
echo "<div class='display-4'>" . $userResults['firstName'] . " " . $userResults['lastName'] . "</div>";
echo "<div class='h3 text-info'>" . $userResults['email'] . "</div>";

$petResults = $conn->query("select * from pet where person='" . $userEmail . "';");

echo "<h2 class='p-3 m-3'>Pets: </h2>";
while ($row = $petResults->fetch_assoc()) {
    echo "<div class='m-3 p-2 border' style='background-color:rgb(225,220,235);'>";
    echo "<div class='row border p-3 m-2' style='background-color:azure;'>";
        echo "<div class='col'>";
            echo "<h3>Pet Name: <span class='text-primary'>" . $row['name'] . "</span></h3>";
            echo "<h4>Species: <span class='text-primary'>" . $row['species'] . "</span></h3>";
        echo "</div>";
    $bioResults = $conn->query("select * from bio where pet='" . $row['petID'] . "';");
        echo "<div class='col'>";
    if ($bioAssoc = $bioResults->fetch_assoc()) {
        echo "<h4>About Me:</h4> <h3 class='text-primary font-weight-bold'>" . $bioAssoc['aboutMe'] . "</h3>";
        echo "<h4>Country</h4> <h3 class='text-primary'>" . $bioAssoc['country'] . "</h3>";
        echo "<h4>State</h4> <h3 class='text-primary'>" . $bioAssoc['state'] . "</h3>";
        echo "<h4>Town</h4> <h3 class='text-primary'>" . $bioAssoc['town'] . "</h3>";
    }

    echo "</div>";
    echo "</div>";
    $petPicResults = $conn->query("select * from picture where pet='" . $row['petID'] . "';");

    if ($petPicResults->num_rows > 0) {
        echo "<h2>Pictures of {$row['name']}:</h2>";
        echo "<div class='border p-3 m-3 d-flex justify-content-center' style='background-color:rgb(250,240,240);'>";

    }
    while ($petPicRow = $petPicResults->fetch_assoc()) {
        echo "<img class='w-25' src='/petSocialMedia/images/" . $petPicRow['filePath'] . "'>";
    }

    if ($petPicResults->num_rows > 0) {
        echo "</div>";
    }
    echo "</div>";

}

echo "<h2>Posts:</h2>";
$postResults = $conn->query("select * from post where person='" . $userEmail . "';");

while ($row = $postResults->fetch_assoc()) {
    echo "<div class='border p-2 m-2' style='background-color:rgb(240,250,230);'>";
    echo "<h3>" . $row['title'] . "</h3>";
    echo "<p>" . $row['description'] . "</p>";
    $postPictureResult = $conn->query("select * from picture where postID='" . $row['postID'] . "';");
    if ($postPictureResult->num_rows > 0) {
        while ($picRow = $postPictureResult->fetch_assoc()) {
            echo "<p>" . $picRow['name'] . "</p>";
            echo "<p>" . $picRow['description'] . "</p>";
            echo "<img src='/petSocialMedia/images/" . $picRow['filePath'] . "'>";
        }
    }
    echo "<div class='border p-2 m-2' style='background-color:rgb(235,240,250);'>";
    echo "<h4>Comments:</h4>";
    echo "<hr>";
    $commentResults = $conn->query("select * from comment where postID='" . $row['postID'] . "';");
    if ($commentResults->num_rows > 0) {
        while ($commentRow = $commentResults->fetch_assoc()) {
            echo "<div class='row'>";
            echo "<div class='col-8'>";
            echo "<p class='text-muted'>" . $commentRow['person'] . "</p>";
            echo "<p>" . $commentRow['body'] . "</p>";

            echo "</div>";
            if ($commentRow['person'] == $_SESSION['email']) {
                echo "<div class='col-4'>";
                echo "<form method='POST' action='' class='form-group'>";

                echo "<div class='p-1 text-center'>";
                    echo "<input type='hidden' name='commentDelete' value='" . $commentRow['commentID'] . "'></input>";
                    echo "<input class='btn btn-outline-danger m-2 text-center' type='submit' value='Delete Comment'>";
                echo "</div>";
                

                echo "</form>";
                echo "</div>";
            }
            echo "</div>";






            $commentPictureResult = $conn->query("select * from picture where commentID='" . $commentRow['commentID'] . "';");
            if ($commentPictureResult->num_rows > 0) {
                while ($commentPicRow = $commentPictureResult->fetch_assoc()) {
                    echo "<p>" . $commentPicRow['name'] . "</p>";
                    echo "<p>" . $commentPicRow['description'] . "</p>";
                    echo "<img class='w-50' src='/petSocialMedia/images/" . $commentPicRow['filePath'] . "'>";
                }
            }
            echo "<hr>";
        }
    }
    echo "<form method='POST' action='' class='form-group'>";
    echo "<div class='p-1'>";
        echo "<label class='input-group-text' for='commentPostBody'>Body: </label>";
        echo "<textarea class='form-control' id='commentPostBody' name='commentPostBody' rows='2' cols='35'></textarea>";
    echo "</div>";

    echo "<div class='p-1 text-center'>";
        echo "<input type='hidden' name='commentPostID' value='" . $row['postID'] . "'></input>";
        echo "<input class='btn btn-primary m-2 text-center' type='submit' value='Create Comment'>";
    echo "</div>";
    

    echo "</form>";
    echo "</div>";
    echo "</div>";
}
echo "</div>";





include "../components/jsDependencies.php";
?>

</body>

</html>