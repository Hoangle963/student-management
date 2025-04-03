<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Lớp</title>
    <?php include "menu.php"; ?>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Sự kiện khi trang được tải
            loadDropdowns();

            // Sự kiện khi người dùng chọn ma_nh hoặc id_khoa
            $("select[name='ma_nh'], select[name='id_khoa']").change(function () {
                updateKihieu();
            });

            // Hàm cập nhật giá trị cho kihieu_n và kihieu_k
            function updateKihieu() {
                var ma_nh = $("select[name='ma_nh']").val();
                var id_khoa = $("select[name='id_khoa']").val();

                // Gửi yêu cầu AJAX để lấy kihieu_n và kihieu_k từ server
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: { ma_nh: ma_nh, id_khoa: id_khoa },
                    success: function (response) {
                        var result = JSON.parse(response);
                        // Hiển thị kihieu_k + kihieu_n vào trường tenlop
                        $("input[name='tenlop']").val(result.kihieu_k + result.kihieu_n);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("Lỗi khi lấy dữ liệu kí hiệu. Kiểm tra Console để biết chi tiết.");
                    }
                });
            }

            // Hàm tải dữ liệu cho dropdowns ban đầu
            function loadDropdowns() {
                // Load ma_nh dropdown
                $.ajax({
                    type: "GET",
                    url: "get_data.php?type=ma_nh",
                    success: function (response) {
                        $("select[name='ma_nh']").html(response);
                        // Trigger sự kiện change để cập nhật kihieu khi trang được tải
                        $("select[name='ma_nh']").trigger('change');
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("Lỗi khi tải dữ liệu ma_nh. Kiểm tra Console để biết chi tiết.");
                    }
                });

                // Load id_khoa dropdown
                $.ajax({
                    type: "GET",
                    url: "get_data.php?type=id_khoa",
                    success: function (response) {
                        $("select[name='id_khoa']").html(response);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("Lỗi khi tải dữ liệu id_khoa. Kiểm tra Console để biết chi tiết.");
                    }
                });
            }
        });
    </script>
</head>
<body>
<div class="container mt-5"><br><br>
    <h1>Thêm Lớp</h1>
    <form action="process_insert.php" method="post">
    <div class="form-group">    
    <label for="ma_nh">Mã Ngành:</label>
        <select  class="form-control" name="ma_nh" required></select>
        <br>
        <label for="id_khoa">ID Khoa:</label>
        <select  class="form-control" name="id_khoa" required></select>
        <br>

        <!-- Trường để nhập tên lớp -->
        <label  for="tenlop">Tên Lớp:</label>
        <input type="text" class="form-control" name="tenlop" required>
        <br>
        <input type="submit" value="Thêm Lớp">
    </form>
</body>
</html>
