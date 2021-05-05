<?php
include '../db/connect_to_db.php';

$conn = get_db_connection("csc335");

include "../login/checkSession.php";

include "../components/head.php";

include "../components/navbar.php";

$result = $conn->query("SELECT * FROM pet WHERE petID='" . htmlspecialchars($_GET["pet"]) . "'");
?>
<div class="container">



    <div class="row">
        <div class="col">
            <?php
            $petAssoc = $result->fetch_assoc();
            echo "<h1>" . $petAssoc['name'] . "</h1>";
            echo "<h3> Species: " . $petAssoc['species'] . "</h3>";


            echo "<h2> Pictures: </h2>";

            $picResults = $conn->query("SELECT * FROM picture WHERE pet='" . htmlspecialchars($_GET["pet"]) . "';");

            if ($picResults->num_rows > 0) {
                while ($row = $picResults->fetch_assoc()) {
                    echo "<img class='w-50' src='/petSocialMedia/images/" . $row['filePath'] . "'>";
                }
            }



            echo "<h2> Bio: </h2>";
            $bioResults = $conn->query("SELECT * FROM bio WHERE pet='" . htmlspecialchars($_GET["pet"]) . "';");
            $bioAssoc = $bioResults->fetch_assoc();

            if ($bioAssoc) {

                echo "<div class='border p-3 m-3'>";
                echo "<div class='row'>";
                echo "<div class='col'>";
                echo "<h2>About Me:</h2> <h3 class='text-primary font-weight-bold'>" . $bioAssoc['aboutMe'] . "</h3>";
                echo "<h3>Country</h3> <h4 class='text-danger font-weight-bold'>" . $bioAssoc['country'] . "</h4>";
                echo "<h3>State</h3> <h4 class='text-secondary'>" . $bioAssoc['state'] . "</h4>";
                echo "<h3>Town</h3> <h4 class='text-primary font-weight-bold'>" . $bioAssoc['town'] . "</h4>";
                echo "</div>";
                echo "</div>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
            } else {
                echo "No Bio Info Found";
            }

            ?>

        </div>
    </div>
    <div class="row">
        <div class="col">
            <h3>Add an Image: </h3>
            <form action="" method="POST" enctype="multipart/form-data">
                Select image to upload:
                <input type="file" name="fileToUpload" id="fileToUpload">


                <div class="p-3">
                    <label class="input-group-text" for="name">Name: </label>
                    <input class="form-control" id="name" name="name" type="name">
                </div>

                <div class="p-3">
                    <label class="input-group-text" for="description">Description: </label>
                    <input class="form-control" id="description" name="description" type="description">
                </div>
                <input type="submit" value="Upload Image" name="submit">

            </form>
        </div>
    </div>
</div>
<?php


// Check if image file is a actual image or fake image

if (isset($_POST["submit"])) {
    echo $_FILES['fileToUpload']['name'];
    $target_dir = "C:\\xampp\\htdocs\\petSocialMedia\\images\\";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    echo "SUBMITTED";
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }


    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            $picInfo = $conn->query("insert into picture (filePath, name, pet, description) values 
    ('" . $_FILES["fileToUpload"]["name"] . "',
    '" . $_POST['name'] . "',
    '" . htmlspecialchars($_GET["pet"]) . "',
    '" . $_POST['description'] . "');");
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}









include "../components/jsDependencies.php";
?>

</body>

</html>