<?php
/**
 * User:
 * Date: 2016/12/20
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Mywiz extends MY_Controller
{

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
        $this->load->model('mywiz_m');

        //비로그인 상태에서는 회원정보 페이지 접근 불가
        if(!$this->session->userdata('EMS_U_ID_')) redirect('/member/login', 'refresh');
    }

    public function index_get()
    {
        self::mypage_get();

    }

    /**
     * 마이페이지
     */
    public function mypage_get()
    {
        $data = array();

        /* load model */
        $this->load->model('cart_m');

        $data['mycoupon_cnt'		] = $this->mywiz_m->get_coupon_count_by_cust();	//보유쿠폰 갯수 가져오기
        $data['mileage'				] = $this->mywiz_m->get_mileage_by_cust();			//보유 마일리지 가져오기
        $data['order_state'			] = $this->mywiz_m->get_order_state_by_cust_no();	//주문상태 갯수
        $data['order_state1'		] = $this->mywiz_m->get_order_state_by_cust_no_limit1();	//주문상태 limit 1

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
        $data['footer_gb'] = 'mywiz';


        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        $this->load->view('include/header', $data);
//		$this->load->view('include/menu');
        $this->load->view('mywiz/mypage');
//		$this->load->view('include/bottom_menu');
        $this->load->view('include/footer', $data);

    }

    /**
     * 비밀번호 확인
     */
    public function check_password_get()
    {
        $type  = $this->uri->segment(3);
        if($type){
            switch($type){
                case 'D' :	$data['title'] = '배송지관리'; break;
                case 'MI':	$data['title'] = '개인정보 수정'; break;
                case 'ML':	$data['title'] = '회원탈퇴'; break;
                case 'MS':	$data['title'] = '간편로그인 연동'; break;
            }
        }
        $data['coupon'		] = $this->mywiz_m->get_coupon_count_by_cust();	//쿠폰개수
        $data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();			//잔여 마일리지
//		$data['cancel_apply'] = "";
        $data['nav'			] = $type;

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
        $data['footer_gb'] = 'mywiz';

        /* load model */
        $this->load->model('cart_m');
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        $this->load->view('include/header', $data);
        $this->load->view('mywiz/check_password');
        $this->load->view('include/footer');
    }

    /**
     * 비밀번호 확인
     */
    public function check_password_post()
    {
        //Load MODEL
        $this->load->model('member_m');

        $param = $this->input->post();

        $cust_id = $this->session->userdata('EMS_U_ID_');

        if($this->member_m->get_member_info_pw1($cust_id, $param['password'])){
            $this->response(array('status' => 'ok'), 200);
        }else{
            $this->response(array('status' => 'error', 'message' => '비밀번호가 일치하지 않습니다.'), 200);
        }
    }

    /**
     * 개인정보 수정
     */
    public function myinfo_get()
    {
        $data = array();

        $info = $this->mywiz_m->get_member_info_by_cust_no();	//회원정보

        $info['arr_email'] = explode('@',$info['EMAIL']);
        $info['arr_phone'] = explode('-',$info['MOB_NO']);

        if(empty($info['arr_phone'][1]) && empty($info['arr_phone'][2])){
            $info['arr_phone'][1] = "";
            $info['arr_phone'][2] = "";
        }

//		var_dump($info['arr_phone']);

        $data['info'		] = $info;
//		$data['cancel_apply'] = "";
        $data['nav'			] = "MI";

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
        $data['footer_gb'] = 'mywiz';
        $data['add_wrap'] = 'mypage';

        /* load model */
        $this->load->model('cart_m');
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        $this->load->view('include/header', $data);
        $this->load->view('mywiz/modify_myinfo');
        $this->load->view('include/footer');
    }

    /**
     * 개인정보 수정
     */
    public function myinfo_post()
    {
        $param = $this->input->post();

        if($param['mob_phone2']){
            $param['mob_phone'] = $param['mob_phone1']."-".$param['mob_phone2']."-".$param['mob_phone3'];
        }else{
            $param['mob_phone'] = "";
        }

        if(!$param['mem_gender']){
            $param['mem_gender'] = 'NULL';
        }
        if(!$param['petYn']){
            $param['petYn'] = 'NULL';
        }
        if(!$param['merry']){
            $param['merry'] = 'NULL';
        }

        if(!$this->mywiz_m->update_member_info($param)){
            $this->response(array('status' => 'error', 'message'=>'잠시 후에 다시 시도하여 주시기 바랍니다.'), 200);
        }

        //추천인 적립
        if($param['chk_rcmdId'] != ''){
            $this->load->model('member_m');
            $this->member_m->insert_mileage_recommendId($param['chk_rcmdId']);
        }

        $this->response(array('status' => 'ok'), 200);

    }

    public function myinfo_fin_get()
    {
        $data = array();

        $this->load->view('include/header', $data);
        $this->load->view('mywiz/modify_myinfo_finish');
        $this->load->view('include/footer');
    }

    /**
     * 배송지관리
     */
    public function delivery_get()
    {
        $data = array();

        //배송지관리 조회
        self::_delivery_list($data);
    }

    /**
     * 배송지관리 페이지
     */
    public function delivery_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'	] = $page;

        //배송지관리 조회
        self::_delivery_list($get_vars);
    }

    /**
     * 배송지관리 리스트
     */
    public function _delivery_list($param)
    {
        $this->load->model('cart_m');

        $data = array();

        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 5   : $param['limit_num_rows'];

        $totalCnt = $this->mywiz_m->get_delivery_list_count($param);

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        $delivery = $this->mywiz_m->get_delivery_list($param);					//배송지

        $idx=0;
        foreach($delivery as $row){
            $delivery[$idx]['arr_mob'] =  explode('-',$row['MOB_NO']);
            $idx++;
        }

//		var_dump($delivery);

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'mywiz/delivery_page';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
        $data['delivery'	] = $delivery;
        $data['coupon'		] = $this->mywiz_m->get_coupon_count_by_cust();		//쿠폰개수
        $data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();			//잔여 마일리
//		$data['cancel_apply'] = "";
        $data['nav'			] = "D";
        $data['deliv_sido_list'		] = $this->cart_m->get_post_sido();					//주소찾기 시/도 select box data

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
        $data['footer_gb'] = 'mywiz';

        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        $this->load->view('include/header', $data);
        $this->load->view('mywiz/delivery');
        $this->load->view('include/footer');
    }

    /**
     * 우편번호 찾기 레이어
     */
    public function search_address_post()
    {
        $this->load->model('cart_m');

        $param = $this->input->post();

        $data = array();
        $data['deliv_sido_list'	] = $this->cart_m->get_post_sido();		//주소찾기 시/도 select box data
        $data['gubun'			] = $param['gubun'];
        $search_address = $this->load->view('mywiz/search_address.php', $data, TRUE); //우편번호 검색

        $this->response(array('status' => 'ok', 'search_address'=>$search_address), 200);
    }

    /**
     * 배송지등록
     */
    public function register_delivery_post()
    {
        $param = $this->input->post();

        $this->mywiz_m->register_delivery($param);

//		var_dump($param);
        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 배송지수정
     */
    public function update_delivery_post()
    {
        $param = $this->input->post();

        $this->mywiz_m->update_delivery($param);

//		var_dump($param);
        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 배송지삭제
     */
    public function delete_delivery_post()
    {
        $param = $this->input->post();

        if(!$this->mywiz_m->delete_delivery($param['deliv_no'])){
            $this->response(array('status' => 'error', 'message' => '잠시 후에 다시 시도하여주시기 바랍니다.'), 200);

        }
        $this->response(array('status' => 'ok'), 200);

    }

    /**
     * 기본배송지 설정
     */
    public function base_delivery_post()
    {
        $param = $this->input->post();

        if(!$this->mywiz_m->update_base_delivery('N')){
            $this->response(array('status' => 'error', 'message' => '잠시 후에 다시 시도하여주시기 바랍니다.'), 200);
        }else{
            if(!$this->mywiz_m->update_base_delivery('Y',$param['deliv_no'])){
                $this->response(array('status' => 'error', 'message' => '잠시 후에 다시 시도하여주시기 바랍니다.'), 200);
            }else{
                $this->response(array('status' => 'ok'), 200);
            }
        }
    }

    /**
     * 최근 본 상품 page
     */
    public function view_goods_get()
    {
        $data = array();

        $page	= $this->uri->segment(3);

        $page = empty($page) ? 1   : $page;
        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 10   : $param['limit_num_rows'];

        $this->load->model('quick_m');
        $data['view_cnt']	= $this->quick_m->get_view_goods_count();
        $data['view']		= $this->quick_m->get_view_goods($page);
//var_dump($data['view']);
        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'mywiz/view_goods';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $data['view_cnt'];
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();

        /* load model */
        $this->load->model('cart_m');
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        $data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기

        $this->load->view('include/header', $data);
        $this->load->view('mywiz/view_goods');
        $this->load->view('include/footer');
    }

    /**
     * 관심상품 page
     */
    public function interest_get()
    {
        $data = array();

        $param['page']	= $this->uri->segment(3);

        $param['page'] = empty($param['page']) ? 1   : $param['page'];

        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 5   : $param['limit_num_rows'];

        $totalCnt = $this->mywiz_m->get_interest_list_count();

        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }
        $wish_list = $this->mywiz_m->get_interest_list($param);

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'mywiz/interest';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();

        /* load model */
        $this->load->model('cart_m');
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        $data['totalCnt'	] = $totalCnt;
        $data['wish_list'	] = $wish_list;

        $data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기

        $this->load->view('include/header', $data);
        $this->load->view('mywiz/interest');
        $this->load->view('include/footer');
    }

    /**
     * 관심상품 삭제
     */
    public function delete_interest_post()
    {
        $param = $this->input->post();
        $param['cust_no'] = $this->session->userdata('EMS_U_NO_');

        if(!$this->mywiz_m->update_interest($param,'N')) $this->response(array('status' => 'error'), 200);

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 관심상품 선택삭제
     */
    public function chk_delete_interest_post()
    {
        $param = $this->input->post();
        $param['cust_no'] = $this->session->userdata('EMS_U_NO_');

        foreach($param['goodsArr'] as $row){
            $param['goods_cd'] = $row;
            if(!$this->mywiz_m->update_interest($param,'N')) $this->response(array('status' => 'error'), 200);
        }

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 1:1문의
     */
    public function qna_get()
    {
        $data = array();
        $data['gb'			] = '01';
        $data['gb_nm'		] = 'qna';
        $data['date_type'	] = '0';
        $data['date_from'	] = date("Y-m-d", strtotime("-1 week"));
        $data['date_to'		] = date("Y-m-d", time());
        $data['nav'			] = "PQ";

        //1:1문의 리스트 조회
        self::_qna_list($data);
    }

    /**
     * 1:1문의 페이징
     */
    public function qna_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['gb'		] = '01';
        $get_vars['gb_nm'	] = 'qna';
        $get_vars['page'	] = $page;
        $get_vars['nav'		] = "PQ";

        //1:1문의 리스트 조회
        self::_qna_list($get_vars);
    }

    /**
     * Q&A
     */
    public function goods_qna_get()
    {
        $data = array();
        $data['gb'			] = '02';
        $data['gb_nm'		] = 'goods_qna';
        $data['date_type'	] = '0';
        $data['date_from'	] = date("Y-m-d", strtotime("-1 week"));
        $data['date_to'		] = date("Y-m-d", time());
        $data['nav'			] = "Q";

        //qna 리스트 조회
        self::_qna_list($data);
    }

    /**
     * Q&A 페이징
     */
    public function goods_qna_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['gb'		] = '02';
        $get_vars['gb_nm'	] = 'goods_qna';
        $get_vars['page'	] = $page;
        $get_vars['nav'		] = "Q";

        //qna 리스트 조회
        self::_qna_list($get_vars);
    }

    /**
     * 활동 및 문의 리스트
     */
    public function _qna_list($param)
    {
        $data = array();

        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 5   : $param['limit_num_rows'];

        $totalCnt = $this->mywiz_m->get_qna_list_count($param);

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        $qna_list = $this->mywiz_m->get_qna_list($param);

//		//페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'mywiz/'.$param['gb_nm'].'_page';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '5';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
        $data['qna_list'	] = $qna_list;
        $data['date_type'	] = $param['date_type'];
        $data['date_from'	] = $param['date_from'];
        $data['date_to'		] = $param['date_to'];
        $data['total_cnt'	] = $totalCnt;
        $data['page'		] = $param['page'];
        $data['sNum'		] = $param['limit_num_rows'	];

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
        $data['footer_gb'] = 'mywiz';

        /* load model */
        $this->load->model('cart_m');
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        $this->load->view('include/header', $data);
//		$this->load->view('include/menu');
        $this->load->view('mywiz/'.$param['gb_nm']);
//		$this->load->view('include/bottom_menu');
        $this->load->view('include/footer', $data);

    }

    /**
     * 1:1문의 수정 레이어
     */
    public function layer_modify_qna_post()
    {
        $param = $this->input->post();
        $data = array();

        /* model_m */
        $this->load->model('customer_m');

        $param['limit_num_rows'	] = 5;
        $param['page'			] = empty($param['page'				]) ? 1 : $param['page'			];
        $totalPage = 0;

        $totalCnt = $this->customer_m->get_order_list_count_by_customer($param);

        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        if($totalPage > 5){
            $data['cnt_page'] = 5;
        }else{
            $data['cnt_page'] = $totalPage;
        }

        $data['qna_no'		] = $param['qna_no'];
        $data['qna'			] = $this->mywiz_m->get_qna_detail($param['qna_no']);		//문의내용
        $data['qna_type'	] = $this->customer_m->get_qna_type_list();					//문의타입
        $data['order'		] = $this->customer_m->get_order_list_by_customer($param);	//주문내역
        $data['total_cnt'	] = $totalCnt;
        $data['total_page'	] = $totalPage;
        $modify_qna = $this->load->view('mywiz/modify_qna.php', $data, TRUE);		//1:1문의 수정

        $this->response(array('status' => 'ok', 'modify_qna'=>$modify_qna), 200);;
    }

    /**
     * 상품문의 수정 레이어
     */
    public function layer_modify_goods_qna_post()
    {
        $param = $this->input->post();
        $data = array();

        $data['qna_no'		] = $param['qna_no'];
        $data['qna'			] = $this->mywiz_m->get_qna_goods_detail($param['qna_no']);		//문의내용

        $modify_goods_qna = $this->load->view('mywiz/modify_goods_qna.php', $data, TRUE);		//1:1문의 수정

        $this->response(array('status' => 'ok', 'modify_goods_qna'=>$modify_goods_qna), 200);;
    }

    /**
     * 상품 문의 등록하기
     */
    public function qna_regist_post()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $param = $this->input->post();

        $this->load->model('member_m');

        $param = str_replace("\\","\\\\",$param);
        $param = str_replace("'","\'",$param);
        $param = str_replace("\n","<br />",$param);

        $member = $this->member_m->get_member_info_id($param['mem_id']);

        $param['mem_no'	] = $member['CUST_NO'];
        $param['mem_name'	] = $member['CUST_NM'];
        $param['mem_mobile'] = $member['MOB_NO'];
        $param['mem_email' ] = $member['EMAIL'];
        $param['date'		] = date("Y-m-d H:i:s", time());

        $qna_no = $this->mywiz_m->regist_qna($param, 'T');
        $param['qna_no'] = $qna_no;

        $qna_content	= $this->mywiz_m->regist_qna($param, 'C');
        $map_qna		= $this->mywiz_m->regist_map_qna_N_goods($param);

        $this->response(array('status' => 'ok'), 200);

    }

    /**
     * 상품문의 수정하기
     */
    public function update_goods_qna_post()
    {
        $param = $this->input->post();

        $param = str_replace("\\","\\\\",$param);
        $param = str_replace("'","\'",$param);
        $param = str_replace("\n","<br />",$param);

//		 var_dump($param);

        $this->mywiz_m->update_goods_qna($param);


        $this->response(array('status' => 'ok'), 200);

    }

    /**
     * 문의 삭제
     */
    public function delete_qna_post()
    {
        $param = $this->input->post();

        $this->mywiz_m->delete_qna($param, 'DAT_CS');
        $this->mywiz_m->delete_qna($param, 'DAT_CS_CONTENTS_REPLY');

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 선택 문의 삭제
     */
    public function chk_delete_qna_post()
    {
        $param = $this->input->post();
        $qParam = array();

        foreach($param['qnaArr'] as $qna_no){
            $qParam['qna_no'] = $qna_no;
            $this->mywiz_m->delete_qna($qParam, 'DAT_CS');
            $this->mywiz_m->delete_qna($qParam, 'DAT_CS_CONTENTS_REPLY');
        }

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 상품평
     */
    public function goods_comment_get()
    {
        $data = array();
        $data['date_type'	] = '0';
        $data['date_from'	] = date("Y-m-d", strtotime("-1 week"));
        $data['date_to'		] = date("Y-m-d", time());

        //상품평 리스트
        self::_goods_comment_list($data);
    }

    /**
     * 상품평 리스트 페이지
     */
    public function comment_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'	] = $page;

        //상품평 리스트
        self::_goods_comment_list($get_vars);
    }


    /**
     * 상품평 리스트
     */
    public function _goods_comment_list($param)
    {
        $param['limit_num_rows'	] = 5;

        $totalCnt = $this->mywiz_m->get_goods_comment_count_by_cust($param);

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'mywiz/comment_page';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '5';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
        $data['comment'		] = $this->mywiz_m->get_goods_comment_by_cust($param);
        $data['date_type'	] = $param['date_type'];
        $data['date_from'	] = $param['date_from'];
        $data['date_to'		] = $param['date_to'];

        for($i=0;$i<count($data['comment']);$i++){
            $iparam['comment_no'] = $data['comment'][$i]['CUST_GOODS_COMMENT'];
            $data['comment'][$i]['FILE_PATH'] = $this->mywiz_m->get_goods_comment_file($iparam);
        }

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
        $data['footer_gb'] = 'mywiz';

        /* load model */
        $this->load->model('cart_m');
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        $this->load->view('include/header', $data);
//		$this->load->view('include/menu');
        $this->load->view('mywiz/goods_comment');
//		$this->load->view('include/bottom_menu');
        $this->load->view('include/footer', $data);

    }

    /**
     * 상품평 수정 레이어
     */
    public function update_goods_comment_get()
    {
        $param = $this->input->get();
        $data = array();

        $data['comment'		] = $this->mywiz_m->get_goods_comment_detail($param['comment_no']);	//상품평
        $data['comment'     ]['FILE_PATH'   ]   = $this->mywiz_m->get_goods_comment_file($param); //상품평 첨부파일

        $modify_comment = $this->load->view('mywiz/modify_goods_comment.php', $data, TRUE);		//상품평 수정

        $this->response(array('status' => 'ok', 'modify_comment'=>$modify_comment), 200);;
    }

    /**
     * 상품평 수정하기
     */
    public function update_goods_comment_post()
    {
        $param = $this->input->post();

//		$param = str_replace("\\","\\\\\\",$param);
        $param = str_replace("\n", '<br />', $param);
        $param = str_replace("'","\'",$param);


        //첨부파일 확인 - 기존에 파일 있었음
        if($param['fileGb'] == "isEx") {
            if($_FILES['fileUpload2']['name']){

                $retUrl = array();

                $this->load->helper(array('form', 'url'));

                $image_path = '/webservice_root/etah_mfront/assets/uploads';

                if ( ! @is_dir($image_path)){
                    $this->response(array('status' => 'error upload fail_NO Directory'));
                }

                $config['upload_path'	] = $image_path;
                $config['allowed_types'	] = 'gif|jpg|jpeg|png';

                $this->load->library('upload', $config);

                //파일 압축해서 하나씩 업로드
                for($a=0;$a<count($_FILES['fileUpload2']['tmp_name']);$a++) {
                    if($_FILES['fileUpload2']['name'][$a] != '') {
                        if ($_FILES['fileUpload2']['size'][$a] > 5500000) {
                            $this->response(array('status' => 'fail', 'message' => '파일 너무 큼'), 200);
                        }
                        else {
                            //0 (최저품질), 75 (기본품질값), 100(최고품질)
                            if ($_FILES['fileUpload2']['size'][$a] < 5500000 && $_FILES['fileUpload2']['size'][$a] > 2000000) { $quality = 50; }
                            else { $quality = 75; }


                            $file_name = $_FILES['fileUpload2']['name'][$a];
                            $url = '/webservice_root/etah_mfront/assets/uploads/'.$file_name;


                            $info = getimagesize($_FILES['fileUpload2']['tmp_name'][$a]);

                            if ($info['mime'] == 'image/jpeg')
                                $image = imagecreatefromjpeg($_FILES['fileUpload2']['tmp_name'][$a]);

                            elseif ($info['mime'] == 'image/gif')
                                $image = imagecreatefromgif($_FILES['fileUpload2']['tmp_name'][$a]);

                            elseif ($info['mime'] == 'image/png')
                                $image = imagecreatefrompng($_FILES['fileUpload2']['tmp_name'][$a]);


                            //모바일에서 세로사진 업로드시 회전되어 나오는 문제
                            $exif = exif_read_data($_FILES['fileUpload2']['tmp_name'][$a]);

                            if(!empty($exif['Orientation'])) {
                                switch ($exif['Orientation']) {
                                    case 8: $image = imagerotate($image, 90, 0);    break;
                                    case 3: $image = imagerotate($image, 180, 0);   break;
                                    case 6: $image = imagerotate($image, -90, 0);   break;
                                    default: $image = imagerotate($image, 0, 0);   break;
                                }
                            }

                            imagejpeg($image, $url, $quality);


                            $rparam['file_name' ] = $_FILES['fileUpload2']['name'][$a];
                            $rparam['file_ext'  ] = '.jpg';


                            $retTitle = self::_s3_upload($rparam, $param['goods_comment_no']);

                            unlink($image_path.'/'.$file_name);

                            //파일 덮어씌우기
                            if($param['file_no2'][$a] != '') {
                                $this->mywiz_m->update_goods_comment_file_path($retTitle, $param['file_no2'][$a]);
                            }
                            //파일 새로추가
                            else {
                                $this->mywiz_m->insert_goods_comment_file_path($retTitle, $param['comment_cd']);
                            }
                        }
                    } else {
                        //기존 첨부파일 삭제
                        if($param['file_url2'][$a] == '') {
                            $this->mywiz_m->update_goods_comment_file_path('', $param['file_no2'][$a]);
                        }
                    }
                }

            }
        }
        //첨부파일 확인 - 기존에 파일 없었음 (새로등록)
        else {
            if($_FILES['fileUpload2']['name']){
                $retUrl = array();

                $this->load->helper(array('form', 'url'));

                $image_path = '/webservice_root/etah_mfront/assets/uploads';

                if ( ! @is_dir($image_path)){
                    $this->response(array('status' => 'error upload fail_NO Directory'));
                }

                $config['upload_path'	] = $image_path;
                $config['allowed_types'	] = 'gif|jpg|jpeg|png';

                $this->load->library('upload', $config);

                //파일 압축해서 하나씩 업로드
                for($a=0;$a<count($_FILES['fileUpload2']['tmp_name']);$a++) {
                    if($_FILES['fileUpload2']['name'][$a] != '') {
                        if ($_FILES['fileUpload2']['size'][$a] > 5500000) {
                            $this->response(array('status' => 'fail', 'message' => '파일 너무 큼'), 200);
                        }
                        else {
                            //0 (최저품질), 75 (기본품질값), 100(최고품질)
                            if ($_FILES['fileUpload2']['size'][$a] < 5500000 && $_FILES['fileUpload2']['size'][$a] > 2000000) { $quality = 50; }
                            else { $quality = 75; }


                            $file_name = $_FILES['fileUpload2']['name'][$a];
                            $url = '/webservice_root/etah_mfront/assets/uploads/'.$file_name;


                            $info = getimagesize($_FILES['fileUpload2']['tmp_name'][$a]);

                            if ($info['mime'] == 'image/jpeg')
                                $image = imagecreatefromjpeg($_FILES['fileUpload2']['tmp_name'][$a]);

                            elseif ($info['mime'] == 'image/gif')
                                $image = imagecreatefromgif($_FILES['fileUpload2']['tmp_name'][$a]);

                            elseif ($info['mime'] == 'image/png')
                                $image = imagecreatefrompng($_FILES['fileUpload2']['tmp_name'][$a]);


                            //모바일에서 세로사진 업로드시 회전되어 나오는 문제
                            $exif = exif_read_data($_FILES['fileUpload2']['tmp_name'][$a]);

                            if(!empty($exif['Orientation'])) {
                                switch ($exif['Orientation']) {
                                    case 8: $image = imagerotate($image, 90, 0);    break;
                                    case 3: $image = imagerotate($image, 180, 0);   break;
                                    case 6: $image = imagerotate($image, -90, 0);   break;
                                    default: $image = imagerotate($image, 0, 0);   break;
                                }
                            }

                            imagejpeg($image, $url, $quality);


                            $rparam['file_name' ] = $_FILES['fileUpload2']['name'][$a];
                            $rparam['file_ext'  ] = '.jpg';

                            $retTitle = self::_s3_upload($rparam, $param['goods_comment_no']);

                            unlink($image_path.'/'.$file_name);

                            $this->mywiz_m->insert_goods_comment_file_path($retTitle, $param['comment_cd']);
                        }
                    }
                }
            }
        }

        if(!$this->mywiz_m->update_goods_comment($param))	$this->response(array('status' => 'error', 'message'=>'[에러] 상품평 수정이 실패되었습니다.'), 200);

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 상품평 삭제
     */
    public function delete_goods_comment_post()
    {
        $param = $this->input->post();

        if(!$this->mywiz_m->delete_goods_comment($param))	$this->response(array('status' => 'error', 'message'=>'[에러] 상품평 삭제가 실패되었습니다.'), 200);

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 상품평 등록하기 (상품상세페이지 하단에 위치)
     */
    public function comment_regist_post()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $mileage = 0;
        $param = $this->input->post();

        $param['grade_val'] = @$param['grade_val01'].@$param['grade_val02'].@$param['grade_val03'].@$param['grade_val04'].@$param['grade_val05'];

        $this->load->model('member_m');

        $param = str_replace("\\","\\\\",$param);
        $param = str_replace("'","\'",$param);
        $param = str_replace("\n","<br />",$param);

        $member = $this->member_m->get_member_info_id($this->session->userdata('EMS_U_ID_'));

        $param['mem_no'	] = $member['CUST_NO'];
        $param['mem_name'	] = $member['CUST_NM'];

        $comment_yn	= $this->mywiz_m->get_goods_order_refer($param);

        if(count($comment_yn) == 0){
            $this->response(array('status' => 'error', 'message' => '해당 상품을 구매하신 내역이 없습니다.'), 200);
            return false;
        }

        $param['order_refer_code'			] = $comment_yn[0]['ORDER_REFER_NO'];

        for($i=0; $i<count($comment_yn); $i++){
            $exists_comment = $this->mywiz_m->get_exists_comment_order($param);

            if($exists_comment['cnt'] == 1){	//이미 주문상세번호에 해당하는 상품평이 등록되어있다면 넘기기
                if($i+1 == count($comment_yn)){
                    $this->response(array('status' => 'error', 'message' => '이미 상품평을 입력하셨습니다.'), 200);
                    return false;
                }
                $param['order_refer_code'			] = $comment_yn[$i+1]['ORDER_REFER_NO'];
            } else {
                break;
            }
        }


        $chk_mileage = $this->mywiz_m->get_exists_all_comment_order($param);
        $mileage_yn = $chk_mileage['cnt'];

        $payinfo = $this->mywiz_m->get_payinfo($param['order_refer_code']);
        $mileage_std = $payinfo['REAL_PAY_AMT'];

        $param['goods_comment_no'] = $this->mywiz_m->regist_comment($param);

        $mileage = 1000;


        //첨부파일 확인
        if($_FILES['fileUpload']['name']){
            //첨부파일이 있을 때만 파일 업로드
            if(!empty(array_filter($_FILES['fileUpload']['name']))){
                $retUrl = array();

                $this->load->helper(array('form', 'url'));

                $image_path = '/webservice_root/etah_mfront/assets/uploads';

                if ( ! @is_dir($image_path)){
                    $this->response(array('status' => 'error upload fail_NO Directory'));
                }

                $config['upload_path'	] = $image_path;
                $config['allowed_types'	] = 'gif|jpg|jpeg|png';

                $this->load->library('upload', $config);


                //파일 압축해서 하나씩 업로드
                for($a=0;$a<count($_FILES['fileUpload']['tmp_name']);$a++) {
                    if($_FILES['fileUpload']['name'][$a] != '') {
                        if ($_FILES['fileUpload']['size'][$a] > 5500000) {
                            $this->response(array('status' => 'fail', 'message' => '파일 너무 큼'), 200);
                        }
                        else {
                            //0 (최저품질), 75 (기본품질값), 100(최고품질)
                            if ($_FILES['fileUpload']['size'][$a] < 5500000 && $_FILES['fileUpload']['size'][$a] > 2000000) { $quality = 50; }
                            else { $quality = 75; }


                            $file_name = $_FILES['fileUpload']['name'][$a];
                            $url = '/webservice_root/etah_mfront/assets/uploads/'.$file_name;


                            $info = getimagesize($_FILES['fileUpload']['tmp_name'][$a]);

                            if ($info['mime'] == 'image/jpeg')
                                $image = imagecreatefromjpeg($_FILES['fileUpload']['tmp_name'][$a]);

                            elseif ($info['mime'] == 'image/gif')
                                $image = imagecreatefromgif($_FILES['fileUpload']['tmp_name'][$a]);

                            elseif ($info['mime'] == 'image/png')
                                $image = imagecreatefrompng($_FILES['fileUpload']['tmp_name'][$a]);


                            //모바일에서 세로사진 업로드시 회전되어 나오는 문제
                            $exif = @exif_read_data($_FILES['fileUpload']['tmp_name'][$a]);

                            if(!empty($exif['Orientation'])) {
                                switch ($exif['Orientation']) {
                                    case 8: $image = imagerotate($image, 90, 0);    break;
                                    case 3: $image = imagerotate($image, 180, 0);   break;
                                    case 6: $image = imagerotate($image, -90, 0);   break;
                                    default: $image = imagerotate($image, 0, 0);   break;
                                }
                            }

                            imagejpeg($image, $url, $quality);


                            $rparam['file_name' ] = $_FILES['fileUpload']['name'][$a];
                            $rparam['file_ext'  ] = '.jpg';


                            $retTitle = self::_s3_upload($rparam, $param['goods_comment_no']);

                            unlink($image_path.'/'.$file_name);

                            $this->mywiz_m->insert_goods_comment_file_path($retTitle, $param['goods_comment_no']);

                        }

                        $mileage = 2000;
                    }
                }
            }
        }


        //마일리지 적립해주기.
        $param['mileage'] = $mileage;
        if( ($mileage_std > 5000 ) && ($mileage_yn == 0) ) {
            $this->mywiz_m->insert_mileage_comment($param);
        }
        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * 마일리지
     */
    public function mileage_get()
    {
        $data = array();
        $data['date_type'] = '0';
        $data['date_from'] = date("Y-m-d", strtotime("-1 week"));
        $data['date_to'	 ] = date("Y-m-d", time());


        //마일리지 리스트 조회
        self::_mileage_list($data);
    }

    /**
     * 마일리지
     */
    public function mileage_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'	] = $page;

        //마일리지 조회
        self::_mileage_list($get_vars);
    }

    /**
     * 마일리지 리스트
     */
    public function _mileage_list($param)
    {
        $data = array();
//
        $data['date_type'	] = $param['date_type'];
        $data['date_from'	] = $param['date_from'];
        $data['date_to'		] = $param['date_to'];
//
        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 5   : $param['limit_num_rows'];

        $totalCnt = $this->mywiz_m->get_mileage_list_count($param);

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        $mileage_list = $this->mywiz_m->get_mileage_list($param);

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'mywiz/mileage_page';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '5';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
        $data['mileage_list'] = $mileage_list;
        $data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();			//잔여 마일리지

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
        $data['footer_gb'] = 'mywiz';

        /* load model */
        $this->load->model('cart_m');
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        $this->load->view('include/header', $data);
//		$this->load->view('include/menu');
        $this->load->view('mywiz/mileage');
//		$this->load->view('include/bottom_menu');
        $this->load->view('include/footer', $data);

    }

    /**
     * 쿠폰
     */
    public function coupon_get()
    {
        $data = array();
        $data['last_coupon'] = "";

        //쿠폰 리스트 조회
        self::_coupon_list($data);
    }

    /**
     * 쿠폰 페이지
     */
    public function coupon_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'	] = $page;

        //쿠폰조회
        self::_coupon_list($get_vars);
    }

    /**
     * 쿠폰 리스트
     */
    public function _coupon_list($param)
    {
        $data = array();

        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 5   : $param['limit_num_rows'];

        $totalCnt = $this->mywiz_m->get_coupon_list_count($param);

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }


        $coupon_list = $this->mywiz_m->get_coupon_list($param);

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'mywiz/coupon_page';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '5';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
        $data['coupon_list'	] = $coupon_list;
        $data['last_coupon'	] = $param['last_coupon'];
        $data['coupon'		] = $this->mywiz_m->get_coupon_count_by_cust();		//쿠폰개수
        $data['mileage'		] = $this->mywiz_m->get_mileage_by_cust();			//잔여 마일리지


        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
        $data['footer_gb'] = 'mywiz';

        /* load model */
        $this->load->model('cart_m');
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        $this->load->view('include/header', $data);
//		$this->load->view('include/menu');
        $this->load->view('mywiz/coupon');
//		$this->load->view('include/bottom_menu');
        $this->load->view('include/footer', $data);

    }

    /**
     * 주문/배송조회
     */
    public function order_get()
    {
        $data = array();

        $data['title'		] = "주문/배송조회";
        $data['date_type'	] = '1';
        $data['date_from'	] = date("Y-m-d", strtotime("-1 month"));
        $data['date_to'		] = date("Y-m-d", time());

        //주문 리스트 조회
        self::_order_list($data);
    }

    /**
     * 취소/반품
     */
    public function cancel_return_get()
    {
        $data = array();

        $data['title'		] = "취소/반품";
        $data['date_type'	] = '1';
        $data['date_from'	] = date("Y-m-d", strtotime("-1 month"));
        $data['date_to'		] = date("Y-m-d", time());

        //주문 리스트 조회
        self::_order_list($data);

    }

    /**
     * 주문리스트 페이징
     */
    public function order_page_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'] = $page;

        //주문 리스트 조회
        self::_order_list($get_vars);
    }


    /**
     * 주문 리스트
     */
    public function _order_list($param)
    {
        $data = array();
        $param['limit_num_rows'	] = 5;

        if($param['title'] == "취소/반품"){
            $param['cancel_return'] = "Y";
        }else{
            $param['cancel_return'] = "";
        }

        $totalCnt = $this->mywiz_m->get_order_list_count($param);

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }
//		var_dump($totalCnt);

        $order = $this->mywiz_m->get_order_list($param);		//최근주문
