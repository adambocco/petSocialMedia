<?php
    include "../login/checkSession.php";

    include "../components/head.php";

    include "../components/navbar.php";


?>
<div class="container">
<div class="display-4 m-2 p-2">Recipes</div>
<a class="btn btn-primary ml-4" href="addRecipe.php">Add Recipe</a>

<?php

    include '../db/connect_to_db.php';
    
    $conn = get_db_connection("csc335");

    $meetupResults = $conn->query("select * from recipe;");

    while ($row = $meetupResults->fetch_assoc()) {



        echo "<div class='border p-3 m-3' style='background-color:azure;'>";
        echo "<div class='row'>";
        echo "<div class='col'>";
        echo "<h3>Recipe Name:</h3> <h2 class='text-primary font-weight-bold'>" . $row['recipeName'] . "</h2>";
        echo "<h4>Author:</h4> <h3 class='text-primary font-weight-bold'>" . $row['author'] . "</h3>";
        echo "<h4>Description:</h4> <div class='border m-1 p-2'><h3 class='text-secondary'>" . $row['description'] . "</h3></div>";
        echo "<h4>Ingredients:</h4> <h3 class='text-primary'>" . $row['ingredients'] . "</h3>";
        echo "<h4>Time to Make:</h4> <h3 class='text-primary'>" . $row['timeToMake'] . " minutes</h3>";
        echo "</div>";
        echo "</div>";
        echo "</form>";
        echo "</div>";

    }


?>

</div>




<?php
include "../components/jsDependencies.php";
?>

</body>
</html>