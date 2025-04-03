<?php

// Include the necessary PHPSpreadsheet classes
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Function to sanitize data for Excel
function cleanData($data)
{
    return htmlspecialchars(strip_tags($data), ENT_QUOTES, 'UTF-8');
}

// Check if selectedClass is set and not empty
if (isset($_GET['selectedClass']) && !empty($_GET['selectedClass'])) {
    $selectedClass = $_GET['selectedClass'];

    // Include connection.php to establish a database connection
    require_once("connection.php");

    // Query to get class details
    $sql_class = "SELECT malop, tenlop FROM lop WHERE malop = '$selectedClass'";
    $result_class = $conn->query($sql_class);

    // Fetch class details
    $class_details = $result_class->fetch_assoc();
    $classID = $class_details["malop"];
    $className = $class_details["tenlop"];

    // Query to get students in the selected class
    $sql_students = "SELECT * FROM sinh_vien WHERE malop = '$selectedClass'";
    $result_students = $conn->query($sql_students);

    // Create a new PHPExcel object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Merge cells for the title and center align it, apply style
    $sheet->mergeCells('A1:E1');
    $sheet->setCellValue('A1', "Danh sách sinh viên lớp $classID $className");
    $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);

    // Add headers to the Excel file and center align them, apply style
    $headers = ['Mã sinh viên', 'Họ và Tên', 'Giới tính', 'Ngày sinh', 'Email'];
    $sheet->fromArray([$headers], NULL, 'A2');
    $sheet->getStyle('A2:E2')->getAlignment()->setHorizontal('center');
    $sheet->getStyle('A2:E2')->getFont()->setBold(true);

    // Set column width for each column
    $sheet->getColumnDimension('A')->setWidth(15);
    $sheet->getColumnDimension('B')->setWidth(30);
    $sheet->getColumnDimension('C')->setWidth(15);
    $sheet->getColumnDimension('D')->setWidth(15);
    $sheet->getColumnDimension('E')->setWidth(30);

    // Set row counter
    $row = 3;

    // Iterate through the students and add data to the Excel file, center aligning each cell, apply style
    while ($student_row = $result_students->fetch_assoc()) {
        $data = [
            cleanData($student_row["masv"]),
            cleanData($student_row["hoten"]),
            cleanData($student_row["gioitinh"]),
            cleanData($student_row["Ngaysinh"]),
            cleanData($student_row["email"])
        ];
        $sheet->fromArray([$data], NULL, 'A' . $row);
        $sheet->getStyle('A' . $row . ':E' . $row)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A' . $row . ':E' . $row)->getBorders()->getAllBorders()->setBorderStyle('thin');

        // Increment the row counter
        $row++;
    }

    // Save Excel file
    $filename = "DanhSachSinhVien_Lop$classID$className.xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    // Close the database connection
    $conn->close();
} else {
    // Redirect to the main page if selectedClass is not set
    header("Location: index.php");
    exit();
}
