<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET["id"];

    $sql_delete = "DELETE FROM monhoc WHERE mamon = '$id'";
    $result_delete = $conn->query($sql_delete);

    if ($result_delete === TRUE) {
        header("Location: /qlsv/admin/display_monhoc");
        exit();
    } else {
        echo "Lỗi xóa: " . $conn->error;
    }
}

$conn->close();
?>
