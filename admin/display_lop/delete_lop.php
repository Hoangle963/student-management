<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET["id"];

    $sql_delete = "DELETE FROM lop WHERE malop = '$id'";
    $result_delete = $conn->query($sql_delete);

    if ($result_delete === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Lỗi xóa: " . $conn->error;
    }
}

$conn->close();
?>
