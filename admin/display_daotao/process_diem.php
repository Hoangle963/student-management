<!-- process_grades.php -->

<?php
require_once("connection.php");

// Kiểm tra xem có dữ liệu được gửi từ form không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị malop, MaMon từ form
    $malop = $_POST["malop"];
    $MaMon = $_POST["MaMon"];

    // Lấy dữ liệu điểm từ form
    $diem1 = $_POST["diem1"];
    $diem2 = $_POST["diem2"];
    $diemthi = $_POST["diemthi"];

    // Duyệt qua danh sách sinh viên và lưu điểm
    foreach ($diem1 as $masv => $value) {
        // Kiểm tra xem sinh viên đã có điểm chưa
        $sql_check = "SELECT * FROM diem WHERE masv = '$masv' AND mamon = '$MaMon'";
        $result_check = $conn->query($sql_check);

        // Chuyển đổi giá trị thành kiểu số
        $diem1_val = floatval($diem1[$masv]);
        $diem2_val = floatval($diem2[$masv]);
        $diemthi_val = floatval($diemthi[$masv]);

        $diemtbm = ($diem1_val + $diem2_val) / 2 * 0.4 + $diemthi_val * 0.6;

        if ($result_check->num_rows > 0) {
            // Nếu đã có điểm, thực hiện cập nhật
            $sql_update = "UPDATE diem 
                           SET diem1 = '{$diem1_val}', 
                               diem2 = '{$diem2_val}', 
                               diemthi = '{$diemthi_val}', 
                               diemtbm = '$diemtbm'
                           WHERE masv = '$masv' AND mamon = '$MaMon'";
            $conn->query($sql_update);
        } else {
            // Nếu chưa có điểm, thực hiện thêm mới
            $sql_insert = "INSERT INTO diem (masv, mamon, diem1, diem2, diemthi, diemtbm) 
                           VALUES ('$masv', '$MaMon', '{$diem1_val}', '{$diem2_val}', '{$diemthi_val}', '$diemtbm')";
            $conn->query($sql_insert);
        }
    }

    // Thực hiện các xử lý khác ở đây
    
    // Tạo thông báo thành công
    $message = "Thêm thành công $malop môn $MaMon";
    
    // Hiển thị alert trước khi chuyển hướng
    echo "<script>alert('$message'); window.location='/qlsv/admin/display_daotao        ';</script>";
    exit();

 
} else {
    // Nếu không có dữ liệu gửi từ form, chuyển hướng về trang trước
    header("Location: index.php");
    exit();
}

// Đóng kết nối
$conn->close();
?>
