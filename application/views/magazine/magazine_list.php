<link rel="stylesheet" href="/assets/css/display.css?ver=1.3">

<div class="content mainsub_category" id="category-main">
    <!-- top-location -->
    <div class="page-title-box page-title-box--location">
        <div class="page-title">
            <ul class="page-title-list">
                <?if($cate_gb=='M'){?>
                    <li class="page-title-item"><a href="/">홈</a></li>
                    <li class="page-title-item"><a href="/magazine">컨텐츠</a></li>
                    <li class="page-title-item active"><?=$cur_category[0]['CATEGORY_NM2']?></li> <!-- 퐐성화시 클래스 active추가 -->
                <?} else if($cate_gb=='S'){?>
                    <li class="page-title-item"><a href="/">홈</a></li>
                    <li class="page-title-item"><a href="/magazine">컨텐츠</a></li>
                    <li class="page-title-item"><a href="/magazine/list?cate_cd=<?=$cur_category[0]['CATEGORY_CD1']?>&cate_gb=M"><?=$cur_category[0]['CATEGORY_NM1']?></a></li> <!-- 퐐성화시 클래스 active추가 -->
                    <li class="page-title-item active"><?=$cur_category[0]['CATEGORY_NM2']?></li> <!-- 퐐성화시 클래스 active추가 -->
                <?}?>

            </ul>
        </div>
    </div>
    <!-- //top-location -->

    <!-- 필터 -->
    <div class="filter-list">
        <div class="filter-inner">
            <div class="filter-item filter-category">
                <a href="#filterOptionBtn" class="filter-btn btn-gnb-open category-btn" data-ui="filter-btn">카테고리</a>
            </div>
            <div class="filter-item filter-option">
                <a href="#filterOptionBtn" class="filter-btn btn-gnb-open ranking-btn" data-ui="filter-btn">
                    <?
                    switch($order_by){
                        case 'A': echo '최신순'; break;
                        case 'B': echo '인기순'; break;
                        case 'C': echo '진행중'; break;
                        case 'D': echo '종료'; break;
                        default:  echo '최신순'; break;
                    }
                    ?>
                </a>
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
                    <p class="search-result">검색결과 <span><?=$totalCnt?></span>개</p>
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
                            <div class="select_wrap select_wrap_cate">
                                <h4 class="srp-cate-tit srp-cate-tit1">정렬</h4>
                                <ul id="srp-cate" class="srp-cate1">
                                    <li>
                                        <a href="#none">
                                            <label class="common-radio-label" for="ranking1">
                                                <input type="radio" id="ranking1" class="common-radio-btn" name="order_by" value="B" <?=($order_by=='B')?'checked':''?>>
                                                <span class="common-radio-text">인기순</span>
                                            </label>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#none">
                                            <label class="common-radio-label" for="ranking2">
                                                <input type="radio" id="ranking2" class="common-radio-btn" name="order_by" value="A" <?=($order_by=='A')?'checked':''?>>
                                                <span class="common-radio-text">최신순</span>
                                            </label>
                                        </a>
                                    </li>
                                    <?if($cur_category[0]['CATEGORY_CD2']=='90000000'){?>
                                    <li>
                                        <a href="#none">
                                            <label class="common-radio-label" for="ranking3">
                                                <input type="radio" id="ranking3" class="common-radio-btn" name="order_by" value="C" <?=($order_by=='C')?'checked':''?>>
                                                <span class="common-radio-text">진행중</span>
                                            </label>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#none">
                                            <label class="common-radio-label" for="ranking4">
                                                <input type="radio" id="ranking4" class="common-radio-btn" name="order_by" value="D" <?=($order_by=='D')?'checked':''?>>
                                                <span class="common-radio-text">종료</span>
                                            </label>
                                        </a>
                                    </li>
                                    <?}?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- //카테고리 필터 -->

                    <!-- //shoping guide -->
                    <div class="confirm">
                        <button class="confirm" onclick="javaScript:search_magazine(); return false;">확인</button>
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
                <div class="prds-list">
                    <ul>
                        <?foreach($list as $row){?>
                        <li>
                            <a href="/magazine/detail/<?=$row['MAGAZINE_NO']?>">
                                <div class="pic">
                                    <div class="item auto-img">
                                        <div class="img">
                                            <img src="<?=$row['MOB_IMG_URL']?>" alt=""/>
                                        </div>
                                    </div>
                                    <div class="layer"></div>
                                    <div class="status">
                                        <span class="like"><?=$row['LOVE']?></span>
                                        <span class="share"><?=$row['SHARE']?></span>
                                        <span class="view">조회 <?=$row['HITS']?></span>
                                    </div>
                                    <?if(isset($row['END_DT']) && ($row['END_DT']<date("Y-m-d H:i:s"))){?>
                                        <div class="pic_slodout" style="background-color: rgba(0,0,0,0.4);">
                                            <?if($current_category[0]['CATEGORY_CD2'] == 90000000){?>
                                                <p style="font-size: 20px;color: #E4E4E4;">이벤트 종료</p>
                                            <?}else{?>
                                                <p style="font-size: 20px;color: #E4E4E4;">SOLD OUT</p>
                                            <?}?>
                                        </div>
                                    <?}?>
                                </div>
                                <div class="txt">
                                    <p class="nm_txt">
                                        <?if($current_category[0]['CATEGORY_CD2'] == 90000000){?>
                                            <?if($row['END_DT']>date("Y-m-d H:i:s")){?>
                                                [진행중]
                                            <?} else {?>
                                                [종료]
                                            <?}?>
                                        <?}?>
                                        <?=$row['TITLE']?>
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

        <!-- 페이징 // -->
        <?=$pagination?>
        <!-- // 페이징  -->

        <script src="/assets/js/common.js?ver=4"></script>
        <script src="/assets/js/owl.carousel.min.js?ver=4"></script>

        <script>
            function search_magazine(){
                var cate_gb = '<?=$cate_gb?>';
                var cate_cd = '<?=$cate_cd?>';
                var order_by = '<?=$order_by?>';

                order_by = $('input[name=order_by]:checked').val();

                document.location.href = "/magazine/list?cate_cd="+cate_cd+"&cate_gb="+cate_gb+"&order_by="+order_by;
            }
        </script>

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