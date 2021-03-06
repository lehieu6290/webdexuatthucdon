<?php
	session_start();
	if(isset($_SESSION['tendangnhap'])){
		$tendangnhap = $_SESSION['tendangnhap'];
		require 'ketnoicsdl.php';
		$sql_layvaitro = "SELECT ma_vai_tro FROM nguoidung WHERE ten_dang_nhap = '$tendangnhap' ";
		$result_layvaitro = $con->query($sql_layvaitro);
		$mavaitro =  $result_layvaitro->fetch_assoc()['ma_vai_tro'];
		if($mavaitro == 'admin'){
			if(isset($_GET['maloaimonan'])){
				$maloaimonan = $_GET['maloaimonan'];
				$sql_loaimonan = "SELECT ma_loai_mon_an, ten_loai_mon_an FROM loaimonan WHERE ma_loai_mon_an = '$maloaimonan'";
				$result_loaimonan = $con->query($sql_loaimonan);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sửa loại món ăn</title>
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
		if($result_loaimonan->num_rows > 0){
			$row = $result_loaimonan->fetch_assoc();
	?>
	<form action="xulysualoaimonan.php" method="POST">
		<input type="hidden" name="maloaimonan" value="<?php echo $row['ma_loai_mon_an'] ?>">
		<table class="form">
			<tr>
				<td>Tên loại món ăn</td>
				<td><input type="text" name="tenloaimonan" value="<?php echo $row['ten_loai_mon_an'] ?>"></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="sualoaimonan" value="Cập nhật" class="submit">
					<a href="danhsachloaimonan.php" class="link">Trở về</a>	
				</td>
			</tr>
		</table>
		
	</form>
	<?php 
		}else{
			echo "Loại món ăn không tồn tại!";
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
				echo "<p style='text-align: center; color: red'>Loại món ăn không tồn tại!</p>";
			}
		}else{
			echo "<p style='text-align: center; color: red'>Bạn không có quyền thực hiện chức năng này!</p>";
		}
	}else{
		header("Location: dangnhap.html");
	}
?>