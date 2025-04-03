<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mamon = $_POST["mamon"];
    $tenmon = $_POST["tenmon"];

    // Cập nhật thông tin môn học trong bảng monhoc
    $sql_update = "UPDATE monhoc SET tenmon = '$tenmon' WHERE mamon = '$mamon'";
    $result_update = $conn->query($sql_update);

    if ($result_update) {
        echo "Cập nhật thành công.";
    } else {
        echo "Cập nhật thất bại. " . $conn->error;
    }
}

$conn->close();
?>
