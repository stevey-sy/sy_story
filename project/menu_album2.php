<!DOCTYPE html>
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-172988251-2"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-172988251-2');
    </script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Welcome, 메인 페이지</title>
    <link rel="stylesheet" type="text/css" href="style_album.css">
    <link rel="stylesheet" type="text/css" href="style_home.css">
    <script src="/project/js/jquery-3.5.1.min.js"></script>
</head>
<style>
    .pageTitle {position: fixed; left: 0; top: 0; width: 100%; height: 52px; line-height: 52px; color: #fff; text-align: center; background: #111;}
    article {padding: 5px 3% 0;}
    article .block {padding: 20px; min-height: 500px;}
    article .block p {line-height: 22px; color: #fff; font-size: 16px; font-weight: 600;}
    /* 사진 게시 배경부분에 홀수, 짝수마다 다른 색을 넣기위해 구분 */
    article .block:nth-child(2n+1) {background: #999;}
    article .block:nth-child(2n) {background: #222;}
</style>
<body>
    <div class = "wrap">
        <header>
            <div id="login_area">
                <ul>
                    <li><a href = "page/product_board/cart.php" target="main_area">장바구니 / </a?</li>
                    <?php
                    session_start();
                    if(!isset($_SESSION['userid'])) {
                        echo "<li><a href = \"test_login.php\">로그인</a></li>";
                    } else {
                        $id = $_SESSION['userid'];
                        echo "<li>$id 님 환영합니다. / </a></li>";
                        echo "<li><a href = \"logout_action.php\">로그아웃</a></li>";
                    }
                    ?>
                </ul>
            </div>
            <div id="title">
                <h1>SY's Interior Story</h1> 
            </div>
        </header>
        <nav>
            <ul>
                <li><a href = "/">홈</a></li>
                <li><a href = "menu_intro.html" target="main_area">인테리어 소식</a></li>
                <li><a href = "menu_album.php">앨범</a></li>
                <li><a href = "page/product_board/menu_product.php" target="main_area">소품</a></li>
                <li><a href = "menu_board.php">게시판</a></li>
            </ul>

        </nav>
        <!-- 앨범 buttons -->
        <div id="album_btn_container">
            <!-- 사진 전체보기 버튼 -->
            <button class ="btn active" onclick= "filterSelection('all')"> <a href = "menu_album.php">Show All</a></button>
            <button class ="btn" onclick="filterSelection('concept')"> Concepts </button>
            <button class ="btn" onclick="filterSelection('size')"> Type </button>
        </div>
        <div class="container">
            <form action = "menu_album_modern.php" method="get">  
                <button class="filterDiv concepts" name="modern">모던</button>
            </form>
            <form action = "menu_album_vintage.php" method="get"> 
                <button class="filterDiv concepts" name="vintage">빈티지</button>
            </form>
            <form action = "menu_album_europe.php" method="get"> 
                <button class="filterDiv concepts" name="europe">북유럽</button>
            </form>
            <form action = "menu_album_room.php" method="get">  
                <button class="filterDiv size" name="room">원룸</button>
            </form>
            <form action = "menu_album_furniture.php" method="get">  
                <button class="filterDiv size" name="20py">주택</button>
            </form>
            <form action = "menu_album_deco.php" method="get">  
                <button class="filterDiv size" name="30py">상업공간</button>
            </form>
        </div>
        <!-- 사진을 담을 article -->
        <article>
            <div class="block">
                <p>
                    #빈티지 #화이트 #포인트:군청색 #거실
                </p>
                <div class="image_description"><a href="images/vintage/vintage16.jpg"><img src="images/vintage/vintage16.jpg" alt="" /></a></div>
            </div>
            <div class="block">
                <p>
                    #빈티지 
                </p>
                <div class="image_description"><a href="images/vintage/vintage16.jpg"><img src="images/vintage/vintage17.jpg" alt="" /></a></div>
            </div>
            <div class="block">
                <p>
                #빈티지 
                </p>
                <div class="image_description"><a href="images/vintage/vintage16.jpg"><img src="images/vintage/vintage18.jpg" alt="" /></a></div>
            </div>
            <div class="block">
                <p>
                #빈티지 
                </p>
                <div class="image_description"><a href="images/vintage/vintage16.jpg"><img src="images/vintage/vintage10.jpg" alt="" /></a></div>
            </div>
            <div class="block">
                <p>
                #빈티지 
                </p>
                <div class="image_description"><a href="images/vintage/vintage16.jpg"><img src="images/vintage/vintage11.jpg" alt="" /></a></div>
            </div>
    </article>

<!--         <footer>
            ::: Contact : sinsy@gmail.com :::
        </footer> -->
    </div>

<script>
    //Javascript
    var count = 0;
    //스크롤 바닥 감지  
    window.onscroll = function(e) {
        //window height + window scroll Y축 값이 document height보다 클 경우, 새로운 로직을 실행한다.
        if((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            //실행할 로직 (콘텐츠 추가)
            count++;       
            var addContent = '<div class="block"><p>'+ count +'번째로 추가된 콘텐츠</p><div class="image_description"><a href="images/allpic/picture'+ count +'.jpg"><img src="images/allpic/picture'+ count +'.jpg" alt="" /></a></div></div>';
            //addContent를 화면에 추가하는 로직 
            $('article').append(addContent);
        }
    };
    //앨범 카테고리 필터
    filterSelection("all")
    function filterSelection(selectedFilter) {
        // 필터가 선택되었을 때의 카테고리를 보여줄 변수 
        var category, i;
        // filterDiv에서 선택된 요소를 불러온다.
        category = document.getElementsByClassName("filterDiv");
        //만약 선택된 필터가 전체보기이면, 선택된 filter가 따로 없으므로 빈값을 보낸다.
        if (selectedFilter == "all") selectedFilter = "";
        // 사용자에게 필터링을 통해서 보여줄 카테고리 개수가 다른 카테고리의 개수보다 작을 때,
        // 카테고리를 변경한다. 
        for (i = 0; i < category.length; i++) {
        removeCategoryClass(category[i], "show");
        if (category[i].className.indexOf(selectedFilter) > -1) addCategoryClass(category[i], "show");
        }
    }
    
    function addCategoryClass(element, name) {
        var i, categoryGroup, categoryElement;
        categoryGroup = element.className.split(" ");
        categoryElement = name.split(" ");
        for (i = 0; i < categoryElement.length; i++) {
        if (categoryGroup.indexOf(categoryElement[i]) == -1) {element.className += " " + categoryElement[i];}
        }
    }
    
    function removeCategoryClass(element, name) {
        var i, categoryGroup, categoryElement;
        categoryGroup = element.className.split(" ");
        categoryElement = name.split(" ");
        for (i = 0; i < categoryElement.length; i++) {
            while (categoryGroup.indexOf(categoryElement[i]) > -1) {
            categoryGroup.splice(categoryGroup.indexOf(categoryElement[i]), 1);     
            }
        }
        element.className = categoryGroup.join(" ");
    }

</script>

</body>
</html>
