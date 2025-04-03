<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối đến cơ sở dữ liệu
    require_once("connection.php");

    // Lấy giá trị từ form
    $ma_nh = $_POST['ma_nh'];
    $id_khoa = $_POST['id_khoa'];
    $tenlop = $_POST['tenlop'];

    // Kiểm tra xem đã tồn tại dữ liệu với các giá trị tương ứng chưa
    $sql_check = "SELECT * FROM lop WHERE ma_nh = '$ma_nh' AND id_khoa = '$id_khoa' AND tenlop = '$tenlop'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        $message = "Dữ liệu đã tồn tại và không thể chèn trùng lặp.";
    
        // Hiển thị alert trước khi chuyển hướng
        echo "<script>alert('$message'); window.location='/qlsv/admin/display_lop';</script>";
        exit();
    } else {
        // Thực hiện truy vấn để chèn dữ liệu vào bảng lop
        $sql_insert = "INSERT INTO lop (ma_nh, id_khoa, tenlop) VALUES ('$ma_nh', '$id_khoa', '$tenlop')";
        
        if ($conn->query($sql_insert) === TRUE) {
            $message = "Thêm thành công!";
    
            // Hiển thị alert trước khi chuyển hướng
            echo "<script>alert('$message'); window.location='/qlsv/admin/display_diem';</script>";
            exit();
        } else {
            echo "Lỗi khi chèn dữ liệu: " . $conn->error;
        }
    }

    // Đóng kết nối
    $conn->close();
}
?>
