<?php
// gemaakt door: Erkin Yilmaz

// Database connectie
function ConnectDB() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "fietsen";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    return $conn;
}

// Haal alle data op uit een tabel
function GetData($table) {
    $conn = ConnectDB();
    $sql = "SELECT * FROM $table";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;

    return $data;
}

// Haal een specifieke fiets op met een gegeven id
function GetFietsById($id) {
    $conn = ConnectDB();
    $sql = "SELECT * FROM fietsen WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch();
    $conn = null;

    return $data;
}

// Print de CRUD tabel voor fietsen
function PrintCrudFiets($result) {
    if (empty($result)) {
        echo "<p>Geen data gevonden.</p>";
        return;
    }

    $table =  "<table border='1'>";
    $table .= "<tr>";

    foreach (array_keys($result[0]) as $columnName) {
        $table .= "<th>" . htmlspecialchars($columnName) . "</th>";
    }

    $table .= "</tr>";

    foreach ($result as $row) {
        $table .= "<tr>";

        foreach ($row as $cell) {
            $table .= "<td>" . htmlspecialchars($cell) . "</td>";
        }

        $table .= "<td><a href='Update-Fietsen.php?id=" . $row['id'] . "'>Wijzigen</a></td>";
        $table .= "<td><a href='Delete-Fietsen.php?id=" . $row['id'] . "'>Verwijderen</a></td>";
        $table .= "</tr>";
    }

    $table .= "</table>";

    echo $table;
}

// Toon de CRUD pagina voor fietsen
function CrudFietsen() {
    echo "
    <h1>CRUD: Fietsen</h1>
    <nav>
    <a href='Insert-Fietsen.php'>Fiets toevoegen</a>
    </nav>";

    $result = GetData("fietsen");
    PrintCrudFiets($result);
}

// Voeg een nieuwe fiets toe aan de database
function InsertFiets($post) {
    $conn = ConnectDB();
    $sql = "INSERT INTO fietsen (merk, type, prijs) VALUES (:merk, :type, :prijs)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':merk', $post['merk'], PDO::PARAM_STR);
    $stmt->bindParam(':type', $post['type'], PDO::PARAM_STR);
    $stmt->bindParam(':prijs', $post['prijs'], PDO::PARAM_STR);
    $stmt->execute();
    $conn = null;
}

// Verwijder een fiets uit de database met een gegeven id
function Delete_Fietsen($id) {
    $conn = ConnectDB();
    $sql = "DELETE FROM fietsen WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $conn = null;
}

// Werk een bestaande fiets bij in de database
function Update_Fietsen($post) {
    $conn = ConnectDB();
    $sql = "UPDATE fietsen SET merk = :merk, type = :type, prijs = :prijs WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $post['id'], PDO::PARAM_INT);
    $stmt->bindParam(':merk', $post['merk'], PDO::PARAM_STR);
    $stmt->bindParam(':type', $post['type'], PDO::PARAM_STR);
    $stmt->bindParam(':prijs', $post['prijs'], PDO::PARAM_STR);
    $stmt->execute();
    $conn = null;
}

?>