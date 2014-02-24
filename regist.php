<html>
<head>
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
	<link rel="stylesheet" href="css/styleA.css" />

	<script type="text/JavaScript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/JavaScript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
<title>Calendar | Schedule | regist</title>
</head>
<body>

	<div id="wrapper">


		<div id="content">
			<?php
			session_start();
			$m = $_POST['QueryM'];
			$d = $_POST['QueryD'];

			//追加時の年月日を変数に格納
			$addDate = $_SESSION['year'].sprintf("%02d",$m).sprintf("%02d",$d);

			require_once("connect.inc.php");

			//connect.inc.phpにあるconnectDBという関数を実行して、接続ID$connectionを取得
			$connection = connectDB();

			//入力値の取得
			$category = $_POST['taskCategory'];
			$SHour = $_POST['startHour'];
			$SMinutes = $_POST['startMinutes'];
			$EHour = $_POST['endHour'];
			$EMinutes = $_POST['endMinutes'];
			$task = $_POST['task'];

			mysqli_query($connection,"INSERT INTO schedule(category,contents,startTime,endTime,addDate)
									  VALUES ('$category','$task','$SHour".":"."$SMinutes','$EHour".":"."$EMinutes','$addDate')");

			//接続の切断
			mysqli_close($connection);

			?>

		</div>
		<h1>登録しました</h1><br /><br />
						<input type="button" onclick="location.href='schedule.php?m=<?php echo $m; ?>&d=<?php echo $d; ?>&queryCategory=default'" value="戻る" id="backButton2"/>
	</div>
</body>
</html>
