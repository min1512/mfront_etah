<link rel="stylesheet" href="/assets/css/main.css?ver=2.5.4">



<div class="content main">
    <!-- main banner // -->
    <div class="main-area">
        <div class="owl-carousel">
            <?foreach($top as $row) {?>
                <a href="<?=$row['BANNER_LINK_URL']?>" class="item">
                    <img src="<?=$row['BANNER_IMG_URL']?>" />
                    <div class="inner">
                        <p class="txt1" style="font-family: <?=$row['BANNER_FONT_CLASS_GB_CD1']?>; color: <?=$row['BANNER_FONTCOLOR_CLASS_GB_CD1']?>;
                            font-weight:<?=$row['BANNER_FONTWEIGHT_CLASS_GB_CD1']?>; font-size: <?=$row['BANNER_FONT_SIZE1']?>px;"><?=$row['BANNER_MAIN_TITLE']?></p>
                        <p class="txt1" style="font-family: <?=$row['BANNER_FONT_CLASS_GB_CD2']?>; color: <?=$row['BANNER_FONTCOLOR_CLASS_GB_CD2']?>;
                                font-weight:<?=$row['BANNER_FONTWEIGHT_CLASS_GB_CD2']?>; font-size: <?=$row['BANNER_FONT_SIZE2']?>px;"><?=$row['BANNER_SUB_TITLE']?></p>
                        <span class="fake-btn">자세히 보러가기</span>
                    </div>
                </a>
            <?}?>
        </div>
    </div>

    <!-- cate-area -->
    <div class="cate-area">
        <div class="owl-carousel">
            <a href="/category/main?cate_cd=24000000" class="item">
                <img src="/assets/images/main/img_cate00.jpg?ver3.0" />
                <span>에타홈<br/>클래스</span>
            </a>
            <a href="/category/main?cate_cd=10000000" class="item">
                <img src="/assets/images/main/img_cate01.jpg?ver3.0" />
                <span>가구</span>
            </a>
            <a href="/category/main?cate_cd=11000000" class="item">
                <img src="/assets/images/main/img_cate02.jpg?ver3.0" />
                <span>소품</span>
            </a>
            <a href="/category/main?cate_cd=14000000" class="item">
                <img src="/assets/images/main/img_cate03.jpg?ver3.0" />
                <span>조명</span>
            </a>
            <a href="/category/main?cate_cd=19000000" class="item">
                <img src="/assets/images/main/img_cate04.jpg?ver3.0" />
                <span>주방</span>
            </a>
            <a href="/category/main?cate_cd=22000000" class="item">
                <img src="/assets/images/main/img_cate05.jpg?ver3.0" />
                <span>식품</span>
            </a>
            <a href="/category/main?cate_cd=21000000" class="item">
                <img src="/assets/images/main/img_cate06.jpg?ver3.0" />
                <span>디지털/가전</span>
            </a>
            <a href="/category/main?cate_cd=17000000" class="item">
                <img src="/assets/images/main/img_cate07.jpg?ver3.0" />
                <span>생활/욕실</span>
            </a>
            <a href="/category/main?cate_cd=15000000" class="item">
                <img src="/assets/images/main/img_cate08.jpg?ver3.0" />
                <span>침구</span>
            </a>
            <a href="/category/main?cate_cd=23000000" class="item">
                <img src="/assets/images/main/img_cate09.jpg?ver3.0" />
                <span>뷰티</span>
            </a>
            <a href="/category/main?cate_cd=13000000" class="item">
                <img src="/assets/images/main/img_cate10.jpg?ver3.0" />
                <span>DIY</span>
            </a>
            <a href="/category/main?cate_cd=16000000" class="item">
                <img src="/assets/images/main/img_cate11.jpg?ver3.0" />
                <span>가드닝</span>
            </a>
        </div>
    </div>
    <!-- //cate-area -->

    <!-- today-area -->
    <div class="today-area">
        <h4 class="title-style">에타홈 특가</h4>
        <h5 class="title-style-sub"></h5>
        <a href="/goods/event/586" class="btn-more">
            <span>more</span>
        </a>

        <ul class="owl-carousel">
            <?foreach($etahDeal as $row){?>
                <li>
                    <a href="<?=$row['LINK_URL']?>">
                        <div class="pic">
                            <div class="item auto-img">
                                <div class="img">
                                    <img src="<?=$row['IMG_URL']?>" alt="">
                                </div>
                                <div class="tag-wrap">
                                    <?if(isset($row['DEAL'])){?>
                                        <?
                                        $price = $row['SELLING_PRICE'] - $row['RATE_PRICE'] - $row['AMT_PRICE'];
                                        $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                        $sale_percent = strval($sale_percent);
                                        $sale_percent_array = explode('.',$sale_percent);
                                        $sale_percent_string = $sale_percent_array[0];
                                        ?>
                                        <?if($sale_percent_string == 0){?>
                                            <!--<span class="circle-tag deal"><em class="blk" style="color:#000">에타<br>딜</em></span>-->
                                        <?} else {?>
                                            <span class="circle-tag sale">~<em class="blk"><?=$sale_percent_string?></em>%</span>
                                        <?}?>
                                    <?}?>
                                    <?if($row['GONGBANG']=='G'){?>
                                        <!--<span class="circle-tag class-prd"><em class="blk">공방<br>제작상품</em></span>-->
                                    <?}else if($row['GONGBANG']=='C'){?>
                                        <!--<span class="circle-tag class"><em class="blk">에타홈<br>클래스</em></span>-->
                                    <?}?>
                                </div>
                            </div>
                        </div>
                        <div class="txt">
                            <p class="nm_txt"><?=$row['NAME']?></p>
                            <?if( ($row['PATTERN_TYPE_CD']=='FREE') ||
                                (($row['PATTERN_TYPE_CD']=='PRICE') && ($row['DELI_LIMIT']>0 && $row['DELI_LIMIT']<($row['SELLING_PRICE']-$row['RATE_PRICE']-$row['AMT_PRICE']))) ){
                            ?>
                                <ul class="prd-label-list">
                                    <li class="prd-label-item free_shipping">무료배송</li>
                                </ul>
                            <?}?>
                        </div>
                    </a>
                </li>
            <?}?>
        </ul>
    </div>
    <!-- //today_area -->

    <!-- homejok_pedia 홈족피디아-->
    <div class="homejok_pedia">

        <h4 class="title-style">홈족피디아</h4>
        <h5 class="title-style-sub">이거 알고 있었어?</h5>
        <a href="/magazine/list?cate_cd=40000000&cate_gb=M" class="btn-more">
            <span>more</span>
        </a>

        <ul class="tabhead">
            <li>
                <a href="/magazine/list?cate_cd=40000000&cate_gb=M" class="on" data-target="tabbody_homeall">전체보기</a>
            </li>
            <li>
                <a href="/magazine/list?cate_cd=40010000&cate_gb=S" class="" data-target="tabbody_living">리빙백서</a>
            </li>
            <li>
                <a href="/magazine/list?cate_cd=40030000&cate_gb=S" class="" data-target="tabbody_life">감성생활</a>
            </li>
            <li>
                <a href="/magazine/list?cate_cd=40020000&cate_gb=S" class="" data-target="tabbody_hometip">홈족TIP</a>
            </li>
            <li>
                <a href="/magazine/list?cate_cd=40040000&cate_gb=S" class="" data-target="tabbody_direct">해외직구</a>
            </li>
        </ul>
        <!-- homejok contents1 -->
        <div class="list prds-list on" id="tabbody_homeall">
            <!--<div class="img current">
                <a href="/magazine/detail/<?/*=$homejokAll[0]['GOODS_CD']*/?>">
                    <div class="img_box">
                        <img src="<?/*=$homejokAll[0]['MAGAZINE_ADD_IMG_URL']*/?>" alt="<?/*=$homejokAll[0]['TITLE']*/?>" class="homejok_<?/*=$homejokAll[0]['GOODS_CD']*/?>">
                    </div>
                    <div class="status">
                        <span class="txt"><?/*=$homejokAll[0]['TITLE']*/?></span>
                        <p class="h_view"><span>VIEW</span> <?/*=$homejokAll[0]['HITS']*/?></p>
                    </div>
                </a>
            </div>--><!--상단에 크게 보이는 홈족 피디아 없애달라는 요청  2020-06-01 김설 팀장 -->
            <?if(count($homejokAll)>1){?>
                <div class="owl-carousel owl-theme">
                    <?
//                    unset($homejokAll[0]);
                    foreach($homejokAll as $arow){
                        if(isset($arow['GOODS_CD'])){
                            ?>
                            <div class="item" data-merge="2">
                                <div class="thumbnail">
                                    <a href="/magazine/detail/<?=$arow['GOODS_CD']?>" alt="홈족피디아 보러가기">
                                        <div class="thumb_img_box">
                                            <div class="thumb_img">
                                                <img src="<?=$arow['MAGAZINE_ADD_IMG_URL']?>" alt="<?=$arow['TITLE']?>" class="homejok_<?=$arow['GOODS_CD']?>">
                                            </div>
                                        </div>
                                        <div class="status sub">
                                            <span class="txt"><?=$arow['TITLE']?></span>
                                            <p class="h_view">조회 <?=$arow['HITS']?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?}
                    }?>
                </div>
            <?}?>
        </div>
        <!--// homejok contents1 -->
        <!-- homejok contents2 -->
        <div class="list prds-list" id="tabbody_living">
            <?if(count($homejok1)!=0){?>
                <!--<div class="img current">
                    <a href="/magazine/detail/<?/*=$homejok1[0]['MAGAZINE_NO']*/?>">
                        <div class="img_box">
                            <img src="<?/*=$homejok1[0]['MAGAZINE_ADD_IMG_URL']*/?>" alt="<?/*=$homejok1[0]['TITLE']*/?>" class="homejok_<?/*=$homejok1[0]['MAGAZINE_NO']*/?>">
                        </div>
                        <div class="status">
                            <span class="txt"><?/*=$homejok1[0]['TITLE']*/?></span>
                            <p class="h_view"><span>VIEW</span> <?/*=$homejok1[0]['HITS']*/?></p>
                        </div>
                    </a>
                </div>-->
            <?}?>
            <?if(count($homejok1)>1){?>
                <div class="owl-carousel owl-theme">
                    <?
                    unset($homejok1[0]);
                    foreach($homejok1 as $brow){
                        ?>
                        <div class="item" data-merge="2">
                            <div class="thumbnail">
                                <a href="/magazine/detail/<?=$brow['MAGAZINE_NO']?>" alt="홈족피디아 보러가기">
                                    <div class="thumb_img_box">
                                        <div class="thumb_img">
                                            <img src="<?=$brow['MAGAZINE_ADD_IMG_URL']?>" alt="<?=$brow['TITLE']?>" class="homejok_<?=$brow['MAGAZINE_NO']?>">
                                        </div>
                                    </div>
                                    <div class="status sub">
                                        <span class="txt"><?=$brow['TITLE']?></span>
                                        <p class="h_view">조회 <?=$brow['HITS']?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?}?>
                </div>
            <?}?>
        </div>
        <!--// homejok contents2 -->

        <!-- homejok contents3 -->
        <div class="list prds-list" id="tabbody_life">
            <?if(count($homejok2)!=0){?>
                <!--<div class="img current">
                    <a href="/magazine/detail/<?/*=$homejok2[0]['MAGAZINE_NO']*/?>">
                        <div class="img_box">
                            <img src="<?/*=$homejok2[0]['MAGAZINE_ADD_IMG_URL']*/?>" alt="<?/*=$homejok2[0]['TITLE']*/?>" class="homejok_<?/*=$homejok2[0]['MAGAZINE_NO']*/?>">
                        </div>
                        <div class="status">
                            <span class="txt"><?/*=$homejok2[0]['TITLE']*/?></span>
                            <p class="h_view"><span>VIEW</span> <?/*=$homejok2[0]['HITS']*/?></p>
                        </div>
                    </a>
                </div>-->
            <?}?>
            <?if(count($homejok2)>1){?>
                <div class="owl-carousel owl-theme">
                    <?
                    unset($homejok2[0]);
                    foreach($homejok2 as $crow){
                        ?>
                        <div class="item" data-merge="2">
                            <div class="thumbnail">
                                <a href="/magazine/detail/<?=$crow['MAGAZINE_NO']?>" alt="홈족피디아 보러가기">
                                    <div class="thumb_img_box">
                                        <div class="thumb_img">
                                            <img src="<?=$crow['MAGAZINE_ADD_IMG_URL']?>" alt="<?=$crow['TITLE']?>" class="homejok_<?=$crow['MAGAZINE_NO']?>">
                                        </div>
                                    </div>
                                    <div class="status sub">
                                        <span class="txt"><?=$crow['TITLE']?></span>
                                        <p class="h_view">조회 <?=$crow['HITS']?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?}?>
                </div>
            <?}?>
        </div>
        <!--// homejok contents3 -->
        <!-- homejok contents4 -->
        <div class="list prds-list" id="tabbody_hometip">
            <?if(count($homejok3)!=0){?>
                <!--<div class="img current">
                    <a href="/magazine/detail/<?/*=$homejok3[0]['MAGAZINE_NO']*/?>">
                        <div class="img_box">
                            <img src="<?/*=$homejok3[0]['MAGAZINE_ADD_IMG_URL']*/?>" alt="<?/*=$homejok3[0]['TITLE']*/?>" class="homejok_<?/*=$homejok3[0]['MAGAZINE_NO']*/?>">
                        </div>
                        <div class="status">
                            <span class="txt"><?/*=$homejok3[0]['TITLE']*/?></span>
                            <p class="h_view"><span>VIEW</span> <?/*=$homejok3[0]['HITS']*/?></p>
                        </div>
                    </a>
                </div>-->
            <?}?>
            <?if(count($homejok3)>1){?>
                <div class="owl-carousel owl-theme">
                    <?
                    $d =1;
                    unset($homejok3[0]);
                    foreach($homejok3 as $drow){
                        ?>
                        <div class="item" data-merge="2">
                            <div class="thumbnail">
                                <a href="/magazine/detail/<?=$drow['MAGAZINE_NO']?>" alt="홈족피디아 보러가기">
                                    <div class="thumb_img_box">
                                        <div class="thumb_img">
                                            <img src="<?=$drow['MAGAZINE_ADD_IMG_URL']?>" alt="<?=$drow['TITLE']?>" class="homejok_<?=$drow['MAGAZINE_NO']?>">
                                        </div>
                                    </div>
                                    <div class="status sub">
                                        <span class="txt"><?=$drow['TITLE']?></span>
                                        <p class="h_view">조회 <?=$drow['HITS']?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?
                        $d++;
                    }?>
                </div>
            <?}?>
        </div>
        <!-- homejok contents4 -->
        <!-- homejok contents5 -->
        <div class="list prds-list" id="tabbody_direct">
            <?if(count($homejok4)!=0){?>
                <!--<div class="img current">
                    <a href="/magazine/detail/<?/*=$homejok4[0]['MAGAZINE_NO']*/?>">
                        <div class="img_box">
                            <img src="<?/*=$homejok4[0]['MAGAZINE_ADD_IMG_URL']*/?>" alt="<?/*=$homejok4[0]['TITLE']*/?>" class="homejok_<?/*=$homejok4[0]['MAGAZINE_NO']*/?>">
                        </div>
                        <div class="status">
                            <span class="txt"><?/*=$homejok4[0]['TITLE']*/?></span>
                            <p class="h_view"><span>VIEW</span> <?/*=$homejok4[0]['HITS']*/?></p>
                        </div>
                    </a>
                </div>-->
            <?}?>
            <?if(count($homejok4)>1){?>
                <div class="owl-carousel owl-theme">
                    <?
                    $d =1;
                    unset($homejok4[0]);
                    foreach($homejok4 as $drow){
                        ?>
                        <div class="item" data-merge="2">
                            <div class="thumbnail">
                                <a href="/magazine/detail/<?=$drow['MAGAZINE_NO']?>" alt="홈족피디아 보러가기">
                                    <div class="thumb_img_box">
                                        <div class="thumb_img">
                                            <img src="<?=$drow['MAGAZINE_ADD_IMG_URL']?>" alt="<?=$drow['TITLE']?>" class="homejok_<?=$drow['MAGAZINE_NO']?>">
                                        </div>
                                    </div>
                                    <div class="status sub">
                                        <span class="txt"><?=$drow['TITLE']?></span>
                                        <p class="h_view">조회 <?=$drow['HITS']?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?
                        $d++;
                    }?>
                </div>
            <?}?>
        </div>
        <!-- homejok contents4 -->
    </div>
    <!-- //homejok_pedia 홈족피디아-->

    <div class="review-area">
        <h4 class="title-style">Best 후기</h4>
        <!-- <div class="list review-list" id="tabbody_review">
            <ul class="owl-carousel">-->
        <div class="review-list" id="tabbody_review">
            <div class="owl-carousel owl-nav1">
                <?for($i=0;$i<count($bestReview);$i+=2){?>
                    <ul>
                        <li>
                            <a href="/goods/detail/<?=$bestReview[$i]['GOODS_CD']?>">
                                <div class="pic">
                                    <div class="item auto-img">
                                        <div class="img">
                                            <img src="<?=$bestReview[$i]['IMG_URL']?>" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="review">
                                    <p class="review_txt"><?=$bestReview[$i]['CONTENTS']?></p>
                                    <div class="txt">
                                        <span class="nm_txt"><?=$bestReview[$i]['BRAND_NM']?></span>
                                        <span class="prd_txt"><?=$bestReview[$i]['GOODS_NM']?></span>
                                    </div>
                                </div>
                            </a>
                            <div class="btm_txt">
                                <!--                                <div class="idpic"><img src="../assets/images/data/main/sample3.jpg" alt=""></div>-->
                                <span class="id_txt"><?=substr($bestReview[$i]['CUST_ID'],0,3)."****"?></span>
                                <span class="date_txt"><?=substr($bestReview[$i]['REG_DT'],0,10)?></span>
                            </div>
                        </li>
                        <li>
                            <a href="/goods/detail/<?=$bestReview[$i+1]['GOODS_CD']?>">
                                <div class="pic">
                                    <div class="item auto-img">
                                        <div class="img">
                                            <img src="<?=$bestReview[$i+1]['IMG_URL']?>" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="review">
                                    <p class="review_txt"><?=$bestReview[$i+1]['CONTENTS']?></p>
                                    <div class="txt">
                                        <span class="nm_txt"><?=$bestReview[$i+1]['BRAND_NM']?></span>
                                        <span class="prd_txt"><?=$bestReview[$i+1]['GOODS_NM']?></span>
                                    </div>
                                </div>
                            </a>
                            <div class="btm_txt">
                                <!--                                                                <div class="idpic"><img src="../assets/images/data/main/sample3.jpg" alt=""></div>-->
                                <span class="id_txt"><?=substr($bestReview[$i+1]['CUST_ID'],0,3)."****"?></span>
                                <span class="date_txt"><?=substr($bestReview[$i+1]['REG_DT'],0,10)?></span>
                            </div>
                        </li>
                    </ul>
                <?}?>
            </div>
        </div>
    </div>

    <!-- keyword-area -->
    <div class="keyword-area">
        <?php
        function toWeekNum($timestamp) {
            $w = date('w', mktime(0,0,0, date('n',$timestamp), 1, date('Y',$timestamp)));
            return ceil(($w + date('j',$timestamp) -1) / 7);
        }
        switch(toWeekNum(time())) {
            case 1: $weekNo = '첫';  break;
            case 2: $weekNo = '둘';  break;
            case 3: $weekNo = '셋';  break;
            case 4: $weekNo = '넷';  break;
            case 5: $weekNo = '다섯'; break;
        }
        ?>
        <h4 class="title-style">인기 키워드</h4>
        <h5 class="title-style-sub"><?=date('n')?>월 <?=$weekNo?>째주 인기 키워드</h5>
        <div class="pic_area">
            <ul class="">
                <?foreach($hot_keyword as $row){?>
                    <li>
                        <?if($row['LINK_URL']){?>
                            <a href="<?=$row['LINK_URL']?>">
                        <?} else {?>
                            <a href="/goods/search?keyword=<?=$row['NAME']?>&gb=T&tag_keyword=<?=$row['NAME']?>">
                        <?}?>
                            <div class="item">
                                <div class="img">
                                    <img src="<?=$row['IMG_URL']?>" alt="">
                                </div>
                            </div>
                            <div class="txt"></div>
                            <span>#<?=$row['NAME']?></span>
                        </a>
                    </li>
                <?}?>
            </ul>
        </div>
    </div>
    <!-- //keyword-area -->

    <!-- MD Pick & New & bestreview area -->
    <div class="tab-area">
        <h4 class="title-style">이번 주의 추천상품</h4>
        <h5 class="title-style-sub">따뜻한 신상부터 베스트 상품까지</h5>
        <a href="/goods/event/586" class="btn-more">
            <span>more</span>
        </a>

        <ul class="tabhead">
            <li>
                <a href="#" class="on" data-target="tabbody_mdpic">MD Pick</a>
            </li>
            <li class="">
                <a href="#" class="" data-target="tabbody_newprd">신상품</a>
            </li>
        </ul>

        <div class="list prds-list on" id="tabbody_mdpic">
            <ul class="owl-carousel">
                <?for($i=0;$i<8;$i++){?>
                    <li>
                        <a href="/goods/detail/<?=$mdPick[$i]['GOODS_CD']?>">
                            <div class="pic">
                                <div class="item auto-img">
                                    <div class="img">
                                        <img src="<?=$mdPick[$i]['IMG_URL']?>" alt="">
                                    </div>
                                    <div class="tag-wrap">
                                        <?if(!empty($mdPick[$i]['DEAL'])){?><!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>--><?}?>
                                    </div>
                                </div>
                            </div>
                            <p class="nm_txt"><?=$mdPick[$i]['BRAND_NM']?></p>
                            <p class="prd_txt"><?=$mdPick[$i]['GOODS_NM']?></p>
                            <p class="price">
                                <span class="price_txt">판매가</span>
                                <?
                                if($mdPick[$i]['COUPON_CD']){
                                    $price = $mdPick[$i]['SELLING_PRICE'] - $mdPick[$i]['RATE_PRICE'] - $mdPick[$i]['AMT_PRICE'];
                                    echo "<span class=\"price1\">".number_format($price)."</span>";

                                    /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                    $sale_percent = (($mdPick[$i]['SELLING_PRICE'] - $price)/$mdPick[$i]['SELLING_PRICE']*100);
                                    $sale_percent = strval($sale_percent);
                                    $sale_percent_array = explode('.',$sale_percent);
                                    $sale_percent_string = $sale_percent_array[0];
                                    ?>
                                    <span class="price2"><?=number_format($mdPick[$i]['SELLING_PRICE'])?></span>
                                    <span class="percent">(<?=floor((($mdPick[$i]['SELLING_PRICE']-$price)/$mdPick[$i]['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%)</span>
                                <?}else{
                                    echo "<span class=\"price1\">".number_format($mdPick[$i]['SELLING_PRICE'])."</span>";
                                }
                                ?>
                            </p>
                        </a>
                    </li>
                <?}?>
            </ul>
        </div>

        <div class="list prds-list" id="tabbody_newprd">
            <ul class="owl-carousel">
                <?foreach($newItem as $row){?>
                    <li>
                        <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                            <div class="pic">
                                <div class="item auto-img">
                                    <div class="img">
                                        <img src="<?=$row['IMG_URL']?>" alt="">
                                    </div>
                                    <div class="tag-wrap">
                                        <?if(!empty($row['DEAL'])){?><!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>--><?}?>
                                    </div>
                                </div>
                            </div>
                            <p class="nm_txt"><?=$row['BRAND_NM']?></p>
                            <p class="prd_txt"><?=$row['GOODS_NM']?></p>
                            <p class="price">
                                <span class="price_txt">판매가</span>
                                <?
                                if($row['COUPON_CD']){
                                    $price = $row['SELLING_PRICE'] - $row['RATE_PRICE'] - $row['AMT_PRICE'];
                                    echo "<span class=\"price1\">".number_format($price)."</span>";

                                    /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                    $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                    $sale_percent = strval($sale_percent);
                                    $sale_percent_array = explode('.',$sale_percent);
                                    $sale_percent_string = $sale_percent_array[0];
                                ?>
                                    <span class="price2"><?=number_format($row['SELLING_PRICE'])?></span>
                                    <span class="percent">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%)</span>
                                <?}else{
                                    echo "<span class=\"price1\">".number_format($row['SELLING_PRICE'])."</span>";
                                }
                                ?>
                            </p>
                        </a>
                    </li>
                <?}?>
            </ul>
        </div>
    </div>
    <!-- //MD Pick & New & bestreview area -->

    <!-- magazine area -->
    <div class="magazine-area">
        <div class="tabhead">
            <div class="tit">
                <h4 class="title-style">에타홈 트렌드 매거진</h4>
                <h5 class="title-style-sub">에타홈 회원분들의 관심으로 만들어진</h5>
                <a href="/magazine" class="btn-more">
                    <span>더보기</span>
                </a>
            </div>
            <ul>
                <li>
                    <a href="#none" class="link1">생활tip</a>
                </li>
                <li>
                    <a href="#none" class="link2">인테리어tip</a>
                </li>
                <li>
                    <a href="#none" class="link3">Brand</a>
                </li>
            </ul>
        </div>

        <div class="tabbody">
            <div class="owl-carousel owl-nav1">
                <?foreach($magazine1 as $row){?>
                    <div class="item tabbody_life">
                        <a href="/magazine/detail/<?=$row['GOODS_CD']?>">
                            <div class="inner">
                                <div class="item">
                                    <div class="img">
                                        <img src="<?=$row['MAGAZINE_IMG_URL']?>"/>
                                    </div>
                                </div>
                                <div class="layer"></div>
                                <div class="status">
                                    <span class="like"><?=$row['LOVE']?></span>
                                    <span class="comment"><?=$row['COMMENT']?></span>
                                    <span class="share"><?=$row['SHARE']?></span>
                                    <span class="view">조회 <?=$row['HITS']?></span>
                                </div>
                            </div>
                            <div class="inner2">
                                <!--                                <img src="../assets/images/data/main/sample3.jpg" class="pic" />-->
                                <span class="userid"><?=$row['CATEGORY_NM']?></span>
                                <span class="txt"><?=$row['TITLE']?></span>
                            </div>
                        </a>
                    </div>
                <?}?>
                <?foreach($magazine2 as $row){?>
                    <div class="item tabbody_interrior">
                        <a href="/magazine/detail/<?=$row['GOODS_CD']?>">
                            <div class="inner">
                                <div class="item">
                                    <div class="img">
                                        <img src="<?=$row['MAGAZINE_IMG_URL']?>"/>
                                    </div>
                                </div>
                                <div class="layer"></div>
                                <div class="status">
                                    <span class="like"><?=$row['LOVE']?></span>
                                    <span class="comment"><?=$row['COMMENT']?></span>
                                    <span class="share"><?=$row['SHARE']?></span>
                                    <span class="view">조회 <?=$row['HITS']?></span>
                                </div>
                            </div>
                            <div class="inner2">
                                <!--                                <img src="../assets/images/data/main/sample3.jpg" class="pic" />-->
                                <span class="userid"><?=$row['CATEGORY_NM']?></span>
                                <span class="txt"><?=$row['TITLE']?> </span>
                            </div>
                        </a>
                    </div>
                <?}?>
                <?foreach($magazine3 as $row){?>
                    <div class="item tabbody_brand">
                        <a href="/magazine/detail/<?=$row['GOODS_CD']?>">
                            <div class="inner">
                                <div class="item">
                                    <div class="img">
                                        <img src="<?=$row['MAGAZINE_IMG_URL']?>"/>
                                    </div>
                                </div>
                                <div class="layer"></div>
                                <div class="status">
                                    <span class="like"><?=$row['LOVE']?></span>
                                    <span class="comment"><?=$row['COMMENT']?></span>
                                    <span class="share"><?=$row['SHARE']?></span>
                                    <span class="view">조회 <?=$row['HITS']?></span>
                                </div>
                            </div>
                            <div class="inner2">
                                <!--                                <img src="../assets/images/data/main/sample3.jpg" class="pic" />-->
                                <span class="userid"><?=$row['CATEGORY_NM']?></span>
                                <span class="txt"><?=$row['TITLE']?> </span>
                            </div>
                        </a>
                    </div>
                <?}?>
            </div>
        </div>
    </div>
    <!-- //magazine area -->

    <!-- class area -->
    <div class="class-area">
        <div class="tit">
            <a href="/category/main?cate_cd=24000000">
                <h4 class="title-style">에타홈<br>클래스</h4>
            </a>
        </div>
        <div class="tabhead">
            <div class="scroll-wrap">
                <div class="scroller">
                    <ul>
                        <?if($classGoods[0]['GOODS_CD'] != null){?><li><a href="/category/category_list?cate_cd=24020000&cate_gb=S">핸드메이드</a></li><?}?>
                        <?if($classA[0]['GOODS_CD'] != null){?><li><a href="/category/category_list?cate_cd=24010100&cate_gb=S">가구</a></li><?}?>
                        <?if($classB[0]['GOODS_CD'] != null){?><li><a href="/category/category_list?cate_cd=24010200&cate_gb=S">수공예</a></li><?}?>
                        <?if($classC[0]['GOODS_CD'] != null){?><li><a href="/category/category_list?cate_cd=24010300&cate_gb=S">도예</a></li><?}?>
                        <?if($classD[0]['GOODS_CD'] != null){?><li><a href="/category/category_list?cate_cd=24010400&cate_gb=S">플라워</a></li><?}?>
                        <?if($classE[0]['GOODS_CD'] != null){?><li><a href="/category/category_list?cate_cd=24010500&cate_gb=S">캔들/향수/디퓨저</a></li><?}?>
                        <?if($classF[0]['GOODS_CD'] != null){?><li><a href="/category/category_list?cate_cd=24010600&cate_gb=S">디저트/요리</a></li><?}?>
                        <?if($classG[0]['GOODS_CD'] != null){?><li><a href="/category/category_list?cate_cd=24010700&cate_gb=S">미술</a></li><?}?>
                        <?if($classH[0]['GOODS_CD'] != null){?><li><a href="/category/category_list?cate_cd=24010800&cate_gb=S">이벤트</a></li><?}?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="swiper-container tabbody">
            <div class="swiper-wrapper">
                <?if($classGoods[0]['GOODS_CD'] != null){?>
                    <div class="swiper-slide outer">
                        <a href="/category/category_list?kind=C&cate_cd=24020000&order_by=A&cate_gb=L">핸드메이드 전체보기</a>
                        <div class="swiper-container2 swiper-gallery-top">
                            <div class="swiper-wrapper">
                                <?foreach($classGoods as $row) {?>
                                    <div class="swiper-slide inner">
                                        <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                                            <div class="inner">
                                                <div class="item">
                                                    <div class="img">
                                                        <img src="<?=$row['IMG_URL']?>">
                                                    </div>
                                                </div>
                                                <div class="layer"></div>
                                            </div>
                                            <div class="inner2">
                                            <span class="map">
                                                <?if($row['CLASS'] != '공방상품'){?>
                                                    <em><?=$row['ADDRESS']?></em><em><?=$row['CLASS']?></em>
                                                <?}else{?>
                                                    <em><?=$row['CLASS']?></em>
                                                <?}?>
                                                <?=$row['BRAND_NM']?>
                                            </span>
                                                <span class="txt"><?=$row['GOODS_NM']?></span>
                                                <p class="price">
                                                    <span class="price_txt">판매가</span>
                                                    <?
                                                    if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                                        $price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S']+$row['RATE_PRICE_G']) - ($row['AMT_PRICE_S']+$row['AMT_PRICE_G']);
                                                        echo "<span class=\"price1\">".number_format($price)."</span>";

                                                        /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                                        $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                                        $sale_percent = strval($sale_percent);
                                                        $sale_percent_array = explode('.',$sale_percent);
                                                        $sale_percent_string = $sale_percent_array[0];
                                                        ?>
                                                        <span class="price2"><?=number_format($row['SELLING_PRICE'])?></span>
                                                        <span class="percent">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%)</span>
                                                    <?}else{
                                                        echo "<span class=\"price1\">".number_format($row['SELLING_PRICE'])."</span>";
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                <?}?>
                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next swiper-button-white"></div>
                            <div class="swiper-button-prev swiper-button-white"></div>
                        </div>
                    </div>
                <?}?>
                <?if($classA[0]['GOODS_CD'] != null){?>
                <div class="swiper-slide outer">
                    <a href="/category/category_list?kind=C&cate_cd=24010100&order_by=A&cate_gb=S">가구 전체보기</a>
                    <div class="swiper-container2 swiper-gallery-top">
                        <div class="swiper-wrapper">
                            <?foreach($classA as $row) {?>
                                <div class="swiper-slide inner">
                                    <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                                        <div class="inner">
                                            <div class="item">
                                                <div class="img">
                                                    <img src="<?=$row['IMG_URL']?>">
                                                </div>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                        <div class="inner2">
                                            <span class="map">
                                                <?if($row['CLASS'] != '공방상품'){?>
                                                    <em><?=$row['ADDRESS']?></em><em><?=$row['CLASS']?></em>
                                                <?}else{?>
                                                    <em><?=$row['CLASS']?></em>
                                                <?}?>
                                                <?=$row['BRAND_NM']?>
                                            </span>
                                            <span class="txt"><?=$row['GOODS_NM']?></span>
                                            <p class="price">
                                                <span class="price_txt">판매가</span>
                                                <?
                                                if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                                    $price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S']+$row['RATE_PRICE_G']) - ($row['AMT_PRICE_S']+$row['AMT_PRICE_G']);
                                                    echo "<span class=\"price1\">".number_format($price)."</span>";

                                                    /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                                    $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                                    $sale_percent = strval($sale_percent);
                                                    $sale_percent_array = explode('.',$sale_percent);
                                                    $sale_percent_string = $sale_percent_array[0];
                                                    ?>
                                                    <span class="price2"><?=number_format($row['SELLING_PRICE'])?></span>
                                                    <span class="percent">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%)</span>
                                                <?}else{
                                                    echo "<span class=\"price1\">".number_format($row['SELLING_PRICE'])."</span>";
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            <?}?>
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-button-next swiper-button-white"></div>
                        <div class="swiper-button-prev swiper-button-white"></div>
                    </div>
                </div>
                <?}?>
                <?if($classB[0]['GOODS_CD'] != null){?>
                <div class="swiper-slide outer">
                    <a href="/category/category_list?kind=C&cate_cd=24010200&order_by=A&cate_gb=S">수공예 전체보기</a>
                    <div class="swiper-container2 swiper-gallery-top">
                        <div class="swiper-wrapper">
                            <?foreach($classB as $row) {?>
                                <div class="swiper-slide inner">
                                    <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                                        <div class="inner">
                                            <div class="item">
                                                <div class="img">
                                                    <img src="<?=$row['IMG_URL']?>">
                                                </div>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                        <div class="inner2">
                                            <span class="map">
                                                <?if($row['CLASS'] != '공방상품'){?>
                                                    <em><?=$row['ADDRESS']?></em><em><?=$row['CLASS']?></em>
                                                <?}else{?>
                                                    <em><?=$row['CLASS']?></em>
                                                <?}?>
                                                <?=$row['BRAND_NM']?>
                                            </span>
                                            <span class="txt"><?=$row['GOODS_NM']?></span>
                                            <p class="price">
                                                <span class="price_txt">판매가</span>
                                                <?
                                                if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                                    $price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S']+$row['RATE_PRICE_G']) - ($row['AMT_PRICE_S']+$row['AMT_PRICE_G']);
                                                    echo "<span class=\"price1\">".number_format($price)."</span>";

                                                    /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                                    $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                                    $sale_percent = strval($sale_percent);
                                                    $sale_percent_array = explode('.',$sale_percent);
                                                    $sale_percent_string = $sale_percent_array[0];
                                                    ?>
                                                    <span class="price2"><?=number_format($row['SELLING_PRICE'])?></span>
                                                    <span class="percent">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%)</span>
                                                <?}else{
                                                    echo "<span class=\"price1\">".number_format($row['SELLING_PRICE'])."</span>";
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            <?}?>
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-button-next swiper-button-white"></div>
                        <div class="swiper-button-prev swiper-button-white"></div>
                    </div>
                </div>
                <?}?>
                <?if($classC[0]['GOODS_CD'] != null){?>
                <div class="swiper-slide outer">
                    <a href="/category/category_list?kind=C&cate_cd=24010300&order_by=A&cate_gb=S">도예 전체보기</a>
                    <div class="swiper-container2 swiper-gallery-top">
                        <div class="swiper-wrapper">
                            <?foreach($classC as $row) {?>
                                <div class="swiper-slide inner">
                                    <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                                        <div class="inner">
                                            <div class="item">
                                                <div class="img">
                                                    <img src="<?=$row['IMG_URL']?>">
                                                </div>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                        <div class="inner2">
                                            <span class="map">
                                                <?if($row['CLASS'] != '공방상품'){?>
                                                    <em><?=$row['ADDRESS']?></em><em><?=$row['CLASS']?></em>
                                                <?}else{?>
                                                    <em><?=$row['CLASS']?></em>
                                                <?}?>
                                                <?=$row['BRAND_NM']?>
                                            </span>
                                            <span class="txt"><?=$row['GOODS_NM']?></span>
                                            <p class="price">
                                                <span class="price_txt">판매가</span>
                                                <?
                                                if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                                    $price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S']+$row['RATE_PRICE_G']) - ($row['AMT_PRICE_S']+$row['AMT_PRICE_G']);
                                                    echo "<span class=\"price1\">".number_format($price)."</span>";

                                                    /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                                    $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                                    $sale_percent = strval($sale_percent);
                                                    $sale_percent_array = explode('.',$sale_percent);
                                                    $sale_percent_string = $sale_percent_array[0];
                                                    ?>
                                                    <span class="price2"><?=number_format($row['SELLING_PRICE'])?></span>
                                                    <span class="percent">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%)</span>
                                                <?}else{
                                                    echo "<span class=\"price1\">".number_format($row['SELLING_PRICE'])."</span>";
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            <?}?>
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-button-next swiper-button-white"></div>
                        <div class="swiper-button-prev swiper-button-white"></div>
                    </div>
                </div>
                <?}?>
                <?if($classD[0]['GOODS_CD'] != null){?>
                <div class="swiper-slide outer">
                    <a href="/category/category_list?kind=C&cate_cd=24010400&order_by=A&cate_gb=S">플라워 전체보기</a>
                    <div class="swiper-container2 swiper-gallery-top">
                        <div class="swiper-wrapper">
                            <?foreach($classD as $row) {?>
                                <div class="swiper-slide inner">
                                    <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                                        <div class="inner">
                                            <div class="item">
                                                <div class="img">
                                                    <img src="<?=$row['IMG_URL']?>">
                                                </div>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                        <div class="inner2">
                                           <span class="map">
                                                <?if($row['CLASS'] != '공방상품'){?>
                                                    <em><?=$row['ADDRESS']?></em><em><?=$row['CLASS']?></em>
                                                <?}else{?>
                                                    <em><?=$row['CLASS']?></em>
                                                <?}?>
                                               <?=$row['BRAND_NM']?>
                                            </span>
                                            <span class="txt"><?=$row['GOODS_NM']?></span>
                                            <p class="price">
                                                <span class="price_txt">판매가</span>
                                                <?
                                                if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                                    $price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S']+$row['RATE_PRICE_G']) - ($row['AMT_PRICE_S']+$row['AMT_PRICE_G']);
                                                    echo "<span class=\"price1\">".number_format($price)."</span>";

                                                    /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                                    $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                                    $sale_percent = strval($sale_percent);
                                                    $sale_percent_array = explode('.',$sale_percent);
                                                    $sale_percent_string = $sale_percent_array[0];
                                                    ?>
                                                    <span class="price2"><?=number_format($row['SELLING_PRICE'])?></span>
                                                    <span class="percent">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%)</span>
                                                <?}else{
                                                    echo "<span class=\"price1\">".number_format($row['SELLING_PRICE'])."</span>";
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            <?}?>
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-button-next swiper-button-white"></div>
                        <div class="swiper-button-prev swiper-button-white"></div>
                    </div>
                </div>
                <?}?>
                <?if($classE[0]['GOODS_CD'] != null){?>
                <div class="swiper-slide outer">
                    <a href="/category/category_list?kind=C&cate_cd=24010500&order_by=A&cate_gb=S">캔들/향수/디퓨저 전체보기</a>
                    <div class="swiper-container2 swiper-gallery-top">
                        <div class="swiper-wrapper">
                            <?foreach($classE as $row) {?>
                                <div class="swiper-slide inner">
                                    <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                                        <div class="inner">
                                            <div class="item">
                                                <div class="img">
                                                    <img src="<?=$row['IMG_URL']?>">
                                                </div>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                        <div class="inner2">
                                            <span class="map">
                                                <?if($row['CLASS'] != '공방상품'){?>
                                                    <em><?=$row['ADDRESS']?></em><em><?=$row['CLASS']?></em>
                                                <?}else{?>
                                                    <em><?=$row['CLASS']?></em>
                                                <?}?>
                                                <?=$row['BRAND_NM']?>
                                            </span>
                                            <span class="txt"><?=$row['GOODS_NM']?></span>
                                            <p class="price">
                                                <span class="price_txt">판매가</span>
                                                <?
                                                if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                                    $price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S']+$row['RATE_PRICE_G']) - ($row['AMT_PRICE_S']+$row['AMT_PRICE_G']);
                                                    echo "<span class=\"price1\">".number_format($price)."</span>";

                                                    /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                                    $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                                    $sale_percent = strval($sale_percent);
                                                    $sale_percent_array = explode('.',$sale_percent);
                                                    $sale_percent_string = $sale_percent_array[0];
                                                    ?>
                                                    <span class="price2"><?=number_format($row['SELLING_PRICE'])?></span>
                                                    <span class="percent">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%)</span>
                                                <?}else{
                                                    echo "<span class=\"price1\">".number_format($row['SELLING_PRICE'])."</span>";
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            <?}?>
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-button-next swiper-button-white"></div>
                        <div class="swiper-button-prev swiper-button-white"></div>
                    </div>
                </div>
                <?}?>
                <?if($classF[0]['GOODS_CD'] != null){?>
                    <div class="swiper-slide outer">
                        <a href="/category/category_list?kind=C&cate_cd=24010600&order_by=A&cate_gb=S">디저트/요리 전체보기</a>
                        <div class="swiper-container2 swiper-gallery-top">
                            <div class="swiper-wrapper">
                                <?foreach($classF as $row) {?>
                                    <div class="swiper-slide inner">
                                        <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                                            <div class="inner">
                                                <div class="item">
                                                    <div class="img">
                                                        <img src="<?=$row['IMG_URL']?>">
                                                    </div>
                                                </div>
                                                <div class="layer"></div>
                                            </div>
                                            <div class="inner2">
                                            <span class="map">
                                                <?if($row['CLASS'] != '공방상품'){?>
                                                    <em><?=$row['ADDRESS']?></em><em><?=$row['CLASS']?></em>
                                                <?}else{?>
                                                    <em><?=$row['CLASS']?></em>
                                                <?}?>
                                                <?=$row['BRAND_NM']?>
                                            </span>
                                                <span class="txt"><?=$row['GOODS_NM']?></span>
                                                <p class="price">
                                                    <span class="price_txt">판매가</span>
                                                    <?
                                                    if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                                        $price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S']+$row['RATE_PRICE_G']) - ($row['AMT_PRICE_S']+$row['AMT_PRICE_G']);
                                                        echo "<span class=\"price1\">".number_format($price)."</span>";

                                                        /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                                        $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                                        $sale_percent = strval($sale_percent);
                                                        $sale_percent_array = explode('.',$sale_percent);
                                                        $sale_percent_string = $sale_percent_array[0];
                                                        ?>
                                                        <span class="price2"><?=number_format($row['SELLING_PRICE'])?></span>
                                                        <span class="percent">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%)</span>
                                                    <?}else{
                                                        echo "<span class=\"price1\">".number_format($row['SELLING_PRICE'])."</span>";
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                <?}?>
                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next swiper-button-white"></div>
                            <div class="swiper-button-prev swiper-button-white"></div>
                        </div>
                    </div>
                <?}?>
                <?if($classG[0]['GOODS_CD'] != null){?>
                    <div class="swiper-slide outer">
                        <a href="/category/category_list?kind=C&cate_cd=24010700&order_by=A&cate_gb=S">미술 전체보기</a>
                        <div class="swiper-container2 swiper-gallery-top">
                            <div class="swiper-wrapper">
                                <?foreach($classG as $row) {?>
                                    <div class="swiper-slide inner">
                                        <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                                            <div class="inner">
                                                <div class="item">
                                                    <div class="img">
                                                        <img src="<?=$row['IMG_URL']?>">
                                                    </div>
                                                </div>
                                                <div class="layer"></div>
                                            </div>
                                            <div class="inner2">
                                            <span class="map">
                                                <?if($row['CLASS'] != '공방상품'){?>
                                                    <em><?=$row['ADDRESS']?></em><em><?=$row['CLASS']?></em>
                                                <?}else{?>
                                                    <em><?=$row['CLASS']?></em>
                                                <?}?>
                                                <?=$row['BRAND_NM']?>
                                            </span>
                                                <span class="txt"><?=$row['GOODS_NM']?></span>
                                                <p class="price">
                                                    <span class="price_txt">판매가</span>
                                                    <?
                                                    if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                                        $price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S']+$row['RATE_PRICE_G']) - ($row['AMT_PRICE_S']+$row['AMT_PRICE_G']);
                                                        echo "<span class=\"price1\">".number_format($price)."</span>";

                                                        /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                                        $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                                        $sale_percent = strval($sale_percent);
                                                        $sale_percent_array = explode('.',$sale_percent);
                                                        $sale_percent_string = $sale_percent_array[0];
                                                        ?>
                                                        <span class="price2"><?=number_format($row['SELLING_PRICE'])?></span>
                                                        <span class="percent">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%)</span>
                                                    <?}else{
                                                        echo "<span class=\"price1\">".number_format($row['SELLING_PRICE'])."</span>";
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                <?}?>
                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next swiper-button-white"></div>
                            <div class="swiper-button-prev swiper-button-white"></div>
                        </div>
                    </div>
                <?}?>
                <?if($classH[0]['GOODS_CD'] != null){?>
                    <div class="swiper-slide outer">
                        <a href="/category/category_list?kind=C&cate_cd=24010800&order_by=A&cate_gb=S">이벤트 전체보기</a>
                        <div class="swiper-container2 swiper-gallery-top">
                            <div class="swiper-wrapper">
                                <?foreach($classH as $row) {?>
                                    <div class="swiper-slide inner">
                                        <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                                            <div class="inner">
                                                <div class="item">
                                                    <div class="img">
                                                        <img src="<?=$row['IMG_URL']?>">
                                                    </div>
                                                </div>
                                                <div class="layer"></div>
                                            </div>
                                            <div class="inner2">
                                            <span class="map">
                                                <?if($row['CLASS'] != '공방상품'){?>
                                                    <em><?=$row['ADDRESS']?></em><em><?=$row['CLASS']?></em>
                                                <?}else{?>
                                                    <em><?=$row['CLASS']?></em>
                                                <?}?>
                                                <?=$row['BRAND_NM']?>
                                            </span>
                                                <span class="txt"><?=$row['GOODS_NM']?></span>
                                                <p class="price">
                                                    <span class="price_txt">판매가</span>
                                                    <?
                                                    if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                                        $price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S']+$row['RATE_PRICE_G']) - ($row['AMT_PRICE_S']+$row['AMT_PRICE_G']);
                                                        echo "<span class=\"price1\">".number_format($price)."</span>";

                                                        /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                                        $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                                        $sale_percent = strval($sale_percent);
                                                        $sale_percent_array = explode('.',$sale_percent);
                                                        $sale_percent_string = $sale_percent_array[0];
                                                        ?>
                                                        <span class="price2"><?=number_format($row['SELLING_PRICE'])?></span>
                                                        <span class="percent">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%)</span>
                                                    <?}else{
                                                        echo "<span class=\"price1\">".number_format($row['SELLING_PRICE'])."</span>";
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                <?}?>
                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next swiper-button-white"></div>
                            <div class="swiper-button-prev swiper-button-white"></div>
                        </div>
                    </div>
                <?}?>
            </div>
        </div>
    </div>
    <!-- //class area -->

    <!-- brandfocus area -->
    <div class="brandfocus-area">
        <h4 class="title-style">브랜드포커스</h4>
        <ul class="list">
            <?foreach($brandFocus as $row){?>
                <li>
                    <a href="<?=$row['LINK_URL']?>">
                        <img src="<?=$row['IMG_URL']?>" />
                        <div class="inner">
                            <span class="tag"><?=$row['NAME']?></span>
                            <span class="text"><?=$row['DISP_HTML']?></span>
                            <span class="cnt"><?=$row['COUNT_GOODS']?>개 상품</span>
                            <span class="btn-more">더보기</span>
                        </div>
                    </a>
                </li>
            <?}?>
        </ul>
    </div>
    <!-- //brandfocus area -->

    <!-- insta area -->
    <div class="insta-area">
        <h4 class="title-style">Instagram</h4>
        <h5 class="title-style-sub">follow @etahome_kr</h5>
        <ul class="list" id="instafeed-gallery-feed">
        </ul>
    </div>
    <!-- //insta area -->

    <div class="store-btn-area">
        <a href="<?=base_url()?>footer/inquiry_for_office" class="btn-yellow large">브랜드 입점문의</a>
        <a href="https://forms.gle/WBEjJENCXqLvjFio7" class="btn-yellow large">에타홈클래스 입점신청</a>
    </div>

    <!-- 메인프로모션 레이어 // -->
    <div class="layer-wrap layer-main01 layer-wrap--view" id="layerMainPopup">
        <div class="layer-inner">
            <div class="layer-content">
                <?foreach($event as $row){?>
                    <a href="<?=$row['BANNER_LINK_URL']?>"><img src="<?=$row['BANNER_IMG_URL']?>" style="width: 100%;" alt=""></a>
                <?}?>
            </div>
            <div class="bottom-wrap">
                <div class="checkbox_area">
                    <input type="checkbox" id="formMainClose" class="checkbox"> <label for="formMainClose" class="checkbox-label">오늘 하루 열지 않음</label>
                </div>
                <a href="#" data-close="layer-close" id="full_layer_close" class="btn_close">닫기 X</a>
            </div>
        </div>
    </div>
    <!-- // 메인프로모션 레이어 -->

    <div class="dimd"></div>

    <!--Instargram. 2020.07.29 인스타 재연동 완료(모바일) 이상민  -->
    <script>
