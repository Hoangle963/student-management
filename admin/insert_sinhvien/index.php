<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sinh Viên</title>
    <?php include "menu.php"; ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Sự kiện khi người dùng chọn ngành học hoặc khóa học
            $("select[name='nganhhoc'], select[name='khoahoc']").change(function () {
                updateClassList();
            });

            // Hàm cập nhật danh sách lớp
            function updateClassList() {
                var nganhhoc = $("select[name='nganhhoc']").val();
                var khoahoc = $("select[name='khoahoc']").val();

                // Gửi yêu cầu AJAX để lấy danh sách lớp từ server
                $.ajax({
                    type: "POST",
                    url: "get_class_list.php",
                    data: {
                        nganhhoc: nganhhoc,
                        khoahoc: khoahoc
                    },
                    success: function (response) {
                        $("#class-list-container").html(response);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("Lỗi khi tải danh sách lớp. Kiểm tra Console để biết chi tiết.");
                    }
                });
            }
        });
    </script>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <br><br><br>
        <h1 class="mb-4">Thêm Sinh Viên</h1>

        <!-- Nút chuyển hướng đến trang nhập file Excel -->
      
        <!-- Biểu mẫu thêm sinh viên -->
        <form action="process_insert.php" method="post">
            <div class="form-group">
                <label for="hoten">Họ và Tên:</label>
                <input type="text" class="form-control" name="hoten" required>
            </div>
            <div class="form-group">
                <label for="gioitinh">Giới Tính:</label>
                <select class="form-control" name="gioitinh" required>
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select>
            </div>
            <div class="form-group">
                <label for="Ngaysinh">Ngày Sinh:</label>
                <input type="date" class="form-control" name="Ngaysinh" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label for="nganhhoc">Ngành Học:</label>
                <select class="form-control" name="nganhhoc" required>
                    <!-- Load danh sách ngành học từ cơ sở dữ liệu -->
                    <?php
                    require_once("connection.php");
                    $sql_nganh = "SELECT ma_nh, ten_nganh FROM nganh_hoc";
                    $result_nganh = $conn->query($sql_nganh);
                    if ($result_nganh->num_rows > 0) {
                        while ($row_nganh = $result_nganh->fetch_assoc()) {
                            echo "<option value='" . $row_nganh["ma_nh"] . "'>" . $row_nganh["ten_nganh"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="khoahoc">Khóa Học:</label>
                <select class="form-control" name="khoahoc" required>
                    <!-- Load danh sách khóa học từ cơ sở dữ liệu -->
                    <?php
                    $sql_khoa = "SELECT id_khoa, namhoc FROM khoa_hoc";
                    $result_khoa = $conn->query($sql_khoa);
                    if ($result_khoa->num_rows > 0) {
                        while ($row_khoa = $result_khoa->fetch_assoc()) {
                            echo "<option value='" . $row_khoa["id_khoa"] . "'>" . $row_khoa["namhoc"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div id="class-list-container" class="mb-3"></div>
            <button type="submit" class="btn btn-primary">Thêm Sinh Viên</button>
        </form>
    </div>
</body>

<footer class="footer mt-auto py-3">
    <div class="container">
        <span class="text-muted">Báo cáo tốt nghiệp sinh viên trường đại học Tài Nguyên và Môi Trường Hà Nội.</span>
    </div>
</footer>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</html>