//		$cnt_order_refer = array();
//		$cnt_delivery	 = array();
//
//		$order_no = "";
//		$deli_no = "";
//		foreach($order	as $row){
//			if($order_no == $row['ORDER_NO']){
//				$cnt_order_refer[$row['ORDER_NO']] ++;
//			}else{
//				$cnt_order_refer[$row['ORDER_NO']] = 1;
//			}
//			if(empty($cnt_delivery[$row['ORDER_NO']][$row['DELIV_POLICY_NO']])){
//				$cnt_delivery[$row['ORDER_NO']][$row['DELIV_POLICY_NO']] = 0;
//			}
//			if($deli_no == $row['DELIV_POLICY_NO']){
//				$cnt_delivery[$row['ORDER_NO']][$row['DELIV_POLICY_NO']] ++;
//			}else{
//				$cnt_delivery[$row['ORDER_NO']][$row['DELIV_POLICY_NO']] = 1;
//			}
//			$order_no = $row['ORDER_NO'];
//			$deli_no = $row['DELIV_POLICY_NO'];
//		}
//		$data['cnt_order_refer'	] = $cnt_order_refer;
//		$data['cnt_delivery'	] = $cnt_delivery;
//
////		var_dump($cnt_delivery);
////		var_dump($cnt_order_refer);
//
        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'mywiz/order_page';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '5';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'		] = $this->pagination->create_links();
