<?php
/**
 * User:
 * Date: 2016/12/12
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller
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

		//2020-09-28 김설 팀장 요청 에타 홈 으로 모바일에서 검색 했을때 고객센터를 클릭하면 페이지를 찾을수 없다고 나와서 백엔드 쪽에서 강제로 페이지 이동
        $HOST = $_SERVER['HTTP_HOST'];
        $PHP_SELF = $_SERVER['PHP_SELF'];
        if($HOST == 'stagingm.etahome.co.kr' || $HOST == 'm.etahome.co.kr'){
            if($PHP_SELF == "/index.php/customer/"){
                echo "<script>document.location.href='https://m.etahome.co.kr/customer/faq';</script>";
            }
        }

		/* model_m */
		$this->load->model('customer_m');
		$this->load->model('cart_m');
	}

	/**
	 * FAQ
	 */
	public function faq_get()
	{
		$data = array();
		$data['keyword'	] = "";
		$data['plus_yn'	] = "N";
		$data['type'	] = $this->uri->segment(3);

		//FAQ ����Ʈ
		self::_faq_list($data);

	}

	/**
	 * FAQ ������
	 */
	public function faq_page_get($page = 1)
	{
		$get_vars = $this->input->get();
		$get_vars['page'] = $page;

		//FAQ ����Ʈ
		self::_faq_list($get_vars);
	}

	/**
	 * FAQ ����Ʈ
	 */
	public function _faq_list($param)
	{
		$data = array();

		$param['limit_num_rows'	] = 5;

		$totalCnt = $this->customer_m->get_faq_list_count($param);

		if(empty($param['page'])){
			$param['page'] = 1;
		}
		if($totalCnt != 0){
			$totalPage = ceil($totalCnt / $param['limit_num_rows']);
		}

		$faq = $this->customer_m->get_faq_list($param);


		//�������׺���̼�
		$this->load->library('pagination');
		$config['base_url'		] = base_url().'customer/faq_page';
		$config['uri_segment'	] = '3';
		$config['total_rows'	] = $totalCnt;
		$config['per_page'		] = $param['limit_num_rows'];
		$config['num_links'		] = '5';
		$config['suffix'		] = '?'.http_build_query($param, '&');
		$this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
		$data['faq'			] = $faq;
		$data['total_cnt'	] = $totalCnt;
		$data['page'		] = $param['page'];
		$data['sNum'		] = $param['limit_num_rows'	];
		$data['keyword'		] = $param['keyword'];
		$data['type'		] = $param['type'];
		$data['active'		] = "faq";
		$data['plus_yn'		] = $param['plus_yn'];

		/**
		 * ��� ī�װ� ����Ÿ
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];
		$data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//��ٱ��� ���� ��������
		$data['header_gb'] = 'none';		//����� �˻��ٸ� ���̵��� �ϱ�
		$data['footer_gb'] = 'customer';

		$this->load->view('include/header', $data);
//		$this->load->view('include/menu');
		$this->load->view('customer/faq');
//		$this->load->view('include/bottom_menu');
		$this->load->view('include/footer', $data);

	}

	/**
	 * 1:1�����ϱ�
	 */
	public function register_qna_get()
	{
		$data = array();

//		phpinfo();

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

		$data['keyword'		] = "";
		$data['type'		] = "";
		$data['qna_type'	] = $this->customer_m->get_qna_type_list();
		$data['order'		] = $this->customer_m->get_order_list_by_customer($param);
		$data['total_cnt'	] = $totalCnt;
		$data['total_page'	] = $totalPage;
		$data['active'		] = "qna";

		/**
		 * ��� ī�װ� ����Ÿ
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];
		$data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//��ٱ��� ���� ��������
		$data['header_gb'] = 'none';	//����� �˻��ٸ� ���̵��� �ϱ�

		$this->load->view('include/header', $data);
//		$this->load->view('include/menu');
		$this->load->view('customer/register_qna');
//		$this->load->view('include/bottom_menu');
		$this->load->view('include/footer');
	}

	/**
	 * 1:1�����ϱ� �ֹ����� ����¡
	 */
	public function order_page_post()
	{
		$param = $this->input->post();

		$param['limit_num_rows'	] = 5;

		$order = $this->customer_m->get_order_list_by_customer($param);


		$this->response(array('status'=>'ok', 'order'=>$order), 200);
	}

	/**
	 * 1:1���ǵ��
	 */
	public function register_qna_post()
	{
		$param = $this->input->post();

//		var_dump($param);
//		var_dump($_FILES);

		$cust_id = $this->session->userdata('EMS_U_ID_');
		$cust_no = $this->session->userdata('EMS_U_NO_');

		if(($cust_id == 'GUEST') || ($cust_id == '')) $cust_no = "guest";

		$param = str_replace("\n", '<br>', $param);
		$param = str_replace("'","\'",$param);

		$param['qna_no'] = $this->customer_m->register_qna($param);

		$this->customer_m->register_qna_contents($param);

		if($param['order_refer_no']) $this->customer_m->register_map_cs_n_order_refer($param);

		//÷������ Ȯ��
		if($_FILES['fileUpload']['name']){

			$this->load->helper(array('form', 'url'));

			$image_path = '/webservice_root/etah_mfront/assets/uploads';

			if ( ! @is_dir($image_path)){
				$this->response(array('status' => 'error upload fail_qna_NO Directory'));
			}

			$config['upload_path'	] = $image_path;
			$config['allowed_types'	] = 'gif|jpg|jpeg';
			$config['encrypt_name'	] = preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $_FILES['fileUpload']['name']);

			$this->load->library('upload', $config);

			if ( !$this->upload->do_upload('fileUpload')){ //���ε� ������
				$error = array('error' => $this->upload->display_errors());
				$this->response(array('status' => 'error upload fail_qna', 'param' => $param, 'data' => $error, 'size' => $_FILES['fileUpload']['size']));
			}else{
				$data = $this->upload->data();

				$date = date("YmdHis", time());
				$title = $param['qna_no']."_".$date;
				$kind = 'cs';

				//Load Library
				$this->load->library('s3');

				$input = S3::inputFile('/webservice_root/etah_mfront/assets/uploads/'.$data['file_name']);
				if (S3::putObject($input, 'image.etah.co.kr', $kind.'/'.$cust_no.'/'.$title.$data['file_ext'], S3::ACL_PUBLIC_READ)) {
		//			echo "File uploaded.";
					$title = 'http://image.etah.co.kr/'.$kind.'/'.$cust_no.'/'.$title.$data['file_ext'];
					if($kind == 'cs'){
						$this->customer_m->update_cs_qna_file_path($title, $param['qna_no']);
					}
					//���� �� ���� ����
					unlink($data['full_path']);
				}else{
		//			echo "Failed to upload file.";
				}
			}
		}
//		var_dump($data);
//		var_dump($title);

		if($cust_no ==  "guest"){ //��ȸ��
			//1:1���� ���� �̸��� ���� �߼�
			$mailParam["kind"		] = "qna";
			$mailParam["title"		] = $param['title'];
			$mailParam["content"	] = $param['content'];
			$mailParam["name"		] = $param['name'];
			$mailParam["type"		] = $param['type'];
			$mailParam["phone"		] = $param['phone'];
			$mailParam["email"		] = $param['email'];
			$mailParam["date"		] = date("Y�� m�� d��", time());
//					var_dump($mailParam);
			self::_background_send_mail($mailParam);
		}

		$this->response(array('status'=>'ok'));
	}


	/**
	 * 1:1���� ����
	 */
	public function modify_qna_post()
	{
		$param = $this->input->post();
//		var_dump($_FILES);
//		var_dump($param);
		$cust_no = $this->session->userdata('EMS_U_NO_');

		$param = str_replace("\n", '<br>', $param);
		$param = str_replace("'","\'",$param);

		$this->customer_m->update_qna($param);
		$this->customer_m->update_qna_content($param);
		if($param['order_refer_no']) $this->customer_m->update_map_cs_n_order_refer($param);

		//÷������ Ȯ��
		if($_FILES['fileUpload']['name']){

			$this->load->helper(array('form', 'url'));

			$image_path = '/webservice_root/etah_mfront/assets/uploads';

			if ( ! @is_dir($image_path)){
				$this->response(array('status' => 'error upload fail_qna_NO Directory'));
			}

			$config['upload_path'	] = $image_path;
			$config['allowed_types'	] = 'gif|jpg|jpeg';
			$config['encrypt_name'	] = preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $_FILES['fileUpload']['name']);

			$this->load->library('upload', $config);

			if ( !$this->upload->do_upload('fileUpload')){ //���ε� ������
				$error = array('error' => $this->upload->display_errors());
				$this->response(array('status' => 'error upload fail_qna', 'param' => $param, 'data' => $error, 'size' => $_FILES['fileUpload']['size']));
			}else{
				$data = $this->upload->data();

				$date = date("YmdHis", time());
				$title = $param['qna_no']."_".$date;
				$kind = 'cs';

				//Load Library
				$this->load->library('s3');

				$input = S3::inputFile('/webservice_root/etah_mfront/assets/uploads/'.$data['file_name']);
				if (S3::putObject($input, 'image.etah.co.kr', $kind.'/'.$cust_no.'/'.$title.$data['file_ext'], S3::ACL_PUBLIC_READ)) {
		//			echo "File uploaded.";
					$title = 'http://image.etah.co.kr/'.$kind.'/'.$cust_no.'/'.$title.$data['file_ext'];
					if($kind == 'cs'){
						$this->customer_m->update_cs_qna_file_path($title, $param['qna_no']);
					}
					//���� �� ���� ����
					unlink($data['full_path']);
				}else{
		//			echo "Failed to upload file.";
				}
			}
		}

		$this->response(array('status' => 'ok'), 200);
	}


	/**
	 * s3 ��������
	 */
	public function _s3_upload($param, $kind, $kind_no)
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');
		$date = date("YmdHis", time());

		$title = $kind_no."_".$date;

		//Load Library
		$this->load->library('s3');

		$input = S3::inputFile('/webservice_root/etah_front/assets/uploads/'.$param['file_name']);
		if (S3::putObject($input, 'image.etah.co.kr', $kind.'/'.$cust_no.'/'.$title.$param['file_ext'], S3::ACL_PUBLIC_READ)) {
//			echo "File uploaded.";

			$title = 'http://image.etah.co.kr/'.$kind.'/'.$cust_no.'/'.$title.$param['file_ext'];
			if($kind == 'cs'){
				$this->customer_m->update_cs_qna_file_path($title, $kind_no);
			}
		}else{
//			echo "Failed to upload file.";
		}

		return;

	}

	/**
	 * ��������
	 */
	public function notice_get()
	{
		$data = array();

		//�������� ����Ʈ
		self::_notice_list($data);
	}

	/**
	 * �������� ������
	 */
	public function notice_page_get($page = 1)
	{
		$get_vars = $this->input->get();
		$get_vars['page'	 ] = $page;

		//�������� ����Ʈ
		self::_notice_list($get_vars);
	}

	/**
	 * �������� ����Ʈ
	 */
	public function _notice_list($param)
	{
		$param['limit_num_rows'	] = 7;
		$param['page'			] = empty($param['page'				]) ? 1  : $param['page'			];

		 //�������� ����
		$totalCnt = $this->customer_m->get_notice_list_count($param);

		if($totalCnt != 0){
			$totalPage = ceil($totalCnt / $param['limit_num_rows']);
		}

		//�������׺���̼�
		$this->load->library('pagination');
		$config['base_url'		] = base_url().'customer/notice_page';
		$config['uri_segment'	] = '3';
		$config['total_rows'	] = $totalCnt;
		$config['per_page'		] = $param['limit_num_rows'];
		$config['num_links'		] = '10';
		$config['suffix'		] = '?'.http_build_query($param, '&');
		$this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
		$data['notice'		] = $this->customer_m->get_notice_list($param);
		$data['total_cnt'	] = $totalCnt;
		$data['page'		] = $param['page'];
		$data['sNum'		] = $param['limit_num_rows'	];
		$data['keyword'		] = "";
		$data['type'		] = "";

		/**
		 * ��� ī�װ� ����Ÿ
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];
		$data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//��ٱ��� ���� ��������
		$data['header_gb'] = 'none';

		$this->load->view('include/header', $data);
//		$this->load->view('include/menu');
		$this->load->view('customer/notice_list');
//		$this->load->view('include/bottom_menu');
		$this->load->view('include/footer');
	}


	/**
	 * �������� ��������
	 */
	public function notice_detail_get()
	{
		$notice_no = $this->uri->segment(3);

		$data['detail'] = $this->customer_m->get_notice_detail($notice_no);


		/**
		 * ��� ī�װ� ����Ÿ
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];
		$data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//��ٱ��� ���� ��������
		$data['header_gb'] = 'none';

		$this->load->view('include/header', $data);
//		$this->load->view('include/menu');
		$this->load->view('customer/notice_detail');
//		$this->load->view('include/bottom_menu');
		$this->load->view('include/footer');
	}


	/**
	 * ���� �ۼ�
	 */
	private function _background_send_mail($param)
	{
		set_time_limit(0);

		$this->load->helper('url');
		$url = site_url("/customer/background_send_mail");

		$type = "POST";

		foreach ($param as $key => &$val) {
			if (is_array($val)) $val = implode(',', $val);
			$post_params[] = $key.'='.urlencode($val);
		}

		$post_string = implode('&', $post_params);

		$parts=parse_url($url);

		if ($parts['scheme'] == 'http') {
			$fp = fsockopen($parts['host'], isset($parts['port'])?$parts['port']:80, $errno, $errstr, 30);
		}
		else if ($parts['scheme'] == 'https') {
			$fp = fsockopen("ssl://" . $parts['host'], isset($parts['port'])?$parts['port']:443, $errno, $errstr, 30);
		}

		// Data goes in the path for a GET request
		if('GET' == $type) $parts['path'] .= '?'.$post_string;

		$out = "$type ".$parts['path']." HTTP/1.1\r\n";
		$out.= "Host: ".$parts['host']."\r\n";
		$out.= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out.= "Content-Length: ".strlen($post_string)."\r\n";
		$out.= "Connection: Close\r\n\r\n";

		// Data goes in the request body for a POST request
		if ('POST' == $type && isset($post_string)) $out.= $post_string;

		fwrite($fp, $out);
		fclose($fp);

	}

	public function background_send_mail_post()
	{
		set_time_limit(0);

        $param = $this->post();

		$this->load->helper('string');
		$this->load->library('email');

		$body = self::_mail_template($param['kind']); //���� ���ø� ��������

		//1:1���� ���� �߼�
        if($param['kind'] == "qna"){
            $subject = "[ETAHOME] ������ 1:1���ǰ� ���������� ��ϵǾ����ϴ�.";

			$body = str_replace("{{type}}"		, $param['type'	  ]	  , $body);
            $body = str_replace("{{name}}"		, $param['name'	  ]   , $body);
            $body = str_replace("{{phone}}"		, $param['phone'  ]   , $body);
			$body = str_replace("{{title}}"		, $param['title'  ]   , $body);
			$body = str_replace("{{content}}"	, $param['content']   , $body);
			$body = str_replace("{{date}}"		, $param['date'   ]   , $body);
            $body = str_replace("{{homepage}}"  , config_item('url')  , $body);
        }

        $receive = $param['email'];

		$this->email->sendmail($receive, $subject, $body, 'info@etah.co.kr', 'ETA HOME');
	}

	/**
	 * ���� ���ø� ��������
	 */
	private function _mail_template($type = 'join')
	{
		$body = $this->load->view('template/email/'.$type.'/email_body.php', '', TRUE);

		return $body;
	}

	public function test_email_get()
	{
		$this->load->view('template/email/qna/email_body');

	}

	/**
	 * ���ǿϷ�
	 */
	public function finish_qna_get()
	{
		$data = array();


		/**
		 * ��� ī�װ� ����Ÿ
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];
		$data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//��ٱ��� ���� ��������
		$data['header_gb'] = 'none';

		$this->load->view('include/header', $data);
//		$this->load->view('include/menu');
		$this->load->view('customer/finish_qna');
//		$this->load->view('include/bottom_menu');
		$this->load->view('include/footer');

	}

    /**
     * 문의 게시판
     * 2018.10.24
     */
    //문의 리스트
    public function qna_list_all_get($page = 1)
    {
        $get_vars = $this->input->get();
        $get_vars['page'	 ] = $page;

//        var_dump($get_vars);
        //1:1문의 리스트 조회
        self::_qna_list_all($get_vars);
    }

    public function _qna_list_all($param)
    {
        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 7 : $param['limit_num_rows'];
        $param['page'			] = empty($param['page'				]) ? 1  : $param['page'			];

        //공지사항 개수
        $totalCnt = $this->customer_m->get_qna_list_count($param);
        $qna_list = $this->customer_m->get_qna_list($param);


        if($totalCnt != 0){
            $totalPage = ceil($totalCnt / $param['limit_num_rows']);
        }

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'customer/qna_list_all';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '10';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
        $data['qna_list'	] = $qna_list;
        $data['total_cnt'	] = $totalCnt;
        $data['page'		] = $param['page'];
        $data['sNum'		] = $param['limit_num_rows'];

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));
        $data['header_gb'] = 'none';

        $this->load->view('include/header', $data);
        $this->load->view('customer/qna_list');
        $this->load->view('include/footer');
    }

    //문의 상세보기
    public function qna_detail_get()
    {
        $qna_no = $this->uri->segment(3);

        $data['qna'] = $this->customer_m->get_qna_detail($qna_no);


        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));
        $data['header_gb'] = 'none';

        $this->load->view('include/header', $data);
        $this->load->view('customer/qna_detail');
        $this->load->view('include/footer');
    }

}