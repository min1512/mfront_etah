<?php
/**
 * Created by PhpStorm.
 * User: YIC-007
 * Date: 2019-11-06
 * Time: 오후 5:28
 */

?>


<!-- 방문예약하기 레이어 // -->
<form name="frmList" id="frmList" method="post">
    <div id="layerReservation" class="common-layer-wrap layer-reservation common-layer-wrap--view"> <!-- common-layer-wrap--view 추가 -->
        <h3 class="common-layer-title">클러프트 매장 방문 예약하기</h3>

        <input type="hidden" name="goods_cd" value="<?=$goods_cd?>">

        <!-- common-layer-content // -->
        <div class="common-layer-content">
            <div class="form-line form-line--modify">
                <div class="form-line-info">
                    <label class="form-line-title" for="formReserv01">이름</label>
                    <input type="text" class="input-text" id="formReserv01" name="name">
                </div>
            </div>
            <div class="form-line form-line--wide form-line--cols">
                <div class="form-line-title"><label for="formReserv02"></label></div>
                <div class="form-line-info">
                    <div class="form-line--cols-item">
                        <div class="select-box select-box--big">
                            <select class="select-box-inner" id="formReserv02_1" name="tel1">
                                <option>010</option>
                                <option>011</option>
                            </select>
                        </div>
                    </div>
                    <span class="dash">-</span>
                    <div class="form-line--cols-item">
                        <label for="joinPhoneForm1_2"><input type="tel" class="input-text" id="formReserv02_2" name="tel2"></label>
                    </div>
                    <span class="dash">-</span>
                    <div class="form-line--cols-item">
                        <label for="joinPhoneForm1_3"><input type="tel" class="input-text" id="formReserv02_3" name="tel3"></label>
                    </div>
                </div>
            </div>

            <div class="form-line form-line--wide form-line--cols">
                <!-- 달력부분 // -->
                <div class="date_time_option_select">
                    <div class="date_option_select_item">
                        <input type="text" id="formReserv03_1" value="<?=date("Y-m-d", time())?>" class="input-text datepicker" readonly name="date"/>
                        <button type="button" class="btn_calendar"><span class="spr-common spr-calendar"></span></button>
                    </div>
                    <div class="select-box select-box--big">
                        <label for="formReserv03_2">시간선택</label>
                        <select class="select-box-inner" id="formReserv03_2" data-ui="select-val" name="time">
                            <option value="09:00-10:00">09:00 - 10:00</option>
                            <option value="10:00-11:00">10:00 - 11:00</option>
                            <option value="11:00-12:00">11:00 - 12:00</option>
                            <option value="12:00-13:00">12:00 - 13:00</option>
                            <option value="13:00-14:00">13:00 - 14:00</option>
                            <option value="14:00-15:00">14:00 - 15:00</option>
                            <option value="15:00-16:00">15:00 - 16:00</option>
                            <option value="16:00-17:00">16:00 - 17:00</option>
                            <option value="17:00-18:00">17:00 - 18:00</option>
                        </select>
                    </div>
                </div>
                <!-- // 달력부분 -->
            </div>

            <div class="agree-check-area">
                <ul class="check-text-list">
                    <li class="check-text-item">
                        <input type="checkbox" id="formReserv04" class="checkbox" name="formAgree">
                        <label for="formReserv04" class="checkbox-label">개인정보 수집 및 이용에 동의 합니다.</label>
                        <a href="#layerPersonalInfoAgree" class="btn-all-view-link" data-layer="bottom-layer-open2">내용확인</a>
                    </li>
                </ul>
            </div>

            <div class="common-layer-button">
                <ul class="common-btn-box common-btn-box--layer">
                    <li class="common-btn-item"><a href="#" class="btn-gray-link" onClick="javascript:jsReservation();">예약하기</a></li>
                </ul>
            </div>
        </div>
        <!-- // common-layer-content -->

        <a href="#" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>
    </div>
</form>
<!-- // 방문예약하기 레이어 -->

