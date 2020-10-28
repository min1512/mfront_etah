</div>	<!--CONTETN DIV 닫음 (LAYOUT 제거)-->
			<!-- 카테고리 오픈시 category-open 클래스 추가 -->

			<div class="footer" id="footer">
				<ul class="footer-menu-list">
					<li class="footer-menu-item"><a href="#" class="footer-menu-link">회사소개</a></li>
					<li class="footer-menu-item"><a href="#" class="footer-menu-link">고객센터</a></li>
					<li class="footer-menu-item"><a href="#" class="footer-menu-link">이용약관</a></li>
					<li class="footer-menu-item"><a href="#" class="footer-menu-link">개인정보취급방침</a></li>
					<li class="footer-menu-item"><a href="#" class="footer-menu-link">입점&#47;제휴문의</a></li>
				</ul>
				<p class="footer-info">
					<span class="footer-info-item">(주)에타 서울시 강남구 논현로63길 25</span>
					<span class="footer-info-item">대표이사 : 권오열</span>
				</p>
				<p class="footer-info">
					<span class="footer-info-item">사업자등록번호 : 423-81-00385</span>
					<span class="footer-info-item">통신판매업 신고번호 : 제 2016-서울강남-02548호</span>
				</p>
				<p class="footer-info footer-info--last">
					<span class="footer-info-item">고객센터 : <a href="tel:1522-5572">1522-5572</a></span>
					<a href="#" class="footer-info-item licensee-info">사업자정보확인</a>
				</p>

			</div>

			<div class="dimd"></div>
		</div>

		<a href="#" class="btn-top" id="btnTop">TOP</a>
		<script src="/assets/js/common.js"></script>
		<script src="/assets/js2/jquery.cookie.js"></script>

		<script type="text/javascript">
			// 카테고리 오픈
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
			});

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
			});
		</script>

		<script>
			$(function()
			{
				etahUi.slideBox(
				{
					box: $('#detailImgFlick'), // maxwidth 넘거가면 margin 제거.
					page: $('#bigBannerPage'), // page 표시영역
					imgArea: $('#bannerList'), // motion box, box size * 3 width, box height
					imgObj: $('#detailImgFlick').find('li.main-banner-item'), // li, contents / box size width,
					btns: $('#detailImgFlick').find('.btn-white-prev, .btn-white-next'), // 좌우 버튼.
					imgCls: 'main-banner-item',
					pageHtm: '', // 페이징(블릿) html
					moveClass: 'transition',
					boxReheight: true // box 의 높이를 조정.
						// .visual-list
				});
			});
		</script>

		<script>
			$(function()
			{
				etahUi.slideBox(
				{
					box: $('#detailImgFlick'), // maxwidth 넘거가면 margin 제거.
					page: $('#bigBannerPage'), // page 표시영역
					imgArea: $('#bannerList'), // motion box, box size * 3 width, box height
					imgObj: $('#detailImgFlick').find('li.main-banner-item'), // li, contents / box size width,
					btns: $('#detailImgFlick').find('.btn-white-prev, .btn-white-next'), // 좌우 버튼.
					imgCls: 'main-banner-item',
					pageHtm: '', // 페이징(블릿) html
					moveClass: 'transition',
					boxReheight: true // box 의 높이를 조정.
						// .visual-list
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