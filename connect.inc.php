<?php

function connectDB(){

	//mysqlに接続
	$connection = mysqli_connect("mysql1.php.xdomain.ne.jp","whitetail_root","hibiki83");

	//文字コードの設定
	mysqli_set_charset($connection,"utf8");

	//データベースの選択
	$db = mysqli_select_db($connection,"whitetail_calender");

	//接続用のID
	return $connection;
}
?>