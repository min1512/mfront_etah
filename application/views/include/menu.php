<!DOCTYPE html>
<html lang="ko-KR">

	<head>
		<title>ETA HOME MOBILE</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<meta id="web_image" property="og:image" content="http://ui.etah.co.kr/assets/images/data/etah_image.png" />
		<link rel="stylesheet" href="../assets/css/common.css?ver=1.8.1">
		<link rel="shortcut icon" href="/favicon.ico">
	</head>
	<body>
		<div class="wrap category-wrap" id="wrap">
			<div class="category">
				<div class="nav-mymenu <? if(!$this->session->userdata('EMS_U_ID_')){ ?>nav-mymenu--logout<?}?>">
					<!-- 로그인 될 경우 클래스 nav-mymenu--logout 추가 -->
					<!-- 회원인 경우 // -->
					<? if($this->session->userdata('EMS_U_ID_') && $this->session->userdata('EMS_U_ID_') != 'TMP_GUEST'){ ?>
					<div class="nav-top-login">
						<span class="login-txt"><strong class="info-bold"><?=$this->session->userdata('EMS_U_ID_')?></strong>님</span>
						<a href="/member/logout" class="btn-white btn-logout">로그아웃</a>
						<a href="/customer/notice" class="nav-top-alert">
							<span class="spr-common ico-alert"></span>
							<? if($notice_cnt > 0){	?>
							<span class="nav-top-num">N</span>
							<? }?>
						</a>
					</div>
					<!-- 주요서비스 // -->
					<ul class="nav-mymenu-list">
						<li class="nav-mymenu-item">
							<a href="/mywiz" class="nav-mymenu-link">
								<span class="nav-mymenu-ico ico-member spr-common"></span>
								<span class="nav-mymenu-txt">마이페이지</span>
							</a>
						</li>
						<li class="nav-mymenu-item">
							<a href="/mywiz/order" class="nav-mymenu-link">
								<span class="nav-mymenu-ico ico-order-delivery spr-common"></span>
								<span class="nav-mymenu-txt">주문/배송</span>
							</a>
						</li>
						<li class="nav-mymenu-item">
							<a href="/customer/faq" class="nav-mymenu-link">
								<span class="nav-mymenu-ico ico-center spr-common"></span>
								<span class="nav-mymenu-txt">고객센터</span>
							</a>
						</li>
						<li class="nav-mymenu-item">
							<a href="/mywiz/view_goods" class="nav-mymenu-link">
								<span class="nav-mymenu-ico ico-recent spr-common"></span>
								<span class="nav-mymenu-txt">최근본상품</span>
							</a>
						</li>
					</ul>

					<ul class="mypage-benefit-list mypage-benefit-list--nav">
						<li class="mypage-benefit-item">
							<a href="/mywiz/coupon">
							<div class="mypage-benefit-ico">
								<span class="mypage-benefit-coupon spr-common"></span>
								<span class="mypage-benefit-coupon-txt">쿠폰</span>
							</div>
							<span class="mypage-benefit-txt"><strong class="mypage-num-info mypage-num-info--big"><?=$mycoupon_cnt?></strong> 장</span>
							</a>
						</li>
						<li class="mypage-benefit-item">
							<a href="/mywiz/mileage">
							<span class="mypage-benefit-ico mypage-benefit-mileage spr-common"></span>
							<span class="mypage-benefit-txt"><strong class="mypage-num-info"><?=number_format($mileage)?></strong> 마일</span>
							</a>
						</li>
					</ul>
					<!-- // 주요서비스 -->
					<!-- // 회원인 경우 -->

					<!-- 비회원일 경우 // -->
					<?} else{	?>
					<div class="nav-top-login">
						<a href="https://<?=$_SERVER['HTTP_HOST']?>/member/login" class="btn-black btn-login">로그인</a>
						<a href="/customer/notice" class="nav-top-alert">
							<span class="spr-common ico-alert"></span>
							<? if($notice_cnt > 0){	?>
							<span class="nav-top-num">N</span>
							<? }?>
						</a>
					</div>

					<ul class="nav-mymenu-list">
						<li class="nav-mymenu-item">
							<a href="https://<?=$_SERVER['HTTP_HOST']?>/member/member_join1" class="nav-mymenu-link">
								<span class="nav-mymenu-ico ico-join spr-common"></span>
								<span class="nav-mymenu-txt">회원가입</span>
							</a>
						</li>
						<li class="nav-mymenu-item">
							<a href="/mywiz/order" class="nav-mymenu-link">
								<span class="nav-mymenu-ico ico-order-delivery spr-common"></span>
								<span class="nav-mymenu-txt">주문/배송</span>
							</a>
						</li>
						<li class="nav-mymenu-item">
							<a href="/customer/faq" class="nav-mymenu-link">
								<span class="nav-mymenu-ico ico-center spr-common"></span>
								<span class="nav-mymenu-txt">고객센터</span>
							</a>
						</li>
						<li class="nav-mymenu-item">
							<a href="/mywiz/view_goods" class="nav-mymenu-link">
								<span class="nav-mymenu-ico ico-recent spr-common"></span>
								<span class="nav-mymenu-txt">최근본상품</span>
							</a>
						</li>
					</ul>
					<? }?>
					<!-- // 비회원일 경우 -->
				</div>

				<!-- 메인카테고리메뉴 // -->
				<div class="nav-menu-list-box">
					<ul class="nav-menu-list">
						<? $icon = '';
							for($a=0; $a<count($menu['arr_menu1_cd']); $a++){
							switch($menu['arr_menu1_cd'][$a]){
								case "10000000": $icon = 'spr-common-02 ico-furniture';	    break;
								case "11000000": $icon = 'spr-common-02 ico-interior';	    break;
								case "13000000": $icon = 'spr-common-02 ico-diy';			break;
								case "14000000": $icon = 'spr-common-02 ico-light';		    break;
								case "18000000": $icon = 'spr-common-02 ico-pet';			break;
								case "19000000": $icon = 'spr-common-02 ico-kitchen';		break;
								case "15000000": $icon = 'spr-common-02 ico-bedding';		break;
								case "16000000": $icon = 'spr-common-02 ico-gardening';	    break;
								case "17000000": $icon = 'spr-common-02 ico-living';		break;
                                case "21000000": $icon = 'spr-common-02 ico-digital';		break;
                                case "22000000": $icon = 'spr-common-02 ico-food';	        break;
                                case "23000000": $icon = 'spr-common-02 ico-beauty';		break;
								default: $icon = '';
							} ?>
							<li class="nav-menu-item" data-toggle="toggle-parent">
								<a href="/category/main?cate_cd=<?=$menu['arr_menu1_cd'][$a]?>" class="nav-menu-link">
									<span class="<?=$icon?>"></span>
									<span class="ico-nav-txt"><?=$menu['arr_menu1_nm'][$a]?></span>
								</a>
								<ul class="nav-sub-menu-list" data-toggle="toggle-box">
								<?for($b=0; $b<count($menu['arr_menu2_cd'][$a]); $b++){?>
									<li class="nav-sub-menu-item">
										<a href="/category/main?cate_cd=<?=$menu['arr_menu2_cd'][$a][$b]?>" class="nav-sub-menu-link"><?=$menu['arr_menu2_nm'][$a][$b]?></a>
									</li>
								<?}?>
								</ul>
							</li>
						<? }?>
					</ul>
				</div>
				<!-- // 메인카테고리메뉴 -->

				<!-- 브랜드 매거진 // -->
				<div class="nav-brand-magazine-box">
					<ul class="nav-brand-magazine-list">
						<li class="nav-brand-magazine-item">
							<a href="/goods/brand_list" class="nav-brand-magazine-link">BRAND</a>
						</li>
						<li class="nav-brand-magazine-item">
							<a href="/magazine" class="nav-brand-magazine-link">MAGAZINE</a>
						</li>
					</ul>
				</div>
				<!-- // 브랜드 매거진 -->

				<!-- 최근 본 상품 // -->
				<div class="nav-recent-prd">
				<?if($quick['view']){?>
					<p class="nav-recent-prd-tlt">최근 본 상품</p>
					<div class="nav-recent-prd-inner">
					<ul class="nav-recent-prd-list">
						<?
						$idx = 0;
						foreach($quick['view'] as $key=>$vrow){?>
						<li class="nav-recent-prd-item">
							<a href="/goods/detail/<?=$vrow['GOODS_CD']?>" class="nav-recent-prd-link"><img src="<?=$vrow['IMG_URL']?>" alt=""></a>
						</li>
						<? if(isset($vrow)) $idx++;
						if($idx==20) break;
					}?>
					</ul>
					</div>
				<?}?>
				</div>
				<!-- // 최근 본 상품 -->
				<!-- 장바구니 관심상품 버튼 // -->
				<ul class="nav-bottom-menu-list">
					<li class="nav-bottom-menu-item">
						<a href="/cart" class="nav-bottom-menu-link">
							<span class="ico-nav ico-category-cart spr-common"></span>장바구니
							<span class="nav-top-num"><?=$cart_cnt?></span>
						</a>
					</li>
					<li class="nav-bottom-menu-item">
						<a href="/mywiz/interest" class="nav-bottom-menu-link">
							<span class="ico-nav ico-category-heart spr-common"></span>관심상품
							<span class="nav-top-num"><?=$interest_cnt?></span>
						</a>
					</li>
				</ul>
				<!-- // 장바구니 관심상품 버튼 -->
				<a href="<?=$returnUrl?>" class="nav-close-btn"><span class="hide">닫기</span></a>
			</div>

		<div class="footer" id="footer">
				<ul class="footer-menu-list">
					<li class="footer-menu-item"><a href="#" class="footer-menu-link">회사소개</a></li>
					<li class="footer-menu-item"><a href="#" class="footer-menu-link">고객센터</a></li>
					<li class="footer-menu-item"><a href="#" class="footer-menu-link">입점&#47;제휴문의</a></li>
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
					<span class="footer-info-item">대표이사 : 김의종</span>
					<span class="footer-info-item">사업자등록번호 : 423-81-00385</span>
					<a href="#" class="licensee-info">사업자정보확인</a>

				</p>
				<p class="footer-info">
					<span class="footer-info-item">통신판매업 신고번호 : 제 2016-서울강남-02548호</span>
				</p>

			</div>

		</div>

		<script src="/assets/js/common.js"></script>
		<script type="text/javascript">
			// 탑버튼
			function topBtn() {var btn = $('#btnTop'), deadLine = $('#footer').offset().top;var scrollFnc = function() {deadLine = $('#footer').offset().top, scrollTop = $(window).scrollTop();
			if (scrollTop > 50) {btn.stop().fadeIn();if (scrollTop > deadLine - $(window).height()) {btn.css({'position': 'absolute', 'bottom': '', 'top': deadLine - 55});}
			else {btn.css({'position': 'fixed', 'top': '', 'bottom': '50px'})}} else {btn.stop().fadeOut();}};
				$(window).on('scroll', scrollFnc);btn.on('click', function() {$('html, body').animate({scrollTop: 0}, 'fast');});scrollFnc();}
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
			//최근본상품 가로스크롤
			$(function() {var recentlyItemLength = $('.nav-recent-prd-item').length, recentlyItemWidth = $('.nav-recent-prd-item').width() + 3;$('.nav-recent-prd-list').css('width', recentlyItemLength * recentlyItemWidth);})
		</script>
	</body>
</html>
