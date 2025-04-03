<!-- process_add_diem.php -->
<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $masv = $_POST["masv"];
    $mamon = $_POST["mamon"];
    $diem1 = $_POST["diem1"];
    $diem2 = $_POST["diem2"];
    $diemthi = $_POST["diemthi"];

    // Thực hiện truy vấn để thêm điểm mới
    $sql_insert_grade = "INSERT INTO diem (masv, mamon, diem1, diem2, diemthi)
                         VALUES ('$masv', '$mamon', '$diem1', '$diem2', '$diemthi')";

    if ($conn->query($sql_insert_grade) === TRUE) {
        // Sau khi thêm điểm, tính lại diemtbm theo công thức mới
        $diemtbm = (($diem1 + $diem2) / 2) * 0.4 + $diemthi * 0.6;
        
        $sql_update_diemtbm = "UPDATE diem
                               SET diemtbm = '$diemtbm'
                               WHERE masv = '$masv' AND mamon = '$mamon'";
        
        $conn->query($sql_update_diemtbm);

        echo "Thêm điểm mới thành công.";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>
