<?php
include 'functions.php';

if (isset($_GET['id'])) {
    if (deleteRecord($_GET['id'])) {
        echo '<script>alert("Brouwer met brouwcode: ' . $_GET['id'] . ' is verwijderd")</script>';
        echo "<script> location.replace('index.php'); </script>";
    } else {
        echo '<script>alert("Brouwer is NIET verwijderd")</script>';
    }
}
?>