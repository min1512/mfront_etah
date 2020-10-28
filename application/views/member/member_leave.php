<link rel="stylesheet" href="/assets/css/mypage.css">

<div class="content">
	<h2 class="page-title-basic page-title-basic--line">회원정보</h2>
	<div class="mypage-member-info-wrap mypage-member-away">
		<h3 class="info-title info-title--sub">회원탈퇴</h3>
		<div class="form-line form-line--wide">
			<div class="select-box select-box--big">
				<select class="select-box-inner" name="member_leave">
					<option value="01">아이디(이메일주소) 변경을 위해 탈퇴 후 재가입</option>
					<option value="02">상품 가격 불만</option>
					<option value="03">장기간 부재 (군입대, 유학 등)</option>
					<option value="04">배송 불만</option>
					<option value="05">개인정보 누출 우려</option>
					<option value="06">교환/환불/반품 불만</option>
					<option value="07">상품의 다양성/품질 불만</option>
					<option value="08">사후조치 불만</option>
					<option value="09">기타</option>
				</select>
			</div>
		</div>
		<div class="form-line form-line--wide">
			<div class="form-line-info">
				<label>
					<textarea type="text" name="leave_comment" class="input-text input-text--textarea" placeholder="탈퇴 사유를 입력해주세요. 보내 주신 의견을 통해 더 나은 서비스를 만들겠습니다."></textarea>
				</label>
			</div>
		</div>
		<div class="mypage-info-section">
			<h4 class="mypage-info-section-title"><span class="ico-i">i</span>안내사항</h4>
			<ul class="text-list">
				<li class="text-item">회원탈퇴 요청 후 처리 기간이 일주일 정도 소요됩니다.<br>이 기간 중 이메일이 발송될 수 있으니 양해 부탁 드립니다.</li>
				<li class="text-item">회원탈퇴를 하시면, 보유하고 계신 마일리지 및 할인쿠폰은 자동소멸되어 재가입하실 경우에도 복원되지 않습니다.</li>
				<li class="text-item">회원탈퇴 하신 후, 30일내 재가입이 불가능합니다.</li>
			</ul>
		</div>
		<ul class="check-text-bg">
			<li class="check-text-bg-item">
				<input type="checkbox" id="mypageAwayAgree" class="checkbox" name="member_leave_agree">
				<label for="mypageAwayAgree" class="checkbox-label checkbox-label--right">회원탈퇴 안내를 모두 확인하였으며, 회원 탈퇴에 동의합니다.</label>
			</li>
		</ul>
		<ul class="common-btn-box">
			<li class="common-btn-item"><a href="/mywiz" class="btn-white btn-white--big">탈퇴취소</a></li>
			<li class="common-btn-item"><a href="#" class="btn-black btn-black--big" onClick="javascript:member_leave();">회원탈퇴</a></li>
		</ul>
	</div>

	<script type="text/javaScript">
	//====================================
	// 회원탈퇴
	//====================================
	function member_leave(){
		var leave_cd = $(":input[name=member_leave]").val()
			, leave_comment = $("textarea[name=leave_comment]").val()
			, leave_agree = $("input:checkbox[name=member_leave_agree]").is(":checked")//.attr('checked');

		if(leave_cd == '09' && !leave_comment){
			alert("기타 사유를 입력해주세요.");
			$("input[name=leave_comment]").focus();
			return false;
		}
		if(!leave_agree){
			alert("회원 탈퇴에 동의하지 않으셨습니다.");
			return false;
		}

        if(confirm("회원탈퇴를 하시겠습니까?")){
            <?if($this->session->userdata('EMS_U_SNS') =='Y' && empty($this->session->userdata('sns_kind'))){ //sns연동 고객인데 sns로 로그인 안한경우..?>
            $.ajax({
                type: 'POST',
                url: '/member/sns_gubun',
                dataType: 'json',
                error: function(res) {
                    alert('Database Error');
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        //								alert("수정되었습니다.");
                        //location.href="/member/leave_finish";
                        alert('앱 연동해제를 위해 로그인 해주시기 바랍니다.');
                        if(res.message == 'N'){
                            loginWithNaver();
                        }else if(res.message == 'K'){
                            loginWithKakao();
                        }else{
                            alert(res.message);
                        }
                    }
                    else alert(res.message);
                }
            });
            <?}else{?>
            $.ajax({
                type: 'POST',
                url: '/member/leave',
                dataType: 'json',
                data: { leave_cd : leave_cd,
                    leave_comment : leave_comment},
                error: function(res) {
                    alert('Database Error');
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        //								alert("수정되었습니다.");
                        location.href="/member/leave_finish";
                    }
                    else alert(res.message);
                }
            });
            <?}?>
        }
	}
    //===============================================================
    // 카카오
    //===============================================================
    function loginWithKakao(){
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
        window.open("https://"+SSL_val+"/member/kakao_login","login-kakao","width=464, height=618, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
    }

    //===============================================================
    // 네이버
    //===============================================================
    function loginWithNaver(){
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
        window.open("https://"+SSL_val+"/member/naver_login","login-naver","width=600, height=600, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
    }
	</script>