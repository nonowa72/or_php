<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
	<link type="text/css" rel="stylesheet" href="css/styleA.css" />
	<script type="text/JavaScript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/JavaScript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
<title>Calendar | Schedule</title>
</head>
<body>


	<div id="wrapper">
		<div id="logo"></div>

		<div id="content">


			<div id="box">

			<?php
				session_start();
				//carendar.phpでセッションが作成されていた場合
				if(!isset($_SESSION['year'])){
					$_SESSION['year'] = $_REQUEST['y'];
				}

				//backボタンが押された場合
				if(isset($_POST['Back'])){
					session_destroy();
				}

				//submitボタンか日付変更ボタンが押された場合実行
				if(isset($_POST['button1'])||isset($_POST['imgButton'])){
					//hiddenから月の値取得
					$m = $_POST['Month'];
					//hiddenから日付の値取得
					$d = $_POST['Day'];
				//通常
				}else{
					$m = $_REQUEST['m'];
					$d = $_REQUEST['d'];
				}


				// 日付変更ボタン処理
				if($d <= 0){
					//日付が１日以下であり、月が１月なら
					if($m==1){
						$m = 12;
					}else{
						$m = $m-1;
					}
					$d = date("t",mktime(0,0,0,$m,1,2013));
				}else if($d > date("t",mktime(0,0,0,$m,1,2013))){
					//12月で日付が31以上なら
					if($m == 12&&$d==32){
						$m=1;
					}else{
						$m = $m+1;
					}
					$d = 1;

				}

				//ここまで


				echo "<div class=\"leftButton\"><a href=\"schedule.php?m=".$m."&d=".($d-1)."&queryCategory=default\"></a></div>";

				echo "<div class=\"rightButton\"><a href=\"schedule.php?m=".$m."&d=".($d+1)."&queryCategory=default\"></a></div>";
			?>
			<div id="centerBox">

				<div id="infoBox">
                    <div id="scheduleMonth">

						<!-- 月表示　class名のmonthの後の番号を変えれば月が表示されるようになる -->
			<?php
					for($i=1;$i<13;$i++){
						//取得した月が同じならば実行
						if($m == $i){
				                    echo	"<div id='month' class='month$i'></div>";
				                    $month = $i;
						}
					}

						// 日付表示

		            for($i=1;$i<32;$i++){
						//取得した日が同じならば実行
						if($d == $i){
							if($d<10){
					            echo	"<div id='date'>.0$i</div>";
							    $Date = "0".$i;
							}else{
							    echo	"<div id='date'>.$i</div>";
							    $Date = $i;
							}
						}
					}
			?>

					</div>

				</div>
<!-- 追加処理　-->
				<div id="scheduleBox">
					<div class="title">New Task.</div>
					<form action="regist.php" method="post">
						<?php
							//クエリ文字を保持
							echo "<input type='hidden' name='QueryM' value='$m'>";
							echo "<input type='hidden' name='QueryD' value='$d'>";

							//入力フォーム部分
							//inputForm.php を読み込んでここにはりつける
							require_once("inputForm.php");
						?>
					</form>
<!-- 追加処理ここまで　-->


					<div id="todaySchedule">
						<div class="title">Today Schedule.</div>
						<ul id="categoryList">
						 <li class="all"><a href="schedule.php?queryCategory=default&m=<?php echo $m;?>&d=<?php echo $d;?>">ALL</a></li>
						 <li class="worktask"><a href="schedule.php?queryCategory=worktask&m=<?php echo $m;?>&d=<?php echo $d;?>">worktask</a></li>
						 <li class="meeting"><a href="schedule.php?queryCategory=meeting&m=<?php echo $m;?>&d=<?php echo $d;?>">meeting</a></li>
						 <li class="personal"><a href="schedule.php?queryCategory=personal&m=<?php echo $m;?>&d=<?php echo $d;?>">personal</a></li>
						</ul>
					</div>


