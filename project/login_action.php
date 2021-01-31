<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

function Console_log($data){
        echo "<script>console.log( 'PHP_Console: " . $data . "' );</script>";
    }
    $testVal = "DB 연결";
    Console_log($testVal);
 
        session_start();
        //include  $_SERVER['DOCUMENT_ROOT']."/git_proejct/proejct/db_info.php";
        include  $_SERVER['DOCUMENT_ROOT']."/db.php";
        //입력 받은 id와 password
        $id=$_POST['id'];
        $pw=$_POST['pw'];
 
        //아이디가 있는지 검사
        $query = "select * from member where id='$id'";
        $result = $connect->query($query);
 
 
        $testVal2 = "아이디 검사 쿼리문";
        Console_log($testVal2);
        //아이디가 있다면 비밀번호 검사
        if(mysqli_num_rows($result)==1) {
                
                $testVal3= "아이디 검사 성공";
                Console_log($testVal3);
                
                $row=mysqli_fetch_assoc($result);
                if ( password_verify($pw, $row['password'])) {
                        $_SESSION['userid']=$id;
                ?> <script>

                        location.replace("/");
                </script>
                <?php
                
 
/*                $row=mysqli_fetch_assoc($result);
 
                //비밀번호가 맞다면 세션 생성
                if($row['pw']==$pw){
                        $_SESSION['userid']=$id;
                        if(isset($_SESSION['userid'])){
                       ?>      <script>
                                        alert("로그인 되었습니다.");
                                        location.replace("/index.php");
                                </script>
                        <?php
                        } else{
                                echo "session fail";
                      } */
                } else {
                        ?>              
                                <script>
                                        alert("아이디 혹은 비밀번호가 잘못되었습니다.");
                                        history.back();
                                </script>
                        <?php
                }
 
        } else {
                        ?>              
                                <script>
                                        alert("아이디 혹은 비밀번호가 잘못되었습니다.");
                                        history.back();
                                </script>
                        <?php
        }
                        ?>
