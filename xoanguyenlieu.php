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
		require 'ketnoicsdl.php';
		if(isset($_GET['manguyenlieu'])){
			$manguyenlieu = $_GET['manguyenlieu'];
			$sql_xoanguyenlieu = "DELETE FROM nguyenlieu WHERE ma_nguyen_lieu = ?";
			$stmt = $con->prepare($sql_xoanguyenlieu);
			$stmt->bind_param("s", $manguyenlieu);
			$stmt->execute();
			$con->close();
			header("Location: danhsachnguyenlieu.php");
		}else{
			echo "<p style='text-align: center; color: red'>Nguyên liệu không tồn tại!</p>";
		}
	}else{
		header("Location: dangnhap.html");
	}
?>

</body>
</html>