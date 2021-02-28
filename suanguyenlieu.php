<?php
	session_start();
	if(isset($_SESSION['tendangnhap'])){
		$tendangnhap = $_SESSION['tendangnhap'];
		require 'ketnoicsdl.php';
		
		if(isset($_GET['manguyenlieu'])){
			$manguyenlieu = $_GET['manguyenlieu'];
			$sql_nguyenlieu = "SELECT ma_nguyen_lieu, ten_nguyen_lieu FROM nguyenlieu WHERE ma_nguyen_lieu = '$manguyenlieu'";
			$result_nguenlieu = $con->query($sql_nguyenlieu);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sửa nguyên liệu</title>
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
			<h2 style="text-align: center; margin: 10px;">Nhập đầy đủ thông tin bên dưới để cập nhât</h2>
			<div class="flex-center">
	<?php
		if($result_nguenlieu->num_rows > 0){
			$row = $result_nguenlieu->fetch_assoc();
	?>
	<form action="xulysuanguyenlieu.php" method="POST">
		<input type="hidden" name="manguyenlieu" value="<?php echo $row['ma_nguyen_lieu'] ?>">
		<table class="form">
			<tr>
				<td>Tên nguyên liệu</td>
				<td><input type="text" name="tennguyenlieu" value="<?php echo $row['ten_nguyen_lieu'] ?>"></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="suanguyenlieu" value="Cập nhật" class="submit">	
					<a href="danhsachnguyenlieu.php" class="link">Trở về</a>
				</td>
			</tr>
		</table>
		
	</form>
	<?php 
		}else{
			echo "Nguyên liệu không tồn tại!";
		}
	?>
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
			echo "<p style='text-align: center; color: red'>Nguyên liệu không tồn tại!</p>";
		}
	}else{
		header("Location: dangnhap.html");
	}
?>