<!DOCTYPE html>
<html lang="vi">
<?php include "menu.php"; ?>
<?php
require_once("connection.php");

// Thực hiện truy vấn để lấy danh sách malop, mamon, tenlop, tenmon từ bảng daotao, lop, monhoc
$sql = "SELECT DISTINCT dt.malop, dt.mamon, l.tenlop, m.tenmon
        FROM daotao dt
        LEFT JOIN lop l ON dt.malop = l.malop
        LEFT JOIN monhoc m ON dt.mamon = m.mamon";

$result = $conn->query($sql);

// Lưu danh sách malop, mamon, tenlop, tenmon vào mảng để sử dụng trong biểu mẫu
$class_subjects = [];
while ($row = $result->fetch_assoc()) {
    $class_subjects[] = $row;
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn Mã Lớp và Mã Môn</title>
</head>

<body>
    <h1>Chọn Mã Lớp và Mã Môn</h1>
    <form action="view_daotao.php" method="post">
    <div class="container mt-5">
        <label for="malop_mamon">Chọn Mã Lớp và Mã Môn:</label>
        <select class="form-control" name="malop_mamon" required>
            <?php
            foreach ($class_subjects as $class_subject) {
                $value = $class_subject["malop"] . "," . $class_subject["mamon"];
                echo "<option value='" . $value . "'>" . $class_subject["tenlop"] . " - " . $class_subject["tenmon"] . "</option>";
            }
            ?>
        </select>
        <br>
        <input class='btn btn-info' type="submit" value="Xem Danh Sách Sinh Viên">
    </form>
</body>

</html>
