<?php
// delete.php

require_once("connection.php");

// Kiểm tra xem có mã sinh viên được chọn không
if (isset($_GET['masv'])) {
    $masv = $_GET['masv'];

    // Bắt đầu một giao dịch để đảm bảo tính nhất quán giữa việc xóa từ cả ba bảng
    $conn->begin_transaction();

    try {
        // Xóa sinh viên khỏi bảng sinh_vien
        $sql_delete_sv = "DELETE FROM sinh_vien WHERE masv = '$masv'";
        $conn->query($sql_delete_sv);

        // Xóa tài khoản sinh viên khỏi bảng user
        $sql_delete_user = "DELETE FROM user WHERE taikhoan = '$masv'";
        $conn->query($sql_delete_user);

        // Xóa điểm của sinh viên khỏi bảng diem
        $sql_delete_diem = "DELETE FROM diem WHERE masv = '$masv'";
        $conn->query($sql_delete_diem);

        // Commit giao dịch nếu mọi thứ thành công
        $conn->commit();

        $message = "Xóa thành công!";
    
        // Hiển thị alert trước khi chuyển hướng
        echo "<script>alert('$message'); window.location='/qlsv/admin/display_sinhvien';</script>";
    } catch (Exception $e) {
        // Nếu có lỗi, thực hiện rollback để hủy bỏ các thay đổi
        $conn->rollback();

        echo "Lỗi khi xóa sinh viên, tài khoản, và điểm: " . $e->getMessage();
    }
} else {
    echo "Mã sinh viên không được cung cấp.";
}

// Đóng kết nối
$conn->close();
?>
