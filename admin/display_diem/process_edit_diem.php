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
    $sql_update_grade = "UPDATE diem SET diem1 = '$diem1', diem2 = '$diem2', diemthi = '$diemthi' WHERE masv = '$masv' AND mamon = '$mamon'";
    $result_update_grade = $conn->query($sql_update_grade);

    if ($result_update_grade) {
        // Tính lại điểm trung bình môn (diemtbm)
        $sql_calculate_diemtbm = "UPDATE diem SET diemtbm = (diem1 + diem2) / 2 * 0.4 + diemthi * 0.6 WHERE masv = '$masv' AND mamon = '$mamon'";
        $result_calculate_diemtbm = $conn->query($sql_calculate_diemtbm);

        if ($result_calculate_diemtbm) {
            $message = "Sửa thành công!";
    
            // Hiển thị alert trước khi chuyển hướng
            echo "<script>alert('$message'); window.location='/qlsv/admin/display_diem';</script>";
            exit();
        } else {
            echo "Sửa điểm thành công, nhưng tính lại điểm trung bình môn (diemtbm) thất bại. Lỗi: " . $conn->error;
        }
    } else {
        echo "Sửa điểm thất bại. Lỗi: " . $conn->error;
    }
} else {
    echo "Phương thức không được hỗ trợ.";
}

$conn->close();
?>
