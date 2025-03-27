<?php

require_once 'Functions-fietsen.php';

if (isset($_POST['submit'])) {
    InsertFiets($_POST);
    echo '<script>alert("Fiets toegevoegd")</script>';
    echo "<script> location.replace('CRUD-Fietsen.php'); </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiets Toevoegen</title>
</head>
<body>
    <form action="Insert-Fietsen.php" method="post">
        <input type="text" name="merk" placeholder="Merk" required><br>
        <input type="text" name="type" placeholder="Type" required><br>
        <input type="number" name="prijs" placeholder="Prijs" step="0.01" required><br>
        <input type="submit" name="submit" value="Toevoegen"><br>
    </form>
    <a href='CRUD-Fietsen.php'>Home</a>
</body>
</html>