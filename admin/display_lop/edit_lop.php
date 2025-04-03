<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Thông Tin Lớp Học</title>
    <?php include "menu.php"; ?>
</head>

<body>
    <h2>Sửa Thông Tin Lớp Học</h2>

    <?php
    require_once("connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = $_GET["id"];

        $sql = "SELECT * FROM lop WHERE malop = '$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    ?>
             <div class="container mt-5">
            <div class="form-group">
            <form action="update_lop.php" method="POST">
            <label for="malop">Mã lớp:</label>
            <input type="text"  class="form-control" name="malop" value="<?php echo $row['malop']; ?> " readonly>
                <input type="hidden"  class="form-control" name="malop" value="<?php echo $row['malop']; ?>">

                <label for="tenlop">Tên Lớp:</label>
                <input type="text"  class="form-control" name="tenlop" value="<?php echo $row['tenlop']; ?>"><br>

                <input type="submit" value="Lưu">
            </form>
    <?php
        } else {
            echo "Không tìm thấy môn học.";
        }
    }

    $conn->close();
    ?>
</body>

</html>
