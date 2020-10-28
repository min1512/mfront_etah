<link rel="stylesheet" href="/assets/css/mypage.css">

<div class="content">
	<h2 class="page-title-basic page-title-basic--line">회원정보</h2>
	<div class="mypage-member-info-wrap">
		<h3 class="info-title info-title--sub"><?=$title?></h3>
		<div class="mypage-info-section mypage-info-section--bg">
			<div class="form-line form-line--wide">
				<div class="form-line-info">
					<label><input type="password" id="formPassword" class="input-text" placeholder="비밀번호" onkeypress="javascript:if(event.keyCode == 13){ check_password(''); return false;}" ></label>
				</div>
			</div>
			<span class="ico-i">i</span>
			<span class="mypage-info-section-text">회원님의 개인정보 보호를 위해 비밀번호를 다시 한번 입력해 주시기 바랍니다.</span>

			<ul class="common-btn-box common-btn-box--modify">
				<li class="common-btn-item"><a href="#" onClick="javascript:check_password();" class="btn-gray btn-gray--big">비밀번호확인</a></li>
			</ul>
		</div>
	</div>

<script type="text/javaScript">
//====================================
// 회원로그인
//====================================
function check_password()
{
	var password = $("#formPassword").val()
		, type = "<?=$nav?>";

	switch(type){
		case 'D' : url = '/mywiz/delivery';	break;
		case 'MI' : url = '/mywiz/myinfo';	break;
		case 'ML' : url = '/member/leave';	break;
        case 'MS' : url = '/mywiz/sns'; break;
	}

	$.ajax({
		type: 'POST',
		url: '/mywiz/check_password',
		dataType: 'json',
		data: { password : password },
		error : function(res) {
			alert('Database Error');
		},
		success: function(res) {
			if(res.status == 'ok'){
				location.href = url;
			}
			else{
				alert(res.message);
				$("#formPassword").focus();
			}
		}
	})

	return true;
}
</script>