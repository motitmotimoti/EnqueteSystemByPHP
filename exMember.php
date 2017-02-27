<?php
$dbname = 'enquete_main_2';//各々の環境で変わります．
$pre_dsn = 'mysql:host=127.0.0.1;charset=utf8';
$dsn = 'mysql:host=127.0.0.1;dbname='.$dbname.';charset=utf8';//各々の環境で変わります．
$user = 'root';//各々の環境で変わります．
$password = 'root';//各々の環境で変わります．

$tbname_1 = 'test_vote';
$tbname_2 = 'test_lab_member_info';
$tbname_3 = 'test_order_of_presentation';
$fiscalyear = '2016'; // 今の所はとりあえず，年度に関しては，ベタ打ちとする．

date_default_timezone_set('Asia/Tokyo');
$date = date('Y-m-d');

try {
  $pre_dbh = new PDO( // databaseがなければ作る．
    $pre_dsn,
    $user,
    $password,
    array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
    )
  );
  $pre_dbh->exec('CREATE DATABASE IF NOT EXISTS'.$dbname);

  $dbh = new PDO(
    $dsn,
    $user,
    $password,
    array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
    )
  );
$col_set_tb1 = <<< EOM
  date  date  COMMENT'年月日',
  time  time  COMMENT'時間',
  voter_person_id  varchar(100)  COMMENT'投票者のID',
  types_of_votes  varchar(30)  COMMENT'P or FG ?',
  rank  tinyint unsigned  COMMENT'順位',
  voted_person_id  varchar(100)  COMMENT'被投票者のID'
EOM;
  $dbh->exec('CREATE TABLE IF NOT EXISTS'.$tbname_1.'('.$col_set_tb1.');');

$col_set_tb2 = <<< EOM
  fiscal_year  year  COMMENT'登録年度',
  studentname  nvarchar(100)  COMMENT'ゼミ所属学生の名前',
  person_id  varchar(100)  COMMENT'ID(年度が異なっても，この値が同じなら，同一人物)'
EOM;
  $dbh->exec('CREATE TABLE IF NOT EXISTS'.$tbname_2.'('.$col_set_tb2.');');

$col_set_tb3 = <<< EOM
  date  date  COMMENT'年月日',
  time  time  COMMENT'時間',
  attendee_person_id  varchar(100)  COMMENT'出席者のID',
  order_of_presen  tinyint unsigned  COMMENT'発表順'
EOM;
  $dbh->exec('CREATE TABLE IF NOT EXISTS'.$tbname_3.'('.$col_set_tb3.');');

  $sql = 'SELECT * FROM ? WHERE fiscal_year = ? ';
  $prepare->bindValue(1, $tbname_2, PDO::PARAM_STR);
  $prepare->bindValue(2, $fiscalyear, PDO::PARAM_STR);
  $memberinfo = $prepare->execute();




} catch (Exception $e) {
  header('Content-Type: text/plain; charset=UTF-8', true, 500);
  echo 'エラー!: '.$e->getMessage().'<br/>';
  die();
}
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
header('Content-Type: text/html; charset=utf-8');


 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>発表順</title>
<div style="background-color: #cff;">
</head>
<body>


<?php
$dsn      = 'mysql:dbname=enquete_main;host=127.0.0.1;charset=utf8mb4'; //ここら辺は各々の環境で．
$user     = 'root'; //ここら辺は各々の環境で．
$password = 'root'; //ここら辺は各々の環境で．

date_default_timezone_set('Asia/Tokyo');
$date = date('Y-m-d');

try {
    $dbh = new PDO('mysql:host=127.0.0.1;charset=utf8', $user, $password);

    // $dbh = new PDO(//各々の環境で変わります．
    //   'mysql:host=127.0.0.1;charset=utf8',
    //   root,
    //   root,
    //   array(
    //     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    //     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    //     PDO::ATTR_EMULATE_PREPARES => false,
    //   )
    // );

    // SELECT文以降の処理では，exec関数は使用できない．
    $dbh->exec('CREATE DATABASE IF NOT EXISTS enquete_main'); // 無ければDBを作成する．
    $dbh = new PDO($dsn, $user, $password); //　$dbh->query("USE enquete_simple"); // こっちでも良い．
// 新しくDBを作成した場合，このカラム設定を適用する．
$col_set = <<< EOM
  date  date  COMMENT'年月日',
  time  time  COMMENT'時間',
  voter_person_id  varchar(100)  COMMENT'投票者のID',
  types_of_votes  varchar(30)  COMMENT'P or FG ?',
  rank  tinyint unsigned  COMMENT'順位',
  voted_person_id  varchar(100)  COMMENT'被投票者のID'
EOM;
    $dbh->query("CREATE TABLE IF NOT EXISTS TestA_1_vote ($col_set);"); // 無ければTABLEを作成する．

    //$st = $dbh->prepare("INSERT INTO enq_table_beta (date) VALUES(?)"); // 投票用のレコードを無ければ作成．
    //$st->execute(array($date)); // 日にちでレコードを分ける．

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error:'.$e->getMessage();
    die();
}


