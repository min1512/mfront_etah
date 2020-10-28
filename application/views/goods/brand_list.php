
	<link rel="stylesheet" href="/assets/css/display.css">

			<div class="content">
				<h2 class="page-title-basic page-title-basic--line">Brand List</h2>
				<div class="brand-lp-wrap">
					<!-- brand-search-wrap// -->
					<form action="" class="brand-search-form">
						<label><input type="search" id="search_keyword" class="brand-search-input" value="<?=@$keyword?>" placeholder="브랜드명을 입력해주세요."  onkeypress="javascript:if(event.keyCode == 13){ brand_search(); return false;}"></label>
						<button type="button" onClick="javascript:brand_search();" class="brand-search-btn"><span class="hide">검색하기</span></button>
					</form>

				<? if(@$brand_initial){?>
					<div class="brand-initial-choice-box">

						<ul class="brand-initial-choice-list">
							<li class="brand-initial-choice-item"><a href="#brandKoreanList" class="brand-initial-link" data-ui="btn-initial">ㄱㄴㄷ</a></li>
							<li class="brand-initial-choice-item"><a href="#brandAlphabetList" class="brand-initial-link" data-ui="btn-initial" style="display: none">A B C</a></li>
							<!-- 활성화 시 active 클래스 추가 -->
						</ul>
						<div class="brand-initial-list-box">
							<!-- A,B,C// -->
							<ul id="brandAlphabetList" class="brand-initial-list alphabet-initial-list" style="display: none">
								<? $idx = 0;
									for($a=0; $a<count($brand_initial); $a++){
									if(!preg_match("/[\xA1-\xFE\xA1-\xFE]/", $brand_initial[$a]['BRAND_NM_FST_LETTER'])){
								?>
									<li class="brand-initial-item"><a href="#brandinitial<?=$idx?>" class="brand-item-link"><?=$brand_initial[$a]['BRAND_NM_FST_LETTER']?></a></li>
								<? $idx++;
								}}?>
<!-- 								<li class="brand-initial-item active"><a href="#a" class="brand-item-link">A</a></li> -->
								<!-- 활성화 시 active 클래스 추가 -->
<!--								<li class="brand-initial-item"><a href="#b" class="brand-item-link">B</a></li>
								<li class="brand-initial-item"><a href="#c" class="brand-item-link">C</a></li>
								<li class="brand-initial-item"><a href="#d" class="brand-item-link">D</a></li>
								<li class="brand-initial-item"><a href="#e" class="brand-item-link">E</a></li>
								<li class="brand-initial-item"><a href="#f" class="brand-item-link">F</a></li>
								<li class="brand-initial-item"><a href="#g" class="brand-item-link">G</a></li>
								<li class="brand-initial-item"><a href="#h" class="brand-item-link">H</a></li>
								<li class="brand-initial-item"><a href="#i" class="brand-item-link">I</a></li>
								<li class="brand-initial-item"><a href="#j" class="brand-item-link">J</a></li>
								<li class="brand-initial-item"><a href="#k" class="brand-item-link">K</a></li>
								<li class="brand-initial-item"><a href="#l" class="brand-item-link">L</a></li>
								<li class="brand-initial-item"><a href="#m" class="brand-item-link">M</a></li>
								<li class="brand-initial-item"><a href="#n" class="brand-item-link">N</a></li>
								<li class="brand-initial-item"><a href="#o" class="brand-item-link">O</a></li>
								<li class="brand-initial-item"><a href="#p" class="brand-item-link">P</a></li>
								<li class="brand-initial-item"><a href="#q" class="brand-item-link">Q</a></li>
								<li class="brand-initial-item"><a href="#r" class="brand-item-link">R</a></li>
								<li class="brand-initial-item"><a href="#s" class="brand-item-link">S</a></li>
								<li class="brand-initial-item"><a href="#t" class="brand-item-link">T</a></li>
								<li class="brand-initial-item"><a href="#u" class="brand-item-link">U</a></li>
								<li class="brand-initial-item"><a href="#v" class="brand-item-link">V</a></li>
								<li class="brand-initial-item"><a href="#w" class="brand-item-link">W</a></li>
								<li class="brand-initial-item"><a href="#x" class="brand-item-link">X</a></li>
								<li class="brand-initial-item"><a href="#y" class="brand-item-link">Y</a></li>
								<li class="brand-initial-item"><a href="#z" class="brand-item-link">Z</a></li>-->
							</ul>
							<!-- //A,B,C -->

							<!-- ㄱ,ㄴ,ㄷ// -->
							<ul id="brandKoreanList" class="brand-initial-list korean-initial-list">

								<? 
									for($a=0; $a<count($brand_initial); $a++){
//										echo preg_match("/[\xA1-\xFE\xA1-\xFE]/", $brand_initial[$a]['BRAND_NM_FST_LETTER']);
									if(preg_match("/[\xA1-\xFE\xA1-\xFE]/", $brand_initial[$a]['BRAND_NM_FST_LETTER'])){
								?>
									<li class="brand-initial-item"><a href="#brandinitial<?=$idx?>" class="brand-item-link"><?=$brand_initial[$a]['BRAND_NM_FST_LETTER']?></a></li>
								<? $idx++;
								}}?>
<!-- 								<li class="brand-initial-item active"><a href="#brandinitial01" class="brand-item-link">ㄱ</a></li> -->
								<!-- 활성화 시 active 클래스 추가 -->
<!-- 								<li class="brand-initial-item"><a href="#brandinitial02" class="brand-item-link">ㄴ</a></li> -->
								<!-- brand-wrd-initial링크에 있는 아이디값과 href값을 맞춰주면 클릭했을때 해당되는 철자로 이동됩니다 -->
<!--								<li class="brand-initial-item"><a href="#brandinitial03" class="brand-item-link">ㄷ</a></li>
								<li class="brand-initial-item"><a href="#brandinitial04" class="brand-item-link">ㄹ</a></li>
								<li class="brand-initial-item"><a href="#brandinitial05" class="brand-item-link">ㅁ</a></li>
								<li class="brand-initial-item"><a href="#brandinitial06" class="brand-item-link">ㅂ</a></li>
								<li class="brand-initial-item"><a href="#brandinitial07" class="brand-item-link">ㅅ</a></li>
								<li class="brand-initial-item"><a href="#brandinitial08" class="brand-item-link">ㅇ</a></li>
								<li class="brand-initial-item"><a href="#brandinitial09" class="brand-item-link">ㅈ</a></li>
								<li class="brand-initial-item"><a href="#brandinitial10" class="brand-item-link">ㅊ</a></li>
								<li class="brand-initial-item"><a href="#brandinitial11" class="brand-item-link">ㅋ</a></li>
								<li class="brand-initial-item"><a href="#brandinitial12" class="brand-item-link">ㅌ</a></li>
								<li class="brand-initial-item"><a href="#brandinitial13" class="brand-item-link">ㅍ</a></li>
								<li class="brand-initial-item"><a href="#brandinitial14" class="brand-item-link">ㅎ</a></li>-->
							</ul>
							<!-- //ㄱ,ㄴ,ㄷ -->
						</div>
					</div>

					<!-- 브랜드 초성별 단어 리스트// -->
					<div class="brand-wrd-order-box">
						<?foreach($brand_list as $key=>$irow){?>
							<span class="brand-wrd-initial" id="brandinitial<?=$key?>"><?=$irow[0]['BRAND_NM_FST_LETTER']?></span>
							<ul class="brand-wrd-list">
							<?foreach($irow as $brow){?>
								<li class="brand-wrd-item">
									<a href="/goods/brand/<?=$brow['BRAND_CD']?>" class="brand-wrd-link"><?=$brow['BRAND_NM']?></a>
								</li>
							<?}?>
							</ul>
						<?}?>
				<?} else {?>
				<br/>
					<div class="brand-wrd-order-box">
						<span class="brand-wrd-initial">검색결과</span>
						<ul class="brand-wrd-list">
						<? foreach($brand_list as $key=>$srow){?>
							<li class="brand-wrd-item">
								<a href="/goods/brand/<?=$srow['BRAND_CD']?>" class="brand-wrd-link"><?=$srow['BRAND_NM']?></a>
							</li>
						<?}?>
						</ul>
				<?}?>

