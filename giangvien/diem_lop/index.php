<?php
require_once("connection.php");

session_start();
include "menu.php";
// Lấy giá trị của taikhoan từ session
$taikhoan = $_SESSION['taikhoan'];
echo " <div class='container mt-4'>";
// Truy vấn SQL để lấy danh sách malop, mamon, tenmon, tenlop từ bảng daotao, monhoc, lop dựa trên magv (taikhoan)
$sqlDaotao = "SELECT daotao.malop, daotao.mamon, daotao.lock_diem, monhoc.tenmon, lop.tenlop 
              FROM daotao 
              INNER JOIN monhoc ON daotao.mamon = monhoc.mamon 
              INNER JOIN lop ON daotao.malop = lop.malop 
              WHERE daotao.magv = '$taikhoan'";
$resultDaotao = $conn->query($sqlDaotao);

// Kiểm tra và hiển thị bảng điểm theo malop và mamon
if ($resultDaotao->num_rows > 0) {
    while ($rowDaotao = $resultDaotao->fetch_assoc()) {
        $malop = $rowDaotao['malop'];
        $mamon = $rowDaotao['mamon'];
        $tenmon = $rowDaotao['tenmon'];
        $tenlop = $rowDaotao['tenlop'];
        $lock_diem = $rowDaotao['lock_diem'];

        // Kiểm tra lock_diem, nếu là 1 thì không hiển thị chức năng "Sửa" và "Xóa"
        $disableEditDelete = ($lock_diem == 1) ? 'disabled' : '';

        // Truy vấn SQL để lấy danh sách sinh viên từ bảng sinh_vien dựa trên malop
        $sqlSinhVien = "SELECT masv, hoten FROM sinh_vien WHERE malop = '$malop'";
        $resultSinhVien = $conn->query($sqlSinhVien);

        echo "<h2>Điểm Lớp $tenlop - Môn $tenmon</h2>";
        echo "<table class='table table-bordered'>
                <tr>
                    <th>Mã Sinh Viên</th>
                    <th>Họ và Tên</th>
                    <th>Điểm 1</th>
                    <th>Điểm 2</th>
                    <th>Điểm Thi</th>
                    <th>Điểm TB Môn</th>";
            
        // Hiển thị chức năng "Sửa" và "Xóa" nếu lock_diem không bằng 1
        if ($lock_diem != 1) {
            echo "<th>Sửa</th>
                  <th>Xóa</th>";
        }

        echo "</tr>";

        while ($rowSinhVien = $resultSinhVien->fetch_assoc()) {
            $masv = $rowSinhVien['masv'];
            $hoten = $rowSinhVien['hoten'];

            // Truy vấn SQL để lấy điểm từ bảng diem dựa trên masv và mamon
            $sqlDiem = "SELECT diem1, diem2, diemthi, diemtbm FROM diem WHERE masv = '$masv' AND mamon = '$mamon'";
            $resultDiem = $conn->query($sqlDiem);

            if ($resultDiem->num_rows > 0) {
                while ($rowDiem = $resultDiem->fetch_assoc()) {
                    echo "<tr>
                            <td>$masv</td>
                            <td>$hoten</td>
                            <td>{$rowDiem['diem1']}</td>
                            <td>{$rowDiem['diem2']}</td>
                            <td>{$rowDiem['diemthi']}</td>
                            <td>{$rowDiem['diemtbm']}</td>";

                    // Hiển thị chức năng "Sửa" và "Xóa" nếu lock_diem không bằng 1
                    if ($lock_diem != 1) {
                        echo "<td><a class='btn btn-primary' href='sua.php?masv=$masv&mamon=$mamon' $disableEditDelete>Sửa</a></td>
                              <td><a class='btn btn-primary' href='xoa.php?masv=$masv&mamon=$mamon' $disableEditDelete>Xóa</a></td>";
                    }

                    echo "</tr>";
                }
            } else {
                echo "<tr>
                        <td>$masv</td>
                        <td>$hoten</td>
                        <td colspan='4'>Không có điểm</td>";

                // Hiển thị chức năng "Sửa" và "Xóa" nếu lock_diem không bằng 1
                if ($lock_diem != 1) {
                    echo "<td><a class='btn btn-primary' href='sua.php?masv=$masv&mamon=$mamon' $disableEditDelete>Sửa</a></td>
                          <td><a class='btn btn-primary' href='xoa.php?masv=$masv&mamon=$mamon' $disableEditDelete>Xóa</a></td>";
                }

                echo "</tr>";
            }
        }

        echo "</table>";
    }
} else {
    echo "Không có dữ liệu.";
}

// Đóng kết nối CSDL
$conn->close();
?>