header('Content-Type: text/html; charset=utf-8');
?>

<?php
$dsn      = 'mysql:dbname=enquete_main;host=127.0.0.1;charset=utf8'; //ここら辺は各々の環境で．
$user     = 'root'; //ここら辺は各々の環境で．
$password = 'root'; //ここら辺は各々の環境で．

try {
    $dbh = new PDO('mysql:host=127.0.0.1;charset=utf8', $user, $password);
    // SELECT文以降の処理では，exec関数は使用できない．
    $dbh->exec('CREATE DATABASE IF NOT EXISTS enquete_main'); // 無ければDBを作成する．
    $dbh = new PDO($dsn, $user, $password); //　$dbh->query("USE enquete_simple"); // こっちでも良い．
// 新しくDBを作成した場合，このカラム設定を適用する．
$col_set = <<< EOM
  fiscal_year  year  COMMENT'登録年度',
  studentname  nvarchar(100)  COMMENT'ゼミ所属学生の名前',
  person_id  varchar(100)  COMMENT'ID(年度が異なっても，この値が同じなら，同一人物)'
EOM;
    $dbh->query("CREATE TABLE IF NOT EXISTS TestA_2_lab_member_info ($col_set);"); // 無ければTABLEを作成する．

    //$st = $dbh->prepare("INSERT INTO enq_table_beta (date) VALUES(?)"); // 投票用のレコードを無ければ作成．
    //$st->execute(array($date)); // 日にちでレコードを分ける．

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error:'.$e->getMessage();
    die();
}
?>

<?php
$dsn      = 'mysql:dbname=enquete_main;host=127.0.0.1;charset=utf8'; //ここら辺は各々の環境で．
$user     = 'root'; //ここら辺は各々の環境で．
$password = 'root'; //ここら辺は各々の環境で．

try {
    $dbh = new PDO('mysql:host=127.0.0.1;charset=utf8', $user, $password);
    // SELECT文以降の処理では，exec関数は使用できない．
    $dbh->exec('CREATE DATABASE IF NOT EXISTS enquete_main'); // 無ければDBを作成する．
    $dbh = new PDO($dsn, $user, $password); //　$dbh->query("USE enquete_simple"); // こっちでも良い．
// 新しくDBを作成した場合，このカラム設定を適用する．
$col_set = <<< EOM
  date  date  COMMENT'年月日',
  time  time  COMMENT'時間',
  attendee_person_id  varchar(100)  COMMENT'出席者のID',
  order_of_presen  tinyint unsigned  COMMENT'発表順'
EOM;
    $dbh->query("CREATE TABLE IF NOT EXISTS TestA_3_order_of_presentation ($col_set);"); // 無ければTABLEを作成する．

    //$st = $dbh->prepare("INSERT INTO enq_table_beta (date) VALUES(?)"); // 投票用のレコードを無ければ作成．
    //$st->execute(array($date)); // 日にちでレコードを分ける．

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error:'.$e->getMessage();
    die();
}
?>


<form method="post" action="exMember.php">
<h2>○出席者を選んでください</h2>
<div style="background: #ddf; width:200px; border: 1px double #CC0000; height:100％; padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:10px;">

<!-- 消すやつ -->
<?php
try {
    $dbh = new PDO('mysql:host=127.0.0.1;charset=utf8',  root, root); //各々の環境で変わります．
  $dbh->query('USE enquete_main');

  // "fiscal_year"に関しては，後で，フロントサイドからトグル？などで「年度」を選択できるようにしたい．
  $st = $dbh->query("SELECT * FROM TestA_2_lab_member_info WHERE fiscal_year = '2016'");

    foreach ($st as $row) {
        # code...
    $name   = $row['studentname'];
        $id = $row['person_id'];
        echo "<label><input type='checkbox' name='cn[]' value='$id' checked>{$name}<br><br></label>";
    }
} catch (PDOException $e) {
    echo 'エラー!: '.$e->getMessage().'<br/>';
    die();
}
?>
<!--  -->

