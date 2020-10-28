</div>	<!--CONTETN DIV 닫음 (LAYOUT 제거)-->
<!-- 카테고리 오픈시 category-open 클래스 추가 -->
<div class="footer" id="footer">
    <ul class="footer-menu-list">
        <li class="footer-menu-item"><a href="/footer/about_etah" class="footer-menu-link">회사소개</a></li>
        <li class="footer-menu-item"><a href="/customer/faq" class="footer-menu-link">고객센터</a></li>
        <li class="footer-menu-item"><a href="/footer/inquiry_for_office" class="footer-menu-link">입점&#47;제휴문의</a></li>
        <li class="footer-menu-item"><a href="tel:1522-5572" class="footer-menu-link">고객센터 : 1522-5572</a></li>
        <li class="footer-menu-item"><a href="/footer/use_clause" class="footer-menu-link">이용약관</a></li>
        <li class="footer-menu-item"><a href="/footer/personal_info" class="footer-menu-link">개인정보취급방침</a></li>
    </ul>
    <p class="footer-info">
                    <span class="footer-info-item">
                        <strong class="bold">(주)에타</strong> 서울특별시 성동구 성수이로 22길 37, 아크밸리지식산업센터 906호 에타 (ETAH, 37, Seongsui-ro 22-gil, Seongdong-gu, Seoul, Republic of Korea (04798)
                        <span class="cs-tel"><a href="mailto:admin@etah.co.kr">대량구매 (02-569-6227)</a></span>
                    </span>
    </p>
    <p class="footer-info">
        <span class="footer-info-item">대표이사 : 김의종</span>
        <span class="footer-info-item">사업자등록번호 : 423-81-00385</span>
        <a href="http://www.ftc.go.kr/info/bizinfo/communicationViewPopup.jsp?wrkr_no=4238100385" target="_blank" class="licensee-info">사업자정보확인</a>
    </p>
    <p class="footer-info">
        <span class="footer-info-item">통신판매업 신고번호 : 2020-서울성동-00699 호</span></p>
    <p class="footer-info">
        <span class="footer-info-item">건강기능식품판매영업신고증 : 제2018-0106933호</span></p>
    <p class="footer-info">
        <span class="footer-info-item">의료기기판매영업신고증 : 제8227호</span></p>
    <p class="footer-info">
        <span class="footer-info-item">수입식품등 인터넷 구매대행업 영업등록 : 제 20180003396호</span>
    </p>

    <ul class="footer-sns-list">
        <li class="footer-sns-item">
            <a href="https://www.facebook.com/etahome.co.kr" target="_blank" class="footer-sns-link ico-facebook spr-common-02"></a>
        </li>
        <li class="footer-sns-item">
            <a href="https://www.instagram.com/etahome_kr" target="_blank" class="footer-sns-link ico-instagram spr-common-02"></a>
        </li><!-- https://www.instagram.com/etahcompany/ -->
        <li class="footer-sns-item">
            <a href="https://blog.naver.com/etah_blog" target="_blank" class="footer-sns-link ico-blog spr-common-02"></a>
        </li>
        <li class="footer-sns-item">
            <a href="https://pf.kakao.com/_fXkqC" target="_blank" class="footer-sns-link ico-kakao spr-common-02"></a>
        </li>
        <li class="footer-sns-item">
            <a href="https://www.youtube.com/etahome" target="_blank" class="footer-sns-link ico-youtube spr-common-02"></a>
        </li><!-- https://www.youtube.com/channel/UCVEBa0D-0coHeJu9LYO5l0Q?view_as=subscriber -->
        <li class="footer-sns-item">
            <a href="https://tv.naver.com/etah" target="_blank" class="footer-sns-link ico-naver-tv spr-common-02"></a>
        </li>
    </ul>
</div>

<?if($footer_gb == 'detail'){?>
    <div class="vip-bottom-height" style="padding-bottom: 90px;"></div>
<?}?>

<a href="#" class="btn-top" id="btnTop">TOP</a>
</div>

<script src="/assets/js2/jquery.cookie.js?ver=1"></script>
<script src="/assets/js/owl.carousel.min.js?ver=1"></script>

<script type="text/javascript">


    /*// 카테고리 오픈
    $('#btnCategoryOpen').on('click', function()
    {
        $('#wrap').addClass('category-open');
        return false;
    });
    $('#btnCategoryClose').on('click', function()
    {
        $('#wrap').removeClass('category-open');
        return false;
    });

    $('.dimd').on('click', function()
    {
        $('#wrap').removeClass('category-open');
    });*/

    // 탑버튼
    function topBtn()
    {
        var btn = $('#btnTop'),
            deadLine = $('#footer').offset().top;
        var scrollFnc = function()
        {
            deadLine = $('#footer').offset().top,
                scrollTop = $(window).scrollTop();
            if (scrollTop > 50)
            {
                btn.stop().fadeIn();
                if (scrollTop > deadLine - $(window).height())
                {
                    btn.css(
                        {
                            'position': 'absolute',
                            'bottom': '',
                            'top': deadLine - 55
                        });
                }
                else
                {
                    btn.css(
                        {
                            'position': 'fixed',
                            'top': '',
                            'bottom': '50px'
                        })
                }
            }
            else
            {
                btn.stop().fadeOut();
            }
        };
        $(window).on('scroll', scrollFnc);
        btn.on('click', function()
        {
            $('html, body').animate(
                {
                    scrollTop: 0
                }, 'fast');
        });
        scrollFnc();
    }



    $(function()
    {
        topBtn();
        etahUi.layercontroller();
        etahUi.bottomLayercontroller();
        etahUi.bottomLayerOpen();
        etahUi.toggleMenu();
        <?if(@$footer_gb != 'detail'){?>
        etahUi.tabMenu();
        <?}?>
        etahUi.cartOptionLayer();
        etahUi.listToggle();
        etahUi.filterLayer();
        etahUi.selectFun();
    });
</script>

<script>
    $(document).ready(function(){
        // 상단비주얼 슬라이드
        $(".main-banner-list").owlCarousel({
            items: 1,
            loop: true,
            autoHeight: true,
            smartSpeed: 300,
            autoplay: true,
            autoplayTimeout: 5000
        });
        //MD픽!, 18년 한해도... 슬라이드
        $(".prd-list--main").owlCarousel({
            loop: true,
            autoHeight: true,
            smartSpeed: 300,
            autoplay: true,
            autoplayTimeout: 5000,
            responsiveClass:true,
            responsive:{
                0:{
                    items:2
                },
                768:{
                    items:4
                }
            }
        });
        // 브랜드 포커스, WEECLY THEME 슬라이드
        $(".brand-theme-list").owlCarousel({
            items: 1,
            loop: true,
            autoHeight: true,
            smartSpeed: 300,
            autoplay: false,
            autoplayTimeout: 5000
        });
    });

</script>

<script src="/assets/js/categorySwipe.js?ver=1"></script>
<script src="/assets/js/areaSwipe.js?ver=1"></script>
<script>
    $(function()
    {
        $('#pageCategoryLayer').categorySwipe();

        $('#prdBrandList, #prdPopularList, #prdPriceList').categorySwipe(function(ele)
        {
            ele.css('display', 'none');
        });

        $('.page-title').areaSwipe();
    })
</script>

<script type="text/javascript" src="//wcs.naver.net/wcslog.js"> </script>
<!--<script type="text/javascript">-->
<!--    if (!wcs_add) var wcs_add={};-->
<!--    wcs_add["wa"] = "s_2bca8280e2cf";-->
<!--    if (!_nasa) var _nasa={};-->
<!--    wcs.inflow();-->
<!--    wcs_do(_nasa);-->
<!--</script>-->

<!--네이버 페이 스크립트 추가 2019.11.28 -->
<script type="text/javascript">
    // Account ID 적용
    if(!wcs_add) var wcs_add = {};
    wcs_add["wa"] = "s_51fd0fb4ae2b";
    //유입 추적 함수 호출
    wcs.inflow("etahome.co.kr");
</script>
<!-- WIDERPLANET  SCRIPT START -->
<div id="wp_tg_cts" style="display:none;"></div>
<script type="text/javascript">
    var wptg_tagscript_vars = wptg_tagscript_vars || [];
    wptg_tagscript_vars.push(
        (function() {
            return {
                wp_hcuid:"",     /*Cross device targeting을 원하는 광고주는 로그인한 사용자의 Unique ID (ex. 로그인 ID, 고객넘버 등)를 암호화하여 대입.
											*주의: 로그인 하지 않은 사용자는 어떠한 값도 대입하지 않습니다.*/
                ti:"35025",       /*광고주 코드*/
                ty:"Home",       /*트래킹태그 타입*/
                device:"mobile"  /*디바이스 종류 (web 또는 mobile)*/
            };
        }));
</script>
<script type="text/javascript" async src="//cdn-aitg.widerplanet.com/js/wp_astg_4.0.js"></script>
<!-- // WIDERPLANET  SCRIPT END -->
<!--
<script type="text/javascript">
    // Account ID 적용
    if(!wcs_add) var wcs_add = {};
    wcs_add["wa"] = "s_51fd0fb4ae2b";
    //유입 추적 함수 호출
    wcs.inflow("etah.co.kr");
</script>-->


<script>
    // 우편번호 찾기 화면을 넣을 element
    var element_layer = document.getElementById('layer_post');

    function closeDaumPostcode() {
        // iframe을 넣은 element를 안보이게 한다.
        element_layer.style.display = 'none';
    }
    //다음 api 우편번호, pcode = 우편번호필드, pcode2 = hidden우편번호필드, paddr1 =기본주소필드, paddr2 = hidden우편번호 필드, paddr3 = 상세우편번호 필드
    function mobile_execDaumPostcode(pcode, pcode2, paddr1, paddr2, paddr3) {
        new daum.Postcode({
            oncomplete: function(data) {
                // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullAddr = data.address; // 최종 주소 변수
                var extraAddr = ''; // 조합형 주소 변수

                // 기본 주소가 도로명 타입일때 조합한다.
                if(data.addressType === 'R'){
                    //법정동명이 있을 경우 추가한다.
                    if(data.bname !== ''){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있을 경우 추가한다.
                    if(data.buildingName !== ''){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                    fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                // document.getElementById('sample2_postcode').value = data.zonecode; //5자리 새우편번호 사용
                // document.getElementById('sample2_address').value = fullAddr;
                //document.getElementById('sample2_addressEnglish').value = data.addressEnglish;
                document.getElementById(pcode).value = data.zonecode; //5자리 새우편번호 사용

                if(pcode2 !== ''){
                    document.getElementById(pcode2).value = data.zonecode;
                }
                document.getElementById(paddr1).value = fullAddr;

                if(paddr2 !== ''){
                    document.getElementById(paddr2).value = fullAddr;
                }
                document.getElementById(paddr3).focus();
                // iframe을 넣은 element를 안보이게 한다.
                // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                element_layer.style.display = 'none';
            },
            width : '100%',
            height : '100%',
            maxSuggestItems : 5
        }).embed(element_layer);

        // iframe을 넣은 element를 보이게 한다.
        element_layer.style.display = 'block';

        // iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
        initLayerPosition();
    }
    function initLayerPosition(){
        var width = 300; //우편번호서비스가 들어갈 element의 width
        var height = 400; //우편번호서비스가 들어갈 element의 height
        var borderWidth = 1; //샘플에서 사용하는 border의 두께

        // 위에서 선언한 값들을 실제 element에 넣는다.
        element_layer.style.width = width + 'px';
        element_layer.style.height = height + 'px';
        element_layer.style.border = borderWidth + 'px solid';
        // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
        element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width)/2 - borderWidth) + 'px';
        //element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height)/4 - borderWidth) + 'px';
        element_layer.style.top = '10px';
    }


    //다음 api 우편번호, pcode = 우편번호필드, pcode2 = hidden우편번호필드, paddr1 =기본주소필드, paddr2 = hidden우편번호 필드, paddr3 = 상세우편번호 필드
    function execDaumPostcode(pcode, pcode2, paddr1, paddr2, paddr3) {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullAddr = ''; // 최종 주소 변수
                var extraAddr = ''; // 조합형 주소 변수

                // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    fullAddr = data.roadAddress;

                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    fullAddr = data.jibunAddress;
                }

                // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
                if(data.userSelectedType === 'R'){
                    //법정동명이 있을 경우 추가한다.
                    if(data.bname !== ''){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있을 경우 추가한다.
                    if(data.buildingName !== ''){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                    fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.

                //document.getElementById('formAddressInput').value = data.zonecode; //5자리 새우편번호 사용
                //document.getElementById('order_postnum').value = data.zonecode;
                //document.getElementById('order_addr1_text').value = fullAddr;
                //document.getElementById('order_addr2').focus();

                document.getElementById(pcode).value = data.zonecode; //5자리 새우편번호 사용

                if(pcode2 !== ''){
                    document.getElementById(pcode2).value = data.zonecode;
                }
                document.getElementById(paddr1).value = fullAddr;

                if(paddr2 !== ''){
                    document.getElementById(paddr2).value = fullAddr;
                }
                document.getElementById(paddr3).focus();
            }
        }).open();
    }
</script>
<!--네이버 페이 스크립트 추가 2019.11.28 -->
<script type="text/javascript">
    wcs_do();
</script>
</body>
</html>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-K9B5N2X');</script>
<!-- End Google Tag Manager -->