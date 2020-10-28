<?php
/**
 * @property member_m $member_m
 * Created by PhpStorm.
 * User: 박상현
 * Date:
 */
class Member extends MY_Controller
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
		$this->load->model('cart_m');
	}

	/** 상품상세 -> 비회원 로그인 페이지로 이동시 변수 이동 **/
	public function Guestlogin_post()
	{
		$param = $this->input->post();
        //log_message("DEBUG", "=============Guestlogin_post".$this->session->userdata('EMS_U_ID_'));
		self::login_get($param);
	}

	/**
	 * 로그인
	 */
	 public function login_get()
	{
		//비회원 로그인 경우 파라미터 가져옴
		$param = $this->input->post();
        //log_message("DEBUG", "=============login_get".$this->session->userdata('EMS_U_ID_'));
		//로그인 상태에서는 로그인 페이지 접근 불가
		//GUEST : 주문번호로 로그인 한 비회원
		//TMP_GUEST : 장바구니에 상품을 담은 비회원
		if($this->session->userdata('EMS_U_ID_') != 'GUEST' && $this->session->userdata('EMS_U_ID_') != 'TMP_GUEST' && $this->session->userdata('EMS_U_ID_')){

		    if(isset($_GET['return_url'])){
				//log_message("DEBUG", "=============2222".$_GET['return_url']);
			    redirect($_GET['return_url'], 'refresh');
			} else{
				redirect('/', 'refresh');
                //log_message("DEBUG", "=============1111");
			}
		}

		if($this->session->userdata('EMS_U_NO_')){
			$data['tmp_no'] = $this->session->userdata('EMS_U_NO_');
		} else {
			$data['tmp_no'] = '';
		}

        $returnUrl = ($this->agent->is_referral()) ? $this->agent->referrer() : '/';
        if(preg_match('/member\/login/i', $returnUrl) || preg_match('/member\/member_join_sns/i', $returnUrl)
            || preg_match('/member\/Guestlogin/i', $returnUrl)|| preg_match('/member\/join_finish/i', $returnUrl)) {
            $returnUrl = '/';
        }

        if(strpos($returnUrl,'join_finish')){
            $returnUrl	= '/';
        }

        if(strpos($returnUrl,'OrderInfo')){
            $returnUrl	= '/';
        }

        if(isset($_GET['return_url'])){
            $returnUrl = $_GET['return_url'];
        }

        $data['returnUrl'] = $returnUrl;

		if(isset($param)){
            $data['param'				] = $param;
            $data['guest_gb'			] = $param['guest_gb'];

            //상품상세페이지 바로구매
            if(!isset($param['order_gb'])) {
                for($i=0; $i<count($param['goods_option_code']); $i++){
                    $data['goods_code'				][$i] = $param['goods_code'];
                    $data['goods_cnt'				][$i] = $param['goods_cnt'][$i];
                    $data['goods_option_code'		][$i] = $param['goods_option_code'][$i];
                    $data['goods_option_name'		][$i] = $param['goods_option_name'][$i];
                    $data['goods_option_add_price'	][$i] = $param['goods_option_add_price'][$i];
                }
            }
		}

        /**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];
		$data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
		$data['header_gb'] = 'none';

		/**
		 * 퀵 레이아웃
		 */
//		$this->load->library('quick_lib');
//		$data['quick'] =  $this->quick_lib->get_quick_layer();

		$this->load->view('include/header', $data);
//		$this->load->view('include/menu');
		$this->load->view('member/member_login', $data);
		$this->load->view('include/footer');
	}

	/**
	 * 회원 로그인 세션 모듈
	 */
	 public function login_post()
	{
		 $param = $this->input->post();

		 $param = str_replace("\\","\\\\",$param);
		 $param = str_replace("'","\'",$param);
		 $param = str_replace("\n","<br />",$param);

		 $mem_id = strtolower($param['mem_id']);
		 $mem_pwd = $param['mem_password'];

		 //Load MODEL
		 $this->load->model('member_m');
		 $this->load->model('cart_m');

		 //회원 정보 구하기
		 if($param['login_gb'] == 'id'){
			 $Member = $this->member_m->get_member_info_pw1($mem_id, $mem_pwd);
			 if( empty($Member) ) $this->response(array('status'=>'error', 'message'=>'아이디나 비밀번호를 다시 확인해주세요.'), 200);
		 } else if($param['login_gb'] == 'email'){
			 $Member = $this->member_m->get_member_info_pw2($mem_id, $mem_pwd);
			 if( empty($Member) ) $this->response(array('status'=>'error', 'message'=>'아이디나 비밀번호를 다시 확인해주세요.'), 200);
		 }

		 //로그인 세션 만들기
		 $this->load->library('encrypt');

		 $dummy = date("d").$mem_id.date("y").$this->input->server('REMOTE_ADDR');
		 $sess_data = array(
             'EMS_U_NO_'		=>	$Member['CUST_NO'],
             'EMS_U_ID_'		=>	$Member['CUST_ID'],
             'EMS_U_PWD_'		=>	$this->encrypt->aes_encrypt($mem_pwd),
             'EMS_U_PWD2_'		=>	'',
             'EMS_U_GRADE_'		=>	$this->encrypt->aes_encrypt($Member['CUST_LEVEL_CD']),
             'EMS_U_DUMMY_'		=>	md5($dummy),
             'EMS_U_IP_'		=>	$this->input->server('REMOTE_ADDR'),
             'EMS_U_TIME_'		=>	time(),
             'EMS_U_NAME_'		=>	$Member['CUST_NM'],
             'EMS_U_EMAIL_'		=>	$Member['EMAIL'],
             'EMS_U_MOB_'		=>	$Member['MOB_NO'],
             'EMS_U_SNS'        =>  $Member['SNS_YN'],
             'EMS_U_SITE_ID_'	=>	'ETAH'
		 );
		 $this->session->set_userdata($sess_data);

		 $AccessLog = $this->member_m->regist_login_log($Member);

		 if($param['tmp_no'] != ''){	//비회원으로 로그인해서 장바구니를 사용했을 경우
			$tmp_cart = $this->cart_m->get_cart_goods($param['tmp_no']);

			if(count($tmp_cart) > 0){
				foreach($tmp_cart as $row){
					$cart['cust_no'				] = $Member['CUST_NO'];
					$cart['goods_code'			] = $row['GOODS_CD'];
					$cart['goods_option_code'	] = $row['GOODS_OPTION_CD'];
					$cart['goods_cnt'			] = $row['GOODS_CNT'];

					$CHKCart = $this->cart_m->chk_cart($cart);

					if($CHKCart){
						$cart['cart_no'	] = $CHKCart['CART_NO'];
						$cart['cnt'		] = $CHKCart['CART_QTY'] + $cart['goods_cnt'];
						$cart['gb'		] = 'CNT';

						$UpdCart = $this->cart_m->upd_cart($cart);
					} else {
						$AddCart = $this->cart_m->add_cart($cart);		//장바구니에 담기
					}
				}	//END foreach
			}	//END if

		 }	//END if

		 $this->response(array('status' => 'ok', 'mem_id' => $mem_id), 200);
	}

	/**
	 * 비회원 로그인 세션 모듈
	 */
	 public function guest_login_post()
	{
		 $param = $this->input->post();
		 $mem_id = 'GUEST';

		 //Load MODEL
		 $this->load->model('member_m');

		 //비회원 로그인이 가능한지 여부 확인
		 $Exists_guest = $this->member_m->check_guest_login($param);

		 if(!$Exists_guest){
			 $this->response(array('status' => 'error', 'message' => '해당하는 정보가 없습니다.'), 200);
		 }

		 //로그인 세션 만들기
		 $this->load->library('encrypt');

		 $dummy = date("d").$mem_id.date("y").$this->input->server('REMOTE_ADDR');
		 $sess_data = array(
			'EMS_U_NO_'			=>	$param['order_no'],
			'EMS_U_ID_'			=>	$mem_id,
			'EMS_U_PWD_'		=>	'',
			'EMS_U_PWD2_'		=>	'',
			'EMS_U_GRADE_'		=>	'',
			'EMS_U_DUMMY_'		=>	md5($dummy),
			'EMS_U_IP_'			=>	$this->input->server('REMOTE_ADDR'),
			'EMS_U_TIME_'		=>	time(),
			'EMS_U_NAME_'		=>	$param['order_name'],
			'EMS_U_EMAIL_'		=>	'',
			'EMS_U_SITE_ID_'	=>	'ETAH'
		 );
		 $this->session->set_userdata($sess_data);

//		 $AccessLog = $this->member_m->regist_login_log($Member);

		 $this->response(array('status' => 'ok', 'mem_id' => $mem_id), 200);
	}

	/**
	 * 로그아웃 모듈
	 */
	 public function logout_get()
	{
		$this->session->sess_destroy();
		redirect('/', 'refresh');
	}

	/**
	 * 회원가입
	 */
	 public function member_join_get()
	{
		//비회원 로그인시 세션 날리기
//		if($this->session->userdata('EMS_U_ID_') == 'GUEST'){
//			$this->session->sess_destroy();
//		}

		//로그인 상태에서는 회원가입 페이지 접근 불가
		if($this->session->userdata('EMS_U_ID_') != 'GUEST' && $this->session->userdata('EMS_U_ID_') != 'TMP_GUEST' && ($this->session->userdata('EMS_U_NO_'))) redirect('/', 'refresh');

		//이용약관
		$data['clause'] = $this->load->view('template/clause/clause_1.php', '', TRUE);

		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];
		$data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
		$data['header_gb'] = 'none';

		/**
		 * 퀵 레이아웃
		 */