<!-- 개인정보 이용약관 레이어 // -->
<div class="common-layer-wrap layer-personal-info-agree cart-coupon-layer" id="layerPersonalInfoAgree">
    <h3 class="common-layer-title">개인정보 수집 및 이용동의</h3>
    <div class="common-layer-content join-layer">
        <div class="join-layer-txt">
            <ul>
                <li class="use-clause-item use-clause-item--modify">
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
                                        <col >
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
                                        <td>&nbsp;</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="basic-table-wrap basic-table-wrap--layer">
                                <table class="basic-table">
                                    <colgroup>
                                        <col style="width:20%;">
                                        <col style="width:20%;">
                                        <col style="width:20%;">
                                        <col style="width:20%;">
                                        <col style="width:20%;">
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
                        <li class="use-clause-item">라. 에타는 비회원 주문의 경우에도 아래와 같이 배송, 대금결제, 주문내역 조회 및 구매확인, 실명여부 확인을 위하여 필요한 개인정보만을 요청하고 있으며, 이 경우 그 정보는 대금결제 및 상품의 배송에 관련된 용도 이외에는 다른 어떠한 용도로도 사용되지 않습니다. 에타는 비회원의 개인정보도 회원과 동등한 수준으로 보호합니다.
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
                            <p class="use-clause-txt">에타는 이용자에 대한 정보를 저장하고 수시로 찾아내는 쿠키(cookie)를 사용합니다. 쿠키는 웹사이트가 이용자의 컴퓨터 브라우저(인터넷익스플로러 등)로 전송하는 소량의 정보입니다. 이용자께서 웹사이트에 접속을 하면 에타의 서버는 이용자의 브라우저에 추가정보를 임시로 저장하여 접속에 따른 성명 등의 추가 입력 없이 서비스를 제공할 수 있습니다. 쿠키는 이용자의 컴퓨터는 식별하지만 이용자를 개인적으로 식별하지는 않습니다. 또한 이용자는 쿠키에 대한 선택권이 있습니다.</p>
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
    </div>
    <a href="#" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>
</div>
<!-- // 개인정보 이용약관 레이어 -->

<script>
    $(function(){
        //topNav();
        etahUi.layercontroller();
        etahUi.bottomLayercontroller();
        etahUi.bottomLayerOpen();
        etahUi.toggleMenu();
        //etahUi.tabMenu();
        etahUi.cartOptionLayer();
        etahUi.listToggle();
        etahUi.filterLayer();
        etahUi.selectFun();
    });

    //datepicker
    $(function() {
        $( ".datepicker" ).datepicker({
            showOn: "button",
            dateFormat: 'yy-mm-dd',
            //numberOfMonths: 1,
            prevText: "",
            nextText: "",
            monthNames: [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12" ],
            monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월" ],
            dayNames: [ "일", "월", "화", "수", "목", "금", "토" ],
            dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
            dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],
            showMonthAfterYear: true,
            yearSuffix: ".",
        });
    });
</script>

<script>
    //=======================================
    // validation 체크
    //=======================================
    function jsChkValidation()
    {
        var mFrm	= document.frmList;

        if(mFrm.name.value == '') {
            alert('이름을 입력해주세요.');
            mFrm.name.focus();
            return false;
        }
        if(mFrm.tel1.value == '' || mFrm.tel2.value == '' || mFrm.tel3.value == '') {
            alert('핸드폰번호를 입력해주세요.');
            mFrm.tel2.focus();
            return false;
        }
        if(mFrm.date.value == '') {
            alert('방문날짜를 선택해주세요.');
            mFrm.date.focus();
            return false;
        }
        if(mFrm.time.value == '') {
            alert('방문시간 선택해주세요.');
            mFrm.time.focus();
            return false;
        }
        if(mFrm.formAgree.checked == false) {
            alert('개인정보 수집 및 이용에 동의해주세요.');
            mFrm.formAgree.focus();
            return false;
        }

        return true;
    }

    //====================================
    // 매장 방문예약
    //====================================
    function jsReservation()
    {
        //validation 체크
        if( !jsChkValidation()){
            return false;
        }

        var data	= $('#frmList').serialize();

        $.ajax({
            type: 'POST',
            url: '/goods/visit_reservation',
            dataType: 'json',
            data: data,
            error:	function(res)	{
                alert( 'Database Error' );
                alert(res.responseText);
            },
            success: function(res) {
                if(res.status == 'ok'){
                    alert("예약되었습니다.");
                    location.reload();
                }
                else{
                    alert(res.message);
                    alert("예약에 실패하였습니다. 잠시후 다시 시도해주세요.");
                }
            }
        });
    }
</script>
