<link rel="stylesheet" href="/assets/css/member.css">

<div class="content">
    <h2 class="page-title-basic page-title-basic--line">MEMBERSHIP</h2>
    <div class="member-join-main-wrap">
        <form method="post" name="mainform" id="mainform">
            <input type="hidden" id="sns_id" name="sns_id" value="" />
            <input type="hidden" id="return_url" name="return_url" value="<?=$returnUrl?>">
            <div class="member-join-main">
                <p class="join-main-txt">
                    에타홈몰에 오신 것을 환영합니다
                </p>
                <p class="join-main-txt-sub">신규회원 가입은 문자인증 혹은<br>SNS계정으로 가입할 수 있습니다.</p>
            </div>
            <div class="common-btn-box2">
                <a href="https://<?=$_SERVER['HTTP_HOST']?>/member/member_join" class="btn-black btn-black--big">에타홈 회원가입</a>
                <a href="/" class="btn-white btn-white--big">홈으로</a>
            </div>

            <!-- SNS로그인 -->
            <div class="sns-login-wrap">
                <div class="sns-btn-box">
                    <a href="#" target="_blank"  class="btn_sns naver" onclick="javascript:loginWithNaver();return false">네이버ID 회원가입</a>
                    <a href="#" class="btn_sns kakao" onclick="javascript:loginWithKakao();return false">카카오ID 회원가입</a>
                    <a type="button" class="btn_sns wemap" onclick="javascript:loginWithWemap();return false">위메프ID 회원가입</a>
                </div>
            </div>
            <!-- SNS로그인 -->
        </form>
    </div>
</div>

<script>
    //===============================================================
    // 카카오 회원가입
    //===============================================================
    function loginWithKakao(){
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
        window.open("https://"+SSL_val+"/member/kakao_login","login-naver","width=464, height=618, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
    }

    //===============================================================
    // 네이버 회원가입
    //===============================================================
    function loginWithNaver(){
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
        window.open("https://"+SSL_val+"/member/naver_login","login-naver","width=600, height=600, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
    }

    //===============================================================
    // 위메프 회원가입
    //===============================================================
    function loginWithWemap(){
        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
        window.open("https://"+SSL_val+"/member/wemap_login","login-wemap","width=600, height=600, status=yes, resizable=yes, scrollbars=yes,top=0,left=0");
    }


    $(function(){
        if($.cookie('saveid')) $("input:checkbox[id='formIdSave']").attr("checked", true); $("input[name=mem_id]").val($.cookie('saveid'));
    })
</script>