//        var  token = '4543432365.d78a785.db347731af734f7eacf680c41f6a4d2c', // access token.
//            userid = 4543432365, // User ID - get it in source HTML of your Instagram profile or look at the next example :)
//            num_photos = 12; // how much photos do you want to get

        $.ajax({
            url: 'https://graph.instagram.com/me/media?fields=id,caption,media_url,media_type,permalink,thumbnail_url&access_token=IGQVJYQkhXR0VqTUJncjFHRkJKOF9rUUk3VEt1bFhVU3RzQkY3ZADVfZAlo2MkRoaWRYbnBaamtFVEttMjl1NjgtM3NqOE1pYzFwUTNOLXJzRHVqR21kQ0ZAYTFhKdlB1T0R2MkVUYVN4czRqbDh0ZAWdkagZDZD',
            dataType: 'jsonp',
            type: 'GET',
//        data: {access_token: token, count: num_photos},
            success: function(data) {
//            console.log(data);
//                $("#instafeed-gallery-feed").append('<ul class="list">');
                $("#instafeed-gallery-feed").append('<ul class="instagram-banner-list">');
                for (x in data.data) {
                    if(x <9){
                        var img = data.data[x];
//                        console.log(data.data[5]);
                        if (data.data[x]['media_type'] == 'CAROUSEL_ALBUM') {
                            $("#instafeed-gallery-feed").append('<li>' +
                                '<a target="_blank" href="' + img['permalink'] + '">' +
                                '<img  src="' + img['media_url'] + '" \">' + '</a>' +
                                '</li>');
                        } else if (data.data[x]['media_type'] == 'VIDEO') {
                            $("#instafeed-gallery-feed").append('<li>' +
                                '<a target="_blank" href="' + img['permalink'] + '">' +
                                '<img  src="' + img['thumbnail_url'] + '" \">' + '</a>' +
                                '</li>');
                        }
                    }
                }
            }
        });




