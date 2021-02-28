<?php
	if(isset($_GET['tennguyenlieu'])){
		require 'ketnoicsdl.php';
		$tennguyenlieu = $_GET['tennguyenlieu'];
		$sql_search = "SELECT ma_nguyen_lieu, ten_nguyen_lieu FROM nguyenlieu WHERE ten_nguyen_lieu LIKE '%$tennguyenlieu%'";
		$result_dsnguyenlieu = $con->query($sql_search);
		if($result_dsnguyenlieu->num_rows > 0){
		
		echo "<tr>
				<th>STT</th>
				<th>Tên nguyên liệu</th>
				<th colspan='2'>Hành động</th>
			</tr>";
			
			$stt = 1; 
			while($row = $result_dsnguyenlieu->fetch_assoc()){ 
				echo "<tr>" .
					"<td>".  $stt++ ."</td>".
					"<td>". $row['ten_nguyen_lieu'] ."</td>".
					"<td><a href='suanguyenlieu.php?manguyenlieu=". $row['ma_nguyen_lieu']."'><img class='icon' src='hinhanh/hethong/edit_icon.png' title='Sửa'></a></td>".
					"<td><a href='xoanguyenlieu.php?manguyenlieu=". $row['ma_nguyen_lieu'] ."'><img class='icon' src='hinhanh/hethong/delete_icon.png' title='Xóa'></a></td>".
				"</tr>";
			}
		}else{
			echo "Không tìm thấy nguyên liệu";
		}
		$con->close();
	}

	if(isset($_GET['tnl'])){
		require 'ketnoicsdl.php';
		$tennguyenlieu = $_GET['tnl'];
		$sql_search = "SELECT ma_nguyen_lieu, ten_nguyen_lieu FROM nguyenlieu WHERE ten_nguyen_lieu LIKE '%$tennguyenlieu%'";
		$result_dsnguyenlieu = $con->query($sql_search);
		if($result_dsnguyenlieu->num_rows > 0){
			while($row = $result_dsnguyenlieu->fetch_assoc()){ 
				echo '<p onclick="themvaotennguyenlieu(' . "'"  .$row['ten_nguyen_lieu']. "'" . ')">' .$row['ten_nguyen_lieu']. "</p>";
			}
		}else{
			echo "<span style='display: block; padding: 3px;'>Nguyên liệu không có trong hệ thống <span id='themnguyenlieu-btn' onclick='themnguyenlieu()'>Thêm nguyên liệu</span></span>";
		}
		$con->close();
	}

	if(isset($_GET['tennl'])){
		require 'ketnoicsdl.php';
		$tennguyenlieu = $_GET['tennl'];
		$sql_search = "SELECT ma_nguyen_lieu, ten_nguyen_lieu FROM nguyenlieu WHERE ten_nguyen_lieu LIKE '%$tennguyenlieu%'";
		$result_dsnguyenlieu = $con->query($sql_search);
		if($result_dsnguyenlieu->num_rows > 0){
			while($row = $result_dsnguyenlieu->fetch_assoc()){ 
				echo '<p onclick="themvaotennguyenlieu(' . "'"  .$row['ten_nguyen_lieu']. "'" . ')">' .$row['ten_nguyen_lieu']. "</p>";
			}
		}else{
			echo "<span style='display: block; padding: 3px;'>Không món ăn nào làm từ nguyên liệu trên</span>";
		}
		$con->close();
	}
?>