<?php

class Cart extends MY_Controller
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

        /* model_m */
        $this->load->model('cart_m');


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
    }


    public function test_get()
    {

        $this->load->view('cart/test');


    }

    /**
     * 장바구니 페이지 Load
     */
    public function index_get()
    {

        $row = $this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_'));

        //모델 LOAD
        $this->load->model('goods_m');
        $this->load->model('mywiz_m');

//		$data['mycoupon_cnt'	] = $this->mywiz_m->get_coupon_count_by_cust();		//보유쿠폰 갯수 가져오기
//		$data['mileage'			] = $this->mywiz_m->get_mileage_by_cust();			//보유 마일리지 가져오기
//		$data['recommend_goods'	] = $this->cart_m->get_cart_best_goods();			//장바구니 추천상품
        $data['ENABLE'          ] = '';
        $cart	= array();

        for($i=0; $i<count($row); $i++){
            $param = array();
            $param['goods_code'			] = $row[$i]['GOODS_CD'];
            $param['brand_code'			] = $row[$i]['BRAND_CD'];
            $param['category_mng_code'	] = $row[$i]['CATEGORY_MNG_CD'];

            if($row[$i]['CATEGORY_MNG_CD2']==24010000 || $row[$i]['GOODS_STS_CD']!='03'){   //공방클래스, 품절/일시정지
                $data['ENABLE'] = 'N';  //네이버페이 구매불가
            }

            //상품 쿠폰 구하기(셀러 & 상품)
            $goods_seller_coupon = $this->goods_m->get_goods_coupon_info($param, 'SELLER');	//상품별 셀러할인쿠폰 가져오기
            $goods_item_coupon   = $this->goods_m->get_goods_coupon_info($param, 'GOODS');	//상품별 상품할인쿠폰 가져오기
            $coupon_price = 0;
//================================== 판매가 기준 할인 계산법
            $seller_coupon_percent	= 0;
            $seller_coupon_amt		= 0;
            $item_coupon_percent	= 0;
            $item_coupon_amt		= 0;

            if($goods_seller_coupon){	//상품에 셀러쿠폰이 붙어있을경우
                if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
                    $seller_coupon_amt = floor($row[$i]['SELLING_PRICE'] * $goods_seller_coupon['COUPON_FLAT_RATE'] / 1000);
                    $seller_coupon_percent = $goods_seller_coupon['COUPON_FLAT_RATE']/10;

                    if($goods_seller_coupon['MAX_DISCOUNT'] != 0 && $goods_seller_coupon['MAX_DISCOUNT'] < $seller_coupon_amt){	//최대금액을 넘을경우 최대금액으로 적용
                        $seller_coupon_amt = $goods_seller_coupon['MAX_DISCOUNT'];
                    }
                } else if($goods_seller_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
                    $seller_coupon_amt = $goods_seller_coupon['COUPON_FLAT_AMT'];
                    $seller_coupon_percent = floor($row[$i]['SELLING_PRICE']/$goods_seller_coupon['COUPON_FLAT_AMT']);
                }

                $row[$i]['SELLER_COUPON_CD'	] = $goods_seller_coupon['COUPON_CD'];
                $row[$i]['SELLER_COUPON_AMT'] = $seller_coupon_amt;
                $row[$i]['SELLER_COUPON_MAX'] = $goods_seller_coupon['MAX_DISCOUNT'];
                $row[$i]['SELLER_COUPON_METHOD'] = $goods_seller_coupon['COUPON_DC_METHOD_CD'];
            }

            if($goods_item_coupon){		//상품에 아이템쿠폰이 붙어있을경우
                if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'RATE'){
                    $item_coupon_amt = floor($row[$i]['SELLING_PRICE'] * $goods_item_coupon['COUPON_FLAT_RATE'] / 1000);
                    $item_coupon_percent = $goods_item_coupon['COUPON_FLAT_RATE']/10;

                    if($goods_item_coupon['MAX_DISCOUNT'] != 0 && $goods_item_coupon['MAX_DISCOUNT'] < $item_coupon_amt){	//최대금액을 넘을경우 최대금액으로 적용
                        $item_coupon_amt = $goods_item_coupon['MAX_DISCOUNT'];
                    }
                } else if($goods_item_coupon['COUPON_DC_METHOD_CD'] == 'AMT'){
                    $item_coupon_amt = $goods_item_coupon['COUPON_FLAT_AMT'];
                    $item_coupon_percent = floor($row[$i]['SELLING_PRICE']/$goods_item_coupon['COUPON_FLAT_AMT']);
                }

                $row[$i]['ITEM_COUPON_CD'	] = $goods_item_coupon['COUPON_CD'];
                $row[$i]['ITEM_COUPON_AMT'	] = $item_coupon_amt;
                $row[$i]['ITEM_COUPON_MAX'	] = $goods_item_coupon['MAX_DISCOUNT'];
                $row[$i]['ITEM_COUPON_METHOD'] = $goods_item_coupon['COUPON_DC_METHOD_CD'];
            }

            if($seller_coupon_amt + $item_coupon_amt > 0){	//할인금액이 있을경우
                $row[$i]['COUPON_AMT'	] = $seller_coupon_amt + $item_coupon_amt;
                $row[$i]['COUPON_PRICE'	] = $row[$i]['SELLING_PRICE'] - $seller_coupon_amt - $item_coupon_amt;
                $row[$i]['COUPON_SALE_PERCENT'] = $seller_coupon_percent + $item_coupon_percent;
            } else {
                $row[$i]['COUPON_AMT'	] = 0;
                $row[$i]['COUPON_PRICE'	] = $row[$i]['SELLING_PRICE'];
                $row[$i]['COUPON_SALE_PERCENT'] = 0;
            }

            //상품 옵션 구하기
            $goods_option = $this->goods_m->get_goods_option($param['goods_code']);
            $row[$i]['GOODS_OPTION'		] = $goods_option;

            $row[$i]['SELLER_COUPON_CD'	] = isset($goods_seller_coupon['COUPON_CD']) ? $goods_seller_coupon['COUPON_CD'] : "";
            $row[$i]['ITEM_COUPON_CD'	] = isset($goods_item_coupon['COUPON_CD']) ? $goods_item_coupon['COUPON_CD'] : "";

            /** 사용 가능한 쿠폰 리스트 가져오기 */
            $auto_coupon = $this->cart_m->get_coupon_info($param, 'AUTO');

            for($j=0; $j<count($auto_coupon); $j++){
                if($auto_coupon[$j]['COUPON_KIND_CD'] == 'GOODS'){	//만약 GOODS쿠폰이 있다면
                    $param['DUPLICATE'] = "";		// 배열을 생성함으로써 DUPLICATE가 Y인것만 보여주기
                    break;
                }
            }

            $cust_coupon = $this->cart_m->get_coupon_info($param, 'ADD');

            for($cnt = 0; $cnt<count($auto_coupon); $cnt++){
                if($auto_coupon[$cnt]['COUPON_DC_METHOD_CD'] == 'RATE') {
                    $coupon_num = explode('.', $auto_coupon[$cnt]['COUPON_SALE']);

                    if ($coupon_num[1] == '0') {
                        $auto_coupon[$cnt]['COUPON_SALE'] = $coupon_num[0];
                    }
                }
            }

            $row[$i]['AUTO_COUPON_LIST'] = $auto_coupon;
            $row[$i]['CUST_COUPON_LIST'] = $cust_coupon;

            $goods_add_deli = $this->goods_m->get_goods_add_deli($param);		//상품별 도서산간지역 추가배송비 가져오기

            $row[$i]['ADD_DELIVERY'] = $goods_add_deli;

            $cart[$row[$i]['DELI_CODE']][] = $row[$i];

            //스크립트에서 사용할 변수 2017-03-29
            $cart_data['GOODS_CD'		][] = $row[$i]['GOODS_CD'];
            $cart_data['GOODS_NM'		][] = $row[$i]['GOODS_NM'];
            $cart_data['SELLING_PRICE'	][] = $row[$i]['SELLING_PRICE'];
            $cart_data['GOODS_CNT'		][] = $row[$i]['GOODS_CNT'];
        }
        $data['cart'		] = $cart;
        @$data['cart_data'	] = $cart_data;

        //네이버페이 구매가능여부
        if(count($row) == 0) $data['ENABLE'] = 'N';
        if($data['ENABLE'] == '') $data['ENABLE'] = 'Y';

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
        $data['header_gb'] = 'none';

        $this->load->view('include/header', $data);
