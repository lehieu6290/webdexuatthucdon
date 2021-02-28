<!DOCTYPE html>
<html>
<head>
	<title>Lỗi</title>
	<meta charset="utf-8">
</head>
<body>
<?php
if(isset($_POST['dangky'])){
	$tendangnhap = isset($_POST['tendangnhap']) ? $_POST['tendangnhap'] : null;
	$matkhau1 = isset($_POST['matkhau1']) ? $_POST['matkhau1'] : null;
	$matkhau2 = isset($_POST['matkhau2']) ? $_POST['matkhau2'] : null;
	$tennguoidung = isset($_POST['tennguoidung']) ? $_POST['tennguoidung'] : null;
	
	require 'ketnoicsdl.php';
	if ($con->connect_errno) {
  		echo "Kết nối CSDL thất bại!";
  		exit();
	}else{
		
		if($tendangnhap != null && $matkhau1 != null && $matkhau2 != null  && $tennguoidung != null ){
			if(strcmp(md5($matkhau1), md5($matkhau2)) == 0){
				//Xu ly ma doc
				$tendangnhap = htmlspecialchars($tendangnhap);
				$matkhau1 = htmlspecialchars($matkhau1);
				$matkhau2 = htmlspecialchars($matkhau2);
				$tennguoidung = htmlspecialchars($tennguoidung);

				$tendangnhap = $con->real_escape_string($tendangnhap);
				$matkhau1 = $con->real_escape_string($matkhau1);
				$matkhau2 = $con->real_escape_string($matkhau2);
				$tennguoidung = $con->real_escape_string($tennguoidung);

				//Xu ly matkhau
				$matkhau = md5($matkhau1);

				//Them vao CSDL
				$sql = "INSERT INTO nguoidung(ten_dang_nhap,mat_khau,ten_nguoi_dung) VALUES (?,?,?)";
				$stmt = $con->prepare($sql);
				$stmt->bind_param("sss", $tendangnhap, $matkhau, $tennguoidung);
				$stmt->execute();
				$con->close();

				header("Location: dangnhap.html");
			}else{
				echo "<p style='text-align: center; color: red'>Mật khẩu và mật khẩu nhập lại phải trùng nhau!</p>";
			}
		}else{
			echo "<p style='text-align: center; color: red'>Phải nhập đầy đủ thông tin!</p>";
		}
	}
}
?>

</body>
</html>