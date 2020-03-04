<form id="search" method="get" action="listSearch.php">
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
    <select name="categories" required>
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
        <option value="0" selected>All</option>
        <option value="1">Mammals</option>
        <option value="2">Insects</option>
        <option value="3">Reptiles</option>
        <option value="4">Birds</option>
        <option value="5">Fish</option>
        <option value="6">Amphibians</option>
    </select>
    <input id="search_text_input" type="search" name="animal" placeholder="Search for an animal species" required>
    <input type="image" src="images/glass.png" alt="Submit" height="20" id="glass">
</form>