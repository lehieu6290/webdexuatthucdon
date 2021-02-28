<!DOCTYPE html>
<html>
<head>
	<title>Lỗi</title>
	<meta charset="utf-8">
</head>
<body>
<?php
	session_start();
	if(isset($_SESSION['tendangnhap'])){
		$tendangnhap = $_SESSION['tendangnhap'];
		require 'ketnoicsdl.php';
		
		if(isset($_POST['themnguyenlieu'])){
			$tennguyenlieu = $_POST['tennguyenlieu'];
			$tennguyenlieu = htmlspecialchars($tennguyenlieu);
			$tennguyenlieu = $con->real_escape_string($tennguyenlieu);

			if($tennguyenlieu != null ){
				$sql_themnguyenlieu = "INSERT INTO nguyenlieu(ten_nguyen_lieu, ten_dang_nhap) VALUES (?, ?)";
				$stmt = $con->prepare($sql_themnguyenlieu);
				$stmt->bind_param("ss", $tennguyenlieu, $tendangnhap);
				$stmt->execute();
				$con->close();
				header("Location: danhsachnguyenlieu.php");
			}else{
				echo "<p style='text-align: center; color: red'>Phải nhập đầy đủ thông tin</p>";
			}
		}else{
			echo "<p style='text-align: center; color: red'>Không thể thực hiện hành động này!</p>";
		}
	}else{
		header("Location: dangnhap.html");
	}
?>

</body>
</html>