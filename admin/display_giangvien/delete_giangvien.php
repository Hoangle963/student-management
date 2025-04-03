<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET["id"];

    // Truy vấn kiểm tra xem giảng viên có tồn tại trong bảng daotao hay không
    $sql_check_daotao = "SELECT * FROM daotao WHERE magv = '$id'";
    $result_check_daotao = $conn->query($sql_check_daotao);

    // Kiểm tra số dòng trả về
    if ($result_check_daotao->num_rows > 0) {
        // Nếu có giảng viên trong bảng daotao, thông báo và không thực hiện xóa
        echo "Không thể xóa giảng viên vì còn công việc chưa hoàn thành hoặc chưa bàn giao xong.";
    } else {
        // Nếu không có giảng viên trong bảng daotao, thực hiện xóa
        // Truy vấn xóa giảng viên trong bảng giang_vien
        $sql_delete_giangvien = "DELETE FROM giang_vien WHERE magv = '$id'";
        $result_delete_giangvien = $conn->query($sql_delete_giangvien);

        // Truy vấn xóa user với magv là tài khoản
        $sql_delete_user = "DELETE FROM user WHERE taikhoan = '$id'";
        $result_delete_user = $conn->query($sql_delete_user);

        if ($result_delete_giangvien === TRUE && $result_delete_user === TRUE) {
            $message = "Thêm thành công!";
    
            // Hiển thị alert trước khi chuyển hướng
            echo "<script>alert('$message'); window.location='/qlsv/admin/display_giangvien';</script>";
        } else {
            echo "Lỗi xóa: " . $conn->error;
        }
    }
}

$conn->close();
?>
