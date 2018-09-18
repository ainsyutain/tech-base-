<?php
//DB接続
		$dsn = 'データベース名';
		$user = 'ユーザー名';
		$password = 'パスワード';
		$pdo = new PDO($dsn,$user,$password);


//編集コード１
		$edit = $_POST["edit"];
		$editpass = $_POST["password_edit"];
if(!empty($edit) && !empty($editpass)){		

$sql = 'select * from g order by id asc';
$results = $pdo->query($sql);

foreach($results as $row){
//パスワードが一致した場合
if($row['pass'] == $editpass){
//編集対象番号と投稿番号が同じなら↓
if($edit == $row['id']){

		$newid = $row['id'];
	 	$newname = $row['name'];
	 	$newcomment = $row['comment'];
	 	$newpass = $row['pass'];



			}
			     }
			  }

//パスワードが違う場合
if($row['pass'] != $editpass){
		echo "パスワードが違います。";
}
					}

//編集対象番号が空の場合
if(empty($edit) && !empty($editpass)){	
echo "編集対象番号またはパスワードが空欄です。";
}
//パスワードが空の場合
if(!empty($edit) && empty($editpass)){	
echo "編集対象番号またはパスワードが空欄です。";
}

?>


<! DOCTYPE html>
<html>
<body>
<head><title></title></head>
<meta http-equiv="content-type" content="text/html;chartest=UTF-8"/>
<h1>クッパのお城</h1>
 <form action = "mission_4-1.php" method = "post">
  名前<br/>
　<input type = "text" name ="name" value="<?php echo $newname ?>" placeholder="名前"><br/>
  コメント<br/>
　<input type = "text" name ="comment" value="<?php echo $newcomment ?>" placeholder="コメント"><br/>
  パスワード<br/>
　<input type = "text" name ="password_new" value="<?php echo $newpass ?>" placeholder="パスワード"><br/>
  <input type = "hidden" name ="editnum" value="<?php echo $newid ?>"><br/>
  <input type = "submit" value ="送信">
<br/>削除番号指定用<br/>
　<input type = "text" name ="delete" value="" placeholder="削除対象番号"><br/>
  <input type = "text" name ="password_dele" value="" placeholder="パスワード"><br/>
　<input type = "submit" value ="削除">
<br/>編集対象番号<br/>
　<input type = "text" name ="edit" value="" placeholder="編集対象番号"><br/>
　<input type = "text" name ="password_edit" value="" placeholder="パスワード"><br/>
　<input type = "submit" value ="編集">

</form>
</body>
</html>

<?php
header('Content-Type: text/html; charset=UTF-8');

//テーブル作成
$sql="CREATE TABLE g"
."("
."id INT AUTO_INCREMENT,"
."name char(32),"
."comment TEXT,"
."created DateTime,"
."pass TEXT,"
."PRIMARY KEY (id)"
.");";
$stmt = $pdo->query($sql);//実行

/*//DB内のテーブル一覧表示
$sql = "show tables";
$result = $pdo->query($sql);
foreach($result as $row){
echo $row[0];
echo '<br>';
}
echo '<hr>';*/

//名前コメントパスワードが空ではなかった場合
if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password_new"]) && empty($_POST["editnum"])){

//insertでデータを入れる		
		$sql = $pdo -> prepare("insert into g(name,comment,created,pass) values(:name,:comment,:created,:pass)");
		$sql->bindParam(':name',$name,PDO::PARAM_STR);
		$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
		$sql->bindParam(':pass',$pass,PDO::PARAM_STR);
		$sql->bindParam(':created',$date,PDO::PARAM_STR);
		
		$name = $_POST["name"];		//名前
		$comment = $_POST["comment"];	//コメント
		$pass = $_POST["password_new"];//パスワード
		$date = new DateTime();
		$date = $date->format('Y-m-d H:i:s');//日時
		
		$sql->execute();		//実行
		


}
//各項目空欄だったら↓
if(empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password_new"]) && empty($_POST["editnum"])){
	echo "名前が空欄です。";
}if(!empty($_POST["name"]) && empty($_POST["comment"]) && !empty($_POST["password_new"]) && empty($_POST["editnum"])){
	echo "コメントが空欄です。";
}if(!empty($_POST["name"]) && !empty($_POST["comment"]) && empty($_POST["password_new"]) && empty($_POST["editnum"])){
	echo "パスワードが空欄です。";
}if(empty($_POST["name"]) && empty($_POST["comment"]) && !empty($_POST["password_new"]) && empty($_POST["editnum"])){
	echo "名前とコメントが空欄です。";
}if(empty($_POST["name"]) && !empty($_POST["comment"]) && empty($_POST["password_new"]) && empty($_POST["editnum"])){
	echo "名前とパスワードが空欄です。";
}if(!empty($_POST["name"]) && empty($_POST["comment"]) && empty($_POST["password_new"]) && empty($_POST["editnum"])){
	echo "パスワードとコメントが空欄です。";
}


//削除コード
		$delete = $_POST["delete"];
		$delepass = $_POST["password_dele"];
//削除対象番号とパスワードが空ではなかった場合		
if(!empty($delete) && !empty($delepass)){
		
		$sql = 'select * from g order by id asc';
		$results = $pdo->query($sql);

	foreach($results as $row){

//パスワードが一致した場合
if($row['pass'] == $delepass){
		$id = $delete;
		$sql = "delete from g where id=$delete";
	$result = $pdo->query($sql);
			     }
				 }
//パスワードが違う場合
if($row['pass'] != $delepass){
	echo "パスワードが違います。";
}
					}

//編集コード２
if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password_new"]) && !empty($_POST["editnum"])){

		$id = $_POST["editnum"];
		$nm = $_POST["name"];
		$come = $_POST["comment"];

		$sql = "update g set name='$nm',comment='$come'where id='$id'";
	$result = $pdo->query($sql);//実行

}

//投稿番号リセット
		$t = 'ALTER TABLE g AUTO_INCREMENT = 1';
	$result = $pdo->query($t);

//ブラウザに表示
		$sql = 'select * from g order by id asc';
	$results = $pdo->query($sql);
	
	echo "注意：半角全角気を付けて<br><br>";
	
	foreach($results as $row){
	
	 	$newid = $row['id'];
	 	$newname = $row['name'];
	 	$newcomment = $row['comment'];
	 	$date = $row['created'];

		$newdate = "$newid"."<>"."$newname"."<>"."$newcomment"."<>"."$date";// 投稿番号・名前・コメント・日付を$newdateにまとめた
	$wake=explode("<>",$newdate);
	echo $wake[0]." ".$wake[1]." ".$wake[2]." ".$wake[3],"<br>" ;

//↓のコメントアウトを解除するとパスワードもブラウザに表示されるよ
	/*echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['created'].'<br>';
	//echo $row['pass'];*/
}

?>
