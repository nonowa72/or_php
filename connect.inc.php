<?php

function connectDB(){

	//mysql�ɐڑ�
	$connection = mysqli_connect("mysql1.php.xdomain.ne.jp","whitetail_root","hibiki83");

	//�����R�[�h�̐ݒ�
	mysqli_set_charset($connection,"utf8");

	//�f�[�^�x�[�X�̑I��
	$db = mysqli_select_db($connection,"whitetail_calender");

	//�ڑ��p��ID
	return $connection;
}
?>