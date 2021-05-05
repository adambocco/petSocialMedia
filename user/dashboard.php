<?php
include '../db/connect_to_db.php';

$conn = get_db_connection("csc335");

include "../login/checkSession.php";

include "../components/head.php";

include "../components/navbar.php";

$friendEmailArray = array();


if (isset($_POST['acceptFriend'])) {
    $friendsResult = $conn->query("UPDATE friends SET accepted=1 WHERE friendOne='{$_SESSION['email']}' and friendTwo='{$_POST['acceptFriend']}';");
}
if (isset($_POST['rejectFriend'])) {
    $friendsResult = $conn->query("DELETE FROM friends WHERE friendOne='{$_SESSION['email']}' and friendTwo='{$_POST['rejectFriend']}';");
}
if (isset($_POST['postTitle'])) {
    echo "INSERT INTO post (title, description, person) VALUES ({$_POST['postTitle']}, {$_POST['postBody']}, {$_SESSION['email']});";
    $postPostResult = $conn->query("INSERT INTO post (title, description, person) VALUES ('{$_POST['postTitle']}', '{$_POST['postBody']}', '{$_SESSION['email']}');");
}

if (isset($_POST['commentPostID'])) {
    $postCommentResult = $conn->query("INSERT INTO comment (body, postID, person) VALUES ('" . $_POST['commentPostBody'] . "','" . $_POST['commentPostID'] . "','" . $_SESSION['email'] . "');");

}
if (isset($_POST['commentDelete'])) {
    $postCommentResult = $conn->query("DELETE FROM comment WHERE commentID =" . $_POST['commentDelete'] . ";");

}
if (isset($_POST['postDelete'])) {
    $postCommentResult = $conn->query("DELETE FROM post WHERE postID =" . $_POST['postDelete'] . ";");

}



?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="display-4">Dashboard</div>
            <h3 class='m-4'>Hello, <?php echo $_SESSION['firstName'] ?></h3>
            <div style="background-color:azure" class="card m-2 p-3">
                <h3>Your pets:</h3>
                <ul>
                    <?php

                    // selecting pets only from person logged in, displaying in list
                    $result = $conn->query("SELECT * FROM pet WHERE person='{$_SESSION['email']}'");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            echo "<a class='btn btn-outline-primary d-inline-block m-2' href='/petSocialMedia/user/petProfile.php?pet=" . $row['petID'] . "'>" . $row['name'] . "</a>";
                        }
                    } else {
                        echo "No Pets!";
                    }
                    ?>
                </ul>
                <a class='btn btn-info m-3' href="addPet.php">Add a Pet</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col border m-3 p-3" style="background-color:azure;">
            <h1>Friends</h1>
            <?php

            $friendsResult = $conn->query("SELECT * FROM friends WHERE (friendOne='{$_SESSION['email']}' OR friendTwo='{$_SESSION['email']}') AND accepted=1");
            if ($friendsResult->num_rows > 0) {
                while ($row = $friendsResult->fetch_assoc()) {

                    $friendEmail = $row['friendTwo'] == $_SESSION['email'] ? $row['friendOne'] : $row['friendTwo'];
                    array_push($friendEmailArray, $friendEmail);
            ?>
                    <li class="m-2 p-1"><?php echo "<a href='/petSocialMedia/main/userProfile.php?user=" . $friendEmail . "' class='btn btn-primary'>" . $friendEmail . "</a>";   ?></li>
            <?php
                }
            } else {
                echo "No Friends!";
            }

            ?>
        </div>

        <div class="col border m-3 p-3" style="background-color:azure;">
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



            ?>

        </div>

    </div>

    <div class="row my-4">
        <div class="col border p-3" style="background-color:azure;">
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




    ?>



    <div class="row">
    <div class="text-center m-0 p-3 display-4 w-100" style="background-color:skyblue;">News Feed</div>
        <div class="col border" style="background-color:azure;">

            <?php
            $friendQueryList =  "'" . implode("','", $friendEmailArray) . "','" . $_SESSION['email'] . "'";

            $friendsPostsResult = $conn->query("SELECT * FROM post WHERE person IN (" . $friendQueryList . ");");

            if ($friendsPostsResult->num_rows > 0) {
                while ($row = $friendsPostsResult->fetch_assoc()) {
                    echo "<div class='border p-3 m-3' style='background-color:rgb(225,235,245);'>";
                    echo "<h4 class='font-weight-bold d-inline'>Title: </h4><h4 class='d-inline text-info font-weight-bold'>" . $row['title'] . "</h4>";
                    if ($row['person'] == $_SESSION['email']) {
                        echo "<form method='POST' action='' class='form-group'>";
                
                        echo "<div class='p-1'>";
                            echo "<input type='hidden' name='postDelete' value='" . $row['postID'] . "'></input>";
                            echo "<input class='btn btn-danger m-2 text-center' type='submit' value='Delete Post'>";
                        echo "</div>";
                        

                        echo "</form>";
                    }
                    
                    
                    echo "<div class='m-2 p-2 lead bg-light'>" . $row['description'] . "</div>";
                    echo "<div class='text-muted'>- " . $row['person'] . "</div>";
                    echo "<div class='p-4 m-4 border' style='background-color:rgb(230,230,230);'>";




                        echo "<h5 class='pb-3'>Comments:</h5>";



                    $friendsPostsCommentsResult = $conn->query("SELECT * FROM comment WHERE postID='" . $row['postID'] . "';");
                    if ($friendsPostsCommentsResult->num_rows > 0) {
                        while ($commentsRow = $friendsPostsCommentsResult->fetch_assoc()) {
                            echo "<hr>";
                            echo "<div class='row'>";
                            echo "<div class='col-8'>";
                            echo "<h5 class='text-primary'>" . $commentsRow['person'] . ":</h5>";
                            echo "<p class='text-muted'>" . $commentsRow['body'] . "</p>";
                            echo "</div>";
                            if ($commentsRow['person'] == $_SESSION['email']) {
                                echo "<div class='col-4'>";
                                echo "<form method='POST' action='' class='form-group'>";
            
                                echo "<div class='p-1 text-center'>";
                                    echo "<input type='hidden' name='commentDelete' value='" . $commentsRow['commentID'] . "'></input>";
                                    echo "<input class='btn btn-outline-danger m-2 text-center' type='submit' value='Delete Comment'>";
                                echo "</div>";
                                
            
                                echo "</form>";
                                echo "</div>";
                            }
                            echo "</div>";

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