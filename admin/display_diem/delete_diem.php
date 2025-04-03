<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $masv = $_GET["masv"];
    $mamon = $_GET["mamon"];

    // Thực hiện truy vấn để xóa điểm của sinh viên cho môn học cụ thể
    $sql_delete_grade = "DELETE FROM diem WHERE masv = '$masv' AND mamon = '$mamon'";
    $result_delete_grade = $conn->query($sql_delete_grade);

    if ($result_delete_grade) {
        echo "Xóa điểm thành công.";
    } else {
        echo "Xóa điểm thất bại. Lỗi: " . $conn->error;
    }
} else {
    echo "Phương thức không được hỗ trợ.";
}

$conn->close();
?>