<?php
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get "ma_dt" from the form
    $selected_ma_dt = $_POST["ma_dt"];

    // Perform query to get information about malop, mamon, tenlop, and tenmon from daotao
    require_once("connection.php");

    $sql_info = "SELECT dt.malop, dt.mamon, lop.tenlop, monhoc.tenmon
                 FROM daotao dt
                 LEFT JOIN lop ON dt.malop = lop.malop
                 LEFT JOIN monhoc ON dt.mamon = monhoc.mamon
                 WHERE dt.ma_dt = ?";
    $stmt_info = $conn->prepare($sql_info);
    $stmt_info->bind_param("s", $selected_ma_dt);
    $stmt_info->execute();
    $result_info = $stmt_info->get_result();

    if ($result_info->num_rows > 0) {
        $row_info = $result_info->fetch_assoc();
        $malop = $row_info["malop"];
        $mamon = $row_info["mamon"];
        $tenlop = $row_info["tenlop"];
        $tenmon = $row_info["tenmon"];

        // Query to get student scores based on "ma_dt"
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
            } elseif ($numericGrade < 5.0) {
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
            } else {
                return 'A';
            }
        }

        if ($result_diem !== null) {
            if ($result_diem->num_rows > 0) {
                // Create a new PHPSpreadsheet object
                $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

                // Set document properties
                $spreadsheet->getProperties()->setCreator('Your Name')
                    ->setLastModifiedBy('Your Name')
                    ->setTitle('Student Scores Export')
                    ->setSubject('Student Scores Export')
                    ->setDescription('Exported student scores');

                // Merge cells for the first row
                $spreadsheet->getActiveSheet()->mergeCells('A1:K1');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
                // Add value to the merged cell
                $spreadsheet->getActiveSheet()->setCellValue('A1', "$tenlop - $tenmon");

                // Add header row starting from the second row
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A2', 'Mã Sinh Viên')
                    ->setCellValue('B2', 'Tên Sinh Viên')
                    ->setCellValue('C2', 'Tên Lớp')
                    ->setCellValue('D2', 'Tên Môn')
                    ->setCellValue('E2', 'Điểm 1')
                    ->setCellValue('F2', 'Điểm 2')
                    ->setCellValue('G2', 'Điểm Thi')
                    ->setCellValue('H2', 'Điểm TB Môn')
                    ->setCellValue('I2', 'Điểm Chữ')
                    ->setCellValue('J2', 'Điểm Hệ 4')
                    ->setCellValue('K2', 'Nhận xét');

                // Set row counter
                $row = 3;

                // Loop through the result set and add data to the spreadsheet
                while ($row_data = $result_diem->fetch_assoc()) {
                    $spreadsheet->getActiveSheet()
                        ->setCellValue('A' . $row, $row_data["masv"])
                        ->setCellValue('B' . $row, $row_data["hoten"])
                        ->setCellValue('C' . $row, $tenlop)
                        ->setCellValue('D' . $row, $tenmon)
                        ->setCellValue('E' . $row, $row_data["diem1"])
                        ->setCellValue('F' . $row, $row_data["diem2"])
                        ->setCellValue('G' . $row, $row_data["diemthi"])
                        ->setCellValue('H' . $row, $row_data["diemtbm"])
                        ->setCellValue('I' . $row, convertToLetterGrade($row_data["diemtbm"]))
                        ->setCellValue('J' . $row, ($row_data["diemtbm"] < 4.0 ? '0.0' : ($row_data["diemtbm"] < 5.0 ? '1.0' : ($row_data["diemtbm"] < 5.5 ? '1.5' : ($row_data["diemtbm"] < 6.5 ? '2.0' : ($row_data["diemtbm"] < 7.0 ? '2.5' : ($row_data["diemtbm"] < 8.0 ? '3.0' : ($row_data["diemtbm"] < 8.5 ? '3.5' : '4.0'))))))))
                        ->setCellValue('K' . $row, convertToGradeDescription($row_data["diemtbm"]));

                    $row++;
                }

                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="exported_excel.xlsx"');
                header('Cache-Control: max-age=0');

                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $writer->save('php://output');
                exit();
            } else {
                echo "Không có điểm nào cho Mã Đào Tạo: $selected_ma_dt.";
            }

            // Close connections
            $stmt_info->close();
            $stmt_diem->close();
            $conn->close();
        } else {
            echo "Error retrieving student scores.";
        }
    } else {
        echo "Không có thông tin cho Mã Đào Tạo: $selected_ma_dt.";
    }

    // Close the connection
    $stmt_info->close();
    $conn->close();
} else {
    // If not a POST request, redirect or display an error message as desired
    echo "Lỗi: Phương thức không hợp lệ.";
}
?>
