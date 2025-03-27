<?php
include 'Functions-fietsen.php';

if (isset($_GET['id'])) {
    Delete_Fietsen($_GET['id']);

    echo '<script>alert("Fiets is verwijderd")</script>';
    echo "<script> location.replace('CRUD-Fietsen.php'); </script>";
}
?>