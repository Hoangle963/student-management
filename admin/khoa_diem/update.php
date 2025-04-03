<?php
include 'Connection.php';

if (isset($_GET['namhoc']) && isset($_GET['hocki'])) {
    $namhoc = $_GET['namhoc'];
    $hocki = $_GET['hocki'];

    // Update the record
    $sql = "UPDATE daotao SET lock_diem = 1 WHERE namhoc = '$namhoc' AND hocki = '$hocki'";
    if ($conn->query($sql) === TRUE) {
        echo "Đã khóa điểm thành công";
    } else {
        echo "Lỗi khi khóa điểm: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
