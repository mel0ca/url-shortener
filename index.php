<?php
require "../config.php"; // Required for database connection ($conn)

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $select = $conn->prepare("SELECT * FROM urls WHERE id = :id");
    $select->execute([':id' => $id]);
    $data = $select->fetch(PDO::FETCH_OBJ);

    if ($data) {
        $clicks = $data->clicks + 1;

        $update = $conn->prepare("UPDATE urls SET clicks = :clicks WHERE id = :id");
        $update->execute([
            ':clicks' => $clicks,
            ':id' => $id
        ]);

        header("Location: " . $data->url);
        exit();
    } else {
        echo "URL not found.";
    }
} else {
    echo "Invalid request.";
}
?>