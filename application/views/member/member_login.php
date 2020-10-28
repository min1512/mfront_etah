<link rel="stylesheet" href="/assets/css/login.css?">

<!-- 화원로그인 // -->
<div class="content">
    <h2 class="page-title-basic">LOGIN</h2>
    <form method="post" name="mainform" id="mainform">
        <input type="hidden" id="login_gb" name="login_gb" value="">	<!-- 아이디로 로그인인지 이메일로 로그인인지 구분 -->
        <input type="hidden" id="tmp_no" name="tmp_no" value="<?=$tmp_no?>">		<!-- 비회원으로 로그인하고 장바구니를 사용하였을 경우 장바구니 정보를 업데이트 해주기 위해서 임시코드 -->
        <input type="hidden" id="sns_id" name="sns_id" value="">
        <input type="hidden" id="return_url" name="return_url" value="<?=$returnUrl?>">

        <div class="login-wrap member-login-wrap">
            <h3 class="info-title info-title--sub"><label for="loginIdForm_1_1">회원 로그인</label></h3>
            <div class="form-line form-line--wide">
                <div class="form-line-info">
                    <input type="text" class="input-text" id="loginIdForm_1_1" name="mem_id" placeholder="ID 또는 이메일" onKeyPress="javascript:if(event.keyCode == 13){ javaScript:jsLogin(); return false;}">
                </div>
            </div>
            <div class="form-line form-line--wide">
                <div class="form-line-info">
                    <label><input type="password" name="mem_password" class="input-text" placeholder="비밀번호" onKeyPress="javascript:if(event.keyCode == 13){ javaScript:jsLogin(); return false;}"></label>
                </div>
            </div>

            <ul class="login-check-list">
                <!--		<li class="login-check-item">
                            <input type="checkbox" id="loginCheck1" class="checkbox">
                            <label for="loginCheck1" class="checkbox-label">자동 로그인</label>
                        </li>		-->
                <li class="login-check-item">
                    <input type="checkbox" id="formIdSave" name="id_save" class="checkbox">
                    <label for="formIdSave" class="checkbox-label">아이디 저장</label>
                </li>
            </ul>
            <ul class="common-btn-box">
                <li class="common-btn-item"><a href="javascript://" onClick="jsLogin();" class="btn-black btn-black--big">로그인</a></li>
            </ul>
            <ul class="login-menu-list">
                <li class="login-menu-item"><a href="/member/id_search" class="login-menu-link">아이디찾기</a></li>
                <li class="login-menu-item"><a href="/member/password_search" class="login-menu-link">비밀번호찾기</a></li>
                <li class="login-menu-item"><a href="/member/member_join1" class="login-menu-link">회원가입</a></li>
            </ul>
        </div>
        <!-- // 회원로그인 -->

        <!-- SNS로그인 -->
        <div class="login-wrap sns-login-wrap">
            <div class="sns-btn-box">
                <a href="#" target="_blank"  class="btn_sns naver" onclick="javascript:loginWithNaver();return false">네이버ID 로그인</a>
                <a href="#" class="btn_sns kakao" onclick="javascript:loginWithKakao();return false">카카오ID 로그인</a>
                <a href="#" class="btn_sns wemap" onclick="javascript:loginWithWemap();return false">위메프ID 로그인</a>
            </div>
        </div>


        <!-- 비회원로그인 // -->
        <div class="login-wrap none-member-login-wrap">
            <h3 class="info-title info-title--sub">비회원 로그인</h3>

            <div class="form-line form-line--modify">
                <div class="form-line-info">
                    <label class="form-line-title" for="loginOrderNameForm_1_1">구매자명</label>
                    <input type="text" class="input-text" id="loginOrderNameForm_1_1" name="order_name" placeholder="주문하신 분 성함을 입력해주세요.">
                </div>
            </div>
            <div class="form-line form-line--modify">
                <div class="form-line-info">
                    <label class="form-line-title" for="loginOrderNumForm_1_1">주문번호</label>
                    <input type="text" class="input-text" id="loginOrderNumForm_1_1" name="order_no" placeholder="이메일로 수신하신 주문번호를 입력해주세요.">
                </div>
            </div>


            <p class="non-member-login-info"><span class="ico-i">i</span>주문번호를 잊으신 경우, 고객센터(1522-5572) 또는 1:1문의를 통해 확인하실 수 있습니다.</p>
            <ul class="common-btn-box">
                <li class="common-btn-item"><a href="javascript://" class="btn-gray btn-gray--big" onClick="javascript:jsGuestLogin();">비회원 로그인</a></li>
            </ul>

            <!-- 비회원 주문하기 버튼 추가 //-->
            <? if($guest_gb == 'direct'){	?>
                <p class="non-member-login-info"><span class="ico-i">i</span>비회원으로 주문하실 경우, 에타에서 제공되는 쿠폰 할인 및 마일리지 적립 등의 혜택은 받으실 수 없습니다.</p>
                <ul class="common-btn-box">
                    <li class="common-btn-item"><a href="javascript:jsGuestOrder();" class="btn-black btn-black--big">비회원 주문하기</a></li>
                </ul>
            <? }?>
            <!-- // 비회원 주문하기 버튼 추가 -->

        </div>
        <!-- // 비회원로그인 -->
    </form>
