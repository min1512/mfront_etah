			<link rel="stylesheet" href="/assets/css/customert_center.css?var=1.0">

			<div class="content">
				<h2 class="page-title-basic">고객센터</h2>

				<!-- FAQ, 1:1문의, 묻고 답하기, 공지사항 // -->
				<div class="tab-customer-center">
					<!-- tab영역// -->
                    <ul class="tab-common-list">
                        <li class="tab-common-btn active"><a href="#QnaTab" class="tab-common-btn-link" data-ui="btn-tab">FAQ</a></li>
                        <li class="tab-common-btn"><a href="/customer/register_qna" class="tab-common-btn-link">1:1문의</a></li>
<!--                        <li class="tab-common-btn"><a href="/customer/qna_list_all" class="tab-common-btn-link">묻고 답하기</a></li>-->
                        <li class="tab-common-btn"><a href="/customer/notice" class="tab-common-btn-link">공지사항</a></li>
                    </ul>
					<!-- //tab영역 -->

					<div class="qna-search-form">
						<label><input type="search" class="common-search-input" placeholder="자주 찾는 질문을 검색해주세요." name="faq_keyword" onKeyPress="javascript:if(event.keyCode == 13){ faqSearch('SEARCH'); return false;}" value="<?=$keyword?>"></label>
						<button class="qna-search-btn" onClick="javaScript:faqSearch('SEARCH');"><span class="hide">검색하기</span></button>
					</div>

					<!-- FAQ // -->
					<div id="QnaTab" class="qna-content-wrap">

						<div class="category-menu-box">
							<ul class="category-menu-bg-list">
								<li class="category-menu-bg-item <?=$type == '' ? "active" : ""?>">
									<a href="javaScript:;" onClick="javaScript:faqSearch('');" class="category-menu-bg-link">
										<span class="spr-common ico-category-besequestion"></span>베스트질문
									</a>
								</li>
								<li class="category-menu-bg-item <?=$type == 'ORDER__SHIPPING' ? "active" : ""?>">
									<a href="javaScript:;" onClick="javaScript:faqSearch('ORDER__SHIPPING');" class="category-menu-bg-link">
										<span class="spr-common ico-category-order"></span>주문/배송
									</a>
								</li>
								<li class="category-menu-bg-item <?=$type == 'GOODS' ? "active" : ""?>">
									<a href="javaScript:;" onClick="javaScript:faqSearch('GOODS');" class="category-menu-bg-link">
										<span class="spr-common ico-category-prd"></span>상품
									</a>
								</li>
								<li class="category-menu-bg-item <?=$type == 'PAY' ? "active" : ""?>">
									<a href="javaScript:;" onClick="javaScript:faqSearch('PAY');" class="category-menu-bg-link">
										<span class="spr-common ico-category-card"></span>결제
									</a>
								</li>
								<li class="category-menu-bg-item <?=$type == 'MILEAGE' ? "active" : ""?>">
									<a href="javaScript:;" onClick="javaScript:faqSearch('MILEAGE');" class="category-menu-bg-link">
										<span class="spr-common ico-category-ico-mileage"></span>마일리지
									</a>
								</li>
								<li class="category-menu-bg-item <?=$type == 'CANCEL__RETURN__CHANGE' ? "active" : ""?>">
									<a href="javaScript:;" onClick="javaScript:faqSearch('CANCEL__RETURN__CHANGE');" class="category-menu-bg-link">
										<span class="spr-common ico-category-cancel"></span>취소반품
									</a>
								</li>
								<li class="category-menu-bg-item <?=$type == 'COUPON' ? "active" : ""?>">
									<a href="javaScript:;" onClick="javaScript:faqSearch('COUPON');" class="category-menu-bg-link">
										<span class="spr-common ico-category-coupon"></span>쿠폰
									</a>
								</li>
								<li class="category-menu-bg-item <?=$type == 'MEMBER' ? "active" : ""?>">
									<a href="javaScript:;" onClick="javaScript:faqSearch('MEMBER');" class="category-menu-bg-link">
										<span class="spr-common ico-category-coustomer"></span>회원관리
									</a>
								</li>
								<li class="category-menu-bg-item <?=$type == 'EVENT' ? "active" : ""?>">
									<a href="javaScript:;" onClick="javaScript:faqSearch('EVENT');" class="category-menu-bg-link">
										<span class="spr-common ico-category-event"></span>이벤트
									</a>
								</li>
								<li class="category-menu-bg-item <?=$type == 'ETC' ? "active" : ""?>">
									<a href="javaScript:;" onClick="javaScript:faqSearch('ETC');" class="category-menu-bg-link">
										<span class="spr-common ico-category-others"></span>기타
									</a>
								</li>
								<li class="category-menu-bg-item category-menu-bg-item-none">
									<a href="#" class="category-menu-bg-link">
										<span class="text-none">없음</span>
									</a>
								</li>
								<li class="category-menu-bg-item category-menu-bg-item-none">
									<a href="#" class="category-menu-bg-link">
										<span class="text-none">없음</span>
									</a>
								</li>
							</ul>

                            <a href="javaScript:faqMenuBox('N');" class="btn-close-link">닫기</a>
                            <a href="javaScript:faqMenuBox('Y');" class="btn-more-link">더보기</a>
							<input type="hidden" id="plus_yn" name="plus_yn" value="<?=$plus_yn?>">
						</div>


						<!-- 베스트 질문 // -->
						<h3 class="info-title info-title--sub">
						<?
						$faq_title = "";
						switch($type){
							case 'ORDER__SHIPPING' : $faq_title = "주문/배송"; break;
							case 'GOODS' : $faq_title = "상품"; break;
							case 'PAY' : $faq_title = "결제"; break;
							case 'MILEAGE' : $faq_title = "마일리지"; break;
							case 'CANCEL__RETURN__CHANGE' : $faq_title = "취소/반품"; break;
							case 'COUPON' : $faq_title = "쿠폰"; break;
							case 'MEMBER' : $faq_title = "회원관리"; break;
							case 'EVENT' : $faq_title = "이벤트"; break;
							case 'ETC' : $faq_title = "기타"; break;
							case 'SEARCH' : $faq_title = "검색결과"; break;
							default : $faq_title = "베스트질문"; break;
						}
						echo $faq_title;
						?>
						</h3>
						<div id="customerQna" class="customer-qna-box">
							<ul class="customer-qna-list">
								<?
								$idx = 1;
								foreach($faq as $frow){?>
								<li class="customer-qna-item" data-toggle="toggle-parent">
									<!-- 활성화 시 클래스 active 추가 -->
									<!-- 질문//-->
									<div class="customer-question-box">
										<span class="customer-ico"><?=$idx++?></span>
										<a href="#" class="customer-question-tlt-link" data-toggle="toggle-link">
											<span class="customer-question-tlt">[<?=$frow['CS_QUE_TYPE_CD_NM']?>] <?=$frow['TITLE']?></span>
										</a>
									</div>
									<!-- //질문 -->

									<!-- 답변// -->
									<div class="customer-answere-box" data-toggle="toggle-box">
										<p class="customer-answere-txt">
											<?=$frow['CONTENT']?>
										</p>
									</div>
									<!-- //답변 -->
								</li>
								<?}?>
							</ul>
						</div>
						<!-- // 베스트 질문  -->
					</div>
					<!-- // FAQ -->
				</div>
				<!-- // FAQ, 1:1문의, 묻고 답하기, 공지사항 -->

				<script>
                //====================================
                // 카테고리 메뉴
                //====================================
                $(document).ready(function(){
                    var type =  "<?=$type?>";
                    if( type ) {
                        $('.btn-more-link').parents('.category-menu-box').addClass('category-menu-box--open');
                    }
                });

				function faqMenuBox(val){
				    if( val == 'Y' ){
                        $('.btn-more-link').parents('.category-menu-box').addClass('category-menu-box--open');
                    } else {
                        $('.btn-more-link').parents('.category-menu-box').removeClass('category-menu-box--open');
                    }
                }

				//====================================
				// 검색
				//====================================
				function faqSearch(val){
					var page = 1;
					var keyword = $("input[name=faq_keyword]").val();
					var plus_yn = $("#plus_yn").val();
	//				var type = "<?=$type?>";

					var param = "";
					param += "page="			+ page;
					param += "&type="			+ val;
					param += "&keyword="		+ keyword;
					param += "&plus_yn="		+ plus_yn;
					document.location.href = "/customer/faq_page/"+page+"?"+param;
				}
				</script>
