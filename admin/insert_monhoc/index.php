<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Môn Học</title>
    <?php include "menu.php"; ?>
</head>
<body>
<div class="container mt-5"><br><br>
    <h1>Thêm Môn Học</h1>
    <form action="process.php" method="post">
    <div class="form-group">  
        <label for="tenmon">Tên Môn Học:</label>
        <input type="text"  class="form-control" name="tenmon" required>
        <br>
        <label for="sotinchi">Số Tín Chỉ:</label>
        <input type="number"  class="form-control" name="sotinchi" required>
        <br>
        <input type="submit" value="Thêm Môn Học">
    </form>
</body>
</html>