//        $.ajax({
//            url: 'https://api.instagram.com/v1/users/' + userid + '/media/recent', // or /users/self/media/recent for Sandbox
//            dataType: 'jsonp',
//            type: 'GET',
//            data: {access_token: token, count: num_photos},
//            success: function(data){
//                //console.log(data);
//            $("#instafeed-gallery-feed").append('<ul class="instagram-banner-list">');
//                for( x in data.data ){
//                    $("#instafeed-gallery-feed").append('<li>' +
//                        '<a target="_blank" href="'+data.data[x].link+'">'+
//                        '<img  src="'+data.data[x].images.thumbnail.url+'">' + '</a>'+
//                        '</li>');
                    // data.data[x].images.low_resolution.url - URL of image, 306х306
                    // data.data[x].images.thumbnail.url - URL of image 150х150  썸네일 이미지
                    // data.data[x].images.standard_resolution.url - URL of image 612х612   기본 이미지
                    // data.data[x].link - Instagram post URL   인스타그램 사진 URL
//                }
//                $("#instafeed-gallery-feed").append('</ul>');
//            },
//            error: function(data){
//                console.log(data); // send the error notifications to console
//            }
//        });
    </script>

    <script src="/assets/js/common.js?ver=1.1"></script>
    <script src="/assets/js/owl.carousel.min.js"></script>


    <script type="text/javascript">
        //메인 프로모션 팝업 딤레이어
        $(document).ready(function(){
            if($.cookie('layerMainPopup') != 'hidden'){
                $('#wrap').addClass('layer-open');
                $('#layerMainPopup').show();
                $('#layerMainPopup').css('visibility','visible');

            }else {
                $('#wrap').removeClass('layer-open');
                $('#layerMainPopup').hide();
            }

            $('#full_layer_close').click( function() {
                var chkd = $("#formMainClose").is(":checked");
                if(chkd){
                    $.cookie('layerMainPopup', 'hidden', {expires : 1});
                }
                $('#wrap').removeClass('layer-open');
            });
        });

        // 탑버튼
        function topBtn (){
            var btn = $('#btnTop'),
                deadLine = $('#footer').offset().top;
            var scrollFnc = function(){
                deadLine = $('#footer').offset().top,
                    scrollTop = $(window).scrollTop();
                if( scrollTop > 50 ) {
                    btn.stop().fadeIn();
                    if( scrollTop > deadLine - $(window).height()  ) {
                        btn.css({
                            'position' : 'absolute',
                            'bottom' : '',
                            'top' : deadLine - 55
                        });
                    } else {
                        btn.css({
                            'position' : 'fixed',
                            'top' : '',
                            'bottom' : '50px'
                        })
                    }
                } else {
                    btn.stop().fadeOut();
                }
            };
            $(window).on('scroll', scrollFnc);
            btn.on('click', function(){
                $('html, body').animate({
                    scrollTop : 0
                }, 'fast');
            });
            scrollFnc();
        }

        $(function(){
            topBtn();
            etahUi.layercontroller();
            etahUi.layercontroller2();
        });
    </script>

    <script>
        $(document).ready(function(){
            //// 메인스와이퍼 - 시작
            var mainSwiper = {
                init : function(){
                    var swiperWeb = new Swiper('.swiper-container', {
                        autoplay: {
                            delay: 4000,
                            //disableOnInteraction: false,
                        },
                        loop: true,
                        on: {
                            init: function(){
                                mainSwiper.afterSlide();
                            },
                            slideChangeTransitionEnd: function(){
                                mainSwiper.afterSlide();
                            }
                        }
                    });
                    mainSwiper.swiper = swiperWeb; //이벤트리스너 안에 this 처리를 위해

                    //event
                    $(".class-area .tabhead ul li a").off("click.menu").on("click.menu", function(e){
                        if( $(this).parent("li").hasClass("on") ) return false;
                        var index = $(this).parent("li").index();
                        console.log(index);
                        $(".class-area .tabhead ul li").removeClass("on").children("a").attr("aria-selected","false");
                        $(".class-area .tabhead ul li:eq("+ index +")").children("a").attr("aria-selected","true");
                        mainSwiper.swiper.slideTo(index+1,0); //slideTo(index,speed,callback)
                        return false; //e.preventDefault() + e.stopPropagation();
                        //실행후 return false 넣을것 (실행 전에 있을경우 실행자체가 안됨)
                    })
                },
                afterSlide : function(){
                    var index = $(".outer.swiper-slide-active").attr("data-swiper-slide-index");
                    $(".class-area .tabhead ul li").removeClass("on").children("a").attr("aria-selected","false");
                    $(".class-area .tabhead ul li:eq("+ index +")").addClass("on").children("a").attr("aria-selected","true");
                    console.log(index);
                    mainSwiper.scrollAlign();
                },
                scrollAlign : function(){
                    var scrollMenuOn = $(".class-area .scroll-wrap .scroller ul li.on"),
                        scroller = $(".class-area .scroll-wrap .scroller");
                    scroller.animate({
                        scrollLeft : scrollMenuOn.offset().left + scroller.scrollLeft() + scrollMenuOn.width()/2 - scroller.width()/2
                    }, 500);
                }
            }
            //메인 모든 리터럴함수 호출
            var main = {
                init : function(){
                    mainSwiper.init();
                    main.userAgent();
                },
                userAgent : function(){
                    var os = "os_" + ua_result.os.name;
                    var platform = ua_result.platform;
                    var browser = ua_result.browser.name;
                    var version = "ver_" + ua_result.browser.version.major;
                    var ua = os + " " + platform + " " + browser + " " + version;
                    $("body").addClass(ua);
                }
            }
            //내부 슬라이드
            var innerSwiper = {
                init : function(){
                    var swiperGallery = new Swiper('.swiper-gallery-top', {
                        nested:true, //중첩
                        resistanceRatio:0,
                    });
                }
            }
            //메인슬라이드, 내부 슬라이드 실행
            $(function(){
                main.init();
                innerSwiper.init();
            })
            //// 메인스와이퍼 - 끝

            // 팝업슬라이드
            $(".layer-main01 .layer-content").owlCarousel({
                items: 1,
                loop: true,
                autoHeight: true,
                smartSpeed: 300,
                autoplay: true,
                autoplayTimeout: 5000
            });
            // main-area 슬라이드
            $(".main-area .owl-carousel").owlCarousel({
                animateOut: 'fadeOut',
                mouseDrag: false,
                items: 1,
                loop: true,
                autoHeight: false,
                smartSpeed: 100,
                autoplay: true,
                autoplayTimeout: 4000,
                nav: false,
                dots: false,
                center:true
            });
            // cate-area 슬라이드
            $(".cate-area .owl-carousel").owlCarousel({
                animateOut: 'fadeOut',
                mouseDrag: false,
                items: 4,
                loop: false,
                margin: 12,
                autoHeight: false,
                smartSpeed: 100,
                autoplay: false,
                autoplayTimeout: 7000,
                nav: true,
                dots: false
            });

            // today-area 슬라이드
            $(".today-area .owl-carousel").owlCarousel({
                items: 2,
                loop: true,
                margin: 6,
                autoHeight: false,
                smartSpeed: 300,
                autoplay: true,
                autoplayTimeout: 7000,
                nav: false,
                dots: false
            });

            // review 슬라이드
            $("#tabbody_review .owl-carousel").owlCarousel({
                items: 1,
                loop: false,
                margin: 6,
                autoHeight: false,
                smartSpeed: 300,
                autoplay: false,
                autoplayTimeout: 7000,
                nav: true,
                dots: false
            });

            // mdpic 슬라이드
            $("#tabbody_mdpic .owl-carousel").owlCarousel({
                items: 2,
                loop: true,
                margin: 6,
                autoHeight: false,
                smartSpeed: 300,
                autoplay: true,
                autoplayTimeout: 3000,
                nav: false,
                dots: false
            });

            // newprd 슬라이드
            $("#tabbody_newprd .owl-carousel").owlCarousel({
                items: 2,
                loop: true,
                margin: 6,
                autoHeight: false,
                smartSpeed: 300,
                autoplay: true,
                autoplayTimeout: 3000,
                nav: false,
                dots: false
            });

            //tab-area tab click function
            $(".tab-area .tabhead li a").click(function(){
                $(".tab-area .list").removeClass("on");
                var target = $(this).data("target");
                $("#"+target).addClass("on");

                $(".tab-area .tabhead li a").removeClass("on");
                $(this).addClass("on");

                return false;
            });

            //tab-area tab click function
            $(".homejok_pedia .tabhead li a").click(function(){
                $(".homejok_pedia .list").removeClass("on");
                var target = $(this).data("target");
                $("#"+target).addClass("on");

                $(".homejok_pedia .tabhead li a").removeClass("on");
                $(this).addClass("on");

                return false;
            });

            // Magazine 슬라이드
            //visual slide
            var visualSlide = $(".magazine-area .tabbody .owl-carousel");
            var btnVsualNav = $(".magazine-area .tabhead li");
            btnVsualNav.eq(0).children("a").addClass("on");
            visualSlide.owlCarousel({
                animateOut: 'fadeOut',
                mouseDrag: false,
                items: 1,
                loop: false,
                autoHeight: false,
                smartSpeed: 100,
                autoplay: true,
                autoplayTimeout: 7000,
                nav: true
            }).on("changed.owl.carousel", syncPosition);
            function syncPosition(el) {
                btnVsualNav.children("a").removeClass("on");
                var count = el.item.count - 1;
                var current = Math.round(el.item.index / 3 - 0.5);
                if (current < 0) {
                    current = count;
                }
                if (current > count) {
                    current = 0;
                }
                btnVsualNav.find("a").removeClass("on").eq(current).addClass("on");
            }
            $("a", btnVsualNav).each(function() {
                var el = $(this);
                el.click(function(){
                    btnVsualNav.children("a").removeClass("on");
                    $(this).addClass("on");
                });
            });
            btnVsualNav.find(".link1").click(function(){
                visualSlide.trigger("to.owl.carousel", 0)
            });
            btnVsualNav.find(".link2").click(function(){
                visualSlide.trigger("to.owl.carousel", 3)
            });
            btnVsualNav.find(".link3").click(function(){
                visualSlide.trigger("to.owl.carousel", 6)
            });

        });

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
        $(document).ready(function(){
            $('.homejok_pedia .owl-carousel').owlCarousel({
                items:5,
                loop:false,
                margin:10,
                merge:true,
                responsive:{
                    678:{
                        mergeFit:true
                    },
                    1000:{
                        mergeFit:false
                    }
                }
            });
        })
    </script>

    <script>
        window.onload = function(){

            $.ajax({
                type: 'POST',
                async: false,
                url: '/main/main_img',
                dataType: 'json',
                error: function(res) {
                    alert('Database Error');
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        var image = res.data;

                        for(key in image) {
                            $(".homejok_"+key).attr("src", image[key]);
                        }
                    }
                }
            })
        }
    </script>