//		$this->load->library('quick_lib');
//		$data['quick'] =  $this->quick_lib->get_quick_layer();

		$this->load->view('include/header', $data);
//		$this->load->view('include/menu');
		$this->load->view('member/member_join', $data);
		$this->load->view('include/footer');
	}

	/**
	 * 회원 아이디 중복 검사 모듈
	 */
	 public function id_check_post()
	{
		$param = $this->input->post();
		$mem_id = strtolower($param['mem_id']);

		//사용불가능 아이디검사
		$limitId = array('root','daemon','sync','shutdown','halt','mail','news','uucp','operator','games','gopher','nobody','vcsa','mailnull','rpcuser','nfsnobody','nscd','ident','radvd','named','pcap','mysql','postgres','oracle','administrator','master','webmaster','operator','admin','sysadmin','system','test','guest','tmp_guest','anonymous','sysop','moderator','babara','okcashbag','boradori','assajapan');
		if(in_array($mem_id, $limitId)) {
			$this->response(array('status'=>'error', 'message'=>'사용할 수 없는 아이디입니다.'), 200);
		}

		//Load MODEL
		$this->load->model('member_m');

		//회원 정보 데이타 구하기
		$row = $this->member_m->get_member_info_id($mem_id);
		if( ! empty($row) ) {
			$this->response(array('status'=>'error', 'message'=>'이미 사용중인 아이디입니다.'), 200);
		}
		else {
			$this->response(array('status' => 'ok', 'mem_id' => $mem_id), 200);
		}
	}

    /**
     * 회원 추천인 ID 확인, 중복 검사
     */
    public function rcmd_id_check_post()
    {
        $param = $this->input->post();
        $rcmd_id = strtolower(trim($param['rcmd_id']));

        //Load MODEL
        $this->load->model('member_m');

        $row = $this->member_m->get_member_info_id($rcmd_id);
        if( empty($row) ) {
            $this->response(array('status'=>'fail', 'message'=>'존재하지 않는 아이디 입니다.'), 200);
        }

        $row2 = $this->member_m->get_member_info_rcmdID($rcmd_id);
        if( ! empty($row2) ) {
            $this->response(array('status'=>'fail', 'message'=>'이미 추천인 ID로 등록된 아이디입니다.'), 200);
        } else {
            $this->response(array('status'=>'ok', 'rcmd_id'=>$rcmd_id), 200);
        }
    }

	/**
	 * 회원 이메일 중복 검사 & 인증번호 생성 모듈
	 */
	 public function email_check_post()
	{
		$param = $this->input->post();
		$mem_email = $param['mem_email'];

		//Load MODEL
		$this->load->model('member_m');

		//회원 정보 데이타 구하기
		$row = $this->member_m->get_member_info_email($mem_email);
		if( ! empty($row) ) {
			$this->response(array('status'=>'error', 'message'=>'이미 사용중인 이메일입니다.'), 200);
		}
		else {
			//이메일 인증코드 생성
			$cal_num = array(8,6,4,2,3,5,9,7);
			$tmp_auth	 = "";
			$tmp_authchr = "";
			$tmp_authnum = array();

			for($i=0; $i<8; $i++){	//난수 8자리 생성
				mt_srand((double)microtime()*1000000);
				$tmp_authnum[$i] = mt_rand(0,9);
				$tmp_auth .= $tmp_authnum[$i];
			}

			//CHECK DIGIT 값 구하기
			for($i=0; $i<8; $i++){		//STEP 01
				$digit_1[$i] = $cal_num[$i] * $tmp_authnum[$i];
			}

			$digit_2 = array_sum($digit_1);			//STEP 02
			$digit_3 = ( $digit_2 - ($digit_2 % 11)) / 11;		//STEP 03
			$digit_4 = ceil( $digit_2 % 11 );		//STEP 04
			$digit_5 = $digit_3 - $digit_4;			//STEP 05 :: 최종 DIGIT 값

			if($digit_5 >= 10){
				$chk_digit01 = substr($digit_5,0,1);
				$chk_digit02 = substr($digit_5,1,1);
			} else {
				$chk_digit01 = "0";
				$chk_digit02 = $digit_5;
			}

			for($i=0; $i<3; $i++){		//알파벳 난수 3자리 생성
				mt_srand((double)microtime()*1000000);
				$tmp_authchr .= substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0,51), 1);
			}

			$tmp_authcode = $tmp_authchr.$tmp_auth.$chk_digit01.$chk_digit02;			//최종 인증코드값

			//이메일 인증 메일 발송
			$mailParam["kind"		] = "email_auth";
			$mailParam["tmp_code"	] = $tmp_authcode;
			$mailParam["mem_email"	] = $mem_email;
			self::_background_send_mail($mailParam);

			$cur_date = date("Y-m-d H:i:s");

			$email_cert = $this->member_m->regist_email_cert($mem_email, $tmp_authcode, $cur_date);		//이메일 인증 테이블에 insert

			$this->response(array('status' => 'ok', 'mem_email' => $mem_email, 'auth_code' => $tmp_authcode), 200);
		}
	}

	/**
	 * 회원 이메일 인증번호 확인 모듈
	 */
	 public function email_auth_check_post()
	{
		 $param = $this->input->post();

		 $auth_code = $param['auth_code'];
		 $chk_digit = substr($auth_code,11,2);		//CHECK DIGIT값

		 //비교를 위한 값 설정
		 $tmp_authnum = array();
		 for($i=0; $i<8; $i++){
			 $tmp_authnum[$i] = substr($auth_code,$i+3,1);
		 }

		 //CHECK DIGIT 값 확인하기
		 $cal_num = array(8,6,4,2,3,5,9,7);

		 for($i=0; $i<8; $i++){		//STEP 01
			 $digit_1[$i] = $cal_num[$i] * $tmp_authnum[$i];
		 }

		 $digit_2 = array_sum($digit_1);		//STEP 02
		 $digit_3 = ( $digit_2 - ($digit_2 % 11)) / 11;		//STEP 03
		 $digit_4 = ceil( $digit_2 % 11 );		//STEP 04
		 $digit_5 = $digit_3 - $digit_4;		//STEP 05 :: 최종 DIGIT 값

		 //Load MODEL
		 $this->load->model('member_m');

		 if($digit_5 != $chk_digit){
			 $email_cert = $this->member_m->update_email_cert($param['mem_email'], $auth_code, $cur_date, 'ERR');		//이메일 인증 update

			 $this->response(array('status' => 'error', 'message'=>'CHECK DIGIT값이 일치하지 않습니다.'), 200);
		 }

		 $cur_date = date("Y-m-d H:i:s");
		 $email_cert = $this->member_m->update_email_cert($param['mem_email'], $auth_code, $cur_date, 'SUC');		//이메일 인증 update

		 $this->response(array('status' => 'ok'), 200);
	}

    /**
     * 회원 휴대전화 중복 검사 & 인증번호 생성 모듈
     */
    public function phone_check_post()
    {
        $param = $this->input->post();
        $mem_mobile = $param['mem_mobile'];

        //Load MODEL
        $this->load->model('member_m');

        //회원 정보 데이타 구하기
        $row = $this->member_m->get_member_info_mobile($mem_mobile);

        if( ! empty($row) ) {
            $this->response(array('status'=>'error', 'message'=>'이미 사용중인 전화번호입니다.'), 200);
        }
        else {
            //휴대폰번호 인증코드 생성
            $tmp_auth	 = "";
            $tmp_authnum = array();

            for($i=0; $i<6; $i++){	//난수 6자리 생성
                mt_srand((double)microtime()*1000000);
                $tmp_authnum[$i] = mt_rand(0,9);
                $tmp_auth .= $tmp_authnum[$i];
            }

            $tmp_authcode = $tmp_auth;			//최종 인증코드값

            //휴대전화 인증 발송
            $sms = array();
            $sms['MSG_GB_CD'    ] = 'SMS';
            $sms['DEST_PHONE'   ] = str_replace("-", "", $mem_mobile);
            $sms['MSG'          ] = "[에타홈] 본인확인 인증번호는 [".$tmp_authcode."]입니다. 정확히 입력해주세요.";

            $send_sms = $this->member_m->reg_send_sms('SMS', $sms); //문자발송

            $cur_date = date("Y-m-d H:i:s");

            $email_cert = $this->member_m->regist_mobile_cert($mem_mobile, $tmp_authcode, $cur_date);		//이메일 인증 테이블에 insert

            $this->response(array('status' => 'ok', 'mem_mobile' => $mem_mobile, 'auth_code' => $tmp_authcode), 200);
        }
    }

    /**
     * 회원 휴대전화 인증번호 확인 모듈
     */
    public function mobile_auth_check_post()
    {
        $param = $this->input->post();

        $mem_mobile = $param['mem_mobile'];
        $auth_code = $param['auth_code'];

        //Load MODEL
        $this->load->model('member_m');

        $result = $this->member_m->get_sms_certkey_chk($mem_mobile, $auth_code);

        if (!$result['MOB_NO']) {
            $cur_date = date("Y-m-d H:i:s");
            $email_cert = $this->member_m->update_mobile_cert($param['mem_mobile'], $auth_code, $cur_date, 'ERR');		//이메일 인증 update

            $this->response(array('status' => 'fail', 'message'=>'인증번호가 일치하지 않습니다.'), 200);
        } else {
            $cur_date = date("Y-m-d H:i:s");
            $email_cert = $this->member_m->update_mobile_cert($param['mem_mobile'], $auth_code, $cur_date, 'SUC');		//이메일 인증 update

            $this->response(array('status' => 'ok'), 200);
        }

    }

	/**
	 * 회원가입
	 */
	 public function join_post()
	{
        $param = $this->input->post();

        //Load MODEL
        $this->load->model('member_m');
        $this->load->model('mywiz_m');

        //적립예정 마일리지 설정
        if($param['mem_birth'] != '' && isset($param['mem_gender']) && isset($param['petYn']) && isset($param['merry'])) {
            $mileage = 3000;    //선택항목 입력시 1000점 추가적립
        } else {
            $mileage = 2000;
        }

        if($param['mem_birth'] == ''){	//생년월일 입력 안했을 경우
            $param['mem_birth'] = 'N';
        }

        if(!isset($param['mem_gender'])){	//성별 선택 안했을 경우
            $param['mem_gender'] = 'N';
        }

        if(!isset($param['Agree_yn'])){	//수신동의 선택 안했을 경우
            $param['Agree_yn'] = 'N';
        }

        if(!isset($param['merry'])){	//결혼유무 안했을 경우
            $param['merry'] = 'C';
        }

        if(!isset($param['petYn'])){	//반려동물 유무 안했을 경우
            $param['petYn'] = 'C';
        }

        $mem_email = $param['mem_email1']."@".$param['mem_email2'];

        $exists_member = $this->member_m->get_member_info_email($mem_email);

		 if( ! empty($exists_member) ) {
			$this->response(array('status'=>'error', 'message'=>'이미 사용중인 이메일주소입니다.'), 200);
		 }

		 //회원가입
         $cust_no = $this->member_m->regist_member($param);


		 //회원가입 완료 이메일 메일 발송
		 $mailParam["kind"		] = "join";
		 $mailParam["mem_id"	] = $param['mem_id'];
		 $mailParam["mem_email"	] = $mem_email;
		 $mailParam["mem_name"	] = $param['mem_name'];
		 self::_background_send_mail($mailParam);

         //메일 발송 이력 추가 2018.04.12
         $this->member_m->Email_send_cust($mailParam);

        //SMS 카카오 알리미 발송. 2018.07.12
         $kakao = array();
         $kakao['SMS_MSG_GB_CD'         ] = 'KAKAO';
         $kakao['KAKAO_TEMPLATE_CODE'] = 'bizp_2019111211173925475126028';
         $kakao['KAKAO_SENDER_KEY'] = '1682e1e3f3186879142950762915a4109f2d04a2';
         $kakao['DEST_PHONE'] = str_replace("-", "", $param['chk_phone']);
         $kakao['MSG'] ="[에타홈] 회원가입 완료
 
안녕하세요, ".$param['mem_name']."고객님^^
에타홈 회원가입이 완료되었습니다
감사의 의미로 
".$mileage." 마일리지를 
적립해 드렸으니 
바로 사용하세요!

집에 관한 모든 것, 에타홈에서  
즐거운 쇼핑정보 만나보세요!";
        $kakao['KAKAO_ATTACHED_FILE'] = 'btn_join.json';
        $this->member_m->reg_send_sms('KAKAO', $kakao);

         //본인적립
         $this->member_m->insert_mileage_default($cust_no, $mileage);

         //추천인 적립
         if($param['chk_rcmdId'] != '') {
            $this->member_m->insert_mileage_recommendId($param['chk_rcmdId']);
         }

		 $this->response(array('status'=>'ok'), 200);
	}

	/**
	 * 회원가입 완료
	 */
	 public function join_finish_post()
	{
		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];
		$data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
		$data['header_gb'] = 'none';

		/**
		 * 퀵 레이아웃
		 */
