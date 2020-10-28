<link rel="stylesheet" href="/assets/css/customert_center.css?var=1.0">

			<div class="content">
				<h2 class="page-title-basic">고객센터</h2>

				<!-- FAQ, 1:1문의, 묻고 답하기, 공지사항 // -->
				<div class="tab-customer-center">
					<!-- tab영역// -->
                    <ul class="tab-common-list">
                        <li class="tab-common-btn"><a href="/customer/faq" class="tab-common-btn-link">FAQ</a></li>
                        <li class="tab-common-btn"><a href="/customer/register_qna" class="tab-common-btn-link">1:1문의</a></li>
<!--                        <li class="tab-common-btn"><a href="/customer/qna_list_all" class="tab-common-btn-link">묻고 답하기</a></li>-->
                        <li class="tab-common-btn active"><a href="#NoticeTab" class="tab-common-btn-link" data-ui="btn-tab">공지사항</a></li>
                    </ul>
					<!-- //tab영역 -->

					<!-- 공지사항(리스트) // -->
					<div id="NoticeTab" class="notice-content-wrap">
						<h3 class="info-title info-title--sub">공지사항</h3>
						<ul class="customer-notice-list">
						<? foreach($notice as $row){?>
							<li class="customer-notice-item">
								<a href="/customer/notice_detail/<?=$row['NOTICE_NO']?>" class="customer-notice-link">
									<span class="notice-title"><?=$row['TITLE']?></span>
									<span class="notice-date"><?=date('Y-m-d', strtotime($row['REG_DT']))?></span>
								</a>
							</li>
						<?}?>
							<!--<li class="customer-notice-item">
                                <a href="#" class="customer-notice-link">
                                    <span class="notice-title">그것이 알고 싶다! ETAH 회원가입 10% 쿠폰 사용법!</span>
                                    <span class="notice-date">2016-12-02</span>
                                </a>
                            </li>-->
						</ul>
                    <?=$pagination?><br/>
					</div>
					<!-- // 1:1문의(비회원) -->
				</div>
				<!-- // FAQ, 1:1문의, 묻고 답하기, 공지사항 -->