<!--				<span class="brand-wrd-initial" id="brandinitial01">ㄱ</span>
						<ul class="brand-wrd-list">
							<li class="brand-wrd-item">
								<a href="#" class="brand-wrd-link">가쯔</a>
							</li>
							<li class="brand-wrd-item">
								<a href="#" class="brand-wrd-link">골든벨</a>
							</li>
						</ul>

						<span class="brand-wrd-initial" id="brandinitial02">ㄴ</span>
						<ul class="brand-wrd-list">
							<li class="brand-wrd-item">
								<a href="#" class="brand-wrd-link">가쯔</a>
							</li>
						</ul>
					</div>-->
					<!-- //브랜드 초성별 단어 리스트(한글) -->

					<!-- 브랜드 초성별 단어 리스트(영문)// -->
	<!--				<div class="brand-wrd-order-box" style="display: none">
						<span class="brand-wrd-initial">A</span>
						<ul class="brand-wrd-list">
							<li class="brand-wrd-item">
								<a href="#" class="brand-wrd-link">AAAA</a>
								<a href="#" class="brand-bookmark-link"><span class="ico-heart spr-common"><span class="hide">찜하기</span></span></a>
							</li>
						</ul>
					</div>-->
					<!-- //브랜드 초성별 단어 리스트(영문) -->
				</div>


		<script>
			$(function()
			{
				var btnInitial = $('[data-ui="btn-initial"]');
				$(btnInitial).on('click', function()
				{
					var thisHref = $(this).attr('href');
					$('.brand-initial-list').show();
					$(btnInitial).show();
					$(this).hide();
					$(thisHref).hide();
				});
			});


			function brand_search()
			{
				var keyword = document.getElementById("search_keyword").value;

				var param = "";

				param += "keyword="+keyword;
				
				document.location.href = "/goods/brand_list?"+param;
			}
		</script>