//		$this->load->library('quick_lib');
//		$data['quick'] =  $this->quick_lib->get_quick_layer();

		$this->load->view('include/header', $data);
//		$this->load->view('include/menu');
		$this->load->view('member/member_join_finish');
		$this->load->view('include/footer');
	}

	/**
	 * 메일 작성
	 */
	private function _background_send_mail($param)
	{
		set_time_limit(0);

		$this->load->helper('url');
		$url = site_url("/member/background_send_mail");

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

		$body = self::_mail_template($param['kind']); //메일 템플릿 가져오기

        //이메일 인증
        if($param['kind'] == "email_auth"){
            $subject = "ETAHOME 회원가입 인증 메일입니다.";

            $body = str_replace("{{mem_id}}"    , $param['mem_email']	, $body);
            $body = str_replace("{{auth_code}}" , $param['tmp_code'	]	, $body);
            $body = str_replace("{{join_date}}" , date('Y-m-d')			, $body);
        }
		//회원가입 메일 발송
		else if($param['kind'] == "join"){
			$subject = "회원가입을 축하드립니다!";

			$body = str_replace("{{mem_id}}"    , $param['mem_id'	]	, $body);
            $body = str_replace("{{mem_email}}" , $param['mem_email']	, $body);
			$body = str_replace("{{mem_name}}"	, $param['mem_name'	]	, $body);
            $body = str_replace("{{join_date}}" , date('Y-m-d')			, $body);
		}
        //임시비밀번호 메일 발송
        else if($param['kind'] == "id_pass"){
            $subject = "ETAHOME 비밀번호 재설정을 위한 임시비밀번호 발급 메일입니다.";

            $body = str_replace("{{mem_id}}"    , $param['mem_id'       ]   , $body);
			$body = str_replace("{{mem_name}}"	, $param['mem_name'		]	, $body);
            $body = str_replace("{{mem_pw}}"    , $param['tmp_password'	]   , $body);
            $body = str_replace("{{reg_date}}"  , $param['mem_regdate'  ]   , $body);
            $body = str_replace("{{homepage}}"  , config_item('url')        , $body);
        }

        $receive = $param['mem_email'];

		$this->email->sendmail($receive, $subject, $body, 'info@etah.co.kr', 'ETA HOME');
	}

	/**
	 * 메일 템플릿 가져오기
	 */
	private function _mail_template($type = 'join')
	{
		$body = $this->load->view('template/email/'.$type.'/email_body.php', '', TRUE);

		return $body;
	}

	/**
	 * 회원탈퇴
	 */
	 public function leave_get()
	{
		$data['nav'			] = "ML";
		$data['cancel_apply'] = "";

		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];
		$data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
		$data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
		$data['footer_gb'] = 'member';

		$this->load->view('include/header', $data);
		$this->load->view('member/member_leave');
		$this->load->view('include/footer');
	}

	/**
	 * 회원탈퇴
	 */
	 public function leave_post()
	{
		//Load MODEL
		$this->load->model('member_m');

		$param = $this->input->post();

        if(!$this->member_m->regist_member_leave($param)) $this->response(array('status'=>'error', 'message'=>'잠시 후에 다시 시도하여주시기 바랍니다.'), 200);
        //sns회원 여부 확인.
        if(!empty($this->session->userdata('sns_kind'))) {
            $sns_data       = $this->session->userdata('sns_kind'     );
            $cust_no        = $this->session->userdata('data_id'      );
            $refresh_token  = $this->session->userdata('refresh_token');
            $access_token   = $this->session->userdata('access_token' );

            if($sns_data == 'naver') {
                /*네이버 서비스 연동해제*/
                $sns_info = $this->member_m->login_sns_naver($cust_no);

                $client_id = "9SaIx5rXOlEMdGL5ZOVY";
                $client_secret = "mTR3IC_4sY";

                //엑세스 토큰 발급.
                $token = $access_token;
                $header = "Bearer ".$token; // Bearer 다음에 공백 추가
                $url = "https://openapi.naver.com/v1/nid/verify";
                $is_post = false;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, $is_post);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $headers = array();
                $headers[] = "Authorization: ".$header;
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $message = curl_exec ($ch);
                $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $message = json_decode($message, true);
                curl_close ($ch);

                if($message['message'] != 'success'){

                    $apiURL = "https://nid.naver.com/oauth2.0/token?grant_type=refresh_token&client_id=".$client_id."&client_secret=".$client_secret."&refresh_token=".$refresh_token;
                    urlencode($apiURL);
                    $is_post = false;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $apiURL);
                    curl_setopt($ch, CURLOPT_POST, $is_post);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $server_output = curl_exec ($ch);
                    $server_output = json_decode($server_output, true);
                    curl_close ($ch);
                    $token = $server_output['access_token'];
                }

                if($status_code == 200) {
                    $chk = 1;
                    if(preg_match("/[!#$%^&*()?+=\/]/",$token)) $chk = 0;
                    if($chk != 1){
                        $token = urlencode($token);
                    }

                    $url = "https://nid.naver.com/oauth2.0/token?grant_type=delete&client_id=".$client_id."&client_secret=".$client_secret."&access_token=".$token."&service_provider=NAVER";
                    $is_post = false;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, $is_post);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $response = json_decode($response, true);

                    curl_close($ch);

                    if($response['result'] != 'success'){
                        $this->response(array('status'=>'error', 'message'=>'잠시 후에 다시 시도하여주시기 바랍니다.'), 200);
                    }
                }else{
                    $this->response(array('status'=>'error', 'message'=>'잠시 후에 다시 시도하여주시기 바랍니다.'), 200);
                }
            }else{
                $sns_info = $this->member_m->login_sns_kakao($cust_no);
                /*카카오 서비스 연동해제*/
                $token = $access_token;
                $url = "https://kapi.kakao.com/v1/user/unlink";
                $header  = "Bearer ".$token;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $headers = array();
                $headers[] = "Authorization: ".$header;
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $message = curl_exec ($ch);
                $message = json_decode($message, true);
                curl_close($ch);
                if($message['id'] != $sns_info['SNS_ID']){
                    $this->response(array('status'=>'error', 'message'=>'잠시 후에 다시 시도하여주시기 바랍니다.'), 200);
                }
            }
            $this->member_m->update_sns_useyn($sns_info['SNS_NO']);
        }
        if(!$this->member_m->update_useyn($param)) $this->response(array('status'=>'error', 'message'=>'잠시 후에 다시 시도하여주시기 바랍니다.'), 200);

		$this->response(array('status'=>'ok'), 200);
	}

	/**
	 * 회원탈퇴 완료
	 */
	 public function leave_finish_get()
	{
	 	$this->session->sess_destroy();

		$data['nav'			] = "ML";
		$data['cancel_apply'] = "";

		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];
		$data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
		$data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
		$data['footer_gb'] = 'member';

		$this->load->view('include/header', $data);
		$this->load->view('member/member_leave_finish');
		$this->load->view('include/footer');
	}

	/**
	 * ID찾기
	 */
	 public function id_search_get()
	{
		 //로그인 상태에서는 회원가입 페이지 접근 불가
		if($this->session->userdata('EMS_U_ID_')) redirect('/', 'refresh');

		$data['type'	] = 'id';
		$data['title'	] = '아이디 찾기';

		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];
		$data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
		$data['header_gb'] = 'none';

		$this->load->view('include/header', $data);
		$this->load->view('member/member_search');
		$this->load->view('include/footer');
	}

	/**
	 * 비밀번호 찾기
	 */
	 public function password_search_get()
	{
		 //로그인 상태에서는 회원가입 페이지 접근 불가
		if($this->session->userdata('EMS_U_ID_')) redirect('/', 'refresh');

		$data['type'	] = 'password';
		$data['title'	] = '비밀번호 찾기';

		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];
		$data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
		$data['header_gb'] = 'none';

		$this->load->view('include/header', $data);
		$this->load->view('member/member_search');
		$this->load->view('include/footer');
	}

	/**
	 * ID/비밀번호 찾기
	 */
	 public function search_member_post()
	{
		$this->load->model('member_m');

		$param = $this->input->post();

		if(!$member = $this->member_m->get_search_member($param)) $this->response(array('status'=>'error', 'message'=>'일치하는 회원정보가 없습니다.'), 200);

		if($param['type'] == 'password'){
			//임시패스워드 세팅
			$tmp_password = "";
			for($i=0; $i<10; $i++){
				mt_srand((double)microtime()*1000000);
				$tmp_password .= substr("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0,61), 1);
			}

//			$tmp_password = "test1234";
			if(!$this->member_m->update_temp_password($param, $tmp_password)) $this->response(array('status'=>'error', 'message'=>'error'), 200);


		//임시 비밀번호 메일 발송
		$mailParam["kind"			] = "id_pass";
		$mailParam["mem_id"			] = $member['CUST_ID'];
		$mailParam["mem_name"		] = $member['CUST_NM'];
		$mailParam["tmp_password"	] = $tmp_password;
		$mailParam["mem_email"		] = $member['EMAIL'];
		$mailParam["mem_regdate"	] = $member['REG_DT'];
		self::_background_send_mail($mailParam);

        //메일 발송 이력 추가 2018.04.12
        $this->member_m->Email_send_cust($mailParam);
		}
		$this->response(array('status'=>'ok', 'member'=>$member), 200);
	}

	/**
	 * 비밀번호 찾기 완료
	 */
	 public function search_finish_post()
	{
		 //로그인 상태에서는 회원가입 페이지 접근 불가
		if($this->session->userdata('EMS_U_ID_')) redirect('/', 'refresh');

		$data['member'] = $this->input->post();
//var_dump($data['member']);
		/**
		 * 상단 카테고리 데이타
		 */
		$this->load->library('etah_lib');
		$category_menu = $this->etah_lib->get_category_menu();
		$data['menu'] = $category_menu['category'];
		$data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
		$data['header_gb'] = 'none';

		$this->load->view('include/header', $data);
		$this->load->view('member/member_search_finish');
//		$this->load->view('include/layout');
		$this->load->view('include/footer');
	}


    #########################################################
    ## 간편 로그인 (kakao, naver)
    ## 2018.06.01 @박상현
    #########################################################
    /**
     * 간편 로그인 (kakao)
     * 카카오 회원조회
     */
    public function kakao_login_get(){
        $ssl_val = $_SERVER['HTTP_HOST'];
        $app_key = "d2f88de4d0ea13fefcf72bc7e3c84c06";
        $redirectURI = urlencode("https://".$ssl_val."/member/ksns_login");
        $state = md5(microtime().mt_rand());
        $apiURL = "https://kauth.kakao.com/oauth/authorize?client_id=".$app_key."&redirect_uri=".$redirectURI."&response_type=code&state=".$state;

        redirect($apiURL);
    }

    public function ksns_login_get(){

        $this->load->model('member_m');
        $client_id = "d2f88de4d0ea13fefcf72bc7e3c84c06";
        $client_secret = "NL59tulqJpNrvSN6V3c6A4vBfYbFQaCr";
        $code = $_GET["code"];
        if(!$code){
//            echo '사용자 취소';
            echo("<script language=javascript>alert('SNS 연동에 실패하였습니다. 다시 시도해주시기 바랍니다.');</script>");
            echo("<script language=javascript>self.close();  </script>");
        }

        //Get access token setting
        $ssl_val = $_SERVER['HTTP_HOST'];
        $post_data = 'grant_type=authorization_code'.
            '&client_id='.$client_id.
            '&redirect_uri=https://'.$ssl_val.'/member/ksns_login'.
            '&code='.$code.
            '&client_secret'.$client_secret;

        $url = "https://kauth.kakao.com/oauth/token";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
        $response = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        $param = json_decode($response,true);

        if($status_code == 200) {
            //get token -> session
            $token_data = array('refresh_token' =>  $param['refresh_token'], 'access_token' => $param['access_token']);
            $tmp_id = $this->session->userdata('EMS_U_NO_');
            $this->session->set_userdata($token_data);

            // post user_data request
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://kapi.kakao.com/v2/user/me");
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$param['access_token']
            ,'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec ($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close ($ch);


            /* 회원 여부 판단. */
            /*회원이면 로그인 세션 모듈생성 후 로그인 처리 아니면 회원가입 창 보여주기.*/
            if($status_code == 200) {

                $server_output = json_decode($server_output, true);

                $kakao_id	            = $server_output['id'];                             //카카오 고유 id 번호
                $kakao_email 	        = $server_output['kakao_account']['email'];         //카카오 로그인시 사용 이메일
                $connect_info = $this->member_m->isset_log_sns_code($kakao_id);
                if(empty($connect_info)){
                    $this->member_m->log_sns_code($server_output, 'K');
                }
                $snss_data = array(
                    'sns_kind'              =>  'kakao',
                    'data_id'			    =>	$kakao_id,
                    'data_email'			=>	$kakao_email
                );
                $this->session->set_userdata($snss_data);


                $cust_id = explode('@',$kakao_email);

                $sns_data1 = $this->member_m->login_sns_kakao($kakao_id);
                $sns_data2 = $this->member_m->get_cust_info($cust_id[0]);

                if(!empty($sns_data1) || !empty($sns_data2)){
                    //회원 정보 구하기
                    if(!empty($sns_data1)){
                        $Member = $this->member_m->get_member_info_sns($sns_data1['CUST_NO']);
                    }else{
                        $Member = $this->member_m->get_member_info_sns($sns_data2['CUST_NO']);
                    }

                    //로그인 세션 만들기
                    $this->load->library('encrypt');

                    $dummy = date("d").$Member['CUST_ID'].date("y").$this->input->server('REMOTE_ADDR');
                    $sess_data = array(
                        'EMS_U_NO_'			=>	$Member['CUST_NO'],
                        'EMS_U_ID_'			=>	$Member['CUST_ID'],
                        'EMS_U_GRADE_'		=>	$this->encrypt->aes_encrypt($Member['CUST_LEVEL_CD']),
                        'EMS_U_DUMMY_'		=>	md5($dummy),
                        'EMS_U_IP_'			=>	$this->input->server('REMOTE_ADDR'),
                        'EMS_U_TIME_'		=>	time(),
                        'EMS_U_NAME_'		=>	$Member['CUST_NM'],
                        'EMS_U_EMAIL_'		=>	$Member['EMAIL'],
                        'EMS_U_MOB_'		=>	$Member['MOB_NO'],
                        'EMS_U_SNS'         =>  $Member['SNS_YN'],
                        'EMS_U_SITE_ID_'	=>	'ETAH'
                    );
                    $this->session->set_userdata($sess_data);

                    $AccessLog = $this->member_m->regist_login_log($Member);

                    if($tmp_id != ''){	//비회원으로 로그인해서 장바구니를 사용했을 경우
                        $this->load->model('cart_m');
                        $tmp_cart = $this->cart_m->get_cart_goods($tmp_id);

                        if(count($tmp_cart) > 0){
                            foreach($tmp_cart as $row){
                                $cart['cust_no'				] = $Member['CUST_NO'];
                                $cart['goods_code'			] = $row['GOODS_CD'];
                                $cart['goods_option_code'	] = $row['GOODS_OPTION_CD'];
                                $cart['goods_cnt'			] = $row['GOODS_CNT'];

                                $CHKCart = $this->cart_m->chk_cart($cart);

                                if($CHKCart){
                                    $cart['cart_no'	] = $CHKCart['CART_NO'];
                                    $cart['cnt'		] = $CHKCart['CART_QTY'] + $cart['goods_cnt'];
                                    $cart['gb'		] = 'CNT';

                                    $UpdCart = $this->cart_m->upd_cart($cart);
                                } else {
                                    $AddCart = $this->cart_m->add_cart($cart);		//장바구니에 담기
                                }
                            }	//END foreach
                        }	//END if

                    }	//END if

                    //로그인
                    echo ("<script language=javascript> window.opener.location.href = window.opener.document.mainform.return_url.value;</script>");
                    echo ("<script language=javascript> self.close();</script>");
                }else{
                    $Member = $this->member_m->get_member_info_sns($this->session->userdata('EMS_U_NO_'));
                    if(!empty($Member)){
                        echo("<script language=javascript>
                        var url = window.opener.location.host;
                        window.opener.document.mainform.method ='post';
                        window.opener.document.mainform.action ='https://'+url+'/member/member_join_sns2';
                        window.opener.document.mainform.submit();</script>");

                        echo("<script language=javascript>self.close();</script>");
                    }else {
                        //2018.11.21 간편로그인 자동연동 추가
                        //SNS 이메일 주소와 기존 고객 이메일 주소 비교하여, 기존 고객여부 1차 판단하여 바로 SNS 연동완료
                        if($kakao_email == '' || $kakao_email == null){
                            //신규회원
                            echo("<script language=javascript>window.opener.document.mainform.sns_id.value = $kakao_id;</script>");
                            echo("<script language=javascript>
                        var url = window.opener.location.host;
                        window.opener.document.mainform.method = 'post';
                        window.opener.document.mainform.action ='https://'+url+'/member/member_join_sns';
                        window.opener.document.mainform.submit();</script>");
                            echo("<script language=javascript>self.close();</script>");
                        }else{
                            $cEmail = $this->member_m->sns_email_match($kakao_email);
                            if(!empty($cEmail)){
                                //회원 가입이력 있음.
                                $match_data = array('MATCH_CUST_NO' =>  $cEmail['CUST_NO'], 'MATCH_CUST_ID' => $cEmail['CUST_ID'],
                                    'MATCH_EAMIL' => $cEmail['EMAIL'], 'MATCH_CUST_NM' => $cEmail['CUST_NM']);
                                $this->session->set_userdata($match_data);

                                echo ("<script language=javascript>if(confirm('회원가입이력이 있습니다. 카카오 연동하시겠습니까?')){
                                var url = window.opener.location.host;
                                window.opener.document.mainform.method = 'post';
                                window.opener.document.mainform.action ='https://'+url+'/member/member_join_sns3';
                                window.opener.document.mainform.submit();
                                
                                self.close();
                            }else{
                                self.close();
                            }</script>");
                            }else{

                                //신규회원
                                echo("<script language=javascript>window.opener.document.mainform.sns_id.value = $kakao_id;</script>");
                                echo("<script language=javascript>
                                var url = window.opener.location.host;
                                window.opener.document.mainform.method = 'post';
                                window.opener.document.mainform.action ='https://'+url+'/member/member_join_sns';
                                window.opener.document.mainform.submit();</script>");
                                echo("<script language=javascript>self.close();</script>");
                            }
                        }
                    }
                }
            }else{
                echo("<script language=javascript>alert('SNS 연동에 실패하였습니다. 다시 시도해주시기 바랍니다.');self.close();</script>");
            }
        }else{
            echo("<script language=javascript>alert('SNS 연동에 실패하였습니다. 다시 시도해주시기 바랍니다.');self.close();</script>");
        }
    }

    /**
     * 간편 로그인 (naver)
     * 네이버용 팝업
     */
    public function naver_login_get(){
        $ssl_val = $_SERVER['HTTP_HOST'];
        $client_id = "9SaIx5rXOlEMdGL5ZOVY";
        $redirectURI = urlencode("https://".$ssl_val."/member/nsns_login");
        $state = md5(microtime().mt_rand());
        $apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$client_id."&redirect_uri=".$redirectURI."&state=".$state;

        redirect($apiURL);
    }

    /**
     * 간편 로그인 (naver)
     * 네이버 회원조회
     */
    public function nsns_login_get(){

        $sparam = array();
        $this->load->model('member_m');
        $ssl_val = $_SERVER['HTTP_HOST'];
        //엑세스 토큰 발급.
        $client_id = "9SaIx5rXOlEMdGL5ZOVY";
        $client_secret = "mTR3IC_4sY";
        $code = $_GET["code"];
        $state = $_GET["state"];
        $redirectURI = urlencode("https://".$ssl_val."/member/nsns_login");
        $url = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".$client_id."&client_secret=".$client_secret."&redirect_uri=".$redirectURI."&code=".$code."&state=".$state;
        $is_post = false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $headers = array();
        $response = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        $param = json_decode($response,true);

        $token_data = array('refresh_token' =>  $param['refresh_token'], 'access_token' => $param['access_token']);
        $tmp_id = $this->session->userdata('EMS_U_NO_');
        $this->session->set_userdata($token_data);  //refresh토큰 취득

        //회원정보 조회 요청
        if($status_code == 200) {

            $token = $param['access_token'];
            $header = "Bearer ".$token; // Bearer 다음에 공백 추가
            $url = "https://openapi.naver.com/v1/nid/me";
            $is_post = false;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, $is_post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = array();
            $headers[] = "Authorization: ".$header;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $server_output = curl_exec ($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close ($ch);
            if($status_code == 200) {

                $server_output = json_decode($server_output, true);

                $naver_id            = $server_output['response']['id'           ];
                $naver_email         = $server_output['response']['email'        ];
                $naver_name          = $server_output['response']['name'         ];
                $naver_nickname      = $server_output['response']['nickname'     ];
                $naver_profile_image = $server_output['response']['profile_image'];

                $connect_info = $this->member_m->isset_log_sns_code($naver_id);

                if(empty($connect_info)){
                    $this->member_m->log_sns_code($server_output, 'N');
                }

                $sparam['naver_data']['id'                 ] = $naver_id;
                $sparam['naver_data']['naver_email'        ] = $naver_email;
                $sparam['naver_data']['naver_name'         ] = $naver_name;
                $sparam['naver_data']['naver_nickname'     ] = $naver_nickname;
                $sparam['naver_data']['naver_profile_image'] = $naver_profile_image;

                $snss_data = array(
                    'sns_kind'              =>  'naver',
                    'data_id'			    =>	$naver_id,
                    'data_email'			=>	$naver_email,
                    'data_nickname'		    =>	$naver_nickname,
                    'data_profile_image'	=>	$naver_profile_image
                );
                $this->session->set_userdata($snss_data);

                $cust_id = explode('@',$naver_email);

                $sns_data1 = $this->member_m->login_sns_naver($naver_id);
//                log_message('DEBUG','========='.$sns_data1);
                $sns_data2 = $this->member_m->get_cust_info($cust_id[0]);
//                log_message('DEBUG','========='.$sns_data2);

                if(!empty($sns_data1) || !empty($sns_data2)){
                    //회원 정보 구하기
                    if(!empty($sns_data1)){
                        $Member = $this->member_m->get_member_info_sns($sns_data1['CUST_NO']);
//                        log_message('DEBUG','========='.$naver_id);
                    }else{
                        $Member = $this->member_m->get_member_info_sns($sns_data2['CUST_NO']);
                    }
                    //로그인 세션 만들기
                    $this->load->library('encrypt');

                    $dummy = date("d").$Member['CUST_ID'].date("y").$this->input->server('REMOTE_ADDR');
                    $sess_data = array(
                        'EMS_U_NO_'			=>	$Member['CUST_NO'],
                        'EMS_U_ID_'			=>	$Member['CUST_ID'],
                        'EMS_U_GRADE_'		=>	$this->encrypt->aes_encrypt($Member['CUST_LEVEL_CD']),
                        'EMS_U_DUMMY_'		=>	md5($dummy),
                        'EMS_U_IP_'			=>	$this->input->server('REMOTE_ADDR'),
                        'EMS_U_TIME_'		=>	time(),
                        'EMS_U_NAME_'		=>	$Member['CUST_NM'],
                        'EMS_U_EMAIL_'		=>	$Member['EMAIL'],
                        'EMS_U_MOB_'		=>	$Member['MOB_NO'],
                        'EMS_U_SNS'         =>  $Member['SNS_YN'],
                        'EMS_U_SITE_ID_'	=>	'ETAH'
                    );
                    $this->session->set_userdata($sess_data);

                    $AccessLog = $this->member_m->regist_login_log($Member);

                    if($tmp_id != ''){	//비회원으로 로그인해서 장바구니를 사용했을 경우
                        $this->load->model('cart_m');
                        $tmp_cart = $this->cart_m->get_cart_goods($tmp_id);

                        if(count($tmp_cart) > 0){
                            foreach($tmp_cart as $row){
                                $cart['cust_no'				] = $Member['CUST_NO'];
                                $cart['goods_code'			] = $row['GOODS_CD'];
                                $cart['goods_option_code'	] = $row['GOODS_OPTION_CD'];
                                $cart['goods_cnt'			] = $row['GOODS_CNT'];

                                $CHKCart = $this->cart_m->chk_cart($cart);

                                if($CHKCart){
                                    $cart['cart_no'	] = $CHKCart['CART_NO'];
                                    $cart['cnt'		] = $CHKCart['CART_QTY'] + $cart['goods_cnt'];
                                    $cart['gb'		] = 'CNT';

                                    $UpdCart = $this->cart_m->upd_cart($cart);
                                } else {
                                    $AddCart = $this->cart_m->add_cart($cart);		//장바구니에 담기
                                }
                            }	//END foreach
                        }	//END if

                    }	//END if

                    //로그인
//                    echo ("<script language=javascript> alert($returnUrl);</script>");
                    echo ("<script language=javascript> window.opener.location.href = window.opener.document.mainform.return_url.value;</script>");
                    echo ("<script language=javascript> self.close();</script>");

                }else{
                    $Member = $this->member_m->get_member_info_sns($this->session->userdata('EMS_U_NO_'));
                    if(!empty($Member)){  //연동
                        echo("<script language=javascript>
                        var url = window.opener.location.host;
                        window.opener.document.mainform.method = 'post';
                        window.opener.document.mainform.action ='https://'+url+'/member/member_join_sns2';
                        window.opener.document.mainform.submit();</script>");

                        echo("<script language=javascript>self.close();</script>");
                    }else {

                        //2018.11.21 간편로그인 자동연동 추가
                        //SNS 이메일 주소와 기존 고객 이메일 주소 비교하여, 기존 고객여부 1차 판단하여 바로 SNS 연동완료
                        if($naver_email == '' || $naver_email == null){
                            //신규회원
                            echo("<script language=javascript>window.opener.document.mainform.sns_id.value = $naver_id;</script>");
                            echo("<script language=javascript>
                            var url = window.opener.location.host;
                            window.opener.document.mainform.method = 'post';
                            window.opener.document.mainform.action ='https://'+url+'/member/member_join_sns';
                            window.opener.document.mainform.submit();</script>");
                            echo("<script language=javascript>self.close();</script>");
                        }else{
                            $cEmail = $this->member_m->sns_email_match($naver_email);

                            if(!empty($cEmail)){
                                //회원 가입이력 있음.
                                $match_data = array('MATCH_CUST_NO' =>  $cEmail['CUST_NO'], 'MATCH_CUST_ID' => $cEmail['CUST_ID'],
                                    'MATCH_EAMIL' => $cEmail['EMAIL'], 'MATCH_CUST_NM' => $cEmail['CUST_NM']);
                                $this->session->set_userdata($match_data);
                                echo ("<script language=javascript> window.opener.location.href = window.opener.document.mainform.return_url.value;</script>");
                                echo ("<script language=javascript>if(confirm('회원가입이력이 있습니다. 네이버 연동하시겠습니까?')){
                            
                                var url = window.opener.location.host;
                                window.opener.document.mainform.method = 'post';
                                window.opener.document.mainform.action ='https://'+url+'/member/member_join_sns3';
                                window.opener.document.mainform.submit();
                                
                                self.close();
                            }else{
                                self.close();
                            }</script>");
                            }else{

                                //신규회원
                                echo("<script language=javascript>window.opener.document.mainform.sns_id.value = $naver_id;</script>");
                                echo("<script language=javascript>
                                var url = window.opener.location.host;
                                window.opener.document.mainform.method = 'post';
                                window.opener.document.mainform.action ='https://'+url+'/member/member_join_sns';
                                window.opener.document.mainform.submit();</script>");
                                echo("<script language=javascript>self.close();</script>");
                            }
                        }
                    }
                }
            } else {
                echo("<script language=javascript>alert('SNS 연동에 실패하였습니다. 다시 시도해주시기 바랍니다.');self.close();</script>");
            }
        } else {
            echo("<script language=javascript>alert('SNS 연동에 실패하였습니다. 다시 시도해주시기 바랍니다.');self.close();</script>");
        }
    }

    /**
     * 간편 로그인 (wemap)
     * 위메프용 팝업
     */
    public function wemap_login_get()
    {
        $ssl_val = $_SERVER['HTTP_HOST'];
        $client_id = "etah_SmYjOYBlhy";
        $redirectURI = urlencode("https://".$ssl_val."/member/wsns_login");
        $state = md5(microtime().mt_rand());
        $apiURL = "https://login.wonders.app/wauth/authorize?response_type=code&client_id=".$client_id."&state=".$state."&redirect_uri=".$redirectURI;

        redirect($apiURL);
    }


    /**
     * 간편 로그인 (wemap)
     * 위메프 회원조회
     */
    public function wsns_login_get()
    {
        $sparam = array();

        $this->load->model('member_m');

        $ssl_val = $_SERVER['HTTP_HOST'];
        //엑세스 토큰 발급.
        $client_id = "etah_SmYjOYBlhy";
        $client_secret = "_yNFrtlgmh-I82s4i7Ug8WsA5R4m4mR5_R1NRoG0buI=";
        $header = base64_encode($client_id.":".$client_secret);
        $code = $_GET["code"];
        $state = $_GET["state"];
        $redirectURI = urlencode("https://".$ssl_val."/member/wsns_login");
        $url = "https://login.wonders.app/wauth/token";

        $post_data['grant_type'] = "authorization_code";
        $post_data['code'] = $code;
        $post_data['redirect_uri'] = "https://".$ssl_val."/member/wsns_login";

        $is_post = true;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $headers = array();
        $headers[] = "Authorization: Basic ".$header;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //echo "status_code:".$status_code."";
        curl_close ($ch);
        $param = json_decode($response,true);

        $token_data = array('refresh_token' =>  $param['refresh_token'], 'access_token' => $param['access_token']);
        $tmp_id = $this->session->userdata('EMS_U_NO_');    //장바구니 임시 고객번호
        $this->session->set_userdata($token_data);  //refresh토큰 취득

        //회원정보 조회 요청
        if($status_code == 200) {

            $token = $param['access_token'];
            $header = "Bearer ".$token; // Bearer 다음에 공백 추가
            $url = "https://login.wonders.app/wauth/me";
            $is_post = false;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, $is_post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = array();
            $headers[] = "Authorization: ".$header;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $server_output = curl_exec ($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close ($ch);
            if($status_code == 200) {

                $server_output = json_decode($server_output, true);

                $wemap_id           = $server_output['mid'          ];      //위메프 사용자 고유키
                $wemap_name         = $server_output['name'         ];      //위메프 사용자 이름
                $wemap_mobile       = $server_output['mobile'       ];      //위메프 핸드폰번호
                $wemap_email        = $server_output['email'        ];      //위메프 이메일주소
                $wemap_gender       = $server_output['gender'       ];      //위메프 성별 (1:남성, 2:여성, 0:선택안함)
                $wemap_birth        = $server_output['birth'        ];      //위메프 생년월일

                $connect_info = $this->member_m->isset_log_sns_code($wemap_id);

                if(empty($connect_info)){
                    $this->member_m->log_sns_code($server_output, 'W');
                }

                $sparam['wemap_data']['id'                  ] = $wemap_id;
                $sparam['wemap_data']['name'                ] = $wemap_name;
                $sparam['wemap_data']['mobile'              ] = $wemap_mobile;
                $sparam['wemap_data']['email'               ] = $wemap_email;
                $sparam['wemap_data']['gender'              ] = $wemap_gender;
                $sparam['wemap_data']['birth'               ] = $wemap_birth;

                $snss_data = array(
                    'sns_kind'              =>  'wemap',
                    'data_id'               =>  $wemap_id,
                    'date_name'			    =>	$wemap_name,
                    'data_mobile'			=>	$wemap_mobile,
                    'data_email'			=>	$wemap_email,
                    'data_gender'		    =>	$wemap_gender,
                    'data_birth'	        =>	$wemap_birth
                );
                $this->session->set_userdata($snss_data);

                $cust_id = explode('@',$wemap_email);

                $sns_data1 = $this->member_m->login_sns_wemap($wemap_id);
//                log_message('DEBUG','========='.$sns_data1);
                $sns_data2 = $this->member_m->get_cust_info($cust_id[0]);
//                log_message('DEBUG','========='.$sns_data2);

                if(!empty($sns_data1) || !empty($sns_data2)){
                    //회원 정보 구하기
                    if(!empty($sns_data1)){
                        $Member = $this->member_m->get_member_info_sns($sns_data1['CUST_NO']);
//                        log_message('DEBUG','========='.$naver_id);
                    }else{
                        $Member = $this->member_m->get_member_info_sns($sns_data2['CUST_NO']);
                    }
                    //로그인 세션 만들기
                    $this->load->library('encrypt');

                    $dummy = date("d").$Member['CUST_ID'].date("y").$this->input->server('REMOTE_ADDR');
                    $sess_data = array(
                        'EMS_U_NO_'			=>	$Member['CUST_NO'],
                        'EMS_U_ID_'			=>	$Member['CUST_ID'],
                        'EMS_U_GRADE_'		=>	$this->encrypt->aes_encrypt($Member['CUST_LEVEL_CD']),
                        'EMS_U_DUMMY_'		=>	md5($dummy),
                        'EMS_U_IP_'			=>	$this->input->server('REMOTE_ADDR'),
                        'EMS_U_TIME_'		=>	time(),
                        'EMS_U_NAME_'		=>	$Member['CUST_NM'],
                        'EMS_U_EMAIL_'		=>	$Member['EMAIL'],
                        'EMS_U_MOB_'		=>	$Member['MOB_NO'],
                        'EMS_U_SNS'         =>  $Member['SNS_YN'],
                        'EMS_U_SITE_ID_'	=>	'ETAH'
                    );
                    $this->session->set_userdata($sess_data);

                    $AccessLog = $this->member_m->regist_login_log($Member);

                    if($tmp_id != ''){	//비회원으로 로그인해서 장바구니를 사용했을 경우
                        $this->load->model('cart_m');
                        $tmp_cart = $this->cart_m->get_cart_goods($tmp_id);

                        if(count($tmp_cart) > 0){
                            foreach($tmp_cart as $row){
                                $cart['cust_no'				] = $Member['CUST_NO'];
                                $cart['goods_code'			] = $row['GOODS_CD'];
                                $cart['goods_option_code'	] = $row['GOODS_OPTION_CD'];
                                $cart['goods_cnt'			] = $row['GOODS_CNT'];

                                $CHKCart = $this->cart_m->chk_cart($cart);

                                if($CHKCart){
                                    $cart['cart_no'	] = $CHKCart['CART_NO'];
                                    $cart['cnt'		] = $CHKCart['CART_QTY'] + $cart['goods_cnt'];
                                    $cart['gb'		] = 'CNT';

                                    $UpdCart = $this->cart_m->upd_cart($cart);
                                } else {
                                    $AddCart = $this->cart_m->add_cart($cart);		//장바구니에 담기
                                }
                            }	//END foreach
                        }	//END if

                    }	//END if

                    //로그인
//                    echo ("<script language=javascript> alert($returnUrl);</script>");
                    echo ("<script language=javascript> window.opener.location.href = window.opener.document.mainform.return_url.value;</script>");
                    echo ("<script language=javascript> self.close();</script>");

                }else{
                    $Member = $this->member_m->get_member_info_sns($this->session->userdata('EMS_U_NO_'));
                    if(!empty($Member)){  //연동
                        echo("<script language=javascript>
                        var url = window.opener.location.host;
                        window.opener.document.mainform.method = 'post';
                        window.opener.document.mainform.action ='https://'+url+'/member/member_join_sns2';
                        window.opener.document.mainform.submit();</script>");

                        echo("<script language=javascript>self.close();</script>");
                    }else {

                        //2018.11.21 간편로그인 자동연동 추가
                        //SNS 이메일 주소와 기존 고객 이메일 주소 비교하여, 기존 고객여부 1차 판단하여 바로 SNS 연동완료
                        if($wemap_email == '' || $wemap_email == null){
                            //신규회원
                            echo("<script language=javascript>window.opener.document.mainform.sns_id.value = $wemap_id;</script>");
                            echo("<script language=javascript>
                            var url = window.opener.location.host;
                            window.opener.document.mainform.method = 'post';
                            window.opener.document.mainform.action ='https://'+url+'/member/member_join_sns';
                            window.opener.document.mainform.submit();</script>");
                            echo("<script language=javascript>self.close();</script>");
                        }else{
                            $cEmail = $this->member_m->sns_email_match($wemap_email);

                            if(!empty($cEmail)){
                                //회원 가입이력 있음.
                                $match_data = array('MATCH_CUST_NO' =>  $cEmail['CUST_NO'], 'MATCH_CUST_ID' => $cEmail['CUST_ID'],
                                    'MATCH_EAMIL' => $cEmail['EMAIL'], 'MATCH_CUST_NM' => $cEmail['CUST_NM']);
                                $this->session->set_userdata($match_data);
                                echo ("<script language=javascript> window.opener.location.href = window.opener.document.mainform.return_url.value;</script>");
                                echo ("<script language=javascript>if(confirm('회원가입이력이 있습니다. 위메프 연동하시겠습니까?')){
                            
                                var url = window.opener.location.host;
                                window.opener.document.mainform.method = 'post';
                                window.opener.document.mainform.action ='https://'+url+'/member/member_join_sns3';
                                window.opener.document.mainform.submit();
                                
                                self.close();
                            }else{
                                self.close();
                            }</script>");
                            }else{

                                //신규회원
                                echo("<script language=javascript>window.opener.document.mainform.sns_id.value = $wemap_id;</script>");
                                echo("<script language=javascript>
                                var url = window.opener.location.host;
                                window.opener.document.mainform.method = 'post';
                                window.opener.document.mainform.action ='https://'+url+'/member/member_join_sns';
                                window.opener.document.mainform.submit();</script>");
                                echo("<script language=javascript>self.close();</script>");
                            }
                        }
                    }
                }
            } else {
                echo("<script language=javascript>alert('SNS 연동에 실패하였습니다. 다시 시도해주시기 바랍니다.');self.close();</script>");
            }
        } else {
            echo("<script language=javascript>alert('SNS 연동에 실패하였습니다. 다시 시도해주시기 바랍니다.');self.close();</script>");
        }
    }

    /**
     * 회원가입 선택창
     * 이메일, 간편로그인(네이버, 카카오)
     */
    public function member_join1_get()
    {
        //로그인 상태에서는 회원가입 페이지 접근 불가
        if($this->session->userdata('EMS_U_ID_') != 'GUEST' && $this->session->userdata('EMS_U_ID_') != 'TMP_GUEST' && ($this->session->userdata('EMS_U_NO_'))) redirect('/', 'refresh');
        $param = $this->input->post();
        //이용약관
        $data['clause'] = $this->load->view('template/clause/clause_1.php', '', TRUE);
        $returnUrl = ($this->agent->is_referral()) ? $this->agent->referrer() : '/';
        if(preg_match('/member\/login/i', $returnUrl) || preg_match('/member\/member_join_sns/i', $returnUrl) || preg_match('/member\/Guestlogin/i', $returnUrl)) {
            $returnUrl = '/';
        }

        if(strpos($returnUrl,'join_finish')){
            $returnUrl	= '/';
        }

        if(isset($_GET['return_url'])){
            $returnUrl = $_GET['return_url'];
        }

        $data['returnUrl'] = $returnUrl;

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
        $data['header_gb'] = 'none';


        $this->load->view('include/header', $data);
        $this->load->view('member/member_join1', $data);
        $this->load->view('include/footer');
    }

    /**
     * 간편로그인용 회원가입
     */
    public function member_join_sns_post()
    {
        //로그인 상태에서는 회원가입 페이지 접근 불가
        if($this->session->userdata('EMS_U_ID_') != 'GUEST' && $this->session->userdata('EMS_U_ID_') != 'TMP_GUEST' && ($this->session->userdata('EMS_U_NO_'))) redirect('/', 'refresh');
        $param = $this->input->post();

        //이용약관
        $data['clause'] = $this->load->view('template/clause/clause_1.php', '', TRUE);
        $data['sns_id'] = $param['sns_id'];


        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
        $data['header_gb'] = 'none';

        $this->load->view('include/header', $data);
        $this->load->view('member/member_join_sns', $data);
        $this->load->view('include/footer');
    }

    /**
     * 일반회원 간편로그인 연동
     */
    public function member_join_sns2_post()
    {
        $this->load->model('member_m');
        $cust_no = $this->session->userdata('EMS_U_NO_');
        $cust_email = $this->session->userdata('data_email');

        $this->member_m->member_sns_with($cust_no, $cust_email);

        $sparam['CUST_NO'     ] = $cust_no;
        $sparam['CUST_ID'     ] = $this->session->userdata('EMS_U_ID_');
        $sparam['SNS_ID'      ] = $this->session->userdata('data_id');
        $sparam['SNS_NM'      ] = $this->session->userdata('EMS_U_NAME_');

        if($this->session->userdata('sns_kind') == 'naver') {
            $sparam['SNS_KIND_CD'] = 'N';
        }else if($this->session->userdata('sns_kind') == 'kakao'){
            $sparam['SNS_KIND_CD'] = 'K';
        }else if($this->session->userdata('sns_kind') == 'wemap'){
            $sparam['SNS_KIND_CD'] = 'W';
        }


        if($this->member_m->regist_member_sns($sparam)) {
            $result = "Success";
            $new_data = array(
                'EMS_U_SNS'              =>  'Y'
            );
            $this->session->set_userdata($new_data);
        }else {
            $result = "Fail";
        }
        $data = array();
        $data['nav'			] = "MS";
        $data['result'      ] = $result;

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
        $data['header_gb'] = 'none';


        $this->load->view('include/header', $data);
        $this->load->view('mywiz/mywiz_sns_f');
        $this->load->view('include/footer');
    }

    /**
     * 간편로그인용 회원가입 완료
     */
    public function sns_join_finsih_post()
    {
        $sparam = array();

        $param = $this->input->post();

        //적립예정 마일리지 설정
        if($param['mem_birth'] != '' && isset($param['mem_gender']) && isset($param['petYn']) && isset($param['merry'])) {
            $mileage = 3000;    //선택항목 입력시 1000점 추가적립
        } else {
            $mileage = 2000;
        }

        $param['mem_id'] = explode('@',$param['chk_email'])[0];
        $param['sns_yn'] = 'Y';

        //Load MODEL
        $this->load->model('member_m');
        $this->load->model('mywiz_m');

        if($param['mem_birth'] == ''){	//생년월일 입력 안했을 경우
            $param['mem_birth'] = 'N';
        }

        if(!isset($param['mem_gender'])){	//성별 선택 안했을 경우
            $param['mem_gender'] = 'N';
        }
        if(!isset($param['petYn'])){	//반려동물유무 선택 안했을 경우
            $param['petYn'] = 'C';
        }
        if(!isset($param['merry'])){	//결혼유무 선택 안했을 경우
            $param['merry'] = 'C';
        }

        if(!isset($param['Agree_yn'])){	//수신동의 선택 안했을 경우
            $param['Agree_yn'] = 'N';
        }

        $mem_mobile_no = $param['mem_mobile1']."-".$param['mem_mobile2']."-".$param['mem_mobile3'];

        $exists_member = $this->member_m->get_member_info_mobile($mem_mobile_no);
        $exists_email = $this->member_m->get_member_info_email($param['chk_email']);

        if( ! empty($exists_member) ) {
            $this->response(array('status'=>'fail', 'message'=>'이미 사용중인 휴대폰 번호 입니다. 기존 고객인 경우 1회 로그인을 하신 후 마이페이지 > 간편로그인 연동을 하실 수 있습니다. '), 200);
        }
        if( ! empty($exists_email) ) {
            $this->response(array('status'=>'fail', 'message'=>'이미 사용중인 이메일입니다.'), 200);
        }


        //회원가입
        $cust_no = $this->member_m->regist_member_s($param);

        if(empty($cust_no)) {
            $this->response(array('status'=>'fail', 'message'=>'System 오류'), 200);
        }

        $sparam['CUST_NO'     ] = $cust_no;
        $sparam['CUST_ID'     ] = $param['mem_id'];
        $sparam['SNS_ID'      ] = $param['sns_id'];
        $sparam['SNS_NM'      ] = $param['mem_name'];
        if($param['sns_kind'] == 'naver') {
            $sparam['SNS_KIND_CD'] = 'N';
        }else if($param['sns_kind'] == 'kakao'){
            $sparam['SNS_KIND_CD'] = 'K';
        }else if($param['sns_kind'] == 'wemap'){
            $sparam['SNS_KIND_CD'] = 'W';
        }


        $this->member_m->regist_member_sns($sparam);
        //회원가입 완료 이메일 메일 발송
        $mailParam["kind"		] = "join";
        $mailParam["mem_id"	    ] = $param['mem_id'];
        $mailParam["mem_email"	] = $param['chk_email'];
        $mailParam["mem_name"	] = $param['mem_name'];
        self::_background_send_mail($mailParam);

        //메일 발송 이력 추가 2018.04.12
        $this->member_m->Email_send_cust($mailParam);


        $kakao = array();
        $kakao['SMS_MSG_GB_CD'         ] = 'KAKAO';
        $kakao['KAKAO_TEMPLATE_CODE'] = 'bizp_2019111211173925475126028';
        $kakao['KAKAO_SENDER_KEY'] = '1682e1e3f3186879142950762915a4109f2d04a2';
        $kakao['DEST_PHONE'] = $param['mem_mobile1'].$param['mem_mobile2'].$param['mem_mobile3'];
        $kakao['MSG'] ="[에타홈] 회원가입 완료
 
안녕하세요, ".$param['mem_name']."고객님^^
에타홈 회원가입이 완료되었습니다
감사의 의미로 
".$mileage." 마일리지를 
적립해 드렸으니 
바로 사용하세요!

집에 관한 모든 것, 에타홈에서  
즐거운 쇼핑정보 만나보세요!";
        $kakao['KAKAO_ATTACHED_FILE'] = 'btn_join.json';
        $this->member_m->reg_send_sms('KAKAO', $kakao);

        //본인적립
        $this->member_m->insert_mileage_default($cust_no, $mileage);

        //추천인 적립
        if($param['chk_rcmdId'] != '') {
            $this->member_m->insert_mileage_recommendId($param['chk_rcmdId']);
        }

        $this->response(array('status'=>'ok'), 200);
    }

    /**
     * SNS 회원구분
     */
    public function sns_gubun_post()
    {
        $this->load->model('member_m');

        $sns_info = $this->member_m->sns_gubun();

        if($sns_info['SNS_KIND_CD'] == 'N'){
            $this->response(array('status'=>'ok', 'message'=>'N'), 200);
        }else if($sns_info['SNS_KIND_CD'] == 'K'){
            $this->response(array('status'=>'ok', 'message'=>'K'), 200);
        }else{
            //에러
            $this->response(array('status'=>'error', 'message'=>'error'), 200);
        }

    }

    public function member_join_sns3_post()
    {
        $this->load->model('member_m');
        $fParam = $this->input->post();
        $cust_no = $this->session->userdata('MATCH_CUST_NO');
        $cust_email = $this->session->userdata('MATCH_EAMIL');

        $this->member_m->member_sns_with($cust_no, $cust_email);

        $sparam['CUST_NO'     ] = $cust_no;
        $sparam['CUST_ID'     ] = $this->session->userdata('MATCH_CUST_ID');
        $sparam['SNS_ID'      ] = $this->session->userdata('data_id');
        $sparam['SNS_NM'      ] = $this->session->userdata('MATCH_CUST_NM');

        if($this->session->userdata('sns_kind') == 'naver') {
            $sparam['SNS_KIND_CD'] = 'N';
        }else if($this->session->userdata('sns_kind') == 'kakao'){
            $sparam['SNS_KIND_CD'] = 'K';
        }else if($this->session->userdata('sns_kind') == 'wemap'){
            $sparam['SNS_KIND_CD'] = 'W';
        }

        //임시세션 제거.
        $this->session->unset_userdata('MATCH_CUST_NO');
        $this->session->unset_userdata('MATCH_EAMIL');
        $this->session->unset_userdata('MATCH_CUST_ID');
        $this->session->unset_userdata('MATCH_CUST_NM');

        if($this->member_m->regist_member_sns($sparam)) {
            $Member = $this->member_m->get_member_info_sns($cust_no);
            //로그인 세션 만들기
            $this->load->library('encrypt');

            $dummy = date("d").$Member['CUST_ID'].date("y").$this->input->server('REMOTE_ADDR');
            $sess_data = array(
                'EMS_U_NO_'			=>	$cust_no,
                'EMS_U_ID_'			=>	$Member['CUST_ID'],
                'EMS_U_GRADE_'		=>	$this->encrypt->aes_encrypt($Member['CUST_LEVEL_CD']),
                'EMS_U_DUMMY_'		=>	md5($dummy),
                'EMS_U_IP_'			=>	$this->input->server('REMOTE_ADDR'),
                'EMS_U_TIME_'		=>	time(),
                'EMS_U_NAME_'		=>	$Member['CUST_NM'],
                'EMS_U_EMAIL_'		=>	$Member['EMAIL'],
                'EMS_U_MOB_'		=>	$Member['MOB_NO'],
                'EMS_U_SNS'         =>  $Member['SNS_YN'],
                'EMS_U_SITE_ID_'	=>	'ETAH'
            );
            $this->session->set_userdata($sess_data);

            $AccessLog = $this->member_m->regist_login_log($Member);
            redirect($fParam['return_url']);
        }else {
            echo("<script language=javascript>alert('연동에 실패하였습니다. 다시 시도해주시기 바랍니다.');self.close();</script>");
        }
    }


}