</div>

<!-- 상품정보 시작 (비회원 구매를 위해) -->
<form id="goods_form" name="goods_form" method="post">
    <? if($param){	?>
        <?
        //상품상세피이지 - 바로구매
        if(!isset($param['order_gb'])) {?>
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
        <?
        //장바구니 구매
        }else{?>
            <input type="hidden" name="order_gb"	id="order_gb"	 value="<?=$param['order_gb']?>">		                <!-- 전체주문/선택주문/바로주문 구분 -->
            <input type="hidden" name="direct_code" id="direct_code" value="<?=$param['direct_code']?>">		            <!-- 바로주문시 장바구니코드         -->

            <? for($i=0;$i<count($param['cart_code']);$i++){?>
                <?if($param['chkGoods'][$i]){?><input type="hidden"     name="chkGoods[]"       value="<?=$param['chkGoods'][$i]?>"><?}?>   <!-- 선택상품주문시 -->
                <?if($param['cart_code'][$i]){?><input type="hidden"    name="cart_code[]"      value="<?=$param['cart_code'][$i]?>"><?}?>  <!-- 전체상품주문시 -->

                <input type="hidden"    name="group_code[]"                 value="<?=$param['group_code'][$i]?>">
                <input type="hidden"    name="goods_cnt[]"                  value="<?=$param['goods_cnt'][$i]?>">
                <input type="hidden"    name="limit_cnt[]"                  value="<?=$param['limit_cnt'][$i]?>">
                <input type="hidden"    name="group_text[]"                 value="<?=$param['group_text'][$i]?>">
                <input type="hidden"    name="group_delivery_price[]"       value="<?=$param['group_delivery_price'][$i]?>">
                <input type="hidden"    name="goods_delivery_price[]"       value="<?=$param['goods_delivery_price'][$i]?>">
                <input type="hidden"    name="deli_code[]"                  value="<?=$param['deli_code'][$i]?>">
                <input type="hidden"    name="chk_deli_code[]"              value="<?=$param['chk_deli_code'][$i]?>">
                <input type="hidden"    name="goods_code[]"                 value="<?=$param['goods_code'][$i]?>">
                <input type="hidden"    name="goods_name[]"                 value="<?=$param['goods_name'][$i]?>">
                <input type="hidden"    name="goods_state_code[]"           value="<?=$param['goods_state_code'][$i]?>">
                <input type="hidden"    name="goods_cate_code1[]"           value="<?=$param['goods_cate_code1'][$i]?>">
                <input type="hidden"    name="goods_cate_code2[]"           value="<?=$param['goods_cate_code2'][$i]?>">
                <input type="hidden"    name="goods_cate_code3[]"           value="<?=$param['goods_cate_code3'][$i]?>">
                <input type="hidden"    name="brand_code[]"                 value="<?=$param['brand_code'][$i]?>">
                <input type="hidden"    name="brand_name[]"                 value="<?=$param['brand_name'][$i]?>">
                <input type="hidden"    name="goods_option_code[]"          value="<?=$param['goods_option_code'][$i]?>">
                <input type="hidden"    name="goods_option_name[]"          value="<?=$param['goods_option_name'][$i]?>">
                <input type="hidden"    name="goods_option_add_price[]"     value="<?=$param['goods_option_add_price'][$i]?>">
                <input type="hidden"    name="goods_option_qty[]"           value="<?=$param['goods_option_qty'][$i]?>">
                <input type="hidden"    name="goods_img[]"                  value="<?=$param['goods_img'][$i]?>">
                <input type="hidden"    name="goods_price_code[]"           value="<?=$param['goods_price_code'][$i]?>">
                <input type="hidden"    name="goods_selling_price[]"        value="<?=$param['goods_selling_price'][$i]?>">
                <input type="hidden"    name="goods_street_price[]"         value="<?=$param['goods_street_price'][$i]?>">
                <input type="hidden"    name="goods_factory_price[]"        value="<?=$param['goods_factory_price'][$i]?>">
                <input type="hidden"    name="goods_discount_price[]"       value="<?=$param['goods_discount_price'][$i]?>">
                <input type="hidden"    name="goods_mileage_save_rate[]"    value="<?=$param['goods_mileage_save_rate'][$i]?>">
                <input type="hidden"    name="goods_coupon_code_s[]"        value="<?=$param['goods_coupon_code_s'][$i]?>">
                <input type="hidden"    name="goods_coupon_amt_s[]"         value="<?=$param['goods_coupon_amt_s'][$i]?>">
                <input type="hidden"    name="goods_coupon_code_i[]"        value="<?=$param['goods_coupon_code_i'][$i]?>">
                <input type="hidden"    name="goods_coupon_amt_i[]"         value="<?=$param['goods_coupon_amt_i'][$i]?>">
                <input type="hidden"    name="goods_add_coupon_no[]"        value="<?=$param['goods_add_coupon_no'][$i]?>">
                <input type="hidden"    name="goods_add_coupon_code[]"      value="<?=$param['goods_add_coupon_code'][$i]?>">
                <input type="hidden"    name="goods_add_coupon_num[]"       value="<?=$param['goods_add_coupon_num'][$i]?>">
                <input type="hidden"    name="goods_add_coupon_type[]"      value="<?=$param['goods_add_coupon_type'][$i]?>">
                <input type="hidden"    name="goods_add_coupon_gubun[]"     value="<?=$param['goods_add_coupon_gubun'][$i]?>">
                <input type="hidden"    name="goods_add_discount_price[]"   value="<?=$param['goods_add_discount_price'][$i]?>">
                <input type="hidden"    name="deli_policy_no[]"             value="<?=$param['deli_policy_no'][$i]?>">
                <input type="hidden"    name="deli_cost[]"                  value="<?=$param['deli_cost'][$i]?>">
                <input type="hidden"    name="deli_limit[]"                 value="<?=$param['deli_limit'][$i]?>">
                <input type="hidden"    name="deli_pattern[]"               value="<?=$param['deli_pattern'][$i]?>">
                <input type="hidden"    name="send_nation[]"                value="<?=$param['send_nation'][$i]?>">
                <input type="hidden"    name="goods_buy_limit_qty[]"        value="<?=$param['goods_buy_limit_qty'][$i]?>">
                <input type="hidden"    name="goods_tax_gb_cd[]"            value="<?=$param['goods_tax_gb_cd'][$i]?>">
            <?}?>
        <?}?>
    <? }?>
