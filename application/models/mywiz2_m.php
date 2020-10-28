<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mywiz2_m extends CI_Model {

	protected $_ci;
	protected $mdb;
	protected $sdb;

	public function __construct()
	{
		parent::__construct();
		$this->_ci =& get_instance();
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
	 * 고객별 쿠폰 개수
	 */
	 public function get_coupon_count_by_cust()
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');

		$query = "
			select	/*  > etah_mfront > mywiz2_m > get_coupon_count_by_cust > ETAH 고객별 쿠폰 개수*/
					count(cc.CUST_COUPON_NO) as COUPON
			from	DAT_CUST_COUPON			cc
				inner join	DAT_COUPON			c
					on	cc.COUPON_CD		= c.COUPON_CD
					and	c.USE_YN			= 'Y'
				inner join	DAT_COUPON_PROGRESS		cp
					on cp.COUPON_PROGRESS_NO		= c.COUPON_PROGRESS_NO
					and cp.COUPON_PROGRESS_STS_CD	= '03'
					and cp.USE_YN					= 'Y'
			where 	cc.CUST_NO 				= '".$cust_no."'
			and		c.COUPON_END_DT >= DATE_FORMAT(CURDATE( ), '%Y-%m-%d' )
			and		cc.USE_YN  = 'Y'

		";

		$db = self::_slave_db();
		$data = $db->query($query)->row_array();
		return $data['COUPON'];
	}

	/**
	 * 고객별 잔여 마일리지
	 */
	 public function get_mileage_by_cust()
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');

		$query = "
			select	/*  > etah_mfront > mywiz2_m > get_mileage_by_cust > ETAH 고객별 잔여 마일리지*/
					m.MILEAGE_AMT
			from	DAT_CUST_MILEAGE	m
			where 	m.CUST_NO			= '".$cust_no."'

		";

		$db = self::_slave_db();
		$data = $db->query($query)->row_array();
		$data['MILEAGE_AMT'] = empty($data['MILEAGE_AMT']) ? 0 : $data['MILEAGE_AMT'];

		return $data['MILEAGE_AMT'];
	}

	/**
	 * 주문상태 정보
	 */
	 public function get_order_state_by_cust_no()
	{
		$cust_id = $this->session->userdata('EMS_U_ID_');
		$cust_no = $this->session->userdata('EMS_U_NO_');

		/* 비회원 구분 */
		if($cust_id == "GUEST"){
			$query_cust = "and o.ORDER_NO = '".$cust_no."'";
			$param['date_type'] = -1;
		}else{
			$query_cust = "and o.CUST_NO = '".$cust_no."'";
		}

		$query = "
			select	/*  > etah_mfront > mywiz2_m > get_order_state_by_cust_no > ETAH 주문 상태 정보 구하기 */
				ifnull(sum(if(s.ORDER_REFER_PROC_STS_CD in ('OA00', 'OA01', 'OA02', 'OA03', 'OB01', 'OB02', 'OB03', 'OE01', 'OE02'), '1', '0')),0)	as A /* 주문/배송조회 */
				, ifnull(sum(if(s.ORDER_REFER_PROC_STS_CD in ('OC01', 'OC02' ,'OC21','OC22','OR01','OR02','OR03','OR04','OR11','OR12','OR13','OR21','OR22', 'OB02', 'OB03'), '1', '0')),0)	as F	/* 취소/교환/반품 */
			from
				DAT_ORDER o
				inner join	DAT_ORDER_REFER 			r
					on o.ORDER_NO						= r.ORDER_NO
				inner join	DAT_ORDER_REFER_PROGRESS 	rp
					on 	r.ORDER_REFER_NO				= rp.ORDER_REFER_NO
					and r.ORDER_REFER_PROC_STS_NO 		= rp.ORDER_REFER_PROC_STS_NO
				inner join	COD_ORDER_REFER_PROC_STS_CD s
					on 	rp.ORDER_REFER_PROC_STS_CD		= s.ORDER_REFER_PROC_STS_CD
			where
				1 = 1
			$query_cust
		";

		$db = self::_slave_db();
		return $db->query($query)->row_array();
	}

	/**
	 * 회원 정보 데이터 구하기
	 */
	 public function get_member_info_by_cust_no()
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');

		$query = "
			select	/*  > etah_mfront > mywiz2_m > get_member_info_by_cust_no > ETAH 회원정보 구하기 */
					 c.CUST_ID
					, c.CUST_NM
					, c.MOB_NO
					, c.MOB_REC_YN
					, c.EMAIL
					, c.EMAIL_REC_YN
					, c.BIRTH_DY
					, c.ZIPCODE
					, c.ADDR1
					, c.ADDR2
					, c.GENDER_GB_CD

			from	DAT_CUST c
			where 	c.CUST_NO = '".$cust_no."'
		";

		$db = self::_slave_db();
		return $db->query($query)->row_array();
	}

	/**
	 * 회원 정보 수정
	 */
	 public function update_member_info($param)
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');

		$query = "
			update 	DAT_CUST      /*  > etah_mfront > mywiz2_m > update_member_info > ETAH 회원 정보 수정 */

			set 	PW 	= PASSWORD('".$param['member_pw']."')
					, MOB_NO = '".$param['mob_phone']."'
					, MOB_REC_YN = '".$param['sns']."'
					, EMAIL_REC_YN = '".$param['email']."'
					, BIRTH_DY = '".$param['member_birth']."'

			where 	CUST_NO = '".$cust_no."'
			and 	USE_YN = 'Y'
		";
