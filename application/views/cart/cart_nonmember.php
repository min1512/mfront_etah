			<link rel="stylesheet" href="../assets/css/cart_order.css">

			<div class="content">

				<h2 class="page-title-basic page-title-basic--line">주문&#47;결제</h2>

				<div class="non-member-order-page">
					<h3 class="info-title info-title--sub">비회원 주문 이용약관</h3>

					<div class="agree-check-area">
						<div class="order-info-all-check">
							<input type="checkbox" id="orderNonMemberAgree0" class="checkbox" onClick="javascript:jsChkAll(this.checked);">
							<label for="orderNonMemberAgree0" class="checkbox-label">모든 이용약관에 동의합니다.</label>
						</div>

						<ul class="check-text-list">
							<li class="check-text-item">
								<input type="checkbox" id="orderNonMemberAgree1" name="formAgree[]" class="checkbox">
								<label for="orderNonMemberAgree1" class="checkbox-label">(주)에타 웹사이트 이용약관 (필수)</label>
								<a href="#nonMemberlayerAgreeUtil" class="btn-all-view-link" data-layer="bottom-layer-open2">내용확인</a>
							</li>
							<li class="check-text-item check-text-item--modify">
								<input type="checkbox" id="orderNonMemberAgree2" name="formAgree[]" class="checkbox">
								<label for="orderNonMemberAgree2" class="checkbox-label">비회원 개인정보수집 및 이용에 대한 동의 (필수)</label>
								<a href="#nonMemberlayerPersonalAgreeUtil" class="btn-all-view-link" data-layer="bottom-layer-open2">내용확인</a>
							</li>
						</ul>
					</div>
					<ul class="common-btn-box">
						<li class="common-btn-item"><a href="/goods/detail/<?=$param['goods_code']?>" class="btn-white btn-white--big">취소</a></li>
						<li class="common-btn-item"><a href="javascript://" class="btn-black btn-black--big" onClick="javascript:jsOrder();">다음</a></li>
					</ul>
				</div>


				<!-- 이용약관 동의 레이어 // -->
				<div class="common-layer-wrap" id="nonMemberlayerAgreeUtil">
					<h3 class="common-layer-title">(주)에타 웹사이트 이용약관(필수)</h3>

					<!-- common-layer-content // -->
					<div class="common-layer-content order-nonmember-layer">
						<div class="order_use_clause_content">
							<ul class="use_clause_list">
								<li>
									<span class="title">제1조(목적)</span>
									<p class="use-clause-txt">이 약관은 (주)에타(전자상거래 사업자)가 운영하는 에타 사이버 몰(이하 “몰”이라 한다)에서 제공하는 인터넷 관련 서비스(이하 “서비스”라 한다)를 이용함에 있어 사이버 몰과 이용자의 권리․의무 및 책임사항을 규정함을 목적으로 합니다.</p>
									<p class="use-clause-txt"> ※「PC통신, 무선 등을 이용하는 전자상거래에 대해서도 그 성질에 반하지 않는 한 이 약관을 준용합니다.」</p>
								</li>
								<li>
									<span class="title">제2조(정의)</span>
									<ul>
										<li class="use-clause-item">① “몰”이란 에타가 재화 또는 용역(이하 “재화 등”이라 함)을 이용자에게 제공하기 위하여 컴퓨터 등 정보통신설비를 이용하여 재화 등을 거래할 수 있도록 설정한 가상의 영업장을 말하며, 아울러 사이버몰을 운영하는 사업자의 의미로도 사용합니다.</li>
										<li class="use-clause-item">② “이용자”란 “몰”에 접속하여 이 약관에 따라 “몰”이 제공하는 서비스를 받는 회원 및 비회원을 말합니다.</li>
										<li class="use-clause-item">③ ‘회원’이라 함은 “몰”에 회원등록을 한 자로서, 계속적으로 “몰”이 제공하는 서비스를 이용할 수 있는 자를 말합니다.</li>
										<li class="use-clause-item">④ ‘비회원’이라 함은 회원에 가입하지 않고 “몰”이 제공하는 서비스를 이용하는 자를 말합니다.</li>
										<li class="use-clause-item">⑤ ‘서비스’라 함은 다양한 정보의 제공 및 상품(재화와 용역 포함)의 판매 또는 상품과 관련한 다양한 판촉행위 및, 기타 부가 서비스를 말합니다.</li>
										<li class="use-clause-item">⑥ ‘마일리지’라 함은 "몰"이 특정 재화 등을 구입한 이용자 또는 경품 등의 목적으로 이용자에게 부여한 사이버머니를 말하며, 적립금의 부여 및 사용 등과 관련한 사항은 이 약관 또는 "몰"의 운영정책이 정한 바에 따릅니다.</li>
									</ul>
								</li>


								<li>
									<span class="title">제3조 (약관 등의 명시와 설명 및 개정) </span>
									<ul>
										<li class="use-clause-item">① “몰”은 이 약관의 내용과 상호 및 대표자 성명, 영업소 소재지 주소(소비자의 불만을 처리할 수 있는 곳의 주소를 포함), 전화번호․모사전송번호․전자우편주소, 사업자등록번호, 통신판매업 신고번호, 개인정보관리책임자등을 이용자가 쉽게 알 수 있도록 에타 사이버몰의 서비스화면에 게시합니다. 다만, 약관의 내용은 이용자가 연결화면을 통하여 볼 수 있도록 할 수 있습니다.</li>
										<li class="use-clause-item">② “몰”은 이용자가 약관에 동의하기에 앞서 약관에 정하여져 있는 내용 중 청약철회․배송책임․환불조건 등과 같은 중요한 내용을 이용자가 이해할 수 있도록 별도의 연결화면 또는 팝업화면 등을 제공하여 이용자의 확인을 구하여야 합니다.</li>
										<li class="use-clause-item">③ “몰”은 「전자상거래 등에서의 소비자보호에 관한 법률」, 「약관의 규제에 관한 법률」, 「전자문서 및 전자거래기본법」, 「전자금융거래법」, 「전자서명법」, 「정보통신망 이용촉진 및 정보보호 등에 관한 법률」, 「방문판매 등에 관한 법률」, 「소비자기본법」 등 관련 법을 위배하지 않는 범위에서 이 약관을 개정할 수 있습니다.</li>
										<li class="use-clause-item">④ “몰”이 약관을 개정할 경우에는 적용일자 및 개정사유를 명시하여 현행약관과 함께 몰의 초기화면에 그 적용일자 7일 이전부터 적용일자 전일까지 공지합니다. 다만, 이용자에게 불리하게 약관내용을 변경하는 경우에는 최소한 30일 이상의 사전 유예기간을 두고 공지합니다. 이 경우 "몰“은 개정 전 내용과 개정 후 내용을 명확하게 비교하여 이용자가 알기 쉽도록 표시합니다. </li>
										<li class="use-clause-item">⑤ “몰”이 약관을 개정할 경우에는 그 개정약관은 그 적용일자 이후에 체결되는 계약에만 적용되고 그 이전에 이미 체결된 계약에 대해서는 개정 전의 약관조항이 그대로 적용됩니다. 다만 이미 계약을 체결한 이용자가 개정약관 조항의 적용을 받기를 원하는 뜻을 제3항에 의한 개정약관의 공지기간 내에 “몰”에 송신하여 “몰”의 동의를 받은 경우에는 개정약관 조항이 적용됩니다.</li>
										<li class="use-clause-item">⑥ 이 약관에서 정하지 아니한 사항과 이 약관의 해석에 관하여는 전자상거래 등에서의 소비자보호에 관한 법률, 약관의 규제 등에 관한 법률, 공정거래위원회가 정하는 전자상거래 등에서의 소비자 보호지침 및 관계법령 또는 상관례에 따릅니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제4조(서비스의 제공 및 변경) </span>
									<ul>
										<li class="use-clause-item">① “몰”은 다음과 같은 업무를 수행합니다.
											<ul>
												<li class="use-clause-item">1. 재화 또는 용역에 대한 정보 제공 및 구매계약의 체결</li>
												<li class="use-clause-item">2. 구매계약이 체결된 재화 또는 용역의 배송</li>
												<li class="use-clause-item">3. 기타 “몰”이 정하는 업무</li>
											</ul>
										</li>

										<li class="use-clause-item">② “몰”은 재화 또는 용역의 품절 또는 기술적 사양의 변경 등의 경우에는 장차 체결되는 계약에 의해 제공할 재화 또는 용역의 내용을 변경할 수 있습니다. 이 경우에는 변경된 재화 또는 용역의 내용 및 제공일자를 명시하여 현재의 재화 또는 용역의 내용을 게시한 곳에 즉시 공지합니다.</li>

										<li class="use-clause-item">③ “몰”이 제공하기로 이용자와 계약을 체결한 서비스의 내용을 재화 등의 품절 또는 기술적 사양의 변경 등의 사유로 변경할 경우에는 그 사유를 이용자에게 통지 가능한 주소로 즉시 통지합니다.</li>

										<li class="use-clause-item">④ 전항의 경우 “몰”은 이로 인하여 이용자가 입은 손해를 배상합니다. 다만, “몰”이 고의 또는 과실이 없음을 입증하는 경우에는 그러하지 아니합니다.</li>

										<li class="use-clause-item">⑤ “몰”은 무료로 제공되는 "서비스"의 일부 또는 전부를 회사의 정책 및 운영의 필요상 수정, 중단, 변경할 수 있으며, 이에 대하여 관련법에 특별한 규정이 없는 한 "회원"에게 별도의 보상을 하지 않습니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제5조(서비스의 중단) </span>
									<ul>
										<li class="use-clause-item">① “몰”은 컴퓨터 등 정보통신설비의 보수점검․교체 및 고장, 통신의 두절 등의 사유가 발생한 경우에는 서비스의 제공을 일시적으로 중단할 수 있습니다.</li>
										<li class="use-clause-item">② “몰”은 제1항의 사유로 서비스의 제공이 일시적으로 중단됨으로 인하여 이용자 또는 제3자가 입은 손해에 대하여 배상합니다. 단, “몰”이 고의 또는 과실이 없음을 입증하는 경우에는 그러하지 아니합니다.</li>
										<li class="use-clause-item">③ 사업종목의 전환, 사업의 포기, 업체 간의 통합 등의 이유로 서비스를 제공할 수 없게 되는 경우에는 “몰”은 제8조에 정한 방법으로 이용자에게 통지하고 당초 “몰”에서 제시한 조건에 따라 소비자에게 보상합니다. 다만, “몰”이 보상기준 등을 고지하지 아니한 경우에는 이용자들의 마일리지 또는 적립금 등을 “몰”에서 통용되는 통화가치에 상응하는 현물 또는 현금으로 이용자에게 지급합니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제6조(회원가입) </span>
									<ul>
										<li class="use-clause-item">① 이용자는 “몰”이 정한 가입 양식에 따라 회원정보를 기입한 후 이 약관에 동의한다는 의사표시를 함으로서 회원가입을 신청합니다.</li>
										<li class="use-clause-item">② “몰”은 제1항과 같이 회원으로 가입할 것을 신청한 이용자 중 다음 각 호에 해당하지 않는 한 회원으로 등록합니다.
											<ul>
												<li class="use-clause-item">1. 가입신청자가 이 약관 제7조제3항에 의하여 이전에 회원자격을 상실한 적이 있는 경우, 다만 제7조제3항에 의한 회원자격 상실 후 3년이 경과한 자로서 “몰”의 회원재가입 승낙을 얻은 경우에는 예외로 한다.</li>
												<li class="use-clause-item">2. 등록 내용에 허위, 기재누락, 오기가 있는 경우</li>
												<li class="use-clause-item">3. 기타 회원으로 등록하는 것이 “몰”의 기술상 현저히 지장이 있다고 판단되는 경우</li>
											</ul>
										</li>
										<li class="use-clause-item">③ 회원가입계약의 성립 시기는 “몰”의 승낙이 회원에게 도달한 시점으로 합니다.</li>
										<li class="use-clause-item">④ 회원은 회원가입 시 등록한 사항에 변경이 있는 경우, 상당한 기간 이내에 “몰”에 대하여 회원정보 수정 등의 방법으로 그 변경사항을 알려야 합니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제7조(회원 탈퇴 및 자격 상실 등) </span>
									<ul>
										<li class="use-clause-item">① 회원은 “몰”에 언제든지 탈퇴를 요청할 수 있으며 “몰”은 즉시 회원탈퇴를 처리합니다.</li>
										<li class="use-clause-item">② 회원이 다음 각 호의 사유에 해당하는 경우, “몰”은 회원자격을 제한 및 정지시킬 수 있습니다.
											<ul>
												<li class="use-clause-item">1. 가입 신청 시에 허위 내용을 등록한 경우</li>
												<li class="use-clause-item">2. “몰”을 이용하여 구입한 재화 등의 대금, 기타 “몰”이용에 관련하여 회원이 부담하는 채무를 기일에 지급하지 않는 경우</li>
												<li class="use-clause-item">3. 다른 사람의 “몰” 이용을 방해하거나 그 정보를 도용하는 등 전자상거래 질서를 위협하는 경우</li>
												<li class="use-clause-item">4. “몰”을 이용하여 법령 또는 이 약관이 금지하거나 공서양속에 반하는 행위를 하는 경우</li>
											</ul>
										</li>
										<li class="use-clause-item">③ “몰”이 회원 자격을 제한․정지 시킨 후, 동일한 행위가 2회 이상 반복되거나 30일 이내에 그 사유가 시정되지 아니하는 경우 “몰”은 회원자격을 상실시킬 수 있습니다.</li>
										<li class="use-clause-item">④ “몰”이 회원자격을 상실시키는 경우에는 회원등록을 말소합니다. 이 경우 회원에게 이를 통지하고, 회원등록 말소 전에 최소한 30일 이상의 기간을 정하여 소명할 기회를 부여합니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제8조(회원에 대한 통지)</span>
									<ul>
										<li class="use-clause-item">① “몰”이 회원에 대한 통지를 하는 경우, 회원이 “몰”과 미리 약정하여 지정한 전자우편 주소로 할 수 있습니다.</li>
										<li class="use-clause-item">② “몰”은 불특정다수 회원에 대한 통지의 경우 1주일이상 “몰” 게시판에 게시함으로서 개별 통지에 갈음할 수 있습니다. 다만, 회원 본인의 거래와 관련하여 중대한 영향을 미치는 사항에 대하여는 개별통지를 합니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제9조(구매신청 및 개인정보 제공 동의 등) </span>
									<ul>
										<li class="use-clause-item">① “몰”이용자는 “몰”상에서 다음 또는 이와 유사한 방법에 의하여 구매를 신청하며, “몰”은 이용자가 구매신청을 함에 있어서 다음의 각 내용을 알기 쉽게 제공하여야 합니다.
											<ul>
												<li class="use-clause-item">1. 재화 등의 검색 및 선택</li>
												<li class="use-clause-item">2. 받는 사람의 성명, 주소, 전화번호, 전자우편주소(또는 이동전화번호) 등의 입력</li>
												<li class="use-clause-item">3. 약관내용, 청약철회권이 제한되는 서비스, 배송료․설치비 등의 비용부담과 관련한 내용에 대한 확인</li>
												<li class="use-clause-item">4. 이 약관에 동의하고 위 3.호의 사항을 확인하거나 거부하는 표시 (예, 마우스 클릭)</li>
												<li class="use-clause-item">5. 재화 등의 구매신청 및 이에 관한 확인 또는 “몰”의 확인에 대한 동의</li>
												<li class="use-clause-item">6. 결제방법의 선택</li>
											</ul>
										</li>
										<li class="use-clause-item">② “몰”이 제3자에게 구매자 개인정보를 제공할 필요가 있는 경우 1) 개인정보를 제공받는 자, 2)개인정보를 제공받는 자의 개인정보 이용목적, 3) 제공하는 개인정보의 항목, 4) 개인정보를 제공받는 자의 개인정보 보유 및 이용기간을 구매자에게 알리고 동의를 받아야 합니다. (동의를 받은 사항이 변경되는 경우에도 같습니다.)</li>
										<li class="use-clause-item">③ “몰”이 제3자에게 구매자의 개인정보를 취급할 수 있도록 업무를 위탁하는 경우에는 1) 개인정보 취급위탁을 받는 자, 2) 개인정보 취급위탁을 하는 업무의 내용을 구매자에게 알리고 동의를 받아야 합니다. (동의를 받은 사항이 변경되는 경우에도 같습니다.) 다만, 서비스제공에 관한 계약이행을 위해 필요하고 구매자의 편의증진과 관련된 경우에는 「정보통신망 이용촉진 및 정보보호 등에 관한 법률」에서 정하고 있는 방법으로 개인정보
											취급방침을 통해 알림으로써 고지절차와 동의절차를 거치지 않아도 됩니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제10조 (계약의 성립)</span>
									<ul>
										<li class="use-clause-item">① “몰”은 제9조와 같은 구매신청에 대하여 다음 각 호에 해당하면 승낙하지 않을 수 있습니다. 다만, 미성년자와 계약을 체결하는 경우에는 법정대리인의 동의를 얻지 못하면 미성년자 본인 또는 법정대리인이 계약을 취소할 수 있다는 내용을 고지하여야 합니다.
											<ul>
												<li class="use-clause-item">1. 신청 내용에 허위, 기재누락, 오기가 있는 경우</li>
												<li class="use-clause-item">2. 미성년자가 담배, 주류 등 청소년보호법에서 금지하는 재화 및 용역을 구매하는 경우</li>
												<li class="use-clause-item">3. 기타 구매신청에 승낙하는 것이 “몰” 기술상 현저히 지장이 있다고 판단하는 경우</li>
											</ul>
										</li>
										<li class="use-clause-item">② “몰”의 승낙이 제12조제1항의 수신확인통지형태로 이용자에게 도달한 시점에 계약이 성립한 것으로 봅니다.</li>
										<li class="use-clause-item">③ “몰”의 승낙의 의사표시에는 이용자의 구매 신청에 대한 확인 및 판매가능 여부, 구매신청의 정정 취소 등에 관한 정보 등을 포함하여야 합니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제11조(지급방법)</span>
									<p class="use-clause-txt">“몰”에서 구매한 재화 또는 용역에 대한 대금지급방법은 다음 각 호의 방법 중 가용한 방법으로 할 수 있습니다. 단, “몰”은 이용자의 지급방법에 대하여 재화 등의 대금에 어떠한 명목의 수수료도 추가하여 징수할 수 없습니다.</p>
									<ul>
										<li class="use-clause-item">1. 폰뱅킹, 인터넷뱅킹, 메일 뱅킹 등의 각종 계좌이체</li>
										<li class="use-clause-item">2. 선불카드, 직불카드, 신용카드 등의 각종 카드 결제</li>
										<li class="use-clause-item">3. 온라인무통장입금</li>
										<li class="use-clause-item">4. 전자화폐에 의한 결제</li>
										<li class="use-clause-item">5. 수령 시 대금지급</li>
										<li class="use-clause-item">6. 마일리지 등 “몰”이 지급한 포인트에 의한 결제
										</li>
										<li class="use-clause-item">7. “몰”과 계약을 맺었거나 “몰”이 인정한 상품권에 의한 결제</li>
										<li class="use-clause-item">8. 기타 전자적 지급 방법에 의한 대금 지급 등</li>
									</ul>
								</li>

								<li>
									<span class="title">제12조(수신확인통지․구매신청 변경 및 취소)</span>
									<p class="use-clause-txt">“몰”에서 구매한 재화 또는 용역에 대한 대금지급방법은 다음 각 호의 방법 중 가용한 방법으로 할 수 있습니다. 단, “몰”은 이용자의 지급방법에 대하여 재화 등의 대금에 어떠한 명목의 수수료도 추가하여 징수할 수 없습니다.</p>
									<ul>
										<li class="use-clause-item">① “몰”은 이용자의 구매신청이 있는 경우 이용자에게 수신확인통지를 합니다.</li>
										<li class="use-clause-item">② 수신확인통지를 받은 이용자는 의사표시의 불일치 등이 있는 경우에는 수신확인통지를 받은 후 즉시 구매신청 변경 및 취소를 요청할 수 있고 “몰”은 배송 전에 이용자의 요청이 있는 경우에는 지체 없이 그 요청에 따라 처리하여야 합니다. 다만 이미 대금을 지불한 경우에는 제15조의 청약철회 등에 관한 규정에 따릅니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제13조(재화 등의 공급)</span>
									<ul>
										<li class="use-clause-item">① “몰”은 이용자와 재화 등의 공급시기에 관하여 별도의 약정이 없는 이상, 이용자가 청약을 한 날부터 7일 이내에 재화 등을 배송할 수 있도록 주문제작, 포장 등 기타의 필요한 조치를 취합니다. 다만, “몰”이 이미 재화 등의 대금의 전부 또는 일부를 받은 경우에는 대금의 전부 또는 일부를 받은 날부터 3영업일 이내에 조치를 취합니다. 이때 “몰”은 이용자가 재화 등의 공급 절차 및 진행 사항을 확인할 수 있도록 적절한 조치를
											합니다.
										</li>
										<li class="use-clause-item">② “몰”은 이용자가 구매한 재화에 대해 배송수단, 수단별 배송비용 부담자, 수단별 배송기간 등을 명시합니다. 만약 “몰”이 약정 배송기간을 초과한 경우에는 그로 인한 이용자의 손해를 배상하여야 합니다. 다만 “몰”이 고의․과실이 없음을 입증한 경우에는 그러하지 아니합니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제14조(환급)</span>
									<p class="use-clause-txt">“몰”은 이용자가 구매신청한 재화 등이 품절 등의 사유로 인도 또는 제공을 할 수 없을 때에는 지체 없이 그 사유를 이용자에게 통지하고 사전에 재화 등의 대금을 받은 경우에는 대금을 받은 날부터 3영업일 이내에 환급하거나 환급에 필요한 조치를 취합니다.</p>
								</li>

								<li>
									<span class="title">제15조(청약철회 등)</span>
									<ul>
										<li class="use-clause-item">① “몰”과 재화등의 구매에 관한 계약을 체결한 이용자는 「전자상거래 등에서의 소비자보호에 관한 법률」 제13조 제2항에 따른 계약내용에 관한 서면을 받은 날(그 서면을 받은 때보다 재화 등의 공급이 늦게 이루어진 경우에는 재화 등을 공급받거나 재화 등의 공급이 시작된 날을 말합니다)부터 7일 이내에는 청약의 철회를 할 수 있습니다. 다만, 청약철회에 관하여 「전자상거래 등에서의 소비자보호에 관한 법률」에 달리 정함이 있는 경우에는
											동 법 규정에 따릅니다. </li>
										<li class="use-clause-item">② 이용자는 재화 등을 배송 받은 경우 다음 각 호의 1에 해당하는 경우에는 반품 및 교환을 할 수 없습니다.
											<ul>
												<li class="use-clause-item">1. 이용자에게 책임 있는 사유로 재화 등이 멸실 또는 훼손된 경우(다만, 재화 등의 내용을 확인하기 위하여 포장 등을 훼손한 경우에는 청약철회를 할 수 있습니다)</li>
												<li class="use-clause-item">2. 이용자의 사용 또는 일부 소비에 의하여 재화 등의 가치가 현저히 감소한 경우</li>
												<li class="use-clause-item">3. 시간의 경과에 의하여 재판매가 곤란할 정도로 재화등의 가치가 현저히 감소한 경우</li>
												<li class="use-clause-item">4. 같은 성능을 지닌 재화 등으로 복제가 가능한 경우 그 원본인 재화 등의 포장을 훼손한 경우</li>
											</ul>
										</li>
										<li class="use-clause-item">③ 제2항제2호 내지 제4호의 경우에 “몰”이 사전에 청약철회 등이 제한되는 사실을 소비자가 쉽게 알 수 있는 곳에 명기하거나 시용상품을 제공하는 등의 조치를 하지 않았다면 이용자의 청약철회 등이 제한되지 않습니다.</li>
										<li class="use-clause-item">④ 이용자는 제1항 및 제2항의 규정에 불구하고 재화 등의 내용이 표시·광고 내용과 다르거나 계약내용과 다르게 이행된 때에는 당해 재화 등을 공급받은 날부터 3월 이내, 그 사실을 안 날 또는 알 수 있었던 날부터 30일 이내에 청약철회 등을 할 수 있습니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제16조(청약철회 등의 효과)</span>
									<ul>
										<li class="use-clause-item">① “몰”은 이용자로부터 재화 등을 반환받은 경우 3영업일 이내에 이미 지급받은 재화 등의 대금을 환급합니다. 이 경우 “몰”이 이용자에게 재화 등의 환급을 지연한때에는 그 지연기간에 대하여 「전자상거래 등에서의 소비자보호에 관한 법률 시행령」제21조의2에서 정하는 지연이자율을 곱하여 산정한 지연이자를 지급합니다.</li>
										<li class="use-clause-item">② “몰”은 위 대금을 환급함에 있어서 이용자가 신용카드 또는 전자화폐 등의 결제수단으로 재화 등의 대금을 지급한 때에는 지체 없이 당해 결제수단을 제공한 사업자로 하여금 재화 등의 대금의 청구를 정지 또는 취소하도록 요청합니다.</li>
										<li class="use-clause-item">③ 청약철회 등의 경우 공급받은 재화 등의 반환에 필요한 비용은 이용자가 부담합니다. “몰”은 이용자에게 청약철회 등을 이유로 위약금 또는 손해배상을 청구하지 않습니다. 다만 재화 등의 내용이 표시·광고 내용과 다르거나 계약내용과 다르게 이행되어 청약철회 등을 하는 경우 재화 등의 반환에 필요한 비용은 “몰”이 부담합니다.</li>
										<li class="use-clause-item">④ 이용자가 재화 등을 제공받을 때 발송비를 부담한 경우에 “몰”은 청약철회 시 그 비용을 누가 부담하는지를 이용자가 알기 쉽도록 명확하게 표시합니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제17조(마일리지)</span>
									<ul>
										<li class="use-clause-item">① "몰"은 재화 등을 구입하거나 특정 결제 수단으로 구입하는 이용자에게 또는 경품 등의 목적으로 이용자에게 마일리지를 부여할 수 있습니다. 마일리지의 적립 및 사용 등과 관련한 사항은 이 약관 또는 "몰"의 운영정책이 정한 바에 따릅니다.</li>
										<li class="use-clause-item">② 1마일리지는 1원의 의미가 있으며, "몰" 및 회사가 운영하는 다른 서비스에서 재화 등 구매 시 현금가액과 동일하게 1,000원 단위로 마일리지를 사용할 수 있습니다 (단, 마일리지 사용이 불가하다고 사전 고지한 품목은 제외됩니다). 타인에게 양도하거나 현금으로 교환할 수 없으며, 부정한 목적이나 용도로 사용할 수 없습니다. </li>
										<li class="use-clause-item">③ 상품구매 후 취소 또는 반품을 할 경우에는 상품 구매 시 “몰”이 부여한 마일리지를 회수합니다.</li>
										<li class="use-clause-item">④ 마일리지 유효기간은 적립일로부터 24개월이며 유효기간이 경과된 마일리지는 자동 소멸됩니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제18조(할인쿠폰)</span>
									<ul>
										<li class="use-clause-item">① “몰” 또는 판매자는 구매서비스를 이용하는 회원에게 상품 구매 시 일정금액 또는 일정비율을 할인 받을 수 있는 할인 쿠폰을 발급할 수 있습니다.</li>
										<li class="use-clause-item">② 할인 쿠폰은 회원 본인의 구매에만 사용할 수 있으며, 어떠한 경우에도 타인에게 매매하거나 양도할 수 없습니다.</li>
										<li class="use-clause-item">③ 할인 쿠폰은 일부 품목이나 금액에 따라 사용이 제한될 수 있으며 유효기간이 지난 후에는 사용할 수 없고, 상품구매 후 취소나 반품으로 환불이 이루어졌을 때에는 재사용을 할 수 없습니다.</li>
										<li class="use-clause-item">④ 구매자에게 제공된 할인 쿠폰은 한 상품 구매 때 중복으로 사용할 수 없습니다. 단, 할인 쿠폰의 발행자가 서로 다르면 중복으로 사용할 수도 있습니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제19조(개인정보보호)</span>
									<ul>
										<li class="use-clause-item">① “몰”은 이용자의 개인정보 수집시 서비스제공을 위하여 필요한 범위에서 최소한의 개인정보를 수집합니다. </li>
										<li class="use-clause-item">② “몰”은 회원가입시 구매계약이행에 필요한 정보를 미리 수집하지 않습니다. 다만, 관련 법령상 의무이행을 위하여 구매계약 이전에 본인확인이 필요한 경우로서 최소한의 특정 개인정보를 수집하는 경우에는 그러하지 아니합니다.</li>
										<li class="use-clause-item">③ “몰”은 이용자의 개인정보를 수집·이용하는 때에는 당해 이용자에게 그 목적을 고지하고 동의를 받습니다. </li>
										<li class="use-clause-item">④ “몰”은 수집된 개인정보를 목적 외의 용도로 이용할 수 없으며, 새로운 이용목적이 발생한 경우 또는 제3자에게 제공하는 경우에는 이용·제공단계에서 당해 이용자에게 그 목적을 고지하고 동의를 받습니다. 다만, 관련 법령에 달리 정함이 있는 경우에는 예외로 합니다.</li>
										<li class="use-clause-item">⑤ “몰”이 제2항과 제3항에 의해 이용자의 동의를 받아야 하는 경우에는 개인정보관리 책임자의 신원(소속, 성명 및 전화번호, 기타 연락처), 정보의 수집목적 및 이용목적, 제3자에 대한 정보제공 관련사항(제공받은자, 제공목적 및 제공할 정보의 내용) 등 「정보통신망 이용촉진 및 정보보호 등에 관한 법률」 제22조제2항이 규정한 사항을 미리 명시하거나 고지해야 하며 이용자는 언제든지 이 동의를 철회할 수 있습니다.</li>
										<li class="use-clause-item">⑥ 이용자는 언제든지 “몰”이 가지고 있는 자신의 개인정보에 대해 열람 및 오류정정을 요구할 수 있으며 “몰”은 이에 대해 지체 없이 필요한 조치를 취할 의무를 집니다. 이용자가 오류의 정정을 요구한 경우에는 “몰”은 그 오류를 정정할 때까지 당해 개인정보를 이용하지 않습니다.</li>
										<li class="use-clause-item">⑦ “몰”은 개인정보 보호를 위하여 이용자의 개인정보를 취급하는 자를 최소한으로 제한하여야 하며 신용카드, 은행계좌 등을 포함한 이용자의 개인정보의 분실, 도난, 유출, 동의 없는 제3자 제공, 변조 등으로 인한 이용자의 손해에 대하여 모든 책임을 집니다.</li>
										<li class="use-clause-item">⑧ “몰” 또는 그로부터 개인정보를 제공받은 제3자는 개인정보의 수집목적 또는 제공받은 목적을 달성한 때에는 당해 개인정보를 지체 없이 파기합니다.</li>
										<li class="use-clause-item">⑨ “몰”은 개인정보의 수집·이용·제공에 관한 동의 란을 미리 선택한 것으로 설정해두지 않습니다. 또한 개인정보의 수집·이용·제공에 관한 이용자의 동의거절시 제한되는 서비스를 구체적으로 명시하고, 필수수집항목이 아닌 개인정보의 수집·이용·제공에 관한 이용자의 동의 거절을 이유로 회원가입 등 서비스 제공을 제한하거나 거절하지 않습니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제20조(“몰“의 의무)</span>
									<ul>
										<li class="use-clause-item">① “몰”은 법령과 이 약관이 금지하거나 공서양속에 반하는 행위를 하지 않으며 이 약관이 정하는 바에 따라 지속적이고, 안정적으로 재화․용역을 제공하는데 최선을 다하여야 합니다.</li>
										<li class="use-clause-item">② “몰”은 이용자가 안전하게 인터넷 서비스를 이용할 수 있도록 이용자의 개인정보(신용정보 포함)보호를 위한 보안 시스템을 갖추어야 합니다.</li>
										<li class="use-clause-item">③ “몰”이 상품이나 용역에 대하여 「표시․광고의 공정화에 관한 법률」 제3조 소정의 부당한 표시․광고행위를 함으로써 이용자가 손해를 입은 때에는 이를 배상할 책임을 집니다.</li>
										<li class="use-clause-item">④ “몰”은 이용자가 원하지 않는 영리목적의 광고성 전자우편을 발송하지 않습니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제21조(회원의 ID 및 비밀번호에 대한 의무)</span>
									<ul>
										<li class="use-clause-item">① 제17조의 경우를 제외한 ID와 비밀번호에 관한 관리책임은 회원에게 있습니다.</li>
										<li class="use-clause-item">② 회원은 자신의 ID 및 비밀번호를 제3자에게 이용하게 해서는 안됩니다.</li>
										<li class="use-clause-item">③ 회원이 자신의 ID 및 비밀번호를 도난당하거나 제3자가 사용하고 있음을 인지한 경우에는 바로 “몰”에 통보하고 “몰”의 안내가 있는 경우에는 그에 따라야 합니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제22조(이용자의 의무) </span>
									<p class="use-clause-txt">이용자는 다음 행위를 하여서는 안 됩니다.</p>
									<ul>
										<li class="use-clause-item">1. 신청 또는 변경시 허위 내용의 등록</li>
										<li class="use-clause-item">2. 타인의 정보 도용</li>
										<li class="use-clause-item">3. “몰”에 게시된 정보의 변경</li>
										<li class="use-clause-item">4. “몰”이 정한 정보 이외의 정보(컴퓨터 프로그램 등) 등의 송신 또는 게시</li>
										<li class="use-clause-item">5. “몰” 기타 제3자의 저작권 등 지적재산권에 대한 침해</li>
										<li class="use-clause-item">6. “몰” 기타 제3자의 명예를 손상시키거나 업무를 방해하는 행위</li>
										<li class="use-clause-item">7. 외설 또는 폭력적인 메시지, 화상, 음성, 기타 공서양속에 반하는 정보를 몰에 공개 또는 게시하는 행위</li>
									</ul>
								</li>

								<li>
									<span class="title">제23조(연결“몰”과 피연결“몰” 간의 관계)</span>
									<ul>
										<li class="use-clause-item">① 상위 “몰”과 하위 “몰”이 하이퍼링크(예: 하이퍼링크의 대상에는 문자, 그림 및 동화상 등이 포함됨)방식 등으로 연결된 경우, 전자를 연결 “몰”(웹사이트)이라고 하고 후자를 피연결 “몰”(웹사이트)이라고 합니다.</li>
										<li class="use-clause-item">② 연결“몰”은 피연결“몰”이 독자적으로 제공하는 재화 등에 의하여 이용자와 행하는 거래에 대해서 보증 책임을 지지 않는다는 뜻을 연결“몰”의 초기화면 또는 연결되는 시점의 팝업화면으로 명시한 경우에는 그 거래에 대한 보증 책임을 지지 않습니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제24조(저작권의 귀속 및 이용제한)</span>
									<ul>
										<li class="use-clause-item">① “몰“이 작성한 저작물에 대한 저작권 기타 지적재산권은 ”몰“에 귀속합니다.</li>
										<li class="use-clause-item">② 이용자는 “몰”을 이용함으로써 얻은 정보 중 “몰”에게 지적재산권이 귀속된 정보를 “몰”의 사전 승낙 없이 복제, 송신, 출판, 배포, 방송 기타 방법에 의하여 영리목적으로 이용하거나 제3자에게 이용하게 하여서는 안됩니다.</li>
										<li class="use-clause-item">③ “몰”은 약정에 따라 이용자에게 귀속된 저작권을 사용하는 경우 당해 이용자에게 통보하여야 합니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제25조(분쟁해결)</span>
									<ul>
										<li class="use-clause-item">① “몰”은 이용자가 제기하는 정당한 의견이나 불만을 반영하고 그 피해를 보상처리하기 위하여 피해보상처리기구를 설치․운영합니다.</li>
										<li class="use-clause-item">② “몰”은 이용자로부터 제출되는 불만사항 및 의견은 우선적으로 그 사항을 처리합니다. 다만, 신속한 처리가 곤란한 경우에는 이용자에게 그 사유와 처리일정을 즉시 통보해 드립니다.</li>
										<li class="use-clause-item">③ “몰”과 이용자 간에 발생한 전자상거래 분쟁과 관련하여 이용자의 피해구제신청이 있는 경우에는 공정거래위원회 또는 시·도지사가 의뢰하는 분쟁조정기관의 조정에 따를 수 있습니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">제26조(재판권 및 준거법)</span>
									<ul>
										<li class="use-clause-item">① “몰”과 이용자 간에 발생한 전자상거래 분쟁에 관한 소송은 “몰”의 본사 소재지를 관할하는 법원을 합의관할법원으로 정합니다.</li>
										<li class="use-clause-item">② “몰”과 이용자 간에 제기된 전자상거래 소송에는 한국법을 적용합니다.</li>
									</ul>
								</li>

								<li class="use-clause-item">
									부 칙(시행일) 이 약관은 2016년 7월 4일부터 시행합니다.
								</li>
							</ul>
						</div>


						<div class="common-layer-button">
							<ul class="common-btn-box common-btn-box--layer">
								<li class="common-btn-item"><a href="#" class="btn-gray-link">확인</a></li>
							</ul>
						</div>
						<!-- // common-layer-button -->
					</div>
					<!-- // common-layer-content -->

					<a href="#" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>
				</div>

				<!-- // 이용약관 동의 레이어 -->

				<!-- 비회원 개인정보수집 및 이용 동의 레이어 // -->
				<div class="common-layer-wrap" id="nonMemberlayerPersonalAgreeUtil">
					<h3 class="common-layer-title">비회원 개인정보수집 및 이용에 대한 동의 (필수)</h3>

					<!-- common-layer-content // -->
					<div class="common-layer-content order-nonmember-layer">
						<div class="order_use_clause_content">
							<ul class="use_clause_list">
								<li>
									<p class="use-clause-txt">주식회사 에타(이하 '에타')는 개인정보보호법에 따라 이용자의 개인정보 보호 및 권익을 보호하고 개인정보와 관련한 이용자의 고충을 원활하게 처리할 수 있도록 다음과 같은 처리방침을 두고 있습니다. 회사는 개인정보처리방침을 개정하는 경우 웹사이트 공지사항(또는 개별공지)을 통하여 공지할 것입니다.</p>
								</li>
								<li>
									<span class="title">1. 개인정보의 처리 목적</span>
									<p class="use-clause-txt">에타는 개인정보를 다음의 목적을 위해 처리합니다. 처리한 개인정보는 다음의 목적 이외의 용도로는 사용되지 않으며 이용 목적이 변경될 시에는 사전동의를 구할 예정입니다.</p>
									<ul>
										<li class="use-clause-item">가. 홈페이지 회원가입 및 관리<br> 회원 가입의사 확인, 회원제 서비스 제공에 따른 본인 식별·인증, 회원자격 유지·관리, 제한적 본인확인제 시행에 따른 본인확인, 서비스 부정이용 방지, 만14세 미만 아동 개인정보 수집 시 법정대리인 동의 여부 확인, 각종 고지·통지, 고충처리, 분쟁 조정을 위한 기록 보존 등을 목적으로 개인정보를 처리합니다.</li>
										<li class="use-clause-item">나. 재화 또는 서비스 제공<br> 물품배송, 서비스 제공, 청구서 발송, 콘텐츠 제공, 맞춤 서비스 제공, 본인인증, 연령인증, 요금결제·정산, 채권추심, 부정거래 방지 등을 목적으로 개인정보를 처리합니다.</li>
										<li class="use-clause-item">다. 마케팅 및 광고에의 활용<br> 신규 서비스(제품) 개발 및 맞춤 서비스 제공, 이벤트 및 광고성 정보 제공 및 참여기회 제공, 인구통계학적 특성에 따른 서비스 제공 및 광고 게재, 서비스의 유효성 확인, 접속빈도 파악 또는 회원의 서비스 이용에 대한 통계 등을 목적으로 개인정보를 처리합니다.</li>
									</ul>
								</li>
								<li>
									<span class="title">2. 개인정보 수집 및 보유</span>
									<ul>
										<li class="use-clause-item">가. 에타는 법령에 따른 개인정보 보유·이용기간 또는 정보주체로부터 개인정보를 수집시에 동의 받은 개인정보 보유, 이용기간 내에서 개인정보를 처리, 보유합니다.</li>
										<li class="use-clause-item">나. 각각의 개인정보 수집항목, 처리 및 보유 기간은 다음과 같습니다.
											<div class="basic-table-wrap basic-table-wrap--layer">
												<table class="basic-table">
													<colgroup>
														<col style="width:33%;">
														<col style="width:33%;">
														<col>
													</colgroup>
													<thead>
														<tr>
															<th scope="col" class="tb-info-title">구분</th>
															<th scope="col" class="tb-info-title">항목</th>
															<th scope="col" class="tb-info-title">수집방법</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td class="tb-info-txt">필수</td>
															<td class="tb-info-txt">이메일, 휴대전화번호, 비밀번호 질문과 답, 비밀번호, 로그인ID, 생년월일, 이름, 서비스 이용 기록, 접속 로그, 쿠키, 접속 IP 정보</td>
															<td class="tb-info-txt">사이트 회원가입 절차, 이벤트나 경품 행사, 서비스 이용 과정이나 사업 처리 과정 등</td>
														</tr>
														<tr>
															<td class="tb-info-txt">필수<br>(상품구매 등 서비스 이용 시 필수적인 정보)</td>
															<td class="tb-info-txt">신용카드정보, 은행계좌정보, 결제기록, 배송지주소, 배송지 연락처, 수취인 정보</td>
															<td class="tb-info-txt">사이트에서 상품/서비스 구매 시 입력</td>
														</tr>
														<tr>
															<td class="tb-info-txt">선택</td>
															<td class="tb-info-txt">성별, 기념일, 결혼여부, 취미</td>
															<td class="tb-info-txt">사이트 회원가입 절차, 이벤트나 경품 행사 등</td>
														</tr>
													</tbody>
												</table>
											</div>
											<div class="basic-table-wrap basic-table-wrap--layer">
												<table class="basic-table">
													<colgroup>
														<col style="width:33%;">
														<col style="width:33%;">
														<col>
													</colgroup>
													<thead>
														<tr>
															<th scope="col" class="tb-info-title">보유근거</th>
															<th scope="col" class="tb-info-title">보유기간</th>
															<th scope="col" class="tb-info-title">비고</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td class="tb-info-txt">서비스 이용자 식별, 만 14세 미만 아동 여부 확인, 서비스 이용에 따른 민원사항의 처리, 부정거래 방지</td>
															<td class="tb-info-txt">6개월</td>
															<td class="tb-info-txt">부정거래를 배제하기 위한 회사방침</td>
														</tr>
														<tr>
															<td class="tb-info-txt">상품 및 경품 배송(반품/환불), 배송지 및 연락처 확인, 부정거래 방지</td>
															<td class="tb-info-txt">대금결제 및 재화 등의 공급에 관한 기록 : 5년<br>계약 또는 청약철회 등에 관한 기록 : 5년<br>소비자의 불만 또는 분쟁처리에 관한 기록 : 3년</td>
															<td class="tb-info-txt">전자상거래등 에서의 소비자보호에 관한 법률</td>
														</tr>
														<tr>
															<td class="tb-info-txt">마케팅 및 개인맞춤 서비스 제공</td>
															<td class="tb-info-txt">회원 탈퇴 시 즉시 삭제</td>
															<td class="tb-info-txt">&nbsp;</td>
														</tr>
													</tbody>
												</table>
											</div>
										</li>
									</ul>
									<ul>
										<li class="use-clause-item">다. 에타는 법정 대리인의 동의가 필요한 만14세 미만 아동의 회원가입은 받고 있지 않습니다.</li>
										<li class="use-clause-item">
											라. 에타는 비회원 주문의 경우에도 아래와 같이 배송, 대금결제, 주문내역 조회 및 구매확인, 실명여부 확인을 위하여 필요한 개인정보만을 요청하고 있으며, 이 경우 그 정보는 대금결제 및 상품의 배송에 관련된 용도 이외에는 다른 어떠한 용도로도 사용되지 않습니다. 에타는 비회원의 개인정보도 회원과 동등한 수준으로 보호합니다.
											<div class="basic-table-wrap basic-table-wrap--layer">
												<table class="basic-table">
													<colgroup>
														<col style="width:33%;">
														<col style="width:33%;">
														<col>
													</colgroup>
													<thead>
														<tr>
															<th scope="col" class="tb-info-title">목적</th>
															<th scope="col" class="tb-info-title">항목</th>
															<th scope="col" class="tb-info-title">보유 및 이용기간</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td class="tb-info-txt">상품 배송 및 서비스 제공을 위한 사용자 정보 확인</td>
															<td class="tb-info-txt">배송의뢰인 및 수령인의 성명, 전화번호, 휴대폰번호, 주소, 이메일주소</td>
															<td class="tb-info-txt">5년 보관 (전자상거래 등에서의 소비자보호에 관한 법률)</td>
														</tr>
														<tr>
															<td class="tb-info-txt">상품 구매에 대한 대금결제 및 취소</td>
															<td class="tb-info-txt">신용카드정보, 은행계좌정보, 휴대폰가입정보</td>
															<td class="tb-info-txt">5년 보관 (전자상거래 등에서의 소비자보호에 관한 법률)</td>
														</tr>
													</tbody>
												</table>
											</div>
										</li>
									</ul>
								</li>

								<li>
									<span class="title">3. 개인정보의 제3자 제공에 관한 사항</span>
									<ul>
										<li class="use-clause-item">가. 에타는 정보주체의 동의, 법률의 특별한 규정 등 개인정보 보호법 제17조 및 제18조에 해당하는 경우에만 개인정보를 제3자에게 제공합니다.</li>
										<li class="use-clause-item">나. 에타는 다음과 같이 개인정보를 제3자에게 제공하고 있습니다.
											<div class="basic-table-wrap basic-table-wrap--layer">
												<table class="basic-table">
													<colgroup>
														<col style="width:25%;">
														<col style="width:25%;">
														<col style="width:25%;">
														<col>
													</colgroup>
													<thead>
														<tr>
															<th scope="col" class="tb-info-title">제공받는 자</th>
															<th scope="col" class="tb-info-title">항목</th>
															<th scope="col" class="tb-info-title">이용목적</th>
															<th scope="col" class="tb-info-title">보유 및 이용기간</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td class="tb-info-txt">판매자</td>
															<td class="tb-info-txt">1)구매자정보(구매자id,구매자명, 구매자전화번호, 구매자휴대폰번호)<br>2)상품 구매, 취소, 반품, 교환정보<br>3)수령인정보(수령인명, 휴대폰번호,전화번호,수령인주소) <br>4)송장정보</td>
															<td class="tb-info-txt">상품(서비스) 배송(전송), 제품 설치, 반품, 환불, 고객상담 등 <br>정보통신서비스제공계약 및 전자상거래(통신판매)계약의 이행을 위해 필요한 업무의 처리</td>
															<td class="tb-info-txt">배송완료 후 3개월까지 (관계법령의 규정에 의하여 보존할 필요가 있는 경우 및 사전 동의를 득한 경우 해당 보유 기간)</td>
														</tr>
													</tbody>
												</table>
											</div>
										</li>
									</ul>
								</li>

								<li>
									<span class="title">4. 개인정보처리 위탁</span>
									<ul>
										<li class="use-clause-item">가. 에타는 원활한 개인정보 업무처리를 위하여 다음과 같이 개인정보 처리업무를 위탁하고 있습니다.
											<div class="basic-table-wrap basic-table-wrap--layer">
												<table class="basic-table">
													<colgroup>
														<col style="width:33%;">
														<col style="width:33%;">
														<col>
													</colgroup>
													<thead>
														<tr>
															<th scope="col" class="tb-info-title">위탁받는 자(수탁자)</th>
															<th scope="col" class="tb-info-title">위탁하는 업무 내용</th>
															<th scope="col" class="tb-info-title">위탁 기간</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td class="tb-info-txt">전자결제대행사(㈜케이지이니시스 외)</td>
															<td class="tb-info-txt">신용카드 결제승인 및 매입업무 대행무통장입금(가상계좌) 서비스제공</td>
															<td class="tb-info-txt">회원 탈퇴 및 위탁 계약 만료 때 까지</td>
														</tr>
														<tr>
															<td class="tb-info-txt">판매자 지정 물류업체 및 배송업체(우체국, CJ대한통운 외)</td>
															<td class="tb-info-txt">물품배송 또는 청구지 등 발송</td>
															<td class="tb-info-txt">회원 탈퇴 및 위탁 계약 만료 때 까지</td>
														</tr>
													</tbody>
												</table>
											</div>
										</li>
									</ul>

									<ul>
										<li class="use-clause-item">나. 에타는 위탁계약 체결시 개인정보 보호법 제25조에 따라 위탁업무 수행목적 외 개인정보 처리금지, 기술적․관리적 보호조치, 재위탁 제한, 수탁자에 대한 관리․감독, 손해배상 등 책임에 관한 사항을 계약서 등 문서에 명시하고, 수탁자가 개인정보를 안전하게 처리하는지를 감독하고 있습니다.</li>
										<li class="use-clause-item">다. 위탁업무의 내용이나 수탁자가 변경될 경우에는 지체없이 본 개인정보 처리방침을 통하여 공개하도록 하겠습니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">5. 정보주체의 권리, 의무 및 그 행사방법</span>
									<ul>
										<li class="use-clause-item">가. 이용자는 개인정보주체로서 에타에 대해 언제든지 다음 각 호의 개인정보 보호 관련 권리를 행사할 수 있습니다.
											<ul>
												<li class="use-clause-item">① 개인정보 열람요구</li>
												<li class="use-clause-item">② 오류 등이 있을 경우 정정 요구</li>
												<li class="use-clause-item">③ 삭제요구</li>
												<li class="use-clause-item">④ 처리정지 요구</li>
											</ul>
										</li>
										<li class="use-clause-item">나. 제1항에 따른 권리 행사는 에타에 대해 개인정보 보호법 시행규칙 별지 제8호 서식에 따라 서면, 전자우편, 모사전송(FAX) 등을 통하여 하실 수 있으며 에타는 이에 대해 지체 없이 조치하겠습니다.</li>
										<li class="use-clause-item">다. 정보주체가 개인정보의 오류 등에 대한 정정 또는 삭제를 요구한 경우에는 에타는 정정 또는 삭제를 완료할 때까지 당해 개인정보를 이용하거나 제공하지 않습니다.</li>
										<li class="use-clause-item">라. 제1항에 따른 권리 행사는 정보주체의 법정대리인이나 위임을 받은 자 등 대리인을 통하여 하실 수 있습니다. 이 경우 개인정보 보호법 시행규칙 별지 제11호 서식에 따른 위임장을 제출하셔야 합니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">6. 개인정보 자동 수집 장치의 설치, 운영 및 그 거부에 관한 사항</span>
									<ul>
										<li class="use-clause-item">가. 쿠키(cookie)란?
											<p class="use-clause-txt">에타는 이용자에 대한 정보를 저장하고 수시로 찾아내는 쿠키(cookie)를 사용합니다. 쿠키는 웹사이트가 이용자의 컴퓨터 브라우저(인터넷익스플로러 등)로 전송하는 소량의 정보입니다. 이용자께서 웹사이트에 접속을 하면 에타의 서버는 이용자의 브라우저에 추가정보를 임시로 저장하여 접속에 따른 성명 등의 추가 입력 없이 서비스를 제공할 수 있습니다. 쿠키는 이용자의 컴퓨터는 식별하지만 이용자를 개인적으로 식별하지는 않습니다. 또한
												이용자는 쿠키에 대한 선택권이 있습니다.</p>
										</li>
										<li class="use-clause-item">나. 에타의 쿠키 운용
											<p class="use-clause-txt">에타는 이용자의 편의를 위하여 쿠키를 운영합니다. 에타가 쿠키를 통해 수집하는 정보는 회원ID에 한하며, 그 외의 다른 정보는 수집하지 않습니다. 에타가 쿠키를 통해 수집한 회원 ID는 다음의 목적을 위해 사용됩니다.</p>
											<ul>
												<li class="use-clause-item">- 개인의 관심 분야에 따란 차별화된 정보를 제공</li>
												<li class="use-clause-item">- 쇼핑한 품목들에 대한 정보와 장바구니 서비스를 제공 </li>
												<li class="use-clause-item">- 회원과 비회원의 접속빈도 또는 머문 시간 등을 분석하여 서비스 개편 및 마케팅에 활용</li>
											</ul>
										</li>
										<li class="use-clause-item">다. 쿠키는 브라우저의 종료시나 로그아웃 시 만료됩니다.</li>
										<li class="use-clause-item">라. 쿠키의 설치 및 거부
											<ul>
												<li class="use-clause-item">① 이용자는 쿠키 설치에 대한 선택권을 가지고 있습니다. 따라서 이용자는 웹브라우저에서 옵션을 설정함으로써 모든 쿠키를 허용하거나, 쿠키가 저장될 때마다 확인을 거치거나, 아니면 모든 쿠키의 저장을 거부할 수도 있습니다. </li>
												<li class="use-clause-item">② 다만, 쿠키의 저장을 거부할 경우에는 로그인이 필요한 서비스 등 일부 서비스 이용에 어려움이 있을 수 있습니다. </li>
												<li class="use-clause-item">③ 쿠키 설치 허용 여부를 지정하는 방법
													<ul>
														<li class="use-clause-item">Internet Explorer: 도구 메뉴 선택 &gt; 인터넷 옵션 선택 &gt; 개인정보 탭 클릭 &gt; 개인정보처리 수준 설정</li>
														<li class="use-clause-item">Chrome: 설정 메뉴 선택 &gt; 고급 설정 표시 선택 &gt; 개인정보-콘텐츠 설정 선택 &gt; 쿠키 수준 설정</li>
														<li class="use-clause-item">firefox: 옵션 메뉴 선택 &gt; 개인정보 선택 &gt; 방문기록-사용자 정의 설정 &gt; 쿠키 수준 설정</li>
														<li class="use-clause-item">safari: 환경설정 메뉴 선택 &gt; 개인정보 탭 선택 &gt; 쿠키 및 웹 사이트 데이터 수준 설정</li>
													</ul>
												</li>
											</ul>
										</li>
									</ul>
								</li>

								<li>
									<span class="title">7. 개인정보의 파기</span>
									<p class="use-clause-txt">에타는 원칙적으로 개인정보 처리목적이 달성된 경우에는 지체없이 해당 개인정보를 파기합니다. 파기의 절차, 기한 및 방법은 다음과 같습니다.</p>
									<ul>
										<li class="use-clause-item">- 파기절차이용자가 입력한 정보는 목적 달성 후 별도의 DB에 옮겨져(종이의 경우 별도의 서류) 내부 방침 및 기타 관련 법령에 따라 일정기간 저장된 후 혹은 즉시 파기됩니다. 이 때, DB로 옮겨진 개인정보는 법률에 의한 경우가 아니고서는 다른 목적으로 이용되지 않습니다.</li>
										<li class="use-clause-item">- 파기기한이용자의 개인정보는 개인정보의 보유기간이 경과된 경우에는 보유기간의 종료일로부터 5일 이내에, 개인정보의 처리 목적 달성, 해당 서비스의 폐지, 사업의 종료 등 그 개인정보가 불필요하게 되었을 때에는 개인정보의 처리가 불필요한 것으로 인정되는 날로부터 5일 이내에 그 개인정보를 파기합니다.</li>
										<li class="use-clause-item">- 파기방법
											<ul>
												<li class="use-clause-item">① 전자적 파일 형태의 정보는 기록을 재생할 수 없는 기술적 방법을 사용합니다.</li>
												<li class="use-clause-item">② 종이에 출력된 개인정보는 분쇄기로 분쇄하거나 소각을 통하여 파기합니다.</li>
											</ul>
										</li>
									</ul>
								</li>

								<li>
									<span class="title">8. 개인정보의 안전성 확보 조치</span>
									<p class="use-clause-txt">에타는 개인정보보호법 제29조에 따라 다음과 같이 안전성 확보에 필요한 기술적/관리적 및 물리적 조치를 하고 있습니다.</p>
									<ul>
										<li class="use-clause-item">- 정기적인 자체 감사 실시<br>개인정보 취급 관련 안정성 확보를 위해 정기적(분기 1회)으로 자체 감사를 실시하고 있습니다.</li>
										<li class="use-clause-item">- 개인정보 취급 직원의 최소화 및 교육<br>개인정보를 취급하는 직원을 지정하고 담당자에 한정시켜 최소화 하여 개인정보를 관리하는 대책을 시행하고 있습니다.</li>
										<li class="use-clause-item">- 내부관리계획의 수립 및 시행<br>개인정보의 안전한 처리를 위하여 내부관리계획을 수립하고 시행하고 있습니다.</li>
										<li class="use-clause-item">- 해킹 등에 대비한 기술적 대책<br>에타는 해킹이나 컴퓨터 바이러스 등에 의한 개인정보 유출 및 훼손을 막기 위하여 보안프로그램을 설치하고 주기적인 갱신·점검을 하며 외부로부터 접근이 통제된 구역에 시스템을 설치하고 기술적/물리적으로 감시 및 차단하고 있습니다.</li>
										<li class="use-clause-item">- 개인정보의 암호화<br>이용자의 개인정보는 비밀번호는 암호화 되어 저장 및 관리되고 있어, 본인만이 알 수 있으며 중요한 데이터는 파일 및 전송 데이터를 암호화 하거나 파일 잠금 기능을 사용하는 등의 별도 보안기능을 사용하고 있습니다.</li>
										<li class="use-clause-item">- 접속기록의 보관 및 위변조 방지<br>개인정보처리시스템에 접속한 기록을 최소 6개월 이상 보관, 관리하고 있으며, 접속 기록이 위변조 및 도난, 분실되지 않도록 보안기능 사용하고 있습니다.</li>
										<li class="use-clause-item">- 개인정보에 대한 접근 제한<br>개인정보를 처리하는 데이터베이스시스템에 대한 접근권한의 부여,변경,말소를 통하여 개인정보에 대한 접근통제를 위하여 필요한 조치를 하고 있으며 침입차단시스템을 이용하여 외부로부터의 무단 접근을 통제하고 있습니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">9. 개인정보 보호책임자 작성</span>
									<ul>
										<li class="use-clause-item">가. 에타는 개인정보 처리에 관한 업무를 총괄해서 책임지고, 개인정보 처리와 관련한 정보주체의 불만처리 및 피해구제 등을 위하여 아래와 같이 개인정보 보호책임자를 지정하고 있습니다.
											<p class="use-clause-txt">▶ 개인정보 보호책임</p>
											<ul>
												<li class="use-clause-item">- 성명: 민승기</li>
												<li class="use-clause-item">- 담당부서명: 서비스기획팀</li>
												<li class="use-clause-item">- 직책: 팀장</li>
												<li class="use-clause-item">- 전화번호: <a href="tel:02-569-6227">02-569-6227</a></li>
												<li class="use-clause-item">- 이메일: <a href="mailto:admin@etah.co.kr">admin@etah.co.kr</a></li>
											</ul>
										</li>
										<li class="use-clause-item">나. 정보주체께서는 에타의 서비스(또는 사업)를 이용하시면서 발생한 모든 개인정보 보호 관련 문의, 불만처리, 피해구제 등에 관한 사항을 개인정보 보호책임자 및 담당부서로 문의하실 수 있습니다. 에타는 정보주체의 문의에 대해 지체 없이 답변 및 처리해드릴 것입니다.</li>
									</ul>
								</li>

								<li>
									<span class="title">10. 개인정보 처리방침 변경</span>
									<ul>
										<li class="use-clause-item">○ 본 방침은 2016년 7월 18일부터 시행됩니다.</li>
									</ul>
								</li>
							</ul>
						</div>


						<div class="common-layer-button">
							<ul class="common-btn-box common-btn-box--layer">
								<li class="common-btn-item"><a href="#" class="btn-gray-link">확인</a></li>
							</ul>
						</div>
						<!-- // common-layer-button -->
					</div>
					<!-- // common-layer-content -->

					<a href="#" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>
				</div>

				<!-- // 비회원 개인정보수집 및 이용 동의 레이어 -->

			</div>

