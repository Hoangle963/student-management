<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem tất cả các trường cần thiết đã được gửi từ form hay không
    if (isset($_POST['masv'], $_POST['mamon'], $_POST['diem1'], $_POST['diem2'], $_POST['diemthi'])) {
        // Lấy giá trị từ biểu mẫu
        $masv = $_POST['masv'];
        $mamon = $_POST['mamon'];
        $diem1 = $_POST['diem1'];
        $diem2 = $_POST['diem2'];
        $diemthi = $_POST['diemthi'];

        // Lấy giá trị malop từ bảng sinh_vien dựa trên masv
        $sql_get_malop = "SELECT malop FROM sinh_vien WHERE masv = '$masv'";
        $result_get_malop = $conn->query($sql_get_malop);

        if ($result_get_malop->num_rows > 0) {
            $row_get_malop = $result_get_malop->fetch_assoc();
            $malop = $row_get_malop['malop'];

            // Tính điểm trung bình môn
            $diemtbm = ($diem1 + $diem2) / 2 * 0.4 + $diemthi * 0.6;

            // Kiểm tra xem điểm cho sinh viên và môn học đã tồn tại chưa
            $sql_check = "SELECT * FROM diem WHERE masv = '$masv' AND mamon = '$mamon'";
            $result_check = $conn->query($sql_check);

            if ($result_check->num_rows > 0) {
                // Nếu đã tồn tại, thực hiện truy vấn để cập nhật điểm
                $sql_update = "UPDATE diem SET diem1 = '$diem1', diem2 = '$diem2', diemthi = '$diemthi', diemtbm = '$diemtbm' WHERE masv = '$masv' AND mamon = '$mamon'";
                if ($conn->query($sql_update) === TRUE) {
                    echo "Sửa điểm thành công.";
                } else {
                    echo "Lỗi khi sửa điểm: " . $conn->error;
                }
            } else {
                // Nếu chưa tồn tại, thực hiện truy vấn để thêm điểm mới
                $sql_insert = "INSERT INTO diem (masv, mamon, malop, diem1, diem2, diemthi, diemtbm) VALUES ('$masv', '$mamon', '$malop', '$diem1', '$diem2', '$diemthi', '$diemtbm')";
                if ($conn->query($sql_insert) === TRUE) {
                    echo "Thêm điểm thành công.";
                } else {
                    echo "Lỗi khi thêm điểm: " . $conn->error;
                }
            }
        } else {
            echo "Không tìm thấy sinh viên với masv đã cho.";
        }
    } else {
        echo "Không đủ dữ liệu từ biểu mẫu.";
    }
} else {
    echo "Phương thức yêu cầu không hợp lệ.";
}

$conn->close();
?>
