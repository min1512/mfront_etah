<link rel="stylesheet" href="/assets/css/mypage.css?ver=1.3">

<div class="content">
	<h2 class="page-title-basic page-title-basic--line">회원정보</h2>
	<div class="mypage-member-info-wrap">
		<h3 class="info-title info-title--mypage">개인정보수정</h3>
		<form id="infoForm" name="infoForm">
		<div class="mypage-member-info-form">
			<div class="form-line form-line--wide">
				<div class="form-line-info">
					<label><input type="text" class="input-text" value="<?=$info['CUST_NM']?>" disabled></label>
				</div>
			</div>
			<div class="form-line form-line--wide">
				<div class="form-line-info">
					<label><input type="text" class="input-text" value="<?=$info['CUST_ID']?>" disabled name="member_id"></label>
				</div>
			</div>
			<div class="form-line form-line--modify">
				<div class="form-line-info">
					<label class="form-line-title" for="memberInfoPwdForm1_1">새 비밀번호</label>
					<input type="password" class="input-text input-text--modify-left" id="memberInfoPwdForm1_1" placeholder="공백없는 8~16자 영문/숫자 조합" name="member_pw">
				</div>
			</div>
			<div class="form-line form-line--modify">
				<div class="form-line-info">
					<label class="form-line-title" for="memberInfoPwdForm1_2">새 비밀번호 확인</label>
					<input type="password" class="input-text input-text--modify-left" id="memberInfoPwdForm1_2" placeholder="비밀번호 확인을 위해 다시 입력해주세요." name="member_pw2">
				</div>
			</div>
			<div class="form-line form-line--modify">
				<div class="form-line-info">
					<label class="form-line-title" for="memberInfoBirthForm1_1">생년월일</label>
					<input type="number" class="input-text" id="memberInfoBirthForm1_1" placeholder="YYYYMMDD" value="<?=@$info['BIRTH_DY']?>" name="member_birth" maxLength="8">
				</div>
			</div>
			<div class="form-line form-line--wide form-line--cols">
				<div class="form-line-title"><label for="memberInfoPhoneForm1_1"></label></div>
				<div class="form-line-info">
					<div class="form-line--cols-item">
						<div class="select-box select-box--big">
							<select class="select-box-inner" id="memberInfoPhoneForm1_1" name="mob_phone1">
								<option <?=$info['arr_phone'][0] == '010' ? "selected" : ""?>>010</option>
								<option <?=$info['arr_phone'][0] == '011' ? "selected" : ""?>>011</option>
								<option <?=$info['arr_phone'][0] == '016' ? "selected" : ""?>>016</option>
								<option <?=$info['arr_phone'][0] == '017' ? "selected" : ""?>>017</option>
								<option <?=$info['arr_phone'][0] == '019' ? "selected" : ""?>>019</option>
							</select>
						</div>
					</div>
					<span class="dash">-</span>
					<div class="form-line--cols-item">
						<label for="memberInfoPhoneForm1_2"><input type="tel" class="input-text" id="memberInfoPhoneForm1_2" maxlength="4" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" value="<?=$info['arr_phone'][1]?>" name="mob_phone2"></label>
					</div>
					<span class="dash">-</span>
					<div class="form-line--cols-item">
						<label for="memberInfoPhoneForm1_3"><input type="tel" class="input-text" id="memberInfoPhoneForm1_3" maxlength="4" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" value="<?=$info['arr_phone'][2]?>" name="mob_phone3"></label>
					</div>
				</div>
			</div>
			<div class="form-line form-line--wide">
				<div class="form-line-info">
					<label><input type="text" class="input-text" value="<?=@$info['EMAIL']?>" disabled></label>
				</div>
			</div>
            <div class="form-line form-line--modify">
                <p class="form-line-title option">성별</p>
                <div class="form-line-info option-area">
                    <label class="common-radio-label" for="joinGenderCheck1">
                        <input type="radio" id="joinGenderCheck1" class="common-radio-btn" name="mem_gender" value="MALE" <?if($info['GENDER_GB_CD']=='MALE'){?>checked<?}?>>
                        <span class="common-radio-text">남자</span>
                    </label>
                    <label class="common-radio-label" for="joinGenderCheck2">
                        <input type="radio" id="joinGenderCheck2" class="common-radio-btn" name="mem_gender" value="FEMALE" <?if($info['GENDER_GB_CD']=='FEMALE'){?>checked<?}?>>
                        <span class="common-radio-text">여자</span>
                    </label>
                    <!-- <div class="use-agree-box">
                        <input type="checkbox" id="joincheckAgree6" class="checkbox">
                        <label for="joincheckAgree6" class="checkbox-label">수집 및 이용동의</label>
                    </div> -->
                </div>
            </div>
            <div class="form-line form-line--modify">
                <p class="form-line-title option">반려동물 유무</p>
                <div class="form-line-info option-area">
                    <label class="common-radio-label" for="joinPetCheck1">
                        <input type="radio" id="joinPetCheck1" class="common-radio-btn" name="petYn" value="Y" <?if($info['PET_YN']=='Y'){?>checked<?}?>>
                        <span class="common-radio-text">있음</span>
                    </label>
                    <label class="common-radio-label" for="joinPetCheck2">
                        <input type="radio" id="joinPetCheck2" class="common-radio-btn" name="petYn" value="N" <?if($info['PET_YN']=='N'){?>checked<?}?>>
                        <span class="common-radio-text">없음</span>
                    </label>
                </div>
            </div>
            <div class="form-line form-line--modify">
                <p class="form-line-title option">결혼 유무</p>
                <div class="form-line-info option-area">
                    <label class="common-radio-label" for="joinMarriageCheck1">
                        <input type="radio" id="joinMarriageCheck1" class="common-radio-btn" name="merry" value="Y" <?if($info['MERRY_YN']=='Y'){?>checked<?}?>>
                        <span class="common-radio-text">예</span>
                    </label>
                    <label class="common-radio-label" for="joinMarriageCheck2">
                        <input type="radio" id="joinMarriageCheck2" class="common-radio-btn" name="merry" value="N" <?if($info['MERRY_YN']=='N'){?>checked<?}?>>
                        <span class="common-radio-text">아니오</span>
                    </label>
                </div>
            </div>
            <div class="form-line form-line--modify">
                <p class="form-line-title option">추천인</p>
                <div class="form-line-info option-area">
                    <div class="form-line-info form-line-info--check">
                        <input type="hidden" id="chk_rcmdId" name="chk_rcmdId" value="<?=$info['RCMD_ID']?>" />
                        <input type="text" id="rcmdID" class="input-text input-text-join-info input-text--modify" value="<?=$info['RCMD_ID']?>" <?if($info['RCMD_ID']!=''){?>readonly disabled<?}?>>
                        <button type="button" class="btn-gray" style="width: 70px;" <?if($info['RCMD_ID']==''){?>onclick="jsRecommendId($('#rcmdID').val())"<?}?>>ID 확인</button>
                    </div>
                </div>
            </div>
		</div>

		<div class="agree-info-area-box agree-info-area-box--top">
			<span class="agree-info-txt">SMS 수신동의</span>
			<div class="form-line-info agree-info-area agree-info-area--modify">
				<label class="common-radio-label" for="memberInfoCheckForm1">
					<input type="radio" id="memberInfoCheckForm1" class="common-radio-btn" name="sns" <?=$info['MOB_REC_YN'] == 'Y' ? "checked='checked'" : ""?> value="Y">
					<span class="common-radio-text">동의</span>
				</label>
				<label class="common-radio-label" for="memberInfoCheckForm2">
					<input type="radio" id="memberInfoCheckForm2" class="common-radio-btn"  name="sns" <?=$info['MOB_REC_YN'] == 'N' ? "checked='checked'" : ""?> value="N" >
					<span class="common-radio-text">동의안함</span>
				</label>
			</div>
		</div>
		<div class="agree-info-area-box">
			<span class="agree-info-txt">이메일 수신동의</span>
			<div class="form-line-info agree-info-area agree-info-area--modify">
				<label class="common-radio-label" for="memberInfoCheckForm3">
					<input type="radio" id="memberInfoCheckForm3" class="common-radio-btn" name="email" <?=$info['EMAIL_REC_YN'] == 'Y' ? "checked='checked'" : ""?> value="Y">
					<span class="common-radio-text">동의</span>
				</label>
				<label class="common-radio-label" for="memberInfoCheckForm4">
					<input type="radio" id="memberInfoCheckForm4" class="common-radio-btn" name="email" <?=$info['EMAIL_REC_YN'] == 'N' ? "checked='checked'" : ""?> value="N">
					<span class="common-radio-text">동의안함</span>
				</label>
			</div>
		</div>
		</form>
		<ul class="common-btn-box">
			<li class="common-btn-item"><a href="#" class="btn-white btn-white--big" onClick="window.location.href='/mywiz/check_password/MI';">수정취소</a></li>
			<li class="common-btn-item"><a href="#" class="btn-black btn-black--big" onClick="javaScript:modifyMyinfo();">정보수정</a></li>
		</ul>
	</div>


