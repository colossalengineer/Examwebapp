<!-- Displays Version to the screen -->
<span class="version">
    <?php
        $json = file_get_contents("C:/xampp/htdocs/GibJohn/Version/version.txt");
        echo "Version: ".$json;
    ?>
</span>