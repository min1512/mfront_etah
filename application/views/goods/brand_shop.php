<link rel="stylesheet" href="/assets/css/display.css?ver=1.3">

<!-- 공방브랜드 페이지 // -->
<?if( $brand['BRAND_CATEGORY_CD'] == 4010 ){?>
        <div class="content brand2">
            <!-- top-location -->
            <?if($srp != ''){?>
                <div class="page-title-box page-title-box--location">
                    <div class="page-title">
                        <ul class="page-title-list">
                            <li class="page-title-item"><a href="/goods/search?keyword=<?=$keyword?>">검색결과</a></li>
                            <li class="page-title-item active">브랜드</li> <!-- 퐐성화시 클래스 active추가 -->
                        </ul>
                    </div>
                </div>
            <?}?>
            <!-- //top-location -->

            <div class="section brand2_visual">
                <div class="img"><img src="<?=$brand['BANNER_IMG_URL']?$brand['BANNER_IMG_URL']:$brand['TITLE_BG_IMG_URL']?>" alt=""></div>
                <div class="txt">
                    <div class="txt_inner">
                        <!--                            <span class="txt1">키치한 색감으로 가득채운</span>-->
                        <span class="txt2"><?=$brand['BRAND_NM']?></span>
                        <p><?=$brand['MOB_BRAND_DESC']?></p>
                    </div>
                </div>
            </div>

            <div class="section brand2_grade">
                <div class="star-grade">
                    <?
                    $i =0;
                    $total_goods_grade = 0;
                    foreach($review as $row){
                        $total_goods_grade += $row['TOTAL_GRADE_VAL'];
                        $i++;
                    }
                    @$total_grade = $total_goods_grade/$i;

                    preg_match("/([가-핳]+동)/", $brand['MAP_URL'], $match);
                    $area = $match[0];
                    ?>
                    <?if(@$total_grade){?>
                        <p class="star-grade-num"><?=number_format($total_grade, 1)?></p> <!-- 상품평이 없는 경우 숫자 안보이게 -->
                    <?}?>
                    <div class="star-grade-box">
                        <span class="star-rating spr-common"><span class="star-ico spr-common" style="width: <?=$total_grade*20?>%"></span></span> <!-- 상품평이 없는 경우 width: 0 으로 -->
                    </div>
                </div>
                <div class="location">
                    <p class="loca01"><?=$area?></p>
                    <p class="loca02">지역</p>
                </div>
            </div>

            <div class="section brand2_about">
                <div class="link_banner">
                    <a href="<?=$brand['VIDEO_URL']?$brand['VIDEO_URL']:"https://www.youtube.com/channel/UCVEBa0D-0coHeJu9LYO5l0Q"?>"><img src="/assets/images/data/main/sample46.jpg" alt=""></a>
                </div>
                <div class="link_banner">
                    <a href="<?=$brand['MAGAZINE_NO']?"/magazine/detail/".$brand['MAGAZINE_NO']:"/magazine/list?cate_cd=70000000"?>"><img src="/assets/images/data/main/sample47.jpg" alt=""></a>
                </div>
                <div class="video">
                    <iframe src="https://www.youtube.com/embed/<?=$brand['VIDEO_TITLE_CD']?>?autoplay=1&loop=1&playlist=<?=$brand['VIDEO_TITLE_CD']?>&mute=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="class_gallery pop-img-wrap">
                    <div class="img-popup owl-carousel">
                        <?foreach($gallery as $grow){?>
                            <div class="item auto-img">
                                <div class="img">
                                    <img src="<?=$grow['IMG_URL']?>" />
                                </div>
                                <span class="btn-close">close</span>
                            </div>
                        <?}?>
                    </div>
                    <div class="img-thumb owl-carousel">
                        <?foreach($gallery as $grow){?>
                            <div class="item auto-img">
                                <div class="img">
                                    <img src="<?=$grow['IMG_URL']?>" />
                                </div>
                            </div>
                        <?}?>
                    </div>
                </div>
            </div>

            <div class="section brand2_class tab-area">
                <ul class="tabhead grid-2">
                    <li>
                        <a href="#" class="on" data-target="tabbody_class">작가님 클래스</a>
                    </li>
                    <li>
                        <a href="#" data-target="tabbody_review">후기</a>
                    </li>
                </ul>

                <div class="list on" id="tabbody_class">
                    <!-- 상품리스트 // -->
                    <div class="prds-list">
                        <ul>
                            <?for($i=0;$i<(($classCnt>6)?6:$classCnt);$i++){?>
                                <li>
                                    <a href="/goods/detail/<?=$classList[$i]['GOODS_CD']?>">
                                        <div class="pic">
                                            <div class="item auto-img">
                                                <div class="img">
                                                    <img src="<?=$classList[$i]['IMG_URL']?>" class="bg" />
                                                </div>
                                                <div class="layer"></div>
                                                <div class="status">
                                                    <span class="like"><?=$classList[$i]['INTEREST']?></span>
                                                </div>
                                            </div>
                                            <div class="tag-wrap">
                                                <span class="circle-tag class"><em class="blk">에타홈<br>클래스</em></span>
                                            </div>
                                        </div>
                                        <div class="txt">
                                            <p class="nm_txt"><?=$classList[$i]['BRAND_NM']?></p>
                                            <p class="prd_txt"><span class="tag <?=$classList[$i]['CLASS_TYPE']=='원데이'?"yellow":"black"?>"><?=$classList[$i]['CLASS_TYPE']?></span><?=$classList[$i]['GOODS_NM']?></p>
                                            <p class="price">
                                                <span class="price_txt">판매가</span>
                                                <?if($classList[$i]['COUPON_CD_S'] || $classList[$i]['COUPON_CD_G']){
                                                    $price = $classList[$i]['SELLING_PRICE'] - ($classList[$i]['RATE_PRICE_S'] + $classList[$i]['RATE_PRICE_G']);
                                                    echo "<span class=\"price1\">".number_format($price)."</span>";
                                                    ?>
                                                    <span class="price2"><?=number_format($classList[$i]['SELLING_PRICE'])?></span>
                                                    <span class="percent">(<?=floor((($classList[$i]['SELLING_PRICE']-$price)/$classList[$i]['SELLING_PRICE'])*100) == 0 ? 1 : floor((($classList[$i]['SELLING_PRICE']-$price)/$classList[$i]['SELLING_PRICE'])*100)?>%)</span>
                                                <?} else{
                                                    echo "<span class=\"price1\">".number_format($classList[$i]['SELLING_PRICE'])."</span>";
                                                }?>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            <?}?>
                            <?for($i=6;$i<$classCnt;$i++){?>
                                <li class="classPlusList">
                                    <a href="/goods/detail/<?=$classList[$i]['GOODS_CD']?>">
                                        <div class="pic">
                                            <div class="item auto-img">
                                                <div class="img">
                                                    <img src="<?=$classList[$i]['IMG_URL']?>" class="bg" />
                                                </div>
                                                <div class="layer"></div>
                                                <div class="status">
                                                    <span class="like"><?=$classList[$i]['INTEREST']?></span>
                                                </div>
                                                <div class="tag-wrap">
                                                    <span class="circle-tag class"><em class="blk">에타홈<br>클래스</em></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="txt">
                                            <p class="nm_txt"><?=$classList[$i]['BRAND_NM']?></p>
                                            <p class="prd_txt"><span class="tag <?=$classList[$i]['CLASS_TYPE']=='원데이'?"yellow":"black"?>"><?=$classList[$i]['CLASS_TYPE']?></span><?=$classList[$i]['GOODS_NM']?></p>
                                            <p class="price">
                                                <span class="price_txt">판매가</span>
                                                <?if($classList[$i]['COUPON_CD_S'] || $classList[$i]['COUPON_CD_G']){
                                                    $price = $classList[$i]['SELLING_PRICE'] - ($classList[$i]['RATE_PRICE_S'] + $classList[$i]['RATE_PRICE_G']);
                                                    echo "<span class=\"price1\">".number_format($price)."</span>";
                                                    ?>
                                                    <span class="price2"><?=number_format($classList[$i]['SELLING_PRICE'])?></span>
                                                    <span class="percent">(<?=floor((($classList[$i]['SELLING_PRICE']-$price)/$classList[$i]['SELLING_PRICE'])*100) == 0 ? 1 : floor((($classList[$i]['SELLING_PRICE']-$price)/$classList[$i]['SELLING_PRICE'])*100)?>%)</span>
                                                <?} else{
                                                    echo "<span class=\"price1\">".number_format($classList[$i]['SELLING_PRICE'])."</span>";
                                                }?>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            <?}?>
                        </ul>
                    </div>
                    <!-- // 상품리스트 -->
                    <?if($classCnt > 6){?>
                        <div class="btn_bottom_wrap">
                            <span class="btn-white" id="classPlus">클래스 더 보기</span>
                        </div>
                    <?}?>
                </div>
                <div class="list" id="tabbody_review">
                    <!-- 후기리스트 // -->
                    <ul class="prd-assessment-list">
                        <?
                        for($i=0;$i<(count($review)>4?4:count($review));$i++){
                            ?>
                            <li class="item">
                                <span class="nick"><?=$review[$i]['CUST_ID']?></span>
                                <span class="date"><?=substr($review[$i]['CUST_GOODS_COMMENT_REG_DT'],0,10)?></span>
                                <div class="star-grade-box">
                                    <span class="star-rating spr-common"><span class="star-ico spr-common" style="width:<?=substr($review[$i]['TOTAL_GRADE_VAL'],0,1)*20?>%"></span></span>
                                </div>
                                <p class="txt"><?=$review[$i]['CONTENTS']?></p>
                                <a href="/goods/detail/<?=$review[$i]['GOODS_CD']?>"><p class="name"><?=$review[$i]['GOODS_NM']?></p></a>
                                <?if($review[$i]['FILE_PATH']){?>
                                    <div class="photo pop-img-wrap">
                                        <div class="img-popup owl-carousel">
                                            <div class="auto-img">
                                                <div class="img">
                                                    <img src="<?=$review[$i]['FILE_PATH']?>" />
                                                </div>
                                                <span class="btn-close">close</span>
                                            </div>
                                        </div>
                                        <div class="img-thumb owl-carousel">
                                            <div class="auto-img">
                                                <div class="img">
                                                    <img src="<?=$review[$i]['FILE_PATH']?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?}?>
                            </li>
                        <?}?>
                        <?for($i=4;$i<count($review);$i++){?>
                            <li class="item reviewPlusList">
                                <span class="nick"><?=$review[$i]['CUST_ID']?></span>
                                <span class="date"><?=substr($review[$i]['CUST_GOODS_COMMENT_REG_DT'],0,10)?></span>
                                <div class="star-grade-box">
                                    <span class="star-rating spr-common"><span class="star-ico spr-common" style="width:80%"></span></span>
                                </div>
                                <p class="txt"><?=$review[$i]['CONTENTS']?></p>
                                <a href="/goods/detail/<?=$review[$i]['GOODS_CD']?>"><p class="name"><?=$review[$i]['GOODS_NM']?></p></a>
                                <?if($review[$i]['FILE_PATH']){?>
                                    <div class="photo pop-img-wrap">
                                        <div class="img-popup owl-carousel">
                                            <div class="auto-img">
                                                <div class="img">
                                                    <img src="<?=$review[$i]['FILE_PATH']?>" />
                                                </div>
                                                <span class="btn-close">close</span>
                                            </div>
                                        </div>
                                        <div class="img-thumb owl-carousel">
                                            <div class="auto-img">
                                                <div class="img">
                                                    <img src="<?=$review[$i]['FILE_PATH']?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?}?>
                            </li>
                        <?}?>
                    </ul>
                    <!-- // 후기리스트 -->
                    <?if(count($review)>4){?>
                        <div class="btn_bottom_wrap">
                            <span class="btn-white" id="reviewPlus">후기 더 보기</span>
                        </div>
                    <?}?>
                </div>
            </div>

            <?if($goodsCnt != 0){?>
                <div class="section brand2_product">
                    <h3 class="title-style">공방 제작 상품</h3>
                    <?if($goodsCnt > 4){?>
                        <div class="btn_wrap">
                            <a href="/category/category_list?&cate_cd=20020000&brand_cd=<?=brand['BRAND_CD']?>" class="btn-more"><span>more</span></a>
                        </div>
                    <?}?>
                    <!-- 상품리스트 // -->
                    <div class="prds-list">
                        <ul>
                            <?foreach($goodsList as $grow){?>
                                <li>
                                    <a href="/goods/detail/<?=$grow['GOODS_CD']?>">
                                        <div class="pic">
                                            <div class="item auto-img">
                                                <div class="img">
                                                    <img src="<?=$grow['IMG_URL']?>" class="bg" />
                                                </div>
                                                <div class="tag-wrap">
                                                    <span class="circle-tag class-prd"><em class="blk">공방<br>제작상품</em></span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="txt">
                                            <p class="nm_txt"><?=$grow['BRAND_NM']?></p>
                                            <p class="prd_txt"><?=$grow['GOODS_NM']?></p>
                                            <p class="price_txt">판매가</p>
                                            <?if($grow['COUPON_CD_S'] || $grow['COUPON_CD_G']){
                                                $price = $grow['SELLING_PRICE'] - ($grow['RATE_PRICE_S'] + $grow['RATE_PRICE_G']);
                                                echo "<p class=\"price1\">".number_format($price)."</P>";
                                                ?>
                                                <p class="price2"><?=number_format($grow['SELLING_PRICE'])?></p>
                                                <span class="percent">(<?=floor((($grow['SELLING_PRICE']-$price)/$grow['SELLING_PRICE'])*100) == 0 ? 1 : floor((($grow['SELLING_PRICE']-$price)/$grow['SELLING_PRICE'])*100)?>%)</span>
                                            <?} else{
                                                echo "<p class=\"price1\">".number_format($grow['SELLING_PRICE'])."</p>";
                                            }?>
                                        </div>
                                    </a>
                                </li>
                            <?}?>
                        </ul>
                    </div>
                    <!-- // 상품리스트 -->
                </div>
            <?}?>
            <div class="brand2_map" style="padding-bottom:30px;">
                <div style="font:normal normal 400 12px/normal dotum, sans-serif; width:100%; height:auto; color:#333; position:relative">
                    <div style="height: auto;">
                        <div id="map" style="border:1px solid #ccc;width:auto;height:200px;position: relative;"></div>
                    </div>
                    <div style="overflow: hidden; padding: 7px 11px; border: 1px solid rgba(0, 0, 0, 0.1); border-radius: 0px 0px 2px 2px; background-color: rgb(249, 249, 249);">
                        <a href="https://map.kakao.com" target="_blank" style="float: left;">
                            <img src="//t1.daumcdn.net/localimg/localimages/07/2018/pc/common/logo_kakaomap.png" width="72" height="16" alt="카카오맵" style="display:block;width:72px;height:16px">
                        </a>
                        <div style="float: right; position: relative; top: 1px; font-size: 11px;">
                            <a id="path" target="_blank" href="#" style="float:left;height:15px;padding-top:1px;line-height:15px;color:#000;text-decoration: none;">길찾기</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function(){
                //클래스 더보기
                $(".classPlusList").hide();

                $("#classPlus").click(function(){
                    $("#classPlus").hide();
                    $(".classPlusList").show();
                });

                //리뷰 더보기
                $(".reviewPlusList").hide();

                $("#reviewPlus").click(function(){
                    $("#reviewPlus").hide();
                    $(".reviewPlusList").show();
                });
            })
        </script>
        <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=a05f67602dc7a0ac2ef1a72c27e5f706&libraries=services"></script>
        <script>
            var mapContainer = document.getElementById('map'), // 지도를 표시할 div
                mapOption = {
                    center: new daum.maps.LatLng(37.494940, 127.038061), // 지도의 중심좌표
                    level: 3 // 지도의 확대 레벨
                };

            // 지도를 생성합니다
            var map = new daum.maps.Map(mapContainer, mapOption);

            // 주소-좌표 변환 객체를 생성합니다
            var geocoder = new daum.maps.services.Geocoder();

            // 주소로 좌표를 검색합니다
            geocoder.addressSearch('<?=$brand['MAP_URL']?>', function(result, status) {

                // 정상적으로 검색이 완료됐으면
                if (status === daum.maps.services.Status.OK) {

                    var coords = new daum.maps.LatLng(result[0].y, result[0].x);
                    x = result[0].y;
                    y = result[0].x;

                    // 결과값으로 받은 위치를 마커로 표시합니다
                    var marker = new daum.maps.Marker({
                        map: map,
                        position: coords
                    });

                    var infowindow = new daum.maps.InfoWindow({
                        content: '<div style="width:250px;text-align:center;padding:6px 0;">' +
                        '<span style="font-weight:600;font-size:0.85rem;"><?=$brand['MAP_URL']?></span></div>'
                    });
                    infowindow.open(map, marker);

                    // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
                    map.setCenter(coords);

                    var path = 'https://map.kakao.com/link/to/<?=$brand['MAP_URL']?>' + ','+ x + ',' + y;

                    $("#path").attr("href",path);
                }
            });
        </script>

        <script src="/assets/js/common.js?ver=2.5"></script>
        <script src="/assets/js/owl.carousel.min.js?ver=2.5"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $(".pop-img-wrap").each(function() {
                    // 사진 슬라이드, 팝업
                    var popImg = $(this).find(".img-popup.owl-carousel");
                    var thumbs = $(this).find(".img-thumb.owl-carousel");
                    var syncedSecondary = true;

                    popImg.owlCarousel({
                        animateOut: 'fadeOut',
                        items: 1,
                        nav: true,
                        autoplay: false,
                        dots: false,
                        responsiveRefreshRate: 200
                    });

                    thumbs.on("initialized.owl.carousel", function() {
                        thumbs.find(".owl-item").eq(0).addClass("current");
                    }).owlCarousel({
                        items: 3,
                        dots: false,
                        nav: true,
                        autoplay: false,
                        slideBy: 3,
                        responsiveRefreshRate: 100
                    }).on("changed.owl.carousel", syncPosition2);

                    function syncPosition2(el) {
                        if (syncedSecondary) {
                            var number = el.item.index;
                            popImg.data("owl.carousel").to(number, 100, true);
                        }
                    }

                    thumbs.on("click", ".owl-item", function(e) {
                        e.preventDefault();
                        var number = $(this).index();
                        popImg.data("owl.carousel").to(number, 300, true);
                        popImg.css("display", "block");
                    });

                    $(this).find(".img-popup .btn-close").on("click", function(e) {
                        popImg.css("display", "none");
                    });
                });
            });

            //calculate image size
            function calcImgSize() {
                $("img", ".auto-img").each(function() {
                    var $el = $(this);
                    $el.parents(".img").addClass(function() {
                        var $height = $el.height();
                        var $width = $el.width();
                        if ($height > $width) return "port";
                        else return "land";
                    });
                });
            };
            //이미지가 모두 로드 된 후 실행
            jQuery.event.add(window,"load",function(){
                calcImgSize();
            });

            //tab3-area tab click function
            $(".tab-area .tabhead li a").click(function(){
                $(".tab-area .list").removeClass("on");
                var target = $(this).data("target");
                $("#"+target).addClass("on");

                $(".tab-area .tabhead li a").removeClass("on");
                $(this).addClass("on");

                return false;
            });

            // 탑버튼
            function topBtn (){
                var btn = $('#btnTop'),
                    deadLine = $('#footer').offset().top;
                var scrollFnc = function(){
                    deadLine = $('#footer').offset().top,
                        scrollTop = $(window).scrollTop();
                    if( scrollTop > 50 ) {
                        btn.stop().fadeIn();
                        if( scrollTop > deadLine - $(window).height()  ) {
                            btn.css({
                                'position' : 'absolute',
                                'bottom' : '',
                                'top' : deadLine - 55
                            });
                        } else {
                            btn.css({
                                'position' : 'fixed',
                                'top' : '',
                                'bottom' : '50px'
                            })
                        }
                    } else {
                        btn.stop().fadeOut();
                    }
                };
                $(window).on('scroll', scrollFnc);
                btn.on('click', function(){
                    $('html, body').animate({
                        scrollTop : 0
                    }, 'fast');
                });
                scrollFnc();
            }


            $(function(){
                topBtn();
                etahUi.layercontroller();
                etahUi.bottomLayercontroller();
                etahUi.bottomLayerOpen();
                etahUi.toggleMenu();
                etahUi.tabMenu();
                etahUi.cartOptionLayer();
                etahUi.listToggle();
                etahUi.filterLayer();
                etahUi.selectFun();
            });
        </script>

        <script src="/assets/js/categorySwipe.js"></script>
        <script src="/assets/js/areaSwipe.js"></script>
        <script>
            $(function(){
                $('#prdCategoryList, #prdPopularList, #prdPriceList').categorySwipe( function( ele ){
                    ele.css('display', 'none');
                } );

                $('.page-title').areaSwipe();
            })
        </script>

