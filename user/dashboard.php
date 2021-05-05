<?php
include '../db/connect_to_db.php';

$conn = get_db_connection("csc335");

include "../login/checkSession.php";

include "../components/head.php";

include "../components/navbar.php";

$friendEmailArray = array();
?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Dashboard</h1>
            <h3>Hello, <?php echo $_SESSION['firstName'] ?></h3>
            <div class="card">
                <h3>Your pets:</h3>
                <ul>
                    <?php

                    // selecting pets only from person logged in, displaying in list
                    $result = $conn->query("SELECT * FROM pet WHERE person='{$_SESSION['email']}'");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            echo "<a class='d-block' href='/petSocialMedia/user/petProfile.php?pet=" . $row['petID'] . "'>" . $row['name'] . "</li>";
                        }
                    } else {
                        echo "No Pets!";
                    }
                    ?>
                </ul>
                <a href="addPet.php">Add a Pet</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h1>Friends</h1>
            <?php

            $friendsResult = $conn->query("SELECT * FROM friends WHERE (friendOne='{$_SESSION['email']}' OR friendTwo='{$_SESSION['email']}') AND accepted=1");
            if ($friendsResult->num_rows > 0) {
                while ($row = $friendsResult->fetch_assoc()) {

                    $friendEmail = $row['friendTwo'] == $_SESSION['email'] ? $row['friendOne'] : $row['friendTwo'];
                    array_push($friendEmailArray, $friendEmail);
            ?>
                    <li><?php echo "<a href='/petSocialMedia/main/userProfile.php?user=" . $friendEmail . "' class='btn btn-primary'>" . $friendEmail . "</a>";   ?></li>
            <?php
                }
            } else {
                echo "No Friends!";
            }

            ?>
        </div>

        <div class="col">
            <h1>Friend Requests</h1>
            <?php

            $friendsResult = $conn->query("SELECT * FROM friends WHERE friendOne='{$_SESSION['email']}'");
            if ($friendsResult->num_rows > 0) {
                while ($row = $friendsResult->fetch_assoc()) {
                    if ($row['accepted'] == 0) {

            ?>
                        <li><?php
                            echo $row['friendTwo'];
                            echo "<form action='' method='POST'>";
                            echo "<button class='btn btn-success' type='submit'>Accept</button>";
                            echo "<input type='hidden' name='acceptFriend' value=" . $row['friendTwo'] . "></input>";
                            echo "</form>";
                            echo "<form action='' method='POST'>";
                            echo "<button class='btn btn-danger' type='submit'>Reject</button>";
                            echo "<input type='hidden' name='rejectFriend' value=" . $row['friendTwo'] . "></input>";
                            echo "</form>";
                            ?>
                        </li>
            <?php
                    }
                }
            } else {
                echo "No Friend Requests!";
            }

            if (isset($_POST['acceptFriend'])) {
                $friendsResult = $conn->query("UPDATE friends SET accepted=1 WHERE friendOne='{$_SESSION['email']}' and friendTwo='{$_POST['acceptFriend']}';");
            }
            if (isset($_POST['rejectFriend'])) {
                $friendsResult = $conn->query("DELETE FROM friends WHERE friendOne='{$_SESSION['email']}' and friendTwo='{$_POST['rejectFriend']}';");
            }


            ?>

        </div>

    </div>

    <div class="row">
        <div class="col">
            <h2>Create a Post:</h2>
            <div>
                <form method="POST" action="" class="form-group">

                    <div class="p-3">
                        <label class="input-group-text" for="postTitle">Title: </label>
                        <input class="form-control" id="postTitle" name="postTitle" type="text">
                    </div>

                    <div class="p-3">
                        <label class="input-group-text" for="postBody">Body: </label>
                        <textarea class="form-control" id="postBody" name="postBody" rows="5" cols="50"></textarea>
                    </div>

                    <div class="p-3 text-center">
                        <input type="hidden" name="action_type" value=<?= "select" ?>></input>
                        <input class="btn btn-primary m-2 text-center" type="submit" value="Create Post">
                    </div>

                </form>
            </div>

        </div>

    </div>

    <?php


    if (isset($_POST['postTitle'])) {
        echo "INSERT INTO post (title, description, person) VALUES ({$_POST['postTitle']}, {$_POST['postBody']}, {$_SESSION['email']});";
        $postPostResult = $conn->query("INSERT INTO post (title, description, person) VALUES ('{$_POST['postTitle']}', '{$_POST['postBody']}', '{$_SESSION['email']}');");
    }

    ?>



    <div class="row">
        <div class="col">
            <h1>News Feed</h1>
            <?php
            $friendQueryList =  "'" . implode("','", $friendEmailArray) . "','" . $_SESSION['email'] . "'";

            $friendsPostsResult = $conn->query("SELECT * FROM post WHERE person IN (" . $friendQueryList . ");");

            if ($friendsPostsResult->num_rows > 0) {
                while ($row = $friendsPostsResult->fetch_assoc()) {
                    echo "<h4 class='text-info font-weight-bold'>" . $row['title'] . "</h4>";
                    echo "<h5 class='text-info'>" . $row['description'] . "</h5>";
                    echo "<div>" . $row['person'] . "</div>";
                    echo "<div class='p-4 m-4 border'>";



                    echo "<div class=''>";
                        echo "<form method='POST' action='' class='form-group'>";

                        echo "<div class='p-3'>";
                            echo "<label class='input-group-text' for='commentPostBody'>Body: </label>";
                            echo "<textarea class='form-control' id='commentPostBody' name='commentPostBody' rows='2' cols='35'></textarea>";
                        echo "</div>";

                        echo "<div class='p-3 text-center'>";
                            echo "<input type='hidden' name='commentPostID' value='" . $row['postID'] . "'></input>";
                            echo "<input class='btn btn-primary m-2 text-center' type='submit' value='Create Comment'>";
                        echo "</div>";
                        

                        echo "</form>";

                    echo "</div>";


                    $friendsPostsCommentsResult = $conn->query("SELECT * FROM comment WHERE postID='" . $row['postID'] . "';");
                    if ($friendsPostsCommentsResult->num_rows > 0) {
                        while ($commentsRow = $friendsPostsCommentsResult->fetch_assoc()) {

                            echo "<h5 class='text-primary'>" . $commentsRow['person'] . ":</h5>";
                            echo "<p class='text-muted'>" . $commentsRow['body'] . "</p>";

                        }
                    }
                    echo "</div>";
                }
            }


            if (isset($_POST['commentPostID'])) {
                echo $_POST['commentPostID'] . "COMMENT POST ID";
                echo $_POST['commentPostBody'] . "COMMENTPOSTBODY";
                $postCommentResult = $conn->query("INSERT INTO comment (body, postID, person) VALUES ('" . $_POST['commentPostBody'] . "','" . $_POST['commentPostID'] . "','" . $_SESSION['email'] . "');");

            }
            ?>

        </div>
    </div>

</div>
<?php
include "../components/jsDependencies.php";
?>

</body>

</html>