</div>	<!--CONTETN DIV 닫음 (LAYOUT 제거)-->
<!-- 카테고리 오픈시 category-open 클래스 추가 -->

<div class="footer" id="footer">
    <ul class="footer-menu-list">
        <li class="footer-menu-item"><a href="#" class="footer-menu-link">회사소개</a></li>
        <li class="footer-menu-item"><a href="#" class="footer-menu-link">고객센터</a></li>
        <li class="footer-menu-item"><a href="#" class="footer-menu-link">입점&#47;제휴문의</a></li>
        <li class="footer-menu-item"><a href="mailto:admin@etah.co.kr" class="footer-menu-link">대량구매 (전화문의 : 02-569-6228)</a></li>
        <li class="footer-menu-item"><a href="#" class="footer-menu-link">이용약관</a></li>
        <li class="footer-menu-item"><a href="#" class="footer-menu-link">개인정보취급방침</a></li>
    </ul>
    <p class="footer-info">
                    <span class="footer-info-item">
                        <strong class="bold">(주)에타</strong> 서울시 강남구 논현로63길 25
                        <span class="cs-tel">고객센터 : <a href="tel:1522-5572">1522-5572</a></span>
                    </span>
    </p>
    <p class="footer-info">
        <span class="footer-info-item">대표이사 : 유남민</span>
        <span class="footer-info-item">사업자등록번호 : 423-81-00385</span>
        <a href="http://www.ftc.go.kr/info/bizinfo/communicationViewPopup.jsp?wrkr_no=4238100385" target="_blank" class="licensee-info">사업자정보확인</a>
    </p>
    <p class="footer-info">
        <span class="footer-info-item">통신판매업 신고번호 : 제 2016-서울강남-02548호</span>
    </p>

    <ul class="footer-sns-list">
        <li class="footer-sns-item">
            <a href="https://www.facebook.com/etahcompany" target="_blank" class="footer-sns-link ico-facebook spr-common-02"></a>
        </li>
        <li class="footer-sns-item">
            <a href="https://www.instagram.com/etahcompany/" target="_blank" class="footer-sns-link ico-instagram spr-common-02"></a>
        </li>
        <li class="footer-sns-item">
            <a href="http://blog.naver.com/etahcompany" target="_blank" class="footer-sns-link ico-blog spr-common-02"></a>
        </li>
    </ul>
</div>

<div class="dimd"></div>
</div>

<a href="#" class="btn-top" id="btnTop">TOP</a>
<script src="/assets/js/common.js"></script>
<script src="/assets/js2/jquery.cookie.js"></script>

<script src="/assets/js/common.js"></script>
<script src="/assets/js/owl.carousel.min.js"></script>

<script type="text/javascript">
    //메인 프로모션 팝업 딤레이어
    $(function(){
        $('#wrap').addClass('layer-open');
        $('#layerMainPopup .btn_close').click( function() {
            $('#wrap').removeClass('layer-open');
        });
    });
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
        etahUi.tabMenu();
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
            autoplay: false,
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

<script src="/assets/js/categorySwipe.js"></script>
<script src="/assets/js/areaSwipe.js"></script>
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

</body>

</html>