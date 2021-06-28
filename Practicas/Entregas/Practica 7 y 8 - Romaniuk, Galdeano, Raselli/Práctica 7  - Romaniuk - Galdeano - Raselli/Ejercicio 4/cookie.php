<?php

setcookie('titular',$_POST['titular'],time() + 30*24*60*60);

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?php echo $_POST['titular']?></h1>
    <a href="index.php"><-volver hacia atras</a>
</body>
</html>