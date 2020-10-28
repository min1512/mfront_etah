<link rel="stylesheet" href="/assets/css/mypage.css">

<div class="content">
    <h2 class="page-title-basic page-title-basic--line">회원정보</h2>
    <div class="mypage-member-info-wrap">
        <h3 class="info-title info-title--sub">간편로그인 연동하기</h3>
        <form method="post" name="mainform" id="mainform">
            <div class="mypage-info-section mypage-info-section--bg">
                <?if($result == 'Success'){?>
                    <h3 align="center">연동되었습니다.</h3>
                <?}else{?>
                    <h3 align="center">연동에 실패했습니다.</h3>
                <?}?>

            </div>
        </form>

        <ul class="common-btn-box">
            <li class="common-btn-item"><a href="/" class="btn-white btn-white--big">홈으로</a></li>
            <li class="common-btn-item"><a href="/mywiz" class="btn-black btn-black--big">마이페이지</a></li>
        </ul>
    </div>