<link rel="stylesheet" href="/assets/css/mypage.css">

<div class="content">
    <h2 class="page-title-basic page-title-basic--line">회원정보</h2>
    <div class="mypage-member-info-wrap">
        <h3 class="info-title info-title--sub">간편로그인 연동하기</h3>
        <form method="post" name="mainform" id="mainform">
            <div class="mypage-info-section mypage-info-section--bg">
                <p align="center">
                    <?if($sns_data == null){?>
                        <a type="button" class="btn_sns naver" onclick="javascript:loginWithNaver();return false">네이버ID 연동하기</a><br/>
                        <a type="button" class="btn_sns kakao" onclick="javascript:loginWithKakao();return false">카카오ID 연동하기</a>
                        <a type="button" class="btn_sns wemap" onclick="javascript:loginWithWemap();return false">위메프ID 연동하기</a>
                    <?}else{
                        if(strpos($sns_data,'N') !== false){?>
                            <a type="button" class="btn_sns naver">네이버ID 연동중</a><br/>
                        <?}else{?>
                            <a type="button" class="btn_sns naver" onclick="javascript:loginWithNaver();return false">네이버ID 연동하기</a><br/>
                        <?}?>
                        <?if(strpos($sns_data,'K') !== false){?>
                            <a type="button" class="btn_sns kakao">카카오ID 연동중</a>
                        <?}else{?>
                            <a type="button" class="btn_sns kakao" onclick="javascript:loginWithKakao();return false">카카오ID 연동하기</a>
                        <?}?>
                        <br/>
                        <?if(strpos($sns_data,'W') !== false){?>
                            <a type="button" class="btn_sns wemap">위메프ID 연동중</a>
                        <?}else{?>
                            <a type="button" class="btn_sns wemap" onclick="javascript:loginWithWemap();return false">위메프ID 연동하기</a>
                        <?}?>
                    <?}?>
                </p>
                <br/><br/><br/>
            </div>
        </form>
    </div>


    <script>
        //===============================================================
        // 카카오 변경
        //===============================================================
        function loginWithKakao(){
            if(confirm('연동하시겠습니까?')) {
                var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
                window.open("https://"+SSL_val+"/member/kakao_login", "login-kakao", "width=464, height=618, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
            }

            return false;
        }

        //===============================================================
        // 네이버 변경
        //===============================================================
        function loginWithNaver() {
            if(confirm('연동하시겠습니까?')) {
                var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
                window.open("https://"+SSL_val+"/member/naver_login", "login-naver", "width=600, height=600, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
            }
            return false;
        }

        //===============================================================
        // 위메프 변경
        //===============================================================
        function loginWithWemap(){
            if(confirm('연동하시겠습니까?')) {
                var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
                window.open("https://"+SSL_val+"/member/wemap_login","login-wemap","width=600, height=600, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
            }

            return false;
        }

    </script>