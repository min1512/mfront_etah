<link rel="stylesheet" href="/assets/css/display.css?ver=1.4">

<div class="content mainsub_category" id="category-main">
    <!-- top-location -->
    <div class="page-title-box page-title-box--location">
        <div class="page-title">
            <ul class="page-title-list">
                <li class="page-title-item"><a href="/">홈</a></li>
                <li class="page-title-item active">컨텐츠</li> <!-- 퐐성화시 클래스 active추가 -->
            </ul>
        </div>
    </div>
    <!-- //top-location -->

    <!-- 필터 -->
    <div class="filter-list">
        <div class="filter-inner">
            <div class="filter-item filter-option1">
                <a href="#filterOptionBtn" class="filter-btn btn-gnb-open category-btn" data-ui="filter-btn">카테고리</a>
            </div>

            <div class="filter-item filter-check">
                <a href="#filterOptionBtn" class="filter-btn btn-gnb-open" data-ui="filter-btn"><span class="spr-common spr-ico-filter"></span>상세검색</a>
            </div>
        </div>
    </div>
    <div class="filter-gnb-list">

        <aside class="filter-gnb" style="margin-right: -300px;">
            <form>
                <p class="filter-gnb-tit">상세검색</p>
                <button type="button" class="btn-close lg-w pop-close">close</button>
                <!-- member -->

                <!-- logined -->
                <div class="filter-search">
                    <p class="search-result">검색결과 <!--<span>247</span>개--></p>
                    <input type="reset" class="btn-reset">
                </div>

                <!-- logined -->
                <!-- //member -->

                <!-- nav -->
                <nav>
                    <!-- 카테고리 필터 -->
                    <div class="option_button position_area srp_option_area">
                        <div class="position_left">
                            <div class="select_wrap select_wrap_cate">
                                <h4 class="srp-cate-tit srp-cate-tit2">카테고리</h4>
                                <ul id="srp-cate" class="srp-cate2">
                                    <?foreach($arr_cate1 as $c1){
                                        if($c1['CODE']=='90000000') {?>
                                            <li <?=($cate_gb=='M'?$cur_category[0]['CATEGORY_CD2']:$cur_category[0]['CATEGORY_CD1'])==$c1['CODE']?'class="on"':''?>><a href="/magazine/list?cate_cd=<?=$c1['CODE']?>&cate_gb=M"><?=$c1['NAME']?></a>
                                            </li>
                                        <?} else {?>
                                            <li <?=($cate_gb=='M'?$cur_category[0]['CATEGORY_CD2']:$cur_category[0]['CATEGORY_CD1'])==$c1['CODE']?'class="on"':''?>><a href="#none"><?=$c1['NAME']?></a>
                                                <ul <?=($cate_gb=='M'?$cur_category[0]['CATEGORY_CD2']:$cur_category[0]['CATEGORY_CD1'])==$c1['CODE']?'style="display:block"':''?>>
                                                    <?foreach($arr_cate2 as $c2){
                                                        if( $c2['PARENT_CODE']==$c1['CODE'] ){?>
                                                        <li <?=($cate_gb=='S' && $cur_category[0]['CATEGORY_CD2']==$c2['CODE'])?'class="on"':''?>><a href="/magazine/list?cate_cd=<?=$c2['CODE']?>&cate_gb=S"><?=$c2['NAME']?></a>
                                                        </li>
                                                    <?}
                                                    }?>
                                                </ul>
                                            </li>
                                        <?}
                                    }?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- //카테고리 필터 -->

                    <!-- //shoping guide -->
                    <div class="confirm">
                        <button class="confirm">확인</button>
                    </div>
                </nav>
                <!-- //nav -->
            </form>
        </aside>

    </div>
    <!-- // 필터 -->

    <div class="magazine_list_wrap">
        <div class="magazine-list">
            <div class="ma_box">
                <h3 class="title-style">홈족피디아 <span class="title-style-sub">이거 알고 있었어?</span>
                </h3>
                <a href="/magazine/list?cate_cd=40000000&cate_gb=M" class="btn-more">
                    <span>more</span>
                </a>
                <div class="prds-list">
                    <ul>
                        <?foreach ($homejok as $hrow){?>
                            <li>
                                <a href="/magazine/detail/<?=$hrow['MAGAZINE_NO']?>">
                                    <div class="pic">
                                        <div class="item auto-img">
                                            <div class="img">
                                                <img src="<?=$hrow['MOB_IMG_URL']?>" alt="<?=$hrow['TITLE']?>"/>
                                            </div>
                                        </div>
                                        <div class="layer"></div>
                                        <div class="status">
                                            <span class="like"><?=$hrow['LOVE']?></span>
                                            <span class="share"><?=$hrow['SHARE']?></span>
                                            <span class="view">조회 <?=$hrow['HITS']?></span>
                                        </div>
                                        <?if(isset($hrow['END_DT']) && ($hrow['END_DT']<date("Y-m-d H:i:s"))){?>
                                            <div class="pic_slodout" style="background-color: rgba(0,0,0,0.4);">
                                                <p style="font-size: 20px;color: #E4E4E4;">SOLD OUT</p>
                                            </div>
                                        <?}?>
                                    </div>
                                    <div class="txt">
                                        <p class="nm_txt"><?=$hrow['TITLE']?></p>
                                    </div>
                                </a>
                            </li>
                        <?}?>
                    </ul>
                </div>
            </div>
            <div class="ma_box">
                <h3 class="title-style">트렌드매거진 <span class="title-style-sub">리빙 트렌드를 한눈에!</span>
                </h3>
                <a href="/magazine/list?cate_cd=50000000&cate_gb=M" class="btn-more">
                    <span>more</span>
                </a>
                <div class="prds-list">
                    <ul>
                        <?foreach ($trend as $trow){?>
                            <li>
                                <a href="/magazine/detail/<?=$trow['MAGAZINE_NO']?>">
                                    <div class="pic">
                                        <div class="item auto-img">
                                            <div class="img">
                                                <img src="<?=$trow['MOB_IMG_URL']?>" alt="<?=$trow['TITLE']?>"/>
                                            </div>
                                        </div>
                                        <div class="layer"></div>
                                        <div class="status">
                                            <span class="like"><?=$trow['LOVE']?></span>
                                            <span class="share"><?=$trow['SHARE']?></span>
                                            <span class="view">조회 <?=$trow['HITS']?></span>
                                        </div>
                                    </div>
                                    <div class="txt">
                                        <p class="nm_txt"><?=$trow['TITLE']?></p>
                                    </div>
                                </a>
                            </li>
                        <?}?>
                    </ul>
                </div>
            </div>
            <div class="ma_box">
                <h3 class="title-style">에타홈클래스<span class="title-style-sub">취미생활로 워라벨라이프</span>
                </h3>
                <a href="/magazine/list?cate_cd=70000000&cate_gb=M" class="btn-more">
                    <span>more</span>
                </a>
                <div class="prds-list">
                    <ul>
                        <?foreach ($class as $crow){?>
                            <li>
                                <a href="/magazine/detail/<?=$crow['MAGAZINE_NO']?>">
                                    <div class="pic">
                                        <div class="item auto-img">
                                            <div class="img">
                                                <img src="<?=$crow['MOB_IMG_URL']?>" alt="<?=$crow['TITLE']?>"/>
                                            </div>
                                        </div>
                                        <div class="layer"></div>
                                        <div class="status">
                                            <span class="like"><?=$crow['LOVE']?></span>
                                            <span class="share"><?=$crow['SHARE']?></span>
                                            <span class="view">조회 <?=$crow['HITS']?></span>
                                        </div>
                                    </div>
                                    <div class="txt">
                                        <p class="nm_txt"><?=$crow['TITLE']?></p>
                                    </div>
                                </a>
                            </li>
                        <?}?>
                    </ul>
                </div>
            </div>
            <div class="ma_box">
                <h3 class="title-style">브랜드</h3>
                <a href="/magazine/list?cate_cd=60000000&cate_gb=M" class="btn-more">
                    <span>more</span>
                </a>
                <div class="prds-list">
                    <ul>
                        <?foreach ($brand as $brow){?>
                            <li>
                                <a href="/magazine/detail/<?=$brow['MAGAZINE_NO']?>">
                                    <div class="pic">
                                        <div class="item auto-img">
                                            <div class="img">
                                                <img src="<?=$brow['MOB_IMG_URL']?>" alt="<?=$brow['TITLE']?>"/>
                                            </div>
                                        </div>
                                        <div class="layer"></div>
                                        <div class="status">
                                            <span class="like"><?=$brow['LOVE']?></span>
                                            <span class="share"><?=$brow['SHARE']?></span>
                                            <span class="view">조회 <?=$brow['HITS']?></span>
                                        </div>
                                    </div>
                                    <div class="txt">
                                        <p class="nm_txt"><?=$brow['TITLE']?></p>
                                    </div>
                                </a>
                            </li>
                        <?}?>
                    </ul>
                </div>
            </div>
            <div class="ma_box">
                <h3 class="title-style">이벤트</h3>
                <a href="/magazine/list?cate_cd=90000000&cate_gb=M" class="btn-more">
                    <span>more</span>
                </a>
                <div class="prds-list">
                    <ul>
                        <?foreach ($event as $erow){?>
                            <li>
                                <a href="/magazine/detail/<?=$erow['MAGAZINE_NO']?>">
                                    <div class="pic">
                                        <div class="item auto-img">
                                            <div class="img">
                                                <img src="<?=$erow['MOB_IMG_URL']?>" alt="<?=$erow['TITLE']?>"/>
                                            </div>
                                        </div>
                                        <div class="layer"></div>
                                        <div class="status">
                                            <span class="like"><?=$erow['LOVE']?></span>
                                            <span class="share"><?=$erow['SHARE']?></span>
                                            <span class="view">조회 <?=$erow['HITS']?></span>
                                        </div>
                                        <?if($erow['END_DT']<date("Y-m-d H:i:s")){?>
                                            <div class="pic_slodout" style="background-color: rgba(0,0,0,0.4);">
                                                <p style="font-size: 20px;color: #E4E4E4;">이벤트 종료</p>
                                            </div>
                                        <?}?>
                                    </div>
                                    <div class="txt">
                                        <p class="nm_txt">
                                            <?if($erow['END_DT']>date("Y-m-d H:i:s")){?>
                                                [진행중]
                                            <?} else {?>
                                                [종료]
                                            <?}?>
                                            <?=$erow['TITLE']?>
                                        </p>
                                    </div>
                                </a>
                            </li>
                        <?}?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- //상품리스트-->
    </div><!--//content -->

    <script src="/assets/js/common.js?ver=1.10"></script>
    <script src="/assets/js/owl.carousel.min.js?ver=2.5"></script>

    <script type="text/javascript">
        //calculate image size
        function calcImgSize() {
            $("img", ".auto-img").each(function() {
                var $el = $(this);
                $el.parents(".img").addClass(function() {
                    var $height = $el.height();
                    var $width = $el.width();
                    if ($height > $width) return "port";
                    else return "land";
                });
            });
        };
        //이미지가 모두 로드 된 후 실행
        jQuery.event.add(window,"load",function(){
            calcImgSize();
        });
    </script>

    <script>
        /* lnb */
        (function($) {
            var lnbUI = {
                click: function(target, speed) {
                    var _self = this,
                        $target = $(target);
                    _self.speed = speed || 300;
                    $target.each(function() {
                        if (findChildren($(this))) {
                            return;
                        }
                        $(this).addClass('noDepth');
                    });

                    function findChildren(obj) {
                        return obj.find('> ul').length > 0;
                    }
                    $target.on('click', 'a', function(e) {
                        e.stopPropagation();
                        var $this = $(this),
                            $depthTarget = $this.next(),
                            $siblings = $this.parent().siblings();
                        $this.parent('li').find('ul li').removeClass('on');
                        $siblings.removeClass('on');
                        $siblings.find('ul').slideUp(250);
                        if ($depthTarget.css('display') == 'none') {
                            _self.activeOn($this);
                            $depthTarget.slideDown(_self.speed);
                        } else {
                            $depthTarget.slideUp(_self.speed);
                            _self.activeOff($this);
                        }
                    })
                },
                activeOff: function($target) {
                    $target.parent().removeClass('on');
                },
                activeOn: function($target) {
                    $target.parent().addClass('on');
                }
            }; // Call lnbUI
            $(function() {
                lnbUI.click('#srp-cate li', 300)
            });
        }(jQuery));
    </script>