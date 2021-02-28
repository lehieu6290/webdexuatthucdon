<!DOCTYPE html>
<html>
<head>
	<title>Lỗi</title>
	<meta charset="utf-8">
</head>
<body>
<?php
if(isset($_POST['dangnhap'])){
	$tendangnhap = isset($_POST['tendangnhap']) ? $_POST['tendangnhap'] : null;
	$matkhau = isset($_POST['matkhau']) ? $_POST['matkhau'] : null;
	
	require 'ketnoicsdl.php';
	
	if ($con->connect_errno) {
	  	echo "Lỗi kết nối CSDL";
	  	exit();
	}else{
		if($tendangnhap != null && $matkhau != null){
			//Xu ly ma doc
			$tendangnhap = htmlspecialchars($tendangnhap);
			$matkhau = htmlspecialchars($matkhau);

			$tendangnhap = $con->real_escape_string($tendangnhap);
			$matkhau = $con->real_escape_string($matkhau);

			$sql = "SELECT mat_khau FROM nguoidung WHERE ten_dang_nhap=?";
			$stmt = $con->prepare($sql);
			$stmt->bind_param("s", $tendangnhap);
			$stmt->execute();
			$result = $stmt->get_result();
			$password = $result->fetch_assoc()['mat_khau'];

			if(strcmp($password, md5($matkhau)) == 0){
				session_start();
				$_SESSION['tendangnhap'] = $tendangnhap;
				header("Location: index.php");
				
				$con->close();
			}else{
				echo "<br><p style='text-align: center; color: red'>Tên đăng nhập hoặc mật khẩu không đúng</p>";
			}
		}else{
			echo "<br><p style='text-align: center; color: red'>Phải nhập đầy đủ thông tin</p>";
		}
	}
	
}
?>
</body>
</html>