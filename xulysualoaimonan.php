<?php
	session_start();
	if(isset($_SESSION['tendangnhap'])){
		$tendangnhap = $_SESSION['tendangnhap'];
		require 'ketnoicsdl.php';
		$sql_layvaitro = "SELECT ma_vai_tro FROM nguoidung WHERE ten_dang_nhap = '$tendangnhap' ";
		$result_layvaitro = $con->query($sql_layvaitro);
		$mavaitro =  $result_layvaitro->fetch_assoc()['ma_vai_tro'];
		if($mavaitro == 'admin'){
			if(isset($_POST['sualoaimonan'])){
				$maloaimonan = $_POST['maloaimonan'];
				$tenloaimonan = $_POST['tenloaimonan'];
				
				$sql_sualoaimonan = "UPDATE loaimonan SET ten_loai_mon_an = ? WHERE ma_loai_mon_an = ?";
				$stmt = $con->prepare($sql_sualoaimonan);
				$stmt->bind_param("si", $tenloaimonan, $maloaimonan);
				$stmt->execute();
				$con->close();
				header("Location: danhsachloaimonan.php");
			}else{
				echo "<p style='text-align: center; color: red'>Sản phẩm không tồn tại!</p>";
			}	
		}else{
			echo "<p style='text-align: center; color: red'>Bạn không có quyền thực hiện chức năng này!</p>";
		}
	}else{
		header("Location: dangnhap.html");
	}
?>