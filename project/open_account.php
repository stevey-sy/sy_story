<?php
 include  $_SERVER['DOCUMENT_ROOT']."/db_connection.php";
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>회원가입</title>
  <script type="text/javascript" src="/project/js/jquery-3.5.1.min.js"></script>
</head>
<script>
function checkid(){
	var userid = document.getElementById("userid").value;
	if(userid)
	{
		url = "/check.php?userid="+userid;
			window.open(url,"chkid","width=300,height=100");
		}else{
			alert("아이디를 입력하세요");
		}
	}
</script>
<style>
    body {
    background-image:url('/uploads/blue.jpg');
    background-size: 750px 800px;
    background-repeat: no-repeat;
    background-position: center top;
    background-color: black;
  }
  ul {padding: 0;}
  li {list-style:none;}
  .login { width: 410px; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);}
  .login h4 { padding: 0 0 10px; font-size: 25px; color: white; border-bottom: 2px solid white;
  text-align: center;}
  .login li { color: white; padding: 0 0 12px;}
  .login li input { width: 100%; height: 46px; box-sizing: border-box; }
  .login button { border: 0; outline: 0; width: 100%; height: 56px; box-sizing: border-box; background: black; color: white; font-size: 18px;}
  #userid {
    width: 310px;
  }
  #id_double_check {
    width: 90px; background: black; color: white; border: 0; outline: 0;
  }
  #id_area {
    float: left;
  }
  .alert-danger{
      color: orange;

  }
    .alert-success{
        color: yellow;

    }
</style>
<body>
  <form action="join_action.php" method="post">
  <section class="login">
    <h4>Sign-in</h4>
    <ul>
      <li>사용자 아이디</li>
      <li id=id_area>
      <input type="text" name= "id" placeholder="아이디" title="아이디 입력" id="userid">
      <input type=button value="중복검사" onclick="checkid();" id=id_double_check>
      <input type="hidden" value="0" name="chs" />
      </li>
      <li>비밀번호</li>
      <li><input type="password" id="pwd1" name= "pw" placeholder="비밀번호" title="비밀번호 입력"></li>
      <li>비밀번호 확인
          <div class="alert alert-success" id="alert-success">"비밀번호가 일치합니다."</div>
          <div class="alert alert-danger" id="alert-danger">"비밀번호가 일치하지 않습니다."</div>
      </li>
      <li><input type="password" id="pwd2" name= "re_pw" placeholder="비밀번호" title="비밀번호 입력"></li>


        <li>이메일</li>
      <li><input type="text" name= "email" placeholder="이메알 주소" title="닉네임 입력"></li>
      <li><button type="submit">Join</button></li>
    </ul>
  </section>
  </form>

</body>
<script type="text/javascript">
    $(function(){
        $("#alert-success").hide();
        $("#alert-danger").hide();
        $("input").keyup(function(){
            var pwd1=$("#pwd1").val();
            var pwd2=$("#pwd2").val();
            if(pwd1 != "" && pwd2 != ""){
                if(pwd1 == pwd2){
                    $("#alert-success").show();
                    $("#alert-danger").hide();
                    $("#submit").removeAttr("disabled");
                }else{
                    $("#alert-success").hide();
                    $("#alert-danger").show();
                    $("#submit").attr("disabled", "disabled");
                }
            }
        });
    });


</script>
</html>