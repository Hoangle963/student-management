<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mamon = $_POST["malop"];
    $tenmon = $_POST["tenlop"];

    // Cập nhật thông tin môn học trong bảng monhoc
    $sql_update = "UPDATE lop SET tenlop = '$tenlop' WHERE malop = '$malop'";
    $result_update = $conn->query($sql_update);

    if ($result_update) {
        $message = "Sửa thành công!";
    
        // Hiển thị alert trước khi chuyển hướng
        echo "<script>alert('$message'); window.location='/qlsv/admin/display_lop';</script>";
        exit();
    } else {
        echo "Cập nhật thất bại. " . $conn->error;
    }
}

$conn->close();
?>
