    <?php
    // Kết nối đến cơ sở dữ liệu
    require_once("connection.php");

    // Bắt đầu session
    session_start();
    include "menu.php";
    // Lấy thông tin từ session
    $magv = $_SESSION['taikhoan'];

    // Truy vấn CSDL để lấy danh sách lớp học và môn học của giáo viên
    $query = "SELECT dt.malop, dt.mamon, l.tenlop, m.tenmon
            FROM daotao dt
            JOIN lop l ON dt.malop = l.malop
            JOIN monhoc m ON dt.mamon = m.mamon
            WHERE dt.magv = '$magv' AND dt.lock_diem = 0";

    $result = $conn->query($query);

    // Lưu danh sách lớp học và môn học vào một mảng
    $classSubjectList = array();
    while ($row = $result->fetch_assoc()) {
        $classSubjectList[] = $row;
    }

    // Lấy thông tin được chọn từ form
    $selectedClassSubject = isset($_POST['classSubject']) ? $_POST['classSubject'] : null;

    // Nếu có lớp học và môn học được chọn, thực hiện truy vấn để lấy danh sách sinh viên và điểm
    if ($selectedClassSubject) {
        list($malop, $mamon) = explode("-", $selectedClassSubject);

        // Truy vấn CSDL để lấy danh sách sinh viên và điểm của lớp học và môn học
        $queryStudent = "SELECT sv.masv, sv.hoten, d.diem1, d.diem2, d.diemthi, d.diemtbm
                        FROM sinh_vien sv
                        LEFT JOIN diem d ON sv.masv = d.masv AND d.mamon = '$mamon'
                        WHERE sv.malop = '$malop'";

        $resultStudent = $conn->query($queryStudent);

        // Lưu danh sách sinh viên và điểm vào một mảng
        $studentList = array();
        while ($rowStudent = $resultStudent->fetch_assoc()) {
            $studentList[] = $rowStudent;
        }
    } else {
        $studentList = array(); // Mảng trống khi form chưa được submit
    }

    // Đóng kết nối CSDL
    $conn->close();
    ?>

    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Danh Sách Sinh Viên và Điểm</title>
    </head>
    <body>
    <div class='container mt-4'>
    <form action="index.php" method="post">
        <label for="classSubject">Chọn Lớp Học và Môn Học:</label>
        <select class="form-control" name="classSubject" id="classSubject">
            <?php
            // Hiển thị danh sách lớp học và môn học trong dropdown
            foreach ($classSubjectList as $classSubject) {
                $selected = ($selectedClassSubject == $classSubject['malop'] . "-" . $classSubject['mamon']) ? 'selected' : '';
                echo "<option value='" . $classSubject['malop'] . "-" . $classSubject['mamon'] . "' $selected>" . $classSubject['tenlop'] . " - " . $classSubject['tenmon'] . "</option>";
            }
            ?>
        </select><br>
        <input class="btn btn-info" type="submit" value="Hiển Thị Danh Sách Sinh Viên và Điểm">
    </form>

    <?php
    // Hiển thị danh sách sinh viên và điểm nếu đã chọn lớp học và môn học
    if (!empty($studentList)) {
        echo " <div class='container mt-4'>
        <h2>Danh Sách Sinh Viên và Điểm</h2>";
        echo "<form action='process_diem.php' method='post'>";
        echo "  <table class='table table-bordered'>
    
                <tr>
                    <th>Mã Sinh Viên</th>
                    <th>Họ và Tên</th>
                    <th>Điểm 1</th>
                    <th>Điểm 2</th>
                    <th>Điểm Thi</th>
                    <th>Điểm TB Môn</th>
                </tr>";
        foreach ($studentList as $student) {
            echo "<tr>
                    <td>" . $student['masv'] . "</td>
                    <td>" . $student['hoten'] . "</td>
                    <td><input type='text' name='diem1[" . $student['masv'] . "]' value='" . ($student['diem1'] ?? '') . "'></td>
                    <td><input type='text' name='diem2[" . $student['masv'] . "]' value='" . ($student['diem2'] ?? '') . "'></td>
                    <td><input type='text' name='diemthi[" . $student['masv'] . "]' value='" . ($student['diemthi'] ?? '') . "'></td>
                    <td><input type='text' name='diemtbm[" . $student['masv'] . "]' value='" . ($student['diemtbm'] ?? '') . "' readonly></td>
                </tr>";
        }
        echo "</table>";
        echo "<input class='btn btn-info' type='submit' value='Lưu'>";
        echo "<input type='hidden' name='malop' value='" . htmlspecialchars($malop) . "'>";
        echo "<input type='hidden' name='MaMon' value='" . htmlspecialchars($mamon) . "'>";
        echo "</form>";
    }
    ?>

    </body>
    </html>
