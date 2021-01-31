<?php

class Crud
{

    public $connect;
    private $host = "3.34.242.186";
    private $username = "sy";
    private $password = "HQNRkvBg27XZw8DPWVuKTQ6JFb8cwG!";
    private $database = "sydb";

//객체가 생성될때 호출
    function __construct()
    {
        $this -> database_connect();
    }

// db 연결 함수
    public function database_connect()
    {
        $this->connect = mysqli_connect($this -> host, $this-> username,
            $this->password, $this->database);
    }


//쿼리 실행 함수
    public function execute_query($query)
    {
        return mysqli_query($this -> connect, $query);
    }

//데이터 조회 함수
    public function get_data_in_table($query)
    {
        $output ='';
        $result = $this ->execute_query($query);
        $output .= '
<table class="table table-bordered table-striped>"
<tr>
<th width="10%">이미지</th>
<th width="35%">성</th>
<th width="35%">이름</th>
<th width="10%">수정</th>
<th width="10%">삭제</th>
</tr>';

        while($row = mysqli_fetch_object($result))
        {
            $output .= '
<tr>
<td><img src="upload/'.$row->image.'" class="img-thumbnail" width="50" height="35"></td>
<td>'.$row->first_name.'</td>
<td>'.$row->last_name.'</td>
<td><button type="button" name="update" id="'.$row->id.'"
class="btn btn-success btn-xs update">수정</button></td>
<td><button type="button" name="delete" id="'.$row->id.'"
class="btn btn-danger btn-xs delete">삭제</button></td>
</tr>
';
        }
        $output .='</table>';
        return $output;
    }

//파일 업로드 함수
    function upload_file($file)
    {
        if(isset($file))
        {
            $extension = explode('.',$file["name"]);
            $new_name = rand() . '.' . $extension[1];
            $destination = './upload/' . $new_name;
            move_uploaded_file($file['tmp_name'], $destination);
            return $new_name;
        }

    }

}



?>
