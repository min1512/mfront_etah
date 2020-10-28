<link rel="stylesheet" href="/assets/css/mypage.css">


<div class="content">
	<h2 class="page-title-basic page-title-basic--line">MY PAGE</h2>

<?if($this->session->userdata('EMS_U_ID_') == 'GUEST'){?>

	<div class="mypage-info-box">
		<div class="mypage-info-profile-wrap">
			<span class="mypage-info-profile spr-common"></span>
			<span class="mypage-info-profile-txt"><strong class="info-bold"><?=$this->session->userdata('EMS_U_ID_')?></strong>님 반갑습니다.</span>
		</div>
	</div>

	<div class="mypage-box progress-order-box">
		<h3 class="info-title info-title--sub">진행중인 주문</h3>
		<ul class="progress-order-list">
			<li class="progress-order-item <?=(@$order_state1['pCD']=='OA00'||@$order_state1['pCD']=='OA01'||@$order_state1['pCD']=='OA02')?'active':''?>">
				<span class="progress-order-item-ico ico-wait spr-common"></span>
				<span class="progress-order-item-txt">입금대기중</span>
			</li>
			<!-- 활성화 클래스 active 추가 -->
			<li class="progress-order-item <?=(@$order_state1['pCD']=='OA03')?'active':''?>">
				<span class="progress-order-item-ico ico-payment_complet spr-common"></span>
				<span class="progress-order-item-txt">결제완료</span>
			</li>
			<li class="progress-order-item <?=(@$order_state1['pCD']=='OB01'||@$order_state1['pCD']=='OB02'||@$order_state1['pCD']=='OB03')?'active':''?>">
				<span class="progress-order-item-ico ico-prepare spr-common"></span>
				<span class="progress-order-item-txt">배송준비중</span>
			</li>
			<li class="progress-order-item <?=(@$order_state1['pCD']=='OE01')?'active':''?>">
				<span class="progress-order-item-ico ico-delivery spr-common"></span>
				<span class="progress-order-item-txt">배송중</span>
			</li>
			<li class="progress-order-item <?=(@$order_state1['pCD']=='OE02')?'active':''?>">
				<span class="progress-order-item-ico ico-complet spr-common"></span>
				<span class="progress-order-item-txt">배송완료</span>
			</li>
		</ul>
	</div>

	<!-- 나의 쇼핑내역 // -->
	<div class="mypage-box">
		<h3 class="info-title info-title--sub">나의 쇼핑내역</h3>
		<ul class="common-history-list">
			<li class="common-history-item">
				<a href="/mywiz/order" class="common-history-link">주문&#47;배송조회 (<strong class="mypage-num-info"><?=@$order_state['A']?></strong>건)</a>
			</li>
		</ul>
	</div>
	<!-- // 나의 쇼핑내역 -->

<?} else {?>

	<div class="mypage-info-box">
		<div class="mypage-info-profile-wrap">
			<span class="mypage-info-profile spr-common"></span>
			<span class="mypage-info-profile-txt"><strong class="info-bold"><?=$this->session->userdata('EMS_U_ID_')?></strong>님 반갑습니다.</span>
		</div>
		<ul class="mypage-benefit-list">
			<li class="mypage-benefit-item">
				<a href="/mywiz/coupon">
					<div class="mypage-benefit-ico">
						<span class="mypage-benefit-coupon spr-common"></span>
						<span class="mypage-benefit-coupon-txt">쿠폰</span>
					</div>
					<span class="mypage-benefit-txt"><strong class="mypage-num-info mypage-num-info--big"><?=@$mycoupon_cnt?></strong> 장</span>
				</a>

			</li>
			<li class="mypage-benefit-item">
				<a href="/mywiz/mileage">
					<span class="mypage-benefit-ico mypage-benefit-mileage spr-common"></span>
					<span class="mypage-benefit-txt"><strong class="mypage-num-info"><?=number_format(@$mileage)?></strong> 마일</span>
				</a>
			</li>
		</ul>
	</div>

	<div class="mypage-box progress-order-box">
		<h3 class="info-title info-title--sub">진행중인 주문</h3>
		<ul class="progress-order-list">
			<li class="progress-order-item <?=(@$order_state1['pCD']=='OA00'||@$order_state1['pCD']=='OA01'||@$order_state1['pCD']=='OA02')?'active':''?>">
				<span class="progress-order-item-ico ico-wait spr-common"></span>
				<span class="progress-order-item-txt">입금대기중</span>
			</li>
			<!-- 활성화 클래스 active 추가 -->
			<li class="progress-order-item <?=(@$order_state1['pCD']=='OA03')?'active':''?>">
				<span class="progress-order-item-ico ico-payment_complet spr-common"></span>
				<span class="progress-order-item-txt">결제완료</span>
			</li>
			<li class="progress-order-item <?=(@$order_state1['pCD']=='OB01'||@$order_state1['pCD']=='OB02'||@$order_state1['pCD']=='OB03')?'active':''?>">
				<span class="progress-order-item-ico ico-prepare spr-common"></span>
				<span class="progress-order-item-txt">배송준비중</span>
			</li>
			<li class="progress-order-item <?=(@$order_state1['pCD']=='OE01')?'active':''?>">
				<span class="progress-order-item-ico ico-delivery spr-common"></span>
				<span class="progress-order-item-txt">배송중</span>
			</li>
			<li class="progress-order-item <?=(@$order_state1['pCD']=='OE02')?'active':''?>">
				<span class="progress-order-item-ico ico-complet spr-common"></span>
				<span class="progress-order-item-txt">배송완료</span>
			</li>
		</ul>
	</div>

	<!-- 나의 쇼핑내역 // -->
	<div class="mypage-box">
		<h3 class="info-title info-title--sub">나의 쇼핑내역</h3>
		<ul class="common-history-list">
			<li class="common-history-item">
				<a href="/mywiz/order" class="common-history-link">주문&#47;배송조회 (<strong class="mypage-num-info"><?=@$order_state['A']?></strong>건)</a>
			</li>
			<li class="common-history-item">
				<a href="/mywiz/cancel_return" class="common-history-link">취소&#47;반품 (<strong class="mypage-num-info"><?=@$order_state['F']?></strong>건)</a>
			</li>
		</ul>
	</div>
	<!-- // 나의 쇼핑내역 -->

	<!-- 나의 관심목록 // -->
	<div class="mypage-box">
		<h3 class="info-title info-title--sub">나의 관심목록</h3>
		<ul class="common-history-list">
			<li class="common-history-item">
				<a href="/mywiz/view_goods" class="common-history-link">최근 본 상품</a>
			</li>
			<li class="common-history-item">
				<a href="/mywiz/interest" class="common-history-link">관심상품</a>
			</li>
			<li class="common-history-item">
				<a href="/cart" class="common-history-link">장바구니</a>
			</li>
		</ul>
	</div>
	<!-- // 나의 관심목록 -->

	<!-- 나의 혜택관리 // -->
	<div class="mypage-box">
		<h3 class="info-title info-title--sub">나의 혜택관리</h3>
		<ul class="common-history-list">
			<li class="common-history-item">
				<a href="/mywiz/mileage" class="common-history-link">마일리지</a>
			</li>
			<li class="common-history-item">
				<a href="/mywiz/coupon" class="common-history-link">쿠폰현황</a>
			</li>
		</ul>
	</div>
	<!-- // 나의 혜택관리 -->

	<!-- 활동 및 문의 // -->
	<div class="mypage-box">
		<h3 class="info-title info-title--sub">활동 및 문의</h3>
		<ul class="common-history-list">
			<li class="common-history-item">
				<a href="/mywiz/qna" class="common-history-link">1:1 문의</a>
			</li>
			<li class="common-history-item">
				<a href="/mywiz/goods_qna" class="common-history-link">나의 상품 Q&amp;A</a>
			</li>
			<li class="common-history-item">
				<a href="mywiz/goods_comment" class="common-history-link">상품평</a>
			</li>
		</ul>
	</div>
	<!-- // 활동 및 문의 -->

	<!-- 회원정보 // -->
	<div class="mypage-box">
		<h3 class="info-title info-title--sub">회원정보</h3>
        <ul class="common-history-list">
            <li class="common-history-item">
                <?if($this->session->userdata('EMS_U_SNS') == 'Y' && empty($this->session->userdata('EMS_U_PWD_'))){?>
                    <a href="/mywiz/delivery" class="common-history-link">배송지 관리</a>
                <?}else{?>
                    <a href="/mywiz/check_password/D" class="common-history-link">배송지 관리</a>
                <?}?>
            </li>
            <li class="common-history-item">
                <?if($this->session->userdata('EMS_U_SNS') == 'Y' && empty($this->session->userdata('EMS_U_PWD_'))){?>
                    <a href="/mywiz/myinfo" class="common-history-link">개인정보 수정</a>
                <?}else{?>
                    <a href="/mywiz/check_password/MI" class="common-history-link">개인정보 수정</a>
                <?}?>
            </li>
            <li class="common-history-item">
                <?if($this->session->userdata('EMS_U_SNS') == 'Y' && empty($this->session->userdata('EMS_U_PWD_'))){?>
                    <a href="https://<?=$_SERVER['HTTP_HOST']?>/member/leave" class="common-history-link">회원탈퇴</a>
                <?}else{?>
                    <a href="https://<?=$_SERVER['HTTP_HOST']?>/mywiz/check_password/ML" class="common-history-link">회원탈퇴</a>
                <?}?>
            </li>
            <li class="common-history-item">
                <?if($this->session->userdata('EMS_U_SNS') == 'Y' && empty($this->session->userdata('EMS_U_PWD_'))){?>
                    <a href="https://<?=$_SERVER['HTTP_HOST']?>/mywiz/sns" class="common-history-link">간편로그인 연동</a>
                <?}else{?>
                    <a href="https://<?=$_SERVER['HTTP_HOST']?>/mywiz/check_password/MS" class="common-history-link">간편로그인 연동</a>
                <?}?>
            </li>
        </ul>
	</div>
	<!-- // 회원정보 -->

<?}?>