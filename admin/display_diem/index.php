<!-- view_diem.php -->

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Điểm</title>
    <?php include "menu.php"; ?><br><br><br>
    <!-- Thêm Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Thêm jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <div class="container mt-4">
        <h1>Danh Sách Điểm Theo Lớp và Môn</h1>
        <form action='/qlsv/admin/khoa_diem' method='post'>
    <input type='hidden' name='' >
    <button type='submit' class='btn btn-success'>Khóa điểm</button>
</form>
        <!-- Add a form to select "ma_dt" from the "daotao" table -->
        <form id="diemForm">
            <label for="ma_dt">Chọn Mã Đào Tạo:</label>
            <select name="ma_dt" id="ma_dt" class="form-control">
                <?php
                require_once("connection.php");

                // Thực hiện truy vấn để lấy danh sách "ma_dt" từ bảng "daotao"
                $sql_daotao = "SELECT DISTINCT ma_dt, malop, mamon FROM daotao";
                $result_daotao = $conn->query($sql_daotao);

                while ($row_daotao = $result_daotao->fetch_assoc()) {
                    $ma_dt_option = $row_daotao["ma_dt"];
                    $malop_option = $row_daotao["malop"];
                    $mamon_option = $row_daotao["mamon"];

                    // Fetch "tenlop" and "tenmon" from the "lop" and "monhoc" tables
                    $sql_fetch_names = "SELECT tenlop, tenmon FROM lop, monhoc WHERE malop = '$malop_option' AND mamon = '$mamon_option'";
                    $result_names = $conn->query($sql_fetch_names);
                    $row_names = $result_names->fetch_assoc();
                    $tenlop = $row_names["tenlop"];
                    $tenmon = $row_names["tenmon"];

                    echo "<option value='$ma_dt_option'>$ma_dt_option - $tenlop - $malop_option - $tenmon - $mamon_option </option>";
                }

                // Đóng kết nối
                $conn->close();
                ?>
            </select>
            <br>
            <!-- Thêm sự kiện input để gọi hàm showDiem ngay khi có sự thay đổi -->
        </form>

        <div id="diemContent"></div>

        <!-- Thêm Bootstrap JS và Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.1/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script>
            // Đảm bảo sự kiện được đăng ký sau khi trang đã tải hoàn toàn
            $(document).ready(function() {
                // Hàm sẽ được gọi khi giá trị của select box thay đổi
                function showDiem() {
                    // Lấy giá trị từ form
                    var selected_ma_dt = $("#ma_dt").val();

                    // Sử dụng Ajax để gọi get_diem.php và hiển thị nội dung trả về
                    $.ajax({
                        type: "POST",
                        url: "get_diem.php",
                        data: { ma_dt: selected_ma_dt },
                        success: function(response) {
                            // Hiển thị nội dung trả về trong div có id là "diemContent"
                            $("#diemContent").html(response);
                        }
                    });
                }

                // Sự kiện input sẽ gọi hàm showDiem ngay khi giá trị của select box thay đổi
                $("#ma_dt").on("input", function() {
                    showDiem();
                });
            });
        </script>
    </div>
</body>

</html>
