<?
include "menu.php"?>

<?php
// Kết nối đến cơ sở dữ liệu
require_once("connection.php");

// Bắt đầu session

include "menu.php";

// Lấy thông tin từ session
$masv = $_SESSION['taikhoan'];

// Truy vấn CSDL để lấy malop từ masv
$queryMalop = "SELECT malop FROM sinh_vien WHERE masv = '$masv'";
$resultMalop = $conn->query($queryMalop);

if ($resultMalop->num_rows > 0) {
    $rowMalop = $resultMalop->fetch_assoc();
    $malop = $rowMalop['malop'];

    // Truy vấn CSDL để lấy danh sách môn học, năm học, học kì từ bảng daotao
    $queryDaotao = "SELECT mamon, namhoc, hocki FROM daotao WHERE malop = '$malop'";
    $resultDaotao = $conn->query($queryDaotao);

    if ($resultDaotao->num_rows > 0) {
        // Hiển thị tiêu đề
        echo " <div class='container mt-4'><br><br><br><h2>Danh Sách Điểm</h2>";

        // Form để chọn năm học và học kì
        echo "<form method='post' action=''>";
        
        echo "<div class='form-group'>";
        echo "<label for='namhoc'>Chọn Năm Học:</label>";
        echo "<select name='namhoc' class='form-control'>";
        // Thêm các option cho năm học
        echo "<option value=''>Tất cả</option>";
        echo "<option value='1'>Năm 1</option>";
        echo "<option value='2'>Năm 2</option>";
        echo "<option value='3'>Năm 3</option>";
        echo "<option value='4'>Năm 4</option>";
        echo "</select>";
        echo "</div>";

        echo "<div class='form-group'>";
        echo "<label for='hocki'>Chọn Học Kì:</label>";
        echo "<select name='hocki' class='form-control'>";
        // Thêm các option cho học kì
        echo "<option value=''>Tất cả</option>";
        echo "<option value='1'>Kì 1</option>";
        echo "<option value='2'>Kì 2</option>";
        echo "</select>";
        echo "</div>";

        echo "<button type='submit' class='btn btn-primary'>Lọc</button>";
        echo "</form>";

        // Lấy dữ liệu từ form
        $selectedNamhoc = isset($_POST['namhoc']) ? $_POST['namhoc'] : '';
        $selectedHocki = isset($_POST['hocki']) ? $_POST['hocki'] : '';

        // Initialize an array to store data for each namhoc and hocki combination
        $tables = array();

        // Initialize variables for total GPA and total credits
        $totalGPA = 0;
        $totalCredits = 0;

        // Initialize variables for overall GPA calculation
        $overallWeightedGPA = 0;
        $overalldiemtbm = 0;
        $overallTotalSotinchi = 0;

        // Loop through each row in the result set
        while ($rowDaotao = $resultDaotao->fetch_assoc()) {
            $mamon = $rowDaotao['mamon'];
            $namhoc = $rowDaotao['namhoc'];
            $hocki = $rowDaotao['hocki'];
        
            // Kiểm tra điều kiện lọc
            if (($selectedNamhoc == '' || $selectedNamhoc == $namhoc) &&
                ($selectedHocki == '' || $selectedHocki == $hocki)) {
        
                // Truy vấn CSDL để lấy thông tin điểm từ bảng diem
                $queryDiem = "SELECT * FROM diem WHERE masv = '$masv' AND mamon = '$mamon'";
                $resultDiem = $conn->query($queryDiem);
        
                // Truy vấn CSDL để lấy tên môn từ bảng monhoc
                $queryMonhoc = "SELECT tenmon, sotinchi FROM monhoc WHERE mamon = '$mamon'";
                $resultMonhoc = $conn->query($queryMonhoc);
        
                if ($resultDiem->num_rows > 0) {
                    // Store data in the tables array
                    if (!isset($tables[$namhoc][$hocki])) {
                        $tables[$namhoc][$hocki] = array();
                    }
        
                    // Fetch subject name and sotinchi
                    $subjectData = ($resultMonhoc->num_rows > 0) ? $resultMonhoc->fetch_assoc() : array('tenmon' => 'Unknown', 'sotinchi' => 0);
        
                    $tables[$namhoc][$hocki][] = array('mamon' => $mamon, 'subjectData' => $subjectData, 'resultDiem' => $resultDiem);
                }
            }
        }
        
        // Display tables for each combination
        foreach ($tables as $namhoc => $hockis) {
            foreach ($hockis as $hocki => $data) {
                // Display accordion for each combination
                
                echo "<div class='accordion' id='accordion{$namhoc}{$hocki}'>";
                echo "<div class='card'>";
                echo "<div class='card-header' id='heading{$namhoc}{$hocki}'>";
                echo "<h2 class='mb-0'>";
                echo "<button class='btn btn-link' type='button' data-toggle='collapse' data-target='#collapse{$namhoc}{$hocki}' aria-expanded='true' aria-controls='collapse{$namhoc}{$hocki}'>";
                echo "Năm học $namhoc - Học kì $hocki";
                echo "</button>";
                echo "</h2>";
                echo "</div>";
        
                // Initialize variables for weighted GPA calculation
                $totalWeightedGPA = 0;
                $totalSotinchi = 0;
                $totaldiemtbm = 0;
                $totalHocphan = 0; // Tổng số học phần
        
                echo "<div id='collapse{$namhoc}{$hocki}' class='collapse show' aria-labelledby='heading{$namhoc}{$hocki}' data-parent='#accordion{$namhoc}{$hocki}'>";
                echo "<div class='card-body'>";
                echo "<table class='table table-striped table-bordered'>";
                echo "<thead><tr><th>Mã Môn</th><th>Tên Môn</th><th>Số Tín Chỉ</th><th>Điểm 1</th><th>Điểm 2</th><th>Điểm Thi</th><th>Điểm TB Môn</th><th>Điểm Hệ 4</th><th>Điểm Chữ</th><th>Tình Trạng</th><th>Xin phúc khảo</th></tr></thead>";
        
                foreach ($data as $item) {
                    $mamon = $item['mamon'];
                    $subjectData = $item['subjectData'];
                    $resultDiem = $item['resultDiem'];
        
                    // Display data for each record
                    while ($rowDiem = $resultDiem->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $mamon . "</td>";
                        echo "<td>" . $subjectData['tenmon'] . "</td>";
                        echo "<td>" . $subjectData['sotinchi'] . "</td>";
                        echo "<td>" . $rowDiem['diem1'] . "</td>";
                        echo "<td>" . $rowDiem['diem2'] . "</td>";
                        echo "<td>" . $rowDiem['diemthi'] . "</td>";
                        echo "<td>" . $rowDiem['diemtbm'] . "</td>";
        
                        // Calculate weighted GPA
                        $totalWeightedGPA += ($subjectData['sotinchi'] * calculateGPA($rowDiem['diemtbm']));
                        $totaldiemtbm += ($subjectData['sotinchi'] * $rowDiem['diemtbm']);
                        $totalSotinchi += $subjectData['sotinchi'];
                        $totalHocphan++;
        
                        // Calculate GPA, letter grade, and status
                        $gpa = calculateGPA($rowDiem['diemtbm']);
                        $letterGrade = calculateLetterGrade($gpa);
                        $status = calculateStatus($gpa);
        
                        // Display additional columns
                        echo "<td>" . convertGPAToHe10($gpa) . "</td>";  // Convert GPA to Hệ 10 and display
                        echo "<td>" . $letterGrade . "</td>";
                        echo "<td>" . $status . "</td>";
                        echo "<td>";
                        echo "<a href='xuliphuckhao.php?masv=" . $masv . "&mamon=" . $mamon . "'>Xin phúc khảo</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                }
        
                echo "</table>";
        
                // Calculate and display weighted GPA
                if ($totalSotinchi > 0) {
                    $gpa = $totalWeightedGPA / $totalSotinchi;
                    $gpa10 = $totaldiemtbm / $totalSotinchi;
                    echo "<p>Điểm trung bình tích lũy (GPA) của kỳ học này: " . round($gpa, 2) . " <br> Điểm trung bình tích lũy (GPA) hệ 10 của kỳ học này: " . round($gpa10, 2) . "</p>";
        
                    // Add to overall calculations
                    $overallWeightedGPA += $totalWeightedGPA;
                    $overalldiemtbm += $totaldiemtbm;
                    $overallTotalSotinchi += $totalSotinchi;
        
                } else {
                    echo "<p>Chưa có điểm để tính GPA.</p>";
                }
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                
                // ... (continue with the rest of your code)
                
            }
        }
        
if ($overallTotalSotinchi > 0) {
    $overallGPA = $overallWeightedGPA / $overallTotalSotinchi;
    echo "<div class='container-fluid'>";
    echo "<table class='table table-bordered'>";
    echo "<tr><th>Thông tin tổng cộng:</th></tr>";
    echo "<tr><td>Điểm trung bình tích lũy (GPA) tổng cộng của tất cả các bảng:</td><td class='text-left'>" . round($overallGPA, 2) . "</td></tr>";

    // Calculate and display overall GPA for the table
    if ($overallTotalSotinchi > 0) {
        $overallGPA = $overalldiemtbm / $overallTotalSotinchi;
        echo "<tr><td>Điểm trung bình hệ 10 của cả quá trình học:</td><td class='text-left'>" . round($overallGPA, 2) . "</td></tr>";
        echo "<tr><td>Tổng tín chỉ tích lũy:</td><td class='text-left'>" . round($overallTotalSotinchi, 2) . "</td></tr>";
        // Calculate and display total GPA and total credits
        $totalGPA += $overallGPA;
        $totalCredits += $overallTotalSotinchi;
    } else {
        echo "<tr><td>Chưa có điểm để tính điểm trung bình của bảng.</td></tr>";
    }
    echo "</table>";
    echo "</div>";
} else {
    echo "<p>Chưa có điểm để tính GPA tổng cộng.</p>";
}

// ... (continue with the rest of your code)

        
    }
} else {
    echo "Không tìm thấy mã lớp của sinh viên.";
}

// Đóng kết nối CSDL
$conn->close();

// Function to calculate GPA
function calculateGPA($diemtbm)
{
    if ($diemtbm >= 0 && $diemtbm <= 4) {
        return 0;
    } elseif ($diemtbm >= 4.0 && $diemtbm <= 4.7) {
        return 1;
    } elseif ($diemtbm >= 4.8 && $diemtbm <= 5.4) {
        return 1.5;
    } elseif ($diemtbm >= 5.5 && $diemtbm <= 6.2) {
        return 2;
    } elseif ($diemtbm >= 6.3 && $diemtbm <= 6.9) {
        return 2.5;
    } elseif ($diemtbm >= 7.0 && $diemtbm <= 7.7) {
        return 3;

    } elseif ($diemtbm >= 7.0 && $diemtbm <= 7.7) {
        return 3;
    } elseif ($diemtbm >= 7.8 && $diemtbm <= 8.4) {
        return 3.5;
    } elseif ($diemtbm >= 8.5 && $diemtbm <= 10) {
        return 4;
    }
}

// Function to calculate letter grade
function calculateLetterGrade($gpa)
{
    if ($gpa == 0) {
        return 'F';
    } elseif ($gpa == 1) {
        return 'D';
    } elseif ($gpa == 1.5) {
        return 'D+';
    } elseif ($gpa == 2) {
        return 'C';
    } elseif ($gpa == 2.5) {
        return 'C+';
    } elseif ($gpa == 3) {
        return 'B';
    } elseif ($gpa == 3.5) {
        return 'B+';
    } elseif ($gpa == 4) {
        return 'A';
    }
}

// Function to calculate status
function calculateStatus($gpa)
{
    if ($gpa >= 0 && $gpa <= 1) {
        return 'Thi lại';
    } else {
        return 'Đạt';
    }
}

// Function to convert GPA to Hệ 10
function convertGPAToHe10($gpa)
{
    if ($gpa == 0) {
        return 0;
    } elseif ($gpa == 1) {
        return 1;
    } elseif ($gpa == 1.5) {
        return 1.5;
    } elseif ($gpa == 2) {
        return 2;
    } elseif ($gpa == 2.5) {
        return 2.5;
    } elseif ($gpa == 3) {
        return 3;
    } elseif ($gpa == 3.5) {
        return 3.5;
    } elseif ($gpa == 4) {
        return 4;
    }
}
?>
</div>