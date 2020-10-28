<!DOCTYPE html>
<html id="etah_html" lang="ko-KR">

<head>
    <title>ETAH MOBILE</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <? if( !isset( $footer_gb ) || !$footer_gb == 'detail'){	?>
        <meta id="web_image" property="og:image" content="http://www.etah.co.kr/assets/images/common/etah_image.png" />
    <? }?>
    <meta property="og:type"                content="website">
    <meta property="og:title"               content="ETAHOME">
    <meta property="og:description"         content="홈&펫&직구, 국내부터 해외까지 가구/소품/주방 등 홈퍼니싱 전문 온라인샵!">
    <meta property="og:url"                 content="http://www.etahome.co.kr/">

    <meta name="naver-site-verification" content="54a86b68cc34cc4188be49ba4ad9fcf4dbd1827d"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="http://ui.etah.co.kr/mobile/assets/css/common.css">
    

    <link rel="shortcut icon" href="/favicon.ico">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
    <script src="/assets/js/common.js"></script>
    <script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>

    <!--Instargam.-->
    <script type="text/javascript">

        var token = '4543432365.d78a785.199cb6e0c0b74b5ca3493f6f9bad7149', // access token.
            userid = 4543432365, // User ID - get it in source HTML of your Instagram profile or look at the next example :)
            num_photos = 6; // how much photos do you want to get

        $.ajax({
            url: 'https://api.instagram.com/v1/users/' + userid + '/media/recent', // or /users/self/media/recent for Sandbox
            dataType: 'jsonp',
            type: 'GET',
            data: {access_token: token, count: num_photos},
            success: function(data){
                console.log(data);
                $("#instafeed-gallery-feed").append('<ul class="instagram-banner-list">');
                for( x in data.data ){
                    $("#instafeed-gallery-feed").append('<li style="margin-right: 1.1px; margin-left: 1.1px; " class="instagram-banner-item">' +
                        '<a class="instagram-banner-link" href="'+data.data[x].link+'">'+
                        '<img  src="'+data.data[x].images.thumbnail.url+'">' + '</a>'+
                        '</li>');
                    // data.data[x].images.low_resolution.url - URL of image, 306х306
                    // data.data[x].images.thumbnail.url - URL of image 150х150  썸네일 이미지
                    // data.data[x].images.standard_resolution.url - URL of image 612х612   기본 이미지
                    // data.data[x].link - Instagram post URL   인스타그램 사진 URL
                }
                $("#instafeed-gallery-feed").append('</ul>');
            },
            error: function(data){
                console.log(data); // send the error notifications to console
            }
        });
    </script>
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: none; opacity: 0.7; background-color: #ddd; z-index: 9999}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 9999}
    </style>

    <!-- Google Tag Manager :: 2017-02-14 -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-TBX6BHL');</script>
    <!-- End Google Tag Manager -->

    <!-- 네이버 애널리틱스 스크립트 :: 2017-02-14 -->
    <script type="text/javascript" src="https://wcs.naver.net/wcslog.js"></script>
    <script type="text/javascript">
        if(!wcs_add) var wcs_add = {};
        wcs_add["wa"] = "10afb10e3a5f0b4";
        wcs_do();
    </script>
    <!-- End Naver Analytics -->

    <? if(isset($footer_gb) && $footer_gb == 'order'){	?>
        <!--다음 전환추적 스크립트 :: 2017-03-29-->
        <script type="text/javascript">
            //<![CDATA[
            var DaumConversionDctSv="type=P,orderID=<?=$order_no?>,amount=<?=$order_amt?>";
            var DaumConversionAccountID="u3.cGbAytHr22fFvg3dnHQ00";
            if(typeof DaumConversionScriptLoaded=="undefined"&&location.protocol!="file:"){
                var DaumConversionScriptLoaded=true;
                document.write(unescape("%3Cscript%20type%3D%22text/javas"+"cript%22%20src%3D%22"+(location.protocol=="https:"?"https":"http")+"%3A//t1.daumcdn.net/cssjs/common/cts/vr200/dcts.js%22%3E%3C/script%3E"));
            }
            //]]>
        </script>

    <? }?>



</head>

