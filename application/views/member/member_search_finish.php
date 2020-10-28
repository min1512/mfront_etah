			<link rel="stylesheet" href="/assets/css/login.css">

			<?if($member['type'] == 'id'){?>
			<!-- 아이디찾기 // -->
			<div class="content">
				<h2 class="page-title-basic page-title-basic--line">아이디찾기</h2>
				<div class="common-complete-wrap common-complete-wrap--id-search">
					<div class="payment-complete-result">
						<p class="complete-result-txt">아이디 찾기 완료되었습니다.</p>
						<p class="complete-result-txt-sub">아이디 찾기 결과 고객님의 아이디 정보는 아래와 같습니다.</p>
						<p class="complete-result-info">아이디 <strong class="info-bold"><?=$member['hid_id']?></strong>입니다.<span class="complete-result-info-date">(<?=substr($member['reg_dt'],0,10)?> 가입)</span></p>

					</div>
					<ul class="common-btn-box">
						<li class="common-btn-item"><a href="/member/password_search" class="btn-white btn-white--big">비밀번호 찾기</a></li>
						<li class="common-btn-item"><a href="/member/login" class="btn-black btn-black--big">로그인</a></li>
					</ul>
				</div>
				<!-- // 아이디찾기 -->
			</div>

			<? } else{ ?>

			<!-- 비밀번호찾기 // -->
			<div class="content">
				<h2 class="page-title-basic page-title-basic--line">비밀번호찾기</h2>
				<div class="common-complete-wrap common-complete-wrap--pwd-search">
					<div class="payment-complete-result">
						<p class="complete-result-txt">
							<strong class="info-bold"><?=$member['email']?></strong>으로<br>임시 비밀번호를 발송하였습니다.
						</p>
						<p class="complete-result-txt-sub">임시 비밀번호로 로그인 후 마이페이지에서<br>비밀번호를 변경하여주시기 바랍니다.</p>

					</div>
					<ul class="common-btn-box">
						<li class="common-btn-item"><a href="/member/login" class="btn-black btn-black--big">로그인</a></li>
					</ul>
				</div>
				<!-- // 비밀번호찾기  -->
			</div>

			<? }?>
