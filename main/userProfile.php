<?php
include "../login/checkSession.php";

include "../components/head.php";

include "../components/navbar.php";

include '../db/connect_to_db.php';

$conn = get_db_connection("csc335");

$userEmail = htmlspecialchars($_GET["user"]);

$userResults = ($conn->query("select * from person where email='" . $userEmail . "';"))->fetch_assoc();

echo "<div class='container'>";
echo $userResults['firstName'] . " " . $userResults['lastName'];

$petResults = $conn->query("select * from pet where person='" . $userEmail . "';");

echo "<h2>Pets: </h2>";
while ($row = $petResults->fetch_assoc()) {

    echo "<div class='border'>";
    echo "<h3>Pet Name: " . $row['name'] . "</h3>";
    echo "<h3>Species: " . $row['species'] . "</h3>";

    $bioResults = $conn->query("select * from bio where pet='" . $row['petID'] . "';");

    if ($bioAssoc = $bioResults->fetch_assoc()) {
        echo "<h2>About Me:</h2> <h3 class='text-primary font-weight-bold'>" . $bioAssoc['aboutMe'] . "</h3>";
        echo "<h3>Country</h3> <h4 class='text-danger font-weight-bold'>" . $bioAssoc['country'] . "</h4>";
        echo "<h3>State</h3> <h4 class='text-secondary'>" . $bioAssoc['state'] . "</h4>";
        echo "<h3>Town</h3> <h4 class='text-primary font-weight-bold'>" . $bioAssoc['town'] . "</h4>";

        $petPicResults = $conn->query("select * from picture where pet='" . $row['petID'] . "';");
        echo "<div class='d-flex'>";
        while ($petPicRow = $petPicResults->fetch_assoc()) {
            echo "<img class='w-25' src='/petSocialMedia/images/" . $petPicRow['filePath'] . "'>";
        }
        echo "</div>";
    }
    echo "</div>";
}

echo "<h2>Posts:</h2>";
$postResults = $conn->query("select * from post where person='" . $userEmail . "';");

while ($row = $postResults->fetch_assoc()) {
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
    echo "<div class='border'>";
    $commentResults = $conn->query("select * from comment where postID='" . $row['postID'] . "';");
    if ($commentResults->num_rows > 0) {
        while ($commentRow = $commentResults->fetch_assoc()) {
            echo "<p class='text-muted'>" . $commentRow['person'] . "</p>";
            echo "<p>" . $commentRow['body'] . "</p>";
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
    echo "</div>";
}
echo "</div>";





include "../components/jsDependencies.php";
?>

</body>

</html>