<!--  残すやつ -->
<?php foreach ($memberinfo as $row): ?>
  <?php $name   = $row['studentname'];?>
  <?php $id = $row['person_id'];?>
  <label>
    <input type='checkbox' name='cn[]' value='<?=h($id)?>' checked>
    {<?=h($name)?>}
    <br><br>
  </label>
<?php endforeach; ?>
<!--  -->

<!-- 残すやつ -->
</div><br>
 <!-- 出席者から今日の発表順がソートされる時点で，これより前の投票結果を削除する．投票の反映は上書きではなく，足し込みのため． -->
<input type="submit" name="sort" value="発表順を決める 　(＆　残っている投票結果をクリアする)" >
</form>
<!--  -->


<?php
echo'<h2>○今日の発表順はこちら</h2>';

// 投票ボタン
if ($_POST['sort']) {
    $food = $_POST['cn'];
    srand(time()); //乱数列初期化．冗長の可能性あり．
  shuffle($food); //　出席者をランダムソートにかけ，発表順を決める．

  date_default_timezone_set('Asia/Tokyo');
    $date = date('Y-m-d');
    $time = date('H:i:s');

    try {
        $dbh = new PDO('mysql:host=127.0.0.1;charset=utf8',  root, root); //各々の環境で変わります．
    $dbh->query('USE enquete_main');

    // すでにその日の発表順が入っている場合は，それをまずDELETEする．
    $sql    = "DELETE FROM TestA_3_order_of_presentation where date = '$date'";
        $st = $dbh->prepare($sql);
        $st->execute();

        for ($i = 0; $i < count($food); ++$i) {
            $j   = $i + 1;
            $sql = "INSERT INTO TestA_3_order_of_presentation (date, time, attendee_person_id, order_of_presen) VALUES ('$date', '$time', '$food[$i]', '$j') ";
      //ON DUPLICATE KEY UPDATE date = '$date'

      //echo "$food[$i]";
      //$sql = "INSERT INTO enq_table_main (date, time, exist_studentname, order_of_presen) VALUES ('$date', '$time', '$food[$i]', '$i')SET $nameA = $nameA + 3 WHERE date = '$date'";
      $st = $dbh->prepare($sql);
            $st->execute();
        }
    } catch (PDOException $e) {
        echo 'エラー!: '.$e->getMessage().'<br/>';
        die();
    }
}

try {
    $dbh = new PDO('mysql:host=127.0.0.1;charset=utf8',  root, root); //各々の環境で変わります．
  $dbh->query('USE enquete_main');

    $query = <<< EOM
    select studentname
    from  TestA_2_lab_member_info
    left join TestA_3_order_of_presentation
    on TestA_2_lab_member_info.person_id = TestA_3_order_of_presentation.attendee_person_id
    where TestA_3_order_of_presentation.date = '$date'
     AND time = (SELECT MAX(time) FROM TestA_3_order_of_presentation WHERE date = '$date')
    order by TestA_3_order_of_presentation.order_of_presen;
EOM;
    $st = $dbh->query("$query");

    echo"<table border='1' cellpadding='6' style='background:white'>";
    $i = 1;
    foreach ($st as $row) {
        echo '<tr>';
        echo "<td>$i</td>";
        echo "<td>{$row['studentname']}</td>";
        echo "</tr>\n";
        $i = $i + 1;
    }
    echo'</table>';
} catch (PDOException $e) {
    echo 'エラー!: '.$e->getMessage().'<br/>';
    die();
}

?>

<br>
<!-- 直下のurlをいじると，ベルの時間とテキストのデフォルト表示を変えられる．ベルの時間の実際に鳴る時間は，コードもいじる必要がある． -->
<h3><a href= withTimer.php#t1=5:00&t2=10:00&t3=20:00&m=論文輪講%20発表時間><font color="orange"> 発表用タイマー </font></a></h3>
<h4><a href= request_exOrder.php ><font color="blue"> 発表順を編集 </font>
<h4><a href= index.html ><font color="green"> TOP </font>
</a><h4>
<br><br><br>
</body>
</html
