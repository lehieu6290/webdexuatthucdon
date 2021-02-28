<?php
	session_start();
	if(isset($_SESSION['tendangnhap'])){
		$tendangnhap = $_SESSION['tendangnhap'];
		require 'ketnoicsdl.php';
		$sql_layvaitro = "SELECT ma_vai_tro FROM nguoidung WHERE ten_dang_nhap = '$tendangnhap' ";
		$result_layvaitro = $con->query($sql_layvaitro);
		$mavaitro =  $result_layvaitro->fetch_assoc()['ma_vai_tro'];
		if($mavaitro == 'admin'){
			$sql_dsloaimonan= "SELECT ma_loai_mon_an, ten_loai_mon_an FROM loaimonan";
			$result_dsloaimonan = $con->query($sql_dsloaimonan);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Danh sách loại món ăn</title>
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
			<h2 style="text-align: center; margin: 10px;">Danh sách các loại món ăn</h2>
			<div class="flex-center">
				<div>
					<div style="text-align: center;">
						<input type="text" placeholder="Nhập tên loại món ăn" id="search" onkeyup="timkiem(this.value)" autocomplete="off">
						<a href="themloaimonan.php" class="submit">Thêm loại món ăn</a>
					</div>
	<?php
		if($result_dsloaimonan->num_rows > 0){
	?>
	<table id="danhsachmonan" class="table">
		<tr>
			<th>STT</th>
			<th>Tên loại món ăn</th>
			<th colspan="2">Hành động</th>
		</tr>
		<?php
			$stt = 1; 
			while($row = $result_dsloaimonan->fetch_assoc()){ 
		?>
		<tr>
			<td><?php echo $stt++ ?></td>
			<td><?php echo $row['ten_loai_mon_an'] ?></td>
			<td><a href="sualoaimonan.php?maloaimonan=<?php echo $row['ma_loai_mon_an'] ?>"><img class="icon" src="hinhanh/hethong/edit_icon.png" title="Sửa"></a></td>
			<td><a href="xoaloaimonan.php?maloaimonan=<?php echo $row['ma_loai_mon_an'] ?>"><img class="icon" src="hinhanh/hethong/delete_icon.png" title="Xóa"></a></td>
		</tr>

		<?php } ?>
	</table>
	<?php 
		}else{
			echo "<p style='text-align: center; color: red; padding: 10px;'>Không có loại món ăn nào!</p>";
		}
	?>
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
	<script>
		function timkiem(value){
			let xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function (){
				if(xhttp.readyState == 4 && xhttp.status == 200){
					document.getElementById("danhsachmonan").innerHTML = xhttp.responseText;
				}
			}
			xhttp.open("GET", "timkiemloaimonan.php?tenloaimonan=" + value, true);
			xhttp.send();
		}
	</script>
</body>
</html>
<?php
		}else{
			echo "<p style='text-align: center; color: red'>Bạn không có quyền thực hiện chức năng này!</p>";
		}
	}else{
		header("Location: dangnhap.html");
	}
?>