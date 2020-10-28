<link rel="stylesheet" href="/assets/css/customert_center.css?var=1.1">

<div class="content">
    <h2 class="page-title-basic">고객센터</h2>

    <!-- FAQ, 1:1문의, 묻고 답하기, 공지사항 // -->
    <div class="tab-customer-center">
        <!-- tab영역// -->
        <ul class="tab-common-list">
            <li class="tab-common-btn"><a href="/customer/faq" class="tab-common-btn-link">FAQ</a></li>
            <li class="tab-common-btn"><a href="/customer/register_qna" class="tab-common-btn-link">1:1문의</a></li>
<!--            <li class="tab-common-btn active"><a href="#QnaListTab" class="tab-common-btn-link">묻고 답하기</a></li>-->
            <li class="tab-common-btn"><a href="/customer/notice" class="tab-common-btn-link">공지사항</a></li>
        </ul>
        <!-- //tab영역 -->

        <!-- 묻고 답하기(상세) // -->
        <div class="notice-content-wrap notice-content-wrap--content">
            <h3 class="info-title info-title--sub">묻고 답하기</h3>
            <a href="/customer/qna_list_all" class="btn-white">목록</a>
            <div class="customer-notice-content-title">
                <span class="notice-title">
                    <?if(@$qna['A_NO'] != null){?>
                        [답변완료] -
                    <?}else{?>
                        [미답변] -
                    <?}?>
                    <?=@$qna['Q_TITLE']?></span>
                <span class="notice-date"><?=@date('Y-m-d', strtotime($qna['Q_REG_DT']))?></span>
            </div>
            <div class="customer-notice-content-txt">
                <table>
                    <colgroup>
                        <col style="width:15%;" />
                        <col />
                    </colgroup>
                    <tr>
                        <td class="left"><span>Q</span></td>
                        <td><?=@$qna['Q_CONTENTS']?></td>
                    </tr>
                </table>
            </div>
            <?if(@$qna['GOODS_CD'] != null || @$qna['ORDER_GOODS_CD'] != null){?>
                <div class="customer-qna-content-txt">
                    <table>
                        <colgroup>
                            <col style="width:15%;" />
                            <col />
                        </colgroup>
                        <tr>
                            <td style="float: left"><span>상품 - </span></td>
                            <td><?if(@$qna['GOODS_CD']){?>
                                    <div class="prd_info">
                                        <div class="img"><img src="<?=@$qna['IMG_URL']?>" width="100" height="100" alt=""></div>
                                        <div class="goods_detail__string">
                                            <p class="goods_cd"><?=@$qna['GOODS_CD']?></p>
                                            <p class="name"><?=@$qna['GOODS_NM']?></p>
                                            <p class="description"><?=@$qna['PROMOTION_PHRASE']?></p>
                                        </div>
                                    </div>
                                <?}else if(@$qna['ORDER_GOODS_CD']){?>
                                    <div class="prd_info">
                                        <div class="img"><img src="<?=@$qna['ORDER_GOODS_IMG_URL']?>" width="100" height="100" alt=""></div>
                                        <div class="goods_detail__string">
                                            <p class="goods_cd"><?=@$qna['ORDER_GOODS_CD']?></p>
                                            <p class="name"><?=@$qna['ORDER_GOODS_NM']?></p>
                                            <p class="option"><?=@$qna['ORDER_GOODS_OPTION_NM']?></p>
                                        </div>
                                    </div>
                                <?}?></td>
                        </tr>
                    </table>
                </div>
            <?}?>
            <?if(@$qna['A_CONTENTS'] != null){?>
                <div class="customer-qna-content-txt" style="border-top: solid #ffffff;">
                    <table>
                        <colgroup>
                            <col style="width:15%;" />
                            <col />
                        </colgroup>
                        <tr>
                            <td class="left"><span>A</span></td>
                            <td><?=@$qna['A_CONTENTS']?></td>

                        </tr>
                    </table>
                </div>
            <?}?>
            <ul class="common-btn-box">
                <li class="common-btn-item"><a href="/customer/qna_list_all" class="btn-gray btn-gray--big">목록보기</a></li>
            </ul>
        </div>
        <!-- // 묻고 답하기(상세) -->
    </div>
    <!-- // FAQ, 1:1문의, 묻고 답하기, 공지사항 -->