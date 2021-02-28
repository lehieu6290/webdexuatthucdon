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
		
		if(isset($_POST['themmonan'])){
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
				$sql_themmonan = "INSERT INTO monan(ten_mon_an, ma_loai_mon_an, la_mon_chay, luong_calo, ten_dang_nhap) VALUES (?,?,?,?,?)";
				$stmt = $con->prepare($sql_themmonan);
				$stmt->bind_param("siiis", $tenmonan, $maloaimonan, $lamonchay, $luongcalo, $tendangnhap);
				$stmt->execute();

				//Lấy mã của món ăn vừa thêm
				$sql_laymonvuathem = "SELECT ma_mon_an FROM monan WHERE ma_mon_an = LAST_INSERT_ID()";
				$result_laymonvuathem = $con->query($sql_laymonvuathem);
				$mamonan = $result_laymonvuathem->fetch_assoc()['ma_mon_an'];

				$tennguyenlieu = trim($tennguyenlieu);
				$cacnguyenlieu = explode(",", $tennguyenlieu);
				foreach ($cacnguyenlieu as $value) {
					$sql_laymanguyenlieu = "SELECT ma_nguyen_lieu FROM nguyenlieu WHERE ten_nguyen_lieu = '$value'";
					$result_laymanguyenlieu = $con->query($sql_laymanguyenlieu);
					$manguyenlieu = $result_laymanguyenlieu->fetch_assoc()['ma_nguyen_lieu'];

					$sql_themmonannguyenlieu = "INSERT INTO monannguyenlieu VALUES($mamonan, $manguyenlieu)";
					$con->query($sql_themmonannguyenlieu);
				}
				

				header("Location: danhsachmonan.php");
				$con->close();
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