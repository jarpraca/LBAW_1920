<form id="search" method="get" action="listSearch.php">
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
    <!-- <?php
            // include_once('database/connection.php');
            // include_once('database/habitations.php');
            // $types = getTypes();

            // foreach ($types as $t) {
            //     echo '<option value="' . $t['idTipo'] . '"';
            //     if ($type != "" && $type['idTipo'] == $t['idTipo'])
            //         echo ' selected ';
            //     echo '>' . $t['nome'] . '</option>';
            // }
            ?> -->
    <input class="search_text_input" type="search" name="animal" placeholder="Search for an animal species" required>
    <input type="image" src="../images/glass.png" alt="Submit" height="20" id="glass">
    <div class="dropdown">
        <button class="btn btn-green dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Categories
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#">Mammals</a>
            <a class="dropdown-item" href="#">Insects</a>
            <a class="dropdown-item" href="#">Reptiles</a>
            <a class="dropdown-item" href="#">Birds</a>
            <a class="dropdown-item" href="#">Fishes</a>
            <a class="dropdown-item" href="#">Amphibians</a>
        </div>
    </div>
</form>