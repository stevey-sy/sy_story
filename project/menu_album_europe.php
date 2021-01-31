<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Welcome, 메인 페이지</title>
    <link rel="stylesheet" type="text/css" href="style_album.css">
    <link rel="stylesheet" type="text/css" href="style_home.css">
</head>
<body>
    <div class = "wrap">
        <header>
            <div id="login_area">
                <ul>
                    <li><a href = "test_login.php">로그인</a></li>
                </ul>
            </div>
            <div id="title">
                <h1>SY's Interior Story</h1> 
            </div>
        </header>
        <nav>
            <ul>
                <li><a href = "main.php">홈</a></li>
                <li><a href = "menu_intro.html" target="main_area">인테리어 소식</a></li>
                <li><a href = "menu_album.php" target="main_area">앨범</a></li>
                <li><a href = "menu_album.php" target="main_area">소품</a></li>
                <li><a href = "menu_board.php" target="main_area">게시판</a></li>

            </ul>
        </nav>
        <!-- Control buttons -->
        <div id="myBtnContianer">
            <button class ="btn active" onclick= "filterSelection('all')"><a href = "menu_album.php">Show All</a></button>
            <button class ="btn" onclick="filterSelection('concept')"> Concepts </button>
            <button class ="btn" onclick="filterSelection('size')"> Type </button>
        </div>
        <!-- The filterable elements. Note that some have multiple class names (this can be used if they belong to multiple categories) -->
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
  
        <section id="main">
            <section class="thumbnails">
                <div>
                    <div class="image_description">
                        <a href="images/europe/europe01.jpg">
                            <img src="images/europe/europe01.jpg" alt="" />
                            <h3> 텍스트 자리 </h3>    
                        </a>
                    </div>
                    <div class="image_description">
                        <a href="images/europe/europe02.jpg">
                            <img src="images/europe/europe02.jpg" alt="" />
                            <h3> 텍스트 자리 </h3>
                        </a>
                    </div>
                    <div class="image_description">
                        <a href="images/europe/europe03.jpg">
                            <img src="images/europe/europe03.jpg" alt="" />
                            <h3> 텍스트 자리 </h3>
                        </a>
                    </div>
                </div>
                <div>
                    <div class="image_description">
                        <a href="images/europe/europe04.jpg">
                            <img src="images/europe/europe04.jpg" alt="" />
                            <h3> 텍스트 자리 </h3>    
                        </a>
                    </div>
                    <div class="image_description">
                        <a href="images/europe/europe05.jpg">
                            <img src="images/europe/europe05.jpg" alt="" />
                            <h3> 텍스트 자리 </h3>
                        </a>
                    </div>
                    <div class="image_description">
                        <a href="images/europe/europe06.jpg">
                            <img src="images/europe/europe06.jpg" alt="" />
                            <h3> 텍스트 자리 </h3>
                        </a>
                    </div>
                </div>
                <div>
<!--                     <div class="image_description">
                        <a href="images/modern/modern03.jpg">
                            <img src="images/modern/modern03.jpg" alt="" />
                            <h3> 텍스트 자리 </h3>    
                        </a>
                    </div>
                    <div class="image_description">
                        <a href="images/modern/modern05.jpg">
                            <img src="images/modern/modern05.jpg" alt="" />
                            <h3> 텍스트 자리 </h3>
                        </a>
                    </div>
                    <div class="image_description">
                        <a href="images/modern/modern01.jpg">
                            <img src="images/modern/modern01.jpg" alt="" />
                            <h3> 텍스트 자리 </h3>
                        </a>
                    </div> -->
                </div> 
            </div>
        </section>
        <footer>
            ::: Contact : sinsy@gmail.com :::
        </footer>
    </div>

<script>
    //Javascript
    var count = 0;
    //스크롤 바닥 감지  
    window.onscroll = function(e) {
        //추가되는 임시 콘텐츠
        //window height + window scroll Y축 값이 document height보다 클 경우,
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
