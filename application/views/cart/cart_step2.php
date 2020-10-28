<?
/* ============================================================================== */
/* =   KCP환경 설정 파일 Include                                                   = */
/* = -------------------------------------------------------------------------- = */
/* =   ※ 필수                                                                  = */
/* =   테스트 및 실결제 연동시 site_conf_inc.php파일을 수정하시기 바랍니다.     = */
/* = -------------------------------------------------------------------------- = */


include APPPATH ."/third_party/KCP/cfg/site_conf_inc.php";
//include APPPATH ."/third_party/KCP_ARS/cfg/site_conf_inc.php";

/* = -------------------------------------------------------------------------- = */
/* =   환경 설정 파일 Include END                                               = */
/* ============================================================================== */

$order_name			= $this->session->userdata('EMS_U_NAME_');
$order_email		= $this->session->userdata('EMS_U_EMAIL_');
$order_recipient	= '';
$buyeremail			= '';
$order_mobile		= '';
$order_phone		= '';
$order_postnum		= '';
$order_addr1		= '';
$order_addr2		= '';
$order_request		= '';
$formDcMileage		= 0;
$shipping_floor		= '';
$shipping_step_width	= '';
$shipping_elevator	= '';
$orderCustomsNum	= '';


if(!empty($pdata3)){
    //log_message("DEBUG", "order_addr2 , cart_step2 =================== ".$pdata3['rcvr_add2']);
    //log_message("DEBUG", "order_recipient , cart_step2 =================== ".$pdata3['order_recipient']);
    $order_name									= $pdata3['order_name'];
    $order_recipient							= $pdata3['order_recipient'];
    $order_email								= $pdata3['order_email'];
    $order_mobile								= $pdata3['buyr_tel1'];
    $order_phone								= $pdata3['buyr_tel2'];
    $order_postnum								= $pdata3['rcvr_zipx'];
    $order_addr1								= $pdata3['rcvr_add1'];
    $order_addr2								= $pdata3['rcvr_add2'];
    $order_request								= $pdata3['order_request'];
    $formDcMileage								= $pdata3['formDcMileage'];

    $shipping_floor								= $pdata3['shipping_floor'];
    $shipping_step_width						= $pdata3['shipping_step_width'];
    $shipping_elevator							= $pdata3['shipping_elevator'];
    $orderCustomsNum							= $pdata3['orderCustomsNum'];
}

?>

<?
/* kcp와 통신후 kcp 서버에서 전송되는 결제 요청 정보 */

$req_tx          = isset($_POST[ "req_tx"         ]) ? $_POST[ "req_tx"         ] : ""; // 요청 종류
$res_cd          = isset($_POST[ "res_cd"         ]) ? $_POST[ "res_cd"         ] : ""; // 응답 코드
$tran_cd         = isset($_POST[ "tran_cd"        ]) ? $_POST[ "tran_cd"        ] : ""; // 트랜잭션 코드
$ordr_idxx       = isset($_POST[ "ordr_idxx"      ]) ? $_POST[ "ordr_idxx"      ] : ""; // 쇼핑몰 주문번호
$good_name       = isset($_POST[ "good_name"      ]) ? $_POST[ "good_name"      ] : ""; // 상품명
$good_mny        = isset($_POST[ "good_mny"       ]) ? $_POST[ "good_mny"       ] : ""; // 결제 총금액
$buyr_name       = isset($_POST[ "buyr_name"      ]) ? $_POST[ "buyr_name"      ] : ""; // 주문자명
$buyr_tel1       = isset($_POST[ "buyr_tel1"      ]) ? $_POST[ "buyr_tel1"      ] : ""; // 주문자 전화번호
$buyr_tel2       = isset($_POST[ "buyr_tel2"      ]) ? $_POST[ "buyr_tel2"      ] : ""; // 주문자 핸드폰 번호
$buyr_mail       = isset($_POST[ "buyr_mail"      ]) ? $_POST[ "buyr_mail"      ] : ""; // 주문자 E-mail 주소
$use_pay_method  = isset($_POST[ "use_pay_method" ]) ? $_POST[ "use_pay_method" ] : ""; // 결제 방법
$enc_info        = isset($_POST[ "enc_info"       ]) ? $_POST[ "enc_info"       ] : ""; // 암호화 정보
$enc_data        = isset($_POST[ "enc_data"       ]) ? $_POST[ "enc_data"       ] : ""; // 암호화 데이터
$cash_yn         = isset($_POST[ "cash_yn"        ]) ? $_POST[ "cash_yn"        ] : "";
$cash_tr_code    = isset($_POST[ "cash_tr_code"   ]) ? $_POST[ "cash_tr_code"   ] : "";
/* 기타 파라메터 추가 부분 - Start - */
$param_opt_1     = isset($_POST[ "param_opt_1"    ]) ? $_POST[ "param_opt_1"    ] : ""; // 기타 파라메터 추가 부분
$param_opt_2     = isset($_POST[ "param_opt_2"    ]) ? $_POST[ "param_opt_2"    ] : "01"; // 기타 파라메터 추가 부분
$param_opt_3     = isset($_POST[ "param_opt_3"    ]) ? $_POST[ "param_opt_3"    ] : ""; // 기타 파라메터 추가 부분
/* 기타 파라메터 추가 부분 - End -   */

$tablet_size     = "1.0"; // 화면 사이즈 고정
$url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
//	$url = "http://devm.etah.co.kr/order/order_kcp_result";
?>

<link rel="stylesheet" href="/assets/css/cart_order.css">
<!-- 거래등록 하는 kcp 서버와 통신을 위한 스크립트-->
<script type="text/javascript" src="/assets/js/approval_key.js"></script>
<!------------------------------------------------->
<!-- 2017-04-20 비회원 구매시 동의 약관 보여주기 -->
<!------------------------------------------------->
<? if(!($this->session->userdata('EMS_U_ID_') != 'GUEST' && $this->session->userdata('EMS_U_ID_') != 'TMP_GUEST' && $this->session->userdata('EMS_U_ID_'))){	//비회원 주문시 동의	?>

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

            $('#agree_contents').hide();	//동의 창을 숨기고
            $('#order_contents').show();	//결제창을 보인다
        }

    </script>

    <div class="content" id="agree_contents">

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
                <? if($order_gb == 'A' || $order_gb == 'C' || $order_gb == 'D'){	?>
                    <li class="common-btn-item"><a href="/cart" class="btn-white btn-white--big">취소</a></li>
                <? } else { ?>
                    <li class="common-btn-item"><a href="javascript:location.href='/goods/detail/<?=explode('||',$order_gb)[1]?>'" class="btn-white btn-white--big">취소</a></li>
                <? }?>
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
<? }?>
<!----------------------------------------------------->
<!-- 2017-04-20 비회원 구매시 동의 약관 보여주기 END -->
<!----------------------------------------------------->

