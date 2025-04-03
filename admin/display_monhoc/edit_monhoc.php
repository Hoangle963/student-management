<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Thông Tin Môn Học</title>
    <?php include "menu.php"; ?>
</head>

<body>
<div class="container mt-5"><br><br><br>
    <h2>Sửa Thông Tin Môn Học</h2>

    <?php
    require_once("connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = $_GET["id"];

        $sql = "SELECT * FROM monhoc WHERE mamon = '$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    ?>
            <form action="update_monhoc.php" method="POST">
            <div class="form-group">
                <input type="hidden"  class="form-control"  name="mamon" value="<?php echo $row['mamon']; ?>">

                <label for="tenmon">Tên Môn Học:</label>
                <input type="text"  class="form-control"  name="tenmon" value="<?php echo $row['tenmon']; ?>"><br>

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
