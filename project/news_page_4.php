<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" type="text/css" href="/project/css/style_news_page.css">
</head>
<style>
    a:link { color: black; text-decoration: none;}
</style>
<body style="overflow-x:hidden; overflow-y:hidden;">

<?php
//  크롤링 파트
ini_set("allow_url_fopen", 1);
include ('simple_html_dom.php');
$data_source = file_get_html('https://maisondebianco.tistory.com/category/%ED%99%88%EC%8A%A4%ED%83%80%EC%9D%BC%EB%A7%81?page=3');

$list_articles = $data_source->find('div[class="index-list-content-inner"]');

foreach($list_articles as $article) {?>
    <?php
    // url 불러오기
    $item[$i]['url'] = $data_source-> find('a.index-mobile', $i)->href;
    //echo $item[$i]['url'];
    // 제목 불러오기
    $item[$i]['title'] = $data_source-> find('strong[class="tit_post"]', $i)->plaintext;
    //echo $item[$i]['title'];
    // 이미지 불러오기
    $item[$i]['img'] = $data_source-> find('div[class="rgy-index-img-frame"]', $i)->style;
    // 기사 내용 불러오기
    $item[$i]['content'] = $data_source-> find('p[class="txt_post"]', $i)->plaintext;
    // 기사 날짜 불러오기
    $item[$i]['date'] = $data_source-> find('span[class="txt_bar"]', $i)->plaintext;

    if($i > 0) {
        ?>

        <!-- 가져온 데이터 html에 삽입 -->
        <a href= "https://maisondebianco.tistory.com/<?php echo $item[$i]['url'];?>">
            <div class="container">
                <div class="item" style= "<?php echo $item[$i]['img'];?> background-size: cover;"></div>
                <div class="item"> <?php echo $item[$i]['title']; ?> </div>
                <div class="item"> <?php echo $item[$i]['date']; ?> </div>
                <div class="item" id="article_content"> <?php echo $item[$i]['content']; ?> </div>
            </div>
        </a>
        <?php
    }
    $i++;
}
?>
<div class="title">
    <h2> 더 불러올 소식이 없습니다. </h2>
</div>
</body>
</html>