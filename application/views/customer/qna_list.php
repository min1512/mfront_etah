<link rel="stylesheet" href="/assets/css/customert_center.css?var=1.0">

<div class="content">
    <h2 class="page-title-basic">고객센터</h2>

    <!-- FAQ, 1:1문의, 묻고 답하기, 공지사항 // -->
    <div class="tab-customer-center">
        <!-- tab영역// -->
        <ul class="tab-common-list">
            <li class="tab-common-btn"><a href="/customer/faq" class="tab-common-btn-link"">FAQ</a></li>
            <li class="tab-common-btn"><a href="/customer/register_qna" class="tab-common-btn-link">1:1문의</a></li>
<!--            <li class="tab-common-btn active"><a href="#QnaListTab" class="tab-common-btn-link">묻고 답하기</a></li>-->
            <li class="tab-common-btn"><a href="/customer/notice" class="tab-common-btn-link">공지사항</a></li>
        </ul>
        <!-- //tab영역 -->

        <!-- 묻고 답하기(리스트) // -->
        <div id="NoticeTab" class="notice-content-wrap">
            <h3 class="info-title info-title--sub">묻고 답하기</h3>
            <ul class="customer-notice-list">
                <?if(empty($qna_list)){?>
                    <li class="customer-notice-item">
                        <a href="#" class="customer-notice-link">
                        <span class="notice-title">등록된 문의가 없습니다.</span></a>
                    </li>
                <?}else {?>
                <? foreach($qna_list as $row){?>
                    <li class="customer-notice-item">
                        <a href="javaScript:jsOpen(<?=$row['CS_NO']?>, '<?=$row['CUST_NO']?>','<?=$row['SECRET_YN']?>');" class="customer-notice-link">
                            <!--                        <a href="/customer/notice_detail/--><?//=$row['CS_NO']?><!--" class="customer-notice-link">-->
                            <span class="notice-title">
                                <?if($row['A_NO'] != null){?>
                                    [답변완료] -
                                <?}else{?>
                                    [미답변] -
                                <?}?>
                                <?if($row['SECRET_YN'] == 'Y'){?>
                                    비밀글입니다.
                                <?}else{?>
                                    <?=$row['Q_TITLE']?>
                                <?}?>
                            </span>
                            <span class="notice-date"><?=date('Y-m-d', strtotime($row['Q_REG_DT']))?></span>
                        </a>
                    </li>
                <?}}?>
            </ul>
            <?=$pagination?><br/>
        </div>
        <!-- 묻고 답하기(리스트) // -->
    </div>
    <!-- // FAQ, 1:1문의, 묻고 답하기, 공지사항 -->

    <script type="text/javaScript">
        //=====================================
        // 공지 클릭시 펼쳐보기
        //=====================================
        function jsOpen(idx, id, secret){
            if(secret == 'N'){
                location.href = '/customer/qna_detail/'+idx;
//                }
            }else{
                <?if(!$this->session->userdata('EMS_U_ID_') || $this->session->userdata('EMS_U_ID_') == 'GUEST'){?>
                alert('비공개 문의내역은 작성자 본인만 확인하실 수 있습니다.');
                <?}else{?>
                var no = <?=$this->session->userdata('EMS_U_NO_')?>;
                if(no == id){
                    location.href = '/customer/qna_detail/'+idx;
                }else{
                    alert('비공개 문의내역은 작성자 본인만 확인하실 수 있습니다.');
                }
                <?}?>
            }
        }
    </script>