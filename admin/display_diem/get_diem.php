<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy "ma_dt" từ form
    $selected_ma_dt = $_POST["ma_dt"];

    // Thực hiện xử lý truy vấn điểm dựa trên "ma_dt"
    require_once("connection.php");

    // Truy vấn để lấy thông tin malop, mamon từ daotao
    $sql_info = "SELECT malop, mamon FROM daotao WHERE ma_dt = ?";
    $stmt_info = $conn->prepare($sql_info);
    $stmt_info->bind_param("s", $selected_ma_dt);
    $stmt_info->execute();
    $result_info = $stmt_info->get_result();
    $row_info = $result_info->fetch_assoc();
    $malop = $row_info["malop"];
    $mamon = $row_info["mamon"];

    // Thực hiện truy vấn để lấy điểm dựa trên "ma_dt"
    $sql_diem = "SELECT sv.masv, sv.hoten, d.diem1, d.diem2, d.diemthi, d.diemtbm
                 FROM sinh_vien sv
                 LEFT JOIN diem d ON sv.masv = d.masv
                 WHERE sv.malop = ? AND d.mamon = ?";
    $stmt_diem = $conn->prepare($sql_diem);
    $stmt_diem->bind_param("ss", $malop, $mamon);
    $stmt_diem->execute();
    $result_diem = $stmt_diem->get_result();
    function convertToGradeDescription($numericGrade) {
        if ($numericGrade < 4.0) {
            return 'Thi lại';
        } else {
            return 'Đạt';
        }
    }
    // Function to convert numeric grade to letter grade
    function convertToLetterGrade($numericGrade) {
        // ... (unchanged)
        if ($numericGrade < 4.0) {
            return 'F';
        }elseif ($numericGrade < 5.0) {
            return 'D';
        } elseif ($numericGrade < 5.5) {
            return 'D+';
        } elseif ($numericGrade < 6.5) {
            return 'C';
        } elseif ($numericGrade < 7.0) {
            return 'C+';
        } elseif ($numericGrade < 8.0) {
            return 'B';
        } elseif ($numericGrade < 8.5) {
            return 'B+';
        } 
         else {
            return 'A';
    }
    }
    if ($result_diem->num_rows > 0) {
        // Hiển thị bảng điểm
        echo "<table class='table table-bordered'>
                <tr>
                    <th>Mã Sinh Viên</th>
                    <th>Tên Sinh Viên</th>
                    <th>Điểm 1</th>
                    <th>Điểm 2</th>
                    <th>Điểm Thi</th>
                    <th>Điểm TB Môn</th>
                    <th>Điểm Chữ</th>
                    <th>Điểm Hệ 4</th>
                    <th>Nhận xét</th>
                    <th>Hoạt động</th>
                </tr>";

        while ($row = $result_diem->fetch_assoc()) {
            // Escape HTML output
            $escapedName = htmlspecialchars($row["hoten"], ENT_QUOTES, 'UTF-8');

            echo "<tr>
                    <td>" . $row["masv"] . "</td>
                    <td>" . $escapedName . "</td>
                    <td>" . $row["diem1"] . "</td>
                    <td>" . $row["diem2"] . "</td>
                    <td>" . $row["diemthi"] . "</td>
                    <td>" . $row["diemtbm"] . "</td>
                    <td>" . convertToLetterGrade($row["diemtbm"]) . "</td>
                    <td>" . ($row["diemtbm"] < 4.0 ? '0.0' : ($row["diemtbm"] < 5.0 ? '1.0' : ($row["diemtbm"] < 5.5 ? '1.5' : ($row["diemtbm"] < 6.5 ? '2.0' : ($row["diemtbm"] < 7.0 ? '2.5' : ($row["diemtbm"] < 8.0 ? '3.0' : ($row["diemtbm"] < 8.5 ? '3.5' : '4.0'))))))) . "</td>
                    <td>" . convertToGradeDescription($row["diemtbm"]) . "</td>
                    <td>
                        <a class='btn btn-primary' href='edit_diem.php?masv=" . $row["masv"] . "&mamon=" . $mamon . "'>Sửa</a>
                        <a class='btn btn-primary' href='delete_diem.php?masv=" . $row["masv"] . "&mamon=" . $mamon . "'>Xóa</a>
                    </td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "Không có điểm nào cho Mã Đào Tạo: $selected_ma_dt.";
    }
    // Inside the existing HTML, add the export button
echo "</table>
<form action='export_excel.php' method='post'>
    <input type='hidden' name='ma_dt' value='$selected_ma_dt'>
    <button type='submit' class='btn btn-success'>Xuất Excel</button>
</form>";

    // Đóng kết nối
    $stmt_info->close();
    $stmt_diem->close();
    $conn->close();
} else {
    // Nếu không phải là phương thức POST, chuyển hướng hoặc thông báo lỗi tùy ý
    echo "Lỗi: Phương thức không hợp lệ.";
}
?>