//var_dump($query);
		$db = self::_master_db();
		return $db->query($query);
	}

	/**
	 * 배송지관리
	 */
	 public function get_delivery_list($param)
	{
		$query_limit = "";

		if(isset($param['limit_num_rows'])){
			$limit_num_rows         = $param['limit_num_rows'];
			$startPos               = ($param['page'] - 1) * $limit_num_rows;

			if($limit_num_rows)	$query_limit = "limit $startPos, $limit_num_rows ";
		}

		$cust_no = $this->session->userdata('EMS_U_NO_');

		$query = "
			select	/*  > etah_mfront > mywiz2_m > get_delivery_list > ETAH 배송지관리 */
					d.CUST_DELIV_ADDR_NO
					, d.CUST_DELIV_ADDR_NM
					, d.RECV_NM
					, d.MOB_NO
					, d.ZIPCODE
					, d.ADDR1
					, d.ADDR2
					, d.BASE_DELIV_ADDR_YN

			from	DAT_CUST_DELIV_ADDR d


			where	d.CUST_NO = '".$cust_no."'
			and		d.USE_YN = 'Y'

			order by d.BASE_DELIV_ADDR_YN desc, d.REG_DT desc

			$query_limit

		";

		$db = self::_slave_db();
		return $db->query($query)->result_array();
	}

	/**
	 * 배송지 개수
	 */
	 public function get_delivery_list_count($param)
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');

		$query = "
			select	/*  > etah_mfront > mywiz2_m > get_delivery_list_count > ETAH 배송지 개수 */
					count(d.CUST_DELIV_ADDR_NO)			as total_cnt

			from	DAT_CUST_DELIV_ADDR d

			where	d.CUST_NO = '".$cust_no."'
			and		d.USE_YN = 'Y'

		";

		$db = self::_slave_db();
		$data = $db->query($query)->row_array();
		return $data['total_cnt'];
	}

	/**
	 * 배송지 등록
	 */
	 public function register_delivery($param)
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');

		$query = "
			insert into DAT_CUST_DELIV_ADDR   /*  > etah_mfront > mywiz2_m > register_delivery > ETAH 배송지 등록 */
			(
				CUST_NO
				, CUST_DELIV_ADDR_NM
				, RECV_NM
				, MOB_NO
				, ZIPCODE
				, ADDR1
				, ADDR2
				, BASE_DELIV_ADDR_YN
			)
			 values
			(
				'".$cust_no."'
				, '".$param['delivery_nm']."'
				, '".$param['receiver_nm']."'
				, '".$param['phone']."'
				, '".$param['post_no']."'
				, '".$param['address1']."'
				, '".$param['address2']."'
				, 'N'

			)
		";

		$db = self::_master_db();
		return $db->query($query);
	}

	/**
	 * 배송지 업데이트
	 */
	 public function update_delivery($param)
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');

		$query = "
			update	DAT_CUST_DELIV_ADDR    /*  > etah_mfront > mywiz2_m > update_delivery > ETAH 배송지 업데이트 */
			set		CUST_DELIV_ADDR_NM	= '".$param['delivery_nm']."'
					, RECV_NM			= '".$param['receiver_nm']."'
					, MOB_NO			= '".$param['phone']."'
					, ZIPCODE			= '".$param['post_no']."'
					, ADDR1				= '".$param['address1']."'
					, ADDR2				= '".$param['address2']."'
			where	CUST_NO				= '".$cust_no."'
			and		CUST_DELIV_ADDR_NO	= '".$param['deliv_no']."'
		";

		$db = self::_master_db();
		return $db->query($query);
	}

	/**
	 * 배송지 삭제
	 */
	 public function delete_delivery($deliv_no)
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');

		$query = "
			update	DAT_CUST_DELIV_ADDR   /*  > etah_mfront > mywiz2_m > delete_delivery > ETAH 배송지 삭제 */
			set		USE_YN = 'N'
			where	CUST_NO = '".$cust_no."'
			and		CUST_DELIV_ADDR_NO = '".$deliv_no."'
		";

		$db = self::_master_db();
		return $db->query($query);
	}

	/**
	 * 기본배송지 설정
	 */
	 public function update_base_delivery($base_yn, $deliv_no = null)
	{
		$query_delivery = "";
		$cust_no = $this->session->userdata('EMS_U_NO_');

		if($deliv_no) $query_delivery = "and		CUST_DELIV_ADDR_NO = '".$deliv_no."'";

		$query = "
			update	DAT_CUST_DELIV_ADDR   /*  > etah_mfront > mywiz2_m > update_base_delivery > ETAH 기본배송지 설정 */
			set		BASE_DELIV_ADDR_YN = '".$base_yn."'
			where	CUST_NO = '".$cust_no."'
			$query_delivery
		";

		$db = self::_master_db();
		return $db->query($query);
	}

	/**
	 * 관심상품
	 */
	 public function get_interest_list($param)
	{
		$limit_num_rows         = $param['limit_num_rows'];
        $startPos               = ($param['page'] - 1) * $limit_num_rows;

		if($limit_num_rows)	$query_limit = "limit $startPos, $limit_num_rows ";

		$cust_no = $this->session->userdata('EMS_U_NO_');

		$query = "
			select	/*  > etah_mfront > mywiz2_m > get_interest_list > ETAH 관심상품 */
				ig.INTEREST_GOODS_NO
				, g.GOODS_CD
				, g.GOODS_NM
				, b.BRAND_CD
				, b.BRAND_NM
				, max(dpp.DELIV_COST_DECIDE_VAL)		as DELI_LIMIT
				, max(dpp.DELIV_COST)					as DELI_COST
				, gi.IMG_URL
				, pri.SELLING_PRICE
			from
				DAT_INTEREST_GOODS 		ig
			inner join	DAT_GOODS					g
				on 	ig.GOODS_CD						= g.GOODS_CD
			inner join	DAT_BRAND					b
				on	g.BRAND_CD						= b.BRAND_CD
			inner join	DAT_GOODS_PRICE				pri
				on	g.GOODS_CD						= pri.GOODS_CD
				and	g.GOODS_PRICE_CD				= pri.GOODS_PRICE_CD
			inner join	DAT_GOODS_PROGRESS			p
				on	p.GOODS_PROGRESS_NO				= g.GOODS_PROGRESS_NO
				and p.USE_YN						= 'Y'
				and p.GOODS_STS_CD					= '03'
			inner join	DAT_GOODS_IMAGE				gi
				on	g.GOODS_CD						= gi.GOODS_CD
				and gi.TYPE_CD						= 'TITLE'
			inner join	DAT_DELIV_POLICY			dp
				on	dp.DELIV_POLICY_NO				= g.DELIV_POLICY_NO
				and dp.USE_YN						= 'Y'

			left join	DAT_DELIV_POLICY_PATTERN	dpp
				on dp.DELIV_POLICY_NO				= dpp.DELIV_POLICY_NO
			where
				ig.CUST_NO ='".$cust_no."'
				and ig.USE_YN = 'Y'
			group by
				ig.GOODS_CD
			order by
				ig.INTEREST_GOODS_NO desc
			$query_limit

		";
//var_dump($query);
		$db = self::_slave_db();
		return $db->query($query)->result_array();
	}

	/**
	 * 관심상품 개수구하기
	 */
	 public function get_interest_list_count()
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');

		$query = "
			select	/*  > etah_mfront > mywiz2_m > get_interest_list_count > ETAH 관심상품 개수구하기*/
				count(g.GOODS_CD)					as total_cnt
			from
				DAT_INTEREST_GOODS 		ig
			inner join	DAT_GOODS					g
				on 	ig.GOODS_CD						= g.GOODS_CD
			inner join	DAT_BRAND					b
				on	g.BRAND_CD						= b.BRAND_CD
			inner join	DAT_GOODS_PRICE				pri
				on	g.GOODS_CD						= pri.GOODS_CD
				and	g.GOODS_PRICE_CD				= pri.GOODS_PRICE_CD
			inner join	DAT_GOODS_PROGRESS			p
				on	p.GOODS_PROGRESS_NO				= g.GOODS_PROGRESS_NO
				and p.USE_YN						= 'Y'
				and p.GOODS_STS_CD					= '03'
			inner join	DAT_GOODS_IMAGE				gi
				on	g.GOODS_CD						= gi.GOODS_CD
				and gi.TYPE_CD						= 'TITLE'
			where
				ig.CUST_NO ='".$cust_no."'
				and ig.USE_YN = 'Y'

		";

		$db = self::_slave_db();
		$data = $db->query($query)->row_array();
		return $data['total_cnt'];
	}

	/**
	 * 관심상품 체크
	 */
	public function get_wish_list_by_cust_no_n_goods_cd($param, $use_yn)
	{
		 $query = "
			select	/*  > etah_mfront > mywiz2_m > get_wish_list_by_cust_no_n_goods_cd > ETAH 관심상품 체크 */
				 CUST_NO
			from
				DAT_INTEREST_GOODS
			where
				CUST_NO	 = '".$param['cust_no']."'
			and GOODS_CD = '".$param['goods_cd']."'
			and USE_YN	 = '".$use_yn."'
		";

		$db = self::_slave_db();
		return $db->query($query)->row_array();
	}

	/**
	 * 관심상품 추가
	 */
	 public function register_add_wish_list($param)
	{
		 $query = "
			insert into	DAT_INTEREST_GOODS	(   /*  > etah_mfront > mywiz2_m > register_add_wish_list > ETAH 관심상품 추가 */
				  CUST_NO
				, GOODS_CD
			--	, REG_USER_CD
			--	, UPD_USER_CD
			)
			values
			(
				  '".$param['cust_no']."'
				, '".$param['goods_cd']."'
			--	, '".$param['cust_no']."'
			--	, '".$param['cust_no']."'
			)
					";

		$db = self::_master_db();
		return $db->query($query);
	}

	/**
	 * 관심상품 삭제 / 삭제됐던 상품 다시 추가.
	 */
	 public function update_interest($param, $use_yn)
	{
		 $query = "
			update	DAT_INTEREST_GOODS      /*  > etah_mfront > mywiz2_m > update_interest > 관심상품 삭제/재추가 */
			set		USE_YN				= '".$use_yn."'
			where	GOODS_CD			= '".$param['goods_cd']."'
			and 	CUST_NO				= '".$param['cust_no']."'
		";

		$db = self::_master_db();
		return $db->query($query);
	}

	/**
	 * 주문상태 정보 limit 1
	 */
	public function get_order_state_by_cust_no_limit1()
	{
		$query_cust = "";

		$cust_id = $this->session->userdata('EMS_U_ID_');
		$cust_no = $this->session->userdata('EMS_U_NO_');

		/* 비회원 구분 */
		if($cust_id == "GUEST"){
			$query_cust = "and o.ORDER_NO = '".$cust_no."'";
			$param['date_type'] = -1;
		}else{
			$query_cust = "and o.CUST_NO = '".$cust_no."'";
		}

		$query = "
			select     /*  > etah_mfront > mywiz2_m > get_order_state_by_cust_no_limit1 > 주문상태 정보 limit 1 */
				o.ORDER_NO
				, r.ORDER_REFER_NO
				, p.ORDER_REFER_PROC_STS_NO
				, p.ORDER_REFER_PROC_STS_CD as pCD
				, p.REG_DT
				, p.UPD_DT
			from DAT_ORDER o
				inner join DAT_ORDER_REFER r
					on r.ORDER_NO = o.ORDER_NO
				inner join DAT_ORDER_REFER_PROGRESS p
					on p.ORDER_REFER_PROC_STS_NO = r.ORDER_REFER_PROC_STS_NO
					and p.USE_YN = 'Y'
			where 1=1
			$query_cust

			order by p.REG_DT desc

			limit 1
			;
		";
//		var_dump($query);
		$db = self::_master_db();
		return $db->query($query)->row_array();

	}



}