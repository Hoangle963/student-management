<!-- process_edit_diem.php -->
<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $masv = $_POST["masv"];
    $mamon = $_POST["mamon"];
    $diem1 = $_POST["diem1"];
    $diem2 = $_POST["diem2"];
    $diemthi = $_POST["diemthi"];

    // Thực hiện truy vấn để cập nhật điểm
    $sql_update_grade = "UPDATE diem
                         SET diem1 = '$diem1', diem2 = '$diem2', diemthi = '$diemthi'
                         WHERE masv = '$masv' AND mamon = '$mamon'";

    if ($conn->query($sql_update_grade) === TRUE) {
        // Sau khi cập nhật điểm, tính lại diemtbm theo công thức mới
        $diemtbm = (($diem1 + $diem2) / 2) * 0.4 + $diemthi * 0.6;
        
        $sql_update_diemtbm = "UPDATE diem
                               SET diemtbm = '$diemtbm'
                               WHERE masv = '$masv' AND mamon = '$mamon'";
        
        $conn->query($sql_update_diemtbm);

        $message = "Thêm thành công!";
    
        // Hiển thị alert trước khi chuyển hướng
        echo "<script>alert('$message'); window.location='/qlsv/admin/insert_diem';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>