<!-- 削除・編集処理 -->
<?php
			//SQL文のLIMIT句に使う変数の初期値設定
			$limit = 0;
		    //ページング部分からクエリ文字が送られて来た場合
		    if(isset($_REQUEST['index'])){
		    	//何件目から表示するかを$limitに格納
		    	$limit = $_REQUEST['index'];
		    }
		    //現在の年月日を変数に格納(例：2013-7-07)
			$today ="'".$_SESSION['year']."-".sprintf("%02d",$month)."-".$Date."'";



			//削除アイコンが押された場合の削除処理
			if(isset($_REQUEST['id'])) {
				$id = $_REQUEST['id'];

				require_once("connect.inc.php");
				//connect.inc.phpにあるconnectDBという関数を実行して、接続ID$connectionを取得
				$connection = connectDB();

				mysqli_query($connection,"DELETE FROM schedule WHERE id=$id");

				mysqli_close($connection);
			}

			//submitボタンが押された場合の編集処理

			if(isset($_POST['button1'])){

					require_once("connect.inc.php");
					//connect.inc.phpにあるconnectDBという関数を実行して、接続ID$connectionを取得
					$connection = connectDB();
					$nameCount = 0;
					//何件目からのデータを取り出すかの値をhiddenから取得
					$HiddenLimit = $_POST['hiddenLimit'];


					if(!isset($_REQUEST['queryCategory'])||$_REQUEST['queryCategory']=="default"){
						$sql = mysqli_query($connection,"SELECT * FROM schedule
											WHERE addDate=$today LIMIT $HiddenLimit,5" );
					//カテゴリがALL以外が選択されていた場合
					}else{
						$sql = mysqli_query($connection,"SELECT * FROM schedule
											WHERE addDate=$today AND category='".$_REQUEST['queryCategory']."' LIMIT $HiddenLimit,5");
					}

					while($select = mysqli_fetch_array($sql)){
						//日付に何も入力されていなかった場合
						if($_POST['time'.$nameCount]==""){
							header("location:schedule.php?queryCategory=default&m=$m&d=$d");
							return;
						}

						//入力値の内容と時間のどちらかがDB内のデータと違っていた場合更新
						if($select['contents']!=$_POST['schedule'.$nameCount]||
							$select['startTime']."-".$select['endTime']!=$_POST['time'.$nameCount]){
								$contents = mysql_real_escape_string($_POST['schedule'.$nameCount]);
								$time = explode("-", mysql_real_escape_string($_POST['time'.$nameCount]));

								//正しい時間入力がされていた場合に実行(例：00:00-00:00)
								if(isset($time[0])&&isset($time[1])){
										mysqli_query($connection,"UPDATE schedule
																  SET contents='$contents',startTime='$time[0]',endTime='$time[1]'
																  WHERE id=".$select['id']);
								}
						}
						$nameCount++;
					}
					mysqli_close($connection);



			}


?>
<!-- 削除・編集ここまで -->





<!--	データベースから読み込んだデータを１行ずつ<li>?</li>に囲んで表示。 -->
				<?php
					//カテゴリ名がクエリ文字から送られてきた場合
					if(isset($_REQUEST['queryCategory'])){
						echo "<form action='schedule.php?queryCategory=".$_REQUEST['queryCategory']."' method='post'>";
					}
					echo "<ul id='listBox'>";

					//テキストボックスのname値に使用
					$count =0;

					//submitボタンが押された場合
					if(isset($_POST['button1'])){
						//hiddenから送られてきたカテゴリ名を格納
						$category = $_POST['category'];
					}else{
						//クエリ文字から送られてきたカテゴリ名を格納
						$category = $_REQUEST['queryCategory'];
					}

					require_once("connect.inc.php");
					//connect.inc.phpにあるconnectDBという関数を実行して、接続ID$connectionを取得
					$connection = connectDB();
					global $category;

					if($category=="default"){
						$result = mysqli_query($connection,"SELECT * FROM schedule WHERE addDate=$today LIMIT $limit,5");
					//カテゴリがALL以外だった場合
					}else{
						$result = mysqli_query($connection,"SELECT * FROM schedule WHERE addDate=$today AND category='".$_REQUEST['queryCategory']."' LIMIT $limit,5");
					}

					while($data = mysqli_fetch_array($result)){
									echo "<li class=".$data['category'].">";
										echo 	"<input type='text' value='".$data['startTime']."-".$data['endTime']."' name='time$count' class='time'  maxlength='11'/>";

										echo	"<input type='text' value='".$data['contents']."' name='schedule$count'  maxlength='50' 	class='todo' />";

										echo	"<a href='schedule.php?id=".$data['id']."&m=$m&d=$d&queryCategory=default' style='position:absolute; bottom:20px;'><img src='img/dustBox.png' alt='削除' /></a>";

									echo "</li>";
									$count ++;
								}

				//ページング処理

					if($category=="default"){
						$sqlc = mysqli_query($connection,"SELECT COUNT(*) FROM schedule WHERE addDate=$today");
					}else{
						$sqlc = mysqli_query($connection,"SELECT COUNT(*) FROM schedule
														  WHERE addDate=$today AND category='".$_REQUEST['queryCategory']."'");
					}

						$allcount = mysqli_fetch_array($sqlc);

					//表示するページ数を格納
					$paging = ceil($allcount[0]/5);
							$NewPaging = null;
							$allcount = 0;

							//ページ数の分だけリンクを表示
							if($paging>=2){
								for($i=1;$i<=$paging;$i++){
									$index = $allcount*5;
									$NewPaging .= "<a href='schedule.php?index=$index&m=$m&d=$d&queryCategory=$category'>[$i]</a>　　　";
									$allcount++;
								}
							}
					echo "<li style='text-align:center;'>$NewPaging</li>";

					mysqli_close($connection);
?>
					</ul>

<!-- リストここまで -->

					<input type="submit" name="button1" value="submit" id="submitButton" />
					<?php
						//月の値
						echo "<input type='hidden' name='Month' value='$m'>";
						//日の値
						echo "<input type='hidden' name='Day' value='$d'>";
						//カテゴリごとに表示させる内容を判定するための値
						echo "<input type='hidden' name='category' value='default'>";
						//ページングによって何件目から表示するかを判定するための値
						echo "<input type='hidden' name='hiddenLimit' value='$limit'>";
					?>
					<input type="button" name="Back" onclick="location.href='calender.php?m=<?php echo $m; ?>&nowMonth=<?php echo $m-1; ?>'" value="back" id="backButton" />
					</form>

				</div>



			</div>




			</div>
		</div>
	</div>
</body>
</html>