//		$data['reason_list'	] = $this->mywiz_m->get_cancel_return_reason();
////		$data['cancel_apply'] = $this->load->view('mywiz/cancel_apply.php', $data, TRUE); //취소신청
        $data['order'		] = $order;
        $data['title'		] = $param['title'];
//		$data['nav'			] = $param['nav'];
        $data['date_type'	] = $param['date_type'];
        $data['date_from'	] = $param['date_from'];
        $data['date_to'		] = $param['date_to'];


        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
        $data['footer_gb'] = 'mywiz';

        /* load model */
        $this->load->model('cart_m');
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        $this->load->view('include/header', $data);
//		$this->load->view('include/menu');
        $this->load->view('mywiz/order');
//		$this->load->view('include/bottom_menu');
        $this->load->view('include/footer', $data);

    }

    /**
     * 배송조회
     */
    public function layer_check_delivery_post()
    {
        $param = $this->input->post();
        $data = array();

        $deli = $this->mywiz_m->get_order_detail($param['order_no'], $param['order_refer_no']);
        $data['delivery'] = $deli[0];
        $delivery = $this->load->view('mywiz/check_delivery.php', $data, TRUE);		//배송조회

        $this->response(array('status' => 'ok', 'delivery'=>$delivery), 200);;
    }

    /**
     * 상품평작성 레이어 (쇼핑내역 > 주문/배송조회)
     */
    public function layer_reg_comment_get()
    {
        $param['goods_code'         ] = $this->input->get('goods_cd', true);
        $param['order_refer_code'   ] = $this->input->get('order_refer_no', true);
        $param['mem_no'             ] = $this->session->userdata('EMS_U_NO_');

        $data = array();

        $exists_comment = $this->mywiz_m->get_exists_comment_order($param);

        if($exists_comment['cnt'] == 1){	//이미 주문상세번호에 해당하는 상품평이 등록되어있다면 넘기기
            $this->response(array('status' => 'fail', 'message' => '이미 상품평을 입력하셨습니다.'), 200);
        } else {
            $data['goods'] = $this->mywiz_m->get_goods_info_write_comment($param['order_refer_code']);
            $comment = $this->load->view('mywiz/write_goods_comment.php', $data, TRUE);		//상품평작성

            $this->response(array('status' => 'ok', 'comment'=>$comment), 200);
        }
    }

    /**
     * 주문상세
     */
    public function order_detail_get()
    {
        $order_no = $this->uri->segment(3);

        $data = array();

        $order = $this->mywiz_m->get_order_detail($order_no);
//
        $data['order'		] = $order[0];
        $data['order_dtl'	] = $order;
//		$data['cancel_apply'] = $this->load->view('mywiz/cancel_apply.php', '', TRUE); //취소신청
        $data['state_cd'	] = array('OC21','OC22','OR21','OR22');				//취반품 환불완료코드

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
        $data['footer_gb'] = 'mywiz';

        /* load model */
        $this->load->model('cart_m');
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        $this->load->view('include/header', $data);
//		$this->load->view('include/menu');
        $this->load->view('mywiz/order_detail');
//		$this->load->view('include/bottom_menu');
        $this->load->view('include/footer', $data);

    }

    /**
     * 취소 신청
     */
    public function layer_cancel_post()
    {
        $param = $this->input->post();

        $data = array();

        $data['order'			] = $this->mywiz_m->get_order_refer_detail($param['order_refer_no']);
        $data['reason_list'		] = $this->mywiz_m->get_cancel_return_reason();

        $apply = $this->load->view('mywiz/apply_cancel.php', $data, TRUE);		//취소신청

        $this->response(array('status' => 'ok', 'apply'=>$apply), 200);;
    }

    /**
     * 반품 신청
     */
    public function layer_return_post()
    {
        $param = $this->input->post();

        $data = array();

        $data['order'			] = $this->mywiz_m->get_order_refer_detail($param['order_refer_no']);
        $data['reason_list'		] = $this->mywiz_m->get_cancel_return_reason();
        $data['deli_list'		] = $this->mywiz_m->get_delivery_company();
        $data['return_type'		] = $this->mywiz_m->get_return_collection_type();
        $data['return_pay_type'	] = $this->mywiz_m->get_return_pay_type();

        $apply = $this->load->view('mywiz/apply_return.php', $data, TRUE);		//반품신청

        $this->response(array('status' => 'ok', 'apply'=>$apply), 200);
    }

    /**
     * 반품신청
     */
    public function return_apply_post()
    {

        $param = $this->input->post();
//var_dumP($param);
        $this->mywiz_m->update_cancel_return_ues_yn($param);
        if(!$cancel_return_no = $this->mywiz_m->register_order_return($param))	$this->response(array('status' => 'error', 'message'=>'[에러] 취소신청이 실패되었습니다.'), 200);
        if(!$progress_no = $this->mywiz_m->register_order_refer_progress($param, $cancel_return_no))	$this->response(array('status' => 'error', 'message'=>'[에러] 취소신청이 실패되었습니다.'), 200);
        if(!$this->mywiz_m->update_order_refer($param, $progress_no))	$this->response(array('status' => 'error', 'message'=>'[에러] 취소신청이 실패되었습니다.'), 200);

        $this->response(array('status' => 'ok', 'return_no' => $cancel_return_no), 200);
    }


    /**
     * 반품신청 - 이미지첨부
     */
    public function return_apply_image_post()
    {
        $param = $this->input->post();

        $return_no = $param['return_no'];   //반품번호

        //첨부파일 확인
        if($_FILES['fileUpload']['name']){
            //첨부파일이 있을 때만 파일 업로드
            if(!empty(array_filter($_FILES['fileUpload']['name']))){
                $retUrl = array();

                $this->load->helper(array('form', 'url'));

                $image_path = '/webservice_root/etah_mfront/assets/uploads';

                if ( ! @is_dir($image_path)){
                    $this->response(array('status' => 'error upload fail_NO Directory'));
                }

                $config['upload_path'	] = $image_path;
                $config['allowed_types'	] = 'gif|jpg|jpeg|png';

                $this->load->library('upload', $config);


                //파일 압축해서 하나씩 업로드
                for($a=0;$a<count($_FILES['fileUpload']['tmp_name']);$a++) {
                    if($_FILES['fileUpload']['name'][$a] != '') {
                        if ($_FILES['fileUpload']['size'][$a] > 5500000) {
                            $this->response(array('status' => 'fail', 'message' => '파일 너무 큼'), 200);
                        }
                        else {
                            //0 (최저품질), 75 (기본품질값), 100(최고품질)
                            if ($_FILES['fileUpload']['size'][$a] < 5500000 && $_FILES['fileUpload']['size'][$a] > 2000000) { $quality = 50; }
                            else { $quality = 75; }


                            $file_name = $_FILES['fileUpload']['name'][$a];
                            $url = '/webservice_root/etah_mfront/assets/uploads/'.$file_name;


                            $info = getimagesize($_FILES['fileUpload']['tmp_name'][$a]);

                            if ($info['mime'] == 'image/jpeg')
                                $image = imagecreatefromjpeg($_FILES['fileUpload']['tmp_name'][$a]);

                            elseif ($info['mime'] == 'image/gif')
                                $image = imagecreatefromgif($_FILES['fileUpload']['tmp_name'][$a]);

                            elseif ($info['mime'] == 'image/png')
                                $image = imagecreatefrompng($_FILES['fileUpload']['tmp_name'][$a]);


                            //모바일에서 세로사진 업로드시 회전되어 나오는 문제
                            $exif = @exif_read_data($_FILES['fileUpload']['tmp_name'][$a]);

                            if(!empty($exif['Orientation'])) {
                                switch ($exif['Orientation']) {
                                    case 8: $image = imagerotate($image, 90, 0);    break;
                                    case 3: $image = imagerotate($image, 180, 0);   break;
                                    case 6: $image = imagerotate($image, -90, 0);   break;
                                    default: $image = imagerotate($image, 0, 0);   break;
                                }
                            }

                            imagejpeg($image, $url, $quality);


                            $rparam['file_name' ] = $_FILES['fileUpload']['name'][$a];
                            $rparam['file_ext'  ] = '.jpg';


                            $retTitle = self::_s3_upload_return($rparam, $return_no);

                            unlink($image_path.'/'.$file_name);

                            $this->mywiz_m->register_order_return_file_path($retTitle, $return_no);

                        }

                    }
                }
            }
        }

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * s3 파일전송 - 반품 첨부파일
     */
    public function _s3_upload_return($param, $return_no)
    {
        $cust_no = $this->session->userdata('EMS_U_NO_');
        $date = date("YmdHis", time());

        $title = $return_no.'_'.$date.'_'.$param['file_name'];

        //Load Library
        $this->load->library('s3');

        $input = S3::inputFile('/webservice_root/etah_mfront/assets/uploads/'.$param['file_name']);
        if (S3::putObject($input, 'image.etah.co.kr', 'cancel_return/'.$cust_no.'/'.$return_no.'/'.$title.$param['file_ext'], S3::ACL_PUBLIC_READ)) {
            $title = 'http://image.etah.co.kr/cancel_return/'.$cust_no.'/'.$return_no.'/'.$title.$param['file_ext'];
        }else{
            $title = "";
        }

        return $title;
    }

    /**
     * 취소신청
     */
    public function cancel_apply_post()
    {
        $param = $this->input->post();

        $this->mywiz_m->update_cancel_return_ues_yn($param);
        if(!$cancel_return_no = $this->mywiz_m->register_order_cancel($param))	$this->response(array('status' => 'error', 'message'=>'[에러] 취소신청이 실패되었습니다.'), 200);
        if(!$progress_no = $this->mywiz_m->register_order_refer_progress($param, $cancel_return_no))	$this->response(array('status' => 'error', 'message'=>'[에러] 취소신청이 실패되었습니다.'), 200);
        if(!$this->mywiz_m->update_order_refer($param, $progress_no))	$this->response(array('status' => 'error', 'message'=>'[에러] 취소신청이 실패되었습니다.'), 200);

        //sms 발송
        $order_info = $this->mywiz_m->get_Orderinfo($param);
//        log_message('DEBUG','==============='.$order_info);
        $pay = $order_info['SELLING_PRICE'] * $param['qty'];
//        log_message('DEBUG','==============='.$pay);
        $kakao['SMS_MSG_GB_CD'         ] = 'KAKAO';
        $kakao['KAKAO_TEMPLATE_CODE'] = 'bizp_2019101814040516788575364';
        $kakao['KAKAO_SENDER_KEY'] = '1682e1e3f3186879142950762915a4109f2d04a2';
        if($order_info['SENDER_MOB_NO'] != '') {
            $kakao['DEST_PHONE'] = str_replace('-', '', $order_info['SENDER_MOB_NO']);
        }else{
            $kakao['DEST_PHONE'] = str_replace('-', '', $order_info['RECEIVER_MOB_NO']);
        }
        $kakao['MSG'] ="[에타홈] 주문취소

주문이 취소되었습니다.
더 좋은상품을 제공해 드릴 수 있도록 노력하겠습니다!


▶상품명:".$order_info['GOODS_NM']."
▶주문번호:".$order_info['ORDER_NO']."
▶취소금액:".$order_info['REAL_PAY_AMT']."
http://www.etah.co.kr/mywiz/order_detail/".$order_info['ORDER_NO']."

※ 환불은 시스템에따라 영업시간을 기준으로 2~3일 정도 소요됩니다.";
//        $kakao['KAKAO_ATTACHED_FILE'] = null;
//        log_message('DEBUG','===========kakao msg'.$kakao['MSG']);
//        log_message('DEBUG','===========kakao msg'.$kakao['KAKAO_TEMPLATE_CODE']);
//        log_message('DEBUG','===========kakao msg'.$kakao['KAKAO_SENDER_KEY']);
//        log_message('DEBUG','===========kakao msg'.$kakao['DEST_PHONE']);
//        log_message('DEBUG','===========kakao msg'.$kakao['KAKAO_ATTACHED_FILE']);
        $sendSMS = $this->mywiz_m->send_sms_kakao($kakao);

        $this->response(array('status' => 'ok'), 200);
    }

    /**
     * SNS연동
     */
    public function sns_get()
    {
        $data['nav'			] = "ML";
        $data['cancel_apply'] = "";

        $data = array();

        $info    = $this->mywiz_m->get_member_info_by_cust_no();	//회원정보
        $snsinfo = $this->mywiz_m->get_snsdata();
        $info['arr_email'] = explode('@',$info['EMAIL']);
        $info['arr_phone'] = explode('-',$info['MOB_NO']);

        if(empty($info['arr_phone'][1]) && empty($info['arr_phone'][2])){
            $info['arr_phone'][1] = "";
            $info['arr_phone'][2] = "";
        }

        $data['info'		] = $info;
        $data['sns_data'    ] = $snsinfo['SNS_KIND_CD'];
        $data['nav'			] = "MS";

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
        $data['footer_gb'] = 'mywiz';

        /* load model */
        $this->load->model('cart_m');
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        $this->load->view('include/header', $data);
        $this->load->view('mywiz/mywiz_sns');
        $this->load->view('include/footer');

    }

    /**
     * s3 파일전송
     */
    public function _s3_upload($param, $goods_comment_no)
    {
        $cust_no = $this->session->userdata('EMS_U_NO_');
        $date = date("YmdHis", time());

        $title = $cust_no.$date.$param['file_name'];

        //Load Library
        $this->load->library('s3');

        $input = S3::inputFile('/webservice_root/etah_mfront/assets/uploads/'.$param['file_name']);
        if (S3::putObject($input, 'image.etah.co.kr', 'cust_goods_comment/'.$cust_no.'/'.$title, S3::ACL_PUBLIC_READ)) {

            $title = 'http://image.etah.co.kr/cust_goods_comment/'.$cust_no.'/'.$title;
//            $this->mywiz_m->update_goods_comment_file_path($title, $goods_comment_no);
        }else{
            $title = "";
        }

        return $title;
    }
}

?>