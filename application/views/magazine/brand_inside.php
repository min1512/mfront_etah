<link rel="stylesheet" href="/assets/css/display.css">
<div class="content">
    <h3 class="info-title info-title--sub">브랜드인사이드</h3>

    <!-- 상품리스트// -->
    <div class="prd-list-wrap">
        <ul class="prd-list prd-list--modify">
            <? foreach($brand_inside as $row){	?>
                <li class="prd-item">
                    <a href=<?=$row['LINK_URL']?> class="prd-link">
                        <img src="<?=$row['IMG_URL']?>" alt="버플리 원목 2700 거실장 세트" onerror="this.src='http://ui.etah.co.kr/assets/images/data/main_magazin_6.jpg'">
                    </a>
                    <a href="#" class="prd-link-text">#<?=$row['NAME']?></a>
                </li>
            <? }?>
            <!--			<li class="prd-item">
                            <a href="#" class="prd-link">
                                <img src="../assets/images/data/prd_item2.jpg" alt="버플리 원목 2700 거실장 세트">
                            </a>
                            <a href="#" class="prd-link-text">#마블 패턴 시계와</a>
                        </li>
                        <li class="prd-item">
                            <a href="#" class="prd-link">
                                <img src="../assets/images/data/prd_item3.jpg" alt="버플리 원목 2700 거실장 세트">
                            </a>
                            <a href="#" class="prd-link-text">#마블 패턴 시계와 보타니컬 선반</a>
                        </li>
                        <li class="prd-item">
                            <a href="#" class="prd-link">
                                <img src="../assets/images/data/prd_item4.jpg" alt="버플리 원목 2700 거실장 세트">
                            </a>
                            <a href="#" class="prd-link-text">#마블 패턴 시계와 보타니컬 선반</a>
                        </li>
                        <li class="prd-item">
                            <a href="#" class="prd-link">
                                <img src="../assets/images/data/prd_item5.jpg" alt="버플리 원목 2700 거실장 세트">
                            </a>
                            <a href="#" class="prd-link-text">#마블 패턴 시계와 보타니컬 선반</a>
                        </li>
                        <li class="prd-item">
                            <a href="#" class="prd-link">
                                <img src="../assets/images/data/prd_item6.jpg" alt="버플리 원목 2700 거실장 세트">
                            </a>
                            <a href="#" class="prd-link-text">#마블 패턴 시계와 보타니컬 선반</a>
                        </li>
                        <li class="prd-item">
                            <a href="#" class="prd-link">
                                <img src="../assets/images/data/prd_item7.jpg" alt="버플리 원목 2700 거실장 세트">
                            </a>
                            <a href="#" class="prd-link-text">#마블 패턴 시계와 보타니컬 선반</a>
                        </li>
                        <li class="prd-item">
                            <a href="#" class="prd-link">
                                <img src="../assets/images/data/prd_item8.jpg" alt="버플리 원목 2700 거실장 세트">
                            </a>
                            <a href="#" class="prd-link-text">#마블 패턴 시계와 보타니컬 선반</a>
                        </li>
                        <li class="prd-item">
                            <a href="#" class="prd-link">
                                <img src="../assets/images/data/prd_item1.jpg" alt="버플리 원목 2700 거실장 세트">
                            </a>
                            <a href="#" class="prd-link-text">#마블 패턴 시계와 보타니컬 선반</a>
                        </li>
                        <li class="prd-item">
                            <a href="#" class="prd-link">
                                <img src="../assets/images/data/prd_item1.jpg" alt="버플리 원목 2700 거실장 세트">
                            </a>
                            <a href="#" class="prd-link-text">#마블 패턴 시계와 보타니컬 선반</a>
                        </li>	-->
        </ul>
    </div>
    <!-- //상품리스트-->

    <!-- 페이징 // -->
    <?=$pagination?>
    <!-- // 페이징  -->