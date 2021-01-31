
<?php
$servername = "192.168.56.1";
$username = "sytester";
$password = "qlqjs13dla##";
$dbname = "myDB";

  $db = new PDO("mysql:host=192.168.56.1;dbname=20200615;charset=utf8", "sytester", "qlqjs13dla##");
  $rows = $db->query("SELECT * FROM board")->fetchAll(PDO::FETCH_OBJ);
?>


<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Welcome, 메인 페이지</title>
</head>

<body>
  <div class = "wrap">
    <ul>
      <?php foreach ($rows as $row): ?>
      <li>
        <?php echo $rows->index ?> /
        <?php echo $rows->subject ?> /
        <?php echo $rows->writer ?> /
        <?php echo $rows->content ?> /
        <?php echo $rows->reg_date ?> 
      </li>
      <?php endforeach ?>
    </ul>
  
  </div>
    <!--   <footer>
      ::: Contact : sinsy@gmail.com :::
    </footer> -->
</body>
</html>
