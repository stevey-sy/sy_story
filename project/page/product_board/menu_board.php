<?php include  $_SERVER['DOCUMENT_ROOT']."/db_connection.php"; ?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Welcome, 메인 페이지</title>
  <link rel="stylesheet" type="text/css" href="style_home.css">
</head>
<style>

.grid-container {
  display: grid;
  grid-template-columns: auto auto auto;
  /* background-color: #2196F3; */
  padding: 10px;
}
.grid-item {
  /* background-color: rgba(255, 255, 255, 0.8); */
  border: 1px solid rgba(0, 0, 0, 0.8);
  padding: 20px;
  font-size: 30px;
  display: flex;
  justify-content: center;
}

img {
  width: 200px;
  height: 400px;
}

.list-table td {
    height:40px;
	  border-top:2px solid black;
	  border-bottom:1px solid #CCC;
	  font-weight: bold;
	  font-size: 17px;
  }

/*   * {
    margin: 50 auto;
  	padding: 0;
  	font-family: 'Malgun gothic','Sans-Serif','Arial';
  }

  .tc {
    text-align:center;
  }

  #board {
    width: 100%;q
    text-align:center;
    position: static;
    background:#fff;
  }

  .list_table {
    width: 100%;
    text-align: center;
  }

  .list_table thead th {
    height:40px;
	  border-top:2px solid black;
	  border-bottom:1px solid #CCC;
	  font-weight: bold;
	  font-size: 17px;
  }

  #write_btn {
	position: absolute;
  margin-top:20px;
  right: 0;
  }
  #page_num {
	font-size: 14px;
	margin-left: 260px;
	margin-top:30px; 
  }
  #page_num ul li {
	float: left;
	margin-left: 10px; 
	text-align: center;
  }
  .mark_red {
	font-weight: bold;
	color:red;
  }

  ul {
  list-style:none;
  } */

</style>
<body>

<div id="board_area"> 
  <h1>상품 목록</h1>
  <div class="grid-container">
        <?php
        // board테이블에서 idx를 기준으로 내림차순해서 5개까지 표시
        //  $query = "select * from board_product order by index desc limit";
        //  $result = $connect->query($query);
          //$total = mysqli_num_rows($result);
          
        //  while($rows = mysqli_fetch_array($result)){
        //    if (!$result) {
        //      printf("Error: %s\n", mysqli_error($con));
        //      exit();
        //  }

           $sql = mq("select * from product order by idx desc limit 0,5"); 
          while($board = $sql->fetch_array())
            {
               //title변수에 DB에서 가져온 title을 선택
              $title=$board["title"]; 
              if(strlen($title)>30)
              { 
                //title이 30을 넘어서면 ...표시
                $title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
              } 
        ?>
      
        <div class="grid-item">
        <table class="list-table">
        <tr>
        <th><img src="/practice-show-image.php?image_id=2"/></th>
        </tr>
        <tr>
          <td width="150"><?php echo $title;?></td>
        </tr>
        <tr>
          <td width="150"><?php echo $board['content']?></td>
        </tr>
        <tr>
          <td width="150"><?php echo $board['name']?></td>
        </tr>
        </table>
        
        </div>
        


        
      
      <?php } ?>
      
    </div>
    <div id="write_btn">
      <a href="/page/board/write.php"><button>글쓰기</button></a>
    </div>
  </div>

    

</body>
</html>