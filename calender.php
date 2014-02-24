<html>
<head>
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
	<link rel="stylesheet" href="css/styleA.css" />
	<script type="text/JavaScript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/JavaScript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
<title>Calendar</title>
</head>
<body>

	<div id="wrapper">

		<div id="logo"></div>

		<div id="content">

			<div id="option1"></div>

			<div id="box">


			<!--月取得 -->

			<?php
			session_start();
				if(isset($_REQUEST['m'])){
					$nowMonth = $_REQUEST['nowMonth'];
					$month = $_REQUEST['m'];
				}else{
					session_destroy();
					$nowMonth = "";
					$month = date("n");
				}


				//12月の時に右ボタンが押された場合
				if($nowMonth==12&&$month==1){
					if(isset($_SESSION['year'])){
						$year = $_SESSION['year']+1;
					}else{
						$year = date("Y")+1;
					}
					//+1した値をセッションに格納
					$_SESSION['year'] = $year;
				//1月の時に左ボタンが押された場合
				}else if($nowMonth==1&&$month==12){
					if(isset($_SESSION['year'])){
						$year = $_SESSION['year']-1;
					}else{
						$year = date("Y")-1;
					}
					$_SESSION['year'] = $year;
				}

				if(isset($_SESSION['year'])){
					$year = $_SESSION['year'];
				}else{
					$year = date("Y");
				}

			$rightY = date("n",mktime( 0, 0, 0, $month+1 ,1, $year));
			$leftY = date("n",mktime( 0, 0, 0, $month-1 ,1, $year));
			?>
			<!-- ここまで -->


			<!-- 左ボタン -->
									<!-- ボタンを押すと、URLに前の月と現在の月の値を付与する -->
			<div class="leftButton"><a href="calender.php?m=<?php echo $leftY; ?>&nowMonth=<?php echo $month; ?>"></a></div>


			<div id="centerBox">

				<div id="infoBox">
			<?php

				echo "<div id='year'>".$year."</div>";
				echo "<div id='month'". "class='month$month'"."></div>";
					//<!-- 曜日の表示 -->

				$week = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
				for($i=0;$i<7;$i++){
				echo "<div class = 'youbi'>";
					echo $week[$i];
					echo "</div>";
				}
			?>
				</div>


			<!-- スケジュール数取得 -->
			<?php
			function schedule($num){
				global $year;		//グローバル変数として使用
				global $month;		//グローバル変数として使用
				$path = $year."-".sprintf("%02d",$month)."-".sprintf("%02d",$num);
				$count = 0;

				require_once("connect.inc.php");
				//connect.inc.phpにあるconnectDBという関数を実行して、接続ID$connectionを取得
				$connection = connectDB();
				$result = mysqli_query($connection,"SELECT * FROM schedule WHERE addDate='$path'");
				while($data = mysqli_fetch_array($result)){
							$count++;
				}

				mysqli_close($connection);
				return $count;
			}
			?>



			<!-- カレンダー表示 -->
			<?php
				$endDate = date("t", mktime( 0, 0, 0, $month ,1, $year));		//月末日取得
				$startDay = date("w", mktime( 0, 0, 0, $month ,1, $year));		//月初日の曜日を取得
				$endDay = date("w", mktime( 0, 0, 0, $month ,$endDate, $year));		//月末日の曜日を取得

				//カレンダーの空白部分表示
				$count = 0;
				for($i=6;$i>=0;$i--){
					if($startDay == $i){
						for($i=$startDay;$i>0;$i--){
							echo "<div class='null'>";
							echo "";
							echo "</div>";
						}
					}
				$count = $count+1;
				}


				for($i=1;$i<$endDate+1;$i++){
				$w = date("w", mktime( 0, 0, 0, $month, $i, $year));	//日数ごとに曜日を取得
					//日曜日の部分を赤色で表示
					if($w==0){
						echo "<div class='sun'>";
						echo "<div class='schedule'>".schedule($i)."</div>";
						echo "<a href='schedule.php?m=$month&d=$i&queryCategory=default&y=$year'>$i</a>";
						echo "</div>";
					//土曜日の部分を青色で表示
					}else if($w==6){
						echo "<div class='sat'>";
						echo "<div class='schedule'>".schedule($i)."</div>";
						echo "<a href='schedule.php?m=$month&d=$i&queryCategory=default&y=$year'>$i</a>";
						echo "</div>";
					//それ以外の部分は通常表示
					}else{
						echo "<div class='normal'>";
						echo "<div class='schedule'>".schedule($i)."</div>";
						echo "<a href='schedule.php?m=$month&d=$i&queryCategory=default&y=$year'>$i</a>";
						echo "</div>";
					}
				}

				//カレンダーの空白部分表示
				$count = 0;
				for($i=6;$i>=0;$i--){
					if($endDay == $i){
						for($i=$count;$i>0;$i--){
							echo "<div class='null'>";
							echo "";
							echo "</div>";
						}
					}
				$count = $count+1;
				}
			?>

			</div>



			<!-- 右ボタン -->
						　			　<!-- ボタンを押すと、URLに次の月と現在の月の値を付与する -->
			<div class="rightButton"><a href="calender.php?m=<?php echo $rightY; ?>&nowMonth=<?php echo $month; ?>"></a></div>


			</div>
		</div>
	</div>
</body>
</html>
