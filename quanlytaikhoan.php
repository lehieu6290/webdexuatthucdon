<?php
	session_start();
	if(isset($_SESSION['tendangnhap'])){
		require 'ketnoicsdl.php';
		$tendangnhap = $_SESSION['tendangnhap'];
		$sql_laytennguoidung = "SELECT ten_nguoi_dung, ma_vai_tro FROM nguoidung WHERE ten_dang_nhap = '$tendangnhap'";
		$result_laytennguoidung = $con->query($sql_laytennguoidung);
		$row = $result_laytennguoidung->fetch_assoc();
		$tennguoidung = $row['ten_nguoi_dung'];
		$mavaitro = $row['ma_vai_tro'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Quản lý tài khoản</title>
	<meta charset="utf-8">
	<link rel="icon" href="hinhanh/hethong/logo.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<div class="center">
			<div class="flex-container">
				<div class="flex-container">
					<a href="index.php"><img src="hinhanh/hethong/logo.png" class="logo"></a>
					<h1 class="title">Hệ thống đề xuất thực đơn</h1>
				</div>
				<div>
				</div>
			</div>
		</div>
	</header>

	<div class="center">
		<h2 style="text-align: center; padding: 20px;">Xin chào <?php echo $tennguoidung ?></h2>
		<div class="flex-center">
			<div>
				<a href="index.php" class="submit">Trang chủ</a>
				<span class="submit">
					Quản lý món ăn
					<div class="hidden-container">
						<a href="themmonan.php">Thêm món ăn</a>
						<a href="danhsachmonan.php">Danh sách món ăn</a>
					</div>
				</span>
				<span class="submit">
					Quản lý nguyên liệu
					<div class="hidden-container">
						<a href="themnguyenlieu.php">Thêm nguyên liệu</a>
						<a href="danhsachnguyenlieu.php">Danh sách nguyên liệu</a>
					</div>
				</span>
				<?php if($mavaitro == 'admin'){ ?>
				<span class="submit">
					Quản lý loại món ăn
					<div class="hidden-container">
						<a href="themloaimonan.php">Thêm loai món ăn</a>
						<a href="danhsachloaimonan.php">Danh sách loại món ăn</a>
					</div>
				</span>
				<?php } ?>
				<a href="dangxuat.php" class="submit">Đăng xuất</a>
			</div>
		</div>
	</div>

	<footer>
		<div class="center">
			<div class="flex-container">
				<div>
					<p>Giảng viên hướng dẫn</p>
					<p>TS Lâm Nhựt Khang</p>
				</div>
				<div>
					<p>Sinh viên thực hiện</p>
					<p>Lê Trung Hiếu</p>
				</div>
			</div>
		</div>
	</footer>
</body>
</html>

<?php } ?>