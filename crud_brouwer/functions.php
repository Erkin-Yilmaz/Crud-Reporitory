<?php
// auteur: Erkin Yilmaz
// functie: algemene functies tbv hergebruik

include_once "config.php";

function connectDb() {
    $servername = SERVERNAME;
    $username = USERNAME;
    $password = PASSWORD;
    $dbname = DATABASE;

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function crudMain() {
    echo "
    <h1>Crud Brouwers</h1>
    <nav>
        <a href='insert.php'>Toevoegen nieuwe brouwer</a>
    </nav><br>";

    $result = getData(CRUD_TABLE);
    printCrudTabel($result);
}

function getData($table) {
    $conn = connectDb();
    $sql = "SELECT * FROM $table";
    $query = $conn->prepare($sql);
    $query->execute();
    return $query->fetchAll();
}

function getRecord($id) {
    $conn = connectDb();
    $sql = "SELECT * FROM " . CRUD_TABLE . " WHERE brouwcode = :id";
    $query = $conn->prepare($sql);
    $query->execute([':id' => $id]);
    return $query->fetch();
}

function printCrudTabel($result) {
    $table = "<table>";
    $headers = array_keys($result[0]);
    $table .= "<tr>";
    foreach ($headers as $header) {
        $table .= "<th>" . $header . "</th>";
    }
    $table .= "<th colspan=2>Actie</th>";
    $table .= "</tr>";

    foreach ($result as $row) {
        $table .= "<tr>";
        foreach ($row as $cell) {
            $table .= "<td>" . $cell . "</td>";
        }
        $table .= "<td>
            <form method='post' action='update.php?id=$row[brouwcode]'>
                <button>Wijzig</button>
            </form>
        </td>";
        $table .= "<td>
            <form method='post' action='delete.php?id=$row[brouwcode]'>
                <button>Verwijder</button>
            </form>
        </td>";
        $table .= "</tr>";
    }
    $table .= "</table>";
    echo $table;
}

function updateRecord($row) {
    $conn = connectDb();
    $sql = "UPDATE " . CRUD_TABLE . "
    SET naam = :naam, land = :land
    WHERE brouwcode = :brouwcode";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':naam' => $row['naam'],
        ':land' => $row['land'],
        ':brouwcode' => $row['brouwcode']
    ]);
    return $stmt->rowCount() == 1;
}

function insertRecord($post) {
    $conn = connectDb();
    $sql = "INSERT INTO " . CRUD_TABLE . " (naam, land)
    VALUES (:naam, :land)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':naam' => $post['naam'],
        ':land' => $post['land']
    ]);
    return $stmt->rowCount() == 1;
}

function deleteRecord($id) {
    $conn = connectDb();
    $sql = "DELETE FROM " . CRUD_TABLE . " WHERE brouwcode = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->rowCount() == 1;
}
?>