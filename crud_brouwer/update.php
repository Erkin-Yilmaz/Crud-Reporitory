<?php
require_once('functions.php');

if (isset($_POST['btn_wzg'])) {
    if (updateRecord($_POST)) {
        echo "<script>alert('Brouwer is gewijzigd')</script>";
        echo "<script> location.replace('index.php'); </script>";
    } else {
        echo '<script>alert("Brouwer is NIET gewijzigd")</script>';
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $row = getRecord($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Wijzig Brouwer</title>
</head>
<body>
    <h2>Wijzig Brouwer</h2>
    <form method="post">
        <input type="hidden" name="brouwcode" value="<?php echo $row['brouwcode']; ?>"><br>

        <label for="naam">Naam:</label>
        <input type="text" id="naam" name="naam" required value="<?php echo $row['naam']; ?>"><br>

        <label for="land">Land:</label>
        <input type="text" id="land" name="land" required value="<?php echo $row['land']; ?>"><br>

        <input type="submit" name="btn_wzg" value="Wijzig">
    </form>
    <br><br>
    <a href='index.php'>Home</a>
</body>
</html>
<?php
} else {
    echo "Geen id opgegeven<br>";
}
?>