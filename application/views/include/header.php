<!DOCTYPE html>
<html id="etah_html" lang="ko-KR">

<?
?>
<head>
    <title>ETAHOME MOBILE</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="홈&펫&직구, 국내부터 해외까지 가구/소품/주방 등 홈퍼니싱 전문 온라인샵!">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="canonical" href="http://m.etahome.co.kr/">
    <?
    $uri_val = $this->uri->segment(1, 0);
    $uri_val .= "/".$this->uri->segment(2, 0);

    $description	= "";
    $metaOgTitle	= "ETAHOME";
    $metaOgUrl		= current_url();
//    $metaOgImg		= "http://www.etah.co.kr/assets/images/common/etah_image.png";
    $metaOgImg		= "http://ui.etah.co.kr/assets/images/data/etah_image.png";

    if($uri_val){
        switch($uri_val) {
            case 'goods/detail':
                $metaOgTitle = "[".@$goods['BRAND_NM']."] ".@$goods['GOODS_NM'];
                $metaOgImg = @$goods['IMG_URL'];
                break;

            case 'magazine/detail':
                $metaOgTitle = @$detail['TITLE'];
                $metaOgImg = @$detail['MOB_IMG_URL'];
                break;

            case 'goods/brand':
                $metaOgTitle = @$brand['BRAND_NM'];
                $metaOgImg = (@$brand['MOB_BRAND_IMG_URL']==''?@$brand['BANNER_IMG_URL']:@$brand['MOB_BRAND_IMG_URL']);
                break;

            case 'goods/event':
                $metaOgTitle = @$event['TITLE'];
                $metaOgImg = @$event['EVENT_IMG_URL'];
                break;

            default	:
                break;
        }
    }

    if($metaOgImg == '') {/*$metaOgImg = "http://www.etah.co.kr/assets/images/common/etah_image.png";*/$metaOgImg = "http://ui.etah.co.kr/assets/images/data/etah_image.png";}
    ?>
    <meta property="og:title"           content="<?=$metaOgTitle?>"/>
    <meta property="og:type"            content="website"/>
    <meta property="og:url"             content="<?=$metaOgUrl?>"/>
    <meta property="og:image"           content="<?=$metaOgImg?>"/>
    <meta property="og:site_name"       content="ETAHOME"/>
    <meta property="fb:app_id"          content=""/>
    <meta property="og:description"     content="홈&펫&직구, 국내부터 해외까지 가구/소품/주방 등 홈퍼니싱 전문 온라인샵!">


    <!--    <meta name="naver-site-verification" content="54a86b68cc34cc4188be49ba4ad9fcf4dbd1827d"/>-->
    <meta name="naver-site-verification" content="73746fe4565e9c13ab3b0443ab5671f7a6c8252c"/>

    <link rel="stylesheet" type="text/css" href="/assets/css/owl.carousel.min.css?ver=1.3">
    <link rel="stylesheet" href="/assets/css/common.css?ver=2.6.8">

    <link rel="shortcut icon" href="https://s3.ap-northeast-2.amazonaws.com/ui.etah.co.kr/favicon.ico">
    <link rel="apple-touch-icon" href="https://s3.ap-northeast-2.amazonaws.com/ui.etah.co.kr/favicon.png">
    <link rel="apple-touch-icon" href="https://s3.ap-northeast-2.amazonaws.com/ui.etah.co.kr/favicon-60.png"><!-- 비 레티나 -->
    <link rel="apple-touch-icon" sizes="76x76" href="https://s3.ap-northeast-2.amazonaws.com/ui.etah.co.kr/favicon-76.png"><!-- 아이패드 -->
    <link rel="apple-touch-icon" sizes="120x120" href="https://s3.ap-northeast-2.amazonaws.com/ui.etah.co.kr/favicon-60@2x.png"><!-- 레티나 기기 -->
    <link rel="apple-touch-icon" sizes="152x152" href="https://s3.ap-northeast-2.amazonaws.com/ui.etah.co.kr/favicon-76@2x.png"><!-- 레티나 패드 -->
    <link rel="apple-touch-icon-precomposed" href="https://s3.ap-northeast-2.amazonaws.com/ui.etah.co.kr/favicon-60.png"><!-- 구형/ 안드로이드 -->
    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic|Noto+Sans+KR|Nanum+Myeongjo|Nanum+Gothic+Coding|Do+Hyeon|Jua" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
    <script src="/assets/js/common.js?ver=1.3.1"></script>
    <script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>

    <span itemscope="" itemtype="http://schema.org/Organization">
        <link itemprop="url" href="<?=base_url()?>">
        <a itemprop="sameAs" href="https://blog.naver.com/etah_blog"></a>
        <a itemprop="sameAs" href="https://www.instagram.com/etahcompany/"></a>
        <a itemprop="sameAs" href="https://www.facebook.com/etahcompany"></a>
        <a itemprop="sameAs" href="https://www.youtube.com/channel/UCVEBa0D-0coHeJu9LYO5l0Q?view_as=subscriber"></a>
    </span>

    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: none; opacity: 0.7; background-color: #ddd; z-index: 9999}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 9999}
    </style>
    <!-- Global site tag (gtag.js) - Google Analytics 2018.06.01-->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-120204887-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-120204887-1');
    </script>
    <!--<script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-120204887-1', 'auto');
        ga('send', 'pageview');
    </script>-->
    <!--네이버 애널리틱스 스크립트 -->
    <script type="text/javascript" src="https://wcs.naver.net/wcslog.js"></script>
    <script type="text/javascript">
        if(!wcs_add) var wcs_add = {};
        wcs_add["wa"] = "47933926cdee40";
        wcs_do();
    </script>

    <!--네이버 페이 스크립트 추가 2019.11.28 -->
    <script type="text/javascript" src="https://wcs.naver.net/wcslog.js"></script>
    <script type="text/javascript">
        if(!wcs_add) var wcs_add = {};

        wcs_add["wa"] = "s_51fd0fb4ae2b";
        wcs.inflow("etahome.co.kr");
    </script>
    <script type="text/javascript">
        var HOST = "<?=$_SERVER['HTTP_HOST'] ?>";
        var URI= "<?= $_SERVER['REQUEST_URI'] ?>";
        var PHP_SELF = "<?= $_SERVER['PHP_SELF'] ?>";
        var mobileKeyWords = new Array('iPhone', 'iPod', 'BlackBerry', 'Android', 'Windows CE', 'LG', 'MOT', 'SAMSUNG', 'SonyEricsson','iPad','MI','hp-tablet');
        var cnt =0;
        for (var word in mobileKeyWords) {
            cnt = cnt + 1;
            if(cnt == 1){
                if (navigator.userAgent.match(mobileKeyWords[word]) != null){
                    if(HOST == "stagingm.etah.co.kr") {
                        //스테이징은 테스트용이니 그냥 카테고리 상관없이 보내기
                        if(URI != "") {location.href = "http://stagingm.etah.co.kr" + URI;}
                        else {location.href = "http://stagingm.etah.co.kr/";}
                    } else if(HOST == "m.etah.co.kr" || HOST == "www.etah.co.kr") {
                        if(PHP_SELF != "") {
                            if(PHP_SELF == '/index.php/category/main/10000000') URI = '/category/main?cate_cd=10000000';
                            else if(PHP_SELF == '/index.php/goods/mid_list/20010000') URI = '/category/main?cate_cd=20000000';
                            else break;

                            location.href = "https://m.etahome.co.kr" + URI;
                        } else {
                            location.href = "https://m.etahome.co.kr";
                        }
                    } else if (HOST == "m.etahome.co.kr" || HOST == "www.etahome.co.kr" ) {
                        //아직 도메인 변경 전, 포워딩 적용되서 etahome으로 들어가도 etah.co.kr 로 들어가짐
                        //도메인이 변경 되면, 그 때 부터 적용 되게 할 로직
                        if(PHP_SELF != "") {
                            if(PHP_SELF == '/index.php/category/main/10000000') URI = '/category/main?cate_cd=10000000';
                            else if(PHP_SELF == '/index.php/goods/mid_list/20010000') URI = '/category/main?cate_cd=20000000';
                            else if(PHP_SELF == '/index.php/category/main/20000000') URI = '/category/main?cate_cd=20000000';
                            else break;

                            location.href = "https://m.etahome.co.kr" + URI;
                        } else {
                            location.href = "https://m.etahome.co.kr";
                        }
                    }  else if ( HOST == "stagingm.etahome.co.kr" ) {
                        //아직 도메인 변경 전, 포워딩 적용되서 etahome으로 들어가도 etah.co.kr 로 들어가짐
                        //도메인이 변경 되면, 그 때 부터 적용 되게 할 로직
                        if(PHP_SELF != "") {
                            if(PHP_SELF == '/index.php/category/main/10000000') URI = '/category/main?cate_cd=10000000';
                            else if(PHP_SELF == '/index.php/goods/mid_list/20010000') URI = '/category/main?cate_cd=20000000';
                            else break;

                            location.href = "http://stagingm.etahome.co.kr" + URI;
                        } else {
                            location.href = "http://stagingm.etahome.co.kr";
                        }
                    }
                }else{
                    if(HOST == "stagingm.etah.co.kr") {
                        //스테이징은 테스트용이니 그냥 카테고리 상관없이 보내기
                        if(URI != "") {location.href = "http://stagingm.etah.co.kr" + URI;}
                        else {location.href = "http://stagingm.etah.co.kr/";}
                    } else if(HOST == "m.etah.co.kr" || HOST == "www.etah.co.kr") {
                        if(PHP_SELF != "") {
                            if(PHP_SELF == '/index.php/category/main/10000000') URI = '/category/main?cate_cd=10000000';
                            else if(PHP_SELF == '/index.php/goods/mid_list/20010000') URI = '/category/main?cate_cd=20000000';
                            else if(PHP_SELF == '/index.php/category/main/20000000') URI = '/category/main?cate_cd=20000000';
                            else break;
                            location.href = "https://m.etahome.co.kr" + URI;
                        } else {
                            location.href = "https://m.etahome.co.kr";
                        }
                    } else if (HOST == "m.etahome.co.kr" || HOST == "www.etahome.co.kr" ) {
                        //아직 도메인 변경 전, 포워딩 적용되서 etahome으로 들어가도 etah.co.kr 로 들어가짐
                        //도메인이 변경 되면, 그 때 부터 적용 되게 할 로직
                        if(PHP_SELF != "") {
                            if(PHP_SELF == '/index.php/category/main/10000000') URI = '/category/main?cate_cd=10000000';
                            else if(PHP_SELF == '/index.php/goods/mid_list/20010000') URI = '/category/main?cate_cd=20000000';
                            else if(PHP_SELF == '/index.php/category/main/20000000') URI = '/category/main?cate_cd=20000000';
                            else break;
                            location.href = "https://m.etahome.co.kr" + URI;
                        } else {
                            location.href = "https://m.etahome.co.kr";
                        }
                    }  else if ( HOST == "stagingm.etahome.co.kr" ) {
                        //아직 도메인 변경 전, 포워딩 적용되서 etahome으로 들어가도 etah.co.kr 로 들어가짐
                        //도메인이 변경 되면, 그 때 부터 적용 되게 할 로직
                        if(PHP_SELF != "") {
                            if(PHP_SELF == '/index.php/category/main/10000000') URI = '/category/main?cate_cd=10000000';
                            else if(PHP_SELF == '/index.php/goods/mid_list/20010000') URI = '/category/main?cate_cd=20000000';
                            else if(PHP_SELF == '/index.php/category/main/20000000') URI = '/category/main?cate_cd=20000000';
                            else break;
                            location.href = "http://stagingm.etahome.co.kr" + URI;
                        } else {
                            location.href = "http://stagingm.etahome.co.kr";
                        }
                    }
                }
            }
        }
    </script>
