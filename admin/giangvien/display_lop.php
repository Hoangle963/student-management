<?php
// Kết nối đến cơ sở dữ liệu
require_once("connection.php");

// Kiểm tra xem session đã khởi tạo chưa



// Lấy tài khoản từ session


// Kiểm tra xem có tham số malop được truyền từ URL không
if (!isset($_GET['malop'])) {
    echo "Mã lớp không hợp lệ.";
    exit;
}

// Lấy mã lớp từ tham số trong URL
$malop = $_GET['malop'];

// Truy vấn cơ sở dữ liệu để lấy thông tin sinh viên của lớp và tên lớp
$sql = "SELECT sv.*, lop.tenlop FROM sinh_vien sv
        JOIN lop ON sv.malop = lop.malop
        WHERE sv.malop = '$malop'";
$result = $conn->query($sql);

$tenlop = ""; // Khởi tạo một giá trị mặc định

if ($result->num_rows > 0) {
    // Lấy tên lớp từ dòng đầu tiên của kết quả truy vấn
    $row = $result->fetch_assoc();
    $tenlop = $row['tenlop'];

    // Đưa con trỏ về đầu kết quả
    $result->data_seek(0);
}


// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sinh Viên Lớp <?php echo $malop; ?></title>
 
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ced4da;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>Danh Sách Sinh Viên Lớp <?php echo $malop; ?> - <?php echo $tenlop; ?></h2>

<div class="container">
    <!-- Hiển thị thông tin từ bảng sinh_vien -->
    <table>
        <tr>
            <th>Mã Sinh Viên</th>
            <th>Họ và Tên</th>
            <th>Giới Tính</th>
            <th>Ngày Sinh</th>
            <th>Email</th>
            <!-- Thêm các cột khác tùy ý -->
        </tr>
        <?php
        // Hiển thị thông tin từ kết quả truy vấn
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['masv'] . "</td>";
            echo "<td>" . $row['hoten'] . "</td>";
            echo "<td>" . $row['gioitinh'] . "</td>";
            echo "<td>" . $row['Ngaysinh'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            // Thêm các cột khác tùy ý
            echo "</tr>";
        }
        ?>
    </table>
</div>

<!-- Nội dung trang đào tạo ở đây -->

</body>
</html>
