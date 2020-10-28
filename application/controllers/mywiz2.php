<?php
/**
 * User:
 * Date: 2016/12/20
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Mywiz2 extends MY_Controller
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
		$this->load->model('mywiz2_m');

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

		$data['mycoupon_cnt'		] = $this->mywiz2_m->get_coupon_count_by_cust();	//보유쿠폰 갯수 가져오기
		$data['mileage'				] = $this->mywiz2_m->get_mileage_by_cust();			//보유 마일리지 가져오기
		$data['order_state'			] = $this->mywiz2_m->get_order_state_by_cust_no();	//주문상태 갯수
		$data['order_state1'		] = $this->mywiz2_m->get_order_state_by_cust_no_limit1();	//주문상태 limit 1

		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];
		$data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
		$data['footer_gb'] = 'mywiz';

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
			}
		}
		$data['coupon'		] = $this->mywiz2_m->get_coupon_count_by_cust();	//쿠폰개수
		$data['mileage'		] = $this->mywiz2_m->get_mileage_by_cust();			//잔여 마일리지
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

		$info = $this->mywiz2_m->get_member_info_by_cust_no();	//회원정보
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
//var_dump($param);
		if(!$this->mywiz2_m->update_member_info($param)){
			$this->response(array('status' => 'error', 'message'=>'잠시 후에 다시 시도하여 주시기 바랍니다.'), 200);
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

		$totalCnt = $this->mywiz2_m->get_delivery_list_count($param);

		if(empty($param['page'])){
			$param['page'] = 1;
		}
		if($totalCnt != 0){
			$totalPage = ceil($totalCnt / $param['limit_num_rows']);
		}

		$delivery = $this->mywiz2_m->get_delivery_list($param);					//배송지

		$idx=0;
		foreach($delivery as $row){
			$delivery[$idx]['arr_mob'] =  explode('-',$row['MOB_NO']);
			$idx++;
		}

//		var_dump($delivery);

		//페이지네비게이션
		$this->load->library('pagination');
		$config['base_url'		] = base_url().'mywiz2/delivery_page';
		$config['uri_segment'	] = '3';
		$config['total_rows'	] = $totalCnt;
		$config['per_page'		] = $param['limit_num_rows'];
		$config['num_links'		] = '10';
		$config['suffix'		] = '?'.http_build_query($param, '&');
		$this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
		$data['delivery'	] = $delivery;
		$data['coupon'		] = $this->mywiz2_m->get_coupon_count_by_cust();		//쿠폰개수
		$data['mileage'		] = $this->mywiz2_m->get_mileage_by_cust();			//잔여 마일리
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

		$this->mywiz2_m->register_delivery($param);

//		var_dump($param);
		$this->response(array('status' => 'ok'), 200);
	}

	/**
	 * 배송지수정
	 */
	public function update_delivery_post()
	{
		$param = $this->input->post();

		$this->mywiz2_m->update_delivery($param);

//		var_dump($param);
		$this->response(array('status' => 'ok'), 200);
	}

	/**
	 * 배송지삭제
	 */
	public function delete_delivery_post()
	{
		$param = $this->input->post();

		if(!$this->mywiz2_m->delete_delivery($param['deliv_no'])){
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

		if(!$this->mywiz2_m->update_base_delivery('N')){
			$this->response(array('status' => 'error', 'message' => '잠시 후에 다시 시도하여주시기 바랍니다.'), 200);
		}else{
			if(!$this->mywiz2_m->update_base_delivery('Y',$param['deliv_no'])){
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
		$param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 40   : $param['limit_num_rows'];

		$this->load->model('quick_m');
		$data['view_cnt']	= $this->quick_m->get_view_goods_count();
		$data['view']		= $this->quick_m->get_view_goods($page);

		//페이지네비게이션
		$this->load->library('pagination');
		$config['base_url'		] = base_url().'mywiz2/view_goods';
		$config['uri_segment'	] = '3';
		$config['total_rows'	] = $data['view_cnt'];
		$config['per_page'		] = $param['limit_num_rows'];
		$config['num_links'		] = '10';
		$config['suffix'		] = '?'.http_build_query($param, '&');
		$this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();

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

		$totalCnt = $this->mywiz2_m->get_interest_list_count();

		if($totalCnt != 0){
			$totalPage = ceil($totalCnt / $param['limit_num_rows']);
		}
		$wish_list = $this->mywiz2_m->get_interest_list($param);

		//페이지네비게이션
		$this->load->library('pagination');
		$config['base_url'		] = base_url().'mywiz2/interest';
		$config['uri_segment'	] = '3';
		$config['total_rows'	] = $totalCnt;
		$config['per_page'		] = $param['limit_num_rows'];
		$config['num_links'		] = '10';
		$config['suffix'		] = '?'.http_build_query($param, '&');
		$this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();

		$data['totalCnt'	] = $totalCnt;
		$data['wish_list'	] = $wish_list;


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

		if(!$this->mywiz2_m->update_interest($param,'N')) $this->response(array('status' => 'error'), 200);

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
			if(!$this->mywiz2_m->update_interest($param,'N')) $this->response(array('status' => 'error'), 200);
		}

		$this->response(array('status' => 'ok'), 200);
	}

}

?>