<!-- // 공방브랜드 페이지 -->

<!-- 일반브랜드 페이지 // -->
<?}

else{?>
        <div class="content srp_detail1">
            <!-- top-location -->
            <?if($srp != ''){?>
            <div class="page-title-box page-title-box--location">
                <div class="page-title">
                    <ul class="page-title-list">
                        <li class="page-title-item"><a href="/goods/search?keyword=<?=$keyword?>">검색결과</a></li>
                        <li class="page-title-item active">브랜드</li> <!-- 퐐성화시 클래스 active추가 -->
                    </ul>
                </div>
            </div>
            <?}?>
            <!-- //top-location -->

            <div class="brand_visual" style="background:url('<?=(!empty(@$brand['TITLE_BG_IMG_URL']))?@$brand['TITLE_BG_IMG_URL']:'/assets/images/brand/bg_brand_default.jpg'?>') repeat-x  0 0;">
                <h2 class="brand-each-title"><?=@$brand['BRAND_NM']?></h2>
            </div>
            <!-- ABOUT BRAND//-->
            <div class="about-brand-box">
                <h3 class="info-title info-title--big">ABOUT BRAND</h3>
                <div class="about-brand-logo"><?if(@$brand['MOB_BRAND_LOGO_URL']){?><img src="<?=$brand['MOB_BRAND_LOGO_URL']?>" alt="<?=$brand['BRAND_NM']?>" height='75px'/><?}else{echo @$brand['BRAND_NM'];}?></div>
                <p class="about-brand-txt"><?=@$brand['MOB_BRAND_DESC']?></p>
            </div>
            <!-- //ABOUT BRAND -->

            <!-- LOCATION// -->
        <!--    <? if(@$brand['MAP_URL']){ ?>
            <div class="location-box">
                <h3 class="info-title info-title--big">LOCATION</h3>
                <dl class="location-info-list">
                    <dt class="location-info-tlt">주소</dt>
                    <dd class="location-info-txt"><?=$brand['MAP_URL']?></dd>
                </dl>
            <?if($brand['MAP_URL']){?>
            <div class="brand_map location-map-img" style="width:100%">
                <div class="brand_map_image" id="map_view">
                </div>
            </div>
            <?}?>
            </div>
            <?}?> -->
            <!-- //LOCATION-->


            <!-- top-location -->
            <div class="page-title-box page-title-box--location">
                <div class="page-title">
                    <ul class="page-title-list">
                        <li class="page-title-item active">상품 <em class="bold_yel">(<?=$total_cnt?>)</em></li> <!-- 퐐성화시 클래스 active추가 -->
                    </ul>
                </div>
            </div>
            <!-- //top-location -->
            <!-- 필터 -->
            <div class="filter-list">
                <div class="filter-inner">
                    <div class="filter-item filter-option1">
                        <a href="#filterOptionBtn" class="filter-btn btn-gnb-open ranking-btn" data-ui="filter-btn">
                            <? switch ($order_by) {
                                case 'A':echo '인기순';break;
                                case 'B':echo '신상품순';break;
                                case 'C':echo '낮은가격순';break;
                                case 'D':echo '높은가격순';break;
                            } ?>
                        </a>
                    </div>

                    <div class="filter-item filter-check">
                        <a href="#filterOptionBtn" class="filter-btn btn-gnb-open" data-ui="filter-btn"><span class="spr-common spr-ico-filter"></span>상세검색</a>
                    </div>
                </div>
            </div>
            <div class="filter-gnb-list">

                <aside class="filter-gnb" style="margin-right: -300px;">
                    <form>
                        <p class="filter-gnb-tit">상세검색</p>
                        <button type="button" class="btn-close lg-w pop-close">close</button>
                        <!-- member -->

                        <!-- logined -->
                        <div class="filter-search">
                            <p class="search-result">검색결과 <span><?=$total_cnt?></span>개</p>
                            <input type="reset" class="btn-reset">
                        </div>
                        <!-- logined -->
                        <!-- //member -->

                        <!-- nav -->
                        <nav>

                            <!-- 카테고리 필터 -->
                            <div class="option_button position_area srp_option_area">
                                <div class="position_left">
                                    <div class="select_wrap select_wrap_cate">
                                        <h4 class="srp-cate-tit srp-cate-tit2">카테고리</h4>
                                        <ul id="srp-cate" class="srp-cate2">
                                            <li><a href="#" onclick="search_goods('C','');" <?=($cate_cd=='')?'class="on"':''?>>전체</a></li>
                                            <?foreach($arr_cate1 as $c1){?>
                                                <li <?=($cur_category['CATE_CD1']==$c1['CODE'])?'class="on"':''?>><a href="#none"><?=$c1['NAME']?></a>
                                                    <ul>
                                                        <?foreach($arr_cate2 as $c2){
                                                            if($c2['PARENT_CODE'] == $c1['CODE']){?>
                                                                <li><a href="#none" <?=($cur_category['CATE_CD2']==$c2['CODE'])?'class="on"':''?>><?=$c2['NAME']?></a>
                                                                    <ul>
                                                                        <?foreach($arr_cate3 as $c3){
                                                                            if($c3['PARENT_CODE'] == $c2['CODE']){?>
                                                                                <li><a href="#none" onclick="search_goods('C','<?=$c3['CODE']?>');" <?=($cur_category['CATE_CD3']==$c3['CODE'])?'class="on"':''?>><?=$c3['NAME']?></a></li>
                                                                            <?}
                                                                        }?>
                                                                    </ul>
                                                                </li>
                                                            <?}
                                                        }?>
                                                    </ul>
                                                </li>
                                            <?}?>
                                        </ul>
                                    </div>
                                    <div class="select_wrap select_wrap_cate">
                                        <h4 class="srp-cate-tit srp-cate-tit1">정렬</h4>
                                        <ul id="srp-cate" class="srp-cate1">
                                            <li>
                                                <a href="#none">
                                                    <label class="common-radio-label" for="ranking1">
                                                        <input type="radio" id="ranking1" class="common-radio-btn" name="order_by" value="A" <?=($order_by=='A')?'checked':''?>>
                                                        <span class="common-radio-text">인기순</span>
                                                    </label>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#none">
                                                    <label class="common-radio-label" for="ranking2">
                                                        <input type="radio" id="ranking2" class="common-radio-btn" name="order_by" value="B" <?=($order_by=='B')?'checked':''?>>
                                                        <span class="common-radio-text">신상품순</span>
                                                    </label>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#none">
                                                    <label class="common-radio-label" for="ranking3">
                                                        <input type="radio" id="ranking3" class="common-radio-btn" name="order_by" value="C" <?=($order_by=='C')?'checked':''?>>
                                                        <span class="common-radio-text">낮은가격순</span>
                                                    </label>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#none">
                                                    <label class="common-radio-label" for="ranking4">
                                                        <input type="radio" id="ranking4" class="common-radio-btn" name="order_by" value="D" <?=($order_by=='D')?'checked':''?>>
                                                        <span class="common-radio-text">높은가격</span>
                                                    </label>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="select_wrap select_wrap_cate">
                                        <h4 class="srp-cate-tit srp-cate-tit4">국가</h4>
                                        <ul id="srp-cate" class="srp-cate4">
                                            <?
                                            $srp_country = explode("|", substr($country,1));

                                            $cnidx = 1;
                                            foreach($arr_country as $key=>$value){?>
                                                <li class="checkbox_area country">
                                                    <a href="#none">
                                                        <input type="checkbox" class="checkbox" id="CountryCheck<?=$cnidx?>" name="country" value="<?=$key?>" <?=(in_array($key,$srp_country))?'checked':''?>>
                                                        <label class="checkbox_label" for="CountryCheck<?=$cnidx?>"><?=$value['NM']?></label>
                                                    </a>
                                                </li>
                                                <?$cnidx++;
                                            }
                                            ?>
                                        </ul>
                                    </div>

                                    <div class="select_wrap select_wrap_cate">
                                        <h4 class="srp-cate-tit srp-cate-tit3">배송</h4>
                                        <ul id="srp-cate" class="srp-cate3">
                                            <li>
                                                <a href="#none" class="free-deli">
                                                    <label class="common-radio-label" for="free-deli1">
                                                        <input type="radio" id="free-deli1" class="common-radio-btn" name="deliv_type" value="" <?=($deliv_type=='')?'checked':''?>>
                                                        <span class="common-radio-text">전체</span>
                                                    </label>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#none" class="free-deli">
                                                    <label class="common-radio-label" for="free-deli2">
                                                        <input type="radio" id="free-deli2" class="common-radio-btn" name="deliv_type" value="FREE" <?=($deliv_type=='FREE')?'checked':''?>>
                                                        <span class="common-radio-text">무료배송만</span>
                                                    </label>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="select_wrap select_wrap_cate">
                                        <h4 class="srp-cate-tit srp-cate-tit5">가격</h4>
                                        <?
                                        $price_min = min($arr_sellingPrice);
                                        $price_max = max($arr_sellingPrice);

                                        //최소값, 최대값 재설정
                                        if ($price_min < 10000) $price_min = 1000; //1천원

                                        if ($price_max > 300000) $price_min = 100000;    //10만원
                                        if ($price_max > 3000000) $price_min = 1000000;   //100만원

                                        //기준금액단위 설정
                                        if( (($price_max - $price_min) > 3000000) && ($price_min > 1000000) ) {
                                            $limit = 1000000; //100만원
                                        } else if( (($price_max - $price_min) > 300000) && ($price_min > 100000) ){
                                            $limit = 100000; //10만원
                                        } else if( (($price_max - $price_min) < 30000)){
                                            $limit = 5000; //5천원
                                        } else {
                                            $limit = 10000; //1만원
                                        }

                                        $price_min = ceil($price_min / $limit) * $limit;
                                        $price_max = floor($price_max / $limit) * $limit;

                                        $price_range = ($price_max - $price_min) / 3;
                                        $price_range = floor($price_range / $limit) * $limit;
                                        ?>
                                        <ul id="srp-cate" class="srp-cate5">
                                            <??>
                                            <li class="checkbox_area country">
                                                <a href="#none">
                                                    <label class="common-radio-label" for="price0">
                                                        <input type="radio" id="price0" class="common-radio-btn" name="price_limit" value="" <?=($price_limit=='')?'checked':''?>>
                                                        <span class="common-radio-text">전체</span>
                                                    </label>
                                                </a>
                                            </li>
                                            <li class="checkbox_area country">
                                                <a href="#none">
                                                    <label class="common-radio-label" for="price1">
                                                        <?$range = '|'.(string)$price_min?>
                                                        <input type="radio" id="price1" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                        <span class="common-radio-text"><?=number_format($price_min)?>원 이하</span>
                                                    </label>
                                                </a>
                                            </li>
                                            <li class="checkbox_area country">
                                                <?$range = (string)$price_min.'|'.(string)($price_min+($price_range*1))?>
                                                <a href="#none">
                                                    <label class="common-radio-label" for="price2">
                                                        <input type="radio" id="price2" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                        <span class="common-radio-text"><?=number_format($price_min)?>원 ~ <?=number_format($price_min+($price_range*1))?>원</span>
                                                    </label>
                                                </a>
                                            </li>
                                            <li class="checkbox_area country">
                                                <a href="#none">
                                                    <label class="common-radio-label" for="price3">
                                                        <?$range = (string)$price_min+($price_range*1).'|'.(string)($price_min+($price_range*2))?>
                                                        <input type="radio" id="price3" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                        <span class="common-radio-text"><?=number_format($price_min+($price_range*1))?>원 ~ <?=number_format($price_min+($price_range*2))?>원</span>
                                                    </label>
                                                </a>
                                            </li>
                                            <li class="checkbox_area country">
                                                <a href="#none">
                                                    <label class="common-radio-label" for="price4">
                                                        <?$range = (string)($price_min+($price_range*2)).'|'.(string)($price_min+($price_range*3))?>
                                                        <input type="radio" id="price4" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                        <span class="common-radio-text"><?=number_format($price_min+($price_range*2))?>원 ~ <?=number_format($price_min+($price_range*3))?>원</span>
                                                    </label>
                                                </a>
                                            </li>
                                            <li class="checkbox_area country">
                                                <a href="#">
                                                    <label class="common-radio-label" for="price5">
                                                        <?$range = (string)($price_min+($price_range*3)).'|'?>
                                                        <input type="radio" id="price5" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                        <span class="common-radio-text"><?=number_format($price_min+($price_range*3))?>원 이상</span>
                                                    </label>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- //카테고리 필터 -->

                            <!-- //shoping guide -->
                            <div class="confirm">
                                <button class="confirm" onclick="search_goods('', ''); return false;">확인</button>
                            </div>
                        </nav>
                        <!-- //nav -->
                    </form>
                </aside>

            </div>
            <!-- // 필터 -->


            <!-- 상품리스트// -->
            <div class="prd-list-wrap">
                <ul class="prd-list prd-list--modify">
                <? foreach($goods as $row){?>
                    <li class="prd-item">
                        <div class="pic">
                            <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                                <div class="item auto-img">
                                    <div class="img">
                                        <img src="<?=$row['IMG_URL']?>" alt="">
                                    </div>
                                </div>
                                <div class="tag-wrap">
                                    <?if(isset($row['GOODS_PRIORITY'])){?>
                                        <!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>-->
                                    <?}?>
                                </div>
                            </a>
                        </div>
                        <div class="prd-info-wrap">
                            <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                                <dl class="prd-info">
                                    <dt class="prd-item-brand"><?=$row['BRAND_NM']?></dt>
                                    <dd class="prd-item-tit"><?=$row['GOODS_NM']?></dd>
                                    <dd class="prd-item-price">
                                        <? if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                            $price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S'] + $row['RATE_PRICE_G']) - ($row['AMT_PRICE_S'] + $row['AMT_PRICE_G']);
                                            echo number_format($price);

                                            /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                            $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                            $sale_percent = strval($sale_percent);
                                            $sale_percent_array = explode('.',$sale_percent);
                                            $sale_percent_string = $sale_percent_array[0];
                                            ?>
                                            <del class="del-price"><?=number_format($row['SELLING_PRICE'])?></del>
                                            <!--<span class="dc-rate">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100)?>%<span class="spr-common ico-arrow-down"></span>)</span>-->
                                            <span class="dc-rate">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common ico-arrow-down"></span>)</span>
                                        <?} else {
                                            echo number_format($price = $row['SELLING_PRICE']);
                                        }?>
                                    </dd>
                                </dl>
                                <ul class="prd-label-list">
                                    <?if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){?>
                                        <li class="prd-label-item">쿠폰할인</li>
                                    <?} if(($row['PATTERN_TYPE_CD'] == 'FREE') || ( $row['DELI_LIMIT'] > 0 && $price > $row['DELI_LIMIT'])) {?>
                                        <li class="prd-label-item free_shipping">무료배송</li>
                                    <?} if($row['GOODS_MILEAGE_SAVE_RATE'] > 0){?>
                                        <li class="prd-label-item">마일리지</li>
                                    <?}?>
                                </ul>
                            </a>
                        </div>
                    </li>
                <?}?>
                </ul>
            </div>
            <!-- //상품리스트-->

            <!--페이징//-->
            <?=$pagination?>
            <!-- //페이징 -->

            <!-- 공유하기 레이어 // -->
            <div id="share_sns"></div>
            <!-- // 공유하기 레이어 -->


            <script src="/assets/js/common.js?ver=2.5"></script>
            <script>
                /* lnb */
                (function($) {
                    var lnbUI = {
                        click: function(target, speed) {
                            var _self = this,
                                $target = $(target);
                            _self.speed = speed || 300;
                            $target.each(function() {
                                if (findChildren($(this))) {
                                    return;
                                }
                                $(this).addClass('noDepth');
                            });

                            function findChildren(obj) {
                                return obj.find('> ul').length > 0;
                            }
                            $target.on('click', 'a', function(e) {
                                e.stopPropagation();
                                var $this = $(this),
                                    $depthTarget = $this.next(),
                                    $siblings = $this.parent().siblings();
                                $this.parent('li').find('ul li').removeClass('on');
                                $siblings.removeClass('on');
                                $siblings.find('ul').slideUp(250);
                                if ($depthTarget.css('display') == 'none') {
                                    _self.activeOn($this);
                                    $depthTarget.slideDown(_self.speed);
                                } else {
                                    $depthTarget.slideUp(_self.speed);
                                    _self.activeOff($this);
                                }
                            })
                        },
                        activeOff: function($target) {
                            $target.parent().removeClass('on');
                        },
                        activeOn: function($target) {
                            $target.parent().addClass('on');
                        }
                    }; // Call lnbUI
                    $(function() {
                        lnbUI.click('#srp-cate li', 300)
                    });
                }(jQuery));
            </script>
        <script type="text/javascript">

        //			var map = "<?//=$brand['MAP_URL']?>//";
        //			if(gubun == "Y") $("#brand_product").attr("tabindex", -1).focus();

                //지도 삽입
        //			if(map != ""){
        //				create_map();
        //			}

                //====================================
                // 지도 생성
                //====================================
        //			function create_map(){
        //				var HOME_PATH = window.HOME_PATH || 'https://navermaps.github.io/maps.js/docs';
        //
        //				var point_x = "<?//=$map['x']?>//",
        //					point_y = "<?//=$map['y']?>//",
        //					position = new naver.maps.LatLng(point_y, point_x),
        //					mapOptions = {	center: position.destinationPoint(0, 300),
        //									size : new naver.maps.Size($(window).width()-25, 338),
        //									zoom: 10,
        //									minZoom: 1, //지도의 최소 줌 레벨
        //									zoomControl: true, //줌 컨트롤의 표시 여부
        //									zoomControlOptions: { //줌 컨트롤의 옵션
        //										position: naver.maps.Position.TOP_LEFT
        //									}
        //								};
        //
        //
        //				var map = new naver.maps.Map('map_view', mapOptions);
        //
        //				//setOptions 메서드를 통해 옵션을 조정할 수도 있습니다.
        //				map.setOptions("mapTypeControl", true); //지도 유형 컨트롤의 표시 여부
        //
        //				var markerOptions = {
        //					position: position,
        //					map: map,
        //					icon: {
        //						url: HOME_PATH +'/img/example/pin_default.png',
        //						size: new naver.maps.Size(22, 35),
        //						origin: new naver.maps.Point(0, 0),
        //						anchor: new naver.maps.Point(11, 35)
        //					},
        //					shadow: {
        //						url: HOME_PATH +'/img/example/shadow-pin_default.png',
        //						size: new naver.maps.Size(40, 35),
        //						origin: new naver.maps.Point(0, 0),
        //						anchor: new naver.maps.Point(11, 35)
        //					},
        //					animation: naver.maps.Animation.BOUNCE
        //				};

        //				alert(HOME_PATH);

        //				// min/max 줌 레벨
        //				$("#min-max-zoom").on("click", function(e) {
        //					e.preventDefault();
        //
        //					if (map.getOptions("minZoom") === 10) {
        //						map.setOptions({
        //							minZoom: 1,
        //							maxZoom: 14
        //						});
        //						$(this).val(this.name + ': 1 ~ 14');
        //					} else {
        //						map.setOptions({
        //							minZoom: 10,
        //							maxZoom: 12
        //						});
        //						$(this).val(this.name + ': 10 ~ 12');
        //					}
        //				});
        //
        //				var marker = new naver.maps.Marker(markerOptions);
        //
        //				var contentString = [
        //						'<div class="iw_inner"  style="width:100%; height:100%; margin-top:2px; margin-left:8px; margin-right:8px; margin-bottom:2px;" >',
        //						'   <b><h3 style="font-size:10pt;"><?//=$brand["BRAND_NM"]?>//</h3></b>',
        //						'   <p><?//=$brand["MAP_URL"]?>//<br />',
        //						'   </p>',
        //						'</div>'
        //					].join('');
        //
        //				var infowindow = new naver.maps.InfoWindow({
        //					content: contentString
        //				});
        //
        //				naver.maps.Event.addListener(marker, "click", function(e) {
        //					if (infowindow.getMap()) {
        //						infowindow.close();
        //					} else {
        //						infowindow.open(map, marker);
        //					}
        //				});
        //
        //				infowindow.open(map, marker);


        //			}

        //====================================
        // 조건별 검색
        //====================================
        function search_goods(kind, val)
        {
            var page		= '<?=$page?>';
            var	brand_cd	= '<?=$brand_cd?>';
            var srp         = '<?=$srp?>';

            var cate_gb     = '<?=$cate_gb?>';
            var cate_cd     = '<?=$cate_cd?>';
            var order_by    = '';
            var country     = '';
            var deliv_type  = '';
            var price_limit = '';

            //카테고리
            if(kind='C'){
                cate_cd = val;
            }

            //정렬
            order_by = $('input[name=order_by]:checked').val();

            //국가
            $("input[name=country]:checked").each(function() {
                country += '|'+$(this).val();
            });

            //배송
            deliv_type = $('input[name=deliv_type]:checked').val();

            //가격
            price_limit = $('input[name=price_limit]:checked').val();


            document.location.href = "/goods/brand/"+brand_cd+"/"+page+"?srp="+srp+"&cate_cd="+cate_cd+"&cate_gb="+cate_gb+"&price_limit="+price_limit+"&order_by="+order_by+"&country="+country+"&deliv_type="+deliv_type;

        }

        </script>
        <!--GA script-->
        <script>
        //Impression
        //ga('require', 'ecommerce', 'ecommerce.js');
        <?//foreach ($goods as $grow){?>
        //ga('ecommerce:addImpression', {
        //    'id': <?//=$grow['GOODS_CD']?>//,                   // Product details are provided in an impressionFieldObject.
        //    'name': "<?//=$grow['GOODS_NM']?>//",
        //    'brand': '<?//=$grow['BRAND_NM']?>//',
        //    'list': 'Mob_Brand_shop Results'
        //});
        <?//}?>
        //ga('ecommerce:send');
        //
        ////action
        //function onProductClick(param,param2) {
        //    var goods_cd = param;
        //    var goods_nm = param2;
        //    ga('ecommerce:addProduct', {
        //        'id': goods_cd,
        //        'name': goods_nm
        //    });
        //    ga('ecommerce:setAction', 'click', {list: 'Mob_Brand_shop Results'});
        //
        //    // Send click with an event, then send user to product page.
        //    ga('send', 'event', 'UX', 'click', 'Results', {
        //        hitCallback: function() {
        //            //alert(goods_cd + '/' + goods_nm);
        //            document.location = '/goods/detail/'+goods_cd;
        //        }
        //    });
        //}
        </script>
        <!--/GA script-->
<?}?>
<!-- // 일반브랜드 페이지 -->