<?php
require 'ketnoicsdl.php';
$matkhau = md5('admin');
$sql = "INSERT INTO nguoidung(ten_dang_nhap,mat_khau,ten_nguoi_dung,ma_vai_tro) VALUES ('admin', '$matkhau', 'Administrator', 'admin')";
echo $sql;
$con->query($sql);