<?php
require_once("./phpQuery-onefile.php");

$word=$_POST['eng'];

$html = file_get_contents("https://unsplash.com/s/photos/.$word");
//HTMLを全文取得
$dom = phpQuery::newDocument($html);

/*
 * Wikipediaのタイトル・H1タグの中身と、
 * 画像の一覧を取得している。
 */

//H1タグの取得

//$h1 = $dom->find("h1")->text();
//echo $h1 . '<br>';

//titleタグの取得
//$title = $dom->find("title")->text();
//echo $title . '<br>';

//imgタグの一覧を取得
//foreach ($dom->find('img') as $img){
  //$img = $img->getAttribute('src');
  //echo '<img src=' . $img . '><br>';
//}

//aタグの一覧を取得
foreach ($dom->find('a') as $a){
  $a = $a->getAttribute('href');
  //echo '<a href=' . $a . '>' . $a . '</a><br>';
}

foreach ($dom->find('img') as $img){
    $img = $img->getAttribute('src');
    //echo '<img src=' . $img . '><br>';
   }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>test</title>
    <link rel="stylesheet" href="./homepage.css" />
</head>
<body>
    <div>English Dictionary with Beautiful Images</div>
    <p>Please input search word.</p>
    <form action="" method="POST">
        <input type="text" name="eng" />　<input type="submit" value="Search" />
    </form>
    <?php
    $dsn = 'mysql:host=localhost;dbname=DIC';
    $username = 'root';
    $password = 'pro3620';
   if ($_POST) {
        try {
            $dbh = new PDO($dsn, $username, $password);
            $search_word = $_POST['eng'];
            if($search_word==""){
              echo "ERR:Please input search word";
            }
            else{
                $sql ="select * from dic where eng like '".$search_word."%'";
                $sth = $dbh->prepare($sql);
                $sth->execute();
                $result = $sth->fetchAll();
                if($result){
                    foreach ($result as $row) {
                        echo $row['eng']." ";
                        echo $row['jan'];
                        echo "<br />";
                        }
                        $i=0;
                        foreach ($dom->find('img') as $img){
                            if($i>=5){
                                break;
                            }
                            $img = $img->getAttribute('src');
                        echo '<img src=' . $img . '><br>';
                            $i++;
                    }
                    }
                else{
                    echo "not found";
                }
            }
        }catch (PDOException $e) {
            echo  "<p>Failed : " . $e->getMessage()."</p>";
            exit();
        }     
    }
  
    ?>

  
 


</html>