<script type="text/javaScript">

//====================================
//trim 함수 생성
//====================================
function trim(s){
	s = s.replace(/^\s*/,'').replace(/\s*$/,'');
	return s;
}

//===============================================================
// 추천인 ID 확인
//===============================================================
function jsRecommendId(val)
{
    var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";

    if(val == '') {
        alert('추천인 ID를 입력해주세요.');
        $('#rcmdID').focus();
        return false;
    }

    if(val == infoForm.member_id.value){
        alert('본인 ID를 추천인 ID에 입력할 수 없습니다.');
        $('#rcmdID').focus();
        return false;
    }

    $.ajax({
        type: 'POST',
        url: 'https://'+SSL_val+'/member/rcmd_id_check',
        dataType: 'json',
        data: { 'rcmd_id' : val },
        error: function(res) {
            alert('Database Error');
        },
        success: function(res) {
            if(res.status == 'ok'){
                $('input[name=chk_rcmdId]').val(res.rcmd_id);
                alert('사용 가능한 아이디입니다.');
            }
            else {
                alert(res.message);
            }

        }
    })
}

//====================================
// 정보수정
//====================================
function modifyMyinfo()
{
	if(infoForm.member_pw.value == ''){
		alert("비밀번호를 입력해주세요.");
		infoForm.member_pw.focus();
		return false;
	}
	if(infoForm.member_pw.value.length < 8 || infoForm.member_pw.value.length > 16 ){
		alert("비밀번호는 8자리 이상 16자리 이하로 입력하셔야 합니다.");
		infoForm.member_pw.focus();
		return false;
	}
	if (f_is_alpha(infoForm.member_pw)){
		alert("비밀번호는 영소문자와 숫자로만 구성됩니다.");
		infoForm.member_pw.value = "";
		infoForm.member_pw.focus();
		return false;
	}
	if(infoForm.member_pw2.value == ''){
		alert("비밀번호 확인을 입력해주세요.");
		infoForm.member_pw2.focus();
		return false;
	}
	if(infoForm.member_pw.value != infoForm.member_pw2.value){
		alert("비밀번호와 비밀번호 확인이 다릅니다.");
		infoForm.member_pw2.focus();
		return false;
	}
	if(!trim(infoForm.mob_phone2.value) || !trim(infoForm.mob_phone3.value)){
		if(!trim(infoForm.mob_phone2.value)){
			alert("휴대전화의 국번을 입력해주세요.");
			infoForm.mob_phone2.focus();
			return false;
		}
		if(infoForm.mob_phone2.value.length < 3){
			alert("휴대전화의 국번은 3자리 이상이어야 합니다.");
			infoForm.mob_phone2.focus();
			return false;
		}
		if(!trim(infoForm.mob_phone3.value)){
			alert("휴대전화의 뒷자리를 입력해주세요.");
			infoForm.mob_phone3.focus();
			return false;
		}

		if(infoForm.mob_phone3.value.length < 4){
			alert("휴대전화의 뒷자리는 4자리 이상이어야 합니다.");
			infoForm.mob_phone3.focus();
			return false;
		}

	}

	if(!trim(infoForm.member_birth.value)){
		alert("생년월일을 입력해주세요.");
		infoForm.member_birth1.focus();
		return false;
	}

    if(infoForm.rcmdID.value != "" && infoForm.chk_rcmdId.value == ""){
        alert("추천인 ID 확인을 해주셔야 합니다.");
        infoForm.rcmdID.focus();
        return false;
    }

//				var	stringRegx = /[~!@\#$% <>^&*\()\-=+_\’]/gi;
//				if( stringRegx.test(infoForm.member_name.value) )

	if(confirm("수정하시겠습니까?")){
		var data = $("#infoForm").serialize();
		$.ajax({
			type: 'POST',
			url: '/mywiz/myinfo',
			dataType: 'json',
			data: data,
			error: function(res) {
				alert('Database Error');
			},
			success: function(res) {
				if(res.status == 'ok'){
						alert("수정되었습니다.");
						location.href='/mywiz/myinfo_fin';
				}
				else console.log(res.message);
			}
		});
	}
}

//====================================
//패스워드검사,이메일
//====================================
function f_is_alpha( it ){

	//영문 숫자 조합
	var alpha ='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	var numeric = '1234567890';
	var blank = ' ';
	var nonkorean = alpha+numeric;
	var i ;
	var t = it.value ;
	for ( i=0; i<t.length; i++ )

		if( nonkorean.indexOf(t.substring(i,i+1)) < 0) {
			break ;
		}

	if ( i != t.length ) {
		return true;
	}

	return false;
}


</script>