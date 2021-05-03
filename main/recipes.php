<?php
    include "../login/checkSession.php";

    include "../components/head.php";

    include "../components/navbar.php";


?>

<h1>Recipes</h1>
<a href="addRecipe.php">Add Recipe</a>
<div class="container">
<?php

    include '../db/connect_to_db.php';
    
    $conn = get_db_connection("csc335");

    $meetupResults = $conn->query("select * from recipe;");

    while ($row = $meetupResults->fetch_assoc()) {



        echo "<div class='border p-3 m-3'>";
        echo "<div class='row'>";
        echo "<div class='col'>";
        echo "<h2>Recipe Name:</h2> <h3 class='text-primary font-weight-bold'>" . $row['recipeName'] . "</h3>";
        echo "<h3>Author:</h3> <h4 class='text-danger font-weight-bold'>" . $row['author'] . "</h4>";
        echo "<h3>Desctiption:</h3> <h4 class='text-secondary'>" . $row['description'] . "</h4>";
        echo "<h3>Ingredients:</h3> <h4 class='text-primary font-weight-bold'>" . $row['ingredients'] . "</h4>";
        echo "<h3>Time to Make:</h3> <h4 class='text-primary font-weight-bold'>" . $row['timeToMake'] . "</h4>";
        echo "</div>";
        echo "</div>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
    }


?>

</div>




<?php
include "../components/jsDependencies.php";
?>

</body>
</html>