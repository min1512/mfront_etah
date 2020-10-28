<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_m extends CI_Model {

	protected $_ci;
	protected $mdb;
	protected $sdb;
    protected $smsdb;

	public function __construct()
	{
		parent::__construct();
		$this->_ci =& get_instance();
	}

    private function _sms_db()
    {
        if( ! empty($this->smsdb) ) return $this->smsdb;

        /* 데이타베이스 연결 */
        $this->load->helper('array');
        $database = random_element(config_item('sms'));
        $this->smsdb = $this->load->database($database,TRUE);

        return $this->smsdb;
    }

	private function _slave_db()
	{
		if( ! empty($this->sdb) ) return $this->sdb;

		/* 데이타베이스 연결 */
		$this->load->helper('array');
		$database = random_element(config_item('slave'));
		$this->sdb = $this->load->database($database,TRUE);

		return $this->sdb;
	}

	private function _master_db()
	{
		if( ! empty($this->mdb) ) return $this->mdb;

		/* 데이타베이스 연결 */
		$this->load->helper('array');
		$database = random_element(config_item('master'));
		$this->mdb = $this->load->database($database,TRUE);

		return $this->mdb;
	}

    /**
     * insert table
     *
     * @return mixed
     */
    public function insert_table( $table_name, $param )
    {
        $db = self::_master_db();
        $query_insert = $db->insert_string( $table_name, $param );

        try{
            $db->query( $query_insert );
        }catch( Exception $E ){

            return false;
        }

        return $db->insert_id();
    }


	/**
	 * 회원 정보 데이터 구하기
	 */
	 public function get_member_info_id($mem_id)
	{
		$query = "
			select	/*  > etah_mfront > member_m > get_member_info_id > ETAH 회원정보를 아이디로 데이터 구하기 */
				  c.CUST_NO
				, c.CUST_LEVEL_CD
				, c.CUST_ID
				, c.CUST_NM
				, c.MOB_NO
				, c.EMAIL
				, c.ZIPCODE
				, c.ADDR1
				, c.ADDR2
			from
				DAT_CUST		c
			where
				1 = 1
			and c.CUST_ID = '".$mem_id."'
		";

		$db = self::_slave_db();
		return $db->query($query)->row_array();
	}

	 public function get_member_info_email($mem_email)
	{
		$query = "
			select	/*  > etah_mfront > member_m > get_member_info_email > ETAH 회원정보를 이메일로 데이터 구하기 */
				  c.CUST_NO
				, c.CUST_LEVEL_CD
				, c.CUST_ID
				, c.CUST_NM
				, c.MOB_NO
				, c.EMAIL
			from
				DAT_CUST		c
			where
				1 = 1
			and c.EMAIL = '".$mem_email."'
		";

		$db = self::_slave_db();
		return $db->query($query)->row_array();
	}

	 public function get_member_info_pw1($mem_id, $mem_pw)
	{
		 $query = "
			select	/*  > etah_mfront > member_m > get_member_info_pw1 > ETAH 회원정보를 아이디+비밀번호로 데이터 구하기 */
				  c.CUST_NO
				, c.CUST_LEVEL_CD
				, c.CUST_ID
				, c.CUST_NM
				, c.MOB_NO
				, c.EMAIL
				, c.SNS_YN
			from
				DAT_CUST		c
			where
				1 = 1
			and c.CUST_ID	= '".$mem_id."'
			and c.PW		= PASSWORD('".$mem_pw."')
			and c.USE_YN	= 'Y'
		";

		$db = self::_slave_db();
		return $db->query($query)->row_array();
	}

	 public function get_member_info_pw2($mem_id, $mem_pw)
	{
		 $query = "
			select	/*  > etah_mfront > member_m > get_member_info_pw2 > ETAH 회원정보를 이메일+비밀번호로 데이터 구하기 */
				  c.CUST_NO
				, c.CUST_LEVEL_CD
				, c.CUST_ID
				, c.CUST_NM
				, c.MOB_NO
				, c.EMAIL
				, c.SNS_YN
			from
				DAT_CUST		c
			where
				1 = 1
			and c.EMAIL		= '".$mem_id."'
			and c.PW		= PASSWORD('".$mem_pw."')
			and c.USE_YN	= 'Y'
		";

		$db = self::_slave_db();
		return $db->query($query)->row_array();
	}

	 public function get_member_info_mobile($mobile_no)
	{
		 $query = "
			select	/*  > etah_mfront > member_m > get_member_info_mobile > ETAH 회원정보를 휴대전화로 데이터 구하기 */
				  c.CUST_NO
				, c.CUST_LEVEL_CD
				, c.CUST_ID
				, c.CUST_NM
				, c.MOB_NO
				, c.EMAIL
				, c.ZIPCODE
				, c.ADDR1
				, c.ADDR2
			from
				DAT_CUST		c
			where
				1 = 1
			and c.MOB_NO = '".$mobile_no."'
			and c.USE_YN = 'Y'
		";

		$db = self::_slave_db();
		return $db->query($query)->row_array();
	}

    public function get_member_info_rcmdID($rcmd_id)
    {
        $query = "
            select	/*  > etah_mfront > member_m > get_member_info_rcmdID > ETAH 추천인 ID 등록여부 확인하기 */
                  c.CUST_NO
                , c.CUST_LEVEL_CD
                , c.CUST_ID
                , c.CUST_NM
                , c.MOB_NO
                , c.EMAIL
                , c.ZIPCODE
                , c.ADDR1
                , c.ADDR2
            from
                DAT_CUST		c
            where
                1 = 1
            and c.RCMD_ID = '".$rcmd_id."'
        ";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

	/**
	 * 이메일 인증 테이블에 쌓기
	 */
	 public function regist_email_cert($email, $cert_no, $cur_date)
	{
		 $query = "
			insert into	DAT_EMAIL_CERT	(   /*  > etah_mfront > member_m > regist_email_cert > 이메일 인증 테이블에 쌓기 */
				  EMAIL
				, CERT_NO
				, SEND_DT
				, CERT_STS_CD
			)
			values
			(
				  '".$email."'
				, '".$cert_no."'
				, '".$cur_date."'
				, 'REG'
			)
		";

		$db = self::_master_db();
		return $db->query($query);
	}

	/**
	 * 이메일 인증 성공/실패 여부 업데이트
	 */
	 public function update_email_cert($email, $cert_no, $cur_date, $sts_cd)
	{
		 $query = "
			update	DAT_EMAIL_CERT    /*  > etah_mfront > member_m > update_email_cert > ETAH 이메일 인증 성공/실패 여부 업데이트 */
			set		  CERT_STS_CD	= '".$sts_cd."'
					, CERT_DT		= '".$cur_date."'
			where
				1 = 1
			and	EMAIL	= '".$email."'
			and	CERT_NO	= '".$cert_no."'
		";

		$db = self::_master_db();
		return $db->query($query);
	}

    /**
     * 휴대폰 인증 테이블에 쌓기
     */
    public function regist_mobile_cert($mobile, $cert_no, $cur_date)
    {
        $query = "
			insert into	DAT_MOBILE_CERT	(    /*  > etah_mfront > member_m > regist_mobile_cert > ETAH 휴대폰 인증 테이블에 쌓기 */
				  MOB_NO
				, CERT_NO
				, SEND_DT
				, CERT_STS_CD
			)
			values
			(
				  '".$mobile."'
				, '".$cert_no."'
				, '".$cur_date."'
				, 'REG'
			)
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * sms 인증번호 확인
     */
    public function get_sms_certkey_chk($mem_mobile, $auth_code)
    {
        $query = "
			select	/*  > etah_mfront > member_m > get_sms_certkey_chk > sms 인증번호 확인 */
				SC.MOB_NO
			from DAT_MOBILE_CERT SC
			where 1=1
				and SC.MOB_NO = '".$mem_mobile."'
				and SC.CERT_NO = '".$auth_code."'
			order by SC.REG_DT desc
			limit 1
		";

        $db = self::_slave_db();
        $result = $db->query($query)->row_array();
        return $result;
    }

    /**
     * 휴대폰 인증 성공/실패 여부 업데이트
     */
    public function update_mobile_cert($mobile, $cert_no, $cur_date, $sts_cd)
    {
        $query = "
			update	DAT_MOBILE_CERT     /*  > etah_mfront > member_m > update_mobile_cert > 휴대폰 인증 성공/실패 여부 업데이트 */
			set		  CERT_STS_CD	= '".$sts_cd."'
					, CERT_DT		= '".$cur_date."'
			where
				1 = 1
			and	MOB_NO	= '".$mobile."'
			and	CERT_NO	= '".$cert_no."'
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 추천인 ID 적립
     */
    public function insert_mileage_recommendId($cust_id)
    {
        $db = self::_master_db();

        $query = "select c.CUST_NO, c.RCMD_LIMIT_DT from DAT_CUST c where c.CUST_ID = '".$cust_id."'";
        $result = $db->query($query)->row_array();

        $cust_no = $result['CUST_NO'];
        $limit_dt = $result['RCMD_LIMIT_DT'];

        if( !empty($limit_dt) ){
            if($limit_dt > date('Y-m-d H:i:s')) {   //유효기간 내 회원가입 한 경우
                $query1 = "
				update	DAT_CUST_MILEAGE  m     /*  > etah_mfront > member_m > insert_mileage_recommendId > 추천인 ID 적립 */
				set m.SAVE_MILEAGE_AMT = m.SAVE_MILEAGE_AMT+5000, m.MILEAGE_AMT = m.MILEAGE_AMT+5000
				where m.CUST_NO = '".$cust_no."'
                ";

                $db->query($query1);

                $query2 = "
				insert into	DAT_CUST_MILEAGE_SAVING     /*  > etah_mfront > member_m > insert_mileage_recommendId > 추천인 ID 적립 */
				(CUST_NO, MILEAGE_SAVING_AMT, SAVE_YN,
				 SAVE_DT, SAVING_REASON_GB_CD, SAVING_REASON_ETC, REG_USER_CD)
				values(
					?, 5000, 'Y', now(), 'EVENT', '추천인 입력', 1)
                ";

                $db->query($query2, $cust_no);
            }
        }

        return true;
    }

	/**
	 * 회원가입
	 */
	 public function regist_member($param)
	{
		 $query = "
			insert into DAT_CUST	(     /*  > etah_mfront > member_m > regist_member > 회원가입 */
				  CUST_LEVEL_CD
				, CUST_ID
				, PW
				, CUST_NM
				, MOB_NO
				, MOB_REC_YN
				, EMAIL
				, EMAIL_REC_YN	";
        if($param['mem_birth'] != 'N'){
            $query .= "
				, BIRTH_DY	";
        }
        if($param['mem_gender'] != 'N'){
            $query .= "
				, GENDER_GB_CD	";
        }
        if($param['petYn'] != 'C'){
            $query .= "
				, PET_YN	";
        }
        if($param['merry'] != 'C'){
            $query .= "
				, MERRY_YN	";
        }
        if($param['chk_rcmdId'] != ''){
            $query .= "
                    , RCMD_ID	";
        }
        $query .= "
				, EMAIL_CERT_YN
			)
			values
			(
				  '01'
				, '".$param['mem_id']."'
				, PASSWORD('".$param['mem_password']."')
				, '".$param['mem_name']."'
				, '".$param['chk_phone']."'
				, '".$param['Agree_yn']."'
				, '".$param['mem_email1']."@".$param['mem_email2']."'
				, '".$param['Agree_yn']."'";
        if($param['mem_birth'] != 'N'){
            $query .= "
				, '".$param['mem_birth']."'	";
        }
        if($param['mem_gender'] != 'N'){
            $query .= "
				, '".$param['mem_gender']."' ";
        }
        if($param['petYn'] != 'C'){
            $query .= "
				, '".$param['petYn']."'	";
        }
        if($param['merry'] != 'C'){
            $query .= "
				, '".$param['merry']."' ";
        }
        if($param['chk_rcmdId'] != ''){
            $query .= "
                , '".$param['chk_rcmdId']."' ";
        }
        $query .= "
				, 'Y'
			)
		";

		$db = self::_master_db();
        $db->query($query);
        //log_message('DEBUG', '============'.$db -> last_query());
        return $db->insert_id();
	}

	/**
	 * 로그인시 로그 기록 쌓기
	 */
	 public function regist_login_log($param)
	{
		 $query = "
			insert into	LOG_CUST_ACCESS		(     /*  > etah_mfront > member_m > regist_login_log > 로그인시 로그 기록 쌓기 */
				  CUST_NO
				, ACCESS_DT
			)
			values
			(
				  '".$param['CUST_NO']."'
				, now()
			)
		";

		$db = self::_master_db();
		return $db->query($query);
	}

	/**
	 * 비회원 로그인 가능 여부
	 */
	 public function check_guest_login($param)
	{
		  $query = "
			select      /*  > etah_mfront > member_m > check_guest_login > 비회원 로그인 가능 여부 */
				o.ORDER_NO
			from
				DAT_ORDER		o
			inner join
				DAT_ORDER_DELIV		od
			on o.ORDER_NO	= od.ORDER_NO

			where
				1 = 1
			and o.ORDER_NO				= '".$param['order_no']."'
			and od.SENDER_NM			= '".$param['order_name']."'
			and o.NONMEMBER_ORDER_YN	= 'Y'
			and o.USE_YN				= 'Y'
		";

		$db = self::_slave_db();
		return $db->query($query)->row_array();
	}


	/**
	 * 회원탈퇴
	 */
	 public function regist_member_leave($param)
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');

		$query = "
			insert into DAT_CUST_WITHDRAW(     /*  > etah_mfront > member_m > regist_member_leave > 회원탈퇴 */
				CUST_NO
				, WITHDRAW_GB_CD";
			if($param['leave_comment'] != ''){
				$query .= ", ETC_CONTENT";
			}
		$query .= ", USE_YN
			)values(
				'".$cust_no."'
				,'".$param['leave_cd']."'";

			if($param['leave_comment'] != ''){
				$query .= ", '".$param['leave_comment']."'";
			}
		$query .= ", 'Y'
			)
		";

		$db = self::_master_db();
		return $db->query($query);
	}

	/**
	 * 회원탈퇴
	 */
	 public function update_useyn($param)
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');

		$query = "
			update 	DAT_CUST     /*  > etah_mfront > member_m > update_useyn > 회원탈퇴 */
			set 	USE_YN = 'N'

			where	CUST_NO = '".$cust_no."'
		";

		$db = self::_master_db();
		return $db->query($query);
	}

	/**
	 * 회원정보 찾기
	 */
	 public function get_search_member($param)
	{
		 $query_password = "";

		 if($param['type'] == 'password') $query_password = "and	c.CUST_ID = '".$param['id']."'";

		 $query = "
			select	/*  > etah_mfront > member_m > get_search_member > ETAH 회원정보 찾기 */
					c.CUST_NO
					, c.CUST_ID
					, c.CUST_NM
					, replace(c.CUST_ID ,right(c.CUST_ID, 3),'***')	as ID
					, c.REG_DT
					, c.EMAIL
			from 	DAT_CUST c
			where 	c.CUST_NM = '".$param['name']."'
			and 	c.EMAIL = '".$param['email']."'
			and		c.USE_YN = 'Y'
			$query_password
		";

		$db = self::_slave_db();
		return $db->query($query)->row_array();

	}

	 /**
	 * 임시 비밀번호 세팅
	 */
    public function update_temp_password($param, $tmp_password)
    {
        $query = "
			update	DAT_CUST    /*  > etah_mfront > member_m > update_temp_password > ETAH 임시 비밀번호 세팅 */
			set		PW = password('".$tmp_password."')
			where	CUST_ID = '".$param['id']."'
        ";

		$db = self::_master_db();
		return $db->query($query);
    }

    /**
     * 마일리지 2000지급
     */
    public function regist_member_mileage($cust_No)
    {
        $query = "
				insert into	DAT_CUST_MILEAGE    /*  > etah_mfront > member_m > regist_member_mileage > ETAH 회원가입 마일리지 지급 */
				(CUST_NO,SAVE_MILEAGE_AMT, MILEAGE_AMT, REG_USER_CD)
				values(
					?, 2000, 2000, 246)
					on duplicate key update 
						CUST_NO= ?
						, SAVE_MILEAGE_AMT=SAVE_MILEAGE_AMT+ 2000
						, MILEAGE_AMT=MILEAGE_AMT+ 2000
			";
        $db = self::_master_db();
        return $db->query($query, array($cust_No, $cust_No));
    }

    public function regist_mileage($param){

        $query = "
				insert into	DAT_CUST_MILEAGE_SAVING   /*  > etah_mfront > member_m > regist_mileage > ETAH 회원가입 마일리지 지급 */
				(CUST_NO,ORDER_REFER_NO, ORDER_DT, MILEAGE_SAVING_AMT, SAVE_YN,
				 SAVE_DT, SAVING_REASON_GB_CD, SAVING_REASON_ETC, REG_USER_CD)
				values(
					?, ?, ?, 2000, 'Y', ?, 'EVENT', '2월 회원가입이벤트', 246)
			";
        $db = self::_master_db();
        return $db->query($query, array($param['CUST_NO'], $param['ORDER_REFER_NO'], $param['ORDER_DT'], $param['SAVE_DT']));
    }

    /**
     * 마일리지 적립 전 주문일시 조회
     */
    public function get_orderDate($orderReferNo)
    {
        $query = "
					select R.REG_DT   /*  > etah_mfront > member_m > get_orderDate > ETAH 마일리지 적립 전 주문일시 조회 */
					from DAT_ORDER_REFER R
					where R.ORDER_REFER_NO = ?
		";

        $sdb = self::_slave_db();
        $row = $sdb->query($query, array($orderReferNo))->row_array();

        return $row;
    }

    /**
     * 2018.04.12
     * 이메일 발송 로그 추가
     * JOIN - 회원가입, PASS - 비밀번호 재발급, ETC - 기타
     */
    public function Email_send_cust($param){

        if(!empty($param['tmp_password'])) {
            $pass = $param['tmp_password'];
        }else{
            $pass = null;
        }

        if($param['kind'] == 'join'){
            $param['kind'] = 'JOIN';
        }else if($param['kind'] == 'id_pass'){
            $param['kind'] = 'PASS';
        }else{
            $param['kind'] = 'ETC';
        }
        $query = "
				INSERT INTO   /*  > etah_mfront > member_m > Email_send_cust > 이메일 발송 로그 */
				
				DAT_EMAIL_SEND (EMAIL, PASS_NO, CUST_ID, SEND_STS_CD)
                VALUES(?, PASSWORD(?), ?, ?)
			";
        $db = self::_master_db();
        $db->query("BEGIN");
        $result = $db->query($query, array($param['mem_email'],$pass,$param['mem_id'],$param['kind']));
        if(!$result){
            $db->query("ROLLBACK");
            return false;
        }else{
            $db->query("COMMIT");
            return true;
        }
    }

    /**
     * 2018.05.28
     * 간편 로그인 네이버
     */
    public function login_sns_naver($param){

        $query = "  
              select  /*  > etah_mfront > member_m > login_sns_naver > 간편 로그인 네이버 */
                    s.SNS_NO
                  , s.CUST_NO
                  , s.CUST_ID
                  , s.SNS_ID
                  , s.SNS_KIND_CD
                  , s.SNS_NM
                  , s.USE_YN 
                  
              from DAT_CUST_SNS s 
              
              inner join DAT_CUST c
              on c.CUST_NO = s.CUST_NO
              and c.USE_YN = 'Y'
              
              where s.SNS_ID =  ?
              and s.SNS_KIND_CD = 'N'
              and s.USE_YN = 'Y'
        ";

        $sdb = self::_slave_db();
        $row = $sdb->query($query, array($param))->row_array();

        return $row;
    }
    /**
     * 간편 로그인 카카오
     */
    public function login_sns_kakao($param){

        $query = "  
              select    /*  > etah_mfront > member_m > login_sns_kakao > 간편 로그인 카카오 */
                    s.SNS_NO  
                  , s.CUST_NO
                  , s.CUST_ID
                  , s.SNS_ID
                  , s.SNS_KIND_CD
                  , s.SNS_NM
                  , s.USE_YN 
                  
              from DAT_CUST_SNS s 
              
              inner join DAT_CUST c
              on c.CUST_NO = s.CUST_NO
              and c.USE_YN = 'Y'
              
              where s.SNS_ID =  ?
              and s.SNS_KIND_CD = 'K'
              and s.USE_YN = 'Y'
        ";

        $sdb = self::_slave_db();
        $row = $sdb->query($query, array($param))->row_array();

        return $row;
    }
    /**
     * 간편 로그인 위메프
     */
    public function login_sns_wemap($param){

        $query = "  
              select    /*  > etah_mfront > member_m > login_sns_wemap > 간편 로그인 위메프 */
                    s.SNS_NO
                  , s.CUST_NO
                  , s.CUST_ID
                  , s.SNS_ID
                  , s.SNS_KIND_CD
                  , s.SNS_NM
                  , s.USE_YN 
                  
              from DAT_CUST_SNS s 
              
              inner join DAT_CUST c
              on c.CUST_NO = s.CUST_NO
              and c.USE_YN = 'Y'
              
              where s.SNS_ID =  ?
              and s.SNS_KIND_CD = 'W'
              and s.USE_YN = 'Y'
        ";

        $sdb = self::_slave_db();
        $row = $sdb->query($query, array($param))->row_array();

        return $row;
    }
    /**
     * sns 계정 로그인시 회원조회
     */
    public function get_member_info_sns($men_id){

        $query = "  
              select /*  > etah_mfront > member_m > get_member_info_sns > sns 계정 로그인시 회원조회 */
                  c.CUST_NO
				, c.CUST_LEVEL_CD
				, c.CUST_ID
				, c.CUST_NM
				, c.MOB_NO
				, c.EMAIL
				, c.SNS_YN 
			  from DAT_CUST c
              
              where 
               1 = 1
                and c.CUST_NO    = ?
                and c.USE_YN	 = 'Y'
        ";

        $sdb = self::_slave_db();
        $row = $sdb->query($query, array($men_id))->row_array();

        return $row;
    }

    /**
     * SNS용 회원가입
     */
    public function regist_member_s($param)
    {
        $query = "
			insert into DAT_CUST	( /*  > etah_mfront > member_m > regist_member_s > SNS용 회원가입 */
				  CUST_LEVEL_CD
				, CUST_ID
				, PW
				, CUST_NM
				, MOB_NO
				, MOB_REC_YN
				, EMAIL
				, EMAIL_REC_YN
				, SNS_YN	";
        if($param['mem_birth'] != 'N'){
            $query .= "
				, BIRTH_DY	";
        }
        if($param['mem_gender'] != 'N'){
            $query .= "
				, GENDER_GB_CD	";
        }
        if($param['petYn'] != 'C'){
            $query .= "
				, PET_YN	";
        }
        if($param['merry'] != 'C'){
            $query .= "
				, MERRY_YN	";
        }
        if($param['chk_rcmdId'] != ''){
            $query .= "
				, RCMD_ID	";
        }
        $query .= "
				, EMAIL_CERT_YN
			)
			values
			(
				  '01'
				, '".$param['mem_id']."'
				, null
				, '".$param['mem_name']."'
				, '".$param['mem_mobile1']."-".$param['mem_mobile2']."-".$param['mem_mobile3']."'
				, '".$param['Agree_yn']."'
				, '".$param['chk_email']."'
				, '".$param['Agree_yn']."'
                , '".$param['sns_yn']."'";
        if($param['mem_birth'] != 'N'){
            $query .= "
				, '".$param['mem_birth']."'	";
        }
        if($param['mem_gender'] != 'N'){
            $query .= "
				, '".$param['mem_gender']."' ";
        }
        if($param['petYn'] != 'C'){
            $query .= "
				, '".$param['petYn']."'	";
        }
        if($param['merry'] != 'C'){
            $query .= "
				, '".$param['merry']."' ";
        }
        if($param['chk_rcmdId'] != ''){
            $query .= "
				, '".$param['chk_rcmdId']."' ";
        }
        $query .= "
				, 'Y'
			)
		";

        $db = self::_master_db();
        $db->query($query);
        return $db->insert_id();
    }

    /**
     * sns 테이블 회원추가
     */
    public function regist_member_sns($param){

        $query="
        insert into DAT_CUST_SNS  (CUST_NO,CUST_ID,SNS_ID,SNS_NM,SNS_KIND_CD) /*  > etah_mfront > member_m > regist_member_sns > sns 테이블 회원추가 */
        
        values(?,?,?,?,?)";

        $db = self::_master_db();
        return $db->query($query, array($param['CUST_NO'],$param['CUST_ID'],$param['SNS_ID'],$param['SNS_NM'],$param['SNS_KIND_CD']));
    }

    /**
     * 일반회원 sns계정 연동.
     */
    public function member_sns_with($cust_no,$email){
        $query="
            update DAT_CUST c /*  > etah_mfront > member_m > member_sns_with > 일반회원 sns계정 연동. */
                set c.SNS_YN = 'Y'
                    ,c.EMAIL = ?
            where   c.CUST_NO = ?    
        ";

        $db = self::_master_db();
        return $db->query($query, array($email,$cust_no));
    }

    /**
     * sns회원탈퇴
     */
    public function update_sns_useyn($param)
    {

        $query = "
			update 	DAT_CUST_SNS /*  > etah_mfront > member_m > update_sns_useyn > sns회원탈퇴 */
			set 	USE_YN = 'N'

			where	SNS_NO = ?
		";

        $db = self::_master_db();
        return $db->query($query, $param);
    }

    /**
     * sns회원 구별
     */
    public function sns_gubun()
    {
        $param = $this->session->userdata('EMS_U_NO_');
        $query = "
			select * from DAT_CUST_SNS s /*  > etah_mfront > member_m > sns_gubun > sns회원 구별 */
		    where s.CUST_NO = ?
		    and s.USE_YN = 'Y'
		";

        $sdb = self::_slave_db();
        $row = $sdb->query($query, $param)->row_array();

        return $row;
    }


    public function isset_log_sns_code($param)
    {
        $query = "
            select * from LOG_SNS_APP_CODE s /*  > etah_mfront > member_m > isset_log_sns_code > 앱ID_LOG 유무 */
		    where s.ID = ?
        ";
        $db = self::_slave_db();
        return $db->query($query, $param)->row_array();
    }

    public function log_sns_code($param, $gubun)
    {
        $device = 'M';
        $query = "
            insert into LOG_SNS_APP_CODE(ID, SNS_KIND, DEVICE)  /*  > etah_mfront > member_m > log_sns_code > 앱ID_LOG */
            values(?, ?, ?)
        ";

        $db = self::_master_db();
        if($gubun == 'N'){
            $db->query($query, array($param['response']['id'],$gubun, $device));
        }else if($gubun == 'K'){
            $db->query($query, array($param['id'],$gubun, $device));
        }else if($gubun == 'W'){
            $db->query($query, array($param['mid'],$gubun, $device));
        }
        return true;
    }

    public function get_cust_info($param)
    {
        $query = " 
            select s.CUST_NO    /*  > etah_mfront > member_m > get_cust_info > 카카오 회원코드 조회 */
            from DAT_CUST s
            where s.CUST_ID = ?
            and s.USE_YN = 'Y'
            and s.SNS_YN = 'Y'
        ";
        $db = self::_slave_db();
        return $db->query($query, $param)->row_array();
    }

    /**
     * 2018.11.21
     * 간편 로그인시 이메일과. 기존 회원들 이메일 비교.
     *
     */
    public function sns_email_match($email)
    {
        $query = "
			      select     /*  > etah_mfront > member_m > sns_email_match > 간편 로그인시 이메일과. 기존 회원들 이메일 비교. */
			      * 
			      from DAT_CUST c 
			      where c.EMAIL = '".$email."'
			            and c.USE_YN = 'Y'
		";

        $sdb = self::_slave_db();
        $row = $sdb->query($query)->row_array();

        return $row;
    }

    /**
     * 회원가입 마일리지 적립
     */
    public function insert_mileage_default($cust_no, $mileage){
        $db = self::_master_db();

        $query1 = "
				insert into	DAT_CUST_MILEAGE     /*  > etah_mfront > member_m > insert_mileage_default > 회원가입 마일리지 적립 */
				(CUST_NO,SAVE_MILEAGE_AMT, MILEAGE_AMT, REG_USER_CD)
				values(?, $mileage, $mileage, 1)
			";

        $db->query($query1, $cust_no);

        $query2 = "
				insert into	DAT_CUST_MILEAGE_SAVING    /*  > etah_mfront > member_m > insert_mileage_default > 회원가입 마일리지 적립 */
				(CUST_NO, MILEAGE_SAVING_AMT, SAVE_YN,
				 SAVE_DT, SAVING_REASON_GB_CD, SAVING_REASON_ETC, REG_USER_CD)
				values(
					?, $mileage, 'Y', now(), 'EVENT', '회원가입 축하 이벤트', 1)
			";

        $db->query($query2, $cust_no);

        $query3 = "
				update DAT_CUST   /*  > etah_mfront > member_m > insert_mileage_default > 회원가입 마일리지 적립 */
				set DEFAULT_MILEAGE ='Y'
				where CUST_NO = ?
			";

        $db->query($query3, $cust_no);

//        $timenow = date("Y-m-d H:i:s");
//        $timetarget = "2019-09-17 14:00:00";
//        $timetarget2 = "2019-09-23 23:59:59";
//
//        $str_now = strtotime($timenow);
//        $str_target = strtotime($timetarget);
//        $str_target2 = strtotime($timetarget2);
//
//        if($str_target < $str_now && $str_now < $str_target2) {
//
//            $query4 = "insert into MAP_COUPON_APPLICATION_SCOPE_OBJECT(COUPON_CD, COUPON_APPLICATION_SCOPE_OBJECT_CD,REG_USER_CD)
//                  values(1337750,?,14)";
//
//            $db->query($query4, $cust_no);
//
//            $query5 = "insert into MAP_COUPON_APPLICATION_SCOPE_OBJECT(COUPON_CD, COUPON_APPLICATION_SCOPE_OBJECT_CD,REG_USER_CD)
//              values(1337751,?,14)";
//
//            $db->query($query5, $cust_no);
//
//            $query6 = "insert into MAP_COUPON_APPLICATION_SCOPE_OBJECT(COUPON_CD, COUPON_APPLICATION_SCOPE_OBJECT_CD,REG_USER_CD)
//              values(1337752,?,14)";
//
//            $db->query($query6, $cust_no);
//
//            $query7 = "insert into DAT_CUST_COUPON(CUST_NO,COUPON_CD,COUPON_GET_CD,REG_USER_CD)
//                  values(?, 1337750,'01',14)";
//
//            $db->query($query7, $cust_no);
//
//            $query8 = "insert into DAT_CUST_COUPON(CUST_NO,COUPON_CD,COUPON_GET_CD,REG_USER_CD)
//              values(?, 1337751,'01',14)";
//
//            $db->query($query8, $cust_no);
//
//            $query9 = "insert into DAT_CUST_COUPON(CUST_NO,COUPON_CD,COUPON_GET_CD,REG_USER_CD)
//              values(?, 1337752,'01',14)";
//
//            $db->query($query9, $cust_no);
//        }


//        $timenow = date("Y-m-d H:i:s");
//        $timetarget = "2019-01-31 15:57:00";
//        $timetarget2 = "2019-02-07 23:59:59";
//
//        $str_now = strtotime($timenow);
//        $str_target = strtotime($timetarget);
//        $str_target2 = strtotime($timetarget2);
//
//        if($str_target < $str_now && $str_now < $str_target2) {
//
//            $query4 = "insert into MAP_COUPON_APPLICATION_SCOPE_OBJECT(COUPON_CD, COUPON_APPLICATION_SCOPE_OBJECT_CD,REG_USER_CD)
//                  values(1218191,?,14)";
//
//            $db->query($query4, $cust_no);
////        log_message("DEBUG", "===========CUST_NO1 = ".$db->last_query());
//
//            $query5 = "insert into MAP_COUPON_APPLICATION_SCOPE_OBJECT(COUPON_CD, COUPON_APPLICATION_SCOPE_OBJECT_CD,REG_USER_CD)
//                  values(1218192,?,14)";
//
//            $db->query($query5, $cust_no);
////        log_message("DEBUG", "===========CUST_NO2 = ".$db->last_query());
//            $query6 = "insert into MAP_COUPON_APPLICATION_SCOPE_OBJECT(COUPON_CD, COUPON_APPLICATION_SCOPE_OBJECT_CD,REG_USER_CD)
//                  values(1218193,?,14)";
//
//            $db->query($query6, $cust_no);
////        log_message("DEBUG", "===========CUST_NO3 = ".$db->last_query());
//            $query7 = "insert into DAT_CUST_COUPON(CUST_NO,COUPON_CD,COUPON_GET_CD,REG_USER_CD)
//                  values(?, 1218191,'01',14)";
//
//            $db->query($query7, $cust_no);
////        log_message("DEBUG", "===========CUST_NO5 = ".$db->last_query());
//            $query8 = "insert into DAT_CUST_COUPON(CUST_NO,COUPON_CD,COUPON_GET_CD,REG_USER_CD)
//                  values(?, 1218192,'01',14)";
//
//            $db->query($query8, $cust_no);
////        log_message("DEBUG", "===========CUST_NO6 = ".$db->last_query());
//            $query9 = "insert into DAT_CUST_COUPON(CUST_NO,COUPON_CD,COUPON_GET_CD,REG_USER_CD)
//                  values(?, 1218193,'01',14)";
//
//            $db->query($query9, $cust_no);
////        log_message("DEBUG", "===========CUST_NO7 = ".$db->last_query());

//        }
        return true;
    }

    /**
     * SMS/KAKAO 발송 (다우)
     * 즉시발송
     */
    public function reg_send_sms($type, $param)
    {
        $db = self::_sms_db();

        $result = null;

        if($type == 'SMS'){
            $query = " INSERT INTO uds_msg /* etah_mfront > member_m > reg_send_sms > SMS발송 ( SMS ) */
							 (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE, MSG_BODY)
							 VALUES
							 (0, concat(now()+0, '".$param['DEST_PHONE']."' ) , now(), now(), '".$param['DEST_PHONE']."', '15225572', '".$param['MSG']."')";
            $result = $db->query($query);
        }

        if($type == 'KAKAO'){
            $query = " INSERT INTO biz_msg /* etah_mfront > member_m > reg_send_sms > SMS발송 ( KAKAO ) */
							 (MSG_TYPE
								  , CMID
								  , REQUEST_TIME
								  , SEND_TIME
								  , DEST_PHONE
								  , SEND_PHONE
								  , MSG_BODY
								  , TEMPLATE_CODE
								  , SENDER_KEY
								  , ATTACHED_FILE
								  , NATION_CODE 
							  ) VALUES ( 
							  	  6
								  , concat(now()+0, ? )
								  , NOW()
								  , NOW()
								  , ?
								  , ?
								  , ?
								  , ?
								  , ?
								  , ?
								  , '82' 
								  ) ";
            $result = $db->query( $query, array( $param['DEST_PHONE'], $param['DEST_PHONE'], 15225572, $param['MSG'], $param['KAKAO_TEMPLATE_CODE'], $param['KAKAO_SENDER_KEY'], $param['KAKAO_ATTACHED_FILE'] ) );
        }

        return $result;
    }
}