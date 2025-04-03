<!-- view_daotao.php -->

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sinh Viên và Điểm</title>
    <?php include "menu.php"; ?>
</head>

<body>
<div class="container mt-4"><br><br><br>
    <?php
    require_once("connection.php");

    // Kiểm tra xem có dữ liệu được gửi từ form không
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy giá trị malop và mamon từ form
        $malop_mamon = $_POST["malop_mamon"];

        // Tách giá trị malop và mamon từ chuỗi
        list($malop, $mamon) = explode(",", $malop_mamon);

        // Thực hiện truy vấn để lấy danh sách masv, tên sinh viên từ bảng sinh_vien
        $sql_students_only = "SELECT masv, hoten FROM sinh_vien WHERE malop = '$malop'";
        $result_students_only = $conn->query($sql_students_only);

        // Thực hiện truy vấn để lấy tên lớp và tên môn
        $sql_class_subject = "SELECT l.tenlop, m.tenmon FROM lop l, monhoc m WHERE l.malop = '$malop' AND m.mamon = '$mamon'";
        $result_class_subject = $conn->query($sql_class_subject);
        $row_class_subject = $result_class_subject->fetch_assoc();
        $tenlop = $row_class_subject["tenlop"];
        $tenmon = $row_class_subject["tenmon"];

        echo "<h1>Danh Sách Sinh Viên và Điểm</h1>";
        // Hiển thị thông tin lớp và môn
        echo "<p><strong>Lớp:</strong> $tenlop</p>";
        echo "<p><strong>Môn:</strong> $tenmon</p>";

        // Hiển thị danh sách sinh viên
        if ($result_students_only->num_rows > 0) {
            echo "<form action='process_diem.php' method='post'>";
            echo "<table class='table table-bordered'>
                    <tr>
                        <th>Mã Sinh Viên</th>
                        <th>Tên Sinh Viên</th>
                        <th>Tên Lớp</th>
                        <th>Tên Môn</th>
                        <th>Điểm 1</th>
                        <th>Điểm 2</th>
                        <th>Điểm Thi</th>
                        <th>Điểm TB Môn</th>
                    </tr>";

            while ($row_only = $result_students_only->fetch_assoc()) {
                $masv = $row_only["masv"];

                // Kiểm tra xem sinh viên có điểm hay không
                $sql_grades = "SELECT diem1, diem2, diemthi, diemtbm FROM diem WHERE masv = '$masv' AND mamon = '$mamon'";
                $result_grades = $conn->query($sql_grades);
                $row_grades = $result_grades->fetch_assoc();

                echo "<tr>
                        <td>" . $masv . "</td>
                        <td>" . $row_only["hoten"] . "</td>
                        <td>" . $tenlop . "</td>
                        <td>" . $tenmon . "</td>
                        <td><input type='text' name='diem1[$masv]' value='" . ($row_grades["diem1"] ?? '') . "'></td>
                        <td><input type='text' name='diem2[$masv]' value='" . ($row_grades["diem2"] ?? '') . "'></td>
                        <td><input type='text' name='diemthi[$masv]' value='" . ($row_grades["diemthi"] ?? '') . "'></td>
                        <td><input type='text' name='diemtbm[$masv]' value='" . ($row_grades["diemtbm"] ?? '') . "' readonly></td>
                    </tr>";
            }

            echo "</table>";
            echo "<input class='btn btn-info' type='submit' value='Lưu'>";
            echo "<input type='hidden' name='malop' value='" . htmlspecialchars($malop) . "'>";
            echo "<input type='hidden' name='MaMon' value='" . htmlspecialchars($mamon) . "'>";
            echo "</form>";
        } else {
            // Thông báo nếu không có sinh viên
            echo "Không có sinh viên nào trong lớp này.";
        }
    } else {
        // Nếu không có dữ liệu gửi từ form, hiển thị thông báo
        echo "Vui lòng chọn Mã Lớp và Mã Môn từ trang trước.";
    }

    // Đóng kết nối
    $conn->close();
    ?>

</body>

</html>
