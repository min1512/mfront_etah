<?php
/**
 * User: 
 * Date: 2016/12/12
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer2 extends MY_Controller
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
		$this->load->model('customer2_m');
	}

	/**
	 * 공지사항
	 */
	public function notice_get()
	{
		$data = array();

		//공지사항 리스트
		self::_notice_list($data);
	}

	/**
	 * 공지사항 페이지
	 */
	public function notice_page_get($page = 1)
	{
		$get_vars = $this->input->get();
		$get_vars['page'	 ] = $page;

		//공지사항 리스트
		self::_notice_list($get_vars);
	}

	/**
	 * 공지사항 리스트
	 */
	public function _notice_list($param)
	{
		$param['limit_num_rows'	] = 7;
		$param['page'			] = empty($param['page'				]) ? 1  : $param['page'			];

		 //공지사항 개수
		$totalCnt = $this->customer2_m->get_notice_list_count($param);

		if($totalCnt != 0){
			$totalPage = ceil($totalCnt / $param['limit_num_rows']);
		}

		//페이지네비게이션
		$this->load->library('pagination');
		$config['base_url'		] = base_url().'customer2/notice_page';
		$config['uri_segment'	] = '3';
		$config['total_rows'	] = $totalCnt;
		$config['per_page'		] = $param['limit_num_rows'];
		$config['num_links'		] = '10';
		$config['suffix'		] = '?'.http_build_query($param, '&');
		$this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
		$data['notice'		] = $this->customer2_m->get_notice_list($param);
		$data['total_cnt'	] = $totalCnt;
		$data['page'		] = $param['page'];
		$data['sNum'		] = $param['limit_num_rows'	];
		$data['keyword'		] = "";
		$data['type'		] = "";

		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];
		$data['header_gb'] = 'none';

		$this->load->view('include/header', $data);
//		$this->load->view('include/menu');
		$this->load->view('customer/notice_list');
		$this->load->view('include/bottom_menu');
		$this->load->view('include/footer');
	}


	/**
	 * 공지사항 상세페이지
	 */
	public function notice_detail_get()
	{
		$notice_no = $this->uri->segment(3);

		$data['detail'] = $this->customer2_m->get_notice_detail($notice_no);


		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];
		$data['header_gb'] = 'none';

		$this->load->view('include/header', $data);
//		$this->load->view('include/menu');
		$this->load->view('customer/notice_detail');
		$this->load->view('include/bottom_menu');
		$this->load->view('include/footer');
	}


}