<?php
	session_start();
	if(isset($_SESSION['tendangnhap'])){
		require 'ketnoicsdl.php';
		if(isset($_POST['suanguyenlieu'])){
			$manguyenlieu = $_POST['manguyenlieu'];
			$tennguyenlieu = $_POST['tennguyenlieu'];
			
			$sql_suanguyenlieu = "UPDATE nguyenlieu SET ten_nguyen_lieu = ? WHERE ma_nguyen_lieu = ?";
			$stmt = $con->prepare($sql_suanguyenlieu);
			$stmt->bind_param("si", $tennguyenlieu, $manguyenlieu);
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