//		$this->load->view('include/menu');
        $this->load->view('cart/cart_step1', $data);
//		$this->load->view('include/bottom_menu');
        $this->load->view('include/footer');
    }

    /** 장바구니 -> 주문/결제 페이지로 이동시 변수 이동 **/
    public function OrderInfo_post()
    {
        $param = $this->input->post();

        //비회원 시 로그인 화면 이동
//        if($this->session->userdata('EMS_U_ID_') == 'GUEST' || $this->session->userdata('EMS_U_ID_') == 'TMP_GUEST'){
        if($this->session->userdata('EMS_U_ID_') == 'GUEST'){
            redirect('https://'.$_SERVER['HTTP_HOST'].'/member/login', 'refresh');
        } else{
            self::Step2_OrderInfo_get($param);
        }
    }

    public function OrderInfo_get()
    {
        $this->load->view('template/error_404');
    }

    /** 상품상세 -> 바로구매 (비회원) 이동시 변수 이동 **/
    public function GuestOrder_post()
    {
        $param = $this->input->post();
        //log_message("DEBUG","GuestOrder_post ===================   ");
        self::GuestOrder_get($param);
    }

    public function GuestOrder_get()
    {
        $param = $this->input->post();

        if(!$param){
            $this->load->view('template/error_404');
        } else {

            $data['param']	= $param;

            /**
             * 상단 카테고리 데이타
             */
            $this->load->library('etah_lib');
            $category_menu = $this->etah_lib->get_category_menu();
            $data['menu'] = $category_menu['category'];
            $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

            $this->load->view('include/header', $data);
            $this->load->view('cart/cart_nonmember', $data);
            $this->load->view('include/footer');
        }
    }

    /**
     * 주문/결제 페이지 Load
     */
    public function Step2_OrderInfo_get($pdata)
    {
//        header("Keep-Alive: timeout=600, max=100");
//        ini_set('memory_limit','-1');
        //비회원 로그인시 세션 날리기

        if($this->session->userdata('EMS_U_ID_') == 'GUEST'){
            $this->session->sess_destroy();
        }

        $param = $pdata;


        //모델 LOAD
        $this->load->model('mywiz_m');
        $this->load->model('goods_m');
        $this->load->model('order_m');

        //최근 배송지 초기값 세팅
        $data['RECEIVER_NM'			] = "";
        $data['RECEIVER_ZIPCODE'	] = "";
        $data['RECEIVER_ADDR1'		] = "";
        $data['RECEIVER_ADDR2'		] = "";
        $data['RECEIVER_PHONE_NO'	] = "";
        $data['RECEIVER_MOB_NO'		] = "";

        //kcp 모바일 결제 중 결제 완료후 카트2로 돌아 올때
        if(isset($param["param_opt_1"]) && $param["param_opt_1"] != ""){
            $data['kcp_pay'] = true;

            //    log_message("DEBUG", "======= ".$data['kcp_pay']);
        }else {
            //  log_message("DEBUG", "======= false");
            if ($this->session->userdata('EMS_U_NO_')) {
                $last_deliv = $this->order_m->get_last_order_deliv($this->session->userdata('EMS_U_NO_'));

                if ($last_deliv) {
                    $data['last_deliv'] = $last_deliv;
                    $data['RECEIVER_NM'] = $last_deliv['RECEIVER_NM'];
                    $data['RECEIVER_ZIPCODE'] = $last_deliv['RECEIVER_ZIPCODE'];
                    $data['RECEIVER_ADDR1'] = $last_deliv['RECEIVER_ADDR1'];
                    $data['RECEIVER_ADDR2'] = $last_deliv['RECEIVER_ADDR2'];
                    $data['RECEIVER_PHONE_NO'] = $last_deliv['RECEIVER_PHONE_NO'];
                    $data['RECEIVER_MOB_NO'] = $last_deliv['RECEIVER_MOB_NO'];
                }
            }


//		$data['mycoupon_cnt'		] = $this->mywiz_m->get_coupon_count_by_cust();		//보유쿠폰 갯수 가져오기
            $data['mileage'] = $this->mywiz_m->get_mileage_by_cust();            //보유 마일리지 가져오기
            $data['cust_delivery'] = $this->mywiz_m->get_delivery_list($param);
//		$data['mycoupon'			] = $this->cart_m->get_cust_coupon_info();			//보유 쿠폰
            $data['deliv_sido_list'] = $this->cart_m->get_post_sido();                    //주소찾기 시/도 select box data
            $data['DELIV_INFO'] = 'N';        //가구 배송정보 노출여부
            $data['SEND_NATION_INFO'] = 'N';        //해외 배송정보
            //카카오 페이용 반려동물 카테고리 체크
            $data['CATEGORY_PET'        ] = 'N';        //반려동물 카테고리 체크
//            echo'check';
//            exit();
            if (!isset($param['chkGoods']) && !isset($param['order_gb'])) {    //바로구매 시
//			var_dump("************************바로구매***************************");
//			var_dump($param);
                $param['order_gb'] = 'B||' . $param['goods_code'];
                $deli_code = $param['deli_code'];
                for ($i = 0; $i < count($param['goods_option_code']); $i++) {
                    $cart[$i]['GOODS_CD'] = $param['goods_code'];
                    $cart[$i]['GOODS_NM'] = $param['goods_name'];
                    $cart[$i]['GOODS_IMG'] = $param['goods_img'];
                    $cart[$i]['BRAND_CD'] = $param['brand_code'];
                    $cart[$i]['BRAND_NM'] = $param['brand_name'];
                    $cart[$i]['GOODS_OPTION_CD'] = $param['goods_option_code'][$i];
                    $cart[$i]['GOODS_OPTION_NM'] = $param['goods_option_name'][$i];
                    $cart[$i]['GOODS_OPTION_ADD_PRICE'] = $param['goods_option_add_price'][$i];
                    $cart[$i]['GOODS_CNT'] = $param['goods_cnt'][$i];
                    $cart[$i]['GOODS_OPTION_QTY'] = $param['goods_option_qty'][$i];
                    $cart[$i]['BUY_LIMIT_QTY'] = $param['goods_buy_limit_qty'];
                    $cart[$i]['GOODS_PRICE_CD'] = $param['goods_price_code'];
                    $cart[$i]['SELLING_PRICE'] = $param['goods_selling_price'];
                    $cart[$i]['STREET_PRICE'] = $param['goods_street_price'];
                    $cart[$i]['FACTORY_PRICE'] = $param['goods_factory_price'];
                    $cart[$i]['GOODS_MILEAGE_SAVE_RATE'] = $param['goods_mileage_save_rate'];
//			$cart[$i]['DISCOUNT_PRICE'			] = $param['goods_discount_price'	];
                    $cart[$i]['SELLER_COUPON_CODE'] = explode('||', $param['goods_coupon_code_s'])[0];
                    $cart[$i]['SELLER_COUPON_AMT'] = $param['goods_coupon_amt_s'];
//			$cart[$i]['ITEM_COUPON_CODE'		] = explode('||', $param['goods_coupon_code_i'])[0];
                    $cart[$i]['ITEM_COUPON_CODE'] = $param['goods_item_coupon_code'][$i];
                    $cart[$i]['ITEM_COUPON_AMT'] = $param['goods_item_coupon_price'][$i];
                    $cart[$i]['DISCOUNT_PRICE'] = floor($param['goods_coupon_amt_s']) + floor($param['goods_item_coupon_price'][$i]);
                    $cart[$i]['ADD_COUPON_NO'] = $param['goods_add_coupon_no'][$i];
                    $cart[$i]['ADD_COUPON_CODE'] = $param['goods_add_coupon_code'][$i];
                    $cart[$i]['ADD_DISCOUNT_PRICE'] = $param['goods_add_discount_price'][$i];
                    $cart[$i]['ADD_COUPON_NUM'] = "";
//			$cart[$i]['DELIV_INFO'				] = 'N';		//가구 배송정보 노출여부


                    /** 사용 가능한 쿠폰 리스트 가져오기 */
                    $param3['goods_code'        ] = $param['goods_code'         ];
                    $param3['brand_code'        ] = $param['brand_code'         ];
                    $param3['category_mng_code' ] = $param['goods_cate_code3'   ];
                    $auto_coupon = $this->cart_m->get_coupon_info($param3, 'AUTO');

                    for($j=0; $j<count($auto_coupon); $j++){
                        if($auto_coupon[$j]['COUPON_KIND_CD'] == 'GOODS'){	//만약 GOODS쿠폰이 있다면
                            $param['DUPLICATE'] = "";		// 배열을 생성함으로써 DUPLICATE가 Y인것만 보여주기
                            break;
                        }
                    }

                    $cust_coupon = $this->cart_m->get_coupon_info($param3, 'ADD');

                    for($cnt = 0; $cnt<count($auto_coupon); $cnt++){
                        if($auto_coupon[$cnt]['COUPON_DC_METHOD_CD'] == 'RATE') {
                            $coupon_num = explode('.', $auto_coupon[$cnt]['COUPON_SALE']);

                            if ($coupon_num[1] == '0') {
                                $auto_coupon[$cnt]['COUPON_SALE'] = $coupon_num[0];
                            }
                        }
                    }

                    $cart[$i]['AUTO_COUPON_LIST'] = $auto_coupon;
                    $cart[$i]['CUST_COUPON_LIST'] = $cust_coupon;


                    if ($param['goods_cate_code1'] == '10000000') {
                        $data['DELIV_INFO'] = 'Y';
                    }

                    if ($param['goods_cate_code1'] == '18000000' && $param['goods_cate_code2'] == '18010000') {
                        $data['DELIV_INFO'] = 'Y';
                    }

                    if ($param['send_nation'] != 'KR') {        //출고지국가
                        $data['SEND_NATION_INFO'] = 'Y';
                    }
                    if($param['goods_cate_code1'] == '18000000'){   //반려동물 카테고리 체크
                        $data['CATEGORY_PET'] = 'Y';
                    }

                    /** 배송비 신규 코드 start **/
                    if ($i == 0) {
                        $group_selling_price = 0;
                        $d_goods_cnt = 0;

                        for ($j = 0; $j < count($param['goods_option_code']); $j++) {
                            //2018.08.23 할인가 기준으로 배송비 변경 황승업
//                            $group_selling_price += ($param['goods_selling_price'] + $param['goods_option_add_price'][$j] - $cart[$i]['DISCOUNT_PRICE']) * $param['goods_cnt'][$j];
                            //2018.09.17 할인가 기준 판매가로 변경 황승업
                            $group_selling_price += ($param['goods_selling_price'] + $param['goods_option_add_price'][$j]) * $param['goods_cnt'][$j];
                            $d_goods_cnt += $param['goods_cnt'][$j];
                        }
                    }

                    if ($param['goods_deliv_pattern_type'] == 'STATIC') {    //갯수대로 배송비
                        $cart[$i]['DELIVERY_PRICE'] = $param['deli_cost'] * $d_goods_cnt;
                    } else if ($param['goods_deliv_pattern_type'] == 'PRICE') {    //가격 조건

                        /** 바로구매 배송비 관련 수정 - 묶음배송비 계산 20171120 이진호 **/
                        if ($param['deli_limit'] == 0 && $param['deli_cost'] > 0) {
                            $cart[$i]['DELIVERY_PRICE'] = $param['deli_cost'];
                        } else {
                            if ($group_selling_price < $param['deli_limit']) {
                                $cart[$i]['DELIVERY_PRICE'] = $param['deli_cost'];
                            } else {
                                $cart[$i]['DELIVERY_PRICE'] = "0";
                            }
                        }

                    } else if ($param['goods_deliv_pattern_type'] == 'FREE') {        //무료배송 조건
                        $cart[$i]['DELIVERY_PRICE'] = "0";
                    } else if ($param['goods_deliv_pattern_type'] == 'NONE') {        //착불배송 조건
                        $cart[$i]['DELIVERY_PRICE'] = "0";
                    }
                    /** end **/

                    $cart[$i]['DELIV_POLICY_NO'] = $param['deli_policy_no'];
                    $cart[$i]['DELIV_PATTERN_TYPE'] = $param['goods_deliv_pattern_type'];

                    $goods_add_deli = $this->goods_m->get_goods_add_deli($param);        //상품별 도서산간지역 추가배송비 가져오기
                    $cart[$i]['ADD_DELIVERY'] = $goods_add_deli;

                    $data['cart'][$deli_code . "||" . $cart[$i]['DELIVERY_PRICE']][] = $cart[$i];        //배송코드(업체코드_배송정책코드)||배송비(묶음적용)
                }    //END FOR
//                var_dump($data['cart']);
            } else {

                if ($param['order_gb'] == 'A') {    //전체상품주문
                    for ($i = 0; $i < count($param['cart_code']); $i++) {
                        $deli_code = $param['deli_code'][$i];

                        $cart[$i]['GOODS_CD'] = $param['goods_code'][$i];
                        $cart[$i]['GOODS_NM'] = $param['goods_name'][$i];
                        $cart[$i]['BRAND_CD'] = $param['brand_code'][$i];
                        $cart[$i]['BRAND_NM'] = $param['brand_name'][$i];
                        $cart[$i]['GOODS_OPTION_CD'] = $param['goods_option_code'][$i];
                        $cart[$i]['GOODS_OPTION_NM'] = $param['goods_option_name'][$i];
                        $cart[$i]['GOODS_OPTION_ADD_PRICE'] = $param['goods_option_add_price'][$i];
                        $cart[$i]['GOODS_CNT'] = $param['goods_cnt'][$i];
                        $cart[$i]['GOODS_OPTION_QTY'] = $param['goods_option_qty'][$i];
                        $cart[$i]['BUY_LIMIT_QTY'] = $param['goods_buy_limit_qty'][$i];
                        $cart[$i]['GOODS_IMG'] = $param['goods_img'][$i];
                        $cart[$i]['GOODS_PRICE_CD'] = $param['goods_price_code'][$i];
                        $cart[$i]['SELLING_PRICE'] = $param['goods_selling_price'][$i];
                        $cart[$i]['STREET_PRICE'] = $param['goods_street_price'][$i];
                        $cart[$i]['FACTORY_PRICE'] = $param['goods_factory_price'][$i];
                        $cart[$i]['GOODS_MILEAGE_SAVE_RATE'] = $param['goods_mileage_save_rate'][$i];
                        $cart[$i]['DISCOUNT_PRICE'] = $param['goods_discount_price'][$i];
                        $cart[$i]['ADD_DISCOUNT_PRICE'] = $param['goods_add_discount_price'][$i];
                        $cart[$i]['SELLER_COUPON_CODE'] = $param['goods_coupon_code_s'][$i];
                        $cart[$i]['SELLER_COUPON_AMT'] = $param['goods_coupon_amt_s'][$i];
                        $cart[$i]['ITEM_COUPON_CODE'] = $param['goods_coupon_code_i'][$i];
                        $cart[$i]['ITEM_COUPON_AMT'] = $param['goods_coupon_amt_i'][$i];
//					$cart[$i]['COUPON_NUM'					] = $param['goods_coupon_num'			][$i];
                        $cart[$i]['ADD_COUPON_NO'] = $param['goods_add_coupon_no'][$i];
                        $cart[$i]['ADD_COUPON_CODE'] = $param['goods_add_coupon_code'][$i];
                        $cart[$i]['ADD_COUPON_NUM'] = $param['goods_add_coupon_num'][$i];
                        $cart[$i]['DELIVERY_PRICE'] = $param['goods_delivery_price'][$i];
                        $cart[$i]['DELIV_POLICY_NO'] = $param['deli_policy_no'][$i];
                        $cart[$i]['DELIV_PATTERN_TYPE'] = $param['deli_pattern'][$i];
                        log_message('DEBUG', '========='.$param['chk_deli_code'][$i].'-');

                        /** 사용 가능한 쿠폰 리스트 가져오기 */
                        $param3['goods_code'        ] = $param['goods_code'         ][$i];
                        $param3['brand_code'        ] = $param['brand_code'         ][$i];
                        $param3['category_mng_code' ] = $param['goods_cate_code3'   ][$i];
                        $auto_coupon = $this->cart_m->get_coupon_info($param3, 'AUTO');

                        for($j=0; $j<count($auto_coupon); $j++){
                            if($auto_coupon[$j]['COUPON_KIND_CD'] == 'GOODS'){	//만약 GOODS쿠폰이 있다면
                                $param['DUPLICATE'] = "";		// 배열을 생성함으로써 DUPLICATE가 Y인것만 보여주기
                                break;
                            }
                        }

                        $cust_coupon = $this->cart_m->get_coupon_info($param3, 'ADD');

                        for($cnt = 0; $cnt<count($auto_coupon); $cnt++){
                            if($auto_coupon[$cnt]['COUPON_DC_METHOD_CD'] == 'RATE') {
                                $coupon_num = explode('.', $auto_coupon[$cnt]['COUPON_SALE']);

                                if ($coupon_num[1] == '0') {
                                    $auto_coupon[$cnt]['COUPON_SALE'] = $coupon_num[0];
                                }
                            }
                        }

                        $cart[$i]['AUTO_COUPON_LIST'] = $auto_coupon;
                        $cart[$i]['CUST_COUPON_LIST'] = $cust_coupon;

                        if ($param['goods_cate_code1'][$i] == '10000000') {
                            $data['DELIV_INFO'] = 'Y';
                        }

                        if ($param['goods_cate_code1'][$i] == '18000000' && $param['goods_cate_code2'][$i] == '18010000') {
                            $data['DELIV_INFO'] = 'Y';
                        }

                        if ($param['send_nation'][$i] != 'KR') {        //출고지국가
                            $data['SEND_NATION_INFO'] = 'Y';
                        }

                        if($param['goods_cate_code1'][$i] == '18000000'){   //반려동물 카테고리 체크
                            $data['CATEGORY_PET'] = 'Y';
                        }

                        $param2['goods_code'] = $param['goods_code'][$i];
                        $goods_add_deli = $this->goods_m->get_goods_add_deli($param2);        //상품별 도서산간지역 추가배송비 가져오기
                        $cart[$i]['ADD_DELIVERY'] = $goods_add_deli;

                        $data['cart'][$deli_code][] = $cart[$i];
                    }

                } else if ($param['order_gb'] == 'C') {    //선택상품주문
                    for ($i = 0; $i < count($param['chkGoods']); $i++) {
                        $chk = explode("||", $param['chkGoods'][$i]);
//					var_dump($chk);
//					for($j=0; $j<count($chk); $j++){
//						var_dump("???");
                        $cnt = $chk[0];
                        $deli_code = $param['chk_deli_code'][$cnt];

                        $cart[$cnt]['GOODS_CD'] = $param['goods_code'][$cnt];
                        $cart[$cnt]['GOODS_NM'] = $param['goods_name'][$cnt];
                        $cart[$cnt]['BRAND_CD'] = $param['brand_code'][$cnt];
                        $cart[$cnt]['BRAND_NM'] = $param['brand_name'][$cnt];
                        $cart[$cnt]['GOODS_OPTION_CD'] = $param['goods_option_code'][$cnt];
                        $cart[$cnt]['GOODS_OPTION_NM'] = $param['goods_option_name'][$cnt];
                        $cart[$cnt]['GOODS_OPTION_ADD_PRICE'] = $param['goods_option_add_price'][$cnt];
                        $cart[$cnt]['GOODS_CNT'] = $param['goods_cnt'][$cnt];
                        $cart[$cnt]['GOODS_OPTION_QTY'] = $param['goods_option_qty'][$cnt];
                        $cart[$cnt]['BUY_LIMIT_QTY'] = $param['goods_buy_limit_qty'][$cnt];
                        $cart[$cnt]['GOODS_IMG'] = $param['goods_img'][$cnt];
                        $cart[$cnt]['GOODS_PRICE_CD'] = $param['goods_price_code'][$cnt];
                        $cart[$cnt]['SELLING_PRICE'] = $param['goods_selling_price'][$cnt];
                        $cart[$cnt]['STREET_PRICE'] = $param['goods_street_price'][$cnt];
                        $cart[$cnt]['FACTORY_PRICE'] = $param['goods_factory_price'][$cnt];
                        $cart[$cnt]['GOODS_MILEAGE_SAVE_RATE'] = $param['goods_mileage_save_rate'][$cnt];
                        $cart[$cnt]['DISCOUNT_PRICE'] = $param['goods_discount_price'][$cnt];
                        $cart[$cnt]['ADD_DISCOUNT_PRICE'] = $param['goods_add_discount_price'][$cnt];
                        $cart[$cnt]['SELLER_COUPON_CODE'] = $param['goods_coupon_code_s'][$cnt];
                        $cart[$cnt]['SELLER_COUPON_AMT'] = $param['goods_coupon_amt_s'][$cnt];
                        $cart[$cnt]['ITEM_COUPON_CODE'] = $param['goods_coupon_code_i'][$cnt];
                        $cart[$cnt]['ITEM_COUPON_AMT'] = $param['goods_coupon_amt_i'][$cnt];
//						$cart[$cnt]['COUPON_NUM'				] = $param['goods_coupon_num'			][$cnt];
                        $cart[$cnt]['ADD_COUPON_NO'] = $param['goods_add_coupon_no'][$cnt];
                        $cart[$cnt]['ADD_COUPON_CODE'] = $param['goods_add_coupon_code'][$cnt];
                        $cart[$cnt]['ADD_COUPON_NUM'] = $param['goods_add_coupon_num'][$cnt];
                        $cart[$cnt]['DELIVERY_PRICE'] = $param['goods_delivery_price'][$cnt];
                        $cart[$cnt]['DELIV_POLICY_NO'] = $param['deli_policy_no'][$cnt];
                        $cart[$cnt]['DELIV_PATTERN_TYPE'] = $param['deli_pattern'][$cnt];
                        log_message('DEBUG', '========='.$param['deli_policy_no'][$cnt].'/');
                        log_message('DEBUG', '========='.$param['chk_deli_code'][$cnt].'-');

                        /** 사용 가능한 쿠폰 리스트 가져오기 */
                        $param3['goods_code'        ] = $param['goods_code'         ][$cnt];
                        $param3['brand_code'        ] = $param['brand_code'         ][$cnt];
                        $param3['category_mng_code' ] = $param['goods_cate_code3'   ][$cnt];
                        $auto_coupon = $this->cart_m->get_coupon_info($param3, 'AUTO');

                        for($j=0; $j<count($auto_coupon); $j++){
                            if($auto_coupon[$j]['COUPON_KIND_CD'] == 'GOODS'){	//만약 GOODS쿠폰이 있다면
                                $param['DUPLICATE'] = "";		// 배열을 생성함으로써 DUPLICATE가 Y인것만 보여주기
                                break;
                            }
                        }

                        $cust_coupon = $this->cart_m->get_coupon_info($param3, 'ADD');

                        for($cnt2 = 0; $cnt2<count($auto_coupon); $cnt2++){
                            if($auto_coupon[$cnt2]['COUPON_DC_METHOD_CD'] == 'RATE') {
                                $coupon_num = explode('.', $auto_coupon[$cnt2]['COUPON_SALE']);

                                if ($coupon_num[1] == '0') {
                                    $auto_coupon[$cnt2]['COUPON_SALE'] = $coupon_num[0];
                                }
                            }
                        }

                        $cart[$cnt]['AUTO_COUPON_LIST'] = $auto_coupon;
                        $cart[$cnt]['CUST_COUPON_LIST'] = $cust_coupon;

                        if ($param['goods_cate_code1'][$cnt] == '10000000') {
                            $data['DELIV_INFO'] = 'Y';
                        }

                        if ($param['goods_cate_code1'][$cnt] == '18000000' && $param['goods_cate_code2'][$cnt] == '18010000') {
                            $data['DELIV_INFO'] = 'Y';
                        }

                        if ($param['send_nation'][$cnt] != 'KR') {        //출고지국가
                            $data['SEND_NATION_INFO'] = 'Y';
                        }

                        if($param['goods_cate_code1'][$cnt] == '18000000'){   //반려동물 카테고리 체크
                            $data['CATEGORY_PET'] = 'Y';
                        }
                        $param2['goods_code'] = $param['goods_code'][$cnt];
                        $goods_add_deli = $this->goods_m->get_goods_add_deli($param2);        //상품별 도서산간지역 추가배송비 가져오기
                        $cart[$cnt]['ADD_DELIVERY'] = $goods_add_deli;
                        $data['cart'][$deli_code][] = $cart[$cnt];
//					}
                    }
//				var_dump($data['cart']);

                } else if ($param['order_gb'] == 'D') {    //바로상품주문
                    $i = explode("||", $param['direct_code'])[0];
                    $deli_code = explode("||", $param['deli_code'][$i])[0];

                    $cart[$i]['GOODS_CD'] = $param['goods_code'][$i];
                    $cart[$i]['GOODS_NM'] = $param['goods_name'][$i];
                    $cart[$i]['BRAND_CD'] = $param['brand_code'][$i];
                    $cart[$i]['BRAND_NM'] = $param['brand_name'][$i];
                    $cart[$i]['GOODS_OPTION_CD'] = $param['goods_option_code'][$i];
                    $cart[$i]['GOODS_OPTION_NM'] = $param['goods_option_name'][$i];
                    $cart[$i]['GOODS_OPTION_ADD_PRICE'] = $param['goods_option_add_price'][$i];
                    $cart[$i]['GOODS_CNT'] = $param['goods_cnt'][$i];
                    $cart[$i]['GOODS_OPTION_QTY'] = $param['goods_option_qty'][$i];
                    $cart[$i]['BUY_LIMIT_QTY'] = $param['goods_buy_limit_qty'][$i];
                    $cart[$i]['GOODS_IMG'] = $param['goods_img'][$i];
                    $cart[$i]['GOODS_PRICE_CD'] = $param['goods_price_code'][$i];
                    $cart[$i]['SELLING_PRICE'] = $param['goods_selling_price'][$i];
                    $cart[$i]['STREET_PRICE'] = $param['goods_street_price'][$i];
                    $cart[$i]['FACTORY_PRICE'] = $param['goods_factory_price'][$i];
                    $cart[$i]['GOODS_MILEAGE_SAVE_RATE'] = $param['goods_mileage_save_rate'][$i];
                    $cart[$i]['DISCOUNT_PRICE'] = $param['goods_discount_price'][$i];
                    $cart[$i]['ADD_DISCOUNT_PRICE'] = $param['goods_add_discount_price'][$i];
                    $cart[$i]['SELLER_COUPON_CODE'] = $param['goods_coupon_code_s'][$i];
                    $cart[$i]['SELLER_COUPON_AMT'] = $param['goods_coupon_amt_s'][$i];
                    $cart[$i]['ITEM_COUPON_CODE'] = $param['goods_coupon_code_i'][$i];
                    $cart[$i]['ITEM_COUPON_AMT'] = $param['goods_coupon_amt_i'][$i];
//				$cart[$i]['COUPON_NUM'				] = $param['goods_coupon_num'			][$i];
                    $cart[$i]['ADD_COUPON_NO'] = $param['goods_add_coupon_no'][$i];
                    $cart[$i]['ADD_COUPON_CODE'] = $param['goods_add_coupon_code'][$i];
                    $cart[$i]['ADD_COUPON_NUM'] = $param['goods_add_coupon_num'][$i];
                    $cart[$i]['DELIVERY_PRICE'] = $param['goods_delivery_price'][$i];
                    $cart[$i]['DELIV_POLICY_NO'] = $param['deli_policy_no'][$i];
                    $cart[$i]['DELIV_PATTERN_TYPE'] = $param['deli_pattern'][$i];
                    $de = $param['goods_delivery_price'][0];

                    /** 사용 가능한 쿠폰 리스트 가져오기 */
                    $param3['goods_code'        ] = $param['goods_code'         ][$i];
                    $param3['brand_code'        ] = $param['brand_code'         ][$i];
                    $param3['category_mng_code' ] = $param['goods_cate_code3'   ][$i];
                    $auto_coupon = $this->cart_m->get_coupon_info($param3, 'AUTO');

                    for($j=0; $j<count($auto_coupon); $j++){
                        if($auto_coupon[$j]['COUPON_KIND_CD'] == 'GOODS'){	//만약 GOODS쿠폰이 있다면
                            $param['DUPLICATE'] = "";		// 배열을 생성함으로써 DUPLICATE가 Y인것만 보여주기
                            break;
                        }
                    }

                    $cust_coupon = $this->cart_m->get_coupon_info($param3, 'ADD');

                    for($cnt = 0; $cnt<count($auto_coupon); $cnt++){
                        if($auto_coupon[$cnt]['COUPON_DC_METHOD_CD'] == 'RATE') {
                            $coupon_num = explode('.', $auto_coupon[$cnt]['COUPON_SALE']);

                            if ($coupon_num[1] == '0') {
                                $auto_coupon[$cnt]['COUPON_SALE'] = $coupon_num[0];
                            }
                        }
                    }

                    $cart[$i]['AUTO_COUPON_LIST'] = $auto_coupon;
                    $cart[$i]['CUST_COUPON_LIST'] = $cust_coupon;

                    if ($param['goods_cate_code1'][$i] == '10000000') {    //대분류:가구
                        $data['DELIV_INFO'] = 'Y';
                    }

                    if ($param['goods_cate_code1'][$i] == '18000000' && $param['goods_cate_code2'][$i] == '18010000') {    //대분류:가드닝 / 중분류:야외용 가구
                        $data['DELIV_INFO'] = 'Y';
                    }

                    if ($param['send_nation'][$i] != 'KR') {        //출고지국가
                        $data['SEND_NATION_INFO'] = 'Y';
                    }

                    if($param['goods_cate_code1'][$i] == '18000000'){   //반려동물 카테고리 체크
                        $data['CATEGORY_PET'] = 'Y';
                    }

                    $param2['goods_code'] = $param['goods_code'][$i];
                    $goods_add_deli = $this->goods_m->get_goods_add_deli($param2);        //상품별 도서산간지역 추가배송비 가져오기
                    $cart[$i]['ADD_DELIVERY'] = $goods_add_deli;

                    $data['cart'][$deli_code . "||" . $param['goods_delivery_price'][$i]][] = $cart[$i];

                }
//                log_message('DEBUG', '============'.$de);
            }

            $data['order_gb'] = $param['order_gb'];        //A: 장바구니-전체구매, B: 상세페이지-바로구매, C: 장바구니-선택구매, D: 장바구니-바로구매
            $data['kcp_pay'] = false;
        }

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt'] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));    //장바구니 갯수 가져오기
        $data['header_gb'] = 'none';
        $data['add_wrap'] = 'cart-order';

        /**
         * 퀵 레이아웃
         */

        $this->load->view('include/header', $data);
        $this->load->view('cart/cart_step2', $data);
        $this->load->view('include/footer');

    }

    /**
     * 주문/결제 실패 페이지
     */
    public function Step3_Order_fail_get(){
        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
        $data['footer_gb'] = 'order';

        /**
         * 퀵 레이아웃
         */
        $this->load->library('quick_lib');
        $data['quick'] =  $this->quick_lib->get_quick_layer();

        $data['Nshopping'] = 'order';

        $this->load->view('include/header', $data);
        $this->load->view('cart/cart_step3_fail');
        $this->load->view('include/footer', $data);
    }

    /**
     * 주문/결제 완료 페이지 Load
     */
    public function Step3_Order_finish_get()
    {
//		error_reporting(E_ALL);
//ini_set('display_errors', 1);
        $order_no = $_GET['order_no'];

        //모델 LOAD
        $this->load->model('order_m');

        if($order_no > 1){ //결제 성공
            $order = $this->order_m->get_order_info($order_no);
            $refer = $this->order_m->get_order_refer_info($order_no);

            $data['order'] = $order;

            for($i=0; $i<count($refer); $i++){
                $data['refer'][$refer[$i]['DELIV_POLICY_NO']][] = $refer[$i];

                //스크립트에서 사용할 변수 2017-03-29
                $refer_data['GOODS_CD'		][] = $refer[$i]['GOODS_CD'];
                $refer_data['GOODS_NM'		][] = $refer[$i]['GOODS_NM'];
                $refer_data['SELLING_PRICE'	][] = $refer[$i]['SELLING_PRICE'];
                $refer_data['ORD_QTY'		][] = $refer[$i]['ORD_QTY'];

                //일일 구매제한 cookie로 설정 !, 우선은 한 상품에 한해서만.. 20180116 이진호
//                if($refer[$i]['BUY_LIMIT_CD'] == "DAY"){
//                    setcookie('limit_cd', $refer[$i]['GOODS_CD'], time() + 86400);
//                }
            }
            $data['order_no'	] = $order_no;
            $data['order_amt'	] = $order['ORDER_AMT'];
            $data['refer_data'	] = $refer_data;

            if(isset($_COOKIE['LPINFO'])){
                $Lparam = array();
                $Lparam['ORDER_NO'      ] = $order_no;
                $Lparam['NETWORK_VALUE' ] = $_COOKIE['LPINFO'];
                $Lparam['REMOTE_ADDRESS'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
                $Lparam['USER_AGENT'    ] = $_SERVER['HTTP_USER_AGENT'];
                $link_no = $this->order_m->set_lprice_value($Lparam);
                $data['link_no'] = $link_no;

                self::lprice($order_no);

            }


            /**
             * 상단 카테고리 데이타
             */
            $this->load->library('etah_lib');
            $category_menu = $this->etah_lib->get_category_menu();
            $data['menu'] = $category_menu['category'];
            $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
            $data['footer_gb'] = 'order';

            /**
             * 퀵 레이아웃
             */
            $this->load->library('quick_lib');
            $data['quick'] =  $this->quick_lib->get_quick_layer();

            $data['Nshopping'] = 'order';

            $this->load->view('include/header', $data);
            $this->load->view('cart/cart_step3', $data);
            $this->load->view('include/footer', $data);
        }else{
            /**
             * 상단 카테고리 데이타
             */
            $this->load->library('etah_lib');
            $category_menu = $this->etah_lib->get_category_menu();
            $data['menu'] = $category_menu['category'];
            $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
            $data['footer_gb'] = 'order';

            /**
             * 퀵 레이아웃
             */
            $this->load->library('quick_lib');
            $data['quick'] =  $this->quick_lib->get_quick_layer();

            $data['Nshopping'] = 'order';

            $this->load->view('include/header', $data);
            $this->load->view('cart/cart_step3_fail');
            $this->load->view('include/footer', $data);
        }
    }

    /**
     * 장바구니에 상품 담기
     */
    public function insert_cart_post()
    {
        //error_reporting(E_ALL);
//ini_set('display_errors', 1);
        $param = $this->input->post();

        if(!$this->session->userdata('EMS_U_NO_')){	//비회원일경우
            $tmp_auth	 = "";
            $tmp_authchr = "";
            $tmp_authnum = array();

            for($i=0; $i<3; $i++){		//알파벳 난수 3자리 생성
                mt_srand((double)microtime()*1000000);
                $tmp_authchr .= substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0,51), 1);
            }

            for($i=0; $i<5; $i++){	//난수 5자리 생성
                mt_srand((double)microtime()*1000000);
                $tmp_authnum[$i] = mt_rand(0,9);
                $tmp_auth .= $tmp_authnum[$i];
            }

            //로그인 세션 만들기
            $this->load->library('encrypt');

            $sess_data = array(
                'EMS_U_ID_'			=>	'TMP_GUEST',
                'EMS_U_NO_'			=>	$tmp_authchr.$tmp_auth
            );

            $this->session->set_userdata($sess_data);

            $param['cust_no'	] = $this->session->userdata('EMS_U_NO_');
        }

        $param2 = array();
        $param2['cust_no'		] = $param['cust_no'];
        $param2['goods_code'	] = $param['goods_code'];

        for($i=0; $i<count($param['goods_option_code']); $i++){
            $param2['goods_option_code'	] = $param['goods_option_code'][$i];
            $param2['goods_cnt'			] = $param['goods_cnt'][$i];

            $ChkCart = $this->cart_m->chk_cart($param2);		//동일 상품&옵션이 담겨있는지 확인하기

            if($ChkCart){
                $param2['cart_no'] = $ChkCart['CART_NO'];
                if($ChkCart['BUY_LIMIT_QTY'] == 0 ){
                    $param2['cnt'	] = $ChkCart['CART_QTY'] + $param2['goods_cnt'];
                }else{
                    if(($ChkCart['CART_QTY'] + $param2['goods_cnt']) > $ChkCart['BUY_LIMIT_QTY']){
                        $param2['cnt'	] = $ChkCart['BUY_LIMIT_QTY'];
                    }else{
                        $param2['cnt'	] = $ChkCart['CART_QTY'] + $param2['goods_cnt'];
                    }
                }
                $param2['gb'	] = 'CNT';

                $UpdCart = $this->cart_m->upd_cart($param2);
            } else {
                $AddCart = $this->cart_m->add_cart($param2);		//장바구니에 담기
            }
        }

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 장바구니에서 상품 제거
     */
    public function del_cart_post()
    {
        $param = $this->input->post();

        if($param['gb'] == 'A'){	//해당 상품 제거
            $DelCart = $this->cart_m->del_cart($param['cart_no']);	//장바구니에서 상품 제거

        } else if($param['gb'] == 'B'){	//선택한 상품 제거
            $cart_no = $param['chkGoods'];

            if(count($cart_no) != 0){
                for($i=0; $i<count($cart_no); $i++){
                    $DelCart = $this->cart_m->del_cart($cart_no[$i]);	//장바구니에서 상품 제거
                }
            }
        }

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 장바구니 옵션/수량 변경
     */
    public function chg_cart_post()
    {
        $param = $this->input->post();

        $param2 = array();
        $param2['gb'			] = $param['gb'];
        $param2['cart_no'		] = $param['cart_no'];
        $param2['cnt'			] = $param['cnt'];
        $param2['option_code'	] = $param['option_code'];
//		 $param2['option_code'] = explode('||',$param['option_code'])[0];

        $UpdCart = $this->cart_m->upd_cart($param2);	//변경
        $this->response(array('status' => 'ok'), 200);
//========================================================================
//		 //모델 LOAD
//		 $this->load->model('goods_m');
//
//		 $ChkOptionQTY = $this->goods_m->get_goods_option_qty($param2['option_code']);
//
//		 if($ChkOptionQTY['QTY'] >= $param2['cnt']){	//구매하고자 하는 수량이 재고수량보다 적을경우
//			$UpdCart = $this->cart_m->upd_cart($param2);	//변경
//			$this->response(array('status' => 'ok'), 200);
//		 } else {
//			$this->response(array('status' => 'error', 'message' => '현재 이 상품의 주문가능한 재고수량은 '.$ChkOptionQTY['QTY'].'개 입니다. '.$ChkOptionQTY['QTY'].'개 이하로 선택해주세요.'), 200);
//		 }
    }

    /**
     * 우편번호 시/군/구 불러오기
     */
    public function get_post_sigungu_post()
    {
        $param = $this->input->post();

        $sigungu_array = $this->cart_m->get_post_sigungu($param);

        $this->response(array('status' => 'ok', 'sigungu_list' => $sigungu_array), 200);
    }

    /**
     * 우편번호 검색 모듈
     */
    public function get_postnum_post()
    {
        $param = $this->input->post();

        if($param['gb'] == '01'){	//지번주소
            $old_addr = $this->cart_m->get_postnum_old($param);		//지번 주소

            $Old_addr_html = "";
            $idx = 0;

            foreach($old_addr as $row){
                $old_sido				= $row['SIDO'];
                $old_sigungu			= $row['SIGUNGU'];
                $old_eupmyeondong		= $row['EUPMYEONDONG'];
                $old_ri				= $row['RI'];
                $old_doseo				= $row['DOSEO'];
                $old_bungi				= $row['BUNGI'];
                $old_building_nm		= $row['BUILDING_NM'];
                $old_zip_code			= substr($row['ZIPCODE'],0,3)."-".substr($row['ZIPCODE'],3,3);

                $Old_addr_html .= "<li class='postcode-result-item'>";
                $Old_addr_html .= "<div class='address-box'>";
                $Old_addr_html .= "<input type='hidden' name='addr_v1[]' value='".$old_sido." ".$old_sigungu." ".$old_eupmyeondong." ".$old_ri." ".$old_doseo." ".$old_bungi." ".$old_building_nm."'>";
                $Old_addr_html .= "<input type='hidden' name='addr_post1[]' value='".$old_zip_code."'>";
                $Old_addr_html .= "<span class='area-postocode'>".$old_zip_code."</span>";
                $Old_addr_html .= "<p class='area-address'>".$old_sido." ".$old_sigungu." ".$old_eupmyeondong." ".$old_ri." ".$old_doseo." ".$old_bungi." ".$old_building_nm."</p>";
                $Old_addr_html .= "</div>";
                $Old_addr_html .= "<a href='javascript:jsPastepost(\"1\",".$idx.");' class='btn-white'>선택</a>";
                $Old_addr_html .= "</li>";

                $idx ++;
            }

            $this->response(array('status' => 'ok', 'old_addr' => $Old_addr_html, 'old_addr_cnt' => count($old_addr)), 200);
        } else if($param['gb'] == '02'){	//도로명주소 + 건물번호

            $new_addr = $this->cart_m->get_postnum_new($param);	//도로명주소

            $New_addr_html = "";
            $idx = 0;

            foreach($new_addr as $row){
                $new_sido				= $row['SIDO'];
                $new_sigungu			= $row['SIGUNGU'];

                if($new_sigungu == 'N/A'){
                    $new_sigungu = '';
                }

                $new_road_nm			= $row['ROAD_NM'];
                $new_road_no			= $row['ROAD_NO'];
                $new_building_nm		= $row['BUILDING_NM'];
                $new_lawdong_building_nm	= $row['LAWDONG_BUILDING_NM'];
                $new_lawdong_nm		= $row['LAWDONG_NM'];
                $new_admindong_nm		= $row['ADMINDONG_NM'];
                $new_gibun_bungi		= $row['GIBUN_BUNGI'];
                $new_zip_code			= $row['ZIPCODE'];

                $New_addr_html .= "<li class='postcode-result-item'>";
                $New_addr_html .= "<div class='address-box'>";
                $New_addr_html .= "<input type='hidden' name='addr_v2[]' value='".$new_sido." ".$new_sigungu." ".$new_road_nm." ".$new_road_no." ".$new_building_nm." ".$new_lawdong_building_nm."'>";
                $New_addr_html .= "<input type='hidden' name='addr_post2[]' value='".$new_zip_code."'>";
                $New_addr_html .= "<span class='area-postocode'>".$new_zip_code."</span>";
                $New_addr_html .= "<p class='area-address'>".$new_sido." ".$new_sigungu." ".$new_road_nm." ".$new_road_no." ".$new_building_nm." ".$new_lawdong_building_nm."</p>";
                $New_addr_html .= "</div>";
                $New_addr_html .= "<a href='javascript:jsPastepost(\"2\",".$idx.");' class='btn-white'>선택</a>";
                $New_addr_html .= "</li>";

                $idx ++;
            }

            $this->response(array('status' => 'ok', 'new_addr' => $New_addr_html, 'new_addr_cnt' => count($new_addr)), 200);
        } else if($param['gb'] == '03'){	//아파트명

            $new_addr = $this->cart_m->get_postnum_new($param);	//도로명주소

            $New_addr_html = "";
            $idx = 0;

            foreach($new_addr as $row){
                $new_sido				= $row['SIDO'];
                $new_sigungu			= $row['SIGUNGU'];

                if($new_sigungu == 'N/A'){
                    $new_sigungu = '';
                }

                $new_road_nm			= $row['ROAD_NM'];
                $new_road_no			= $row['ROAD_NO'];
                $new_building_nm		= $row['BUILDING_NM'];
                $new_lawdong_building_nm	= $row['LAWDONG_BUILDING_NM'];
                $new_lawdong_nm		= $row['LAWDONG_NM'];
                $new_admindong_nm		= $row['ADMINDONG_NM'];
                $new_gibun_bungi		= $row['GIBUN_BUNGI'];
                $new_zip_code			= $row['ZIPCODE'];

                $New_addr_html .= "<li class='postcode-result-item'>";
                $New_addr_html .= "<input type='hidden' name='addr_v2[]' value='".$new_sido." ".$new_sigungu." ".$new_road_nm." ".$new_road_no." ".$new_building_nm." ".$new_lawdong_building_nm."'>";
                $New_addr_html .= "<input type='hidden' name='addr_post2[]' value='".$new_zip_code."'>";
                $New_addr_html .= "<span class='area-postocode'>".$new_zip_code."</span>";
                $New_addr_html .= "<p class='area-address'>".$new_sido." ".$new_sigungu." ".$new_road_nm." ".$new_road_no." ".$new_building_nm." ".$new_lawdong_building_nm."</p>";
                $New_addr_html .= "</div>";
                $New_addr_html .= "<a href='javascript:jsPastepost(\"2\",".$idx.");' class='btn-white'>선택</a>";
                $New_addr_html .= "</li>";

                $idx ++;
            }

            $this->response(array('status' => 'ok', 'new_addr' => $New_addr_html, 'new_addr_cnt' => count($new_addr)), 200);
        }
    }

    /**
     * 추가 배송비 모듈
     */
    public function get_add_delivery_post()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $param = $this->input->post();

        $no_deli  = $this->cart_m->get_no_delivery($param);		//배송불가지역인지 확인
//var_dump($no_deli);
        if($no_deli){	//배송불가지역일경우
            $this->response(array('status' => 'error', 'message' => $no_deli['DELIV_AREA_NM']."에 배송이 불가능한 상품이 있습니다. \n상품별 배송지역을 확인해주세요."), 200);
        } else {
            $add_deli = $this->cart_m->get_add_delivery_cost($param);

            if(!$add_deli){
                $delivery_cost = 0;
            } else {
                $delivery_cost = $add_deli['ADD_DELIV_COST'];
            }

            //		 var_dump($delivery_cost);
            $this->response(array('status' => 'ok', 'add_delivery_price' => $delivery_cost), 200);
        }

    }

    /**
     * 링크 프라이스 실적 전송
     */
    public function lprice($param)
    {
        $send_data = array();
        $search_order_code = $param;    // order code from complete payment page

        $send_data = $this->order_m->get_lprice_order($search_order_code);

//data send
        if (!empty($send_data)) {
            define("LP_URL", "https://service.linkprice.com/lppurchase_cps_v3.php");
            $options = array(
                'http' => array(
                    'method' => 'POST',
                    'content' => json_encode($send_data),
                    'header' => "Content-type: application/json\r\n"
                )
            );
            $context = stream_context_create($options);
            $result = file_get_contents(LP_URL, false, $context);
        }
    }
}