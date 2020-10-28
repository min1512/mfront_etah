			<link rel="stylesheet" href="/assets/css/login.css">

			<!-- 아이디찾기 // -->
			<div class="content">
				<h2 class="page-title-basic page-title-basic--line"><?=$title?></h2>
				<div class="login-wrap id-find-wrap">
					<h3 class="info-title info-title--sub">회원 가입정보로 찾기</h3>
					<?if($type == 'password'){?>
					<div class="form-line form-line--wide">
						<div class="form-line-info">
							<label><input type="text" class="input-text" id="pwdFindIdForm_1_1" placeholder="ID" name="id"></label>
						</div>
					</div>
					<?}?>
					<div class="form-line form-line--wide">
						<div class="form-line-info">
							<label><input type="text" id="formInputName" class="input-text" placeholder="이름" name="name"></label>
						</div>
					</div>
					<div class="form-line form-line--wide">
						<div class="form-line-info">
							<label><input type="text" id="formMailSelect" class="input-text" placeholder="이메일" name="email"></label>
						</div>
					</div>
					<?if($type == 'id'){?>
					<ul class="text-list">
						<li class="text-item">간편인증은 아이디의 일부가 ***로 표시됩니다.</li>
						<li class="text-item">회원정보에 등록된 이름, 이메일을 입력해주세요.</li>
					</ul>
					<? }?>
					<ul class="common-btn-box">
						<li class="common-btn-item"><a href="javaScript://" onClick="searchMember();" class="btn-gray btn-gray--big">확인</a></li>
					</ul>
				</div>
				<!-- // 아이디찾기 -->

				<form id="hidForm" name="hidForm" method="post">
					<input type="hidden" name="email">
					<input type="hidden" name="id">
					<input type="hidden" name="hid_id">
					<input type="hidden" name="reg_dt">
					<input type="hidden" name="type">
				</form>

			</div>

<script type="text/javaScript">

//====================================
// ID찾기
//====================================
function searchMember()
{
	var type = "<?=$type?>"
		, name = $("input[name=name]").val()
		, email = $("input[name=email]").val()
		, id = "";

	if(type == 'password') id = $("input[name=id]").val();
	$.ajax({
		type: 'POST',
		url: '/member/search_member',
		dataType: 'json',
		data: { name : name , email : email, id : id, type: type},
		error : function(res) {
			alert('Database Error');
			alert(res.responseText);
		},
		success: function(res) {
			if(res.status == 'ok'){
//							location.href="/member/id_search_finish?name="+name+"&email="+email;
//							alert(res.member);
				$("input[name=id]").val(res.member['CUST_ID']);
				$("input[name=email]").val(res.member['EMAIL']);
				$("input[name=hid_id]").val(res.member['ID']);
				$("input[name=reg_dt]").val(res.member['REG_DT']);
				$("input[name=type]").val(type);

				var v = document.hidForm;
				v.target = "_self";
				v.action = "/member/search_finish";
				v.submit();
			}
			else {
				alert(res.message);
			}
		}
	})
}

</script>