<!-- 상품정보 시작 (비회원 구매를 위해) -->
<form id="goods_form" name="goods_form" method="post">
<input type="hidden"	name="cust_no"							value="<?=$param['cust_no']?>">
<input type="hidden"	name="goods_code"						value="<?=$param['goods_code']?>">
<input type="hidden"	name="goods_name"						value="<?=$param['goods_name']?>">
<input type="hidden"	name="goods_img"						value="<?=$param['goods_img']?>">
<input type="hidden"	name="goods_mileage_save_rate"			value="<?=$param['goods_mileage_save_rate']?>">
<input type="hidden"	name="goods_price_code"					value="<?=$param['goods_price_code']?>">
<input type="hidden"	name="goods_selling_price"				value="<?=$param['goods_selling_price']?>">
<input type="hidden"	name="goods_street_price"				value="<?=$param['goods_street_price']?>">
<input type="hidden"	name="goods_factory_price"				value="<?=$param['goods_factory_price']?>">
<input type="hidden"	name="goods_state"						value="<?=$param['goods_state']?>">
<input type="hidden"	name="brand_code"						value="<?=$param['brand_code']?>">
<input type="hidden"	name="brand_name"						value="<?=$param['brand_name']?>">
<input type="hidden"	name="goods_discount_price"				value="<?=$param['goods_discount_price']?>">
<input type="hidden"	name="goods_coupon_code_s"				value="<?=$param['goods_coupon_code_s']?>">
<input type="hidden"	name="goods_coupon_amt_s"				value="<?=$param['goods_coupon_amt_s']?>">
<input type="hidden"	name="goods_coupon_code_i"				value="<?=$param['goods_coupon_code_i']?>">
<input type="hidden"	name="goods_coupon_amt_i"				value="<?=$param['goods_coupon_amt_i']?>">
<input type="hidden"	name="deli_policy_no"					value="<?=$param['deli_policy_no']?>">
<input type="hidden"	name="deli_limit"						value="<?=$param['deli_limit']?>">
<input type="hidden"	name="deli_cost"						value="<?=$param['deli_cost']?>">
<input type="hidden"	name="deli_code"						value="<?=$param['deli_code']?>">
<input type="hidden"	name="goods_delivery_price"				value="<?=$param['goods_delivery_price']?>">
<input type="hidden"	name="goods_cate_code1"					value="<?=$param['goods_cate_code1']?>">
<input type="hidden" 	name="goods_cate_code2"					value="<?=$param['goods_cate_code2']?>">
<input type="hidden"	name="goods_cate_code3"					value="<?=$param['goods_cate_code3']?>">
<input type="hidden"	name="goods_deliv_pattern_type"			value="<?=$param['goods_deliv_pattern_type']?>">
<input type="hidden"	name="send_nation"						value="<?=$param['send_nation']?>">	<!--출고국가-->

