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
					<div class="notice-content-wrap notice-content-wrap--content">
						<h3 class="info-title info-title--sub">공지사항</h3>
						<a href="/customer/notice" class="btn-white">목록</a>
						<div class="customer-notice-content-title">
							<span class="notice-title"><?=@$detail['TITLE']?></span>
							<span class="notice-date"><?=@date('Y-m-d', strtotime($detail['REG_DT']))?></span>
						</div>
						<div class="customer-notice-content-txt">
							<?=@$detail['CONTENT']?>

                            <?
                            if (strlen($detail['FILE_NAME']) != 0) {
                                $file_names = explode(',', $detail['FILE_NAME']);
                                $file_paths = explode(',', $detail['FILE_PATH']);
                                for ($i=0; $i < count($file_names); $i++){
                                    $ext = explode('.', $file_names[$i])[1];
                                    ?>
                                    <br><a href="<?=$file_paths[$i]?>" download="<?=$file_names[$i]?>"><?=$file_names[$i]?></a><br>
                                    <?
                                }
                            }
                            ?>
						</div>

<!--						<div class="customer-notice-content-txt">
							ETAH 회원님~ 안녕하세요!!<br></br>ETAH 회원으로 가입하시면 최대 3만원 할인이 가능한 10%쿠폰이 회원님 계정으로 쏙~ 들어가는 것 알고 계시나요? 해당 쿠폰을 사용하지 못하신 분들을 위해 사용 방법에 대해알려드리고자 합니다~<br><br>혹시 쿠폰 기한이 지나서 사용하지 못하신 분들이 있으시다면,아무런 망설임 없이 cs@etah.co.kr 로 회원명과 연락처만 간단하게 적어서 보내주시면 회원님 계정으로 쿠폰 재발급해드리고적어주신
							연락처로 SMS/이메일을 발송 공지해드리겠습니다!<br><br>그럼 본격적으로 회원가입 쿠폰과 사용 방법에 대해 설명드리겠습니다! ^^<br><br>Q-1. 회원가입 쿠폰이란?<br>A-1. ETAH 회원으로 가입하신 분들에게 상품 판매가의 10%할인 쿠폰을 회원님 계정으로 지급하고 있습니다.회원가입 혜택 쿠폰은 상품 1개 단위에 적용하실 수 있으며,“ETAH회원가입혜택_10%쿠폰”이라는 명칭의 쿠폰을선택하시면 (주문수량과 관계없이)
							최대 3만원까지 할인 받으실 수 있습니다.쿠폰에 대한 추가적인 설명은
							<<이벤트 페이지>>에서 참조하실 수 있습니다!<br><br>Q-2. 회원 가입 후 쿠폰을 수령했는지 어떻게 확인할 수 있나요?<br>A-2. ETAH 사이트에 방문하셔서 로그인 후, 마이페이지에들어가셔서 확인하실 수 있습니다.
								<div class="notice-img">
									<img src="/assets/images/data/notice_content.jpg" alt="">
								</div>
								① 우측 상단에 쿠폰 아이콘에 1장 이상 있으면 클릭하셔도 되고,<br>② 왼쪽 “나의 혜택관리” 메뉴에서 “쿠폰현황”을 클릭해서 보유여부 확인하셔도 됩니다.<br>③ 만약 쿠폰 기한(회원 가입일 기준 1개월)이 만료되었다면“지난 쿠폰 내역”에서 찾으실 수 있는데,이 쿠폰을 다시 살리고 싶으시다면 cs@etah.co.kr 로 회원명과연락처만 간단하게 적어서 보내주세요!그럼 저희가 쿠폰을 재발급해드리고 적어주신 연락처로SMS/이메일
								발송 공지해드리겠습니다.
						</div>-->

						<ul class="common-btn-box">
							<li class="common-btn-item"><a href="/customer/notice" class="btn-gray btn-gray--big">목록보기</a></li>
						</ul>
					</div>
					<!-- // 1:1문의(비회원) -->
				</div>
				<!-- // FAQ, 1:1문의, 공지사항 -->