<? if($kcp_pay == false ){ ?>
    <!-- 주문/결제 페이지 시작 CONTENTS -->
    <div class="content" id="order_contents" <? if(!($this->session->userdata('EMS_U_ID_') != 'GUEST' && $this->session->userdata('EMS_U_ID_') != 'TMP_GUEST' && $this->session->userdata('EMS_U_ID_'))){	?>style="display:none;"<? }?>>

        <h2 class="page-title-basic page-title-basic--line">주문&#47;결제</h2>

        <form name="OrderForm" id="OrderForm" method="post">
            <div class="cart-prd-order">
                <h3 class="info-title info-title--sub">주문상품 내역 (<span name="check_count"></span>)</h3>

                <?
                $total_goods_price		= 0;
                $total_discount_price	= 0;
                $total_delivery_price	= 0;
                $idx					= 0;		//상품별 카운트 인덱스
                $idx2					= 0;		//하부공급사별 묶음 카운트를 위한 인덱스
                $goods_mileage_save		= 0;
                $goods_seller_amt_sum	= 0;		//상품별 셀러쿠폰 합
                $goods_item_amt_sum		= 0;		//상품별 아이템쿠폰 합
                $goods_cust_amt_sum		= 0;		//상품별 에타중복쿠폰 합

                $group					= array_keys($cart);    // cart의 키값을 배열형태로 반환

                $test = json_encode($cart);

                ?>
                <script>
                    console.log(<?=$test?>)
                </script>
                <?

                $ascw_good_info			= "";		//kcp 에스크로 상품 정보
                $ascw_good_cnt			= 0;		//kcp 에스크로 상품 갯수

                foreach($cart as $cart_grp){
                    //var_dump($cart_grp);
                    $group_delivery_price	= explode("||",$group[$idx2])[1];		//묶음배송비
                    $group_goods	= 'N';		//묶음상품여부

                    foreach($cart_grp as $row){

                        $ascw_good_cnt ++;
                        $ascw_good_info .= "seq=".$ascw_good_cnt.chr(31)."ordr_numb=".date("YmdHms").$ascw_good_cnt.chr(31)."good_name=".$row['GOODS_NM'].chr(31)."good_cntx=".$row['GOODS_CNT'].chr(31)."good_amtx=".(($row['SELLING_PRICE'] + $row['GOODS_OPTION_ADD_PRICE']) * $row['GOODS_CNT'] - ($row['DISCOUNT_PRICE'] * $row['GOODS_CNT']) - $row['ADD_DISCOUNT_PRICE']).chr(30);

                        if($idx == 0){
                            $main_goods = $row['GOODS_NM'];
                        }	?>
                        <div class="prd-order-section prd-order-section--pay">
                            <div class="media-area prd-order-media">
                                <span class="media-area-img prd-order-media-img"><a href="/goods/detail/<?=$row['GOODS_CD']?>"><img src="<?=$row['GOODS_IMG']?>" alt=""></a></span>
                                <span class="media-area-info prd-order-media-info">
								<span class="prd-order-media-info-brand">[<?=$row['BRAND_NM']?>] <?=$row['GOODS_NM']?></span>
							<span class="prd-order-media-info-name"><?=$row['GOODS_OPTION_NM']?> <? if($row['GOODS_OPTION_ADD_PRICE'] > 0){?>(+<?=number_format($row['GOODS_OPTION_ADD_PRICE'])?>원)<? } else if($row['GOODS_OPTION_ADD_PRICE'] < 0){?>(<?=number_format($row['GOODS_OPTION_ADD_PRICE'])?>원)<? }?> &#47; <?=$row['GOODS_CNT']?>개 </span>

                                    <? if($group_goods == "N"){		//배송비
                                        ?>
                                        <input type="hidden"	name="group_deli_policy_no[]"				value="<?=$row['DELIV_POLICY_NO']?>">	<!-- 묶음상품 배송정책 -->
								<input type="hidden"	name="group_delivery_price[]"				value="<?=$group_delivery_price?>">	<!-- 묶음상품 배송비 -->
								<input type="hidden"	name="group_add_delivery_price[]"	value=0>	<!-- 묶음상품 추가배송비 -->
								<input type="hidden"	name="group_text[]"	value="N">		<!--묶음 무료배송 코드-->
                                    <?	}?>
                                    <span class="prd-order-media-info-price">판매가 <strong class="bold"><?=number_format(($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT'])?></strong><span class="won">원</span></span>
							</span>
                            </div>
                            <div class="prd-order-dc-price">

                                <?
                                if($row['DELIV_PATTERN_TYPE'] == 'NONE'){	?>
                                    <strong class="price"><span name="sale_price<?=$idx?>"><?=number_format((($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT']) - ($row['DISCOUNT_PRICE']*$row['GOODS_CNT']) - $row['ADD_DISCOUNT_PRICE'] + $group_delivery_price)?></span><span class="won">원</span></strong>
                                    <span class="price-explain">(판매가 <strong class="bold"><?=number_format(($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT'])?></strong>원 - 할인 <strong class="bold"><span name="discount_price<?=$idx?>"><?=number_format(($row['DISCOUNT_PRICE']*$row['GOODS_CNT'])+$row['ADD_DISCOUNT_PRICE'])?></span></strong>원 + 배송비
                                <strong class="bold">착불</strong>)</span>
                                <? }
                                else {
                                    if($group_goods == 'N'){
                                        if($group_delivery_price == 0 && $row['DELIV_PATTERN_TYPE'] != 'PRICE' && $row['DELIV_PATTERN_TYPE'] != 'NONE'){	?>
                                            <strong class="price"><span name="sale_price<?=$idx?>"><?=number_format((($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT']) - ($row['DISCOUNT_PRICE']*$row['GOODS_CNT']) - $row['ADD_DISCOUNT_PRICE'] + $group_delivery_price)?></span><span class="won">원</span></strong>
                                            <span class="price-explain">(판매가 <strong class="bold"><?=number_format(($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT'])?></strong>원 - 할인 <strong class="bold"><span name="discount_price<?=$idx?>"><?=number_format(($row['DISCOUNT_PRICE']*$row['GOODS_CNT'])+$row['ADD_DISCOUNT_PRICE'])?></span></strong>원 + 배송비
										<strong class="bold">무료</strong>)</span>
                                        <? } else if($group_delivery_price == 0 && $row['DELIV_PATTERN_TYPE'] == 'PRICE'){?>
                                            <!--										<strong class="bold"><del></strong>원)</del>
                                                                                    <br />*묶음 배송비 할인 적용중입니다.	-->
                                            <strong class="price"><span name="sale_price<?=$idx?>"><?=number_format((($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT']) - ($row['DISCOUNT_PRICE']*$row['GOODS_CNT']) - $row['ADD_DISCOUNT_PRICE'] + 0)?></span><span class="won">원</span></strong>
                                            <span class="price-explain">(판매가 <strong class="bold"><?=number_format(($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT'])?></strong>원 - 할인 <strong class="bold"><span name="discount_price<?=$idx?>"><?=number_format(($row['DISCOUNT_PRICE']*$row['GOODS_CNT'])+$row['ADD_DISCOUNT_PRICE'])?></span></strong>원 + 배송비

										<strong class="bold"><del><?=number_format($row['DELIVERY_PRICE'])?></strong>원)</del>	<br />*묶음 배송비 할인 적용중입니다.</span>
                                        <? } else {?>
                                            <strong class="price"><span name="sale_price<?=$idx?>"><?=number_format((($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT']) - ($row['DISCOUNT_PRICE']*$row['GOODS_CNT']) - $row['ADD_DISCOUNT_PRICE'] + $row['DELIVERY_PRICE'])?></span><span class="won">원</span></strong>
                                            <span class="price-explain">(판매가 <strong class="bold"><?=number_format(($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT'])?></strong>원 - 할인 <strong class="bold"><span name="discount_price<?=$idx?>"><?=number_format(($row['DISCOUNT_PRICE']*$row['GOODS_CNT'])+$row['ADD_DISCOUNT_PRICE'])?></span></strong>원 + 배송비

										<strong class="bold"><?=number_format($row['DELIVERY_PRICE'])?></strong>원)</span>
                                        <? }?>
                                    <?	} else if($group_goods == 'Y'){	?>
                                        <strong class="price"><span name="sale_price<?=$idx?>"><?=number_format((($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT']) - ($row['DISCOUNT_PRICE']*$row['GOODS_CNT']) - $row['ADD_DISCOUNT_PRICE'] + 0)?></span><span class="won">원</span></strong>
                                        <span class="price-explain">(판매가 <strong class="bold"><?=number_format(($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT'])?></strong>원 - 할인 <strong class="bold"><span name="discount_price<?=$idx?>"><?=number_format(($row['DISCOUNT_PRICE']*$row['GOODS_CNT'])+$row['ADD_DISCOUNT_PRICE'])?></span></strong>원 + 배송비

									<strong class="bold"><del><?=number_format($row['DELIVERY_PRICE'])?></strong>원)</del>
                                            <br />*묶음 배송비 할인 적용중입니다.</span>
                                    <? }
                                }?>
                                </span>
                            </div>
                            <div class="prd-order-btns">
                                <a href="#cartCouponLayer<?=$idx?>" class="btn-gray btn-gray--min btn-coupon-change" data-layer="bottom-layer-open2" onClick="jsReset(<?=$idx?>,'CPN');">쿠폰변경</a>
                                <a href="#cartDeliveryLayer<?=$idx?>" class="btn-white btn-white--bold btn-add-delivery-charge" data-layer="bottom-layer-open2">지역별 추가배송비</a>
                            </div>
                        </div>

                    <?		$group_goods = "Y";
                    $total_delivery_price	+= $group_delivery_price;
                    if($group_goods == 'Y'){	?>
                        <script>
                            var idx2 = "<?=$idx2?>";
                            document.getElementsByName("group_text[]")[idx2].value = 'Y';
                        </script>
                    <?	}	?>

                    <?
                    $total_goods_price		+= ($row['SELLING_PRICE'] + $row['GOODS_OPTION_ADD_PRICE'])  * $row['GOODS_CNT'];
                    $total_discount_price	+= ($row['DISCOUNT_PRICE'] * $row['GOODS_CNT']) + $row['ADD_DISCOUNT_PRICE'];
                    //						$total_delivery_price	+= $row['DELIVERY_PRICE'];

                    $idx++;
                    ?>
                        <input type="hidden"	name="goods_code[]"					value="<?=$row['GOODS_CD'		]?>">
                        <input type="hidden"	name="goods_name[]"					value="<?=$row['GOODS_NM'		]?>">
                        <input type="hidden"	name="brand_code[]"					value="<?=$row['BRAND_CD'		]?>">
                        <input type="hidden"	name="brand_name[]"					value="<?=$row['BRAND_NM'		]?>">
                        <input type="hidden"	name="goods_option_code[]"			value="<?=$row['GOODS_OPTION_CD']?>">
                        <input type="hidden"	name="goods_option_name[]"			value="<?=$row['GOODS_OPTION_NM']?>">
                        <input type="hidden"	name="goods_option_add_price[]"		value="<?=$row['GOODS_OPTION_ADD_PRICE']?>">
                        <input type="hidden"	name="goods_deli_policy_no[]"		value="<?=$row['DELIV_POLICY_NO']?>">
                        <input type="hidden"	name="goods_deli_policy_pattern_type[]" value="<?=$row['DELIV_PATTERN_TYPE']?>">
                        <input type="hidden"	name="goods_cnt[]"					value="<?=$row['GOODS_CNT'		]?>">
                        <input type="hidden"	name="goods_option_qty[]"			value="<?=$row['GOODS_OPTION_QTY']?>">  <!--옵션 재고수량-->
                        <input type="hidden"    name="goods_buy_limit_qty[]"		value="<?=$row['BUY_LIMIT_QTY']?>">     <!--구매제한 수량-->
                        <input type="hidden"	name="goods_price_code[]"			value="<?=$row['GOODS_PRICE_CD'	]?>">
                        <input type="hidden"	name="goods_selling_price[]"		value="<?=$row['SELLING_PRICE'	]?>">
                        <input type="hidden"	name="goods_street_price[]"			value="<?=$row['STREET_PRICE'	]?>">
                        <input type="hidden"	name="goods_factory_price[]"		value="<?=$row['FACTORY_PRICE']?>">
                        <input type="hidden"	name="goods_discount_price[]"		value="<?=$row['DISCOUNT_PRICE'	]?>">
                        <input type="hidden"	name="goods_add_discount_price[]"	value="<?=$row['ADD_DISCOUNT_PRICE']?>">
                        <input type="hidden"	name="goods_mileage_save_rate[]"	value="<?=$row['GOODS_MILEAGE_SAVE_RATE']?>">
                        <input type="hidden"	name="goods_mileage_save_amt[]"		value="<?=$this->session->userdata('EMS_U_NO_') != "" && $this->session->userdata('EMS_U_ID_') != 'GUEST' && $this->session->userdata('EMS_U_ID_') != 'TMP_GUEST' ? (($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT']) * ($row['GOODS_MILEAGE_SAVE_RATE']/1000) : 0?>">
                        <input type="hidden"	name="goods_coupon_code_s[]"		value="<?=$row['SELLER_COUPON_CODE'	]?>">	<!--할인쿠폰코드(셀러)-->
                        <input type="hidden"	name="goods_coupon_amt_s[]"			value="<?=$row['SELLER_COUPON_AMT']?>">		<!--쿠폰할인적용금액(셀러쿠폰)-->
                        <input type="hidden"	name="goods_coupon_code_i[]"		value="<?=$row['ITEM_COUPON_CODE'	]?>">	<!--할인쿠폰코드(아이템)-->
                        <input type="hidden"	name="goods_coupon_amt_i[]"			value="<?=$row['ITEM_COUPON_AMT']?>">		<!--쿠폰할인적용금액(아이템쿠폰)-->

                        <input type="hidden"	name="goods_add_coupon_no[]"		value="<?=$row['ADD_COUPON_NO']?>">
                        <input type="hidden"	name="goods_add_coupon_code[]"		value="<?=$row['ADD_COUPON_CODE']?>">		<!--추가쿠폰코드-->
                        <input type="hidden"	name="goods_add_coupon_num[]"		value="<?=$row['ADD_COUPON_NUM']?>">		<!--추가쿠폰번호-->

                        <input type="hidden"	name="goods_delivery_price[]"		value="<?=$group_delivery_price?>">
                        <input type="hidden"	name="goods_add_delivery_price[]"	value=0>
                        <input type="hidden"	name="deliv_yn"						value="Y">	<!--배송가능여부-->
                        <input type="hidden"	name="cart_coupon_code"				value="">	<!--장바구니쿠폰-->
                        <input type="hidden"	name="cart_coupon_num"				value="">	<!--장바구니번호-->
                        <input type="hidden"	name="cart_coupon_amt"				value="0">	<!--장바구니쿠폰적용금액-->


                                                                                                    <!-- 2019.09.25 쿠폰선택버튼 추가 // -->
                        <input type="hidden" name="goods_add_coupon_num[]"		value="">	<!--추가할인쿠폰번호-->
                        <input type="hidden" name="goods_add_coupon_type[]"		value="">	<!--추가할인쿠폰 지급방식-->
                        <input type="hidden" name="goods_add_coupon_gubun[]"	value="">	<!--추가할인쿠폰 구분-->
                        <!-- // 쿠폰선택버튼 추가 -->

                        <?
                        $goods_mileage_save	+= $this->session->userdata('EMS_U_NO_') != "" && $this->session->userdata('EMS_U_ID_') != 'GUEST' && $this->session->userdata('EMS_U_ID_') != 'TMP_GUEST' ? ($row['SELLING_PRICE']*$row['GOODS_CNT']) * ($row['GOODS_MILEAGE_SAVE_RATE']/1000) : 0;	//적립예정마일리지

                        $goods_seller_amt_sum	+= $row['SELLER_COUPON_AMT'] * $row['GOODS_CNT'];
                        $goods_item_amt_sum		+= $row['ITEM_COUPON_AMT'] * $row['GOODS_CNT'];
                        $goods_cust_amt_sum		+= $row['ADD_DISCOUNT_PRICE'];
                    }
                    $idx2++;
                }
                $goods_name = $main_goods;

                if($idx > 1){
                    $goods_name .=" 외 ".($idx-1)."개";
                }	?>

                <!-- 아임포트에 필요한 정보 -->
                <input type="hidden" name="gopaymethod"				value="card">	<!--기본값 카드-->
                <input type="hidden" name="goodname"				value="<?=$goods_name ?>">
                <input type="hidden" name="buyercode"				value="<?=$this->session->userdata('EMS_U_NO_')?>">
                <input type="hidden" name="buyerid"					value="<?=$this->session->userdata('EMS_U_ID_')?>">
                <input type="hidden" name="buyername"				value="<?=$this->session->userdata('EMS_U_NAME_')?>">
                <input type="hidden" name="buyeremail"				value="<?=$this->session->userdata('EMS_U_EMAIL_')?>">
                <input type="hidden" name="buyertel"				value="<?=$this->session->userdata('EMS_U_MOB_')?>">

                <input type="hidden" name="imp_uid"		value="">	<!--아임포트 결제 고유 ID-->
                <input type="hidden" name="receipt_url"				value="">	<!--신용카드 매출전표 확인 URL-->
                <input type="hidden" name="card_name"				value="">	<!--카드사명-->
                <input type="hidden" name="card_quota"				value="">	<!--카드할부개월-->
                <input type="hidden" name="vbank_name"				value="">	<!--가상계좌 은행명-->
                <input type="hidden" name="vbank_num"				value="">	<!--가상계좌 계좌번호-->
                <input type="hidden" name="vbank_holder"			value="">	<!--가상계좌 예금주-->
                <input type="hidden" name="vbank_date"				value="">	<!--가상계좌 마감기한-->
                <input type="hidden" name="pg_tid"					value="">	<!--PG사 주문번호-->

                <!-- ARS 결제 정보 추가 -->
                <input type="hidden" name="vnum_no"                 value="">   <!--ARS 가상전화번호-->
                <input type="hidden" name="expr_dt"                 value="">   <!--ARS 결제 유효기간-->
                <input type="hidden" name="ars_trade_no"            value="">   <!--ARS 상품 등록번호-->

                <!-- 기타설정 -->
                <input type="hidden" name="currency"				value="WON">
                <input type="hidden" name="acceptmethod"			value="">
                <input type="hidden" name="oid"						value="">

                <!--input type="hidden" name=ini_logoimage_url		value="http://"-->
                <input type="hidden" name="ini_encfield"			value="">
                <input type="hidden" name="ini_certid"				value="">
                <input type="hidden" name="quotainterest"			value="">
                <input type="hidden" name="paymethod"				value="">
                <input type="hidden" name="cardcode"				value="">
                <input type="hidden" name="cardquota"				value="">
                <input type="hidden" name="rbankcode"				value="">
                <input type="hidden" name="reqsign"					value="DONE">
                <input type="hidden" name="encrypted"				value="">
                <input type="hidden" name="sessionkey"				value="">
                <input type="hidden" name="uid"						value="">
                <input type="hidden" name="sid"						value="">
                <input type="hidden" name="version"					value=5000>
                <input type="hidden" name="clickcontrol"			value="">
                <input type="hidden" name="escrowuse"				value="N">

                <input type="hidden" name="order_payment_type"      value="<?=$param_opt_2?>">	<!--기본값 카드-->
                <input type="hidden" name="total_order_money"		value="<?=$total_goods_price?>">
                <input type="hidden" name="total_discount_money"	value="<?=$total_discount_price?>">
                <input type="hidden" name="total_delivery_money"	value="<?=$total_delivery_price?>">
                <input type="hidden" name="total_payment_money"		value="<?=$total_goods_price - $total_discount_price + $total_delivery_price?>">
                <input type="hidden" name="use_mileage"				value=0>
                <input type="hidden" name="pay_result"	value="N">		<!-- 모바일 버전은 결제 완료되면 이 값이 Y로 변경되어야 함 :: 결제 완료되면 order_pay_result.php에서 변경해줌 -->
                <input type="hidden" name="browser_info" id="browser_info">

                <div class="prd-all-price-box">
                    <dl class="prd-all-price-line">
                        <dt class="title">총 상품금액 (상품 <?=$idx?>개)</dt>
                        <dd class="price"><?=number_format($total_goods_price)?><span class="won">원</span></dd>
                    </dl>
                    <dl class="prd-all-price-line">
                        <dt class="title"><span class="minus"></span>총 할인금액</dt>
                        <dd class="price"><span name="finally_discount_price"><?=number_format($total_discount_price)?></span><span class="won">원</span></dd>
                    </dl>
                    <dl class="prd-all-price-line">
                        <dt class="title"><span class="plus"></span>총 배송비 (선불)</dt>
                        <dd class="price"><span name="total_delivery_price">10,000</span><span class="won">원</span><span name="total_add_delivery_price_1"></span></dd>
                    </dl>
                    <dl class="prd-all-price-line prd-all-price-line--total">
                        <dt class="title">결제 예정 금액</dt>
                        <dd class="price"><span name="finally_payment_price"><?=number_format($total_goods_price - $total_discount_price + $total_delivery_price)?></span><span class="won">원</span></dd>
                    </dl>
                </div>

                <!--                <div class="notice-section notice-section--bg notice-section--btn">-->
                <!--                    <span class="ico-i">i</span>-->
                <!--                    <span class="notice-section-text">할인쿠폰 적용&#47;수정은 상품페이지 및 장바구니에서 가능합니다.</span>-->
                <!--                    <a href="/cart" class="btn-white btn-white--gray btn-white--arrow">장바구니가기</a>-->
                <!--                </div>-->

                <div class="prd-order-section prd-order-section--pay prd-order-section--form">
                    <h3 class="info-title info-title--sub">주문자&#47;배송지 정보</h3>
                    <div class="form-line">
                        <div class="form-line-title"><label for="orderForm_1_1">주문자명</label></div>
                        <div class="form-line-info">
                            <input type="text" class="input-text" id="orderForm_1_1" name="order_name" value="<?=$order_name?>">
                        </div>
                    </div>

                    <div class="form-line">
                        <div class="form-line-title">배송지선택</div>
                        <div class="form-line-info position-area">
                            <? if($this->session->userdata('EMS_U_NO_') != "" && $this->session->userdata('EMS_U_ID_') != 'GUEST' && $this->session->userdata('EMS_U_ID_') != 'TMP_GUEST'){	?>
                                <label class="common-radio-label" for="orderForm_2_1">
                                    <input type="radio" id="orderForm_2_1" class="common-radio-btn" name="radio" checked onClick="javascript:jsAddrReset('A');">
                                    <span class="common-radio-text">최근배송지</span>
                                </label>
                                <label class="common-radio-label" for="orderForm_2_2">
                                    <input type="radio" id="orderForm_2_2" class="common-radio-btn" name="radio" onClick="javascript:jsAddrReset('B');">
                                    <span class="common-radio-text">새배송지</span>
                                </label>
                                <a href="#addressBookLayer" class="btn-white btn-white--select position-right" data-layer="bottom-layer-open2">주소록 선택</a>
                            <? } else {	?>
                                <label class="common-radio-label" for="orderForm_2_2">
                                    <input type="radio" id="orderForm_2_2" class="common-radio-btn" name="radio" checked onClick="javascript:jsAddrReset('B');">
                                    <span class="common-radio-text">새배송지</span>
                                </label>
                            <? }?>
                        </div>
                    </div>

                    <div class="form-line">
                        <div class="form-line-title"><label for="orderForm_3_1">받으시는분</label></div>
                        <div class="form-line-info">
                            <input type="text" class="input-text" id="orderForm_3_1" name="order_recipient" value="<?=$order_recipient?>" />
                        </div>
                    </div>

                    <div class="form-line form-line--rows">
                        <div class="form-line-title"><label for="orderForm_4_1">배송지주소</label></div>
                        <div class="form-line-info">
                            <div class="form-line--rows-item position-area form-line-info-item--btn">
                                <input type="text" class="input-text" id="orderForm_4_1" name="order_postnum_text">
                                <input type="hidden" name="order_postnum" id="order_postnum" value="">
                                <a href="#postcodeSearchLayer" class="btn-gray position-right" onclick="mobile_execDaumPostcode('orderForm_4_1','order_postnum','orderForm_4_2','order_addr1','orderForm_4_3');">우편번호 검색</a>
                            </div>

                            <div id="layer_post" style="display:none;position:absolute;overflow:hidden;z-index:100;-webkit-overflow-scrolling:touch;top:100px;">
                                <img src="//t1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:100" onclick="closeDaumPostcode()" alt="닫기 버튼">
                            </div>

                            <div class="form-line--rows-item" style="padding-top:.3125rem">
                                <label for="orderForm_4_2"><input type="text" class="input-text" id="orderForm_4_2" name="order_addr1_text"></label>
                                <input type="hidden" name="order_addr1" id="order_addr1" value="<?=$order_addr1?>">
                            </div>
                            <div class="form-line--rows-item">
                                <label for="orderForm_4_3"><input type="text" class="input-text" id="orderForm_4_3" name="order_addr2" value="<?=$order_addr2?>"></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-line form-line--cols">
                        <div class="form-line-title"><label for="orderForm_5_0">통신사</label></div>
                        <div class="form-line-info">
                            <div class="form-line--cols-item">
                                <div class="select-box select-box--big">
                                    <select class="select-box-inner" id="orderForm_5_0" name="order_commID">
                                        <option value="">선택</option>
                                        <option value="SKT">SKT</option>
                                        <option value="KTF">KT</option>
                                        <option value="LGT">LGU+</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-line form-line--cols">
                        <div class="form-line-title"><label for="orderForm_5_1">휴대폰번호</label></div>
                        <div class="form-line-info">
                            <div class="form-line--cols-item">
                                <div class="select-box select-box--big">
                                    <select class="select-box-inner" id="orderForm_5_1" name="order_mobile1">
                                        <option value="">선택</option>
                                        <option value="010">010</option>
                                        <option value="011">011</option>
                                        <option value="016">016</option>
                                        <option value="017">017</option>
                                        <option value="019">019</option>
                                    </select>
                                </div>
                            </div>
                            <span class="dash">-</span>
                            <div class="form-line--cols-item">
                                <label for="orderForm_5_2"><input type="text" class="input-text" id="orderForm_5_2" name="order_mobile2"></label>
                            </div>
                            <span class="dash">-</span>
                            <div class="form-line--cols-item">
                                <label for="orderForm_5_3"><input type="text" class="input-text" id="orderForm_5_3" name="order_mobile3"></label>
                            </div>
                            <input type="hidden" name="order_mobile" value="<?=$order_mobile?>">
                        </div>
                    </div>

                    <div class="form-line form-line--cols">
                        <div class="form-line-title"><label for="orderForm_6_1">전화번호<br><span class="light">(선택)</span></label></div>
                        <div class="form-line-info">
                            <div class="form-line--cols-item">
                                <div class="select-box select-box--big">
                                    <select class="select-box-inner" id="orderForm_6_1" name="order_phone1">
                                        <option value="">선택</option>
                                        <option value="02">02</option>
                                        <option value="031">031</option>
                                        <option value="032">032</option>
                                        <option value="033">033</option>
                                        <option value="041">041</option>
                                        <option value="042">042</option>
                                        <option value="043">043</option>
                                        <option value="044">044</option>
                                        <option value="051">051</option>
                                        <option value="052">052</option>
                                        <option value="053">053</option>
                                        <option value="054">054</option>
                                        <option value="055">055</option>
                                        <option value="061">061</option>
                                        <option value="062">062</option>
                                        <option value="063">063</option>
                                        <option value="064">064</option>
                                        <option value="070">070</option>
                                        <option value="080">080</option>
                                        <option value="0507">0507</option>
                                        <option value="0506">0506</option>
                                        <option value="0505">0505</option>
                                        <option value="0504">0504</option>
                                        <option value="0503">0503</option>
                                        <option value="0502">0502</option>
                                        <option value="0303">0303</option>
                                    </select>
                                </div>
                            </div>
                            <span class="dash">-</span>
                            <div class="form-line--cols-item">
                                <label for="orderForm_6_2"><input type="text" class="input-text" id="orderForm_6_2" name="order_phone2"></label>
                            </div>
                            <span class="dash">-</span>
                            <div class="form-line--cols-item">
                                <label for="orderForm_6_3"><input type="text" class="input-text" id="orderForm_6_3" name="order_phone3"></label>
                            </div>
                            <input type="hidden" name="order_phone" value="<?=$order_phone?>">
                        </div>
                    </div>

                    <div class="form-line form-line--cols">
                        <?
                        $email_com = '';
                        if($order_email){
                            $email_com = explode('@',$order_email)[1];
                            if($email_com != 'naver.com' || $email_com != 'hotmail.com' || $email_com != 'nate.com' || $email_com != 'yahoo.co.kr' || $email_com != 'paran.com' || $email_com != 'empas.com' || $email_com != 'dreamwiz.com' || $email_com != 'freechal.com' || $email_com != 'lycos.com' || $email_com != 'korea.com' || $email_com != 'gmail.com' || $email_com != 'hanmir.com'){
                                $user_mail =  $email_com;
                            }else{
                                $user_mail =  '';
                            }
                        }else{
                            $email_com = '';
                            $user_mail = '';
                        }
                        ?>
                        <div class="form-line-title"><label for="orderForm_7_1">이메일 </label></div>
                        <div class="form-line-info">
                            <div class="form-line--cols-item">
                                <input type="text" class="input-text" id="orderForm_7_1" name="order_email1" value="<?=$order_email ? explode('@',$order_email)[0] : ''?>">
                            </div>
                            <span class="dash">@</span>

                            <div class="form-line--cols-item">
                                <div class="select-box select-box--big">
                                    <label for="orderForm_7_2">이메일주소선택</label>

                                    <select class="select-box-inner" id="orderForm_7_2" data-ui="select-val">
                                        <option value="">선택</option>
                                        <option value="직접입력">직접입력</option>
                                        <option value="naver.com" <? if($order_email && explode('@',$order_email)[1] == 'naver.com') echo "selected" ?>>naver.com</option>
                                        <option value="hotmail.com" <? if($order_email && explode('@',$order_email)[1] == 'hotmail.com') echo "selected" ?>>hotmail.com</option>
                                        <option value="nate.com"  <? if($order_email && explode('@',$order_email)[1] == 'nate.com') echo "selected" ?>>nate.com</option>
                                        <option value="yahoo.co.kr" <? if($order_email && explode('@',$order_email)[1] == 'yahoo.co.kr') echo "selected" ?>>yahoo.co.kr</option>
                                        <option value="paran.com" <? if($order_email && explode('@',$order_email)[1] == 'paran.com') echo "selected" ?>>paran.com</option>
                                        <option value="empas.com" <? if($order_email && explode('@',$order_email)[1] == 'empas.com') echo "selected" ?>>empas.com</option>
                                        <option value="dreamwiz.com" <? if($order_email && explode('@',$order_email)[1] == 'dreamwiz.com') echo "selected" ?>>dreamwiz.com</option>
                                        <option value="freechal.com" <? if($order_email && explode('@',$order_email)[1] == 'freechal.com') echo "selected" ?>>freechal.com</option>
                                        <option value="lycos.co.kr" <? if($order_email && explode('@',$order_email)[1] == 'lycos.com') echo "selected" ?>>lycos.co.kr</option>
                                        <option value="korea.com" <? if($order_email && explode('@',$order_email)[1] == 'korea.com') echo "selected" ?>>korea.com</option>
                                        <option value="gmail.com" <? if($order_email && explode('@',$order_email)[1] == 'gmail.com') echo "selected" ?>>gmail.com</option>
                                        <option value="hanmir.com" <? if($order_email && explode('@',$order_email)[1] == 'hanmir.com') echo "selected" ?>>hanmir.com</option>
                                        <?
                                        if($order_email && $user_mail != ''){
                                            ?>
                                            <option value="<?=$user_mail?>"  <? if($order_email && explode('@',$order_email)[1] == $user_mail) echo "selected" ?> selected><?=$user_mail?></option>
                                            <?
                                        }
                                        ?>
                                    </select>
                                    <label for="formJoin05_2">이메일 주소 직접 입력</label>
                                    <span class="email-address-input" style="display:none;"><input type="email" id="formJoin05_2" name="order_email2" class="input-text" value="<?=$order_email ? explode('@',$order_email)[1] : ''?>"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-line">
                        <div class="form-line-title"><label for="orderForm_8_1">배송시<br>요청사항</label></div>
                        <div class="form-line-info">
                            <input type="text" class="input-text" id="orderForm_8_1" name="order_request" value="<?=$order_request?>">
                        </div>
                    </div>
                </div>

                <? if($DELIV_INFO == 'Y'){	?>
                    <div class="prd-order-section prd-order-section--pay">
                        <h3 class="info-title info-title--sub">가구 배송정보</h3>
                        <div class="form-line">
                            <div class="form-line-title"><label for="orderForm_9_1">주거층수</label></div>
                            <div class="form-line-info">
                                <div class="select-box select-box--big">
                                    <select class="select-box-inner" id="orderForm_9_1" name="shipping_floor">
                                        <option value="">선택</option>
                                        <option value="LOW" <?if($shipping_floor == 'LOW') echo "selected"?>>1~2층</option>
                                        <option value="HIGH" <?if($shipping_floor == 'HIGH') echo "selected"?>>3층이상</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-line">
                            <div class="form-line-title"><label for="orderForm_10_1">계단폭</label></div>
                            <div class="form-line-info">
                                <div class="select-box select-box--big">
                                    <select class="select-box-inner" id="orderForm_10_1" name="shipping_step_width">
                                        <option value="">선택</option>
                                        <option value="LOW" <?if($shipping_step_width == 'LOW') echo "selected"?>>2m미만</option>
                                        <option value="HIGH" <?if($shipping_step_width == 'HIGH') echo "selected"?> >2m이상</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-line">
                            <div class="form-line-title"><label for="orderForm_11_1">엘리베이터</label></div>
                            <div class="form-line-info">
                                <div class="select-box select-box--big">
                                    <select class="select-box-inner" id="orderForm_11_1" name="shipping_elevator">
                                        <option value="">선택</option>
                                        <option value="SEVEN" <?if($shipping_elevator == 'SEVEN') echo "selected"?> >1~7인승</option>
                                        <option value="TEN" <?if($shipping_elevator == 'TEN') echo "selected"?>>8~10인승</option>
                                        <option value="ELEVEN" <?if($shipping_elevator == 'ELEVEN') echo "selected"?>>11인승 이상</option>
                                        <option value="NONE" <?if($shipping_elevator == 'NONE') echo "selected"?>>없음</option>
                                        <option value="NOUSE" <?if($shipping_elevator == 'NOUSE') echo "selected"?>>사용불가</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="order-prd-agree-check">
                        <ul class="check-text-bg">
                            <li class="check-text-bg-item">
                                <input type="checkbox" id="orderPrdAgreeCheck1" class="checkbox" <?if($shipping_step_width != '') echo "checked"?>>
                                <label for="orderPrdAgreeCheck1" class="checkbox-label checkbox-label--right">제품 설치 할 공간을 미리 확보 하셨습니까?</label>
                            </li>
                            <li class="check-text-bg-item">
                                <input type="checkbox" id="orderPrdAgreeCheck2" class="checkbox" <?if($shipping_step_width != '') echo "checked"?>>
                                <label for="orderPrdAgreeCheck2" class="checkbox-label checkbox-label--right">(제품에 따라) 3층 이상 또는 계단 폭 2m 미만, 엘리베이터가 없거나 8인 이상이 아닌경우 사다리차가 필요합니다.(자세한 내용은 상품 정보 배송가이드 참조 또는 고객센터 문의) 이에 동의하십니까?</label>
                            </li>
                            <li class="check-text-bg-item">
                                <input type="checkbox" id="orderPrdAgreeCheck3" class="checkbox" <?if($shipping_step_width != '') echo "checked"?>>
                                <label for="orderPrdAgreeCheck3" class="checkbox-label checkbox-label--right">사다리차 이용이 필요한 경우 고객님 부담입니다. 이에 동의 하십니까? 사다리차 사용 거부 시, 반품 처리가 되며 반품비가 발생합니다. 가구 엘리베이터 이동이 불가능 할 시 부득이한 경우에만 사다리차를 사용합니다. 하단 <사다리차 추가비용 안내> 상세내용 필독바랍니다.</label>
                            </li>
                        </ul>

                        <a href="#layerOrderAddInfo" class="btn-white btn-order-prd-info" data-layer="bottom-layer-open2">사다리차 추가비용 안내</a>
                    </div>

                <?  } else {?>
                    <input type="hidden" name="shipping_floor"		value="">
                    <input type="hidden" name="shipping_step_width" value="">
                    <input type="hidden" name="shipping_elevator"	value="">
                <?  }?>

                <!-------------------------------------->
                <!-- 개인통관고유부호 (해외직구 상품) -->
                <!-------------------------------------->
                <? if($SEND_NATION_INFO == 'Y'){	?>
                    <div class="customs-agree-box">
                        <h3 class="info-title info-title--sub">개인통관고유부호 (해외직구 상품)</h3>
                        <div class="check-text-bg-item">
                            <input type="checkbox" id="orderCustomsAgreeCheck1" class="checkbox" <?if($orderCustomsNum != '') echo "checked"?>>
                            <label for="orderCustomsAgreeCheck1" class="checkbox-label checkbox-label--right">통관정보 수집 및 제공에 동의 (필수)</label>
                        </div>
                        <div class="check-text-bg-item">
                            <input type="checkbox" id="orderCustomsAgreeCheck2" class="checkbox">
                            <label for="orderCustomsAgreeCheck2" class="checkbox-label checkbox-label--right">개인통관고유부호의 이름과 주문하시는분, 받으시는분 이름은 모두 동일해야 합니다. 동일한지 확인하셨습니까? (필수)</label>
                        </div>

                        <div class="form-line">
                            <div class="form-line-title"><label for="orderCustomsNum">고유부호</label></div>
                            <div class="form-line-info">
                                <input type="text" class="input-text" id="orderCustomsNum" name="orderCustomsNum" placeholder="P자로 시작하는 개인통관 고유부호 입력" value="<?=$orderCustomsNum?>" >
                            </div>
                        </div>
                        <ul class="text-list">
                            <li class="text-item">개인통관 고유부호는 개인정보 유출을 방지하기 위하여 관세청에서 개인물품 수입신고시 주민등록번호 대신 활용할 수 있는 개인식별 고유번호입니다. 관세청시스템(https://p.customs.go.kr)에서본인인증 및 신청 즉시 부여되며 한 번 발급된 부호는 계속 사용 가능합니다.</li>
                            <li class="text-item">통관업무를 위해 개인통관고유부호를 수집하여 공급자에게 제공하며, 다음 주문시 사용할 수 있도록 서비스 이용기간동안 보관합니다.</li>
                        </ul>
                    </div>
                <? }else{?>
                    <input type="hidden" name="orderCustomsNum" value="" >
                <?}?>

                <div class="prd-order-dc-benefit prd-order-section prd-order-section--pay ">
                    <h3 class="info-title info-title--sub">할인/혜택 적용</h3>
                    <dl class="prd-order-dc-benefit-all-price">
                        <dt class="title">총 주문금액</dt>
                        <dd class="price">
                            <strong class="price-bold"><?=number_format($total_goods_price)?></strong><span class="won">원</span>
                            <p class="price-tip">(배송비 제외 금액입니다.)</p>
                        </dd>
                    </dl>
                    <div class="form-line form-line--text">
                        <div class="form-line-title">총 배송비(선불)</div>
                        <div class="form-line-info">
                            <span name="total_delivery_price">10,000</span>원<span name="total_add_delivery_price_2"></span>
                        </div>
                    </div>
                    <div class="form-line">
                        <div class="form-line-title"><label for="prdOrderDcBenefit1">브랜드할인</label></div>
                        <div class="form-line-info">
                            <input type="text" class="input-text" id="prdOrderDcBenefit1" name="brand_price" value="<?=number_format(floor($goods_seller_amt_sum))?>" disabled> <span class="won">원</span>
                        </div>
                    </div>
                    <div class="form-line">
                        <div class="form-line-title"><label for="prdOrderDcBenefit2">에타할인</label></div>
                        <div class="form-line-info">
                            <input type="text" class="input-text" id="prdOrderDcBenefit2" name="discount_price" value="<?=number_format(floor($goods_item_amt_sum)+$goods_cust_amt_sum)?>" disabled> <span class="won">원</span>
                        </div>
                    </div>
                    <div class="form-line">
                        <div class="form-line-title"><label for="formDcMileage">마일리지</label></div>
                        <div class="form-line-info">
                            <input type="text" class="input-text" id="formDcMileage" value="<?=$formDcMileage?>" placeholder=0> <span class="won point">P</span>
                        </div>
                    </div>
                    <div class="prd-order-dc-benefit-mileage">
                        <p class="mileage-point">사용가능 : <strong class="point"><?=number_format($mileage)?></strong> P</p>
                        <p class="mileage-check">
                            <input type="checkbox" id="prdOrderDcBenefit4" class="checkbox" onClick="javascript:jsAllUsemileage(this.checked);">
                            <label for="prdOrderDcBenefit4" class="checkbox-label">모두사용</label>
                            <a href="javascript://" onClick="jsUsemileage();" class="btn-black">적용</a>
                        </p>
                    </div>

                    <dl class="prd-all-price-line prd-all-price-line--total">
                        <dt class="title">최종결제금액</dt>
                        <dd class="price">
                            <span name="finally_payment_price"><?=number_format($total_goods_price - $total_discount_price + $total_delivery_price)?></span><span class="won">원</span>
                            <p class="price-tip">(배송비 포함. 착불 제외)</p>
                        </dd>
                    </dl>
                    <ul class="text-list">
                        <!--                    <li class="text-item">마일리지는 1,000P 이상부터 1,000P단위로 사용가능합니다.</li>-->
                        <li class="text-item">마일리지 보유금액 1,000p 이상부터 사용 가능합니다.</li>
                        <li class="text-item">배송비 별도표기 및 착불인 경우, 결제금액에 포함되지 않습니다.</li>
                    </ul>
                </div>

                <div class="prd-order-section prd-order-section--pay payment-method-select">
                    <h3 class="info-title info-title--sub">결제수단 선택</h3>
                    <ul class="tab-common-list">
                        <li class="tab-common-item active"><a id="paymethod_card" href="#creditCard" class="tab-common-link" data-ui="btn-tab">신용카드(일반)</a></li>
                        <!-- 활성화시 클래스 active추가 -->
                        <li class="tab-common-item"><a id="paymethod_trans" href="#realTimeAccount" class="tab-common-link" data-ui="btn-tab">실시간계좌이체</a></li>
                        <li class="tab-common-item"><a id="paymethod_vbank" href="#noPassbook" class="tab-common-link" data-ui="btn-tab">무통장입금</a></li>
                        <li class="tab-common-item"><a id="paymethod_phone" href="#phonePay" class="tab-common-link" data-ui="btn-tab">휴대폰 결제</a></li>
                        <?if($CATEGORY_PET == 'N'){?>
                            <li class="tab-common-item"><a id="paymethod_kakao" href="#kakaoPay" class="tab-common-link kakao" data-ui="btn-tab"><img alt="" src="../assets/images/sprite/payment_icon_yellow_large.png"/><span>카카오페이</span></a></li>
                        <?}?>
                        <li class="tab-common-item"><a id="paymethod_vars" href="#varsPay" class="tab-common-link" data-ui="btn-tab">ARS 결제</a></li>
                    </ul>

                    <!-- 결제수단 신용카드 // -->
                    <div class="payment-method-content" id="creditCard" data-ui="tab-cont" style="display: block">
                        <ul class="check-text-bg">
                            <li class="check-text-bg-item">
                                <input type="checkbox" id="checkAgree4" class="checkbox" name="formAgree">
                                <label for="checkAgree4" class="checkbox-label checkbox-label--right">주문 상품의 상품명, 상품가격, 배송정보를 확인하였으며, 구매에 동의하겠습니다. (전자상거래8조2항)</label>
                            </li>
                        </ul>
                    </div>
                    <!-- // 결제수단 신용카드 -->

                    <!-- 결제수단 실시간계좌이체 // -->
                    <div class="payment-method-content" id="realTimeAccount" data-ui="tab-cont">
                        <ul class="check-text-bg">
                            <li class="check-text-bg-item">
                                <input type="checkbox" id="checkAgree5" class="checkbox" name="formAgree">
                                <label for="checkAgree5" class="checkbox-label checkbox-label--right">주문 상품의 상품명, 상품가격, 배송정보를 확인하였으며, 구매에 동의하겠습니다. (전자상거래8조2항)</label>
                            </li>
                            <li class="check-text-bg-item">
                                <input type="checkbox" id="checkAgree6" class="checkbox">
                                <label for="checkAgree6" class="checkbox-label checkbox-label--right">에스크로(구매안전)서비스를 적용합니다.</label>
                            </li>
                        </ul>
                    </div>
                    <!-- // 결제수단 실시간계좌이체 -->

                    <!-- 결제수단 무통장입금 // -->
                    <div class="payment-method-content" id="noPassbook" data-ui="tab-cont">

                        <div class="prd-order-section--pay">
                            <br /><h3 class="info-title info-title--sub">환불계좌 등록</h3>
                            <div class="prd-order-dc-benefit">
                                <div class="form-line">
                                    <div class="form-line-title"><label for="selRefundBank">은행</label></div>
                                    <div class="form-line-info">
                                        <div class="select-box select-box--big">
                                            <select class="select-box-inner" id="selRefundBank" name="selRefundBank">
                                                <option value="">은행선택</option>
                                                <option value="국민은행">국민은행</option>
                                                <option value="기업은행">기업은행</option>
                                                <option value="신한은행">신한은행</option>
                                                <option value="우리은행">우리은행</option>
                                                <option value="KEB하나은행">KEB하나은행</option>
                                                <option value="SC은행">SC은행</option>
                                                <option value="농협중앙회">농협중앙회</option>
                                                <option value="단위농협">단위농협</option>
                                                <option value="우체국">우체국</option>
                                                <option value="전북은행">전북은행</option>
                                                <option value="제주은행">제주은행</option>
                                                <option value="경남은행">경남은행</option>
                                                <option value="광주은행"">광주은행</option>
                                                <option value="대구은행">대구은행</option>
                                                <option value="부산은행">부산은행</option>
                                                <option value="산림조합">산림조합</option>
                                                <option value="상호저축은행">상호저축은행</option>
                                                <option value="새마을금고">새마을금고</option>
                                                <option value="수협">수협</option>
                                                <option value="신협">신협</option>
                                                <option value="한국씨티은행">한국씨티은행</option>
                                                <option value="산업은행">산업은행</option>
                                                <option value="케이뱅크">케이뱅크</option>
                                                <option value="카카오뱅크">카카오뱅크</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-line">
                                    <div class="form-line-title"><label for="txtRefundAccount">계좌번호</label></div>
                                    <div class="form-line-info">
                                        <input type="text" class="input-text" name="txtRefundAccount" id="txtRefundAccount" value="" placeholder="'-' 없이 입력해주세요." style="text-align: left;">
                                    </div>
                                </div>
                                <div class="form-line">
                                    <div class="form-line-title"><label for="txtRefundCust">예금주</label></div>
                                    <div class="form-line-info">
                                        <input type="text" class="input-text" name="txtRefundCust" id="txtRefundCust" value="" style="text-align: left;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br />

                        <ul class="check-text-bg">
                            <li class="check-text-bg-item">
                                <input type="checkbox" id="checkAgree7" class="checkbox">
                                <label for="checkAgree7" class="checkbox-label checkbox-label--right">주문 상품의 상품명, 상품가격, 배송정보를 확인하였으며, 구매에 동의하겠습니다. (전자상거래8조2항)</label>
                            </li>
                            <li class="check-text-bg-item">
                                <input type="checkbox" id="checkAgree8" class="checkbox">
                                <label for="checkAgree8" class="checkbox-label checkbox-label--right">에스크로(구매안전)서비스를 적용합니다.</label>
                            </li>
                        </ul>
                    </div>
                    <!-- // 결제수단 무통장입금 -->

                    <!-- 결제수단 휴대폰 결제 // -->
                    <div class="payment-method-content" id="phonePay" data-ui="tab-cont">
                        <ul class="check-text-bg">
                            <li class="check-text-bg-item">
                                <input type="checkbox" id="checkAgree9" class="checkbox">
                                <label for="checkAgree9" class="checkbox-label checkbox-label--right">주문 상품의 상품명, 상품가격, 배송정보를 확인하였으며, 구매에 동의하겠습니다. (전자상거래8조2항)</label>
                            </li>
                        </ul>
                    </div>
                    <!-- // 결제수단 휴대폰 결제 -->

                    <!-- 결제수단 카카오페이 결제 // -->
                    <div class="payment-method-content" id="kakaoPay" data-ui="tab-cont">
                        <ul class="check-text-bg">
                            <li class="check-text-bg-item">
                                <input type="checkbox" id="checkAgree11" class="checkbox">
                                <label for="checkAgree11" class="checkbox-label checkbox-label--right">주문 상품의 상품명, 상품가격, 배송정보를 확인하였으며, 구매에 동의하겠습니다. (전자상거래8조2항)</label>
                            </li>
                        </ul>
                    </div>
                    <!-- // 결제수단 카카오페이 결제 -->

                    <!-- 결제수단 ARS결제 // -->
                    <div class="payment-method-content" id="varsPay" data-ui="tab-cont">
                        <ul class="check-text-bg">
                            <li class="check-text-bg-item">
                                <input type="checkbox" id="checkAgree12" class="checkbox" name="formAgree">
                                <label for="checkAgree12" class="checkbox-label checkbox-label--right">주문 상품의 상품명, 상품가격, 배송정보를 확인하였으며, 구매에 동의하겠습니다. (전자상거래8조2항)</label>
                            </li>
                        </ul>
                    </div>
                    <!-- // 결제수단 ARS결제 -->


                    <a href="javascript://" onClick="javascript:jsOrderPayKCP();" class="payment-method-select-price" id="pay_kcp">
                        <span name="finally_payment_price"><?=number_format($total_goods_price - $total_discount_price + $total_delivery_price)?></span>원 결제하기
                    </a>

                    <a href="javascript://" onClick="javascript:jsOrderPayKAKAO();" class="payment-method-select-price" id="pay_kakao" style="display: none;">
                        <span name="finally_payment_price"><?=number_format($total_goods_price - $total_discount_price + $total_delivery_price)?></span>원 결제하기
                    </a>

                    <a href="javascript://" onClick="javascript:jsOrderPayARS();" class="payment-method-select-price" id="pay_ars" style="display: none;">
                        <span name="finally_payment_price"><?=number_format($total_goods_price - $total_discount_price + $total_delivery_price)?></span>원 결제하기
                    </a>

                    <!-- 결제 정보 안내-->
                    <div class="notice-section" id="credit_info" style="display:block;">
                        <h4 class="notice-section-title"><span class="ico-i">i</span>결제 이용 안내</h4>
                        <ul class="text-list">
                            <li class="text-item">신용카드, 실시간 계좌이체는 안전거래 서비스 KCP 전자결제를 통해 결제 됩니다.</li>
                            <li class="text-item">무이자행사는 '무이자안내'팝업 또는 KCP 전자결제 창에서 확인가능합니다.</li>
                            <li class="text-item">에타 가구와 생활용품(소품/패브릭)의 배송은 제품별로 설치, 택배 상품으로 각각 나뉘어 배송됩니다.</li>
                            <li class="text-item">에타배송 상품과 업체 배송 상품을 같이 구매하실 경우, 각각의 배송비가 적용되며 각각 배송됩니다.</li>
                        </ul>
                    </div>

                    <!-- 카카오페이 이용 안내-->
                    <div class="notice-section" id="kakao_info" style="display: none;">
                        <h4 class="notice-section-title"><span class="ico-i">i</span>카카오페이 이용 안내</h4>
                        <ul class="text-list">
                            <li class="text-item">카카오페이는 카카오톡에 개인 신용/체크 카드를 등록하여 간단하게 비밀번호 만으로 결제할 수있는 모바일 결제 서비스입니다. 등록 시 휴대폰과 카드 명의자가 동일해야 합니다.</li>
                            <li class="text-item">무이자 할부 서비스 및 신용카드 전용쿠폰 서비스는 이용이 제한 됩니다.</li>
                            <li class="text-item">카카오머니로 결제 시, 현금영수증 발급은 ㈜카카오페이에서 발급가능합니다.</li>
                        </ul>
                    </div>

                    <!-- 무이자할부 이용 안내-->
                    <div class="notice-section">
                        <h4 class="notice-section-title"><span class="ico-i">i</span>무이자할부 이용 안내</h4>
                        <ul class="text-list">
                            <li class="text-item">무이자 할부 개월 수가 다른 상품을 한번에 주문하시는 경우, 가장 낮은 할부 개월 수가 적용됩니다. 원치 않으시면 각각 주문해주세요. (예:6개월, 3개월 무이자 상품 동시 결제 시 3개월 무이자로 결제)</li>
                            <li class="text-item">무이자행사는 카드사 사정에 따라 변경 또는 중단될 수 있습니다.</li>
                        </ul>
                    </div>
                </div>

            </div>
        </form>

        <!-- 주소록선택 레이어 // -->
        <div class="common-layer-wrap address-book-layer" id="addressBookLayer">
            <h3 class="common-layer-title">주소록</h3>
            <div class="common-layer-content">
                <div class="common-layer-inner">
                    <ul class="address-book-list">
                        <? $i=0;
                        if($cust_delivery){
                            foreach($cust_delivery as $row){	?>
                                <li class="address-book-item">
                                    <label>
                                        <span class="title"><?=$row['CUST_DELIV_ADDR_NM']?></span>
                                        <span class="address">[<?=strlen($row['ZIPCODE']) == '6' ? substr($row['ZIPCODE'],0,3)."-".substr($row['ZIPCODE'],3,3) : $row['ZIPCODE']?>] <?=$row['ADDR1']." ".$row['ADDR2']?><br>휴대폰번호 : <?=$row['MOB_NO']?></span>
                                        <input type="radio" class="common-radio-btn" name="address_book" id="formAddressBook_<?=$i?>" value="<?=$i?>" <?if($row['BASE_DELIV_ADDR_YN'] == 'Y'){?>checked="checked"<?}?>>
                                        <input type="hidden" name="cust_zipcode[]"	value="<?=strlen($row['ZIPCODE']) == '6' ? substr($row['ZIPCODE'],0,3)."-".substr($row['ZIPCODE'],3,3) : $row['ZIPCODE']?>">
                                        <input type="hidden" name="cust_addr1[]"	value="<?=$row['ADDR1']?>">
                                        <input type="hidden" name="cust_addr2[]"	value="<?=$row['ADDR2']?>">
                                    </label>
                                </li>
                                <? $i++;
                            }
                        } else {?>
                            <li class="address-book-item">
                                <span class="title">주소록에 등록된 주소가 없습니다.</span>
                                <span class="address">[마이페이지 &gt; 회원정보 - 배송지관리]에서 주소를 등록해주세요.</span>
                            </li>
                        <? }?>
                    </ul>

                    <ul class="common-btn-box common-btn-box--layer">
                        <li class="common-btn-item"><a href="#" class="btn-gray-link" data-close="bottom-layer-close2">취소</a></li>
                        <li class="common-btn-item"><a href="#" onClick="javascript:jsUseaddr('C');" class="btn-black-link">적용</a></li>
                    </ul>
                </div>
                <a href="#" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>
            </div>
        </div>

        <!-- // 주소록선택 레이어 -->

        <!-- 지역별 추가배송비 확인 레이어 // -->
        <?	if(count($cart) != 0){
            $idx = 0;
            foreach($cart as $cart_grp){
                foreach($cart_grp as $row){
                    $seller_coupon_max	= isset($row['SELLER_COUPON_MAX']) ? $row['SELLER_COUPON_MAX'] : 0;
                    $item_coupon_max	= isset($row['ITEM_COUPON_MAX']) ? $row['ITEM_COUPON_MAX'] : 0;
                    $seller_coupon_amt	= isset($row['SELLER_COUPON_AMT']) ? $row['SELLER_COUPON_AMT'] : 0;
                    $item_coupon_amt	= isset($row['ITEM_COUPON_AMT']) ? $row['ITEM_COUPON_AMT'] : 0;

                    if($seller_coupon_amt > $seller_coupon_max && $seller_coupon_max != 0){
                        $seller_coupon_amt	= $seller_coupon_max * $row['GOODS_CNT'];
                    } else {
                        $seller_coupon_amt	= $seller_coupon_amt * $row['GOODS_CNT'];
                    }

                    if($item_coupon_amt > $item_coupon_max && $item_coupon_max != 0){
                        $item_coupon_amt	= $item_coupon_max * $row['GOODS_CNT'];
                    } else {
                        $item_coupon_amt	= $item_coupon_amt * $row['GOODS_CNT'];
                    }

                    $goods_price = $row['SELLING_PRICE']*$row['GOODS_CNT'];
                    ?>
                    <!-- 쿠폰적용하기 레이어 // -->
                    <div class="common-layer-wrap cart-coupon-layer" id="cartCouponLayer<?=$idx?>">
                        <!-- common-layer-wrap--view 추가 -->
                        <h3 class="common-layer-title">쿠폰 적용하기</h3>

                        <!-- common-layer-content // -->
                        <div class="common-layer-content">
                            <div class="basic-table-wrap">
                                <table class="basic-table">
                                    <colgroup>
                                        <col style="width:30%;">
                                        <col style="width:47%;">
                                        <col style="width:23%;">
                                    </colgroup>
                                    <tr>
                                        <th scope="row" class="tb-info-title">할인구분</th>
                                        <th scope="row" class="tb-info-title">쿠폰명</th>
                                        <th scope="row" class="tb-info-title">할인액</th>
                                    </tr>
                                    <tr>
                                        <td class="tb-info-txt">판매자할인</td>
                                        <td class="tb-info-txt">
                                            <ul>
                                                <? $idx2 = 0;
                                                if($row['AUTO_COUPON_LIST']){
                                                    foreach($row['AUTO_COUPON_LIST'] as $row2)	{
                                                        if($row2['COUPON_KIND_CD'] == 'SELLER'){

                                                            $row2['COUPON_PRICE'] = $row2['COUPON_DC_METHOD_CD'] == 'RATE' ? floor($row2['COUPON_SALE']/100*$goods_price) : $row2['COUPON_SALE'];

                                                            $row2 = str_replace("\"","&ldquo;",$row2);		//큰따옴표 치환
                                                            ?>
                                                            <li class="tb-info-txt-item">
                                                                <label>
                                                                    <input type="radio" class="common-radio-btn" name="coupon_select_S<?=$idx?>" id="coupon_1_1"  value="<?=$row2['COUPON_CD']?>||<?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>||<?=($row2['COUPON_PRICE']/$row['GOODS_CNT'])?>||<?=$row2['MAX_DISCOUNT']?>" checked>
                                                                    <!-- 쿠폰코드||쿠폰명||할인금액||최대할인금액 -->
                                                                    <p class="tb-info-txt-right"><?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>
                                                                        <span class="tb-info-txt--font"><?=$row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE'].'%' : number_format($row2['COUPON_SALE']).'원'?>할인 <?=$row2['MAX_DISCOUNT'] ? "(최대 ".number_format($row2['MAX_DISCOUNT'])."원 할인)" : ""?></span>
                                                                    </p>
                                                                </label>
                                                            </li>
                                                            <?  $coupon_S_text = $row2['MAX_DISCOUNT'] < ($row2['COUPON_PRICE']/$row['GOODS_CNT']) && $row2['MAX_DISCOUNT'] != 0 ? number_format($row2['MAX_DISCOUNT']*$row['GOODS_CNT']) : number_format($row2['COUPON_PRICE']);
                                                            $idx2++;
                                                        }//END IF
                                                        else if($row2['COUPON_KIND_CD'] != 'GOODS' || count($row['AUTO_COUPON_LIST']) == 1){	?>
                                                            <li class="tb-info-txt-item">
                                                                적용 가능 쿠폰이 없습니다.
                                                            </li>
                                                            <?
                                                            $coupon_S_text = 0;
                                                        }
                                                    }//END FOREACH
                                                }//END IF
                                                else {	?>
                                                    <li class="tb-info-txt-item">
                                                        적용 가능 쿠폰이 없습니다.
                                                    </li>
                                                    <?
                                                    $coupon_S_text = 0;
                                                }
                                                ?>
                                            </ul>
                                        </td>
                                        <!-- 밑에 함수에서 사용쿠폰 표시를 위해 각 상품별 셀러쿠폰이 몇개인지 알려주는 변수 -->
                                        <input type="hidden"	name="seller_coupon_cnt[]"			value="<?=$idx2?>">
                                        <td class="tb-info-txt">
                                            <?=$coupon_S_text?>원
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tb-info-txt">에타할인</td>
                                        <td class="tb-info-txt">
                                            <ul>
                                                <? $idx2 = 0;
                                                $ITEM_COUPON_YN = '';
                                                $coupon_E_text = 0;
                                                if($row['AUTO_COUPON_LIST'] || $row['CUST_COUPON_LIST']){
                                                    foreach($row['AUTO_COUPON_LIST'] as $row2)	{
                                                        if($row2['COUPON_KIND_CD'] == 'GOODS'){

                                                            $row2['COUPON_PRICE'] = $row2['COUPON_DC_METHOD_CD'] == 'RATE' ? floor($row2['COUPON_SALE']/100*$goods_price) : $row2['COUPON_SALE'];

                                                            $row2 = str_replace("\"","&ldquo;",$row2);		//큰따옴표 치환
                                                            ?>
                                                            <li class="tb-info-txt-item">
                                                                <label>
                                                                    <input type="radio" class="common-radio-btn" name="coupon_select_E<?=$idx?>" id="coupon_E<?=$idx?>_<?=$idx2?>" onClick="javascript:Coupon_check('E',this.value,<?=$idx?>,<?=$idx2?>);" value="<?=$row2['COUPON_CD']?>||<?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>||<?=($row2['COUPON_PRICE']/$row['GOODS_CNT'])?>||<?=$row2['MAX_DISCOUNT']?>||COUPON_I" checked>
                                                                    <p id="coupon_name_E<?=$idx?>_<?=$idx2?>" class="tb-info-txt-right"><?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>
                                                                        <span class="tb-info-txt--font"><?=$row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE'].'%' : number_format($row2['COUPON_SALE']).'원'?>할인 <?=$row2['MAX_DISCOUNT'] ? "(최대 ".number_format($row2['MAX_DISCOUNT'])."원 할인)" : ""?></span>
                                                                    </p>
                                                                </label>
                                                            </li>
                                                            <?	$coupon_E_text = $row2['MAX_DISCOUNT'] < ($row2['COUPON_PRICE']/$row['GOODS_CNT']) && $row2['MAX_DISCOUNT'] != 0 ? number_format($row2['MAX_DISCOUNT']*$row['GOODS_CNT']) : number_format($row2['COUPON_PRICE']);	//COUPON_PRICE에 이미 CNT가격포함
                                                            ?>

                                                            <?		$ITEM_COUPON_YN = 'Y';
                                                            $idx2++;
                                                        }
                                                    }	//END FOREACH
                                                    foreach($row['CUST_COUPON_LIST'] as $row2)	{
                                                        if($row2['BUYER_COUPON_DUPLICATE_DC_YN'] == 'N' && $row2['MIN_AMT'] < (($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT'])){
                                                            $row2['COUPON_PRICE'] = $row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE']/100*$goods_price : $row2['COUPON_SALE']*$row['GOODS_CNT'];

                                                            $row2 = str_replace("\"","&ldquo;",$row2);		//큰따옴표 치환

                                                            ?>
                                                            <li class="tb-info-txt-item">
                                                                <label>
                                                                    <input type="radio" class="common-radio-btn" name="coupon_select_E<?=$idx?>" id="coupon_E<?=$idx?>_<?=$idx2?>" onClick="javascript:Coupon_check('E',this.value,<?=$idx?>,<?=$idx2?>);" value="<?=$row2['COUPON_CD']?>||<?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>||<?=$row2['COUPON_PRICE']/$row['GOODS_CNT']?>||<?=$row2['MAX_DISCOUNT']?>||COUPON_B||<?=$row2['BUYER_COUPON_GIVE_METHOD_CD']?>||<?=$row2['BUYER_COUPON_DUPLICATE_DC_YN']?>||<?=$row2['GUBUN']?>||<?=$row2['CUST_COUPON_NO']?>">
                                                                    <p id="coupon_name_E<?=$idx?>_<?=$idx2?>" class="tb-info-txt-right"><?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>
                                                                        <span class="tb-info-txt--font"><?=$row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE'].'%' : number_format($row2['COUPON_SALE']).'원'?>할인 <?=$row2['MAX_DISCOUNT'] ? "(최대 ".number_format($row2['MAX_DISCOUNT'])."원 할인)" : ""?></span>
                                                                    </p>
                                                                </label>
                                                            </li>
                                                            <?	if(!$row['AUTO_COUPON_LIST']){
                                                                $coupon_E_text = 0;
                                                            }
                                                            if($ITEM_COUPON_YN == ''){
                                                                $ITEM_COUPON_YN = 'N';
                                                            }

                                                            $idx2++;
                                                        }
                                                    }	//END FOREACH

                                                    if(($row['AUTO_COUPON_LIST'] && ($row['AUTO_COUPON_LIST'][0]['COUPON_KIND_CD'] == 'GOODS') || (@$row['AUTO_COUPON_LIST'][1]['COUPON_KIND_CD'] == 'GOODS')) || $row['CUST_COUPON_LIST']){
                                                        ?>
                                                        <li class="tb-info-txt-item">
                                                            <label>
                                                                <input type="radio" class="common-radio-btn" name="coupon_select_E<?=$idx?>" class="radio" id="coupon_E<?=$idx?>_<?=$idx2?>" value="" onClick="javascript:Coupon_check('EN',this.value,<?=$idx?>,<?=$idx2?>);"<?if($ITEM_COUPON_YN == 'N'){?>checked<?}?>>
                                                                <p class="tb-info-txt-right">쿠폰 적용 안함</p>
                                                            </label>
                                                        </li>
                                                        <?
                                                    } else {	?>
                                                        <li class="tb-info-txt-item">
                                                            적용 가능 쿠폰이 없습니다.
                                                        </li>
                                                        <?		$coupon_E_text = 0;
                                                    }

                                                }	//END IF
                                                else {	?>
                                                    <li class="tb-info-txt-item">
                                                        적용 가능 쿠폰이 없습니다.
                                                    </li>
                                                    <?
                                                    $coupon_E_text = 0;
                                                }
                                                ?>

                                            </ul>
                                        </td>
                                        <!-- 밑에 함수에서 사용쿠폰 표시를 위해 각 상품별 셀러쿠폰이 몇개인지 알려주는 변수 -->
                                        <input type="hidden"	name="item_coupon_cnt[]"			value="<?=$idx2?>">
                                        <td class="tb-info-txt">
                                            <span name="coupon_E_text<?=$idx?>"><?=$coupon_E_text?></span>원
                                        </td>
                                    </tr>
                                    <tr id="dup_coupon_<?=$idx?>">
                                        <td class="tb-info-txt">에타중복할인</td>
                                        <td class="tb-info-txt">
                                            <ul>
                                                <? $idx2 = 0;
                                                if($row['CUST_COUPON_LIST']){
                                                    foreach($row['CUST_COUPON_LIST'] as $row2)	{
                                                        if($row2['BUYER_COUPON_DUPLICATE_DC_YN'] == 'Y' && $row2['MIN_AMT'] < (($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT'])){	//최소금액 이상일때 보임

                                                            $row2['COUPON_PRICE'] = $row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE']/100*$goods_price : $row2['COUPON_SALE']*$row['GOODS_CNT'];

                                                            $row2 = str_replace("\"","&ldquo;",$row2);		//큰따옴표 치환
                                                            ?>
                                                            <li class="tb-info-txt-item">
                                                                <label>
                                                                    <input type="radio" class="common-radio-btn" name="coupon_select_C<?=$idx?>" id="coupon_C<?=$idx?>_<?=$idx2?>" onClick="javascript:Coupon_check('C',this.value,<?=$idx?>,<?=$idx2?>);" value="<?=$row2['COUPON_CD']?>||<?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>||<?=$row2['COUPON_PRICE']/$row['GOODS_CNT']?>||<?=$row2['MAX_DISCOUNT'] ? $row2['MAX_DISCOUNT'] : 0?>||<?=$row2['COUPON_DTL_NO']?>||<?=$row2['BUYER_COUPON_GIVE_METHOD_CD']?>||<?=$row2['BUYER_COUPON_DUPLICATE_DC_YN']?>||<?=$row2['GUBUN']?>||<?=$row2['CUST_COUPON_NO']?>">
                                                                    <p class="tb-info-txt-right" id="coupon_name_C<?=$idx?>_<?=$idx2?>"><?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>
                                                                        <span class="tb-info-txt--font"><?=$row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE'].'%' : number_format($row2['COUPON_SALE']).'원'?>할인 <?=$row2['MAX_DISCOUNT'] ? "(최대 ".number_format($row2['MAX_DISCOUNT'])."원 할인)" : ""?></span>
                                                                    </p>
                                                                </label>
                                                            </li>
                                                            <? $idx2++;
                                                        }	//END IF
                                                    } //END FOREACH

                                                    if($idx2>0){	//최소금액 이상일때 보임?>
                                                        <li class="tb-info-txt-item">
                                                            <label>
                                                                <input type="radio" class="common-radio-btn"  name="coupon_select_C<?=$idx?>" id="coupon_C<?=$idx?>_<?=$idx2?>" value="" onClick="javascript:Coupon_check('CN',this.value,<?=$idx?>,<?=$idx2?>);" checked>
                                                                <p class="tb-info-txt-right">쿠폰 적용 안함</p>
                                                            </label>
                                                        </li>
                                                    <? } else {	?>
                                                        <input type="hidden" name="coupon_select_C<?=$idx?>" id="coupon_C<?=$idx?>_<?=$idx2?>" value="">
                                                        <li class="tb-info-txt-item">
                                                            적용 가능 쿠폰이 없습니다.
                                                        </li>
                                                    <? } ?>
                                                    <?
                                                    $coupon_C_text = 0;
                                                } //END IF
                                                else {?>
                                                    <input type="hidden" name="coupon_select_C<?=$idx?>" id="coupon_C<?=$idx?>_<?=$idx2?>" value="">
                                                    <li class="tb-info-txt-item">
                                                        적용 가능 쿠폰이 없습니다.
                                                    </li>
                                                    <?
                                                    $coupon_C_text = 0;
                                                } ?>


                                            </ul>
                                        </td>
                                        <!-- 밑에 함수에서 사용쿠폰 표시를 위해 각 상품별 추가쿠폰이 몇개인지 알려주는 변수 -->
                                        <input type="hidden"	name="add_coupon_cnt[]"			value="<?=$idx2?>">
                                        <td class="tb-info-txt">
                                            <span name="coupon_C_text<?=$idx?>"><?=$coupon_C_text?></span>원
                                        </td>
                                    </tr>
                                    <!-- seller & item value :: 쿠폰코드||쿠폰명||할인금액||최대할인금액)
                                         cust value :: 쿠폰코드||쿠폰명||할인금액||최대할인금액||쿠폰번호||쿠폰지급방식||중복여부)	-->
                                    <input type="hidden" name="goods_seller_coupon_<?=$idx?>"		value="">
                                    <input type="hidden" name="goods_item_coupon_<?=$idx?>"			value="">
                                    <input type="hidden" name="goods_cust_coupon_<?=$idx?>"			value="">
                                    <tr>
                                        <td colspan="3" class="tb-info-txt tb-info-total">쿠폰할인 총액 <strong class="total-color"><span name="coupon_total_amt_<?=$idx?>"><?=number_format(($seller_coupon_amt+$item_coupon_amt))?></span></strong><span class="tb-info-total-color">원</span></td>
                                    </tr>
                                </table>
                            </div>

                            <ul class="text-list">
                                <li class="text-item">할인쿠폰은 판매가 기준으로 할인율 적용됩니다.</li>
                            </ul>
                            <ul class="common-btn-box common-btn-box--layer">
                                <li class="common-btn-item"><a href="javascript://" onClick="jsReset(<?=$idx?>,'CPN');" class="btn-gray-link" >적용취소</a></li>
                                <li class="common-btn-item"><a href="javascript://" onClick="Coupon_apply(<?=$idx?>);" class="btn-black-link">쿠폰적용</a></li>
                            </ul>
                            <!-- // common-layer-button -->
                        </div>
                        <!-- // common-layer-content -->

                        <a href="#" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>
                    </div>

                    <!-- // 쿠폰적용하기 레이어 -->

                    <div class="common-layer-wrap cart-delivery-layer" id="cartDeliveryLayer<?=$idx?>">
                        <!-- common-layer-wrap--view 추가 -->
                        <h3 class="common-layer-title">지역별 추가 배송비 확인</h3>
                        <div class="common-layer-content">
                            <div class="basic-table-wrap">
                                <table class="basic-table">
                                    <colgroup>
                                        <col style="width:40%;">
                                        <col style="width:60%;">
                                    </colgroup>
                                    <tr>
                                        <th scope="row" class="tb-info-title">상품정보</th>
                                        <td class="tb-info-txt"><?=$row['BRAND_NM']?><br> <?=$row['GOODS_NM']?><br> <?=$row['GOODS_OPTION_NM']?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="tb-info-title">지역별 추가 배송비</th>
                                        <td class="tb-info-txt">제주도 및 도서산간지역<br>추가 운임 발생 가능<br>(수도권 외 지역 추가운임은 상품페이지 내 설명 참조)</td>
                                    </tr>
                                </table>
                            </div>
                            <ul class="text-list">
                                <li class="text-item">상품별로 배송비 및 추가배송비가 다르게 적용됩니다.</li>
                                <li class="text-item">택배사를 통해 배송되는 상품의 경우, 지역별 추가운임을 상품 페이지 내 설명에서 꼭 확인해주십시오.</li>
                                <li class="text-item">업체직접배송 또는 설치배송 상품의 경우, 사전에 고객님께 연락을 하고 배송 및 설치를 진행하는 과정에서 추가배송비를 확인하실 수 있으며, 일정 기간 내 연락 부재 시 1:1문의 또는 고객센터로 문의하여 주십시오.</li>
                            </ul>

                            <a href="#" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>
                        </div>
                    </div>
                    <? $idx++;
                }
            }
        }?>
        <!-- // 지역별 추가배송비 확인 레이어 -->

        <!-- 사다리차 추가비용 안내 레이어 // -->
        <div class="common-layer-wrap layer-order-add-info" id="layerOrderAddInfo">
            <h3 class="common-layer-title">사다리차 추가비용 안내</h3>

            <!-- common-layer-content // -->
            <div class="common-layer-content ">
                <div class="notice-section">
                    <h4 class="notice-section-title"><span class="ico-i">i</span>사다리차 추가비용 안내</h4>
                    <ul class="text-list">
                        <li class="text-item">설치 당일. 설치현장의 특수성으로 인하여 추가적으로 발생하는 비용은 고객님 부담입니다. (양중비용, 엘리베이터 사용료, 사다리차, 지계차 사용료, 배송차량 주차료 등)</li>
                        <li class="text-item">사다리차를 이용하셔야 하는 경우(사다리차는 기본적으로 고객님이별도 요청하셔야 합니다. (8인이상 탑승가능한 엘리베이터가 없는 경우 3층부터 사용. 계단이 좁거나(2m이하), 가구가 들어가지 않는경우)</li>
                        <li class="text-item">소파 및 침대와 같은 대물 가구인 경우, 8인승 엘리베이터여도 사다리차가 필요할 수 있습니다.</li>
                        <li class="text-item">사다리차 사용을 하지 않고, 기사님과 같이 가구를 옮기는 것은 불가합니다.</li>
                        <li class="text-item">사다리차 필요 여건임에도 건물 특성상 사다리차 사용이 불가할 경우 양중비용 진행되어 비용이 발생합니다.</li>
                        <li class="text-item">사다리차 비용 거부시 배송 불가하며, 발생 반품비용은 고객부담입니다.</li>
                    </ul>
                </div>
                <div class="notice-section notice-section--margin">
                    <h4 class="notice-section-title"><span class="ico-i">i</span>배송일정 정보</h4>
                    <ul class="text-list">
                        <li class="text-item">고객께서 원하시는 시점에 상품을 배송하기 위해 에타는 최선의 노력을 다하겠습니다. 다만 주문제작 등 상품 준비 상황에 따라 배송이 약간 늦어질 수 있는 점 양해하여 주십시오.</li>
                        <li class="text-item">궁금하신 상황이 있으시면 저희에게 문의하여 주십시오.</li>
                    </ul>
                </div>
            </div>
            <!-- // common-layer-content -->

            <a href="#" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>
        </div>
        <!-- // 사다리차 추가비용 안내 레이어 -->
    </div>
<? }else{ ?>
    <!-- 딤 프로그래스바 -->
    <div id="dim" class="dim-progress active"><!-- active 클래스 추가 시 활성화 -->
        <div class="dimd"></div>
        <div class="icon-progress">
            <img src="/assets/images/sprite/progressbar.gif" alt="">
            <p>결제 진행중입니다</p>
        </div>
    </div>
<? }?>

<!-- // KCP 모바일 결제용 form -->
<form name="order_info" id="order_info" method="post">
    <input type="hidden" name="ordr_idxx" class="w200" value="">
    <input type="hidden" name="good_name" class="w100" value="<?=$goods_name ?>">
    <input type="hidden" name="good_mny" class="w100" value="<?=$total_goods_price - $total_discount_price + $total_delivery_price?>">
    <input type="hidden" name="buyr_name" class="w100" value="">
    <input type="hidden" name="buyr_mail" class="w200" value="">
    <input type="hidden" name="buyr_tel1" class="w100" value="">
    <input type="hidden" name="buyr_tel2" class="w100" value="">
    <!-- 에스크로 정보 필드 (에스크로 신청 가맹점은 필수로 값 세팅)-->
    <input type="hidden" name="rcvr_name" class="w100" value="">
    <input type="hidden" name="rcvr_tel1" class="w100" value="">
    <input type="hidden" name="rcvr_tel2" class="w100" value="">
    <input type="hidden" name="rcvr_mail" class="w200" value="">
    <input type="hidden" name="rcvr_zipx" class="w100" value="">
    <input type="hidden" name="rcvr_add1" class="w300" value="">
    <input type="hidden" name="rcvr_add2" class="w300" value="">

    <!-- <input name="" type="button" class="submit" value="결제요청" onclick="kcp_AJAX();"> -->

    <!-- 공통정보 -->
    <input type="hidden" name="req_tx"          value="pay">                           <!-- 요청 구분 -->
    <input type="hidden" name="shop_name"       value="<?= $g_conf_site_name ?>">      <!-- 사이트 이름 -->
    <input type="hidden" name="site_cd"         value="<?= $g_conf_site_cd   ?>">      <!-- 사이트 코드 -->
    <input type="hidden" name="currency"        value="410"/>                          <!-- 통화 코드 -->
    <!-- 결제등록 키 -->
    <input type="hidden" name="approval_key"    id="approval">
    <!-- 인증시 필요한 파라미터(변경불가)-->
    <input type="hidden" name="pay_method"      value="CARD">
    <input type="hidden" name="van_code"        value="">
    <!-- 신용카드 설정 -->
    <input type="hidden" name="quotaopt"        value="12"/>                           <!-- 최대 할부개월수 -->
    <!-- 가상계좌 설정 -->
    <input type="hidden" name="ipgm_date"       value=""/>
    <!-- 리턴 URL (kcp와 통신후 결제를 요청할 수 있는 암호화 데이터를 전송 받을 가맹점의 주문페이지 URL) -->
    <input type="hidden" name="Ret_URL"         value="<?=$url?>">
    <!-- 화면 크기조정 -->
    <input type="hidden" name="tablet_size"     value="<?=$tablet_size?>">

    <!-- 추가 파라미터 ( 가맹점에서 별도의 값전달시 param_opt 를 사용하여 값 전달 ) -->
    <input type="hidden" name="ActionResult"	  value="card" />
    <input type="hidden" name="param_opt_1"     value="">
    <input type="hidden" name="param_opt_2"     value="">
    <input type="hidden" name="param_opt_3"     value="">
    <input type="hidden" name="encoding_trans" value="UTF-8" />
    <input type="hidden" name="PayUrl"   id="PayUrl"   value=""/>

    <!-- ARS 결제 추가 파라미터 -->
    <input type="hidden" name="phon_mny" value="<?=$total_goods_price - $total_discount_price + $total_delivery_price?>" />
    <input type="hidden" name="phon_no" value="">
    <input type="hidden" name="comm_id" value="">
    <input type="hidden" name="expr_dt" value="">
    <input type="hidden" name="cert_flg" value ="">

    <?
    /* ============================================================================== */
    /* =   에스크로결제 사용시 필수 정보                                            = */
    /* = -------------------------------------------------------------------------- = */
    /* =   결제에 필요한 주문 정보를 입력 및 설정합니다.                            = */
    /* = -------------------------------------------------------------------------- = */
    ?>
    <!-- 에스크로 사용유무 에스크로 사용 업체(가상계좌, 계좌이체 해당)는 escw_used 를 Y로 세팅 해주시기 바랍니다.-->
    <input type="hidden" name="escw_used" value="Y">
    <!-- 장바구니 상품 개수 -->
    <input type='hidden' name='bask_cntx' value="<?=$ascw_good_cnt?>">
    <!-- 장바구니 정보(상단 스크립트 참조) -->
    <input type='hidden' name='good_info' value="<?=$ascw_good_info?>">
    <!-- 에스크로 결제처리모드 KCP 설정된 금액 결제(사용 : 설정된금액적용: 사용안함: -->
    <input type="hidden" name='pay_mod'   value="N">
    <!-- 배송소요기간 -->
    <input type="hidden" name='deli_term' value='03'>

    <?
    /* = -------------------------------------------------------------------------- = */
    /* =   에스크로결제 사용시 필수 정보  END                                       = */
    /* ============================================================================== */
    ?>
    <?
    /* ============================================================================== */
    /* =   옵션 정보                                                                = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ※ 옵션 - 결제에 필요한 추가 옵션 정보를 입력 및 설정합니다.             = */
    /* = -------------------------------------------------------------------------- = */
    /* 카드사 리스트 설정
    예) 비씨카드와 신한카드 사용 설정시
    <input type="hidden" name='used_card'    value="CCBC:CCLG">

    /*  무이자 옵션
            ※ 설정할부    (가맹점 관리자 페이지에 설정 된 무이자 설정을 따른다)                             - "" 로 설정
            ※ 일반할부    (KCP 이벤트 이외에 설정 된 모든 무이자 설정을 무시한다)                           - "N" 로 설정
            ※ 무이자 할부 (가맹점 관리자 페이지에 설정 된 무이자 이벤트 중 원하는 무이자 설정을 세팅한다)   - "Y" 로 설정
    <input type="hidden" name="kcp_noint"       value=""/> */

    /*  무이자 설정
            ※ 주의 1 : 할부는 결제금액이 50,000 원 이상일 경우에만 가능
            ※ 주의 2 : 무이자 설정값은 무이자 옵션이 Y일 경우에만 결제 창에 적용
            예) 전 카드 2,3,6개월 무이자(국민,비씨,엘지,삼성,신한,현대,롯데,외환) : ALL-02:03:04
            BC 2,3,6개월, 국민 3,6개월, 삼성 6,9개월 무이자 : CCBC-02:03:06,CCKM-03:06,CCSS-03:06:04
    <input type="hidden" name="kcp_noint_quota" value="CCBC-02:03:06,CCKM-03:06,CCSS-03:06:09"/> */

    /* KCP는 과세상품과 비과세상품을 동시에 판매하는 업체들의 결제관리에 대한 편의성을 제공해드리고자,
       복합과세 전용 사이트코드를 지원해 드리며 총 금액에 대해 복합과세 처리가 가능하도록 제공하고 있습니다
       복합과세 전용 사이트 코드로 계약하신 가맹점에만 해당이 됩니다
       상품별이 아니라 금액으로 구분하여 요청하셔야 합니다
       총결제 금액은 과세금액 + 부과세 + 비과세금액의 합과 같아야 합니다.
       (good_mny = comm_tax_mny + comm_vat_mny + comm_free_mny)

        <input type="hidden" name="tax_flag"       value="TG03">  <!-- 변경불가	   -->
        <input type="hidden" name="comm_tax_mny"   value=""    >  <!-- 과세금액	   -->
        <input type="hidden" name="comm_vat_mny"   value=""    >  <!-- 부가세	   -->
        <input type="hidden" name="comm_free_mny"  value=""    >  <!-- 비과세 금액 --> */

    /* 결제창 한국어/영어 설정 옵션 (Y : 영어)
        <input type="hidden" name="eng_flag"        value="Y"/> */

    /* 가맹점에서 관리하는 고객 아이디 설정을 해야 합니다. 상품권 결제 시 반드시 입력하시기 바랍니다.
        <input type="hidden" name="shop_user_id"    value=""/> */

    /* 복지포인트 결제시 가맹점에 할당되어진 코드 값을 입력해야합니다.
        <input type="hidden" name="pt_memcorp_cd"   value=""/> */

    /* 결제창 현금영수증 노출 설정 옵션 (Y : 노출)
        <input type="hidden" name="disp_tax_yn"     value="Y"/> */
    /* = -------------------------------------------------------------------------- = */
    /* =   옵션 정보 END                                                            = */
    /* ============================================================================== */
    ?>

</form>
<form name="pay_form" method="post" action="/order/kcpCli">
    <input type="hidden" name="req_tx"         value="<?=$req_tx?>">               <!-- 요청 구분          -->
    <input type="hidden" name="res_cd"         value="<?=$res_cd?>">               <!-- 결과 코드          -->
    <input type="hidden" name="tran_cd"        value="<?=$tran_cd?>">              <!-- 트랜잭션 코드      -->
    <input type="hidden" name="ordr_idxx"      value="<?=$ordr_idxx?>">            <!-- 주문번호           -->
    <input type="hidden" name="good_mny"       value="<?=$good_mny?>">             <!-- 휴대폰 결제금액    -->
    <input type="hidden" name="good_name"      value="<?=$good_name?>">            <!-- 상품명             -->
    <input type="hidden" name="buyr_name"      value="<?=$buyr_name?>">            <!-- 주문자명           -->
    <input type="hidden" name="buyr_tel1"      value="<?=$buyr_tel1?>">            <!-- 주문자 전화번호    -->
    <input type="hidden" name="buyr_tel2"      value="<?=$buyr_tel2?>">            <!-- 주문자 휴대폰번호  -->
    <input type="hidden" name="buyr_mail"      value="<?=$buyr_mail?>">            <!-- 주문자 E-mail      -->
    <input type="hidden" name="cash_yn"		   value="<?=$cash_yn?>">              <!-- 현금영수증 등록여부-->
    <input type="hidden" name="enc_info"       value="<?=$enc_info?>">
    <input type="hidden" name="enc_data"       value="<?=$enc_data?>">
    <input type="hidden" name="use_pay_method" value="<?=$use_pay_method?>">
    <input type="hidden" name="cash_tr_code"   value="<?=$cash_tr_code?>">

    <!-- 추가 파라미터 -->
    <input type="hidden" name="param_opt_1"	   value="<?=$param_opt_1?>">
    <input type="hidden" name="param_opt_2"	   value="<?=$param_opt_2?>">
    <input type="hidden" name="param_opt_3"	   value="<?=$param_opt_3?>">
</form>

<script src="/assets/js2/cart_coupon.js"></script>
<script type="text/javascript">

    $(document).ready(function(){
        //google_gtag

        var cartDataCnt		= "<?=$idx?>";
        var cartItemsArray  = new Array();
        var cartItems		= new Object();

        for (var a=0; a<cartDataCnt; a++)
        {
            var cartItems	= new Object();

            var brand  = '['+document.getElementsByName("brand_code[]")[a].value + ']'+document.getElementsByName("brand_name[]")[a].value;
            var option = '['+document.getElementsByName("goods_option_code[]")[a].value+']'+document.getElementsByName("goods_option_name[]")[a].value;

            cartItems.id	= document.getElementsByName("goods_code[]")[a].value;
            cartItems.name	= document.getElementsByName("goods_name[]")[a].value;
            cartItems.list_name	= "CheckOut list";
            cartItems.brand	= brand;
            cartItems.variant	= option;
            cartItems.quantity	= document.getElementsByName("goods_cnt[]")[a].value;
            cartItems.price	= document.getElementsByName("goods_selling_price[]")[a].value;

            cartItemsArray.push(cartItems);
        }

        console.log(cartItemsArray);
        gtag('event', 'begin_checkout', {
            "items": cartItemsArray,
            "coupon": ""
        });
    });
    /******************************************************/
    /** 쿠폰 관련 함수는 /assets/js2/cart_coupon.js 참고 **/
    /******************************************************/

    var cart_cnt = "<?=$idx?>";
    $('span[name=check_count]').text(cart_cnt);

    /*****************/
    /** 천단위 콤마 **/
    /*****************/
    function numberFormat(num) {
        num = String(num);
        return num.replace(/(\d)(?=(?:\d{3})+(?!\d))/g,"$1,");
    }

    /**********************/
    /** 천단위 콤마 제거 **/
    /**********************/
    function renumberFormat(num){
        return num.replace(/^\$|,/g, "") + ""
    }

    /**********************/
    /**** 숫자만 입력 *****/
    /**********************/
    function OnlyNumber(){
        if((event.keyCode<48)||(event.keyCode>57)){
            event.returnValue=false;
        }
    }

    /**************************/
    /**** 콤보박스 초기화 *****/
    /**************************/
    function initCombo(pObj, pTitle)
    {
        for (var i = document.getElementById(pObj).length; i >=0; i-- ){
            document.getElementById(pObj)[i] = null;
        }

        var option 		= document.createElement("option");
        option.value 	= "";
        option.text 	= pTitle;
        document.getElementById(pObj).appendChild(option);
        document.getElementById(pObj).value = "";
    }

    /*********************************/
    /***** 가격 재계산 ***************/
    /*********************************/
    var total_sum_price = function()
    {
        var total_delivery_price		= parseInt($('input[name=total_delivery_money]').val());	//전체 배송비(기본+추가)
        var total_goods_selling_price	= 0;	//기존 상품금액 합
        var total_goods_discount_price	= 0;	//기존 상품할인금액 합
        var total_goods_add_discount_price = 0; //기존 상품추가할인금액 합
        var use_mileage					= parseInt($("input[name=use_mileage]").val());
        var cart_coupon_price			= parseInt($("input[name=cart_coupon_amt]").val());
        var brand_price                 = parseInt(renumberFormat($("input[name=brand_price]").val()));     //브랜드할인(셀러쿠폰)

        for(i=0; i<document.getElementsByName("goods_code[]").length; i++){
            total_goods_selling_price += (parseInt($($("input[name='goods_selling_price[]']").get(i)).val())+parseInt($($("input[name='goods_option_add_price[]']").get(i)).val()))*parseInt($($("input[name='goods_cnt[]']").get(i)).val());		//기존 상품금액 합

            total_goods_discount_price += parseInt($($("input[name='goods_discount_price[]']").get(i)).val())*parseInt($($("input[name='goods_cnt[]']").get(i)).val());		//기존 상품할인금액 합

            total_goods_add_discount_price += parseInt($($("input[name='goods_add_discount_price[]']").get(i)).val());	//기존 상품추가할인금액 합
        }

        //히든값 변경
        $('input[name=total_order_money]').val(total_goods_selling_price);
        $('input[name=total_discount_money]').val(total_goods_discount_price + total_goods_add_discount_price + cart_coupon_price);
        $('input[name=total_payment_money]').val(total_goods_selling_price - total_goods_discount_price - total_goods_add_discount_price - cart_coupon_price - use_mileage + total_delivery_price);
        $('input[name=phon_mny]').val(total_goods_selling_price - total_goods_discount_price - total_goods_add_discount_price - cart_coupon_price - use_mileage + total_delivery_price);


        //보이는 정보 변경
//	$('span[name=payment_price]').text(numberFormat(total_goods_selling_price - total_goods_discount_price - total_goods_add_discount_price - cart_coupon_price - use_mileage + total_delivery_price));		//결제예정금액(상단)
        $('span[name=discount_price]').text(numberFormat(total_goods_discount_price + total_goods_add_discount_price + cart_coupon_price));	//최종 할인금액 (상단)

        $('span[name=payment_price]').text(numberFormat(total_goods_selling_price - total_goods_discount_price - total_goods_add_discount_price - cart_coupon_price + total_delivery_price));		//결제예정금액(상단)

        $('input[name=discount_price]').val(numberFormat(total_goods_discount_price + total_goods_add_discount_price + cart_coupon_price - brand_price));		//에타할인(하단)

        $('span[name=finally_discount_price]').text(numberFormat(total_goods_discount_price + total_goods_add_discount_price + cart_coupon_price + use_mileage));		//최종 할인금액 (하단)

        $('span[name=finally_payment_mileage]').text(numberFormat(use_mileage));		//사용 마일리지

        $('span[name=finally_payment_price]').text(numberFormat(total_goods_selling_price - total_goods_discount_price - total_goods_add_discount_price - cart_coupon_price - use_mileage + total_delivery_price));		//결제예정금액(하단)
        document.order_info.good_mny.value = total_goods_selling_price - total_goods_discount_price - total_goods_add_discount_price - cart_coupon_price - use_mileage + total_delivery_price;
    }

    /*******************/
    /** 레이어 초기화 **/
    /*******************/
    function jsReset(idx,gb){
        if(gb == 'OPT'){
            $($("span[name='chk_option_name[]']").get(idx)).text(document.getElementsByName("goods_option_name[]")[idx].value);
//		alert(document.getElementsByName("moption1[]")[idx].value);
            document.getElementsByName("moption1[]")[idx].value = document.getElementsByName("goods_option_code[]")[idx].value+"||"+document.getElementsByName("goods_option_add_price[]")[idx].value+"||"+document.getElementsByName("goods_option_qty[]")[idx].value;
//		alert(document.getElementsByName("goods_option_code[]")[idx].value+"||"+document.getElementsByName("goods_option_add_price[]")[idx].value+"||"+document.getElementsByName("goods_option_qty[]")[idx].value);
            document.getElementsByName("option_cnt[]")[idx].value = document.getElementsByName("goods_cnt[]")[idx].value;
            $("input[name=dup_option]").val('N');
            $($("span[name='duplicate_option[]']").get(idx)).html('');
            document.getElementsByName("total_option_price[]")[idx].innerText = numberFormat((parseInt(document.getElementsByName("goods_selling_price[]")[idx].value) + parseInt(document.getElementsByName("goods_option_add_price[]")[idx].value)) * parseInt(document.getElementsByName("goods_cnt[]")[idx].value));

            $("#layer__cart_03_"+idx).attr('class','layer layer__cart_03');	//레이어 닫기
        } else if(gb == 'CPN'){
            var total_coupon_price	= parseInt(document.getElementsByName("goods_discount_price[]")[idx].value)*parseInt($($("input[name='goods_cnt[]']").get(idx)).val());
            var item_coupon_max		= parseInt(0);
            var item_coupon_amt		= parseInt(0);
            var item_coupon_checked_id	= '';
            var item_coupon_checked_tid = '';
            var item_coupon_checked_name = '';
            var cust_coupon_max		= parseInt(0);
            var cust_coupon_amt		= parseInt(0);

            for(var i=0; i<cart_cnt; i++){		//체크한 쿠폰 원래대로
                if(i == idx){
                    var goods_cnt	= parseInt($($("input[name='goods_cnt[]']").get(idx)).val());	//상품갯수

                    if($($("input[name='item_coupon_cnt[]']").get(idx)).val() > 0){	//아이템쿠폰이 하나라도 있을경우 체크재점검
                        for(k=0; k<document.getElementsByName("coupon_select_E"+i).length; k++){
                            document.getElementsByName("coupon_select_E"+i)[k].checked = false;
                        }
//===2016-10-06 중복불가쿠폰은 에타할인으로
                        for(var j=0; j<$($("input[name='item_coupon_cnt[]']").get(i)).val(); j++){
                            if($($("input[name='goods_coupon_code_i[]']").get(idx)).val() == $("#coupon_E"+i+"_"+j).val().split("||")[0]){
                                $("#coupon_E"+i+"_"+j).prop('checked', true);
                                $("#coupon_E"+i+"_"+j).prop('disabled', false);
                                $("#coupon_name_E"+i+"_"+j).html($("#coupon_E"+i+"_"+j).val().split("||")[1]);

                                item_coupon_max	= parseInt($("#coupon_E"+i+"_"+j).val().split("||")[3]);
                                item_coupon_amt	= parseInt($("#coupon_E"+i+"_"+j).val().split("||")[2]);
                                item_coupon_kind	= parseInt($("#coupon_E"+i+"_"+j).val().split("||")[4]);

                                if(item_coupon_kind	== 'COUPON_B'){
                                    if( item_coupon_max < (item_coupon_amt*goods_cnt) && item_coupon_max != 0){
                                        item_coupon_amt = item_coupon_max;
                                    } else {
                                        item_coupon_amt = item_coupon_amt*goods_cnt;
                                    }
                                } else {
                                    if( item_coupon_max < (item_coupon_amt) && item_coupon_max != 0){
                                        item_coupon_amt = item_coupon_max*goods_cnt;
                                    } else {
                                        item_coupon_amt = item_coupon_amt*goods_cnt;
                                    }

                                }
                                $("span[name=coupon_E_text"+i+"]").text(numberFormat(item_coupon_amt));

                                $("#dup_coupon_"+idx).show();
                                break;
                            } else if($($("input[name='goods_coupon_code_i[]']").get(idx)).val() == ""){	//아이템쿠폰 사용안함
                                if($($("input[name='goods_add_coupon_code[]']").get(idx)).val() == ''){	//고객쿠폰쪽도 비어있을경우
                                    $("input[name='coupon_select_E"+idx+"']:input[value='']").prop('checked', true);
//								$("#coupon_E"+i+"_"+j).prop('disabled', false);
//								$("#coupon_name_E"+i+"_"+j).html($("#coupon_E"+i+"_"+j).val().split("||")[1]);
                                    $("span[name=coupon_E_text"+i+"]").text(0);

                                    $("#dup_coupon_"+idx).show();
                                    break;
                                } else {	//고객쿠폰이 있음
//								alert("aa");
//								alert($($("input[name='goods_add_coupon_code[]']").get(idx)).val());
//								alert($("#coupon_E"+i+"_"+j).val().split("||")[0]);
                                    if($($("input[name='goods_add_coupon_code[]']").get(idx)).val() == $("#coupon_E"+i+"_"+j).val().split("||")[0]){
//									alert("bb");
                                        $("#coupon_E"+i+"_"+j).prop('checked', true);
                                        $("#coupon_E"+i+"_"+j).prop('disabled', false);
                                        $("#coupon_name_E"+i+"_"+j).html($("#coupon_E"+i+"_"+j).val().split("||")[1]);

                                        item_coupon_max	= parseInt($("#coupon_E"+i+"_"+j).val().split("||")[3]);
                                        item_coupon_amt	= parseInt($("#coupon_E"+i+"_"+j).val().split("||")[2]);
                                        if( item_coupon_max < (item_coupon_amt*goods_cnt) && item_coupon_max != 0){
                                            item_coupon_amt = item_coupon_max;
                                        } else {
                                            item_coupon_amt = item_coupon_amt*goods_cnt;
                                        }
                                        $("span[name=coupon_E_text"+i+"]").text(numberFormat(item_coupon_amt));

                                        total_coupon_price += item_coupon_amt;

                                        $("#dup_coupon_"+idx).hide();
                                        break;
                                    } else if(j==$($("input[name='item_coupon_cnt[]']").get(i)).val()-1) {	//아이템쿠폰의 고객쿠폰은 아님
                                        $("input[name='coupon_select_E"+idx+"']:input[value='']").prop('checked', true);
//									$("#coupon_E"+i+"_"+j).prop('disabled', false);
//									$("#coupon_name_E"+i+"_"+j).html($("#coupon_E"+i+"_"+j).val().split("||")[1]);
                                        $("span[name=coupon_E_text"+i+"]").text(0);

                                        $("#dup_coupon_"+idx).show();
                                        break;
                                    }
                                }
                            }
                        }

                    }

                    if($($("input[name='add_coupon_cnt[]']").get(idx)).val() > 0){	//에타중복쿠폰 하나라도 있을경우 체크재점검
                        for(k=0; k<document.getElementsByName("coupon_select_C"+i).length; k++){
                            document.getElementsByName("coupon_select_C"+i)[k].checked = false;
                        }

//===2016-10-06 중복불가쿠폰은 에타할인으로
                        for(var j=0; j<$($("input[name='add_coupon_cnt[]']").get(i)).val(); j++){
                            if($($("input[name='goods_add_coupon_code[]']").get(idx)).val() == $("#coupon_C"+i+"_"+j).val().split("||")[0]){
                                $("#coupon_C"+i+"_"+j).prop('checked', true);
                                cust_coupon_max	= parseInt($("#coupon_C"+i+"_"+j).val().split("||")[3]);
                                cust_coupon_amt	= parseInt($("#coupon_C"+i+"_"+j).val().split("||")[2]);
                                if( cust_coupon_max < (cust_coupon_amt*goods_cnt) && cust_coupon_max != 0){
//                                cust_coupon_amt = cust_coupon_max*goods_cnt;
                                    cust_coupon_amt = cust_coupon_amt;
                                } else {
                                    cust_coupon_amt = cust_coupon_amt*goods_cnt;
                                }
                                total_coupon_price += cust_coupon_amt;

                                break;
                            } else if($($("input[name='goods_add_coupon_code[]']").get(idx)).val() == ""){	//중복쿠폰사용x
                                $("input[name='coupon_select_C"+idx+"']:input[value='']").prop('checked', true);
                                break;
                            }
                        }	//END FOR

                        //장바구니 -> 결제 : 사용중인 쿠폰 체크
                        for(var j=0; j<$($("input[name='add_coupon_cnt[]']").get(i)).val(); j++) {
                            for (var a = 0; a < cart_cnt; a++) {
                                if( $($("input[name='goods_add_coupon_code[]']").get(a)).val() != '' ){
                                    if( $("#coupon_C" + i + "_" + j).val().split("||")[7] == 'CUST' ) { //구매자 고객쿠폰일때
                                        if( $($("input[name='goods_add_coupon_code[]']").get(a)).val() == $("#coupon_C" + i + "_" + j).val().split("||")[0] ) {
                                            if($("#coupon_C"+i+"_"+j).is(":checked")) {

                                            } else {
                                                $("#coupon_C"+i+"_"+j).prop('disabled', true);
                                                $("#coupon_name_C"+i+"_"+j).html("<s>"+$("#coupon_C"+i+"_"+j).val().split("||")[1]+"</s><font color=red> (사용중)</font>");
                                            }
                                        }
                                    }
                                }


                            }

                        }

                    }
                }	//END if
            }	//END for

            $("span[name='coupon_C_text"+idx+"']").text(numberFormat(cust_coupon_amt));	//할인액 재계산
            $("span[name='coupon_total_amt_"+idx+"']").text(numberFormat(total_coupon_price));		//총 재계산
//		$("#layer__cart_02_"+idx).attr('class','layer layer__cart_02');			//레이어 닫기
            $("div[id=cartCouponLayer"+idx+"]").removeClass();
            $("div[id=cartCouponLayer"+idx+"]").addClass('common-layer-wrap cart-coupon-layer');	//레이어 닫기
            $("#etah_html").removeClass();

        }	//END else if
    }	//END function

    /****************************************/
    /** 추가배송비 또는 배송 불가지역 재계산*/
    /****************************************/
    function jsDeliveryAmt(postnum){
        var total_add_delivery_price	= 0;	//추가배송비 합
        var total_delivery_price		= 0;	//기존배송비 합
        var total_goods_selling_price	= 0;	//기존 상품금액 합
        var total_goods_discount_price	= 0;	//기존 상품할인금액 합
        var total_goods_add_discount_price = 0; //기존 상품추가할인금액 합
        var use_mileage					= parseInt($("input[name=use_mileage]").val());
        var cart_coupon_price			= parseInt($("input[name=cart_coupon_amt]").val());
        var deliv_yn					= "Y";	//배송가능여부
        var group_text					= '';

        for(i=0; i<document.getElementsByName("group_deli_policy_no[]").length; i++){
            var group_deli_policy_no	= document.getElementsByName("group_deli_policy_no[]")[i].value;
            var add_price		= 0;			//지역에 따른 추가배송비

            $.ajax({
                type: 'POST',
                async: false,
                url: '/cart/get_add_delivery',
                dataType: 'json',
                data: { postnum : postnum, deli_policy_no : group_deli_policy_no },
                error: function(res) {
                    alert('Database Error');
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        add_price = res.add_delivery_price;
                    }
                    else{
                        alert(res.message);
                        deliv_yn = 'N';
                    }
                }
            })

            for(j=0; j<document.getElementsByName("goods_code[]").length; j++){
                if(document.getElementsByName("group_deli_policy_no[]")[i].value == document.getElementsByName("goods_deli_policy_no[]")[j].value){
                    if($($("input[name='goods_deli_policy_pattern_type[]']").get(j)).val() == 'NONE'){
                        add_price = 0;
                        break;
                    }
                }
            }

            $($("input[name='group_add_delivery_price[]']").get(i)).val(parseInt(add_price));
            total_add_delivery_price += parseInt($($("input[name='group_add_delivery_price[]']").get(i)).val());	//추가배송비 합
            total_delivery_price += parseInt($($("input[name='group_delivery_price[]']").get(i)).val());	//기존배송비 합

            if(parseInt(add_price) + parseInt($($("input[name='group_delivery_price[]']").get(i)).val()) != 0){
                $('p[name=delivery_price'+i+']').text(numberFormat(parseInt(add_price) + parseInt($($("input[name='group_delivery_price[]']").get(i)).val()))+"원");		//상품별 추가배송비 계산해서 다시 적용
            } else {
                if(document.getElementsByName("group_text[]")[i].value == 'Y'){
                    group_text = '(묶음)';
                } else {
                    group_text = '';
                }

                $('p[name=delivery_price'+i+']').text("무료배송 "+group_text);

                for(j=0; j<document.getElementsByName("goods_code[]").length; j++){
                    if(document.getElementsByName("group_deli_policy_no[]")[i].value == document.getElementsByName("goods_deli_policy_no[]")[j].value){
                        if($($("input[name='goods_deli_policy_pattern_type[]']").get(j)).val() == 'NONE'){
                            $('p[name=delivery_price'+i+']').text("착불배송");
                            break;
                        }
                    }
                }

            }
        }	//END for

//		for(i=0; i<document.getElementsByName("group_deli_policy_no[]").length; i++){
        for(i=0; i<document.getElementsByName("goods_code[]").length; i++){
            total_goods_selling_price += (parseInt($($("input[name='goods_selling_price[]']").get(i)).val())+parseInt($($("input[name='goods_option_add_price[]']").get(i)).val()))*parseInt($($("input[name='goods_cnt[]']").get(i)).val());		//기존 상품금액 합

            total_goods_discount_price += parseInt($($("input[name='goods_discount_price[]']").get(i)).val())*parseInt($($("input[name='goods_cnt[]']").get(i)).val());		//기존 상품할인금액 합

            total_goods_add_discount_price += parseInt($($("input[name='goods_add_discount_price[]']").get(i)).val());	//기존 상품추가할인금액 합
        }

        $('span[name=total_delivery_price]').text(numberFormat(total_delivery_price));		//총배송비
        $('span[name=delivery_info]').text(numberFormat(total_delivery_price));
        if(total_add_delivery_price != 0){
            $('span[name=total_add_delivery_price_1]').html(" + <span>"+numberFormat(total_add_delivery_price)+"</span><span class='won'>원(도서산간배송비)</span>");
            $('span[name=total_add_delivery_price_2]').html(" + <span>"+numberFormat(total_add_delivery_price)+"</span>원(도서산간배송비)");
        } else {
            $('span[name=total_add_delivery_price_1]').html("");
            $('span[name=total_add_delivery_price_2]').html("");
        }
        //히든값 변경
        $('input[name=total_order_money]').val(total_goods_selling_price);
        $('input[name=total_discount_money]').val(total_goods_discount_price + total_goods_add_discount_price + cart_coupon_price);
        $('input[name=total_delivery_money]').val(total_delivery_price + total_add_delivery_price);
        $('input[name=total_payment_money]').val(total_goods_selling_price - total_goods_discount_price - total_goods_add_discount_price - cart_coupon_price - use_mileage + total_delivery_price + total_add_delivery_price);

        $('span[name=payment_price]').text(numberFormat(total_goods_selling_price - total_goods_discount_price - total_goods_add_discount_price - cart_coupon_price - use_mileage + total_delivery_price + total_add_delivery_price));		//결제예정금액

        $('span[name=finally_payment_price]').text(numberFormat(total_goods_selling_price - total_goods_discount_price - total_goods_add_discount_price - cart_coupon_price - use_mileage + total_delivery_price + total_add_delivery_price));		//결제예정금액

        if(deliv_yn == 'N'){	//배송불가지역이라면
            $('span[name=no_deliv_text]').text("해당 지역에 배송이 불가능한 상품이 있습니다.");
            $('input[name=deliv_yn]').val("N");
        } else {
            $('span[name=no_deliv_text]').text("");
            $('input[name=deliv_yn]').val("Y");
        }
    }

    /****************************************/
    /********* 주소 클릭시 붙여넣기 *********/
    /****************************************/
    function jsPastepost(gubun, idx){

        if(gubun == '1'){	//지번주소
            $('input[name=order_postnum_text]').val($($("input[name='addr_post1[]']").get(idx)).val());
            $('input[name=order_addr1_text]').val($($("input[name='addr_v1[]']").get(idx)).val());
            $('input[name=order_addr1]').val($($("input[name='addr_v1[]']").get(idx)).val());

            var postnum = $($("input[name='addr_post1[]']").get(idx)).val();

            if($($("input[name='addr_post1[]']").get(idx)).val().length == '7'){	//우편번호 6자리일경우 '-'표시 제거
                postnum = $($("input[name='addr_post1[]']").get(idx)).val().split("-")[0] + $($("input[name='addr_post1[]']").get(idx)).val().split("-")[1];
            }

            $('input[name=order_postnum]').val(postnum);	//우편번호 히든값 넣기

            jsDeliveryAmt(postnum);

            //레이어 닫기
            $('#postcodeSearchLayer').removeClass();
            $('#postcodeSearchLayer').addClass('common-layer-wrap postcode-search-layer');
            $('#addressBookLayer').removeClass();
            $('#addressBookLayer').addClass('common-layer-wrap address-book-layer');
            $("#etah_html").removeClass();

        } else if(gubun == '2'){	//도로명주소
            $('input[name=order_postnum_text]').val($($("input[name='addr_post2[]']").get(idx)).val());
            $('input[name=order_addr1_text]').val($($("input[name='addr_v2[]']").get(idx)).val());
            $('input[name=order_addr1]').val($($("input[name='addr_v2[]']").get(idx)).val());

            var postnum = $($("input[name='addr_post2[]']").get(idx)).val();

            if($($("input[name='addr_post2[]']").get(idx)).val().length == '7'){	//우편번호 6자리일경우 '-'표시 제거
                postnum = $($("input[name='addr_post2[]']").get(idx)).val().split("-")[0] + $($("input[name='addr_post2[]']").get(idx)).val().split("-")[1];
            }

            $('input[name=order_postnum]').val(postnum);	//우편번호 히든값 넣기

            jsDeliveryAmt(postnum);

            //레이어 닫기
            $('#postcodeSearchLayer').removeClass();
            $('#postcodeSearchLayer').addClass('common-layer-wrap postcode-search-layer');
            $('#addressBookLayer').removeClass();
            $('#addressBookLayer').addClass('common-layer-wrap address-book-layer');
            $("#etah_html").removeClass();
        }

    }

    /****************************************/
    /*************** 주소사용 ***************/
    /****************************************/
    function jsUseaddr(gb){
        if(gb == 'C'){	//주소록 적용
            var idx = $(':input:radio[name=address_book]:checked').val();

            $('input[name=order_postnum_text]').val($($("input[name='cust_zipcode[]']").get(idx)).val());
            $('input[name=order_addr1_text]').val($($("input[name='cust_addr1[]']").get(idx)).val());
            $('input[name=order_addr1]').val($($("input[name='cust_addr1[]']").get(idx)).val());
            $('input[name=order_addr2]').val($($("input[name='cust_addr2[]']").get(idx)).val());

            var postnum = $($("input[name='cust_zipcode[]']").get(idx)).val();

            if($($("input[name='cust_zipcode[]']").get(idx)).val().length == '7'){	//우편번호 6자리일경우 '-'표시 제거
                postnum = $($("input[name='cust_zipcode[]']").get(idx)).val().split("-")[0] + $($("input[name='cust_zipcode[]']").get(idx)).val().split("-")[1];
            }

            $('input[name=order_postnum]').val(postnum);	//우편번호 히든값 넣기
        }

        jsDeliveryAmt(postnum);		//추가배송비 또는 배송불가지역 재계산

        $('#addressBookLayer').removeClass();
        $('#addressBookLayer').addClass('common-layer-wrap address-book-layer');
        $("#etah_html").removeClass();
    }


    //===============================================================
    // 배송지 초기화
    //===============================================================
    function jsAddrReset(gb){
        var receive_name	= "<?=$RECEIVER_NM?>";
        var receive_zipcode	= "<?=$RECEIVER_ZIPCODE?>";
        var receive_zipcode_text = "<?=$RECEIVER_ZIPCODE?>";

        if(receive_zipcode.length == 6){
            var receive_zipcode_text = receive_zipcode.substr(0,3)+"-"+receive_zipcode.substr(3,3);
        }

        var receive_addr1	= "<?=$RECEIVER_ADDR1?>";
        var receive_addr2	= "<?=$RECEIVER_ADDR2?>";
        var receive_phone	= "<?=$RECEIVER_PHONE_NO?>";
        var receive_phone_1 = receive_phone.split("-")[0];
        var receive_phone_2 = receive_phone.split("-")[1];
        var receive_phone_3 = receive_phone.split("-")[2];
        var receive_mob		= "<?=$RECEIVER_MOB_NO?>";
        var receive_mob_1 = receive_mob.split("-")[0];
        var receive_mob_2 = receive_mob.split("-")[1];
        var receive_mob_3 = receive_mob.split("-")[2];

        if(gb == 'A'){	//최근 배송지
            $("input[name=order_recipient]").val(receive_name);		//받으시는분
            $("input[name=order_postnum_text]").val(receive_zipcode_text);	//우편번호
            $("input[name=order_postnum]").val(receive_zipcode);	//우편번호(값초기화)
            $("input[name=order_addr1_text]").val(receive_addr1);	//기본주소
            $("input[name=order_addr1]").val(receive_addr1);		//기본주소(값초기화)
            $("input[name=order_addr2]").val(receive_addr2);		//상세주소
            $("select[name=order_mobile1]").val(receive_mob_1);		//핸드폰번호
            $("input[name=order_mobile2]").val(receive_mob_2);
            $("input[name=order_mobile3]").val(receive_mob_3);
            $("select[name=order_phone1]").val(receive_phone_1);		//전화번호
            $("input[name=order_phone2]").val(receive_phone_2);
            $("input[name=order_phone3]").val(receive_phone_3);
            $("input[name=order_requst]").val('');			//요청사항

            jsDeliveryAmt(receive_zipcode);
        } else if (gb == 'B'){	//새로운 배송지
            $("input[name=order_recipient]").val('');		//받으시는분
            $("input[name=order_postnum_text]").val('');	//우편번호
            $("input[name=order_postnum]").val('');			//우편번호(값초기화)
            $("input[name=order_addr1_text]").val('');		//기본주소
            $("input[name=order_addr1]").val('');			//기본주소(값초기화)
            $("input[name=order_addr2]").val('');			//상세주소
            $("select[name=order_mobile1]").val('');		//핸드폰번호
            $("input[name=order_mobile2]").val('');
            $("input[name=order_mobile3]").val('');
            $("select[name=order_phone1]").val('');			//전화번호
            $("input[name=order_phone2]").val('');
            $("input[name=order_phone3]").val('');
            $("input[name=order_requst]").val('');			//요청사항

            $('span[name=no_deliv_text]').text("");
            $('input[name=deliv_yn]').val("Y");
        }
    }

    //===============================================================
    // 마일리지 모두 사용
    //===============================================================
    function jsAllUsemileage(chk_val){
        if(chk_val == true){	//모두사용
            var cust_mileage = parseInt("<?=$mileage?>");
//            var use_mileage  = Math.floor(cust_mileage/1000)*1000;
//            $("#formDcMileage").val(use_mileage);
            if(parseInt(cust_mileage) > $("input[name=total_payment_money]").val()) {
                cust_mileage = $("input[name=total_payment_money]").val()
            }

            $("#formDcMileage").val(cust_mileage);
        } else {	//사용 X
            $("#formDcMileage").val(0);
        }
    }

    //===============================================================
    // 마일리지 적용
    //===============================================================
    function jsUsemileage(){
        var cust_mileage = "<?=$mileage?>";
        var use_mileage	 = parseInt(renumberFormat($("#formDcMileage").val()));

        if(parseInt(cust_mileage) < use_mileage){
            alert("보유하고 계신 마일리지보다 많은 마일리지를 적용하실 수 없습니다.");
            $("#formDcMileage").val(numberFormat($("input[name=use_mileage]").val()));
            return false;
        }

        if(parseInt(cust_mileage) < 1000){
            alert("마일리지 보유금액 1,000P이상부터 사용가능합니다.");
            $("#formDcMileage").val(numberFormat($("input[name=use_mileage]").val()));
            return false;
        }

//        if(parseInt(use_mileage) < 1000 && parseInt(use_mileage) != 0){
//            alert("마일리지는 1,000P부터 사용 가능합니다.");
//            $("#formDcMileage").val(numberFormat($("input[name=use_mileage]").val()));
//            return false;
//        }
//
//        if(parseInt(use_mileage)%1000 != 0){
//            alert("마일리지는 1,000P 단위로 사용할 수 있습니다.");
//            $("#formDcMileage").val(numberFormat($("input[name=use_mileage]").val()));
//            return false;
//        }

        if(parseInt(use_mileage) > $("input[name=total_payment_money]").val()){
            alert("결제 금액보다 사용하시려는 마일리지가 큽니다.");
            $("#formDcMileage").val(numberFormat($("input[name=use_mileage]").val()));
            return false;
        }

        $("input[name=use_mileage]").val(use_mileage);
        $("#formDcMileage").val(numberFormat(use_mileage));

        //가격 재계산
        total_sum_price();
    }


    //================================================================
    // 결제수단 선택
    //================================================================
    $(function(){
        $("#paymethod_card").on('click', function(e) {		//카드
            document.OrderForm.order_payment_type.value = "01";
            document.OrderForm.gopaymethod.value		= "card";

            document.order_info.pay_method.value		= "CARD";
            document.order_info.pay_mod.value			= "N";
            document.order_info.ActionResult.value		= "card";
            document.order_info.param_opt_2.value		= "01";
            $("#pay_kcp").show();
            $("#credit_info").show();
            $("#pay_kakao").hide();
            $("#kakao_info").hide();
            $("#pay_ars").hide();
        })
    })

    $(function(){
        $("#paymethod_trans").on('click', function(e) {		//계좌이체
            document.OrderForm.order_payment_type.value = "03";
            document.OrderForm.gopaymethod.value		= "trans";

            document.order_info.pay_method.value		= "BANK";
            document.order_info.pay_mod.value			= "O";
            document.order_info.ActionResult.value		= "acnt";
            document.order_info.param_opt_2.value		= "03";
            $("#pay_kcp").show();
            $("#credit_info").show();
            $("#pay_kakao").hide();
            $("#kakao_info").hide();
            $("#pay_ars").hide();
        })
    })

    $(function(){
        $("#paymethod_vbank").on('click', function(e) {		//가상계좌
            document.OrderForm.order_payment_type.value = "02";
            document.OrderForm.gopaymethod.value		= "vbank";

            document.order_info.pay_method.value		= "VCNT";
            document.order_info.pay_mod.value			= "O";
            document.order_info.ActionResult.value		= "vcnt";
            document.order_info.param_opt_2.value		= "02";
            $("#pay_kcp").show();
            $("#credit_info").show();
            $("#pay_kakao").hide();
            $("#kakao_info").hide();
            $("#pay_ars").hide();
        })
    })

    $(function(){
        $("#paymethod_phone").on('click', function(e) {		//휴대폰
            document.OrderForm.order_payment_type.value = "05";
            document.OrderForm.gopaymethod.value		= "phone";

            document.order_info.pay_method.value		= "MOBX";
            document.order_info.pay_mod.value			= "O";
            document.order_info.ActionResult.value		= "mobx";
            document.order_info.param_opt_2.value		= "05";
            $("#pay_kcp").show();
            $("#credit_info").show();
            $("#pay_kakao").hide();
            $("#kakao_info").hide();
            $("#pay_ars").hide();
        })
    })

    $(function(){
        $("#paymethod_kakao").on('click', function(e) {		//카카오페이
            document.OrderForm.order_payment_type.value = "07";
            $("#pay_kakao").show();
            $("#kakao_info").show();
            $("#pay_kcp").hide();
            $("#credit_info").hide();
            $("#pay_ars").hide();
        })
    })

    $(function(){
        $("#paymethod_vars").on('click', function(e) {		//ARS결제
            document.OrderForm.order_payment_type.value = "08";
            document.OrderForm.gopaymethod.value		= "vars";

            document.order_info.pay_method.value		= "VARS";
            $("#pay_kcp").hide();
            $("#credit_info").show();
            $("#pay_kakao").hide();
            $("#kakao_info").hide();
            $("#pay_ars").show();
        })
    })

    //=======================================
    // 상품옵션체크
    //=======================================
    function jsChkOption()
    {
        var optionCode = new Array();

        var hidOptionCode = document.getElementsByName("goods_option_code[]");

        for(var i=0;i<hidOptionCode.length;i++){
            optionCode[i] = hidOptionCode[i].value;
        }
        $.unique(optionCode);

        if(hidOptionCode.length != optionCode.length) {
            alert("주문하려는 상품의 옵션이 올바르지 않습니다. \n옵션 확인 후 다시 주문부탁드립니다.");
            return false;
        }

        var hidGoodsName = document.getElementsByName("goods_name[]");
        var hidGoodsOptionName = document.getElementsByName("goods_option_name[]");
        var hidGoodsQty = document.getElementsByName("goods_cnt[]");
        var hidOptionQty = document.getElementsByName("goods_option_qty[]");
        var hidBuyLimitQty = document.getElementsByName("goods_buy_limit_qty[]");

        for(var j=0;j<hidGoodsQty.length;j++){
            if(Number(hidBuyLimitQty[j].value) != 0) {
                if(Number(hidGoodsQty[j].value) > Number(hidBuyLimitQty[j].value)) {
                    alert("상품정보 : "+hidGoodsName[j].value+"("+hidGoodsOptionName[j].value+")\n1회 최대 구매수는 "+hidBuyLimitQty[j].value+" 개 입니다. \n상품 수량 수정 후 다시 주문부탁드립니다.");
                    return false;
                }
            }

            if(Number(hidGoodsQty[j].value) > Number(hidOptionQty[j].value)) {
                alert("상품정보 : "+hidGoodsName[j].value+"("+hidGoodsOptionName[j].value+")\n현재 주문가능한 재고수량은 "+hidOptionQty[j].value+" 개입니다. \n상품 수량 수정 후 다시 주문부탁드립니다.\n현재 구매수량 : "+hidGoodsQty[j].value);
                return false;
            }
        }

        return true;
    }

    //=======================================
    // validation체크
    //=======================================
    function jsChkValidation()
    {
        var frm = document.OrderForm;
        var deliv_info = "<?=$DELIV_INFO?>";
        var send_nation_info = "<?=$SEND_NATION_INFO?>";

//alert($('input[name=formAgree]').is(':checked'));
        if(frm.order_name.value == ""){
            alert("주문하시는 분을 입력해주세요.");
            frm.order_name.focus();
            return false;
        }

        frm.buyername.value = frm.order_name.value;		//주문자 히든값에 넣기

        if(frm.order_recipient.value == ""){
            alert("받으시는 분을 입력해주세요.");
            frm.order_recipient.focus();
            return false;
        }

        if(frm.order_postnum.value == ""){
            alert("우편번호를 입력해주세요.");
            frm.order_postnum.focus();
            return false;
        }

        if(frm.order_addr1.value == ""){
            alert("배송할 기본 주소지를 입력해주세요.");
            frm.order_addr1.focus();
            return false;
        }

        if(frm.order_addr2.value == ""){
            alert("배송할 상세 주소지를 입력해주세요.");
            frm.order_addr2.focus();
            return false;
        }

        if(frm.order_payment_type.value == '08'){
            if(frm.order_commID.value == ""){
                alert("통신사를 선택해주세요.");
                frm.order_commID.focus();
                return false;
            }
        }

        if(frm.order_mobile1.value == ""){
            alert("휴대폰 번호를 입력해주세요.");
            frm.order_mobile1.focus();
            return false;
        }

        if(frm.order_mobile2.value == ""){
            alert("휴대폰 번호를 입력해주세요.");
            frm.order_mobile2.focus();
            return false;
        }

        if(frm.order_mobile3.value == ""){
            alert("휴대폰 번호를 입력해주세요.");
            frm.order_mobile3.focus();
            return false;
        }

        if((frm.order_phone1.value != "" && frm.order_phone2.value == "") || (frm.order_phone1.value != "" && frm.order_phone3.value == "") || (frm.order_phone2.value != "" && frm.order_phone1.value == "") || (frm.order_phone2.value != "" && frm.order_phone3.value == "") || (frm.order_phone3.value != "" && frm.order_phone1.value == "") || (frm.order_phone3.value != "" && frm.order_phone2.value == "")){
            alert("전화번호를 입력해주세요.");
            frm.order_phone1.focus();
            return false;
        }

        if(frm.order_email1.value == ""){
            alert("결제정보를 받을 이메일을 입력해주세요.");
            frm.order_email1.focus();
            return false;
        }

        if(frm.order_email2.value == "" && document.getElementById("orderForm_7_2").value == ""){
            alert("결제정보를 받을 이메일을 입력해주세요.");
            frm.order_email2.focus();
            return false;
        } else {
            if(document.getElementById("orderForm_7_2").value != '직접입력'){
                frm.order_email2.value = document.getElementById("orderForm_7_2").value;
            }
        }

        if(deliv_info == 'Y'){
            if(frm.shipping_floor.value == ''){
                alert("가구 배송정보의 주거층수를 선택해주세요.");
                frm.shipping_floor.focus();
                return false;
            }

            if(frm.shipping_step_width.value == ''){
                alert("가구 배송정보의 계단폭을 선택해주세요.");
                frm.shipping_step_width.focus();
                return false;
            }

            if(frm.shipping_elevator.value == ''){
                alert("가구 배송정보의 엘레베이터를 선택해주세요.");
                frm.shipping_elevator.focus();
                return false;
            }

            if((!document.getElementById("orderPrdAgreeCheck1").checked) || (!document.getElementById("orderPrdAgreeCheck2").checked) || (!document.getElementById("orderPrdAgreeCheck3").checked)){
                alert("가구 배송정보에 동의 확인을 해주세요.");
                return false;
            }
        }

        if(send_nation_info == 'Y'){
            if((!document.getElementById("orderCustomsAgreeCheck1").checked)){
                alert("통관정보 수집 및 제공에 동의해주세요.");
                return false;
            }
            if((!document.getElementById("orderCustomsAgreeCheck2").checked)){
                alert("개인통관고유부호의 이름과 주문자명, 수취인명이 모두 동일한지 확인해주세요.");
                document.getElementById("orderCustomsAgreeCheck2").focus();
                return false;
            }
            if(frm.orderCustomsNum.value == ''){
                alert("P로 시작하는 개인통관 고유부호를 입력해주세요.");
                return false;
            }
        }

        if($('input[name=deliv_yn]').val() == 'N'){
            alert("주문하려는 주소지에 배송이 불가능한 상품이 있습니다. \n주소를 변경해주세요.");
            frm.order_postnum.focus();
            return false;
        }

        document.OrderForm.order_mobile.value	= frm.order_mobile1.value + "-" + frm.order_mobile2.value + "-" + frm.order_mobile3.value;

        if(frm.order_phone1.value != '' && frm.order_phone2.value != '' && frm.order_phone3.value != ''){
            document.OrderForm.order_phone.value	= frm.order_phone1.value + "-" + frm.order_phone2.value + "-" + frm.order_phone3.value;
        }
        else {
            document.OrderForm.order_phone.value = "";
        }

        var order_email = frm.order_email1.value+'@'+frm.order_email2.value;

        $('input[name=buyeremail]').val(order_email);	//주문자 이메일 히든값에 넣기
        $('input[name=buyertel]').val(document.OrderForm.order_mobile.value);	//주문자 휴대폰 번호 히든값에 넣기

        if(document.OrderForm.order_payment_type.value == '01'){		//KCP:카드로 결제일경우
            if(!document.getElementById("checkAgree4").checked){
                alert("구매동의에 동의해주세요.");
                return false;
            }
            $('input[name=escrowuse]').val('N');
        } else if(document.OrderForm.order_payment_type.value == '03'){	//KCP:계좌이체로 결제일경우
            if(!document.getElementById("checkAgree5").checked){
                alert("구매동의에 동의해주세요.");
                return false;
            }
            if(document.getElementById("checkAgree6").checked){
                $('input[name=escrowuse]').val('Y');
                document.order_info.pay_mod.value			= "O";
            } else {
                $('input[name=escrowuse]').val('N');
                document.order_info.pay_mod.value			= "N";
            }
        } else if(document.OrderForm.order_payment_type.value == '05'){	//KCP:휴대폰으로 결제일경우
            if(!document.getElementById("checkAgree9").checked){
                alert("구매동의에 동의해주세요.");
                return false;
            }
            $('input[name=escrowuse]').val('N');
        } else if(document.OrderForm.order_payment_type.value == '02'){	//KCP:가상계좌로 결제일경우
            if(frm.selRefundBank.value == "") {
                alert("주문취소 및 반품 시 환불받으실 은행을 선택해주세요.");
                frm.selRefundBank.focus();
                return false;
            }
            if(frm.txtRefundAccount.value == "") {
                alert("주문취소 및 반품 시 환불받으실 계좌번호를 입력해주세요.");
                frm.txtRefundAccount.focus();
                return false;
            }
            if(frm.txtRefundCust.value == "") {
                alert("주문취소 및 반품 시 환불받으실 예금주명을 입력해주세요.");
                frm.txtRefundCust.focus();
                return false;
            }
            if(!document.getElementById("checkAgree7").checked){
                alert("구매동의에 동의해주세요.");
                return false;
            }
            if(document.getElementById("checkAgree8").checked){
                $('input[name=escrowuse]').val('Y');
                document.order_info.pay_mod.value			= "O";
            } else {
                $('input[name=escrowuse]').val('N');
                document.order_info.pay_mod.value			= "N";
            }
        } else if(document.OrderForm.order_payment_type.value == '07'){	// 카카오페이 결제일경우
            if(!document.getElementById("checkAgree11").checked){
                alert("구매동의에 동의해주세요.");
                return false;
            }
            $('input[name=escrowuse]').val('N');
        } else if(document.OrderForm.order_payment_type.value == '04'){	// 전액 마일리지 결제일경우
            $('input[name=escrowuse]').val('N');
        } else if(document.OrderForm.order_payment_type.value == '08'){	//kcp:ARS 결제일경우
            if(!document.getElementById("checkAgree12").checked){
                alert("구매동의에 동의해주세요.");
                return false;
            }
            $('input[name=escrowuse]').val('N');
        } else {
            alert("구매동의에 동의해주세요.");
            return false;
        }
        return true;
    }

    //===============================================================
    // KCP 모바일 결제
    //===============================================================
    function jsOrderPayKCP(){

        if(document.order_info.good_mny.value == 0) {   //전액 마일리지 결제
            var session_no	= "<?=$this->session->userdata('EMS_U_NO_')?>";
            var session_id	= "<?=$this->session->userdata('EMS_U_ID_')?>";

            var browser_info = navigator.userAgent;
            $('input[name=browser_info]').val(browser_info);

            //상품옵션체크
            if(!jsChkOption()){
                return false;
            }

            //validation 체크
            if(!jsChkValidation()) {
                return false;
            }


            if(!(session_no != "" && session_id != 'GUEST' && session_id != 'TMP_GUEST')){
                $('input[name=buyerid]').val('GUEST');
                $('input[name=buyername]').val(document.OrderForm.order_name.value);
            }

            document.OrderForm.order_payment_type.value = '04';
            document.OrderForm.buyertel.value = document.OrderForm.order_mobile1.value + "-" + document.OrderForm.order_mobile2.value + "-" + document.OrderForm.order_mobile3.value;

            var param = $("#OrderForm").serialize();

            //주문정보 DB저장 후 kcp 결제창 호출
            $.ajax({
                type: 'POST',
                url: '/order/process_temp',
                dataType: 'json',
                data: param,
                error: function(res) {
                    alert('결제에 실패했습니다.');
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        req_ord_succ();
                    }
                    else alert(res.message);
                }
            });
        } else {
            var session_no	= "<?=$this->session->userdata('EMS_U_NO_')?>";
            var session_id	= "<?=$this->session->userdata('EMS_U_ID_')?>";

            var browser_info = navigator.userAgent;
            $('input[name=browser_info]').val(browser_info);

            //상품옵션체크
            if(!jsChkOption()){
                return false;
            }

            //validation 체크
            if(!jsChkValidation()){
                return false;
            }

            if(!(session_no != "" && session_id != 'GUEST' && session_id != 'TMP_GUEST')){
//		$('input[name=buyercode]').val('');
                $('input[name=buyerid]').val('GUEST');
                $('input[name=buyername]').val(document.OrderForm.order_name.value);
            }

            var form = document.order_info;
            var today = new Date();
            var year  = today.getFullYear();
            var month = today.getMonth() + 1;
            var date  = today.getDate();
            var time  = today.getTime();

            if(parseInt(month) < 10) {
                month = "0" + month;
            }

            if(parseInt(date) < 10) {
                date = "0" + date;
            }
            var order_idxx = "ETAH" + year + "" + month + "" + date + "" + time;

            var order_email = document.OrderForm.order_email1.value+'@'+document.OrderForm.order_email2.value;

            var buyr_tel1	= document.OrderForm.order_mobile1.value + "-" + document.OrderForm.order_mobile2.value + "-" + document.OrderForm.order_mobile3.value;

            if(document.OrderForm.order_phone1.value != '' && document.OrderForm.order_phone2.value != '' && document.OrderForm.order_phone3.value != ''){
                var buyr_tel2	= document.OrderForm.order_phone1.value + "-" + document.OrderForm.order_phone2.value + "-" + document.OrderForm.order_phone3.value;
            }
            else {
                var buyr_tel2 = "";
            }


            document.order_info.ordr_idxx.value = order_idxx;

            document.order_info.buyr_name.value = document.OrderForm.order_name.value;
            document.order_info.buyr_mail.value = order_email;
            document.order_info.buyr_tel1.value = buyr_tel1;
            document.order_info.buyr_tel2.value = buyr_tel2;

            //에스크로 정보
            document.order_info.rcvr_name.value = document.OrderForm.order_name.value;
            document.order_info.rcvr_mail.value = order_email;
            document.order_info.rcvr_tel1.value = buyr_tel1;
            document.order_info.rcvr_tel2.value = buyr_tel2;
            document.order_info.rcvr_zipx.value = document.OrderForm.order_postnum_text.value;
            document.order_info.rcvr_add1.value = document.OrderForm.order_addr1_text.value;
            document.order_info.rcvr_add2.value = document.OrderForm.order_addr2.value;
            kcp_AJAX();
        }

    }

    //===============================================================
    // KAKAO_PAY 모바일 결제
    //===============================================================
    function jsOrderPayKAKAO()
    {
        if(document.order_info.good_mny.value == 0) {   //전액 마일리지 결제
            var session_no	= "<?=$this->session->userdata('EMS_U_NO_')?>";
            var session_id	= "<?=$this->session->userdata('EMS_U_ID_')?>";

            var browser_info = navigator.userAgent;
            $('input[name=browser_info]').val(browser_info);

            //상품옵션체크
            if(!jsChkOption()){
                return false;
            }

            //validation 체크
            if(!jsChkValidation()) {
                return false;
            }


            if(!(session_no != "" && session_id != 'GUEST' && session_id != 'TMP_GUEST')){
                $('input[name=buyerid]').val('GUEST');
                $('input[name=buyername]').val(document.OrderForm.order_name.value);
            }

            document.OrderForm.order_payment_type.value = '04';
            document.OrderForm.buyertel.value = document.OrderForm.order_mobile1.value + "-" + document.OrderForm.order_mobile2.value + "-" + document.OrderForm.order_mobile3.value;

            var param = $("#OrderForm").serialize();

            //주문정보 DB저장 후 kcp 결제창 호출
            $.ajax({
                type: 'POST',
                url: '/order/process_temp',
                dataType: 'json',
                data: param,
                error: function(res) {
                    alert('결제에 실패했습니다.');
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        req_ord_succ();
                    }
                    else alert(res.message);
                }
            });
        } else {
            var session_no	= "<?=$this->session->userdata('EMS_U_NO_')?>";
            var session_id	= "<?=$this->session->userdata('EMS_U_ID_')?>";

            var browser_info = navigator.userAgent;
            document.OrderForm.browser_info.value = browser_info;

            //상품옵션체크
            if(!jsChkOption()){
                return false;
            }

            //validation 체크
            if(!jsChkValidation()){
                return false;
            }

            if(!(session_no != "" && session_id != 'GUEST' && session_id != 'TMP_GUEST')){
                $('input[name=buyerid]').val('GUEST');
                $('input[name=buyername]').val(document.OrderForm.order_name.value);
            }
            var frm = document.getElementById("OrderForm");
            var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";

            frm.action = "https://"+SSL_val+"/order/kakao_pay";
            frm.submit();
        }
    }

    //===============================================================
    // 주문 결제 팝업 띄우기
    //===============================================================
    function jsOrderPay(){

        var session_no	= "<?=$this->session->userdata('EMS_U_NO_')?>";
        var session_id	= "<?=$this->session->userdata('EMS_U_ID_')?>";

        //validation 체크
        if(!jsChkValidation()){
            return false;
        }

        if(!(session_no != "" && session_id != 'GUEST' && session_id != 'TMP_GUEST')){
            $('input[name=buyerid]').val('GUEST');
            $('input[name=buyername]').val(document.OrderForm.order_name.value);
        }

        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";

        var url = "https://"+SSL_val+"/order/pay_popup";

        //모바일 결제를 위해 팝업창 띄우기
        popupOpen(url);

    }

    var m_hWnd = null;
    var m_hTime = null;

    //팝업창 띄우기
    function popupOpen(URL){
        m_hWnd = window.open(URL, "_popup", "left="+(screen.width/2-150)+",top= "+(screen.height/2-200)+",width=800, height=700,status=yes, scrollbars=no, resizable=yes, menubar=no");
        if(m_hWnd==null) {
            alert("팝업을 허용해 주시기 바랍니다.\n");
            return false;
        }
        m_hWnd.focus();
        m_hTime = setTimeout("checkPopup()", 600);
    }

    //팝업이 종료되었는지 검사
    function checkPopup(){
        if(m_hWnd != null)
            if(m_hWnd.closed == false) {
                m_hTime = setTimeout("checkPopup()", 600);
                return;
            }

//	alert("사용자가 팝업창을 닫았습니다.");
        window.top.window.focus();

        clearTimeout(m_hTime);
        m_hTime = null;

        req_approval();
    }

    //===============================================================
    // 결제 완료 후 팝업 닫히면 주문 생성하기 - import
    //===============================================================
    function req_approval()
    {
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
        if($("input[name='pay_result']").val() == 'N'){
            alert("결제에 실패하였습니다.");
            return false;
        } else if($("input[name='pay_result']").val() == 'Y'){
            //alert("결제완료, 주문생성");

            var param = $("#OrderForm").serialize();

            $.ajax({
                type: 'POST',
                url: 'https://'+SSL_val+'/order/process',
                dataType: 'json',
                data: param,
                error: function(res) {
                    alert('Database Error');
                    alert(res.responseText)
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        location.href = 'https://'+SSL_val+'/cart/Step3_Order_finish?order_no='+res.order_no;
                    }
                    else alert(res.message);
                }
            });
        }
    }

    jsAddrReset('A');
    total_sum_price();
</script>

<script type="text/javascript">

    $(window).load(function() {
        chk_pay();
    });

    /* kcp web 결제창 호츨 (변경불가) */
    function call_pay_form()
    {
        var v_frm = document.order_info;
        var param = $("#OrderForm").serialize();

        // 인코딩 방식에 따른 변경 -- Start
        if(v_frm.encoding_trans == undefined)
        {
            v_frm.action = PayUrl;
        }
        else
        {
            if(v_frm.encoding_trans.value == "UTF-8")
            {
                v_frm.action = PayUrl.substring(0,PayUrl.lastIndexOf("/"))  + "/jsp/encodingFilter/encodingFilter.jsp";
                v_frm.PayUrl.value = PayUrl;
            }
            else
            {
                v_frm.action = PayUrl;
            }
        }
        // 인코딩 방식에 따른 변경 -- End

        if (v_frm.Ret_URL.value == "")
        {
            /* Ret_URL값은 현 페이지의 URL 입니다. */
            alert("연동시 Ret_URL을 반드시 설정하셔야 됩니다.");
            return false;
        }
        else
        {
            //alert(param);
            //주문정보 DB저장 후 kcp 결제창 호출
            $.ajax({
                type: 'POST',
                url: '/order/process_temp',
                dataType: 'json',
                data: param,
                error: function(res) {
                    alert('결제에 실패했습니다.ㄹㄹㄹㄹ');
                    //alert(res.responseText)
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        //alert(res.order_no);
                        v_frm.param_opt_1.value = res.order_no;
                        v_frm.submit();
                    }
                    else alert(res.message);
                }
            });

            //   v_frm.submit();
        }
    }

    /* kcp 통신을 통해 받은 암호화 정보 체크 후 결제 요청 (변경불가) */
    function chk_pay()
    {
        self.name = "tar_opener";
        var pay_form = document.pay_form;
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";

        if (pay_form.res_cd.value == "3001" )
        {
            alert("사용자가 취소하였습니다.");
            pay_form.res_cd.value = "";
            location.href = '/cart/Step3_Order_fail';
        }

        if (pay_form.enc_info.value){

            pay_form.submit();

        }
    }

    //===============================================================
    // 결제 완료 후 팝업 닫히면 주문 생성하기 - import
    //===============================================================
    function req_ord_succ()
    {
        //alert('etah 주문생성');

        var session_no	= "<?=$this->session->userdata('EMS_U_NO_')?>";
        var session_id	= "<?=$this->session->userdata('EMS_U_ID_')?>";

        if(!(session_no != "" && session_id != 'GUEST' && session_id != 'TMP_GUEST')){
            $('input[name=buyerid]').val('GUEST');
            $('input[name=buyername]').val(document.OrderForm.order_name.value);
        }

        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
        var param = $("#OrderForm").serialize();

        $.ajax({
            type: 'POST',
            url: 'https://'+SSL_val+'/order/process',
            dataType: 'json',
            data: param,
            error: function(res) {
                alert('Database Error');
                alert(res.responseText)
            },
            success: function(res) {
                if(res.status == 'ok'){
                    location.href = 'https://'+SSL_val+'/cart/Step3_Order_finish?order_no='+res.order_no;
                }
                else alert(res.message);

            }
        });
    }

</script>


<script>
    //===============================================================
    // ARS 결제
    //===============================================================
    function jsOrderPayARS() {
        if(document.order_info.good_mny.value == 0) {   //전액 마일리지 결제
            var session_no	= "<?=$this->session->userdata('EMS_U_NO_')?>";
            var session_id	= "<?=$this->session->userdata('EMS_U_ID_')?>";

            var browser_info = navigator.userAgent;
            $('input[name=browser_info]').val(browser_info);

            //상품옵션체크
            if(!jsChkOption()){
                return false;
            }

            //validation 체크
            if(!jsChkValidation()) {
                return false;
            }


            if(!(session_no != "" && session_id != 'GUEST' && session_id != 'TMP_GUEST')){
                $('input[name=buyerid]').val('GUEST');
                $('input[name=buyername]').val(document.OrderForm.order_name.value);
            }

            document.OrderForm.order_payment_type.value = '04';
            document.OrderForm.buyertel.value = document.OrderForm.order_mobile1.value + "-" + document.OrderForm.order_mobile2.value + "-" + document.OrderForm.order_mobile3.value;

            var param = $("#OrderForm").serialize();

            //주문정보 DB저장 후 kcp 결제창 호출
            $.ajax({
                type: 'POST',
                url: '/order/process_temp',
                dataType: 'json',
                data: param,
                error: function(res) {
                    alert('결제에 실패했습니다.');
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        req_ord_succ();
                    }
                    else alert(res.message);
                }
            });
        } else {
            var session_no	= "<?=$this->session->userdata('EMS_U_NO_')?>";
            var session_id	= "<?=$this->session->userdata('EMS_U_ID_')?>";

            var browser_info = navigator.userAgent;
            $('input[name=browser_info]').val(browser_info);

            //상품옵션체크
            if(!jsChkOption()){
                return false;
            }

            //validation 체크
            if(!jsChkValidation()){
                return false;
            }

            if(!(session_no != "" && session_id != 'GUEST' && session_id != 'TMP_GUEST')){
                $('input[name=buyerid]').val('GUEST');
                $('input[name=buyername]').val(document.OrderForm.order_name.value);
            }

            var form = document.order_info;
            var today = new Date();
            var year  = today.getFullYear();
            var month = today.getMonth() + 1;
            var date  = today.getDate();
            var time  = today.getTime();

            if(parseInt(month) < 10) {
                month = "0" + month;
            }

            if(parseInt(date) < 10) {
                date = "0" + date;
            }
            var order_idxx = "ETAH" + year + "" + month + "" + date + "" + time;

            var phon_no	= document.OrderForm.order_mobile1.value + document.OrderForm.order_mobile2.value + document.OrderForm.order_mobile3.value;

            document.order_info.ordr_idxx.value = order_idxx;
            document.order_info.buyr_name.value = document.OrderForm.order_name.value;
            document.order_info.phon_no.value = phon_no;
            document.order_info.comm_id.value = document.OrderForm.order_commID.value;
            document.order_info.cert_flg.value = 'Y';

            var param = $("#OrderForm").serialize();

            //주문정보 DB저장 후 kcp 결제창 호출
            $.ajax({
                type: 'POST',
                url: '/order/process_temp',
                dataType: 'json',
                data: param,
                error: function(res) {
                    alert('결제에 실패했습니다.');
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        go_pay_ars();
                    }
                    else {
                        alert(res.message);
                    }
                }
            });
        }
    }

    function go_pay_ars(){
        var param = $("#order_info").serialize();

        $.ajax({
            type: 'POST',
            url: '/order/process_temp_ars',
            dataType: 'json',
            data: param,
            error: function(res) {
                alert('오류가 발생하였습니다.');
            },
            success: function(res) {
                if(res.res_cd == '0000'){
                    //kcp결제 통신 완료
                    document.OrderForm.vnum_no.value		= res.vnum_no;		//ARS 결제요청 가상 전화번호
                    document.OrderForm.expr_dt.value	    = res.expr_dt;		//ARS 결제 유효기간
                    document.OrderForm.ars_trade_no.value	= res.ars_trade_no;	//ARS 상품 등록번호
                    document.OrderForm.pg_tid.value			= res.pg_tid;

                    req_ord_succ();
                } else{
                    alert('결제에 실패 하였습니다 \n'+res.res_msg);
                    console.log(res.message);
                    location.href = '/cart/Step3_Order_fail';
                }
            }
        });
    }
</script>