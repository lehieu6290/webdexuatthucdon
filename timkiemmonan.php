<?php
	if(isset($_GET['tenmonan'])){
		require 'ketnoicsdl.php';
		$tenmonan = $_GET['tenmonan'];
		$sql_search = "SELECT monan.ma_mon_an, monan.ten_mon_an, loaimonan.ten_loai_mon_an, monan.la_mon_chay, monan.luong_calo, GROUP_CONCAT(nguyenlieu.ten_nguyen_lieu) AS ten_nguyen_lieu
						FROM monannguyenlieu JOIN nguyenlieu JOIN monan JOIN loaimonan
						ON monannguyenlieu.ma_nguyen_lieu = nguyenlieu.ma_nguyen_lieu AND monannguyenlieu.ma_mon_an = monan.ma_mon_an AND monan.ma_loai_mon_an = loaimonan.ma_loai_mon_an
						WHERE monan.ten_mon_an LIKE '%$tenmonan%'
						GROUP BY monan.ma_mon_an";
		$result_dsmonan = $con->query($sql_search);
		if($result_dsmonan->num_rows > 0){
		
		echo "<tr>
			<th>STT</th>
			<th>Tên món ăn</th>
			<th>Loại món ăn</th>
			<th>Là món chay</td>
			<th>Lượng calo</th>
			<th>Nguyên liệu</th>
			<th colspan='2'>Hành động</th>
		</tr>";
			
			$stt = 1; 
			while($row = $result_dsmonan->fetch_assoc()){ 
				echo "<tr>" .
					"<td>".  $stt++ ."</td>".
					"<td>". $row['ten_mon_an'] ."</td>".
					"<td>". $row['ten_loai_mon_an'] ."</td>".
					"<td>" .($row['la_mon_chay'] == 0 ? 'Không': 'Có')."</td>".
					"<td>" .$row['luong_calo']."</td>".
					"<td>" .$row['ten_nguyen_lieu']."</td>".
					"<td><a href='suamonan.php?mamonan=" .$row['ma_mon_an']."'><img class='icon' src='hinhanh/hethong/edit_icon.png' title='Sửa'></a></td>".
					"<td><a href='xoamonan.php?mamonan=" .$row['ma_mon_an']."'><img class='icon' src='hinhanh/hethong/delete_icon.png' title='Xóa'></a></td>".
				"</tr>";
			}
		}else{
			echo "Không tìm thấy nguyên liệu";
		}
		$con->close();
	}
?>