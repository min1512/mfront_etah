<link rel="stylesheet" href="/assets/css/display.css?ver=2.3.1">

<div class="content <?=(($gubun=='G')||($gubun=='T'))?'srp_detail1':'srp_detail'?>">

    <!-- top-location -->
    <div class="page-title-box page-title-box--location">
        <div class="page-title">
            <ul class="page-title-list">
                <li class="page-title-item"><a href="/goods/search?keyword=<?=$keyword?>">검색결과</a></li>
                <li class="page-title-item <?=($gubun!='T')?'active':''?>">
                    <?
                    switch($gubun){
                        case 'E': echo "기획전"; break;
                        case 'G': echo "상품"; break;
                        case 'M': echo "매거진"; break;
                        case 'T': echo "연관태그"; break;
                    }
                    ?>
                    <?if($gubun!='T'){?><em class="bold_yel">(<?=number_format($list_cnt)?>)</em><?}?>
                </li> <!-- 퐐성화시 클래스 active추가 -->
                <?if($gubun=='T'){?>
                    <li class="page-title-item active">
                        #<?=$tag_keyword?>
                        <em class="bold_yel">(<?=number_format($list_cnt)?>)</em>
                    </li>
                <?}?>
            </ul>
        </div>
    </div>
    <!-- //top-location -->

    <?
    //기획전 검색결과 상세
    if($gubun=='E'){?>
        <!-- 필터 -->
        <div class="filter-list">
            <div class="filter-inner">
                <div class="filter-item filter-option1">
                    <a href="#filterOptionBtn" class="filter-btn btn-gnb-open ranking-btn" data-ui="filter-btn"><?=($order_by=='A')?'인기순':'최신순'?></a>
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
                        <p class="search-result">검색결과 <span><?=number_format($list_cnt)?></span>개</p>
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
                                        <li><a href="#none" onclick="search_goods('E', 'C','');" <?=($category=='')?'class="on"':''?>>전체</a></li>
                                        <?foreach($arr_cate1 as $c1){?>
                                        <li><a href="#none" <?=($cur_category['CATE_CD1']==$c1['CODE'])?'class="on"':''?>><?=$c1['NAME']?></a>
                                            <ul>
                                                <?foreach($arr_cate2 as $c2){
                                                    if($c2['PARENT_CODE'] == $c1['CODE']){?>
                                                        <li><a href="#none" onclick="search_goods('E', 'C','<?=$c2['CODE']?>');" <?=($cur_category['CATE_CD2']==$c2['CODE'])?'class="on"':''?>><?=$c2['NAME']?></a></li>
                                                    <?}
                                                }?>
                                            </ul>
                                        </li>
                                        <?}?>
                                    </ul>
                                </div>
                                <div class="select_wrap select_wrap_cate">
                                    <h4 class="srp-cate-tit srp-cate-tit1">정렬</h4>
                                    <ul id="srp-cate" class="srp-cate1">
                                        <li>
                                            <a href="#none">
                                                <label class="common-radio-label" for="ranking1">
                                                    <input type="radio" id="ranking1" class="common-radio-btn" name="order_by" value="A" <?=($order_by=='A')?'checked':''?>>
                                                    <span class="common-radio-text">인기순</span>
                                                </label>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#none">
                                                <label class="common-radio-label" for="ranking2">
                                                    <input type="radio" id="ranking2" class="common-radio-btn" name="order_by" value="B" <?=($order_by=='B')?'checked':''?>>
                                                    <span class="common-radio-text">최신순</span>
                                                </label>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- //카테고리 필터 -->

                        <!-- //shoping guide -->
                        <div class="confirm">
                            <button class="confirm" onclick="search_goods('E','',''); return false;">확인</button>
                        </div>
                    </nav>
                    <!-- //nav -->
                </form>
            </aside>

        </div>
        <!-- // 필터 -->


        <ul class="srp_project_list">
            <?foreach($list as $lt){?>
                <li>
                    <a href="/goods/event/<?=$lt['PLAN_EVENT_CD']?>">
                        <div class="img"><img src="<?=$lt['IMG_URL']?>" onerror="this.style.display='none'" alt="<?=$lt['TITLE']?>"></div>
                        <div class="txt">
                            <div class="txt-inner">
                                <span><?=$lt['TITLE']?></span>
                            </div>
                        </div>
                    </a>
                </li>
            <?}?>
        </ul>
        <!--// 기획전 -->
    <?
    }
    //매거진 검색결과 상세
    else if($gubun=='M'){?>
        <!-- 필터 -->
        <div class="filter-list">
            <div class="filter-inner">
                <div class="filter-item filter-option1">
                    <a href="#filterOptionBtn" class="filter-btn btn-gnb-open ranking-btn" data-ui="filter-btn"><?=($order_by=='A')?'인기순':'최신순'?></a>
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
                        <p class="search-result">검색결과 <span><?=number_format($list_cnt)?></span>개</p>
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
                                        <li><a href="#none" onclick="search_goods('M', 'C','');" <?=($category=='')?'class="on"':''?>>전체</a></li>
                                        <?foreach($arr_cate1 as $c1){?>
                                            <li><a href="#none" <?=($cur_category['CATE_CD1']==$c1['CODE'])?'class="on"':''?>><?=$c1['NAME']?></a>
                                                <ul>
                                                    <?foreach($arr_cate2 as $c2){
                                                        if($c2['PARENT_CODE'] == $c1['CODE']){?>
                                                            <li><a href="#none" onclick="search_goods('M', 'C','<?=$c2['CODE']?>');" <?=($cur_category['CATE_CD2']==$c2['CODE'])?'class="on"':''?>><?=$c2['NAME']?></a></li>
                                                        <?}
                                                    }?>
                                                </ul>
                                            </li>
                                        <?}?>
                                    </ul>
                                </div>
                                <div class="select_wrap select_wrap_cate">
                                    <h4 class="srp-cate-tit srp-cate-tit1">정렬</h4>
                                    <ul id="srp-cate" class="srp-cate1">
                                        <li>
                                            <a href="#none">
                                                <label class="common-radio-label" for="ranking1">
                                                    <input type="radio" id="ranking1" class="common-radio-btn" name="order_by" value="A" <?=($order_by=='A')?'checked':''?>>
                                                    <span class="common-radio-text">인기순</span>
                                                </label>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#none">
                                                <label class="common-radio-label" for="ranking2">
                                                    <input type="radio" id="ranking2" class="common-radio-btn" name="order_by" value="B" <?=($order_by=='B')?'checked':''?>>
                                                    <span class="common-radio-text">최신순</span>
                                                </label>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- //카테고리 필터 -->

                        <!-- //shoping guide -->
                        <div class="confirm">
                            <button class="confirm" onclick="search_goods('M','',''); return false;">확인</button>
                        </div>
                    </nav>
                    <!-- //nav -->
                </form>
            </aside>

        </div>
        <!-- // 필터 -->


        <!-- 매거진 리스트 // -->

        <div class="magazine srp_detail">
            <div class="magazine-list">
                <div class="ma_box">
                    <div class="prds-list">
                        <ul>
                            <?foreach($list as $lt){?>
                                <li>
                                    <a href="/magazine/detail/<?=$lt['MAGAZINE_NO']?>">
                                        <div class="pic">
                                            <div class="item auto-img">
                                                <div class="img land">
                                                    <img src="<?=$lt['IMG_URL']?>" alt="<?=$lt['TITLE']?>"/>
                                                </div>
                                            </div>
                                            <div class="layer"></div>
                                            <div class="status">
                                                <span class="like"><?=$lt['LOVE']?></span>
                                                <span class="share"><?=$lt['SHARE']?></span>
                                                <span class="view">조회 <?=$lt['HITS']?></span>
                                            </div>
                                            <?if( isset($lt['END_DT']) && ($lt['END_DT']<date("Y-m-d H:i:s")) ){?>
                                                <div class="pic_slodout" style="background-color: rgba(0,0,0,0.4);">
                                                    <?
                                                    $gb = substr($lt['CATEGORY_CD'],0,1);

                                                    if($gb=='4') echo "<p>SOLD OUT</p>";
                                                    if($gb=='9') echo "<p>이벤트 종료</p>";
                                                    ?>
                                                </div>
                                            <?}?>
                                        </div>
                                        <div class="txt">
                                            <p class="nm_txt"><?=$lt['TITLE']?></p>
                                        </div>
                                    </a>
                                </li>
                            <?}?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--// 매거진 리스트 -->
    <?
    }
    //상품 검색결과 상세
    else if( ($gubun=='G') || ($gubun=='T') ){?>
        <!-- 필터 -->
        <div class="filter-list">
            <div class="filter-inner">
                <div class="filter-item filter-option1">
                    <a href="#filterOptionBtn" class="filter-btn btn-gnb-open ranking-btn" data-ui="filter-btn">
                        <?
                        switch($order_by){
                            case 'A': echo '인기순'; break;
                            case 'B': echo '신상품순'; break;
                            case 'C': echo '낮은가격순'; break;
                            case 'D': echo '높은가격순'; break;
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
                        <p class="search-result">검색결과 <span><?=number_format($list_cnt)?></span>개</p>
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
                                        <li><a href="#" onclick="search_goods('G', 'C', '')" <?=($category=='')?'class="on"':''?>>전체</a></li>
                                        <?foreach($arr_cate1 as $c1){?>
                                            <li><a href="#none" <?=($cur_category['CATE_CD1']==$c1['CODE'])?'class="on"':''?>><?=$c1['NAME']?></a>
                                                <ul>
                                                    <?foreach($arr_cate2 as $c2){
                                                        if($c2['PARENT_CODE']==$c1['CODE']){?>
                                                            <li><a href="#none" <?=($cur_category['CATE_CD2']==$c2['CODE'])?'class="on"':''?>><?=$c2['NAME']?></a>
                                                                <ul>
                                                                    <?foreach($arr_cate3 as $c3){
                                                                        if($c3['PARENT_CODE']==$c2['CODE']){?>
                                                                        <li><a href="#none" onclick="search_goods('G', 'C', <?=$c3['CODE']?>)" <?=($cur_category['CATE_CD3']==$c3['CODE'])?'class="on"':''?>><?=$c3['NAME']?></a></li>
                                                                    <?}
                                                                    }?>
                                                                </ul>
                                                            </li>
                                                        <?}
                                                    }?>
                                                </ul>
                                            </li>
                                        <?}?>
                                    </ul>
                                </div>
                                <div class="select_wrap select_wrap_cate">
                                    <h4 class="srp-cate-tit srp-cate-tit1">정렬</h4>
                                    <ul id="srp-cate" class="srp-cate1">
                                        <li>
                                            <a href="#none">
                                                <label class="common-radio-label" for="ranking1">
                                                    <input type="radio" id="ranking1" class="common-radio-btn" name="order_by" value="A" <?=($order_by=='A')?'checked':''?>>
                                                    <span class="common-radio-text">인기순</span>
                                                </label>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#none">
                                                <label class="common-radio-label" for="ranking2">
                                                    <input type="radio" id="ranking2" class="common-radio-btn" name="order_by" value="B" <?=($order_by=='B')?'checked':''?>>
                                                    <span class="common-radio-text">신상품순</span>
                                                </label>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#none">
                                                <label class="common-radio-label" for="ranking3">
                                                    <input type="radio" id="ranking3" class="common-radio-btn" name="order_by" value="C" <?=($order_by=='C')?'checked':''?>>
                                                    <span class="common-radio-text">낮은가격순</span>
                                                </label>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#none">
                                                <label class="common-radio-label" for="ranking4">
                                                    <input type="radio" id="ranking4" class="common-radio-btn" name="order_by" value="D" <?=($order_by=='D')?'checked':''?>>
                                                    <span class="common-radio-text">높은가격순</span>
                                                </label>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="select_wrap select_wrap_cate">
                                    <h4 class="srp-cate-tit srp-cate-tit4">국가</h4>
                                    <?$search_country = explode("|", substr($country,1));?>
                                    <ul id="srp-cate" class="srp-cate4">
                                        <?
                                        $cidx = 1;
                                        foreach($arr_country as $key=>$value){?>
                                        <li class="checkbox_area country">
                                            <a href="#none">
                                                <input type="checkbox" class="checkbox" id="CountryCheck<?=$cidx?>" name="country" value="<?=$key?>" <?=(in_array($key, $search_country))?'checked':''?>>
                                                <label class="checkbox_label" for="CountryCheck<?=$cidx?>"><?=$value['NM']?></label>
                                            </a>
                                        </li>
                                        <?$cidx++;
                                        }?>
                                    </ul>
                                </div>

                                <div class="select_wrap select_wrap_cate">
                                    <h4 class="srp-cate-tit srp-cate-tit3">배송</h4>
                                    <ul id="srp-cate" class="srp-cate3">
                                        <li>
                                            <a href="#none" class="free-deli">
                                                <label class="common-radio-label" for="free-deli1">
                                                    <input type="radio" id="free-deli1" class="common-radio-btn" name="deliv_type" value="" <?=($deliv_type=='')?'checked':''?>>
                                                    <span class="common-radio-text">전체</span>
                                                </label>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#none" class="free-deli">
                                                <label class="common-radio-label" for="free-deli2">
                                                    <input type="radio" id="free-deli2" class="common-radio-btn" name="deliv_type" value="FREE" <?=($deliv_type=='FREE')?'checked':''?>>
                                                    <span class="common-radio-text">무료배송만</span>
                                                </label>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="select_wrap select_wrap_cate">
                                    <h4 class="srp-cate-tit srp-cate-tit5">가격</h4>
                                    <?
                                    $price_min = min($arr_sellingPrice);
                                    $price_max = max($arr_sellingPrice);

                                    //최소값, 최대값 재설정
                                    if ($price_min < 10000) $price_min = 1000; //1천원

                                    if ($price_max > 300000) $price_min = 100000;    //10만원
                                    if ($price_max > 3000000) $price_min = 1000000;   //100만원

                                    //기준금액단위 설정
                                    if( (($price_max - $price_min) > 3000000) && ($price_min > 1000000) ) {
                                        $limit = 1000000; //100만원
                                    } else if( (($price_max - $price_min) > 300000) && ($price_min > 100000) ){
                                        $limit = 100000; //10만원
                                    } else if( (($price_max - $price_min) < 30000)){
                                        $limit = 5000; //5천원
                                    } else {
                                        $limit = 10000; //1만원
                                    }

                                    $price_min = ceil($price_min / $limit) * $limit;
                                    $price_max = floor($price_max / $limit) * $limit;

                                    $price_range = ($price_max - $price_min) / 3;
                                    $price_range = floor($price_range / $limit) * $limit;
                                    ?>
                                    <ul id="srp-cate" class="srp-cate5">
                                        <li class="checkbox_area country">
                                            <a href="#none">
                                                <label class="common-radio-label" for="price0">
                                                    <input type="radio" id="price0" class="common-radio-btn" name="price_limit" value="" <?=($price_limit=='')?'checked':''?>>
                                                    <span class="common-radio-text">전체</span>
                                                </label>
                                            </a>
                                        </li>
                                        <li class="checkbox_area country">
                                            <a href="#none">
                                                <label class="common-radio-label" for="price1">
                                                    <?$range = '|'.(string)$price_min?>
                                                    <input type="radio" id="price1" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                    <span class="common-radio-text"><?=number_format($price_min)?>원 이하</span>
                                                </label>
                                            </a>
                                        </li>
                                        <li class="checkbox_area country">
                                            <?$range = (string)$price_min.'|'.(string)($price_min+($price_range*1))?>
                                            <a href="#none">
                                                <label class="common-radio-label" for="price2">
                                                    <input type="radio" id="price2" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                    <span class="common-radio-text"><?=number_format($price_min)?>원 ~ <?=number_format($price_min+($price_range*1))?>원</span>
                                                </label>
                                            </a>
                                        </li>
                                        <li class="checkbox_area country">
                                            <a href="#none">
                                                <label class="common-radio-label" for="price3">
                                                    <?$range = (string)$price_min+($price_range*1).'|'.(string)($price_min+($price_range*2))?>
                                                    <input type="radio" id="price3" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                    <span class="common-radio-text"><?=number_format($price_min+($price_range*1))?>원 ~ <?=number_format($price_min+($price_range*2))?>원</span>
                                                </label>
                                            </a>
                                        </li>
                                        <li class="checkbox_area country">
                                            <a href="#none">
                                                <label class="common-radio-label" for="price4">
                                                    <?$range = (string)($price_min+($price_range*2)).'|'.(string)($price_min+($price_range*3))?>
                                                    <input type="radio" id="price4" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                    <span class="common-radio-text"><?=number_format($price_min+($price_range*2))?>원 ~ <?=number_format($price_min+($price_range*3))?>원</span>
                                                </label>
                                            </a>
                                        </li>
                                        <li class="checkbox_area country">
                                            <a href="#">
                                                <label class="common-radio-label" for="price5">
                                                    <?$range = (string)($price_min+($price_range*3)).'|'?>
                                                    <input type="radio" id="price5" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                    <span class="common-radio-text"><?=number_format($price_min+($price_range*3))?>원 이상</span>
                                                </label>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="select_wrap select_wrap_cate">
                                    <h4 class="srp-cate-tit srp-cate-tit6">브랜드</h4>
                                    <?$search_brand = explode("|", substr($brand,1));?>
                                    <ul id="srp-cate" class="srp-cate6">
                                        <?
                                        $bidx1 = 1;
                                        foreach($arr_brand as $key=>$value){?>
                                            <li class="checkbox_area country">
                                                <a href="#none" <?=in_array($key,$brand_letter)?'class="on"':''?>><?=$key?></a>
                                                <ul id="srp-cate" class="srp-cate7" style="display: none">
                                                    <?
                                                    $bidx2 = 1;
                                                    foreach($value as $k=>$v){?>
                                                    <li class="checkbox_area country">
                                                        <a href="#none">
                                                            <input type="checkbox" class="checkbox" id="BrandCheck<?=$bidx1?>_<?=$bidx2?>" name="brand" value="<?=$k?>" <?=in_array($k,$search_brand)?'checked':''?>>
                                                            <label class="checkbox_label" for="BrandCheck<?=$bidx1?>_<?=$bidx2?>"><?=$v['NM']?></label>
                                                        </a>
                                                    </li>
                                                    <?$bidx2++;
                                                    }?>
                                                </ul>
                                            </li>
                                        <?$bidx1++;
                                        }?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- //카테고리 필터 -->

                        <!-- //shoping guide -->
                        <div class="confirm">
                            <button class="confirm" onclick="javaScript:search_goods('G','','');return false;">확인</button>
                        </div>
                    </nav>
                    <!-- //nav -->
                </form>
            </aside>

        </div>
        <!-- // 필터 -->

        <!-- 상품리스트 // -->
        <div class="prd-list-wrap">
            <ul class="prd-list prd-list--modify">
                <?foreach($list as $lt){?>
                    <li class="prd-item">
                        <div class="pic">
                            <a href="/goods/detail/<?=$lt['fields']['goods_cd']?>">
                                <div class="item auto-img">
                                    <div class="img">
                                        <img src="<?=$lt['fields']['img_url']?>" alt="<?=$lt['fields']['goods_nm']?>">
                                    </div>
                                </div>
                                <div class="tag-wrap">
                                    <?@$gPrice = $arr_price[$lt['fields']['goods_cd']]?>
                                    <?if(isset($gPrice['DEAL'])){?>
                                        <!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>-->
                                    <?}?>
                                    <?if($gPrice['GONGBANG']=='G'){?>
                                        <!--<span class="circle-tag class-prd"><em class="blk">공방<br>제작상품</em></span>-->
                                    <?}else if($gPrice['GONGBANG']=='C'){?>
                                        <!--<span class="circle-tag class"><em class="blk">에타<br>클래스</em></span>-->
                                    <?}?>
                                </div>
                            </a>
                        </div>
                        <div class="prd-info-wrap">
                            <a href="/goods/detail/<?=$lt['fields']['goods_cd']?>">
                                <dl class="prd-info">
                                    <dt class="prd-item-brand"><?=$lt['fields']['brand_nm']?></dt>
                                    <dd class="prd-item-tit"><?=$lt['fields']['goods_nm']?></dd>
                                    <dd class="prd-item-price">
                                        <?
                                        @$gPrice = $arr_price[$lt['fields']['goods_cd']];
                                        if($gPrice['COUPON_CD_S'] || $gPrice['COUPON_CD_G']){
                                            $price = $gPrice['SELLING_PRICE'] - ($gPrice['RATE_PRICE_S'] + $gPrice['RATE_PRICE_G'] ) - ($gPrice['AMT_PRICE_S'] + $gPrice['AMT_PRICE_G']);
                                            echo number_format($price);

                                            $sale_percent = (($gPrice['SELLING_PRICE'] - $price)/$gPrice['SELLING_PRICE']*100);
                                            $sale_percent = strval($sale_percent);
                                            $sale_percent_array = explode('.',$sale_percent);
                                            $sale_percent_string = $sale_percent_array[0];
                                            ?><span class="won">원</span><br>
                                            <del class="del-price"><?=number_format($gPrice['SELLING_PRICE'])?>원</del>
                                            <!--<span class="dc-rate">(<?=floor((($gPrice['SELLING_PRICE']-$price)/$gPrice['SELLING_PRICE'])*100)?>%<span class="spr-common ico-arrow-down"></span>)</span>-->
                                            <span class="dc-rate">(<?=floor((($gPrice['SELLING_PRICE']-$price)/$gPrice['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common ico-arrow-down"></span>)</span>
                                        <?}else{
                                            echo number_format($price = $gPrice['SELLING_PRICE']);
                                            ?><span class="won">원</span><br>
                                        <?}?>
                                    </dd>
                                </dl>
                                <ul class="prd-label-list">
                                    <?
                                    if($gPrice['COUPON_CD_S'] || $gPrice['COUPON_CD_G']){?>
                                        <li class="prd-label-item">쿠폰할인</li>
                                    <?}
                                    if($gPrice['GOODS_MILEAGE_SAVE_RATE'] > 0){
                                        ?>
                                        <li class="prd-label-item">마일리지</li>
                                    <?}
                                    if(($gPrice['PATTERN_TYPE_CD'] == 'FREE') || ( $gPrice['DELI_LIMIT'] > 0 && $price > $gPrice['DELI_LIMIT'])){
                                        ?>
                                        <li class="prd-label-item free_shipping">무료배송</li>
                                    <?}?>
                                </ul>
                            </a>
                        </div>
                    </li>
                <?}?>
            </ul>
        </div>
        <!-- // 상품리스트 -->
    <?}?>

    <?=$pagination?>

    <script src="/assets/js/common.js?ver=25"></script>
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

        //google_gtag
        <?if($gubun=='E'){
        $event_list = array();
        foreach($list as $key=> $lt){
            $event_list[$key]['id'] = $lt['PLAN_EVENT_CD'];
            $event_list[$key]['name'] = 'ETAH - promotion';
        }
        $event_list = json_encode($event_list);
        ?>
        var viewEvent_array = new Object();
        viewEvent_array = <?=$event_list?>;
        console.log(viewEvent_array);

        gtag('event', 'view_promotion', {
            "promotions": viewEvent_array
        });
        <?}else if($gubun=='M'){
        $magazine_list = array();
        foreach($list as $key=> $lt){
            $magazine_list[$key]['id'] = $lt['MAGAZINE_NO'];
            $magazine_list[$key]['name'] = 'ETAH - MAGAZINE';
        }
        $magazine_list = json_encode($magazine_list);
        ?>
        var viewMagazine_array = new Object();
        viewMagazine_array = <?=$magazine_list?>;
        console.log(viewMagazine_array);

        gtag('event', 'view_magazine', {
            "promotions": viewMagazine_array
        });
        <?}
        else if( ($gubun=='G') || ($gubun=='T') ){?>
        var viewItem_array = new Object();
        <? $goods_array = array();
        foreach($list as $key => $grow){
            $goods_array[$key]['id'       ] = $grow['fields']['goods_cd'];
            $goods_array[$key]['name'     ] = $grow['fields']['goods_nm'];
            $goods_array[$key]['list_name'] = 'viewItem_list';
            $goods_array[$key]['brand'] = $grow['fields']['brand_nm'];
            @$gPrice = $arr_price[$grow['fields']['goods_cd']];
            $goods_array[$key]['price'    ] = $gPrice['SELLING_PRICE'] - ($gPrice['RATE_PRICE_S'] + $gPrice['RATE_PRICE_G'] ) - ($gPrice['AMT_PRICE_S'] + $gPrice['AMT_PRICE_G']);
        }
        $goods_array = json_encode($goods_array);?>
        viewItem_array = <?=$goods_array?>;
        console.log(viewItem_array);
        gtag('event', 'view_item_list', {
            "items": viewItem_array
        });
        <?}?>
    </script>

    <script type="text/javascript">
        //====================================
        // 조건별 검색
        //====================================
        function search_goods(cgb, kind, val){
            var keyword = '<?=$keyword?>';
            var gb = '<?=$gubun?>';
            var tag_keyword = '<?=$tag_keyword?>';

            var category    = '<?=$category?>';
            var price_limit = '';
            var order_by    = '';
            var country     = '';
            var brand       = '';
            var deliv_type  = '';


            //카테고리
            if(kind=='C'){
                category = val;
            }

            //정렬
            order_by = $('input[name=order_by]:checked').val();


            //검색결과 - 상품/태그 페이지
            if(cgb=='G'){
                //국가
                $("input[name=country]:checked").each(function() {
                    country += '|'+$(this).val();
                });

                //배송
                deliv_type = $('input[name=deliv_type]:checked').val();

                //가격
                price_limit = $('input[name=price_limit]:checked').val();

                //브랜드
                $("input[name=brand]:checked").each(function() {
                    brand += '|'+$(this).val();
                });

                document.location.href = "/goods/search?keyword="+keyword+"&gb="+gb+"&tag_keyword="+tag_keyword+"&category="+category+"&price_limit="+price_limit+"&order_by="+order_by+"&country="+country+"&brand="+brand+"&deliv_type="+deliv_type;
            }
            //검색결과 - 기획전/매거진 페이지
            else {
                document.location.href = "/goods/search?keyword="+keyword+"&gb="+gb+"&category="+category+"&order_by="+order_by;
            }

        }
    </script>

