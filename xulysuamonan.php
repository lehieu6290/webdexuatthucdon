<?php
	session_start();
	if(isset($_SESSION['tendangnhap'])){
		require 'ketnoicsdl.php';
		if(isset($_POST['suamonan'])){
			if(isset($_POST['mamonan'])){
				$tendangnhap = $_SESSION['tendangnhap'];
				$mamonan = $_POST['mamonan'];
				$tenmonan = $_POST['tenmonan'];
				$maloaimonan = $_POST['maloaimonan'];
				$lamonchay = $_POST['lamonchay'];
				$luongcalo = $_POST['luongcalo'];
				$tennguyenlieu = $_POST['tennguyenlieu'];

				$tenmonan = htmlspecialchars($tenmonan);
				$maloaimonan = htmlspecialchars($maloaimonan);
				$lamonchay = htmlspecialchars($lamonchay);
				$luongcalo = htmlspecialchars($luongcalo);
				$tennguyenlieu = htmlspecialchars($tennguyenlieu);

				$tenmonan = $con->real_escape_string($tenmonan);
				$maloaimonan = $con->real_escape_string($maloaimonan);
				$lamonchay = $con->real_escape_string($lamonchay);
				$luongcalo = $con->real_escape_string($luongcalo);
				$tennguyenlieu = $con->real_escape_string($tennguyenlieu);

				if($tennguyenlieu != null && $maloaimonan != null && $lamonchay != null && $luongcalo != null && $tennguyenlieu != null){
					$sql_suamonan = "UPDATE monan SET ten_mon_an=?, ma_loai_mon_an=?, la_mon_chay=?, luong_calo=?, ten_dang_nhap=? WHERE ma_mon_an=?";
					echo $sql_suamonan;
					$stmt = $con->prepare($sql_suamonan);
					$stmt->bind_param("siiisi", $tenmonan, $maloaimonan, $lamonchay, $luongcalo, $tendangnhap, $mamonan);
					$stmt->execute();

					//Xóa các nguyên liệu cũ
					$sql_xoanguyenlieu = "DELETE FROM monannguyenlieu WHERE ma_mon_an='$mamonan'";
					$con->query($sql_xoanguyenlieu);

					$tennguyenlieu = trim($tennguyenlieu);
					$cacnguyenlieu = explode(",", $tennguyenlieu);
					foreach ($cacnguyenlieu as $value) {
						$sql_laymanguyenlieu = "SELECT ma_nguyen_lieu FROM nguyenlieu WHERE ten_nguyen_lieu = '$value'";
						$result_laymanguyenlieu = $con->query($sql_laymanguyenlieu);
						$manguyenlieu = $result_laymanguyenlieu->fetch_assoc()['ma_nguyen_lieu'];

						$sql_themmonannguyenlieu = "INSERT INTO monannguyenlieu VALUES($mamonan, $manguyenlieu)";
						$con->query($sql_themmonannguyenlieu);
					}
				}	
			$con->close();
			header("Location: danhsachmonan.php");
			}else{
				echo "<p style='text-align: center; color: red'>Món ăn không tồn tại!</p>";
			}
		}else{
			echo "<p style='text-align: center; color: red'>Không thể thực hiện hành động này!</p>";
		}
	}else{
		header("Location: dangnhap.html");
	}
?>