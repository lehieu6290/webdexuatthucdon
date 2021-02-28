<!DOCTYPE html>
<html>
<head>
	<title>Trang chủ</title>
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
				session_start();
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
		<h2 style="text-align: center; margin: 10px;">Mời bạn nhập các yêu cầu phía dưới</h2>
		<div class="flex-center">
			<form action="ketqua.php" method="POST">
				<table class="form">
					<tr>
						<td>Loại bữa ăn</td>
						<td>
							<select name="loaibuaan">
								<option value="0">Ăn mặn</option>
								<option value="1">Ăn chay</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Ăn kiên</td>
						<td>
							<select name="ankien" onchange="thaydoiankien(this.value)">
								<option value="khong">Không</option>
								<option value="co">Có</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Lượng calo tối đa</td>
						<td>
							<p id="calo-warning" style="display: none; color: red; font-size: 13px;">Lượng calo khuyến khích cho người ăn kiên là 1500</p>
							<input id="calo-input" type="number" name="luongcalo" min="0" max="10000">
						</td>
					</tr>
					<tr>
						<td>Nguyên liệu không ăn được</td>
						<td>
							<p id="tennguyenlieu"></p>
							<input style="display: none" id="tennguyenlieu-input" name="tennguyenlieu">
							<input type="text" id="nguyenlieu-input" placeholder="Nhập tên nguyên liệu" onkeyup="timnguyenlieu(this.value)" autocomplete="off">
							<div id="ketquatimkiem"></div>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type="submit" name="dexuat" value="Xử lý" class="submit">	
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
	<script>
		function timnguyenlieu(value){
			if(value != ""){
				let xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function (){
					if(xhttp.readyState == 4 && xhttp.status == 200){
						document.getElementById("ketquatimkiem").innerHTML = xhttp.responseText;
					}
				}
				xhttp.open("GET", "timkiemnguyenlieu.php?tennl=" + value, true);
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

		function xoanguyenlieu(){
			document.getElementById("tennguyenlieu").removeChild(this);
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

		function thaydoiankien(value){
			if(value == "co"){
				document.getElementById("calo-input").value = "1500";
				document.getElementById("calo-input").disabled = "disabled";
				document.getElementById("calo-warning").style.display = "block";
			}else{
				document.getElementById("calo-input").disabled = null;
				document.getElementById("calo-input").value = "";
				document.getElementById("calo-warning").style.display = "none";
			}
		}
	</script>
</body>
</html>