</form>


<script type="text/javascript">
    //===============================================================
    // 회원로그인
    //===============================================================
    function jsLogin()
    {
        var mf		= document.mainform;

        if( ! $("input[name=mem_id]").val() ){
            alert("아이디를 입력해 주십시오");
            mf.mem_id.focus();
            return false;
        }
        if( ! $("input[name=mem_password]").val() ){
            alert("비밀번호를 입력해 주십시오");
            mf.mem_password.focus();
            return false;
        }

        var exptext = /^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/;
        if(exptext.test($("input[name=mem_id]").val())==true){	//이메일 형식인지 아이디 형식인지 구분
            mf.login_gb.value = "email";
        } else {
            mf.login_gb.value = "id";
        }

        //아이디저장
        if (mf.id_save.checked == true)	{
            $.cookie('saveid', mf.mem_id.value, { expires: 7, path: '/' });
        }
        else {
            $.removeCookie('saveid', { path: '/' });
        }

        var param = $("#mainform").serialize();
        $.ajax({
            type: 'POST',
            url: '/member/login',
            async: false,
            dataType: 'json',
            data: param,
            error : function(res) {
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    location.href = "<?=$returnUrl?>";
                }
                else{
                    alert(res.message);
                }
            }
        })

        return true;
    }

    //===============================================================
    // 비회원 주문하기
    //===============================================================
    function jsGuestOrder()
    {
        var param		= $("#goods_form").serialize();
        var frm = document.getElementById("goods_form");
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";

//	frm.action = "/cart/GuestOrder";
        frm.action = "https://"+SSL_val+"/cart/OrderInfo";		//주문결제페이지 동의약관이 나오도록 함 (2017-04-20)
        frm.submit();
    }

    //===============================================================
    // 비회원로그인
    //===============================================================
    function jsGuestLogin()
    {
        var mf		= document.mainform;

        if( ! $("input[name=order_name]").val() ){
            alert("구매자 이름을 입력해 주십시오");
            mf.order_name.focus();
            return false;
        }
        if( ! $("input[name=order_no]").val() ){
            alert("주문번호를 입력해 주십시오");
            mf.order_no.focus();
            return false;
        }


        var param = $("#mainform").serialize();
        $.ajax({
            type: 'POST',
            url: '/member/guest_login',
            async: false,
            dataType: 'json',
            data: param,
            error : function(res) {
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    location.href = "/mywiz/mypage";
                }
                else{
                    alert(res.message);
                }
            }
        })

        return true;
    }

    //===============================================================
    // 카카오로그인
    //===============================================================
    function loginWithKakao(){
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
        window.open("https://"+SSL_val+"/member/kakao_login","login-naver","width=464, height=618, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
    }

    //===============================================================
    // 네이버로그인
    //===============================================================
    function loginWithNaver(){
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
        window.open("https://"+SSL_val+"/member/naver_login","login-naver","width=600, height=600, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
    }

    //===============================================================
    // 위메프로그인
    //===============================================================
    function loginWithWemap(){
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
        window.open("https://"+SSL_val+"/member/wemap_login","login-wemap","width=600, height=600, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
    }


    $(function(){
        if($.cookie('saveid')) $("input:checkbox[id='formIdSave']").attr("checked", true); $("input[name=mem_id]").val($.cookie('saveid'));
    })
</script>