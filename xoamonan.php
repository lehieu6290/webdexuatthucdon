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
		if(isset($_GET['mamonan'])){
			$mamonan = $_GET['mamonan'];
			$sql_xoamonan = "DELETE FROM monan WHERE ma_mon_an = ?";
			$stmt = $con->prepare($sql_xoamonan);
			$stmt->bind_param("i", $mamonan);
			$stmt->execute();

			$sql_xoamonannguyenlieu = "DELETE FROM monannguyenlieu WHERE ma_mon_an = '$mamonan'";
			$con->query($sql_xoamonannguyenlieu);
			$con->close();
			header("Location: danhsachmonan.php");
		}else{
			echo "<p style='text-align: center; color: red'>Món ăn không tồn tại!</p>";
		}
	}else{
		header("Location: dangnhap.html");
	}
?>

</body>
</html>