<?php
/**
 * @property goods_m $goods_m
 * Created by PhpStorm.
 * User: 박상현
 * Date:
 */
class Goods extends MY_Controller
{
    protected $methods = array(
        //'index_get' => array('log' => 0)
    );

    function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: api_key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }

        parent::__construct();


        /**
         * 로그 기록 여부 설정
         */
        $method_id = explode(".", $this->uri->segment(2));
        if( ! empty($method_id[0])) {
            $method_type = strtolower($method);
            $funtion = $method_id[0]."_".$method_type;
            if(!config_item('log')) $this->methods[$funtion] = array('log' => 0);
        }

        //API Key 사용시 해당 값을 설정하면 키검사를 하지 않음
        $this->_allow = TRUE;

        /* model_m */
        $this->load->model('goods_m');
        $this->load->model('main_m');
        $this->load->model('cart_m');
        $this->load->model('mywiz_m');
    }

    /**
     * 상품 상세 페이지
     */
    public function detail_get()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $goods_code = $this->uri->segment(3, '');

        //유입경로 확인
        $utm = $this->input->get();
        if(isset($utm)){
            if(strpos(@$utm['utm_source'], 'wonder_shopping') !== false){    //원더쇼핑 유입
                setcookie('funnel', 'wonder', time() + 3600,'/');
            }
        }


        $param = array();

        //상품 클릭수 증가
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; //AWS ping 접속 제외
        if(!empty($ip)) {
            $click = $this->goods_m->goods_click($goods_code);
        }

        //상품 상세 정보 구하기
        $goods = $this->goods_m->get_goods_detail_info($goods_code);
        //연결된 태그이름 배열로 저장
        if(!empty($goods['TAG_NM'])){
            $data['tag'] = explode('|', $goods['TAG_NM']);
        }

        $data['coupon_banner'] = $this->main_m->get_Main_Banner('MOB_GOODS_BANNER');   //시크릿딜 이미지 구하기
        if(empty($goods)) {    //상품코드에 일치하는 상품이 없을 경우 에러페이지 보여주기
            /**
             * 최근 본 상품 쿠키 저장
             */
            $this->load->library('etah_lib');

            /**
             * 상단 카테고리 데이타
             */
            $this->load->library('etah_lib');
            $category_menu = $this->etah_lib->get_category_menu();
            $data['menu'] = $category_menu['category'];
            $data['cart_cnt'] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));    //장바구니 갯수 가져오기
            $data['header_gb'] = 'none';
            $data['footer_gb'] = 'detail';

            $this->load->view('include/header', $data);
            $this->load->view('template/error_404');
            $this->load->view('include/footer');
        }else {
            //네이버페이 구매버튼 가능여부
            if($goods['CATEGORY_MNG_CD2']==24010000 || $goods['GOODS_STATE_CD']!='03'){ //공방클래스, 품절/일시정지
                $data['ENABLE'] = 'N';
            } else {
                $data['ENABLE'] = 'Y';
            }

            //상품 구매가이드 구하기 (상품&카테고리&브랜드)
            $goods_buy_guide = $this->goods_m->get_goods_guide_info($goods_code);
            $data['goods_buy_guide'] = $goods_buy_guide;

            if ($goods_buy_guide) {
                $data['goods_buy_guide'] = $goods_buy_guide;
            } else {
                $data['goods_buy_guide'] = '';
            }

            //상품 쿠폰 정보 구하기
            $param['goods_code'] = $goods_code;
            $param['brand_code'] = $goods['BRAND_CD'];
            $param['category_mng_code'] = $goods['CATEGORY_MNG_CD3'];
            $goods_seller_coupon = $this->goods_m->get_goods_coupon_info($param, 'SELLER');
            $goods_item_coupon = $this->goods_m->get_goods_coupon_info($param, 'GOODS');

            //상품 정보고시 구하기
            $goods_extend = $this->goods_m->get_goods_extend($param);
            if ($goods_extend) {
                $goods_extend_info = $this->goods_m->get_goods_exnted_info($goods_extend['kind']);

                $data['goods_extend'] = $goods_extend;
                $data['goods_extend_info'] = $goods_extend_info;
            }

            //상품 추가배송비 지역 구하기
            if ($goods['ADD_DELIVERY']) {
                $goods_add_deli = $this->goods_m->get_goods_add_deli($param);
                $data['goods_add_deli'] = $goods_add_deli;
            }

            //상품 배송불가지역 구하기
            if ($goods['NO_DELIVERY']) {
                $goods_no_deli = $this->goods_m->get_goods_no_deli($param);
                $data['goods_no_deli'] = $goods_no_deli;
            }

            //상품 이미지 구하기
            $goods_img = $this->goods_m->get_goods_img($goods_code);
//            echo var_dump($goods_img[0]);
            for ($i = 0; $i < count($goods_img); $i++) {
                $data['img'][$i] = $goods_img[$i];
            }

            //상품 설명 리스트 구하기
            $goods_desc = $this->goods_m->get_goods_desc($goods_code);
            $data['goods_desc'] = $goods_desc;

            //상품 태그 구하기
            $data['tag'] = $this->goods_m->get_goods_tag($goods_code);

            //에타 이벤트 배너
            $data['event'] = $this->main_m->get_Main_Banner('MOB_GOODS_BANNER');

            //MD추천멘트
            $data['mdTalk'] = $this->goods_m->get_mdTalk($goods_code);

            //상품이 포함된 기획전
            $plan_event = $this->goods_m->get_plan_event_in_goods('A', $goods_code, '');
            if (count($plan_event) == 0) { //상품 포함된 기획전 없을때 -> 인기기획전
                $plan_event = $this->goods_m->get_plan_event_in_goods('B', $goods_code, $goods['CATEGORY_MNG_CD1']);
            }
            $data['plan_event'] = $plan_event;

            //상품이 포함된 매거진
            $magazine = $this->goods_m->get_magazine_in_goods('A', $goods_code, '');
            if (count($magazine) == 0) { //상품 포함된 매거진 없을때 -> 인기매거진
                $magazine = $this->goods_m->get_magazine_in_goods('B', $goods_code, $goods['CATEGORY_MNG_CD1']);
            }
            $data['magazine'] = $magazine;

            //카테고리 베스트 상품
            $data['category_goods'  ] = $this->goods_m->get_goods('C', $goods['CATEGORY_MNG_CD3'], $goods_code, $goods['BRAND_CD'],'');

            //브랜드 베스트 상품
            $data['brand_goods'     ] = $this->goods_m->get_goods('B', '', $goods_code, $goods['BRAND_CD'],'');

//            //추천 상품 구하기 2019.01.31
//            if($goods['CATEGORY_MNG_CD2'] == 24010000) {
//                $recommend_goods = $this->goods_m->get_recommend_goods('', $goods['BRAND_CD'], $goods_code, $goods['CATEGORY_MNG_CD3']);
//                $data['recommend_goods'] = $recommend_goods;
//            } else {
//                $recommend_goods = $this->goods_m->get_recommend_goods('U', $goods['BRAND_CD'], $goods_code, $goods['CATEGORY_MNG_CD3']);
//                $data['recommend_goods'] = $recommend_goods;
//            }
//
//            //하단 추천상품 구하기 2019.02.01
//            $best_goods = $this->goods_m->get_category_recommend_goods($goods);
//            $data['best_goods'] = $best_goods;

            //상품 옵션 구하기
            $goods_option = $this->goods_m->get_goods_option($goods_code);
            $data['goods_option'] = $goods_option;

            if ($goods_option) {
                $goods_moption1 = $this->goods_m->get_goods_moption($goods_code, 'M_OPTION_1');
                $data['goods_moption1'] = $goods_moption1;

                if ($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_1') {
                    $goods_moption2 = $this->goods_m->get_goods_moption($goods_code, 'M_OPTION_2');
                    $data['goods_moption2'] = $goods_moption2;
                }

                if (($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_1') && ($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_2')) {
                    $goods_moption3 = $this->goods_m->get_goods_moption($goods_code, 'M_OPTION_3');
                    $data['goods_moption3'] = $goods_moption3;
                }

                if (($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_1') && ($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_2') && ($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_3')) {
                    $goods_moption4 = $this->goods_m->get_goods_moption($goods_code, 'M_OPTION_4');
                    $data['goods_moption4'] = $goods_moption4;
                }

                if (($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_1') && ($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_2') && ($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_3') && ($goods_option[0]['MOPTION_RESULT'] != 'MOPTION_4')) {
                    $goods_moption5 = $this->goods_m->get_goods_moption($goods_code, 'M_OPTION_5');
                    $data['goods_moption5'] = $goods_moption5;
                }

                //상품옵션구하기 테스트
                if ($goods_option[0]['MOPTION_RESULT'] == 'M_OPTION_5') {
                    $max_moption = '5';
                } else if ($goods_option[0]['MOPTION_RESULT'] == 'M_OPTION_4') {
                    $max_moption = '4';
                } else if ($goods_option[0]['MOPTION_RESULT'] == 'M_OPTION_3') {
                    $max_moption = '3';
                } else if ($goods_option[0]['MOPTION_RESULT'] == 'M_OPTION_2') {
                    $max_moption = '2';
                } else {
                    $max_moption = '1';
                }

                $template_option_list = $this->goods_m->get_template_option_list($goods_code, $max_moption);
                $data['template_option_list'] = $template_option_list;
                $data['MOPTION_RESULT'] = $goods_option[0]['MOPTION_RESULT'];
                $data['MOPTION_RESULT_NO'] = $max_moption;
            } else {
                $data['goods_moption1'] = '';
                $data['goods_moption2'] = '';
                $data['goods_moption3'] = '';
                $data['goods_moption4'] = '';
                $data['goods_moption5'] = '';
                $data['MOPTION_RESULT'] = '';
                $data['template_option_list'] = '';
            }

            $data['goods'] = $goods;

            $coupon_info = "";
            $coupon_price = 0;

            //================================== 판매가 기준 할인 계산법
            $seller_coupon_percent = 0;
            $seller_coupon_amt = 0;
            $item_coupon_percent = 0;
            $item_coupon_amt = 0;

            if ($goods_seller_coupon) {    //상품에 셀러쿠폰이 붙어있을경우
                if ($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'RATE') {
                    $seller_coupon_amt = floor($goods['SELLING_PRICE'] * $goods_seller_coupon['COUPON_FLAT_RATE'] / 1000);
                    $seller_coupon_percent = $goods_seller_coupon['COUPON_FLAT_RATE'] / 10;

                    if ($goods_seller_coupon['MAX_DISCOUNT'] != 0 && $goods_seller_coupon['MAX_DISCOUNT'] < $seller_coupon_amt) {    //최대금액을 넘을경우 최대금액으로 적용
                        $seller_coupon_amt = $goods_seller_coupon['MAX_DISCOUNT'];
                    }
                } else if ($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'AMT') {
                    $seller_coupon_amt = $goods_seller_coupon['COUPON_FLAT_AMT'];
                    $seller_coupon_percent = floor($goods_seller_coupon['COUPON_FLAT_AMT'] / $goods['SELLING_PRICE'] * 100);
                }

                $data['goods']['SELLER_COUPON_CD'] = $goods_seller_coupon['COUPON_CD'];
                $data['goods']['SELLER_COUPON_METHOD'] = $goods_seller_coupon['COUPON_DC_METHOD_CD'];
                $data['goods']['SELLER_COUPON_FLAT_RATE'] = $goods_seller_coupon['COUPON_FLAT_RATE'];
                $data['goods']['SELLER_COUPON_FLAT_AMT'] = $goods_seller_coupon['COUPON_FLAT_AMT'];
                $data['goods']['SELLER_COUPON_MAX_DISCOUNT'] = $goods_seller_coupon['MAX_DISCOUNT'];
                $data['goods']['SELLER_COUPON_AMT'] = $seller_coupon_amt;
            }

            if ($goods_item_coupon) {        //상품에 아이템쿠폰이 붙어있을경우
                if ($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'RATE') {
                    $item_coupon_amt = floor($goods['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000);
                    $item_coupon_percent = $goods_item_coupon['COUPON_FLAT_RATE'] / 10;

                    if ($goods_item_coupon['MAX_DISCOUNT'] != 0 && $goods_item_coupon['MAX_DISCOUNT'] < $item_coupon_amt) {    //최대금액을 넘을경우 최대금액으로 적용
                        $item_coupon_amt = $goods_item_coupon['MAX_DISCOUNT'];
                    }
                } else if ($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'AMT') {
                    $item_coupon_amt = $goods_item_coupon['COUPON_FLAT_AMT'];
                    $item_coupon_percent = floor($goods_item_coupon['COUPON_FLAT_AMT'] / $goods['SELLING_PRICE'] * 100);
                }

                $data['goods']['ITEM_COUPON_CD'] = $goods_item_coupon['COUPON_CD'];
                $data['goods']['ITEM_COUPON_METHOD'] = $goods_item_coupon['COUPON_DC_METHOD_CD'];
                $data['goods']['ITEM_COUPON_FLAT_RATE'] = $goods_item_coupon['COUPON_FLAT_RATE'];
                $data['goods']['ITEM_COUPON_FLAT_AMT'] = $goods_item_coupon['COUPON_FLAT_AMT'];
                $data['goods']['ITEM_COUPON_MAX_DISCOUNT'] = $goods_item_coupon['MAX_DISCOUNT'];
                $data['goods']['ITEM_COUPON_AMT'] = $item_coupon_amt;
            }

            if ($seller_coupon_amt + $item_coupon_amt > 0) {    //할인금액이 있을경우
                $data['goods']['COUPON_AMT'] = $seller_coupon_amt + $item_coupon_amt;
                $data['goods']['COUPON_PRICE'] = $goods['SELLING_PRICE'] - $seller_coupon_amt - $item_coupon_amt;
                $data['goods']['COUPON_SALE_PERCENT'] = $seller_coupon_percent + $item_coupon_percent;
            } else {
                $data['goods']['COUPON_AMT'] = 0;
                $data['goods']['COUPON_PRICE'] = $goods['SELLING_PRICE'];
                $data['goods']['COUPON_SALE_PERCENT'] = 0;
            }

            log_message("DEBUG", "===================================openddd");

            /**
             * 상품평 템플릿 구성
             */
            $temp = array();
            $temp['goods_code'] = $goods_code;
            $temp['mid_category_code'] = $goods['CATEGORY_MNG_CD2'];
            $paging_limit = 5;
            $goods_comment_num = $this->goods_m->get_goods_comment_cnt($goods_code);        //상품평 전체 갯수 불러오기
            $total_goods_comment_val = $this->goods_m->get_goods_comment($goods_code, 0, 0);        //상품평 전체 평점 불러오기
            $goods_comment = $this->goods_m->get_goods_comment($goods_code, 1, $paging_limit);    //상품평 불러오기

            for($i=0;$i<count($goods_comment);$i++){
                $iparam['comment_no'] = $goods_comment[$i]['CUST_GOODS_COMMENT'];
                $goods_comment[$i]['FILE_PATH'] = $this->mywiz_m->get_goods_comment_file($iparam);
            }

            $temp['total_comment_val'] = $total_goods_comment_val;
            $temp['goods_comment'] = $goods_comment;

            //페이징 구성
            $temp['page'] = 1;        //현재페이지
            $temp['total_page'] = ceil($goods_comment_num['cnt'] / $paging_limit);        //전체 페이지 갯수
            $temp['limit_num'] = $paging_limit;                    //한 페이지에 보여주는 갯수
            $temp['total_cnt'] = $goods_comment_num['cnt'];        //전체 갯수
            $data['cmt_total'] = $goods_comment_num['cnt'];        //상품평 전체 갯수

            $comment_template = $this->load->view('goods/template_comment', $temp, TRUE);
            $data['comment_template'] = $comment_template;

            /**
             * 상품 문의 템플릿 구성
             */
            $paging_limit = 5;
            $goods_qna_num = $this->goods_m->get_goods_qna_cnt($goods_code);
            $goods_qna = $this->goods_m->get_goods_qna($goods_code, 1, $paging_limit);
            $temp['goods_qna'] = $goods_qna;

            //페이징 구성
            $temp['page'] = 1;        //현재페이지
            $temp['total_page'] = ceil($goods_qna_num['cnt'] / $paging_limit);        //전체 페이지 갯수
            $temp['limit_num'] = $paging_limit;                //한 페이지에 보여주는 갯수
            $temp['total_cnt'] = $goods_qna_num['cnt'];        //전체 갯수

            $qna_template = $this->load->view('goods/template_qna', $temp, TRUE);
            $data['qna_template'] = $qna_template;
            $data['title'] = $goods['GOODS_NM'];
            //$data['img'] = $goods['img'][0];
            $data['qna_total'] = $goods_qna_num['cnt'];        //상품평 전체 갯수

            /**
             * 상품 구매가이드 템플릿 구성
             */
            $temp = array();
            $temp['goods_name'] = $goods['GOODS_NM'];
            $temp['category_name'] = $goods['CATEGORY_MNG_NM3'];
            $temp['brand_name'] = $goods['BRAND_NM'];
            $temp['goods_buy_guide'] = $goods_buy_guide;

            $data['goods_buy_guide_template'] = $this->load->view('goods/template_guide', $temp, TRUE);


            /**
             * 상세페이지 들어오기 전 URL 저장
             */
            $returnUrl = ($this->agent->is_referral()) ? $this->agent->referrer() : '/';
            if (preg_match('/member\/login/i', $returnUrl)) {
                $returnUrl = '/';
            }

            if (strpos($returnUrl, 'join_finish')) {
                $returnUrl = '/';
            }

            if (isset($_GET['return_url'])) {
                $returnUrl = $_GET['return_url'];
            }

            $data['returnUrl'] = $returnUrl;


            /**
             * 최근 본 상품 쿠키 저장
             */
            $this->load->library('etah_lib');
            $this->etah_lib->set_cookie_new_goods($goods_code);


            /**
             * 상단 카테고리 데이타
             */
            $this->load->library('etah_lib');
            $category_menu = $this->etah_lib->get_category_menu();
            $data['menu'] = $category_menu['category'];
            $data['cart_cnt'] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));    //장바구니 갯수 가져오기
//            $data['header_gb'] = 'none';
            $data['footer_gb'] = 'detail';

            $this->load->view('include/header', $data);
            $this->load->view('goods/detail');
            $this->load->view('include/footer');

            //2018.06.13 대진침대 홈화면 리다이렉트
            if($goods_code == 1100225 || $goods_code == 1100223){
                redirect('/');
            }
        }
    }

    public function detail_brand_plus_post()
    {
        $param			= $this->input->post();

        $data['brand_goods'] = $this->goods_m->get_goods('B', '', $param['goods_cd'], $param['brand_cd'], $param['seq']);


        if( empty($data['brand_goods']) ) {
            $this->response(array('status' => 'fail', 'message' => '더이상 상품이 없습니다.'), 200);
        }else {
            $goods_template = $this->load->view('goods/detail_brand_plus', $data, TRUE);
            $this->response(array('status' => 'ok', 'message' => $goods_template), 200);

        }
    }

    /**
     * 상품평 페이징
     */
    public function comment_paging_post()
    {
        $param			= $this->input->post();
        $goods_code	= $param['goods_code'];
        $page			= $param['page'];
        $limit			= $param['limit'];

        //Load MODEL
        $this->load->model('goods_m');
        $this->load->model('mywiz_m');

        $goods_comment = $this->goods_m->get_goods_comment($goods_code, $page, $limit);

        for($i=0;$i<count($goods_comment);$i++){
            $iparam['comment_no'] = $goods_comment[$i]['CUST_GOODS_COMMENT'];
            $goods_comment[$i]['FILE_PATH'] = $this->mywiz_m->get_goods_comment_file($iparam);
        }

        $this->response(array('status' => 'ok', 'comment' => $goods_comment), 200);
    }

    /**
     * 상품 문의 페이징
     */
    public function qna_paging_post()
    {
        $param			= $this->input->post();
        $goods_code	= $param['goods_code'];
        $page			= $param['page'];
        $limit			= $param['limit'];

        //Load MODEL
        $this->load->model('goods_m');

        $goods_qna = $this->goods_m->get_goods_qna($goods_code, $page, $limit);

        $this->response(array('status' => 'ok', 'qna' => $goods_qna), 200);

    }

    /**
     * 상품 상세 쿠폰 레이어
     */
    public function coupon_layer_post()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $this->load->model('goods_m');
        $this->load->model('cart_m');

        $param = $this->input->post();

        //상품 상세 정보 구하기
        $goods = $this->goods_m->get_goods_detail_info($param['goods_code']);

        //상품 쿠폰 정보 구하기
        $param['brand_code'	] = $goods['BRAND_CD'];
        $param['category_mng_code'] = $goods['CATEGORY_MNG_CD3'];

        $goods_seller_coupon  = $this->goods_m->get_goods_coupon_info($param, 'SELLER');
        $goods_item_coupon	  = $this->goods_m->get_goods_coupon_info($param, 'GOODS');

        $data['goods'] = $goods;

        $coupon_info = "";
        $coupon_price = 0;

//================================== 판매가 기준 할인 계산법
        $seller_coupon_percent	= 0;
        $seller_coupon_amt		= 0;
        $item_coupon_percent	= 0;
        $item_coupon_amt		= 0;

        if($goods_seller_coupon){	//상품에 셀러쿠폰이 붙어있을경우
            if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
                $seller_coupon_amt = floor($goods['SELLING_PRICE'] * $goods_seller_coupon['COUPON_FLAT_RATE'] / 1000);
                $seller_coupon_percent = $goods_seller_coupon['COUPON_FLAT_RATE']/10;

                if($goods_seller_coupon['MAX_DISCOUNT'] != 0 && $goods_seller_coupon['MAX_DISCOUNT'] < $seller_coupon_amt){	//최대금액을 넘을경우 최대금액으로 적용
                    $seller_coupon_amt = $goods_seller_coupon['MAX_DISCOUNT'];
                }
            } else if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
                $seller_coupon_amt = $goods_seller_coupon['COUPON_FLAT_AMT'];
                $seller_coupon_percent = floor($goods_seller_coupon['COUPON_FLAT_AMT']/$goods['SELLING_PRICE']*100);
            }

            $data['goods']['SELLER_COUPON_CD'			] = $goods_seller_coupon['COUPON_CD'];
            $data['goods']['SELLER_COUPON_METHOD'		] = $goods_seller_coupon['COUPON_DC_METHOD_CD'];
            $data['goods']['SELLER_COUPON_FLAT_RATE'	] = $goods_seller_coupon['COUPON_FLAT_RATE'];
            $data['goods']['SELLER_COUPON_FLAT_AMT'		] = $goods_seller_coupon['COUPON_FLAT_AMT'];
            $data['goods']['SELLER_COUPON_MAX_DISCOUNT'	] = $goods_seller_coupon['MAX_DISCOUNT'];
            $data['goods']['SELLER_COUPON_AMT'			] = $seller_coupon_amt;
        }

        if($goods_item_coupon){		//상품에 아이템쿠폰이 붙어있을경우
            if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
                $item_coupon_amt = floor($goods['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000);
                $item_coupon_percent = $goods_item_coupon['COUPON_FLAT_RATE']/10;

                if($goods_item_coupon['MAX_DISCOUNT'] != 0 && $goods_item_coupon['MAX_DISCOUNT'] < $item_coupon_amt){	//최대금액을 넘을경우 최대금액으로 적용
                    $item_coupon_amt = $goods_item_coupon['MAX_DISCOUNT'];
                }
            } else if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
                $item_coupon_amt = $goods_item_coupon['COUPON_FLAT_AMT'];
                $item_coupon_percent = floor($goods_item_coupon['COUPON_FLAT_AMT']/$goods['SELLING_PRICE']*100);
            }

            $data['goods']['ITEM_COUPON_CD'				] = $goods_item_coupon['COUPON_CD'];
            $data['goods']['ITEM_COUPON_METHOD'			] = $goods_item_coupon['COUPON_DC_METHOD_CD'];
            $data['goods']['ITEM_COUPON_FLAT_RATE'		] = $goods_item_coupon['COUPON_FLAT_RATE'];
            $data['goods']['ITEM_COUPON_FLAT_AMT'		] = $goods_item_coupon['COUPON_FLAT_AMT'];
            $data['goods']['ITEM_COUPON_MAX_DISCOUNT'	] = $goods_item_coupon['MAX_DISCOUNT'];
            $data['goods']['ITEM_COUPON_AMT'			] = $item_coupon_amt;
        }
