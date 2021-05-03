<?php
        echo "<select name='petSelect'>";
        $selectedSet = false;
        foreach($_SESSION['pets'] as $pet) {
            if (!$selectedSet) {
                echo "<option selected value=" . $pet['petID'] . ">" . $pet['name'] . "</option>";
                $selectedSet = true;
            } else {
                echo "<option value=" . $pet['petID'] . ">" . $pet['name'] . "</option>";
            }
        }
        echo "</select>";
?>