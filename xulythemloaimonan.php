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
			if(isset($_POST['themloaimonan'])){
				$tenloaimonan = $_POST['tenloaimonan'];
				$tenloaimonan = htmlspecialchars($tenloaimonan);
				$tenloaimonan = $con->real_escape_string($tenloaimonan);

				if($tenloaimonan != null ){
					$sql_themloaimonan = "INSERT INTO loaimonan(ten_loai_mon_an) VALUES (?)";
					$stmt = $con->prepare($sql_themloaimonan);
					$stmt->bind_param("s", $tenloaimonan);
					$stmt->execute();
					$con->close();
					header("Location: danhsachloaimonan.php");
				}else{
					echo "<p style='text-align: center; color: red'>Phải nhập đầy đủ thông tin</p>";
				}
			}else{
				echo "<p style='text-align: center; color: red'>Không thể thực hiện hành động này!</p>";
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