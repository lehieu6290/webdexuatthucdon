<?php 
	session_start();
	if(isset($_POST['dexuat'])){
		require 'ketnoicsdl.php';
		
		//Lọc ra các món mặn/chay
		$sql_laydsmonan = '';
		$lamonchay = $_POST['loaibuaan'];
		if(isset($_SESSION['tendangnhap'])){
			$tendangnhap = $_SESSION['tendangnhap'];
			$sql_laydsmonan = "SELECT * FROM monan WHERE la_mon_chay = '$lamonchay' AND (ten_dang_nhap = 'admin' OR ten_dang_nhap = '$tendangnhap')";
		}else{
			$sql_laydsmonan = "SELECT * FROM monan WHERE la_mon_chay = '$lamonchay' AND ten_dang_nhap = 'admin'";
		}

		if(!empty($_POST['tennguyenlieu'])){
			//Câu lệnh sql lọc các món không ăn được
			$tennguyenlieu = $_POST['tennguyenlieu'];
			$tennguyenlieu = trim($tennguyenlieu, ",");
			$cacnguyenlieu = explode(",", $tennguyenlieu);
			$where_nguyenlieu = 'AND ma_mon_an NOT IN (SELECT ma_mon_an FROM monannguyenlieu WHERE ';

			foreach($cacnguyenlieu as $key => $value) {
				$sql_laymanguyenlieu = "SELECT ma_nguyen_lieu FROM nguyenlieu WHERE ten_nguyen_lieu = '$value'";
				$result_laymanguyenlieu = $con->query($sql_laymanguyenlieu);
				$manguyenlieu = $result_laymanguyenlieu->fetch_assoc()['ma_nguyen_lieu'];

				$where_nguyenlieu .= "ma_nguyen_lieu = " .$manguyenlieu;
				if($key == count($cacnguyenlieu) - 1)
					continue;
				$where_nguyenlieu .= " OR ";
			}
			$where_nguyenlieu .= ")";

			$sql_laydsmonan .= $where_nguyenlieu;
		}

		$result_laydsmonan = $con->query($sql_laydsmonan);
		$dsmonan = [];
		while ($row = $result_laydsmonan->fetch_assoc()) {
			array_push($dsmonan, $row);
		}

		//Phân chia các món có thể ăn thành 3 loại mặn, canh và xào
	    $monman = [];
	    $moncanh = [];
	    $monxao = [];
	    foreach ($dsmonan as $monan) {
	    	if($monan['ma_loai_mon_an'] == 1){
	    		array_push($monman, $monan);
	    	}elseif ($monan['ma_loai_mon_an'] == 2) {
	    		array_push($moncanh, $monan);
	    	}else{
	    		array_push($monxao, $monan);
	    	}
	    }

	    //Nếu có lượng calo tối đa thì cộng lượng calo của 3 loại
		//Nếu không có lượng calo thì lấy tập hợp tất cả các món từ 3 loại
		$ketqua = [];
		if(!empty($_POST['luongcalo'])){
			foreach ($monman as $m) {
				foreach ($moncanh as $c) {
					foreach ($monxao as $x) {
						if($m['luong_calo'] + $c['luong_calo'] + $x['luong_calo'] <= $_POST['luongcalo']){
							array_push($ketqua, array($m['ten_mon_an'], $c['ten_mon_an'], $x['ten_mon_an']));
						}
					}
				}
			}
		}else{
			foreach ($monman as $m) {
				foreach ($moncanh as $c) {
					foreach ($monxao as $x) {
						array_push($ketqua, array($m['ten_mon_an'], $c['ten_mon_an'], $x['ten_mon_an']));
					}
				}
			}
		}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Kết quả đề xuất</title>
	<meta charset="utf-8">
	<link rel="icon" href="hinhanh/hethong/logo.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<div class="center">
			<div class="flex-container">
				<div class="flex-container">
					<a href="index.php"><img src="hinhanh/hethong/logo.png" class="logo"></a>
					<h1 class="title">Hệ thống đề xuất thực đơn</h1>
				</div>
				<?php 
				if(isset($_SESSION['tendangnhap'])){
					require 'ketnoicsdl.php';
					$tendangnhap = $_SESSION['tendangnhap'];
					$sql_laytennguoidung = "SELECT ten_nguoi_dung FROM nguoidung WHERE ten_dang_nhap = '$tendangnhap'";
					$result_laytennguoidung = $con->query($sql_laytennguoidung);
					$tennguoidung = $result_laytennguoidung->fetch_assoc()['ten_nguoi_dung'];
				?>
				<div>
					<p class="user-name"><?php echo $tennguoidung ?> &dtrif;</p>
					<div class="control-container">
						<a href="quanlytaikhoan.php">Quản lý tài khoản</a>
						<a href="dangxuat.php">Đăng xuất</a>
					</div>
				</div>
				<?php }else{ ?>
					<div>
						<a href="dangnhap.html" class="link">Đăng nhập</a>
						<span> | </span>
						<a href="dangky.html" class="link">Đăng ký</a>
					</div>
				<?php } ?>
			</div>
		</div>
	</header>

	<div class="center">
		<?php if(!empty($ketqua)){ ?>
		<h2 style="text-align: center; margin: 10px;">Bạn có thể lựa chọn một trong các đề xuất thực đơn dưới đây</h2>
		<?php } ?>
		<div class="flex-center">
			<div>
				<?php if(!empty($ketqua)){ ?>

				<table class="table">
					<tr>
						<th>Đề xuất</th>
						<th>Món mặn</th>
						<th>Món canh</th>
						<th>Món xào</th>
					</tr>
					<?php 
						$i = 1;
						foreach ($ketqua as $value) {
					?>
						<tr>
							<td><?php echo $i++ ?></td>
							<td><?php echo $value[0] ?></td>
							<td><?php echo $value[1] ?></td>
							<td><?php echo $value[2] ?></td>
						</tr>
					<?php } ?>
				</table>
				<?php }else{ ?>
					<h2 style="padding: 10px;">Rất tiếc. Không có kết quả đề xuất phù hợp!</h2>
					<div style="text-align: center; padding: 10px;">
						<a href="index.php" class="submit">Thực hiện lại</a>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<footer>
		<div class="center">
			<div class="flex-container">
				<div>
					<p>Giảng viên hướng dẫn</p>
					<p>TS Lâm Nhựt Khang</p>
				</div>
				<div>
					<p>Sinh viên thực hiện</p>
					<p>Lê Trung Hiếu</p>
				</div>
			</div>
		</div>
	</footer>
</body>
</html>

<?php } ?>