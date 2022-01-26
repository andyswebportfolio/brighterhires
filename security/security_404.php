<?php

//Instantly leaves the page and shows a 404 without running code.

function push_back_instant($address) {
    

    echo "<script>
    window.location = '".$address."';
    </script>";

}
push_back_instant('/404.php');

?>