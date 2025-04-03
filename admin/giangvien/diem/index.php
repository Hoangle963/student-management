<?php
// Kết nối đến cơ sở dữ liệu
require_once("connection.php");

// Bắt đầu session
session_start();

// Lấy thông tin từ session
$magv = $_SESSION['taikhoan'];

// Truy vấn CSDL
$query = "SELECT sv.masv, sv.hoten
          FROM sinh_vien sv
          JOIN daotao dt ON sv.malop = dt.malop
          WHERE dt.magv = '$magv'";

$result = $conn->query($query);

// Lưu danh sách sinh viên vào một mảng
$sinhVienList = array();
while ($row = $result->fetch_assoc()) {
    // Sử dụng masv làm khóa để loại bỏ trùng lặp
    $sinhVienList[$row['masv']] = $row;
}

// Đóng kết nối CSDL
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn Sinh Viên và Môn Học</title>
    <?php include "menu.php"; ?>


    <style>
        /* Ẩn form mamon khi trang được load */
        #formMamon {
            display: none;
        }
    </style>
</head>
<body>
<div class='container mt-4'>
<form action="process_selected_student.php" method="post">
    <label for="sinhVien">Chọn Sinh Viên:</label>
    <select  class="form-control"  name="sinhVien" id="sinhVien" onchange="showMamonForm()">
        <?php
        // Hiển thị danh sách sinh viên trong dropdown
        foreach ($sinhVienList as $masv => $sinhVien) {
            echo "<option value='" . $masv . "'>" . $sinhVien['masv'] . " - " . $sinhVien['hoten'] . "</option>";
        }
        ?>
    </select>
    

</form>

<form action="process_selected_subject.php" method="post" id="formMamon">
    <!-- Các tùy chọn mamon sẽ được thêm vào đây sau khi chọn sinh viên -->
    <label for="mamon">Chọn Môn Học:</label>
    <select  class="form-control"  name="mamon" id="mamon">
        <!-- Các tùy chọn mamon sẽ được thêm vào đây từ PHP -->
    </select><br>
  
    <button class='btn btn-info' type="button" onclick="fetchGradeList()">Xem Danh Sách Điểm</button>
</form>

<script>
    function showMamonForm() {
        // Lấy giá trị được chọn từ dropdown
        var selectedValue = document.getElementById("sinhVien").value;

        // Kiểm tra giá trị được chọn
        if (selectedValue !== "") {
            // Nếu có giá trị, hiển thị form mamon
            document.getElementById("formMamon").style.display = "block";
            
            // Gửi AJAX request để lấy danh sách mamon và cập nhật dropdown mamon
            fetch("get_mamon_list.php?masv=" + selectedValue)
                .then(response => response.json())
                .then(data => {
                    // Cập nhật dropdown mamon với các tùy chọn từ data
                    var mamonDropdown = document.getElementById("mamon");
                    mamonDropdown.innerHTML = "";
                    data.forEach(mamon => {
                        var option = document.createElement("option");
                        option.value = mamon.mamon;
                        option.text = mamon.mamon + " - " + mamon.tenmon; // Hiển thị cả mamon và tenmon
                        mamonDropdown.add(option);
                    });
                });
        } else {
            // Nếu không có giá trị, ẩn form mamon
            document.getElementById("formMamon").style.display = "none";
        }
    }

    function confirmSelection() {
        var selectedSinhVien = document.getElementById("sinhVien").value;
        var selectedMamon = document.getElementById("mamon").value;
        
        if (selectedSinhVien !== "" && selectedMamon !== "") {
            alert("Đã chọn Sinh Viên và Môn Học. Bạn có thể xem danh sách điểm.");
        } else {
            alert("Vui lòng chọn Sinh Viên và Môn Học trước khi xác nhận.");
        }
    }

    function fetchGradeList() {
        var selectedSinhVien = document.getElementById("sinhVien").value;
        var selectedMamon = document.getElementById("mamon").value;

        if (selectedSinhVien !== "" && selectedMamon !== "") {
            // Redirect to a new page (process_selected_grade.php) with selected masv and mamon
            window.location.href = "process_lay_diem.php?masv=" + selectedSinhVien + "&mamon=" + selectedMamon;
        } else {
            alert("Vui lòng chọn Sinh Viên và Môn Học trước khi xem danh sách điểm.");
        }
    }
</script>

</body>
</html>