<body data-showroom="true" data-collection="true" data-newitem="true">
<!-- Google Tag Manager (noscript) :: 2017-02-14 -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TBX6BHL"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

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
                    <label><input type="search" id="searchVal" onkeypress="javascript:if(event.keyCode == 13){ search(''); return false;}" class="header-search-input" value="<?=@$header_gb2=='search'?@$keyword:''?>"></label>
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

        <? if(!isset($header_gb)) {		//2016-12-15 현재 장바구니, 주문/결제, 회원가입, 로그인 일 경우 컨트롤러에서 header_gb를 만들어서 메뉴바가 사라지도록 함 ?>
            <div class="gnb">
                <ul class="gnb-list">
                    <li class="gnb-item gnb-item--home"><a href="/" class="gnb-link <?=isset($bar_md) ? 'active' : ''?>">MD픽!</a></li>
                    <!-- 활성화 됐을때 클래스 active 추가 -->
                    <li class="gnb-item gnb-item--thechoice"><a href="/goods/best_item" class="gnb-link <?=isset($bar_best) ? 'active' : ''?>"">베스트</a></li>
                    <?php if($this->session->userdata('EMS_U_ID_') && $this->session->userdata('EMS_U_ID_') != 'TMP_GUEST'){	?>
                        <li class="gnb-item gnb-item--best">
                            <a href="/goods/event/77" class="gnb-link <?=isset($bar_secret) ? 'active' : ''?>"">시크릿딜</a>
                        </li>
                    <?}else{?>
                        <li class="gnb-item gnb-item--best">
                            <a href="/goods/event/66" class="gnb-link <?=isset($bar_secret) ? 'active' : ''?>"">시크릿딜</a>
                        </li>
                    <?}?>

                    <li class="gnb-item gnb-item--magazine"><a href="/magazine" class="gnb-link <?=isset($bar_magazine) ? 'active' : ''?>"">브랜드인사이드</a></li>
                </ul>
            </div>
        <? }?>

    </div>

    <script type="text/javascript">
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
//					if(SESSION_ID == ''){
//						if(confirm("")){
//							location.href = '/member/login';
//						}
//					}
            }
            //WISH LIST 담기
            else if(mode == 'W'){
                if(SESSION_ID == ''||SESSION_ID == 'GUEST'){
                    if(confirm("로그인 후에 이용하실 수 있습니다. 로그인 하시겠습니까?")){
                        location.href = '/member/login';
                        return false;
                    }else{
                        return false;
                    }
//						window.open("/member/login_pop","LOGIN","width=1000, height=1000, menubar=no, status=no, resizable=yes, scrollbars=yes");
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
            else if(mode == 'S'){
                var url = 'http://dev.etah.co.kr/goods/detail/'+val;
                //페이스북
                if(share == 'F'){
//						$('#ftest').append("<meta id='web_title' property='og:title' content='"+title+"' />");
////						$('#web_image').attr("content",img);
////						$('#web_desc').attr("content",title);
////						alert($('meta[property="og:description"]').attr("content"));
//						alert(title);
//						alert($('#web_title').attr('content'));
//						window.open("http://www.facebook.com/sharer/sharer.php?u="+url+"&t="+title,"","width=550, height=300, status=yes, resizable=no, scrollbars=no");
                    window.open('/goods/share_facebook?title='+title+'&img='+img+'&goods_code='+val,"","width=550, height=300, status=yes, resizable=yes, scrollbars=no");
                }
                //인스타그램
                else if(share == 'I'){
//						window.open("http://www.pinterest.com/pin/create/button/?url="+url+"&media="+img+"&description="+"[ETAH]"+title,"","width=550, height=300, status=yes, resizable=no, scrollbars=no");
                }
                //카카오스토리
                else if(share == 'K'){
                    shareStory(url,encodeURIComponent(title));
                }
                //핀터레스트
                else if(share == 'P'){
                    window.open("http://www.pinterest.com/pin/create/button/?url="+url+"&media="+img+"&description="+"[ETAH] "+encodeURIComponent(title),"","width=800, height=300, status=yes, resizable=no, scrollbars=no");
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
            //	document.getElementsByName("copy_url").focus();
            //	document.getElementsByName("copy_url").select();
            //	therange=document.getElementById("copy_url").createTextRange();
            //
            //	therange.execCommand("Copy");
            //	document.getElementById("copy_url").value = url;
            //	var doc = f.test_copy.createTextRange();

            //	document.getElementById("copy_url").select();


            //	var test = url.execCommand('copy');

            //	if(test) alert(document.getElementById("copy_url").value);

            //	alert('URL이 복사 되었습니다..');
            //	return;
            //	var tempval=eval("document."+theField)
            //	tempval.focus()
            //	tempval.select()
            //	therange=tempval.createTextRange()
            //	therange.execCommand("Copy")
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
            param += "&cate_cd="	+ cate_cd;
            param += "&type="		+ type;

            document.location.href = "/goods/search?"+param;

        }


        //====================================
        // 공유하기 레이어
        //====================================
        function openShareLayer(gubun, code, img, name){

            $.ajax({
                type: 'POST',
                url: '/main/layer_share',
                dataType: 'json',
                data: { gubun : gubun,
                    code : code,
                    name : name,
                    img	: img},
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


        //=====================================
        // 2018.02.06
        // keyword 검색.
        //=====================================
        function keysearch(val)
        {
            var keyword = document.getElementById("keysearch").value;
            var cate_cd = "";
            var type	= "srp";

            if(!trim(keyword)) return false;

            var param = "";
            param += "keyword="		+ keyword;
            param += "&cate_cd="	+ cate_cd;
            param += "&type="		+ type;

            document.location.href = "/goods/search?"+param;

        }
    </script>

