<!DOCTYPE html>
<html lang="en">

<?php include "menu.php"; ?>

<head>
    <!-- Add your existing head content here -->

    <style>
        /* Add your existing styles here */
    </style>
</head>

<body>
    <div class="container mt-4"><br><br><br>
        <h1 class="mb-4">Danh Sách Sinh Viên</h1>

        <!-- Add a form to dynamically fetch the list of classes -->
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="classSelect">Chọn lớp:</label>
            <select class="form-control" id="classSelect" name="selectedClass">
                <option value="" disabled selected>Chọn lớp</option>
                <?php
                // Include connection.php to establish a database connection
                require_once("connection.php");

                // Select distinct classes from the database
                $sql_classes = "SELECT DISTINCT malop, tenlop FROM lop";
                $result_classes = $conn->query($sql_classes);

                // Populate the dropdown with class options
                while ($class_row = $result_classes->fetch_assoc()) {
                    $class_id = $class_row["malop"];
                    $class_name = $class_row["tenlop"];
                    echo '<option value="' . $class_id . '">' . $class_name . '</option>';
                }
                ?>
            </select>
            <br>
            <button type="submit" class="btn btn-primary">Hiển thị danh sách</button>

            <!-- Add a button for exporting to Excel -->
            <?php
            if (isset($_POST['selectedClass'])) {
                $selectedClass = $_POST['selectedClass'];

                // Fetch the name of the selected class
                $sql_selected_class = "SELECT tenlop FROM lop WHERE malop = '$selectedClass'";
                $result_selected_class = $conn->query($sql_selected_class);

                if ($result_selected_class->num_rows > 0) {
                    $selectedClassName = $result_selected_class->fetch_assoc()["tenlop"];
                } else {
                    $selectedClassName = ""; // Set a default value if the class name is not found
                }

                echo '<a href="export_excel.php?selectedClass=' . $selectedClass . '" class="btn btn-success ml-2">Xuất Excel</a>';
            }
            ?>
        </form>

        <?php
        // Check if a class is selected
        if (isset($selectedClass)) {
            // Display the selected class name
           

            // Query to get students in the selected class
            $sql_students = "SELECT * FROM sinh_vien WHERE malop = '$selectedClass'";
            $result_students = $conn->query($sql_students);

            // Display the student list for the selected class
            if ($result_students->num_rows > 0) {
                echo '<div class="accordion" id="accordionExample">';
                echo '<div class="accordion-item">';
                echo '<h2 class="accordion-header" id="heading' . $selectedClass . '">';
                echo '<button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $selectedClass . '" aria-expanded="false" aria-controls="collapse' . $selectedClass . '">';
                echo "Danh sách lớp: $selectedClass -  $selectedClassName";
                echo '</button>';
                echo '</h2>';

                echo "<div id='collapse$selectedClass' class='accordion-collapse collapse show' aria-labelledby='heading$selectedClass' data-bs-parent='#accordionExample'>";
                echo '<div class="accordion-body">';
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Mã sinh viên</th>';
                echo '<th>Họ và Tên</th>';
                echo '<th>Giới tính</th>';
                echo '<th>Ngày sinh</th>';
                echo '<th>Email</th>';
                echo '<th>Hoạt động</th>';
                // Add more table headers as needed
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($student_row = $result_students->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $student_row["masv"] . '</td>';
                    echo '<td>' . $student_row["hoten"] . '</td>';
                    echo '<td>' . $student_row["gioitinh"] . '</td>';
                    echo '<td>' . $student_row["Ngaysinh"] . '</td>';
                    echo '<td>' . $student_row["email"] . '</td>';
                    echo '<td>';
                    echo '<a class="btn btn-info" href="update.php?masv=' . $student_row["masv"] . '">Sửa</a> | ';
                    echo '<a class="btn btn-info" href="delete.php?masv=' . $student_row["masv"] . '" onclick="return confirm(\'Bạn có chắc chắn muốn xóa không?\');">Xóa</a>';
                    echo '</td>';
                    // Add more table columns as needed
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<p>Không có sinh viên nào trong lớp này.</p>';
            }
        }

        // Close the database connection
        $conn->close();
        ?>

    </div>

    <!-- Add your existing scripts and footer include here -->
</body>

</html>