</head>

<body data-showroom="true" data-collection="true" data-newitem="true">

<div id="loading">
    <img id="loading-image" src="/assets/js2/loading.gif" width="150" alt="Loading..." />
</div>
<div class="wrap <?=isset($add_wrap) ? $add_wrap : ''?>" id="wrap">
    <!-- 카테고리 오픈시 category-open 클래스 추가 -->
    <div class="header" id="header">
        <div class="header-menu">
            <h1 class="header-logo spr-common"><a href="/"><span class="hide">etah everything about home.</span></a></h1>
            <div class="header-search">
                <form action="">
                    <label><input type="search" id="searchVal" onkeypress="javascript:if(event.keyCode == 13){ search(''); return false;}" class="header-search-input" value="<?=@$search_gb?@$search_gb:''?>"></label>
                    <button type="button" onClick="javascript:search('');"  class="header-search-btn"><span class="hide">검색하기</span></button>
                </form>
            </div>
            <ul class="header-menu-list">
                <li class="header-menu-item">
                    <a href="/cart" class="header-menu-link ico-common-cart spr-common">
                        <span class="hide">장바구니</span>
                        <span class="nav-top-num"><?=$cart_cnt?></span>
                    </a>
                </li>
                <li class="header-menu-item">
                    <a href="/main/menu" class="header-menu-link btn-category"><span class="hide">카테고리페이지가기</span></a>
                </li>
            </ul>
        </div>
        <? if(!isset($header_gb)) { ?>
            <div class="gnb">
                <ul class="gnb-list owl-carousel gnb-owl-nav">
                    <!-- 활성화 됐을때 클래스 active 추가 -->

                    <li class="gnb-item gnb-item--magazine"><a href="/magazine" class="gnb-link ico1 <?=isset($bar_magazine) ? 'active' : ''?>">컨텐츠</a></li>
                    <li class="gnb-item gnb-item--thechoice"><a href="/goods/best_item" class="gnb-link <?=isset($bar_best) ? 'active' : ''?>">베스트</a></li>
                    <li class="gnb-item gnb-item--best"><a href="/goods/event/586" class="gnb-link <?=isset($bar_deal) ? 'active' : ''?>">특가</a></li>
                    <li class="gnb-item gnb-item--magazine"><a href="/category/main?cate_cd=20000000" class="gnb-link ico1">직구샵</a></li>
                    <li class="gnb-item gnb-item--magazine"><a href="/category/main?cate_cd=18000000" class="gnb-link">펫</a></li>
                    <!--<li class="gnb-item gnb-item--home"><a href="/goods/event/234" class="gnb-link <?/*=isset($bar_md) ? 'active' : ''*/?>">MD 픽!</a></li>
                    <li class="gnb-item gnb-item--magazine"><a href="/category/main?cate_cd=24000000" class="gnb-link ico1">에타클래스</a></li>
                    <li class="gnb-item gnb-item--best"><a href="/goods/special" class="gnb-link <?/*=isset($bar_special) ? 'active' : ''*/?>">클러프트관</a></li>-->
                </ul>
            </div>
        <? }?>
    </div>

    <script src="/assets/js/owl.carousel.min.js"></script>
    <script type="text/javascript">
        //GNB 슬라이드
        $(".gnb-list").owlCarousel({
            items: 3,
            autoWidth: true,
            loop: false,
            margin: 15,
            nav: true,
            dots: false,
            smartSpeed: 200,
            responsive:{
                0:{
                    items: 3
                },
                500:{
                    items: 5,
                    center: false,
                    loop: false
                }
            }
        });
        //=======================================
        // trim 함수
        //=======================================
        function trim(s){
            s = s.replace(/^\s*/,'').replace(/\s*$/,'');
            return s;
        }
        //=====================================
        // action 클릭시	/* 모바일 버젼은 /include/share_sns.php 에서 이루어짐. 해당 함수 사용 X */
        //=====================================
        function jsGoodsAction(mode, share, val, img, title){
            var SESSION_ID	= "<?=$this->session->userdata('EMS_U_ID_')?>";
            //CART 담기
            if(mode == 'C'){
            }
            //WISH LIST 담기
            else if(mode == 'W'){
                if(SESSION_ID == ''||SESSION_ID == 'GUEST'){
                    if(confirm("로그인 후에 이용하실 수 있습니다. 로그인 하시겠습니까?")){
                        location.href = "https://<?=$_SERVER['HTTP_HOST']?>/member/login";
                        return false;
                    }else{
                        return false;
                    }
                }
                $.ajax({
                    type: 'POST',
                    url: '/goods/goods_action',
                    dataType: 'json',
                    data: {	mode : mode, goods_cd : val },
                    error: function(res) {
                        alert('Database Error');
                    },
                    success: function(res) {
                        if(res.status == 'ok'){
                            alert('관심상품에 등록되었습니다.');
                            location.reload();
                        }
                        else{
                            if(res.message) alert(res.message);
                        }
                    }
                })
            }
            //SNS 공유
            else if(mode == 'S'){//사용 안하는 것 같음 => 확인 하기
                var url = '<?=base_url()?>goods/detail/'+val;
                //페이스북
                if(share == 'F'){
                    window.open('/goods/share_facebook?title='+title+'&img='+img+'&goods_code='+val,"","width=550, height=300, status=yes, resizable=yes, scrollbars=no");
                }
                //인스타그램
                else if(share == 'I'){}
                //카카오스토리
                else if(share == 'K'){
                    shareStory(url,encodeURIComponent(title));
                }
                //핀터레스트
                else if(share == 'P'){
                    window.open("http://www.pinterest.com/pin/create/button/?url="+url+"&media="+img+"&description="+"[ETAHOME] "+encodeURIComponent(title),"","width=800, height=300, status=yes, resizable=no, scrollbars=no");
                }


            }
        }
        //=====================================
        // 카카오스토리 공유하기
        //=====================================
        function shareStory(url, text) {
            Kakao.Story.share({
                url: url,
                text: text
            });
        }
        function jsUrlCopy(url)
        {
            window.clipboardData.setData('Text',url);
        }
        //=====================================
        // 검색
        //=====================================
        function search(val)
        {
            var keyword = document.getElementById("searchVal").value;
            var cate_cd = "";
            var type	= "srp";

            if(!trim(keyword)) return false;

            var param = "";
            param += "keyword="		+ keyword;
//            param += "&cate_cd="	+ cate_cd;
//            param += "&type="		+ type;

            document.location.href = "/goods/search?"+param;

        }
        //====================================
        // 공유하기 레이어
        //====================================
        function openShareLayer(gubun, code, img, name, addInfo){

            $.ajax({
                type: 'POST',
                url: '/main/layer_share',
                dataType: 'json',
                data: { gubun : gubun,
                    code : code,
                    name : name,
                    img	: img,
                    addInfo : addInfo
                },
                error: function(res) {
                    alert('Database Error');
                },
                async : false,
                success: function(res) {
                    if(res.status == 'ok'){
                        $("#share_sns").html(res.share);

                    }
                    else alert(res.message);
                }
            });
            $('#layerSnsShare').addClass('layer-wrap--view');
            $('#wrap').addClass('layer-open');
        }
    </script>