//var_dump($seller_coupon_percent);
//var_dump($item_coupon_percent);
//var_dump($seller_coupon_amt);
//var_dump($item_coupon_amt);
        if($seller_coupon_amt + $item_coupon_amt > 0){	//할인금액이 있을경우
            $data['goods']['COUPON_AMT'		] = $seller_coupon_amt + $item_coupon_amt;
            $data['goods']['COUPON_PRICE'	] = $goods['SELLING_PRICE'] - $seller_coupon_amt - $item_coupon_amt;
            $data['goods']['COUPON_SALE_PERCENT'] = $seller_coupon_percent + $item_coupon_percent;
        } else {
            $data['goods']['COUPON_AMT'			] = 0;
            $data['goods']['COUPON_PRICE'		] = $goods['SELLING_PRICE'];
            $data['goods']['COUPON_SALE_PERCENT'] = 0;
        }

        /** 사용 가능한 쿠폰 리스트 가져오기 */
        $auto_coupon = $this->cart_m->get_coupon_info($param, 'AUTO');
        $cust_coupon = $this->cart_m->get_coupon_info($param, 'ADD');


        for($i = 0; $i<count($auto_coupon); $i++){
            if($auto_coupon[$i]['COUPON_DC_METHOD_CD'] == 'RATE') {
                $coupon_num = explode('.', $auto_coupon[$i]['COUPON_SALE']);

                if ($coupon_num[1] == '0') {
                    $auto_coupon[$i]['COUPON_SALE'] = $coupon_num[0];
                }
            }
        }

        $data['AUTO_COUPON_LIST'] = $auto_coupon;
        $data['CUST_COUPON_LIST'] = $cust_coupon;

        $data['option_add_price'] = $param['option_add_price'];
        $data['idx'				] = $param['idx'];

        $coupon_layer = $this->load->view('goods/coupon_layer.php', $data, TRUE); //쿠폰 레이어 열기

        $this->response(array('status' => 'ok', 'coupon_layer'=>$coupon_layer), 200);
    }

    /**
     * 상품 상세 - 방문예약 레이어
     */
    public function reservation_layer_post()
    {
        $param = $this->input->post();

        $data['goods_cd'] = $param['goods_cd'];


        $reservation_layer = $this->load->view('goods/reservation_layer.php', $data, TRUE); //쿠폰 레이어 열기

        $this->response(array('status' => 'ok', 'reservation_layer' => $reservation_layer), 200);
    }

    /**
     * 상품 상세 - 방문에약
     */
    public function visit_reservation_post()
    {
        $param = $this->input->post();

        $param['mob_no'] = $param['tel1']."-".$param['tel2']."-".$param['tel3'];

        $arr = explode("-", $param['time']);
        $param['start_dt' ] = $param['date']." ".$arr[0].":00";
        $param['end_dt'   ] = $param['date']." ".$arr[1].":00";

        $result = $this->goods_m->reg_reservation($param);

        //Load MODEL
        $this->load->model('order_m');

        if($result) {
            //방문예약정보 SMS발송 - 고객
            $kakao['SMS_MSG_GB_CD'] = 'KAKAO';
            $kakao['MSG'] = "[에타홈] 예약완료

".$param['name']." 고객님, 클러프트 매장
방문 예약이 완료되었습니다^^

클러프트에서
확인전화 드릴 예정입니다

조금만 기다려 주세요 ~!

▶ 예약자: ".$param['name']."
▶ 예약일: ".$param['date']." ".$param['time']."

▼예약확인▼
http://m.etah.co.kr/visit/cust/".$result;
            $kakao['KAKAO_TEMPLATE_CODE'] = 'bizp_2019110514075716788360151';
            $kakao['KAKAO_SENDER_KEY'] = '1682e1e3f3186879142950762915a4109f2d04a2';
            $kakao['DEST_PHONE'] = str_replace('-','',$param['mob_no']);
            $sendSMS = $this->order_m->send_sms_kakao($kakao);

            //방문예약정보 SMS발송 - 업체
            $kakao['SMS_MSG_GB_CD'] = 'KAKAO';
            $kakao['MSG'] = "[에타홈] 예약알람

".$param['name']." 고객님이 클러프트 매장 방문을 예약했습니다^^
고객님께 전화해 예약일을 확정해주세요

▶ 예약자: ".$param['name']."
▶ 예약일: ".$param['date']." ".$param['time']."

▼예약확인▼
http://m.etah.co.kr/visit/seller/".$result;
            $kakao['KAKAO_TEMPLATE_CODE'] = 'bizp_2019110514100822317727188';
            $kakao['KAKAO_SENDER_KEY'] = '1682e1e3f3186879142950762915a4109f2d04a2';
            $kakao['DEST_PHONE'] = '01093777877';
            $sendSMS = $this->order_m->send_sms_kakao($kakao);

            $this->response(array('status' => 'ok', 'message' => '예약 성공'), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => '예약 실패'), 200);
        }

    }

    /**
     * 묶음배송상품리스트
     */
    public function bundle_delivery_get()
    {
        $data['goods_code'	] = $this->uri->segment(3);

        //브랜드 상품조회
        self::_bundle_delivery_list($data);
    }

    /**
     * 묶음배송상품리스트 페이징
     */
    public function bundle_delivery_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'	 ] = $page;

        //카테고리 상품조회
        self::_bundle_delivery_list($get_vars);
    }

    /**
     * 묶음배송상품 리스트 보기
     */
    public function _bundle_delivery_list($param)
    {
        //상품 상세 정보 구하기
        $goods = $this->goods_m->get_goods_detail_info($param['goods_code']);

        $data['goods'] = $goods;

        $param['deli_policy_no'] = $goods['DELIV_POLICY_NO'];

        //상품 할인금액 구하기
        $goods_seller_coupon  = $this->goods_m->get_goods_coupon_info($param, 'SELLER');
        $goods_item_coupon	  = $this->goods_m->get_goods_coupon_info($param, 'GOODS');

        //================================== 판매가 기준 할인 계산법
        $seller_coupon_percent	= 0;
        $seller_coupon_amt		= 0;
        $item_coupon_percent	= 0;
        $item_coupon_amt		= 0;

        if($goods_seller_coupon){	//상품에 셀러쿠폰이 붙어있을경우
            if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
                $seller_coupon_amt = floor($goods['SELLING_PRICE'] * $goods_seller_coupon['COUPON_FLAT_RATE'] / 1000);
                $seller_coupon_percent = $goods_seller_coupon['COUPON_FLAT_RATE']/10;

                if($goods_seller_coupon['MAX_DISCOUNT'] != 0 && $goods_seller_coupon['MAX_DISCOUNT'] < $seller_coupon_amt){	//최대금액을 넘을경우 최대금액으로 적용
                    $seller_coupon_amt = $goods_seller_coupon['MAX_DISCOUNT'];
                }
            } else if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
                $seller_coupon_amt = $goods_seller_coupon['COUPON_FLAT_AMT'];
                $seller_coupon_percent = floor($goods_seller_coupon['COUPON_FLAT_AMT']/$goods['SELLING_PRICE']*100);
            }
        }

        if($goods_item_coupon){		//상품에 아이템쿠폰이 붙어있을경우
            if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
                $item_coupon_amt = floor($goods['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000);
                $item_coupon_percent = $goods_item_coupon['COUPON_FLAT_RATE']/10;

                if($goods_item_coupon['MAX_DISCOUNT'] != 0 && $goods_item_coupon['MAX_DISCOUNT'] < $item_coupon_amt){	//최대금액을 넘을경우 최대금액으로 적용
                    $item_coupon_amt = $goods_item_coupon['MAX_DISCOUNT'];
                }
            } else if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
                $item_coupon_amt = $goods_item_coupon['COUPON_FLAT_AMT'];
                $item_coupon_percent = floor($goods_item_coupon['COUPON_FLAT_AMT']/$goods['SELLING_PRICE']*100);
            }
        }

        if($seller_coupon_amt + $item_coupon_amt > 0){	//할인금액이 있을경우
            $data['goods']['COUPON_AMT'		] = $seller_coupon_amt + $item_coupon_amt;
            $data['goods']['COUPON_PRICE'	] = $goods['SELLING_PRICE'] - $seller_coupon_amt - $item_coupon_amt;
            $data['goods']['COUPON_SALE_PERCENT'] = $seller_coupon_percent + $item_coupon_percent;
        } else {
            $data['goods']['COUPON_AMT'			] = 0;
            $data['goods']['COUPON_PRICE'		] = $goods['SELLING_PRICE'];
            $data['goods']['COUPON_SALE_PERCENT'] = 0;
        }

        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 40  : $param['limit_num_rows'];
        $param['order_by'		] = empty($param['order_by'			]) ? 'A' : $param['order_by'	  ];
        $param['cate_gb'	    ] = empty($param['cate_gb'		    ]) ? 'S' : $param['cate_gb'	      ];
        $param['cate_cd'	    ] = empty($param['cate_cd'		    ]) ? ''	 : $param['cate_cd'	      ];
        $param['deliv_type'	    ] = empty($param['deliv_type'		]) ? ''	 : $param['deliv_type'	  ];
        $param['country'	    ] = empty($param['country'		    ]) ? ''	 : $param['country'	      ];
        $param['price_limit'	] = empty($param['price_limit'		]) ? ''	 : $param['price_limit'	  ];

        //상품개수
        $totalCnt = $this->goods_m->get_goods_list_count($param);

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        //상품리스트
        $goodsList = $this->goods_m->get_goods_list($param);


        //전체상품정보 구하기
        $iparam = array();
        $iparam['deli_policy_no'] = $param['deli_policy_no'];
        $all_goodsList = $this->goods_m->get_goods_list($iparam);

        $arr_cate1 = array();   //카테고리1
        $arr_cate2 = array();   //카테고리2
        $arr_cate3 = array();   //카테고리3

        $cur_category = array(); //선택한 카테고리정보
        $arr_country = array();  //국가
        $arr_sellingPrice = array();   //가격

        foreach($all_goodsList as $all_goods) {
            //카테고리 리스트
            $arr_cate1[$all_goods['CATEGORY_CD1']]['CODE'] = $all_goods['CATEGORY_CD1'];
            $arr_cate1[$all_goods['CATEGORY_CD1']]['NAME'] = $all_goods['CATEGORY_NM1'];

            $arr_cate2[$all_goods['CATEGORY_CD2']]['CODE'] = $all_goods['CATEGORY_CD2'];
            $arr_cate2[$all_goods['CATEGORY_CD2']]['NAME'] = $all_goods['CATEGORY_NM2'];
            $arr_cate2[$all_goods['CATEGORY_CD2']]['PARENT_CODE'] = $all_goods['CATEGORY_CD1'];

            $arr_cate3[$all_goods['CATEGORY_CD3']]['CODE'] = $all_goods['CATEGORY_CD3'];
            $arr_cate3[$all_goods['CATEGORY_CD3']]['NAME'] = $all_goods['CATEGORY_NM3'];
            $arr_cate3[$all_goods['CATEGORY_CD3']]['PARENT_CODE'] = $all_goods['CATEGORY_CD2'];

            //선택한 카테고리 정보
            if($param['cate_cd']==$all_goods['CATEGORY_CD3']) {
                $cur_category['CATE_CD1'] = $all_goods['CATEGORY_CD1'];
                $cur_category['CATE_NM1'] = $all_goods['CATEGORY_NM1'];
                $cur_category['CATE_CD2'] = $all_goods['CATEGORY_CD2'];
                $cur_category['CATE_NM2'] = $all_goods['CATEGORY_NM2'];
                $cur_category['CATE_CD3'] = $all_goods['CATEGORY_CD3'];
                $cur_category['CATE_NM3'] = $all_goods['CATEGORY_NM3'];
            }

            //국가 리스트
            $country_cd = $all_goods['COUNTRY_CD'];
            $arr_country[$country_cd]['NM'] = $all_goods['COUNTRY_NM'];

            //가격
            $price = $all_goods['SELLING_PRICE'];
            if( !in_array($price, $arr_sellingPrice) ) array_push($arr_sellingPrice, $price);
        }

        $data['arr_cate1'       ] = $arr_cate1;
        $data['arr_cate2'       ] = $arr_cate2;
        $data['arr_cate3'       ] = $arr_cate3;
        $data['arr_country'     ] = $arr_country;
        $data['arr_sellingPrice'] = $arr_sellingPrice;
        $data['cur_category'    ] = $cur_category;

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'goods/bundle_delivery_page';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'		] = $this->pagination->create_links();
        $data['page'			] = $param['page'			];
        $data['price_limit'		] = $param['price_limit'	];
        $data['deli_policy_no'	] = $param['deli_policy_no'	];
        $data['order_by'		] = $param['order_by'		];
        $data['cate_gb'		    ] = $param['cate_gb'		];
        $data['cate_cd'		    ] = $param['cate_cd'		];
        $data['deliv_type'		] = $param['deliv_type'		];
        $data['country'		    ] = $param['country'		];
        $data['limit'			] = $param['limit_num_rows'	];
        $data['goods_code'		] = $param['goods_code'		];
        $data['goodsList'		] = $goodsList;
        $data['total_cnt'		] = $totalCnt;


        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
        $data['header_gb'] = 'none';
        $data['footer_gb'] = 'category';


        $this->load->view('include/header', $data);
