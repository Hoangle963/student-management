<?php
// Kết nối đến cơ sở dữ liệu
require_once("connection.php");



// Lấy thông tin từ session
$magv = $_SESSION['taikhoan'];

// Truy vấn CSDL để lấy thông tin giảng viên từ bảng giang_vien
$queryGiangVien = "SELECT hoten FROM giang_vien WHERE magv = '$magv'";
$resultGiangVien = $conn->query($queryGiangVien);

// Đảm bảo rằng có dữ liệu để hiển thị
if ($resultGiangVien->num_rows > 0) {
    $rowGiangVien = $resultGiangVien->fetch_assoc();
    $hotenGiangVien = $rowGiangVien['hoten'];

    // Truy vấn CSDL để lấy thông tin từ bảng daotao và đếm số sinh viên
    $sql = "SELECT daotao.malop, daotao.mamon, COUNT(sinh_vien.masv) AS so_sinh_vien, lop.tenlop, monhoc.tenmon
            FROM daotao
            LEFT JOIN sinh_vien ON daotao.malop = sinh_vien.malop
            LEFT JOIN lop ON daotao.malop = lop.malop
            LEFT JOIN monhoc ON daotao.mamon = monhoc.mamon
            WHERE daotao.magv = '$magv'
            GROUP BY daotao.malop, daotao.mamon, lop.tenlop, monhoc.tenmon";

    $result = $conn->query($sql);

    // Đóng kết nối cơ sở dữ liệu - Dời đoạn này xuống cuối để đảm bảo result có dữ liệu trước khi đóng kết nối
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Đào Tạo</title>

    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        h2 {
            margin-left: 2%;
        }
    </style>

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<?php
echo " <div class='container mt-4'>";
// Check if $hotenGiangVien is set in the session
if (isset($hotenGiangVien)) :
?>
    <h2>Xin chào, <?php echo $hotenGiangVien; ?>! Đây là danh sách các lớp học của bạn.</h2>
    <!-- Use Bootstrap Accordion -->
    <div id="accordion">
        <?php
        // Initialize an index variable for unique identifiers
        $index = 1;

        // Loop through the result set
        while ($row = $result->fetch_assoc()) :
            // Truy vấn CSDL để lấy danh sách sinh viên của lớp (sử dụng $row['malop'] từ kết quả truy vấn trước)
            $malop_sinhvien = $row['malop'];
            $query_sinhvien = "SELECT * FROM sinh_vien WHERE malop = '$malop_sinhvien'";
            $result_sinhvien = $conn->query($query_sinhvien);
        ?>
            <div class="card">
                <div class="card-header" id="heading<?php echo $index; ?>">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $index; ?>" aria-expanded="true" aria-controls="collapse<?php echo $index; ?>">
                            Mã Lớp: <?php echo $row['malop']; ?> - Tên Lớp: <?php echo $row['tenlop']; ?> - Mã Môn: <?php echo $row['mamon']; ?> - Tên Môn: <?php echo $row['tenmon']; ?> - Số Sinh Viên: <?php echo $row['so_sinh_vien']; ?>
                        </button>
                    </h5>
                </div>
                <div id="collapse<?php echo $index; ?>" class="collapse" aria-labelledby="heading<?php echo $index; ?>" data-parent="#accordion">
                    <div class="card-body">
                        <?php
                        // Kiểm tra xem có sinh viên nào hay không
                        if ($result_sinhvien->num_rows > 0) {
                            echo '<table class="table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Mã Sinh Viên</th>';
                            echo '<th>Họ và Tên</th>';
                            echo '<th>Giới Tính</th>';
                            echo '<th>Ngày Sinh</th>';
                            echo '<th>Email</th>';
                            // Thêm các cột khác tùy ý
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            // Hiển thị thông tin từ kết quả truy vấn sinh viên
                            while ($row_sinhvien = $result_sinhvien->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row_sinhvien['masv'] . '</td>';
                                echo '<td>' . $row_sinhvien['hoten'] . '</td>';
                                echo '<td>' . $row_sinhvien['gioitinh'] . '</td>';
                                echo '<td>' . $row_sinhvien['Ngaysinh'] . '</td>';
                                echo '<td>' . $row_sinhvien['email'] . '</td>';
                                // Thêm các cột khác tùy ý
                                echo '</tr>';
                            }
                            echo '</tbody>';
                            echo '</table>';
                        } else {
                            echo '<p>Không có sinh viên trong lớp này.</p>';
                        }

                        // Đóng kết nối cơ sở dữ liệu sau khi sử dụng dữ liệu sinh viên
                        $result_sinhvien->close();
                        ?>
                    </div>
                </div>
            </div>
        <?php
            // Increment the index for the next iteration
            $index++;
        endwhile;
        ?>
    </div>
<?php
endif;

// Đóng kết nối cơ sở dữ liệu sau khi sử dụng dữ liệu
$conn->close();
?>

<!-- Include Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