<? for($i=0; $i<count($param['goods_cnt']); $i++){	?>
<input type="hidden"	name="goods_cnt[]"						value="<?=$param['goods_cnt'][$i]?>">
<input type="hidden"	name="goods_option_code[]"				value="<?=$param['goods_option_code'][$i]?>">
<input type="hidden"	name="goods_option_name[]"				value="<?=$param['goods_option_name'][$i]?>">
<input type="hidden"	name="goods_option_add_price[]"			value="<?=$param['goods_option_add_price'][$i]?>">
<input type="hidden"	name="goods_option_qty[]"				value="<?=$param['goods_option_qty'][$i]?>">
<input type="hidden"	name="goods_item_coupon_code[]"			value="<?=$param['goods_item_coupon_code'][$i]?>">
<input type="hidden"	name="goods_item_coupon_price[]"		value="<?=$param['goods_item_coupon_price'][$i]?>">
<input type="hidden"	name="goods_add_coupon_code[]"			value="<?=$param['goods_add_coupon_code'][$i]?>">
<input type="hidden"	name="goods_add_discount_price[]"		value="<?=$param['goods_add_discount_price'][$i]?>">
<input type="hidden"	name="goods_add_coupon_type[]"			value="<?=$param['goods_add_coupon_type'][$i]?>">
<input type="hidden"	name="goods_add_coupon_gubun[]"			value="<?=$param['goods_add_coupon_gubun'][$i]?>">
<input type="hidden"	name="goods_coupon_amt[]"				value="<?=$param['goods_coupon_amt'][$i]?>">
<input type="hidden"	name="goods_add_coupon_no[]"			value="<?=$param['goods_add_coupon_no'][$i]?>">

<? }?>
</form>


<script type="text/javascript">

/** 체크박스 전체선택/해제	**/
function jsChkAll(pBool){
	for (var i=0; i<document.getElementsByName("formAgree[]").length; i++){
		document.getElementsByName("formAgree[]")[i].checked = pBool;
	}
}

//===============================================================
// 상품 주문하기
//===============================================================
function jsOrder(){

	if(document.getElementById("orderNonMemberAgree1").checked == false){
		alert("에타 웹사이트 이용약관에 동의해주세요.");
		return false;
	}

	if(document.getElementById("orderNonMemberAgree2").checked == false){
		alert("비회원 개인정보수집 및 이용에 대한 약관에 동의해주세요.");
		return false;
	}

	var param		= $("#goods_form").serialize();
	var frm = document.getElementById("goods_form");
	var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";

		frm.action = "https://"+SSL_val+"/cart/OrderInfo";
		frm.submit();
}

</script>