<script src="/assets/js2/clipboard.min.js"></script>

<!-- 공유하기 레이어 // -->
<div class="layer-wrap layer-sns-share" id="layerSnsShare">
    <div class="layer-inner">
        <h1 class="layer-title">공유하기</h1>
        <div class="layer-content">
            <ul class="layer-sns-list">
                <li class="layer-sns-item">
                    <a href="javaScript:;" id="kakao-link-btn" onClick="javaScript:share_sns('T','<?=$code?>','<?=$img?>', '<?=$name?>', '<?=$addInfo?>');" class="layer-sns-link"><span class="spr-layer layer-sns-kakaotalk"></span>카카오톡</a>
                </li>
                <li class="layer-sns-item">
                    <a href="javaScript:;" onClick="javaScript:share_sns('F','<?=$code?>','<?=$img?>', '<?=$name?>');" class="layer-sns-link"><span class="spr-layer layer-sns-facebook"></span>페이스북</a>
                </li>
                <li class="layer-sns-item">
                    <a href="javaScript:;" onClick="javaScript:share_sns('K','<?=$code?>','<?=$img?>', '<?=$name?>');" class="layer-sns-link"><span class="spr-layer layer-sns-kakaostory" ></span>카카오스토리</a>
                </li>
            </ul>
            <input type="text" value="" id="url" style="opacity: 0;">
            <a href="javaScript://" class="btn-layer-url-copy" id="copyURL" data-clipboard-text="<?=$_SERVER['HTTP_REFERER']?>">URL 복사하기</a>
        </div>
        <a href="javaScript:;" class="btn-layer-close" onClick="javaScript:document.getElementById('layerSnsShare').className = 'layer-wrap layer-sns-share'; $('#wrap').removeClass('layer-open');"><span class="hide">닫기</span></a>
    </div>
</div>


<!-- // 공유하기 레이어 -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>

<script>
    //=====================================
    // 링크 복사하기
    //=====================================
    var copyURL = document.getElementById('copyURL');
    var clipboard = new Clipboard(copyURL);
    clipboard.on('success', function(e) {
        alert("URL이 복사되었습니다.");
        console.log(e);
    });
    clipboard.on('error', function(e) {
        console.log(e);
    });
</script>



<script>
    //=====================================
    // 공유하기
    //=====================================
    function share_sns(mode, code, img, name, addInfo){
        <?if($gubun == 'G'){?>
        var url = '<?=base_url()?>goods/detail/'+code;
        <?} else if($gubun == 'M'){?>
        var url = '<?=base_url()?>magazine/detail/'+code;
        <?}?>

        //페이스북
        if(mode == 'F'){
//						$('#ftest').append("<meta id='web_title' property='og:title' content='"+title+"' />");
////						$('#web_image').attr("content",img);
////						$('#web_desc').attr("content",title);
////						alert($('meta[property="og:description"]').attr("content"));
//						alert(title);
//						alert($('#web_title').attr('content'));
//						window.open("http://www.facebook.com/sharer/sharer.php?u="+url+"&t="+title,"","width=550, height=300, status=yes, resizable=no, scrollbars=no");
            window.open('/goods/share_facebook?title='+name+'&img='+img+'&goods_code='+code+'&url='+url,"","width=550, height=300, status=yes, resizable=yes, scrollbars=no");
        }
        //카카오톡
        else if(mode == 'T'){
            shareKaKaoTalk('<?=$gubun?>', code, img, name, addInfo);
        }
        //카카오스토리
        else if(mode == 'K'){
//						shareStory(url,encodeURIComponent(title));
            shareStory(url,name);
        }
        //핀터레스트
        else if(mode == 'P'){
            window.open("http://www.pinterest.com/pin/create/button/?url="+url+"&media="+img+"&description="+"[ETAHOME] "+encodeURIComponent(name),"","width=800, height=300, status=yes, resizable=no, scrollbars=no");
        }
    }

    //=====================================
    // 카카오스토리 공유하기
    //=====================================
    function shareStory(url, text) {
        Kakao.Story.share({
            url: url,
            text: text
        });
    }

    //=====================================
    // 카카오톡 공유하기
    //=====================================
    Kakao.init('a05f67602dc7a0ac2ef1a72c27e5f706');

    //카카오톡 공유하기
    function shareKaKaoTalk(gubun, code, img, name, addInfo) {
        //상품공유
        if(gubun == 'G') {
            var string = addInfo;
            var price = string.split("|");

            var discountPrice = parseInt(price[0]);
            var regularPrice = parseInt(price[1]);
            var discountRate = parseInt(price[2]);

            Kakao.Link.sendDefault({
                objectType: 'commerce',
                content: {
                    title: name,
                    imageUrl: img,
                    link: {
                        mobileWebUrl: '<?=base_url()?>goods/detail/'+code,
                        webUrl: '<?=base_url()?>goods/detail/'+code
                    }
                },
                commerce: {
                    regularPrice: regularPrice,
                    discountPrice: discountPrice,
                    discountRate: discountRate
                },
                buttons: [
                    {
                        title: '구매하기',
                        link: {
                            mobileWebUrl: '<?=base_url()?>goods/detail/'+code,
                            webUrl: '<?=base_url()?>goods/detail/'+code
                        }
                    }
                ]
            });
        }
        //매거진 공유
        if(gubun == 'M') {
            Kakao.Link.createDefaultButton({
                container: '#kakao-link-btn',
                objectType: 'feed',
                content: {
                    title: name,
                    imageUrl: img,
                    link: {
                        mobileWebUrl: '<?=base_url()?>magazine/detail/'+code,
                        webUrl: '<?=base_url()?>magazine/detail/'+code
                    }
                },
                buttons: [
                    {
                        title: '자세히 보기',
                        link: {
                            mobileWebUrl: '<?=base_url()?>magazine/detail/'+code,
                            webUrl: '<?=base_url()?>magazine/detail/'+code
                        }
                    }
                ]
            });
        }

    }

</script>