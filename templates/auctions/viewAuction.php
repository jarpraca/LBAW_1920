<section id="property">
    <header>
        <h1>Macaco Albino da Guiné</h1>
        <h3>Albert&nbsp;&nbsp;&nbsp;&nbsp;3 anos</h3>
    </header>
    <!-- fotos -->
    <!-- <?php 
        // include("templates/properties/image_slideshow.php");
    ?> -->
    <?php
    if (true){
    ?>
        <aside>
            <p> /night</p>
            <h3>Dates</h3>
            <p>2020-03-03 -> 2020-03-07</p>
            <!--<hr>-->
            <p>90x4 nights</p>
            <p><?=90*4?>€</p>
            <p>Cleaning Tax</p>
            <p><?=30?>€</p>
            <h3>Total</h3>
            <h3><?=90*4+30?>€</h3>
            <!-- <div class="list_properties_options">
              <?php  /*include_once("templates/forms/reservation.php");*/ ?>
            </div> -->
            <?php if(isset($_SESSION['user'])) {?>
            <?php }
            else{ ?>
                <a href="login.php" class="submit"><p>Login to Reserve</p></a>
            <?php } ?>

        </aside>
    <?php } ?>
    <section id="property_data">
        <h3>Macaco Albino da Guiné</h3>
        <p>Maximum Guests: 4</p>
        <p>Bedrooms: 2</p>
        <p>Cancelling Policy: Flexivel</p>
        <h3>Description</h3>
        <p>descricaodescricaodescricaodescricao</p>
        <h3>Skills</h3>
        <p id="amenity">skill1</p>
        <p id="amenity">skill2</p>
        <p id="amenity">skill3</p>
        <p id="amenity">skill4</p>
        <h3>Reviews</h3>
        <?php ?>
    </section>
</section>