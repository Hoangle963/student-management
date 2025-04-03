<!-- them_diem_check.php -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Điểm</title>
</head>
<?php include "menu.php"; ?>
<body>
    <div style="margin-left: 2%">
    <div class="container mt-5">
<br><br>
        <h2>Thêm Điểm</h2>

        <?php
        require_once("connection.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $masv = $_POST["masv"];
            $mamon = $_POST["MaMon"];

            // Kiểm tra xem đã có điểm hay chưa
            $sql_check_grade = "SELECT * FROM diem WHERE masv = '$masv' AND mamon = '$mamon'";
            $result_check_grade = $conn->query($sql_check_grade);

            if ($result_check_grade->num_rows > 0) {
                // Đã có điểm, hiển thị form sửa điểm
                $row_grade = $result_check_grade->fetch_assoc();
                $diem1 = $row_grade["diem1"];
                $diem2 = $row_grade["diem2"];
                $diemthi = $row_grade["diemthi"];

                // Hiển thị form sửa điểm
                echo "<form action='process_edit_diem.php' method='post'>
                        <input type='hidden' name='masv' value='$masv'>
                        <input type='hidden' name='mamon' value='$mamon'>
                        <label for='diem1'>Điểm 1:</label>
                        <input type='text' class='form-control' name='diem1' value='$diem1'><br>
                        <label for='diem2'>Điểm 2:</label>
                        <input type='text' class='form-control' name='diem2' value='$diem2'><br>
                        <label for='diemthi'>Điểm Thi:</label>
                        <input type='text' class='form-control' name='diemthi' value='$diemthi'><br>
                        <input  class='btn btn-info' type='submit' value='Lưu'>
                    </form>";
            } else {
                // Chưa có điểm, hiển thị form thêm điểm mới
                echo "<form action='process_add_diem.php' method='post'>
                        <input type='hidden' name='masv' value='$masv'>
                        <input type='hidden' name='mamon' value='$mamon'>
                        <label for='diem1'>Điểm 1:</label>
                        <input type='text' name='diem1'><br>
                        <label for='diem2'>Điểm 2:</label>
                        <input type='text' name='diem2'><br>
                        <label for='diemthi'>Điểm Thi:</label>
                        <input type='text' name='diemthi'><br>
                        <input type='submit'  class='btn btn-info' value='Thêm'>
                    </form>";
            }
        }

        $conn->close();
        ?>
    </div>
</body>

</html>