//		$this->load->view('include/menu');
        $this->load->view('goods/bundle_delivery' ,$data);
//		$this->load->view('include/bottom_menu');
//		$this->load->view('include/layout');
        $this->load->view('include/footer', $data);

    }

    /**
     * 페이스북 공유하기
     */
    public function share_facebook_get()
    {
        $data = $this->input->get();
//		 var_dump($data);

        $this->load->view('goods/share_facebook', $data);
    }

    /**
     * 검색결과 리스트
     */
    public function search2_get()
    {
        $param = $this->input->get();

        $param['page'           ] = $this->uri->segment(3);
        $param['attr'			] = "";
        $param['kind'			] = empty($param['kind'				]) ? ''  : $param['kind'];
        $param['brand_nm'		] = empty($param['brand_nm'			]) ? ''  : $param['brand_nm'];
        $param['cate_nm'		] = empty($param['cate_nm'			]) ? ''  : $param['cate_nm'];
        $param['order_by'		] = empty($param['order_by'			]) ? 'A' : $param['order_by'];
        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 80  : $param['limit_num_rows'];
        $param['page'			] = empty($param['page'				]) ? 1   : $param['page'];

        $keyword = $param['keyword'];
        $field   = '';
        $sort    = '';
        $field2  = '';
        $sort2   = '';
        /* 페이징 */
        $limit_num_rows	= 10000;
        $startPos = 0;

        /*검색어 히스토리 저장*/
        $this->goods_m->reg_search_history($param['keyword']);

        $search_data = self::_cloudsearch($keyword,$limit_num_rows,$startPos,$field,$sort,$field2,$sort2,1);


        if($search_data['hits']['found']>10000) {
            $totalCnt = $search_data['hits']['found'];
        } else {
            $totalCnt = $search_data['hits']['found'];
        }

        $arr_cate = array();
        $arr_cate_nm = array();

        //카테고리 그룹
        $cidx = 0;
        foreach($search_data['hits']['hit'] as $crow){
            @$arr_cate[$cidx] = $crow['fields']['category_1_nm'];
            $cidx ++;
        }

        //카테고리별 상품개수 담음
        if($arr_cate){
            asort($arr_cate);

            $str_cate = $arr_cate[0];
            $arr_cate_nm[$str_cate] = 0;

            foreach($arr_cate as $cate){
                if($str_cate == $cate){
                    $arr_cate_nm[$cate] ++;
                }else{
                    $str_cate = $cate;
                    $arr_cate_nm[$cate] = 1;
                }
            }
        }

        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 80  : $param['limit_num_rows'];

        /* 페이징 */
        $startPos = ($param['page']-1) * $param['limit_num_rows'];
        $limit_num_rows	= $param['limit_num_rows'];

        /* 브랜드 검색 */
        if($param['brand_nm']) {
            $bkeyword = $keyword;
            $brand_nm = substr($param['brand_nm'], 1);
            $brand_nm2 = explode('|',$brand_nm);

            for($i=0;$i<count($brand_nm2); $i++) {
                $brand_cd[$i] = $this->goods_m->get_brand_cd($brand_nm2[$i]);
            }
            $brand_cd2 = '';
            for($i=0;$i<count($brand_cd); $i++) {
                $brand_cd2 .= '|'.$brand_cd[$i]['brand_cd'];
            }

            $keyword = $keyword . '&(' . substr($brand_cd2, 1) . ')';
        }

        /* 카테고리 검색 */
//        if($param['cate_nm']) $keyword = $keyword.'&'.$param['cate_nm']; $bkeyword =  $bkeyword.'&'.$param['cate_nm'];
        if($param['cate_nm']) {
            $category = $this->goods_m->get_category_cd($param['cate_nm']);
            $cate_cd = $category['CATEGORY_DISP_CD'];

            $keyword = $keyword.'&'.$cate_cd;
            $bkeyword =  $bkeyword.'&'.$cate_cd;
        }

        switch($param['order_by']){
            case 'A' :	    //인기순
                $field = "goods_priority";
                $sort = "asc";
                $field2 = "goods_sort_score";
                $sort2 = "desc";
                break;
            case 'B' :	    //신상품순
                $field = "goods_cd";
                $sort = "desc";
                break;
            case 'C' :	    //낮은가격순
                $field = "selling_price";
                $sort = "asc";
                $field2 = "goods_cd";
                $sort2 = "desc";
                break;
            case 'D' :	    //높은가격순
                $field = "selling_price";
                $sort = "desc";
                $field2 = "goods_cd";
                $sort2 = "desc";
                break;
        }
        $search_result = self::_cloudsearch($keyword,$limit_num_rows,$startPos,$field,$sort,$field2,$sort2,0);

        if($search_result['hits']['found']>10000){
            $totalrows = 10000;
        } else {
            $totalrows = $search_result['hits']['found'];
        }

        $goods_cd  = "";
        $arr_price = array();

        foreach($search_result['hits']['hit'] as $grow){
            $goods_cd .= ",".$grow['fields']['goods_cd'];
        }
        $goods_cd = substr($goods_cd, 1);

        if($goods_cd){
            $price = $this->goods_m->get_goods_price_by_search($goods_cd);

            foreach($price as $prow){
                $arr_price[$prow['GOODS_CD']]['SELLING_PRICE'		   ] = $prow['SELLING_PRICE'		  ];
                $arr_price[$prow['GOODS_CD']]['RATE_PRICE_S'		   ] = $prow['RATE_PRICE_S'			  ];
                $arr_price[$prow['GOODS_CD']]['RATE_PRICE_G'		   ] = $prow['RATE_PRICE_G'			  ];
                $arr_price[$prow['GOODS_CD']]['AMT_PRICE_S'			   ] = $prow['AMT_PRICE_S'			  ];
                $arr_price[$prow['GOODS_CD']]['AMT_PRICE_G'			   ] = $prow['AMT_PRICE_G'			  ];
                $arr_price[$prow['GOODS_CD']]['COUPON_CD_S'			   ] = $prow['COUPON_CD_S'			  ];
                $arr_price[$prow['GOODS_CD']]['COUPON_CD_G'			   ] = $prow['COUPON_CD_G'			  ];
                $arr_price[$prow['GOODS_CD']]['DELIV_POLICY_NO'		   ] = $prow['DELIV_POLICY_NO'		  ];
                $arr_price[$prow['GOODS_CD']]['PATTERN_TYPE_CD'		   ] = $prow['PATTERN_TYPE_CD'		  ];
                $arr_price[$prow['GOODS_CD']]['DELI_LIMIT'			   ] = $prow['DELI_LIMIT'			  ];
                $arr_price[$prow['GOODS_CD']]['DELI_COST'			   ] = $prow['DELI_COST'			  ];
                $arr_price[$prow['GOODS_CD']]['GOODS_MILEAGE_SAVE_RATE'] = $prow['GOODS_MILEAGE_SAVE_RATE'];
                $arr_price[$prow['GOODS_CD']]['INTEREST_GOODS_NO'	   ] = $prow['INTEREST_GOODS_NO'	  ];
                $arr_price[$prow['GOODS_CD']]['DEAL'	               ] = $prow['DEAL'	                  ];
                $arr_price[$prow['GOODS_CD']]['GONGBANG'	           ] = $prow['GONGBANG'	              ];
            }
        }

        //검색결과 재정렬
        if($param['order_by']=='C' || $param['order_by']=='D') {
            //할인가 구하기
            for($i=0;$i<count($search_result['hits']['hit']);$i++){
                $price = $this->goods_m->get_goods_price_by_search($search_result['hits']['hit'][$i]['fields']['goods_cd']);

                if($price[0]['COUPON_CD_S'] || $price[0]['COUPON_CD_G']){
                    $discount_price = $price[0]['SELLING_PRICE'] - ($price[0]['RATE_PRICE_S']+$price[0]['RATE_PRICE_G']) - ($price[0]['AMT_PRICE_S']+$price[0]['AMT_PRICE_G']);
                } else {
                    $discount_price = $price[0]['SELLING_PRICE'];
                }

                array_push($search_result['hits']['hit'][$i], $discount_price);
            }

            //배열 재정렬
            if($param['order_by']=='C') {
                $sort = array();
                foreach($search_result['hits']['hit'] as $key => $value) {
                    $sort[$key] = $value[0];
                }
                array_multisort($sort, SORT_ASC, $search_result['hits']['hit']);
            }
            if($param['order_by']=='D') {
                $sort = array();
                foreach($search_result['hits']['hit'] as $key => $value) {
                    $sort[$key] = $value[0];
                }
                array_multisort($sort, SORT_DESC, $search_result['hits']['hit']);
            }
        }

        //현재 카테고리의 count 구하기.
        foreach($arr_cate_nm as $key=>$crow) {
            if($key == $param['cate_nm']){
                $data['cate_cnt'] = $crow;
            }
        }

        //브랜드 그룹
        $arr_brand    = array();
        $arr_brand_nm = array();

        $limit_num_rows	= 10000;
        $startPos1      = 0;
        if($param['brand_nm']) $keyword = $bkeyword;
        $search_brand = self::_cloudsearch($keyword,$limit_num_rows,$startPos1,$field,$sort,$field2,$sort2,0);


        $bidx = 0;
        foreach($search_brand['hits']['hit'] as $brow){
            $arr_brand[$bidx] = $brow['fields']['brand_nm'];
            $bidx ++;
        }

        //브랜드별 상품개수 담음
        if($arr_brand){
            asort($arr_brand);

            $str_brand = $arr_brand[0];
            $arr_brand_nm[$str_brand] = 0;

            foreach($arr_brand as $brand){
                if($str_brand == $brand){
                    $arr_brand_nm[$brand] ++;
                }else{
                    $str_brand = $brand;
                    $arr_brand_nm[$brand] = 1;
                }
            }
            arsort($arr_brand_nm);
            ksort($arr_brand_nm);
        }
        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 80  : $param['limit_num_rows'];
        $limit_num_rows = $param['limit_num_rows'	];

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'goods/search';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalrows;
        $config['per_page'		] = $limit_num_rows;
        $config['num_links'		] = '5';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
        $data['kind'		] = $param['kind'];
        $data['search_cnt'	] = empty($param['search_cnt']) ? $totalCnt : $param['search_cnt'];
        $data['arr_price'	] = $arr_price;
        $data['keyword'		] = $param['keyword'];
        $data['order_by'	] = $param['order_by'];
        $data['price_limit'	] = '';
        $data['limit'		] = $limit_num_rows;
        $data['page'		] = $param['page'];
        $data['brand_nm'	] = $param['brand_nm'];
        $data['cate_nm'		] = $param['cate_nm'];
        $data['goods'		] = $search_result['hits']['hit'];
        $data['arr_brand_nm'] = $arr_brand_nm;
        $data['arr_cate_nm'	] = $arr_cate_nm;



        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
        $data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
        $data['search_gb'] = $param['keyword'];
        $data['footer_gb'] = 'search';

        $this->load->view('include/header', $data);
        $this->load->view('goods/search_list2');
        $this->load->view('include/footer');
    }

    /**
     * 검색결과 리스트
     */
    public function search_get()
    {
        $param = $this->input->get();

        $gubun    = $param['gb'];
        $keyword  = $param['keyword'];

        //텍스트 값 정제
        $keyword = trim($keyword);
        $keyword = preg_replace('/\r\n|\t|\0|\r|\n/','',  $keyword  );
        $keyword = str_replace('"', '', $keyword );
        $keyword = preg_replace("/[\/\\\:'\"\^`\_|]/i", "",  $keyword  );

        if( isset($gubun) ) {
            /* 검색결과 상세리스트 이동 */
            self::_search_detail($param);
        }
        else {
            /* 검색어 히스토리 저장 */
//            if($_SERVER['HTTP_X_FORWARDED_FOR'] != '1.221.31.141') {  //역삼사무실
            if($_SERVER['HTTP_X_FORWARDED_FOR'] != '112.217.100.186' && $_SERVER['HTTP_X_FORWARDED_FOR'] != '106.243.163.42') { //성수 사무실
                $this->goods_m->reg_search_history($param['keyword']);
            }

            /* 상품 */
            $limit_num_rows	= 10000;
            $startPos       = 0;
            $field          = '';
            $sort           = '';
            $field2         = '';
            $sort2          = '';
            $case           = 0;

            $arr_fq = array();
            $arr_sort = array();

            $arr_sort['field_A'] = $field;
            $arr_sort['sort_A' ] = $sort;
            $arr_sort['field_B'] = $field2;
            $arr_sort['sort_B' ] = $sort2;
            $search_data = self::_cloudsearch($keyword,$limit_num_rows,$startPos,$arr_sort,$arr_fq,$case);

            $target_cd = "";
            foreach($search_data['hits']['hit'] as $grow){
                $target_cd .= ",".$grow['fields']['goods_cd'];
            }
            $target_cd = substr($target_cd, 1);

            $goods_total_cnt = $search_data['hits']['found'];

            $limit_num_rows = 5;
            $search_result = self::_cloudsearch($keyword,$limit_num_rows,$startPos,$arr_sort,$arr_fq,$case);

            $goods_cd  = "";
            $arr_price = array();

            foreach($search_result['hits']['hit'] as $grow){
                $goods_cd .= ",".$grow['fields']['goods_cd'];
            }
            $goods_cd = substr($goods_cd, 1);

            if($goods_cd){
                $price = $this->goods_m->get_goods_price_by_search($goods_cd);
                foreach($price as $prow){
                    $arr_price[$prow['GOODS_CD']]['SELLING_PRICE'		   ] = $prow['SELLING_PRICE'		  ];
                    $arr_price[$prow['GOODS_CD']]['RATE_PRICE_S'		   ] = $prow['RATE_PRICE_S'			  ];
                    $arr_price[$prow['GOODS_CD']]['RATE_PRICE_G'		   ] = $prow['RATE_PRICE_G'			  ];
                    $arr_price[$prow['GOODS_CD']]['AMT_PRICE_S'			   ] = $prow['AMT_PRICE_S'			  ];
                    $arr_price[$prow['GOODS_CD']]['AMT_PRICE_G'			   ] = $prow['AMT_PRICE_G'			  ];
                    $arr_price[$prow['GOODS_CD']]['COUPON_CD_S'			   ] = $prow['COUPON_CD_S'			  ];
                    $arr_price[$prow['GOODS_CD']]['COUPON_CD_G'			   ] = $prow['COUPON_CD_G'			  ];
                    $arr_price[$prow['GOODS_CD']]['DELIV_POLICY_NO'		   ] = $prow['DELIV_POLICY_NO'		  ];
                    $arr_price[$prow['GOODS_CD']]['PATTERN_TYPE_CD'		   ] = $prow['PATTERN_TYPE_CD'		  ];
                    $arr_price[$prow['GOODS_CD']]['DELI_LIMIT'			   ] = $prow['DELI_LIMIT'			  ];
                    $arr_price[$prow['GOODS_CD']]['DELI_COST'			   ] = $prow['DELI_COST'			  ];
                    $arr_price[$prow['GOODS_CD']]['GOODS_MILEAGE_SAVE_RATE'] = $prow['GOODS_MILEAGE_SAVE_RATE'];
                    $arr_price[$prow['GOODS_CD']]['DEAL'                   ] = $prow['DEAL'                   ];
                    $arr_price[$prow['GOODS_CD']]['GONGBANG'               ] = $prow['GONGBANG'               ];
                }
            }

            $param['start'   ] = 0;
            $param['code'    ] = $target_cd;
            $param['order_by'] = 'A';

            /* 브랜드 */
            $search_brand = $this->goods_m->get_search_brand($param);

            if($target_cd != ''){
                /* 연관 태그 */
                $search_tag = $this->goods_m->get_search_tag($param);
            }

            /* 기획전 */
            $param['limit'] = 2;
            $search_planEvent_cnt   = $this->goods_m->get_search_plan_event_cnt($param);
            $search_planEvent       = $this->goods_m->get_search_plan_event($param);

            /* 매거진 */
            $param['limit'] = 4;
            $search_magazine_cnt    = $this->goods_m->get_search_magazine_cnt($param);
            $search_magazine        = $this->goods_m->get_search_magazine($param);


            $total_cnt = count($search_brand)+count($search_tag)+$search_planEvent_cnt['CNT']+$search_magazine_cnt['CNT']+$goods_total_cnt;

            $data['search_cnt'	  ] = $total_cnt;
            $data['arr_price'	  ] = $arr_price;
            $data['keyword'		  ] = $param['keyword'];
            $data['goods'		  ] = $search_result['hits']['hit'];
            $data['brand'		  ] = $search_brand;
            $data['tag'		      ] = $search_tag;
            $data['planEvent'	  ] = $search_planEvent;
            $data['magazine'	  ] = $search_magazine;
            $data['goods_cnt'     ] = $goods_total_cnt;
            $data['planEvent_cnt' ] = $search_planEvent_cnt['CNT'];
            $data['magazine_cnt'  ] = $search_magazine_cnt['CNT'];

            /**
             * 상단 카테고리 데이타
             */
            $this->load->library('etah_lib');
            $category_menu = $this->etah_lib->get_category_menu();
            $data['menu'      ] = $category_menu['category'];
            $data['cart_cnt'  ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
            $data['header_gb' ] = 'none';		//헤더의 검색바만 보이도록 하기
            $data['search_gb' ] = $param['keyword'];
            $data['footer_gb' ] = 'search';
            $data['add_wrap'  ] = 'srp';

            $this->load->view('include/header', $data);
            $this->load->view('goods/search_list');
            $this->load->view('include/footer');
        }
    }


    /**
     * 검색결과 리스트 상세
     * 2020.01.06
     */
    public function _search_detail($param)
    {
        $gb      = $param['gb'];
        $keyword = ($gb == 'T')?$param['tag_keyword']:$param['keyword'];

        //텍스트 값 정제
        $keyword = trim($keyword);
        $keyword = preg_replace('/\r\n|\t|\0|\r|\n/','',  $keyword  );
        $keyword = str_replace('"', '', $keyword );
        $keyword = preg_replace("/[\/\\\:'\"\^`\_|]/i", "",  $keyword  );

        $page = empty($this->uri->segment(3)) ? 1  : $this->uri->segment(3);

        /* 검색필터 */
        $param['brand'      ] = empty($param['brand'        ]) ? ''    : $param['brand'       ];  //브랜드
        $param['order_by'   ] = empty($param['order_by'     ]) ? 'A'   : $param['order_by'    ];  //정렬순위
        $param['category'   ] = empty($param['category'     ]) ? ''    : $param['category'    ];  //카테고리
        $param['deliv_type' ] = empty($param['deliv_type'   ]) ? ''    : $param['deliv_type'  ];  //무료배송여부
        $param['price_limit'] = empty($param['price_limit'  ]) ? ''    : $param['price_limit' ];  //가격
        $param['country'    ] = empty($param['country'      ]) ? ''    : $param['country'     ];  //국가
        $param['tag_keyword'] = empty($param['tag_keyword'  ]) ? ''    : $param['tag_keyword' ];  //연관태그


        /* 상품정보 가져오기 */
        $limit_num_rows	= 10000;
        $startPos       = 0;
        $field          = '';
        $sort           = '';
        $field2         = '';
        $sort2          = '';
        $case           = 0;

        $arr_fq     = array();
        $arr_sort   = array();


        $arr_sort['field_A'] = $field;
        $arr_sort['sort_A' ] = $sort;
        $arr_sort['field_B'] = $field2;
        $arr_sort['sort_B' ] = $sort2;
        $search_data = self::_cloudsearch($keyword,$limit_num_rows,$startPos,$arr_sort,$arr_fq,$case); //검색결과 전체 상품 추출

        $target_cd = "";
        foreach($search_data['hits']['hit'] as $grow){
            $target_cd .= ",".$grow['fields']['goods_cd'];
        }
        $code = substr($target_cd, 1);

        $temp['code'    ] = $code;  //검색결과 상품코드
        $temp['limit'   ] = '60';
        $temp['start'   ] = ($page-1) * $temp['limit'];
        $temp['order_by'] = $param['order_by'];
        $temp['category'] = $param['category'];
        $temp['keyword' ] = $param['keyword' ];

        /* 기획전 검색상세 */
        if($gb == 'E') {
            $totalCnt   = $this->goods_m->get_search_plan_event_cnt($temp);    //전체개수
            $list       = $this->goods_m->get_search_plan_event($temp);        //기획전 리스트


            $cur_category = array();
            $arr_cate1 = array();
            $arr_cate2 = array();

            $category_list_info = $this->goods_m->get_search_plan_event_category($temp);    //기획전 카테고리

            foreach($category_list_info as $crow) {
                //현재 설정된 카테고리
                if(!empty($crow['CURRENT_CATE'])) {
                    $cur_category['CATE_CD1'] = $crow['CATEGORY_CD1'];
                    $cur_category['CATE_NM1'] = $crow['CATEGORY_NM1'];
                    $cur_category['CATE_CD2'] = $crow['CATEGORY_CD2'];
                    $cur_category['CATE_NM2'] = $crow['CATEGORY_NM2'];
                }

                //카테고리 리스트
                $arr_cate1[$crow['CATEGORY_CD1']]['CODE'] = $crow['CATEGORY_CD1'];
                $arr_cate1[$crow['CATEGORY_CD1']]['NAME'] = $crow['CATEGORY_NM1'];

                $arr_cate2[$crow['CATEGORY_CD2']]['CODE'] = $crow['CATEGORY_CD2'];
                $arr_cate2[$crow['CATEGORY_CD2']]['NAME'] = $crow['CATEGORY_NM2'];
                $arr_cate2[$crow['CATEGORY_CD2']]['PARENT_CODE'] = $crow['CATEGORY_CD1'];
            }

            //페이지네비게이션
            $this->load->library('pagination');
            $config['base_url'		] = base_url().'goods/search';
            $config['uri_segment'	] = '3';
            $config['total_rows'	] = $totalCnt['CNT'];
            $config['per_page'		] = $temp['limit'];
            $config['num_links'		] = '10';
            $config['suffix'		] = '?'.http_build_query($param, '&');
            $this->pagination->initialize($config);

            $data['pagination'	    ] = $this->pagination->create_links();

            $data['list'            ] = $list;
            $data['list_cnt'        ] = $totalCnt['CNT'];
            $data['arr_cate1'       ] = $arr_cate1;
            $data['arr_cate2'       ] = $arr_cate2;
            $data['cur_category'    ] = $cur_category;
        }

        /* 매거진 검색상세 */
        if($gb == 'M') {
            $totalCnt   = $this->goods_m->get_search_magazine_cnt($temp);    //전체개수
            $list       = $this->goods_m->get_search_magazine($temp);    //매거진 리스트

            $cur_category = array();
            $arr_cate1 = array();
            $arr_cate2 = array();

            $category_list_info = $this->goods_m->get_search_magazine_category($temp);    //매거진 카테고리

            foreach($category_list_info as $crow) {
                //현재 설정된 카테고리
                if(!empty($crow['CURRENT_CATE'])) {
                    $cur_category['CATE_CD1'] = $crow['CATEGORY_CD1'];
                    $cur_category['CATE_NM1'] = $crow['CATEGORY_NM1'];
                    $cur_category['CATE_CD2'] = $crow['CATEGORY_CD2'];
                    $cur_category['CATE_NM2'] = $crow['CATEGORY_NM2'];
                }

                //카테고리 리스트
                $arr_cate1[$crow['CATEGORY_CD1']]['CODE'] = $crow['CATEGORY_CD1'];
                $arr_cate1[$crow['CATEGORY_CD1']]['NAME'] = $crow['CATEGORY_NM1'];

                $arr_cate2[$crow['CATEGORY_CD2']]['CODE'] = $crow['CATEGORY_CD2'];
                $arr_cate2[$crow['CATEGORY_CD2']]['NAME'] = $crow['CATEGORY_NM2'];
                $arr_cate2[$crow['CATEGORY_CD2']]['PARENT_CODE'] = $crow['CATEGORY_CD1'];
            }


            //페이지네비게이션
            $this->load->library('pagination');
            $config['base_url'		] = base_url().'goods/search';
            $config['uri_segment'	] = '3';
            $config['total_rows'	] = $totalCnt['CNT'];
            $config['per_page'		] = $temp['limit'];
            $config['num_links'		] = '10';
            $config['suffix'		] = '?'.http_build_query($param, '&');
            $this->pagination->initialize($config);

            $data['pagination'	    ] = $this->pagination->create_links();

            $data['list'            ] = $list;
            $data['list_cnt'        ] = $totalCnt['CNT'];
            $data['arr_cate1'       ] = $arr_cate1;
            $data['arr_cate2'       ] = $arr_cate2;
            $data['cur_category'    ] = $cur_category;
        }

        /* 상품,태그 검색상세 */
        if( ($gb == 'G') || ($gb == 'T') ) {
            $arr_brand = array();   //브랜드
            $arr_cate1 = array();   //카테고리1
            $arr_cate2 = array();   //카테고리2
            $arr_cate3 = array();   //카테고리3

            $cur_category = array(); //선택한 카테고리정보
            $arr_country = array();  //국가
            $arr_sellingPrice = array();   //가격

            //검색필터 설정
            foreach($search_data['hits']['hit'] as $srow) {
                //브랜드 리스트
                $brand_cd = $srow['fields']['brand_cd'];
                $brand_nm = $srow['fields']['brand_nm'];

                $brand_info = $this->goods_m->get_brandInfo($brand_cd);
                $brand_letter = $brand_info['BRAND_NM_FST_LETTER'];

                if($brand_letter != '') {
                    $arr_brand[$brand_letter][$brand_cd]['NM'] = $brand_nm;
                }

                //카테고리 리스트
                $cate_cd1 = $srow['fields']['category_1_cd'];
                $cate_nm1 = $srow['fields']['category_1_nm'];
                $cate_cd2 = $srow['fields']['category_2_cd'];
                $cate_nm2 = $srow['fields']['category_2_nm'];
                $cate_cd3 = $srow['fields']['category_3_cd'];
                $cate_nm3 = $srow['fields']['category_3_nm'];

                $arr_cate1[$cate_cd1]['CODE'] = $cate_cd1;
                $arr_cate1[$cate_cd1]['NAME'] = $cate_nm1;

                $arr_cate2[$cate_cd2]['CODE'] = $cate_cd2;
                $arr_cate2[$cate_cd2]['NAME'] = $cate_nm2;
                $arr_cate2[$cate_cd2]['PARENT_CODE'] = $cate_cd1;

                $arr_cate3[$cate_cd3]['CODE'] = $cate_cd3;
                $arr_cate3[$cate_cd3]['NAME'] = $cate_nm3;
                $arr_cate3[$cate_cd3]['PARENT_CODE'] = $cate_cd2;

                //선택한 카테고리 정보
                if($param['category']==$cate_cd3) {
                    $cur_category['CATE_CD1'] = $cate_cd1;
                    $cur_category['CATE_NM1'] = $cate_nm1;
                    $cur_category['CATE_CD2'] = $cate_cd2;
                    $cur_category['CATE_NM2'] = $cate_nm2;
                    $cur_category['CATE_CD3'] = $cate_cd3;
                    $cur_category['CATE_NM3'] = $cate_nm3;
                }

                //국가 리스트
                $country_cd = $srow['fields']['country_cd'];
                $arr_country[$country_cd]['NM'] = $this->goods_m->get_countryInfo($country_cd);

                //가격
                $price = $srow['fields']['selling_price'];
                if( !in_array($price, $arr_sellingPrice) ) array_push($arr_sellingPrice, $price);
            }

            ksort($arr_brand);
            ;
            $data['arr_brand'       ] = $arr_brand;
            $data['arr_cate1'       ] = $arr_cate1;
            $data['arr_cate2'       ] = $arr_cate2;
            $data['arr_cate3'       ] = $arr_cate3;
            $data['arr_country'     ] = $arr_country;
            $data['arr_sellingPrice'] = $arr_sellingPrice;
            $data['cur_category'    ] = $cur_category;          //선택한 카테고리정보

            //페이징
            $limit_num_rows	= $temp['limit'];
            $startPos       = $temp['start'];
            $field          = '';
            $sort           = '';
            $field2         = '';
            $sort2          = '';
            $case           = 1;

            $arr_fq   = array();    //검색필터
            $arr_sort = array();    //정렬순위

            //정렬
            switch($param['order_by']){
                case 'A' :  //인기순
                    $field = "goods_priority";$sort = "asc";
                    $field2 = "goods_sort_score";$sort2 = "desc";
                    break;
                case 'B' :  //신상품순
                    $field = "goods_cd";$sort = "desc";
                    break;
                case 'C' :  //낮은가격순
                    $field = "selling_price";$sort = "asc";
                    $field2 = "goods_cd";$sort2 = "desc";
                    break;
                case 'D' :  //높은가격순
                    $field = "selling_price";$sort = "desc";
                    $field2 = "goods_cd";$sort2 = "desc";
                    break;
            }

            $arr_sort['field_A'] = $field;
            $arr_sort['sort_A' ] = $sort;
            $arr_sort['field_B'] = $field2;
            $arr_sort['sort_B' ] = $sort2;

            $arr_fq['brand'     ] = $param['brand'      ];  //검색필터 브랜드
            $arr_fq['category'  ] = $param['category'   ];  //검색필터 카테고리
            $arr_fq['price'     ] = $param['price_limit'];  //검색필터 가격
            $arr_fq['country'   ] = $param['country'    ];  //검색필터 국가
            $arr_fq['deliv_type'] = $param['deliv_type' ];  //검색필터 무료배송

            $search_result = self::_cloudsearch($keyword,$limit_num_rows,$startPos,$arr_sort,$arr_fq,$case);   //검색결과 페이징
            $totalCnt = $search_result['hits']['found'];  //전체개수 (검색필터적용)


            //가격할인정보 구하기
            $goods_cd  = "";
            $arr_price = array();

            foreach($search_result['hits']['hit'] as $grow){
                $goods_cd .= ",".$grow['fields']['goods_cd'];
            }
            $goods_cd = substr($goods_cd, 1);

            if($goods_cd){
                $price = $this->goods_m->get_goods_price_by_search($goods_cd);
                foreach($price as $prow){
                    $arr_price[$prow['GOODS_CD']]['SELLING_PRICE'		   ] = $prow['SELLING_PRICE'		  ];
                    $arr_price[$prow['GOODS_CD']]['RATE_PRICE_S'		   ] = $prow['RATE_PRICE_S'			  ];
                    $arr_price[$prow['GOODS_CD']]['RATE_PRICE_G'		   ] = $prow['RATE_PRICE_G'			  ];
                    $arr_price[$prow['GOODS_CD']]['AMT_PRICE_S'			   ] = $prow['AMT_PRICE_S'			  ];
                    $arr_price[$prow['GOODS_CD']]['AMT_PRICE_G'			   ] = $prow['AMT_PRICE_G'			  ];
                    $arr_price[$prow['GOODS_CD']]['COUPON_CD_S'			   ] = $prow['COUPON_CD_S'			  ];
                    $arr_price[$prow['GOODS_CD']]['COUPON_CD_G'			   ] = $prow['COUPON_CD_G'			  ];
                    $arr_price[$prow['GOODS_CD']]['DELIV_POLICY_NO'		   ] = $prow['DELIV_POLICY_NO'		  ];
                    $arr_price[$prow['GOODS_CD']]['PATTERN_TYPE_CD'		   ] = $prow['PATTERN_TYPE_CD'		  ];
                    $arr_price[$prow['GOODS_CD']]['DELI_LIMIT'			   ] = $prow['DELI_LIMIT'			  ];
                    $arr_price[$prow['GOODS_CD']]['DELI_COST'			   ] = $prow['DELI_COST'			  ];
                    $arr_price[$prow['GOODS_CD']]['GOODS_MILEAGE_SAVE_RATE'] = $prow['GOODS_MILEAGE_SAVE_RATE'];
                    $arr_price[$prow['GOODS_CD']]['DEAL'                   ] = $prow['DEAL'                   ];
                    $arr_price[$prow['GOODS_CD']]['GONGBANG'               ] = $prow['GONGBANG'               ];
                }
            }

            //검색결과 재정렬 (가격순일때 할인가로 재정렬)
            if($param['order_by']=='C' || $param['order_by']=='D') {
                //할인가 구하기
                for($i=0;$i<count($search_result['hits']['hit']);$i++){
                    $price = $this->goods_m->get_goods_price_by_search($search_result['hits']['hit'][$i]['fields']['goods_cd']);

                    if($price[0]['COUPON_CD_S'] || $price[0]['COUPON_CD_G']){
                        $discount_price = $price[0]['SELLING_PRICE'] - ($price[0]['RATE_PRICE_S']+$price[0]['RATE_PRICE_G']) - ($price[0]['AMT_PRICE_S']+$price[0]['AMT_PRICE_G']);
                    } else {
                        $discount_price = $price[0]['SELLING_PRICE'];
                    }

                    array_push($search_result['hits']['hit'][$i], $discount_price);
                }

                //배열 재정렬
                if($param['order_by']=='C') {    //낮은가격순
                    $sort = array();
                    foreach($search_result['hits']['hit'] as $key => $value) {
                        $sort[$key] = $value[0];
                    }
                    array_multisort($sort, SORT_ASC, $search_result['hits']['hit']);
                }
                if($param['order_by']=='D') {    //높은가격순
                    $sort = array();
                    foreach($search_result['hits']['hit'] as $key => $value) {
                        $sort[$key] = $value[0];
                    }
                    array_multisort($sort, SORT_DESC, $search_result['hits']['hit']);
                }
            }

            //페이지네비게이션
            $this->load->library('pagination');
            $config['base_url'		] = base_url().'goods/search';
            $config['uri_segment'	] = '3';
            $config['total_rows'	] = $totalCnt;
            $config['per_page'		] = $limit_num_rows;
            $config['num_links'		] = '10';
            $config['suffix'		] = '?'.http_build_query($param, '&');
            $this->pagination->initialize($config);


            $data['pagination'	    ] = $this->pagination->create_links();

            $data['list'            ] = $search_result['hits']['hit'];
            $data['list_cnt'        ] = $totalCnt;
            $data['arr_price'       ] = $arr_price;
        }

        //설정된 브랜드 코드 초성 추출
        $arr_letter = explode("|", substr($param['brand'],1));

        $brand_letter = array();
        foreach($arr_letter as $arr){
            $brand_info = $this->goods_m->get_brandInfo($arr);

            if(!in_array($brand_info['BRAND_NM_FST_LETTER'], $brand_letter)){
                $brand_letter[] = $brand_info['BRAND_NM_FST_LETTER'];
            }
        }

        $data['keyword'		    ] = $param['keyword'    ];  //검색어
        $data['gubun'           ] = $gb;                    //검색상세 구분
        $data['brand'           ] = $param['brand'      ];  //브랜드
        $data['brand_letter'    ] = $brand_letter;          //브랜드 초성
        $data['order_by'        ] = $param['order_by'   ];  //정렬순위
        $data['category'        ] = $param['category'   ];  //카테고리
        $data['deliv_type'      ] = $param['deliv_type' ];  //배송비
        $data['price_limit'     ] = $param['price_limit'];  //가격
        $data['country'         ] = $param['country'    ];  //국가
        $data['tag_keyword'     ] = $param['tag_keyword'];  //연관태그 키워드

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt'  ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기


        /**
         * 퀵 레이아웃
         */
        $this->load->library('quick_lib');
        $data['quick'] =  $this->quick_lib->get_quick_layer();

        $data['header_gb' ] = 'none';		//헤더의 검색바만 보이도록 하기
        $data['search_gb' ] = $param['keyword'];
        $data['add_wrap'  ] = 'srp';

        $this->load->view('include/header', $data);
        $this->load->view('goods/search_list_detail');
        $this->load->view('include/layout');
        $this->load->view('include/footer');
    }

    public function brand_get()
    {
        $this->load->model('category_m');

        $param = $this->input->get();

        $param['brand_cd'   ] = $this->uri->segment(3);
        $param['page'       ] = $this->uri->segment(4);

        if(!$param['brand_cd'])     header("Location: /");

        $brand = $this->goods_m->get_brand_detail($param['brand_cd']);    //브랜드정보

        $param['page'			] = empty($param['page'				]) ? '1' : $param['page'		  ];
        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 40  : $param['limit_num_rows'];
        $param['cate_gb'		] = empty($param['cate_gb'			]) ? 'S' : $param['cate_gb'	      ];
        $param['cate_cd'		] = empty($param['cate_cd'			]) ? ''	 : $param['cate_cd'	      ];
        $param['price_limit'	] = empty($param['price_limit'		]) ? ''	 : $param['price_limit'	  ];
        $param['order_by'		] = empty($param['order_by'			]) ? 'A' : $param['order_by'	  ];
        $param['deliv_type'		] = empty($param['deliv_type'		]) ? ''  : $param['deliv_type'	  ];
        $param['country'		] = empty($param['country'		    ]) ? ''  : $param['country'	      ];
        $param['srp'		    ] = empty($param['srp'			    ]) ? ''  : $param['srp'	          ];

        //공방 브랜드관
        if($brand['BRAND_CATEGORY_CD'] == 4010) {

            $gallery = $this->goods_m->get_brand_gallery($param['brand_cd']);  //공방브랜드 갤러리

            //작가님 클래스
            $param['cate_gb'] = 'M';
            $param['cate_cd'] = 24010000;
            $classList = $this->goods_m->get_goods_list($param);
            $classCnt = $this->goods_m->get_goods_list_count($param);

            //공방 상품
            $param['cate_cd'] = 24020000;
            $goodsCnt = $this->goods_m->get_goods_list_count($param);
            $param['limit_num_rows'] = 4;
            $goodsList = $this->goods_m->get_goods_list($param);

            //상품평 정보
            $review = $this->goods_m->get_goods_comment($param['brand_cd'], 0, '');

            $data['brand'		] = $brand;
            $data['gallery'		] = $gallery;
            $data['classList'	] = $classList;
            $data['classCnt'	] = $classCnt;
            $data['goodsList'	] = $goodsList;
            $data['goodsCnt'	] = $goodsCnt;
            $data['review'      ] = $review;
        }
        //일반 브랜드관페이지
        else {
            //상품개수
            $totalCnt = $this->goods_m->get_goods_list_count($param);
            $data['total_cnt'		] = $totalCnt;

            //상품리스트
            $goodsList = $this->goods_m->get_goods_list($param);
            $data['goods'			] = $goodsList;

            //전체상품정보 구하기
            $iparam = array();
            $iparam['brand_cd'] = $param['brand_cd'];
            $all_goodsList = $this->goods_m->get_goods_list($iparam);

            $arr_cate1 = array();   //카테고리1
            $arr_cate2 = array();   //카테고리2
            $arr_cate3 = array();   //카테고리3

            $cur_category = array(); //선택한 카테고리정보
            $arr_country = array();  //국가
            $arr_sellingPrice = array();   //가격

            foreach($all_goodsList as $all_goods) {
                //카테고리 리스트
                $arr_cate1[$all_goods['CATEGORY_CD1']]['CODE'] = $all_goods['CATEGORY_CD1'];
                $arr_cate1[$all_goods['CATEGORY_CD1']]['NAME'] = $all_goods['CATEGORY_NM1'];

                $arr_cate2[$all_goods['CATEGORY_CD2']]['CODE'] = $all_goods['CATEGORY_CD2'];
                $arr_cate2[$all_goods['CATEGORY_CD2']]['NAME'] = $all_goods['CATEGORY_NM2'];
                $arr_cate2[$all_goods['CATEGORY_CD2']]['PARENT_CODE'] = $all_goods['CATEGORY_CD1'];

                $arr_cate3[$all_goods['CATEGORY_CD3']]['CODE'] = $all_goods['CATEGORY_CD3'];
                $arr_cate3[$all_goods['CATEGORY_CD3']]['NAME'] = $all_goods['CATEGORY_NM3'];
                $arr_cate3[$all_goods['CATEGORY_CD3']]['PARENT_CODE'] = $all_goods['CATEGORY_CD2'];

                //선택한 카테고리 정보
                if($param['cate_cd']==$all_goods['CATEGORY_CD3']) {
                    $cur_category['CATE_CD1'] = $all_goods['CATEGORY_CD1'];
                    $cur_category['CATE_NM1'] = $all_goods['CATEGORY_NM1'];
                    $cur_category['CATE_CD2'] = $all_goods['CATEGORY_CD2'];
                    $cur_category['CATE_NM2'] = $all_goods['CATEGORY_NM2'];
                    $cur_category['CATE_CD3'] = $all_goods['CATEGORY_CD3'];
                    $cur_category['CATE_NM3'] = $all_goods['CATEGORY_NM3'];
                }

                //국가 리스트
                $country_cd = $all_goods['COUNTRY_CD'];
                $arr_country[$country_cd]['NM'] = $all_goods['COUNTRY_NM'];

                //가격
                $price = $all_goods['SELLING_PRICE'];
                if( !in_array($price, $arr_sellingPrice) ) array_push($arr_sellingPrice, $price);
            }

            $data['arr_cate1'       ] = $arr_cate1;
            $data['arr_cate2'       ] = $arr_cate2;
            $data['arr_cate3'       ] = $arr_cate3;
            $data['arr_country'     ] = $arr_country;
            $data['arr_sellingPrice'] = $arr_sellingPrice;
            $data['cur_category'    ] = $cur_category;


            //페이지네비게이션
            $this->load->library('pagination');
            $config['base_url'		] = base_url().'goods/brand/'.$param['brand_cd'];
            $config['uri_segment'	] = '4';
            $config['total_rows'	] = $totalCnt;
            $config['per_page'		] = $param['limit_num_rows'];
            $config['num_links'		] = '5';
            $config['suffix'		] = '?'.http_build_query($param, '&');
            $this->pagination->initialize($config);

            $data['pagination'		] = $this->pagination->create_links();
        }

        $data['brand_cd'		] = $param['brand_cd'		];
        $data['page'			] = $param['page'			];
        $data['limit'			] = $param['limit_num_rows'	];
        $data['cate_gb'			] = $param['cate_gb'		];
        $data['cate_cd'			] = $param['cate_cd'		];
        $data['price_limit'		] = $param['price_limit'	];
        $data['deliv_type'	    ] = $param['deliv_type'	    ];
        $data['country'	        ] = $param['country'	    ];
        $data['order_by'		] = $param['order_by'		];
        $data['srp'		        ] = $param['srp'		    ];
        $data['brand'			] = $brand;


        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
        $data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
        $data['footer_gb'] = 'brand';

        //검색어 표시
        $data['search_gb'] = $param['srp'];
        $data['keyword'  ] = $param['srp'];

        $this->load->view('include/header', $data);
//		$this->load->view('include/menu');
        $this->load->view('goods/brand_shop');
//		$this->load->view('include/bottom_menu');
        $this->load->view('include/footer', $data);
    }

    /**
     * curl 통신 하기
     */
    public function _getHttp($url, $headers=null)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result,1);
    }


    public function brand_list_get()
    {
        $data = array();
        $brand_list = array();

        $param = $this->input->get();

        if(isset($param['keyword']) && $param['keyword'] != ''){
            $brand_list = $this->goods_m->get_brand_list($param);
            $data['keyword'] = $param['keyword'];
        } else {
            $brand_initial = $this->goods_m->get_brand_initial();

            foreach($brand_initial as $key=>$row){
                $brand_list[$key] = $this->goods_m->get_brand_list($row);  //상품판매불가쪽 브랜드 없애기
            }
        }


        @$data['brand_initial'] = $brand_initial;

        $data['brand_list'] = $brand_list;

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        $data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기

        $this->load->view('include/header', $data);
//		$this->load->view('include/menu');
        $this->load->view('goods/brand_list');
//		$this->load->view('include/bottom_menu');
        $this->load->view('include/footer');
    }

    /**
     * 이벤트 페이지
     */
    public function event_get()
    {
        $event_cd = $this->uri->segment(3, '');

        //유입경로 확인
        $utm = $this->input->get();
        if(isset($utm)){
            if(strpos($utm['utm_source'], 'wonder_shopping') !== false){    //원더쇼핑 유입
                setcookie('funnel', 'wonder', time() + 3600,'/');
            }
        }

        //2019.04.09 시크릿딜 클릭 수 체크용
        if($event_cd == 66) $this->goods_m->log_event_click();

        //기획전 클릭수 증가
        $click = $this->goods_m->event_click($event_cd);

        $event = $this->goods_m->get_plan_event($event_cd);
        if(!empty($event[0]['BANNER_CD'])) {
            $banner = $this->main_m->get_banner($event[0]['BANNER_CD']);
        }
        $data['banner'] = $banner[0];
        $data['event'] = $event[0];
        $data['goods'] = $event;
        if($event_cd == 66 || $event_cd ==77) {
            $data['bar_secret'] = 'Y';
        }
        if($event_cd == 234){
            $data['bar_md'] = 'Y';
        }
        if($event_cd == 586) {
            $data['bar_deal'] = "Y";
        }

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        /**
         * 퀵 레이아웃
         */
//		$this->load->library('quick_lib');
//		$data['quick'] =  $this->quick_lib->get_quick_layer();
        $data['add_wrap'] = 'event';

        $this->load->view('include/header', $data);
        $this->load->view('goods/event' ,$data);
        $this->load->view('include/footer');
    }

    /**
     * 이벤트 페이지 쿠폰 다운로드
     */
    public function get_event_coupon_post()
    {
        $param = $this->input->post();

        $coupon_info		= $this->goods_m->coupon_info($param['coupon_code']);					//쿠폰 정보
        $coupon_check		= $this->goods_m->event_coupon_check($param['coupon_code'], 'Y', '');	//쿠폰 발급받았는지 체크
        $use_coupon_check	= $this->goods_m->event_coupon_check($param['coupon_code'], 'N', '');	//쿠폰을 발급받아서 사용한게 있는지 체크
        $today_get_coupon	= $this->goods_m->event_coupon_check($param['coupon_code'], 'N', date("Y-m-d"));	//쿠폰을 발급받아서 사용한게 있는지 체크

        if($coupon_check){
            $this->response(array('status' => 'error', 'message' => '이미 사용하지 않은 해당 쿠폰이 존재합니다.'), 200);
        } else {
            if(count($use_coupon_check) >= $coupon_info['BUYER_MAX_DOWN_QTY']){
                $this->response(array('status' => 'error', 'message' => '최대 쿠폰 발급 횟수를 초과하였습니다.'), 200);
            } else {
                if( count($today_get_coupon) >= $coupon_info['DAY_ISSUE_LIMIT_QTY']){
                    $this->response(array('status' => 'error', 'message' => '오늘 발급 받을 수 있는 최대 횟수를 초과하였습니다.'), 200);
                } else {
                    $bring_coupon = $this->goods_m->bring_event_coupon($param['coupon_code']);
                }
            }
        }

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * best item
     */
    public function best_item_get()
    {
        $category = $this->input->get('C', TRUE);

        $data = array();
        $data['goods'] = $this->goods_m->get_best_item($category);
        $data['bar_best'] = "Y";

        if(empty($category)) {
            $data['CATE_CD'] = '';
            $data['CATE_NM'] = '전체';
        } else {
            /* model_m */
            $this->load->model('category_m');

            $cateInfo = $this->category_m->get_category_detail($category);
            $data['CATE_CD'] = $cateInfo['CATE_CODE3'];
            $data['CATE_NM'] = $cateInfo['CATE_NAME3'];
        }

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
//		$data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
//		$data['footer_gb'] = 'bestItem';
        $data['add_wrap'] = 'best-item';


        $this->load->view('include/header', $data);
//		$this->load->view('include/menu');
        $this->load->view('goods/best_item');
//		$this->load->view('include/bottom_menu');
        $this->load->view('include/footer', $data);
    }

    /**
     * the choice
     */
    public function the_choice_get()
    {
        $data = array();

        $data['goods'] = $this->goods_m->get_the_choice();
        $data['bar_md'] = "Y";

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
//		$data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
//		$data['footer_gb'] = 'theChoice';
        $data['add_wrap'] = 'the-choice';


        $this->load->view('include/header', $data);
//		$this->load->view('include/menu');
        $this->load->view('goods/the_choice');
//		$this->load->view('include/bottom_menu');
        $this->load->view('include/footer', $data);
    }

    /**
     * Goods Acount 클릭시
     */
    public function goods_action_post()
    {
        /* model_m */
        $this->load->model('mywiz2_m');

        $param = $this->input->post();
        $param['cust_no'] = $this->session->userdata('EMS_U_NO_');

        //CART 담기
        if($param['mode'] == 'C'){
        }
        //WISH LISH 담기
        else if($param['mode'] == 'W'){
            if($this->mywiz2_m->get_wish_list_by_cust_no_n_goods_cd($param, 'Y')){
                $this->response(array('status' => 'error', 'message' => '이미 관심상품에 등록된 상품입니다.'), 200);
            }
            if($this->mywiz2_m->get_wish_list_by_cust_no_n_goods_cd($param, 'N')){
                if(!$this->mywiz2_m->update_interest($param, 'Y'))	$this->response(array('status' => 'error', 'message' => '이미 관심상품에 등록된 상품입니다.'), 200);
            }else if(!$this->mywiz2_m->register_add_wish_list($param)){
                $this->response(array('status' => 'error', 'message' => '잠시 후 다시 시도하여 주시기 바랍니다.'), 200);
            }

        }
        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 2018.07.25
     * 클라우드 서치 모듈
     */
    public function _cloudsearch($keyword,$limit_num_rows,$startPos,$arr_sort,$arr_fq,$case){

        if($case == 1) {
            $fqUrl   = "";
            $sortUrl = "";

            /* 정렬기준 2개 */
            if($arr_sort['field_B'] != '') {
                $sortUrl = $arr_sort['field_A']."+".$arr_sort['sort_A'].",".$arr_sort['field_B']."+".$arr_sort['sort_B'];
            }else {
                $sortUrl = $arr_sort['field_A']."+".$arr_sort['sort_A'];
            }


            $brandUrl   = "";
            $cateUrl    = "";
            $countryUrl = "";
            $priceUrl   = "";
            $delivUrl   = "";

            /* 검색필터 브랜드 */
            if( $arr_fq['brand'] ) {
                $arr_brand = array_filter(explode("|", $arr_fq['brand']));
                foreach($arr_brand as $brand) {
                    $brandUrl .= "+(term+field%3Dbrand_cd+'".$brand."')";
                }
                $brandUrl = "+(or".$brandUrl.")";
            }

            /* 검색필터 카테고리 */
            if( $arr_fq['category'] ) {
                $cateUrl = "+(term+field%3Dcategory_3_cd+'".$arr_fq['category']."')";
            }

            /* 검색필터 국가 */
            if( $arr_fq['country'] ) {
                $arr_country = explode("|", substr($arr_fq['country'],1));
                foreach($arr_country as $country) {
                    $countryUrl .= "+(term+field%3Dcountry_cd+'".$country."')";
                }
                $countryUrl = "+(or".$countryUrl.")";
            }

            /* 검색필터 가격 */
            if( $arr_fq['price'] ) {
                $arr_price = explode("|", $arr_fq['price']);

                if($arr_price[0]=='' || $arr_price[1]=='') {
                    $pri = "{".$arr_price[0].",".$arr_price[1]."}";
                }
                else {
                    $pri = "[".$arr_price[0].",".$arr_price[1]."]";
                }
                $priceUrl = "+(range+field%3Dselling_price+".$pri.")";

            }

            /* 검색필터 무료배송 */
            if( $arr_fq['deliv_type'] ) {
                $delivUrl = "+(term+field%3Ddelivery_pattern+'".$arr_fq['deliv_type']."')";
            }


            if( $brandUrl!='' || $cateUrl!='' || $countryUrl!='' || $priceUrl!='' || $delivUrl!='' ) {
                $fqUrl = "&fq=(and".$brandUrl.$cateUrl.$countryUrl.$priceUrl.$delivUrl.")";
            }


            $strRequestUri = "http://search-etah-kqpl3wahogdn2xgvjrmzwjlipe.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode($keyword)."".$fqUrl."&size=".$limit_num_rows."&start=".$startPos."&sort=".$sortUrl."+&return=_all_fields,_score";

        }else {
            $strRequestUri = "http://search-etah-kqpl3wahogdn2xgvjrmzwjlipe.ap-northeast-2.cloudsearch.amazonaws.com/2013-01-01/search?q=".urlencode($keyword)."&size=".$limit_num_rows."&start=".$startPos."&sort=goods_priority+asc,goods_sort_score+desc&return=_all_fields,_score";
        }

        $CURL = curl_init();
        curl_setopt($CURL, CURLOPT_URL,	$strRequestUri );
        curl_setopt($CURL, CURLOPT_HEADER, 0 );
        curl_setopt($CURL, CURLOPT_RETURNTRANSFER,	1	);
        curl_setopt($CURL, CURLOPT_TIMEOUT,	600	);
        $result = curl_exec($CURL);
        curl_close($CURL);
        $search_result = json_decode($result, true);

        return $search_result;
    }

    /**
     * 네이버페이 - 찜하기
     */
    function naver_pick_post(){
        $param = $this->input->post();

        $param['goods_img'] = $this->goods_m->get_goodsImageResizing($param['goods_cd'], '300');   //  리사이징 이미지 가져오기

        $queryString = 'SHOP_ID='.urlencode('np_chfrl677135');
        $queryString .= '&CERTI_KEY='.urlencode('50CE9CAD-5C85-483E-910E-2FDA41D0E26C');
        $queryString .= '&RESERVE1=&RESERVE2=&RESERVE3=&RESERVE4=&RESERVE5=';

        $queryString .= '&ITEM_ID='.urlencode($param['goods_cd']);
        $queryString .= '&ITEM_NAME='.urlencode($param['goods_name']);
        $queryString .= '&ITEM_UPRICE='.$param['goods_price'];
        $queryString .= '&ITEM_IMAGE='.urlencode($param['goods_img']);
        $queryString .= '&ITEM_URL='.urlencode('http://www.etah.co.kr/goods/detail/'.$param['goods_cd']);

        $req_addr = 'ssl://pay.naver.com';
        $req_url = 'POST /customer/api/wishlist.nhn HTTP/1.1'; // utf-8
        $req_host = 'pay.naver.com';
        $req_port = 443;

        $nc_sock = @fsockopen($req_addr, $req_port, $errno, $errstr);
        if ($nc_sock) {
            fwrite($nc_sock, $req_url."\r\n" );
            fwrite($nc_sock, "Host: ".$req_host.":".$req_port."\r\n" );
            fwrite($nc_sock, "Content-type: application/x-www-form-urlencoded; charset=utf8\r\n"); // utf-8
            fwrite($nc_sock, "Content-length: ".strlen($queryString)."\r\n");
            fwrite($nc_sock, "Accept: */*\r\n");
            fwrite($nc_sock, "\r\n");
            fwrite($nc_sock, $queryString."\r\n");
            fwrite($nc_sock, "\r\n");

            // get header
            while(!feof($nc_sock)){
                $header=fgets($nc_sock,4096);
                if($header=="\r\n"){
                    break;
                } else {
                    $headers .= $header;
                }
            }
            // get body
            while(!feof($nc_sock)){
                $bodys.=fgets($nc_sock,4096);
            }

            fclose($nc_sock);

            $resultCode = substr($headers,9,3);

            if ($resultCode == 200) {
                // success
                $itemId = $bodys;
                $wishlistPopupUrl = "https://m.pay.naver.com/mobile/customer/wishList.nhn";

                $this->response(array('status'=>'ok', 'itemId'=>$itemId, 'url'=>$wishlistPopupUrl),200);
            } else {
                // fail
                $this->response(array('status'=>'fail', 'message'=>'잠시 후 다시 시도해주세요.'),200);
            }
        } else {
            exit(-1);
            $this->response(array('status'=>'fail', 'message'=>'잠시 후 다시 시도해주세요.'),200);
            //에러 처리
        }

    }

    /**
     * 클러프트관
     */
    public function special_get()
    {
        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        /**
         * 퀵 레이아웃
         */
//		$this->load->library('quick_lib');
//		$data['quick'] =  $this->quick_lib->get_quick_layer();
        $data['bar_special'] = 'special';

        $this->load->view('include/header', $data);
        $this->load->view('goods/special_kluft' ,$data);
        $this->load->view('include/footer');
    }
}