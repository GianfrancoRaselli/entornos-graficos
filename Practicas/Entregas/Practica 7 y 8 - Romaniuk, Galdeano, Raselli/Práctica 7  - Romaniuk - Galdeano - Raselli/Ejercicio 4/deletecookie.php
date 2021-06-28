<?php

    setcookie ('titular', "", time() - 3600);
    echo "cookie borrada"."<br>";
    echo '<a href="index.php"><-volver hacia atras</a>';
?>