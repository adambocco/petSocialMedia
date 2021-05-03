<?php
    include "../login/checkSession.php";

    include "../components/head.php";

    include "../components/navbar.php";


?>

<h1>Add a Recipe</h1>

<div class="container">

    <div>
        <form method="POST" action="" class="form-group">

            <div class="p-3">
                <label class="input-group-text" for="recipeName">Recipe Name</label>
                <input class="form-control" id="recipeName" name="recipeName" type="text">
            </div>

            <div class="p-3">
                <label class="input-group-text" for="recipeDescription">Description</label>
                <input class="form-control" id="recipeDescription" name="recipeDescription" type="text">
            </div>

            <div class="p-3">
                <label class="input-group-text" for="ingredients">Ingredients </label>
                <input class="form-control" id="ingredients" name="ingredients" type="text">
            </div>

            <div class="p-3">
                <label class="input-group-text" for="timeToMake">Time To Make </label>
                <input class="form-control" id="timeToMake" name="timeToMake" type="number">
            </div>

            <div class="p-3 text-center">
                <input type="hidden" name="action_type" value=<?="select"?>></input>
                <input class="btn btn-primary m-2 text-center" type="submit" value="CreateRecipe">
            </div>

        </form>
    </div>

</div>


<?php
    include '../db/connect_to_db.php';
    $conn = get_db_connection("csc335");


    if (isset($_POST['recipeName']) && isset($_POST['recipeDescription']) && isset($_POST['ingredients']) && isset($_POST['timeToMake']) ) {
            
        // Check if email entered by user exists in the database
        $userResults = $conn->query("select * from recipe where recipeName='" . $_POST['recipeName'] . "';");

        if ($userResults->num_rows > 0) {
            echo "RECIPE NAME TAKEN";
        } else {
            // If the email is not taken, create a new user
            $meetupAddResults = $conn->query("insert into recipe (author, recipeName, description, ingredients, timeToMake) values 
                                            ('" . $_SESSION['email'] . "',
                                            '" . $_POST['recipeName'] . "',
                                            '" . $_POST['recipeDescription'] . "',
                                            '" . $_POST['ingredients'] . "',
                                            '" . $_POST['timeToMake'] . "');");

            if ($meetupAddResults) {
                echo "Recipe successfully added!";
            } else {
                echo "Something went wrong...";
            }
        }
    } 
?>






<?php
include "../components/jsDependencies.php";
?>

</body>
</html>