<?php
	session_start();
	if(isset($_SESSION['tendangnhap'])){
?>
<!DOCTYPE html>
<html>
<head>
	<title>Thêm nguyên liệu</title>
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
				<?php 
				if(isset($_SESSION['tendangnhap'])){
					require 'ketnoicsdl.php';
					$tendangnhap = $_SESSION['tendangnhap'];
					$sql_laytennguoidung = "SELECT ten_nguoi_dung FROM nguoidung WHERE ten_dang_nhap = '$tendangnhap'";
					$result_laytennguoidung = $con->query($sql_laytennguoidung);
					$tennguoidung = $result_laytennguoidung->fetch_assoc()['ten_nguoi_dung'];
				?>
				<div>
					<p class="user-name"><?php echo $tennguoidung ?> &dtrif;</p>
					<div class="control-container">
						<a href="quanlytaikhoan.php">Quản lý tài khoản</a>
						<a href="dangxuat.php">Đăng xuất</a>
					</div>
				</div>
				<?php }else{ ?>
					<div>
						<a href="dangnhap.html" class="link">Đăng nhập</a>
						<span> | </span>
						<a href="dangky.html" class="link">Đăng ký</a>
					</div>
				<?php } ?>
			</div>
		</div>
	</header>
	
	<div class="center">
			<h2 style="text-align: center; margin: 10px;">Nhập đầy đủ thông tin bên dưới để thêm</h2>
			<div class="flex-center">
	<form action="xulythemnguyenlieu.php" method="POST">
		<table class="form">
			<tr>
				<td>Tên nguyên liệu</td>
				<td><input type="text" name="tennguyenlieu" autocomplete="off"></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="themnguyenlieu" value="Thêm" class="submit">	
					<a href="danhsachnguyenlieu.php" class="link">Trở về</a>
				</td>
			</tr>
		</table>
	</form>
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
<?php
	}else{
		header("Location: dangnhap.html");
	}
?>