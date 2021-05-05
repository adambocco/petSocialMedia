<?php
include '../db/connect_to_db.php';

$conn = get_db_connection("csc335");

include "../login/checkSession.php";

include "../components/head.php";

include "../components/navbar.php";



?>
                <?php

// Add Pet
if (isset($_POST['petName']) && isset($_POST['species'])) {
    
    // create pet name in db
    $registerResults = $conn->query("insert into pet (name, species, person) values 
                                ('" . $_POST['petName'] . "',
                                '" . $_POST['species'] . "',
                                '" . $_SESSION['email'] . "');");
    $lastPetID = $conn->insert_id;

    if ($registerResults) {
        $last_id = $conn->insert_id;
        // Add newly created pet to session list of pets for this user
        $userPetResults = $conn->query("select * from pet where person='" . $_SESSION['email'] . "';");
        $_SESSION['pets'] = array();
        while ($row = $userPetResults->fetch_assoc()) {
            array_push($_SESSION['pets'], $row);
        }
        // Add Bio

        if (isset($_POST['aboutMe']) && isset($_POST['country']) && isset($_POST['state']) && isset($_POST['town'])) {

            // create pet name in db
            $registerResults = $conn->query("insert into bio (pet, aboutMe, country, state, town) values 
        ('" . $last_id . "',
        '" . $_POST['aboutMe'] . "',
        '" . $_POST['country'] . "',
        '" . $_POST['state'] . "',
        '" . $_POST['town'] . "');");

            if (!$registerResults) {
                echo "Something went wrong...";
            }
        }
        if ($_FILES["fileToUpload"]['name'] != "") {
            
            echo "Adding Image: " . $_FILES["fileToUpload"]['name'] . "<br>";


            $target_dir = "C:\\xampp\\htdocs\\petSocialMedia\\images\\";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
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
                                            '" . $_POST['picName'] . "',
                                            '" . $lastPetID . "',
                                            '" . $_POST['picDescription'] . "');");
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }

        }
        header("Location: /petSocialMedia/user/petProfile.php?pet=" . $lastPetID);
    } else {
        echo "Something went wrong...";
    }
}

include "../components/jsDependencies.php";
?>
<div class="container">
    <div class="row">
        <div class="col">
        <div class="display-4 m-3 p-2">Add a Pet:</div>
            <div class="card">



                <div>
                    <form method="POST" action="" enctype="multipart/form-data" class="form-group">

                        <div class="p-3">
                            <label class="input-group-text" for="petName">Enter Pet Name: </label>
                            <input class="form-control" id="petName" name="petName" type="petName">
                        </div>

                        <div class="p-3">
                            <select name="species" id="species">
                                <option selected value="dog">Dog</option>
                                <option value="cat">Cat</option>
                            </select>
                        </div>

                        <div class="p-3">
                            <label class="input-group-text" for="aboutMe">About Me </label>
                            <input class="form-control" id="aboutMe" name="aboutMe" type="aboutMe">
                        </div>

                        <div class="p-3">
                            <label class="input-group-text" for="country">Country </label>
                            <input class="form-control" id="country" name="country" type="country">
                        </div>

                        <div class="p-3">
                            <label class="input-group-text" for="state">State </label>
                            <input class="form-control" id="state" name="state" type="state">
                        </div>

                        <div class="p-3">
                            <label class="input-group-text" for="town">Town </label>
                            <input class="form-control" id="town" name="town" type="town">
                        </div>

                        <div class="p-3 text-center">
                            <input type="hidden" name="action_type" value=<?= "select" ?>></input>
                            <input class="btn btn-primary m-2 text-center" type="submit" value="Add Pet Info">
                        </div>




                        <h3>Add an Image: </h3>
                        Select image to upload:
                        <input type="file" name="fileToUpload" id="fileToUpload">


                        <div class="p-3">
                            <label class="input-group-text" for="picName">Name: </label>
                            <input class="form-control" id="picName" name="picName" type="text">
                        </div>

                        <div class="p-3">
                            <label class="input-group-text" for="picDescription">Description: </label>
                            <input class="form-control" id="picDescription" name="picDescription" type="text">
                        </div>




                    </form>
                </div>
            </div>
        </div>
    </div>
</div>