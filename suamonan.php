<?php
	session_start();
	if(isset($_SESSION['tendangnhap'])){
		$tendangnhap = $_SESSION['tendangnhap'];
		require 'ketnoicsdl.php';
		
		if(isset($_GET['mamonan'])){
			$mamonan = $_GET['mamonan'];
			$sql_laymonan = "SELECT monan.ma_mon_an, monan.ten_mon_an, loaimonan.ten_loai_mon_an, monan.la_mon_chay, monan.luong_calo, GROUP_CONCAT(nguyenlieu.ten_nguyen_lieu) AS ten_nguyen_lieu
						FROM monannguyenlieu JOIN (nguyenlieu JOIN (monan JOIN loaimonan))
						ON monannguyenlieu.ma_nguyen_lieu = nguyenlieu.ma_nguyen_lieu AND monannguyenlieu.ma_mon_an = monan.ma_mon_an AND monan.ma_loai_mon_an = loaimonan.ma_loai_mon_an
						WHERE monan.ten_dang_nhap = '$tendangnhap' AND monan.ma_mon_an = '$mamonan'";
			$result_laymonan = $con->query($sql_laymonan);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sửa món ăn</title>
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
		if($result_laymonan->num_rows > 0){
			$row = $result_laymonan->fetch_assoc();
	?>
	<form action="xulysuamonan.php" method="POST">
		<input type="hidden" name="mamonan" value="<?php echo $row['ma_mon_an'] ?>">
		<table class="form">
			<tr>
				<td>Tên món ăn</td>
				<td><input type="text" name="tenmonan" value="<?php echo $row['ten_mon_an'] ?>" autocomplete="off"></td>
			</tr>
			<tr>
				<td>Loại món ăn</td>
				<td>
					<select name="maloaimonan">
					<?php
						$result_loaimonan = $con->query("SELECT * FROM loaimonan");
						while ($row_loaimonan = $result_loaimonan->fetch_assoc()){ ?>
						<option value="<?php echo $row_loaimonan['ma_loai_mon_an'] ?>"><?php echo $row_loaimonan['ten_loai_mon_an'] ?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Là món chay</td>
				<td>
					<select name="lamonchay">
						<option value="0">Không</option>
						<option value="1">Có</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Lượng calo</td>
				<td><input type="number" name="luongcalo" min="0" max="10000" value="<?php echo $row['luong_calo'] ?>"></td>
			</tr>
			<tr>
				<td>Nguyên liệu</td>
				<td>
					<p id="tennguyenlieu">
					<?php
						$cacnguyenlieu = explode(",", $row['ten_nguyen_lieu']);
						foreach ($cacnguyenlieu as $value) {
							echo "<span class='nguyenlieu' onclick='xoanguyenlieucu(this)'>" .$value. "</span>";	
						} 
					?>
					</p>
					<input style="display: none" id="tennguyenlieu-input" name="tennguyenlieu">
					<input type="text" id="nguyenlieu-input" placeholder="Nhập tên nguyên liệu" onkeyup="timnguyenlieu(this.value)" autocomplete="off">
					<div id="ketquatimkiem"></div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="suamonan" value="Cập nhật" class="submit">	
					<a href="danhsachmonan.php" class="link">Trở về</a>
				</td>
			</tr>
		</table>
		
	</form>
	<?php 
		}else{
			echo "Món ăn không tồn tại!";
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
	<script>
		function timnguyenlieu(value){
			if(value != ""){
				let xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function (){
					if(xhttp.readyState == 4 && xhttp.status == 200){
						document.getElementById("ketquatimkiem").innerHTML = xhttp.responseText;
					}
				}
				xhttp.open("GET", "timkiemnguyenlieu.php?tnl=" + value, true);
				xhttp.send();
			}else{
				document.getElementById("ketquatimkiem").innerHTML = "";
			}
		}

		function themvaotennguyenlieu(value){
			let text = document.getElementById("tennguyenlieu").innerText;
			let cacnguyenlieu = text.split(",");
			let exist = false;
			for(let i = 0; i < cacnguyenlieu.length; i++){
				if(value == cacnguyenlieu[i]){
					exist = true;
				}
			}

			if(exist){
				alert("Đã thêm nguyên liệu này");
			}else{
				let span = document.createElement("span");
				span.innerText = value;
				span.classList.add("nguyenlieu");
				span.onclick = xoanguyenlieu;
				document.getElementById("tennguyenlieu").appendChild(span);
				document.getElementById("nguyenlieu-input").value = "";
				document.getElementById("ketquatimkiem").innerHTML = "";
				capnhatTenNguyenLieuInput();
			}	
		}

		capnhatTenNguyenLieuInput();

		function xoanguyenlieu(){
			document.getElementById("tennguyenlieu").removeChild(this);
			capnhatTenNguyenLieuInput();
		}

		function xoanguyenlieucu(nguyenlieu){
			document.getElementById("tennguyenlieu").removeChild(nguyenlieu);
			capnhatTenNguyenLieuInput();
		}

		function capnhatTenNguyenLieuInput(){
			let cacnguyenlieu = document.getElementsByClassName("nguyenlieu");
			let text = '';
			for(let i = 0; i < cacnguyenlieu.length; i++){
				text += cacnguyenlieu[i].innerText + ',';
			}

			document.getElementById("tennguyenlieu-input").value = text;
		}

		function themnguyenlieu(){
			let tennguyenlieu = document.getElementById("nguyenlieu-input").value;
			let xhttp = new XMLHttpRequest();
			xhttp.open("POST", "xulythemnguyenlieu.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("themnguyenlieu=submit&tennguyenlieu=" + tennguyenlieu);
			themvaotennguyenlieu(tennguyenlieu);
			document.getElementById("ketquatimkiem").innerHTML = "Thêm nguyên liệu thành công";
			document.getElementById("nguyenlieu-input").value = "";
		}
	</script>
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