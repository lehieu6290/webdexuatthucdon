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
		$sql_layvaitro = "SELECT ma_vai_tro FROM nguoidung WHERE ten_dang_nhap = '$tendangnhap' ";
		$result_layvaitro = $con->query($sql_layvaitro);
		$mavaitro =  $result_layvaitro->fetch_assoc()['ma_vai_tro'];
		if($mavaitro == 'admin'){
			if(isset($_GET['maloaimonan'])){
				$maloaimonan = $_GET['maloaimonan'];
				$sql_xoaloaimonan = "DELETE FROM loaimonan WHERE ma_loai_mon_an = ?";
				$stmt = $con->prepare($sql_xoaloaimonan);
				$stmt->bind_param("s", $maloaimonan);
				$stmt->execute();
				$con->close();
				header("Location: danhsachloaimonan.php");
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

</body>
</html>