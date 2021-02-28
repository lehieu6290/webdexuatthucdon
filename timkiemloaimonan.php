<?php
	if(isset($_GET['tenloaimonan'])){
		require 'ketnoicsdl.php';
		$tenloaimonan = $_GET['tenloaimonan'];
		$sql_search = "SELECT ma_loai_mon_an, ten_loai_mon_an FROM loaimonan WHERE ten_loai_mon_an LIKE '%$tenloaimonan%'";
		$result_dsloaimonan = $con->query($sql_search);
		if($result_dsloaimonan->num_rows > 0){
		
		echo "<tr>
				<th>STT</th>
				<th>Tên loại món ăn</th>
				<th colspan='2'>Hành động</th>
			</tr>";
			
			$stt = 1; 
			while($row = $result_dsloaimonan->fetch_assoc()){ 
				echo "<tr>" .
					"<td>".  $stt++ ."</td>".
					"<td>". $row['ten_loai_mon_an'] ."</td>".
					"<td><a href='sualoaimonan.php?maloaimonan=". $row['ma_loai_mon_an']."'><img class='icon' src='hinhanh/hethong/edit_icon.png' title='Sửa'></a></td>".
					"<td><a href='xoaloaimonan.php?maloaimonan=". $row['ma_loai_mon_an'] ."'><img class='icon' src='hinhanh/hethong/delete_icon.png' title='Xóa'></a></td>".
				"</tr>";
			}
		}else{
			echo "Không tìm thấy loại món ăn";
		}
	}
?>