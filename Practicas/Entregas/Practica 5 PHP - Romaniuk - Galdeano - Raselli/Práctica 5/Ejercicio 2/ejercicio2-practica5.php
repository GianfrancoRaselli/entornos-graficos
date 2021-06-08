<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 5 - Ejercicio 2</title>
    <style>
    
    </style>
</head>
<body>
    <form action="scripts2.php" method="POST">
        <label for="name">Name: <input type="text" name="name" id="name" required=""></label><br><br>
        <label for="email">Email: <input type="email" name="email" id="email" required=""></label><br><br>  
        <label for="name">Asunto: <input type="text" name="asunto" id="asunto" required=""></label><br><br>
        <label for="message">Message: <textarea name="message" id="message" rows="8" cols="20"></textarea></label><br><br>
        <input type="submit" value="Send">
    </form>

</body>
</html>