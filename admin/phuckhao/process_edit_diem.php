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
            // Update the trang_thai in phuc_khao table to 'Đã Phúc Khảo'
            $sql_update_trang_thai = "UPDATE phuc_khao SET trang_thai = 'Đã Phúc Khảo' WHERE masv = '$masv' AND mamon = '$mamon'";
            $result_update_trang_thai = $conn->query($sql_update_trang_thai);

            if ($result_update_trang_thai) {
                $message = "Sửa thành công!";
    
                // Hiển thị alert trước khi chuyển hướng
                echo "<script>alert('$message'); window.location='/qlsv/admin/phuckhao';</script>";
                exit();
            } else {
                echo "Sửa điểm thành công, nhưng cập nhật trạng thái thất bại. Lỗi: " . $conn->error;
            }
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
