<?php
echo '<h2>Update Fietsen</h2>';
require_once 'Functions-fietsen.php';

if (isset($_GET['id'])) {
    $fiets = GetFietsById($_GET['id']);

    if (empty($fiets)) {
        echo "<p>Geen data gevonden.</p>";
        return;
    }
} else {
    echo "<p>Geen data gevonden.</p>";
    return;
}

if (isset($_POST['submit'])) {
    Update_Fietsen($_POST);
    echo '<script>alert("Fiets bijgewerkt")</script>';
    echo "<script> location.replace('CRUD-Fietsen.php'); </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiets Bijwerken</title>
</head>
<body>
    <form action="Update-fietsen.php?id=<?php echo $fiets['id']; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $fiets['id']; ?>">
        <input type="text" name="merk" value="<?php echo $fiets['merk']; ?>" required><br>
        <input type="text" name="type" value="<?php echo $fiets['type']; ?>" required><br>
        <input type="number" name="prijs" value="<?php echo $fiets['prijs']; ?>" step="0.01" required><br>
        <input type="submit" name="submit" value="Bijwerken"><br>
    </form>
    <a href='CRUD-Fietsen.php'>Home</a>
</body>
</html>