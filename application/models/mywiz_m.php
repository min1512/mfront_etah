<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mywiz_m extends CI_Model {

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
     * 고객별 쿠폰 개수
     */
    public function get_coupon_count_by_cust()
    {
        $cust_no = $this->session->userdata('EMS_U_NO_');

        $query = "
			select	/*  > etah_mfront > mywiz_m > get_coupon_count_by_cust > ETAH 고객별 쿠폰 개수*/
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
			and		c.COUPON_END_DT >= now()
			and 	c.COUPON_START_DT <= now()
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
			select	/*  > etah_mfront > mywiz_m > get_mileage_by_cust > ETAH 고객별 잔여 마일리지*/
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
			select	/*  > etah_mfront > mywiz_m > get_order_state_by_cust_no > ETAH 주문 상태 정보 구하기 */
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
			select	/*  > etah_mfront > mywiz_m > get_member_info_by_cust_no > ETAH 회원정보 구하기 */
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
					, c.PET_YN
					, c.MERRY_YN
					, c.RCMD_ID

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
			update 	DAT_CUST    /*  > etah_mfront > mywiz_m > update_member_info > ETAH 회원정보 수정 */

			set 	PW 	= PASSWORD('".$param['member_pw']."')
					, MOB_NO = '".$param['mob_phone']."'
					, MOB_REC_YN = '".$param['sns']."'
					, EMAIL_REC_YN = '".$param['email']."'
					, BIRTH_DY = '".$param['member_birth']."'
			";
        if($param['mem_gender'] != 'NULL'){
            $query .= ",GENDER_GB_CD = '".$param['mem_gender']."'";
        }
        if($param['petYn'] != 'NULL'){
            $query .= ",PET_YN = '".$param['petYn']."'";
        }
        if($param['merry'] != 'NULL'){
            $query .= ",MERRY_YN = '".$param['merry']."'";
        }
        if($param['chk_rcmdId'] != ''){
            $query .= ", RCMD_ID = '".$param['chk_rcmdId']."'";
        }

        $query .= "where 	CUST_NO = '".$cust_no."'
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
			select	/*  > etah_mfront > mywiz_m > get_delivery_list > ETAH 배송지관리 */
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
			select	/*  > etah_mfront > mywiz_m > get_delivery_list_count > ETAH 배송지 개수 */
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
			insert into DAT_CUST_DELIV_ADDR   	/*  > etah_mfront > mywiz_m > register_delivery > ETAH 배송지 등록 */
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
			update	DAT_CUST_DELIV_ADDR     	/*  > etah_mfront > mywiz_m > update_delivery > ETAH 배송지 업데이트 */
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
			update	DAT_CUST_DELIV_ADDR     	/*  > etah_mfront > mywiz_m > delete_delivery > ETAH 배송지 삭제 */
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
			update	DAT_CUST_DELIV_ADDR     	/*  > etah_mfront > mywiz_m > update_base_delivery > ETAH 기본배송지 설정 */
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
			select	/*  > etah_mfront > mywiz_m > get_interest_list > ETAH 관심상품 */
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
			select	/*  > etah_mfront > mywiz_m > get_interest_list_count > ETAH 관심상품 개수구하기*/
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
			select	/*  > etah_mfront > mywiz_m > get_wish_list_by_cust_no_n_goods_cd > ETAH 관심상품 체크 */
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
			insert into	DAT_INTEREST_GOODS	(     /*  > etah_mfront > mywiz_m > register_add_wish_list > ETAH 관심상품 추가 */
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
			update	DAT_INTEREST_GOODS      /*  > etah_mfront > mywiz_m > update_interest > ETAH 관심상품 삭제/재추가 */
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
			select     /*  > etah_mfront > mywiz_m > get_order_state_by_cust_no_limit1 > ETAH 주문상태 정보 limit 1 */
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

    /**
     * 문의등록
     */
    public function regist_qna($param, $gubun)
    {
        if($gubun == 'T'){
            $query = "
				insert into DAT_CS	(    /*  > etah_mfront > mywiz_m > regist_qna > ETAH 문의등록 */
					  CS_QUE_GB_CD
					, CS_QUE_TYPE_CD
					, CUST_NO
					, QUE_CUST_NM
					, QUE_CUST_PHONE_NO
					, QUE_DT
					, EMAIL
					, SECRET_YN
				)
				values
				(
					  '02'
					, '".$param['qna_type']."'
					, '".$param['mem_no']."'
					, '".$param['mem_name']."'
					, '".$param['mem_mobile']."'
					, '".$param['date']."'
					, '".$param['mem_email']."'
					, '".$param['secret_yn']."'
				)
			";

            $db = self::_master_db();
            $result = $db->query($query);
            $rs_identity = $db->insert_id();

            return $rs_identity;

        } else if($gubun == 'C'){
            $query = "
				insert into	DAT_CS_CONTENTS_REPLY	(   /*  > etah_mfront > mywiz_m > regist_qna > ETAH 문의답변등록 */
					  CS_NO
					, KIND
					, TITLE
					, CONTENTS
				)
				values
				(
					  '".$param['qna_no']."'
					, 'Q'
					, '".$param['title']."'
					, '".$param['contents']."'
				)
			";

            $db = self::_master_db();
            return $db->query($query);
        }

    }

    /**
     * 문의등록
     */
    public function regist_map_qna_N_goods($param)
    {
        $query = "
			insert into	MAP_CS_N_GOODS	(    /*  > etah_mfront > mywiz_m > regist_map_qna_N_goods > ETAH 문의 상품 매핑 */
				  CS_NO
				, GOODS_CD
			)
			values
			(
				  '".$param['qna_no']."'
				, '".$param['goods_code']."'
			)
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * Q&A 리스트
     */
    public function get_qna_list($param)
    {
        $cust_no		= $this->session->userdata('EMS_U_NO_');
        $limit_num_rows = $param['limit_num_rows'];
        $startPos       = ($param['page'] - 1) * $limit_num_rows;
        $query_date		= "";

        if($limit_num_rows)		$query_limit = "limit $startPos, $limit_num_rows ";
        if($param['date_type']>=0) $query_date = "and cs.REG_DT between '".$param['date_from']." 00:00:00' and '".$param['date_to']." 23:59:59'";

        $query = "
			select	/*  > etah_mfront > mywiz_m > get_qna_list > ETAH Q&A 리스트 */
				cs.CS_NO
				, gb.CS_QUE_GB_CD
				, gb.CS_QUE_GB_CD_NM
				, tp.CS_QUE_TYPE_CD
				, tp.CS_QUE_TYPE_CD_NM
				, cs.CUST_NO
				, cs.QUE_CUST_NM
				, cs.FILE_PATH
				, rpQ.CS_CONTENTS_REPLY_NO		as Q_NO
				, rpQ.TITLE						as Q_TITLE
				, rpQ.`CONTENTS`				as Q_CONTENTS
				, left(rpQ.REG_DT, 11)			as Q_REG_DT
				, rpA.CS_CONTENTS_REPLY_NO		as A_NO
				, rpA.TITLE						as A_TITLE
				, rpA.`CONTENTS`				as A_CONTENTS
				, left(rpA.REG_DT, 11)			as A_REG_DT
				, u.UPD_USER_CD
				, u.USER_NM
				, left(cs.REG_DT, 11)			as REG_DT
				, g.GOODS_CD
				, g.GOODS_NM
				, g.PROMOTION_PHRASE
				, b.BRAND_NM
				, gi.IMG_URL
				, r.GOODS_CD					as ORDER_GOODS_CD
				, r.GOODS_NM					as ORDER_GOODS_NM
				, r.GOODS_OPTION_NM				as ORDER_GOODS_OPTION_NM
				, ri.IMG_URL					as ORDER_GOODS_IMG_URL
				, rb.BRAND_NM					as ORDER_BRAND_NM
			from
				DAT_CS 	cs
			inner join	COD_CS_QUE_GB_CD 		gb
				on	cs.CS_QUE_GB_CD 			= gb.CS_QUE_GB_CD
			inner join	COD_CS_QUE_TYPE_CD 		tp
				on 	cs.CS_QUE_TYPE_CD 			= tp.CS_QUE_TYPE_CD
			inner join	DAT_CS_CONTENTS_REPLY 	rpQ
				on	cs.CS_NO					= rpQ.CS_NO
				and rpQ.KIND 					= 'Q'
			left join	MAP_CS_N_GOODS 			m
				on	m.CS_NO						= cs.CS_NO
			left join	DAT_GOODS				g
				on 	m.GOODS_CD					= g.GOODS_CD
			left join	DAT_GOODS_IMAGE			gi
				on 	g.GOODS_CD					= gi.GOODS_CD
				and gi.TYPE_CD					= 'TITLE'
			left join	DAT_BRAND				b
				on	b.BRAND_CD					= g.BRAND_CD
			left join	DAT_CS_CONTENTS_REPLY	rpA
				on	cs.CS_NO					= rpA.CS_NO
				and rpA.KIND					= 'A'
			left join	DAT_USER				u
				on	cs.UPD_USER_CD				= u.USER_CD
			left join	MAP_CS_N_ORDER_REFER 	mo
				on	cs.CS_NO					= mo.CS_NO
			left join	DAT_ORDER_REFER			r
				on	mo.ORDER_REFER_NO			= r.ORDER_REFER_NO
			left join	DAT_GOODS_IMAGE			ri
				on	r.GOODS_CD					= ri.GOODS_CD
				and ri.TYPE_CD					= 'TITLE'
			left join	DAT_GOODS				rg
				on 	r.GOODS_CD					= rg.GOODS_CD
			left join	DAT_BRAND				rb
				on	rg.BRAND_CD					= rb.BRAND_CD
			where
				cs.CUST_NO = '".$cust_no."'
			and cs.CS_QUE_GB_CD = '".$param['gb']."'
			and	cs.USE_YN = 'Y'
			$query_date
			order by
				cs.REG_DT desc
			$query_limit

		";

        $db = self::_slave_db();
//var_dump($query);
        return $db->query($query)->result_array();
    }

    /**
     * Q&A 리스트 개수구하기
     */
    public function get_qna_list_count($param)
    {
        $cust_no	= $this->session->userdata('EMS_U_NO_');
        $query_date	= "";

//		var_dump($param['date_type']);

        if($param['date_type']>=0) $query_date = "and cs.REG_DT between '".$param['date_from']." 00:00:00' and '".$param['date_to']." 23:59:59'";

        $query = "
			select	/*  > etah_mfront > mywiz_m > get_qna_list_count > ETAH Q&A 리스트 개수구하기 */
				count(cs.CS_NO)					as total_cnt
			from
				DAT_CS 	cs
			inner join	COD_CS_QUE_GB_CD 		gb
				on	cs.CS_QUE_GB_CD 			= gb.CS_QUE_GB_CD
			inner join	COD_CS_QUE_TYPE_CD 		tp
				on 	cs.CS_QUE_TYPE_CD 			= tp.CS_QUE_TYPE_CD
			inner join	DAT_CS_CONTENTS_REPLY 	rpQ
				on	cs.CS_NO					= rpQ.CS_NO
				and rpQ.KIND 					= 'Q'
			left join	MAP_CS_N_GOODS 			m
				on	m.CS_NO						= cs.CS_NO
			left join	DAT_GOODS				g
				on 	m.GOODS_CD					= g.GOODS_CD
			left join	DAT_GOODS_IMAGE			gi
				on 	g.GOODS_CD					= gi.GOODS_CD
				and gi.TYPE_CD					= 'TITLE'
			left join	DAT_CS_CONTENTS_REPLY	rpA
				on	cs.CS_NO					= rpA.CS_NO
				and rpA.KIND					= 'A'
			left join	DAT_USER				u
				on	cs.UPD_USER_CD				= u.USER_CD
			where
				cs.CUST_NO = '".$cust_no."'
			and cs.CS_QUE_GB_CD = '".$param['gb']."'
			and	cs.USE_YN = 'Y'
			$query_date
			order by
				cs.REG_DT

		";

        $db = self::_slave_db();
//		var_dump($query);
        $data = $db->query($query)->row_array();
        return $data['total_cnt'];
    }

    /**
     * 1:1문의 상세
     */
    public function get_qna_detail($qna_no)
    {
        $cust_no = $this->session->userdata('EMS_U_NO_');

        $query = "
			select    /*  > etah_mfront > mywiz_m > get_qna_detail > ETAH 1:1문의 상세 */
				c.CS_NO
				, c.CS_QUE_GB_CD
				, c.CS_QUE_TYPE_CD
				, c.EMAIL_REPLAY_YN
				, c.SMS_REPLAY_YN
				, c.QUE_CUST_NM
				, c.QUE_CUST_PHONE_NO
				, c.EMAIL
				, c.FILE_PATH
				, r.TITLE
				, r.`CONTENTS`
				, mr.GOODS_NM
			from
				DAT_CS 	c
			inner join	DAT_CS_CONTENTS_REPLY r
				on	c.CS_NO = r.CS_NO
				and r.KIND = 'Q'
			left join	MAP_CS_N_ORDER_REFER m
				on	c.CS_NO = m.CS_NO
			left join	DAT_ORDER_REFER mr
				on	m.ORDER_REFER_NO = mr.ORDER_REFER_NO
			where
				c.CS_QUE_GB_CD = '01'
			and	c.CUST_NO = '".$cust_no."'
			and	c.CS_NO = '".$qna_no."'
			and c.USE_YN = 'Y'


		";

        $db = self::_slave_db();
//		var_dump($query);
        $data = $db->query($query)->row_array();
        return $data;
    }

    /**
     * 상품문의 상세
     */
    public function get_qna_goods_detail($qna_no)
    {
        $cust_no = $this->session->userdata('EMS_U_NO_');

        $query = "
			select    /*  > etah_mfront > mywiz_m > get_qna_goods_detail > ETAH 상품문의 상세 */
				c.CS_NO
				, c.CS_QUE_GB_CD
				, c.CS_QUE_TYPE_CD
				, c.EMAIL_REPLAY_YN
				, c.SMS_REPLAY_YN
				, c.QUE_CUST_NM
				, c.QUE_CUST_PHONE_NO
				, c.EMAIL
				, c.FILE_PATH
				, r.CS_CONTENTS_REPLY_NO
				, r.TITLE
				, r.`CONTENTS`
				, m.GOODS_CD
				, g.GOODS_NM
				, b.BRAND_NM
				, i.IMG_URL
			from
				DAT_CS 	c
			inner join	DAT_CS_CONTENTS_REPLY	r
				on	c.CS_NO						= r.CS_NO
				and r.KIND						= 'Q'
			inner join	MAP_CS_N_GOODS			m
				on	c.CS_NO						= m.CS_NO
			inner join	DAT_GOODS				g
				on	m.GOODS_CD					= g.GOODS_CD
			inner join	DAT_BRAND				b
				on	g.BRAND_CD					= b.BRAND_CD
			inner join	DAT_GOODS_IMAGE			i
				on	i.GOODS_CD					= g.GOODS_CD
				and i.TYPE_CD					= 'TITLE'

			where
				c.CS_QUE_GB_CD = '02'
			and	c.CUST_NO = '".$cust_no."'
			and	c.CS_NO = '".$qna_no."'
			and c.USE_YN = 'Y'


		";

        $db = self::_slave_db();
//		var_dump($query);
        $data = $db->query($query)->row_array();
        return $data;
    }

    /**
     * 상품문의 수정
     */
    public function update_goods_qna($param)
    {
        $query = "
			update 	DAT_CS_CONTENTS_REPLY   /*  > etah_mfront > mywiz_m > update_goods_qna > ETAH 상품문의 수정 */
			set		TITLE = '".$param['title']."'
					, `CONTENTS` = '".$param['content']."'
			where	CS_CONTENTS_REPLY_NO = '".$param['qna_no']."'
			and		KIND = 'Q'
		";
//var_dump($query);
        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 문의 삭제
     */
    public function delete_qna($param, $table)
    {
        $query = "
			update	{$table}   /*  > etah_mfront > mywiz_m > delete_qna > ETAH 상품문의 삭제 */
			set		USE_YN = 'N'
			where	CS_NO = '".$param['qna_no']."'
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 고객 상품평
     */
    public function get_goods_comment_by_cust($param)
    {
        $limit_num_rows         = $param['limit_num_rows'];
        $startPos               = ($param['page'] - 1) * $limit_num_rows;
        $query_date				= "";

        if($limit_num_rows)	$query_limit = "limit $startPos, $limit_num_rows ";

        /* 일자조회 */
        if($param['date_type']>=0) $query_date = "and cm.REG_DT between '".$param['date_from']." 00:00:00' and '".$param['date_to']." 23:59:59'";

        $cust_no = $this->session->userdata('EMS_U_NO_');

        $query = "
			select	/*  > etah_mfront > mywiz_m > get_goods_comment_by_cust > ETAH 고객 상품평 */
				cm.CUST_GOODS_COMMENT
				, cm.GOODS_CD
				, cm.`CONTENTS`
				, cm.CUST_GOODS_COMMENT_REG_DT
				, cm.GRADE_VAL
				, substr(cm.GRADE_VAL,1,1) 	as GRADE_VAL1
				, substr(cm.GRADE_VAL,2,1) 	as GRADE_VAL2
				, substr(cm.GRADE_VAL,3,1) 	as GRADE_VAL3
				, substr(cm.GRADE_VAL,4,1) 	as GRADE_VAL4
				, if((length(cm.GRADE_VAL)= 1), cm.GRADE_VAL, ((substring(cm.GRADE_VAL,1,1) + substring(cm.GRADE_VAL,2,1) + substring(cm.GRADE_VAL,3,1) + substring(cm.GRADE_VAL,4,1))/4))    as TOTAL_GRADE
				, DATE_FORMAT(cm.REG_DT,'%Y.%m.%d') as REG_DT
				, c.CUST_ID
				, c.CUST_NM
				, g.GOODS_NM
				, r.GOODS_OPTION_NM
				, i.IMG_URL
				, b.BRAND_NM

			from
				DAT_CUST_GOODS_COMMENT cm
				inner join	DAT_CUST 			c
					on	cm.CUST_NO 				= c.CUST_NO
				inner join	DAT_ORDER_REFER 	r
					on	cm.ORDER_REFER_NO 		= r.ORDER_REFER_NO
				inner join	DAT_GOODS			g
					on	cm.GOODS_CD				= g.GOODS_CD
				inner join	DAT_GOODS_IMAGE		i
					on	g.GOODS_CD				= i.GOODS_CD
					and	i.TYPE_CD				= 'TITLE'
				inner join	DAT_GOODS_OPTION	op
					on	r.GOODS_OPTION_CD		= op.GOODS_OPTION_CD
				inner join	DAT_BRAND			b
					on	b.BRAND_CD				= g.BRAND_CD
			where
				cm.CUST_NO = '".$cust_no."'
			and cm.USE_YN = 'Y'
			$query_date

            group by
                cm.CUST_GOODS_COMMENT 
                
			order by
				cm.REG_DT desc
			$query_limit

		";

        $db = self::_slave_db();
//		var_dump($query);
        return $db->query($query)->result_array();
    }

    /**
     * 고객 상품평
     */
    public function get_goods_comment_count_by_cust($param)
    {
        $query_date				= "";

        /* 일자조회 */
        if($param['date_type']>=0) $query_date = "and cm.REG_DT between '".$param['date_from']." 00:00:00' and '".$param['date_to']." 23:59:59'";

        $cust_no = $this->session->userdata('EMS_U_NO_');

        $query = "
			select	/*  > etah_mfront > mywiz_m > get_goods_comment_count_by_cust > ETAH 고객 상품평 개수 */
				count(cm.CUST_GOODS_COMMENT)	as total_cnt
			from
				DAT_CUST_GOODS_COMMENT cm
				inner join	DAT_CUST 			c
					on	cm.CUST_NO 				= c.CUST_NO
				inner join	DAT_ORDER_REFER 	r
					on	cm.ORDER_REFER_NO 		= r.ORDER_REFER_NO
				inner join	DAT_GOODS			g
					on	cm.GOODS_CD				= g.GOODS_CD
				inner join	DAT_GOODS_IMAGE		i
					on	g.GOODS_CD				= i.GOODS_CD
					and	i.TYPE_CD				= 'TITLE'
				inner join	DAT_GOODS_OPTION	op
					on	r.GOODS_OPTION_CD		= op.GOODS_OPTION_CD
			where
				cm.CUST_NO = '".$cust_no."'
			and cm.USE_YN = 'Y'
			$query_date

		";

        $db = self::_slave_db();
//		var_dump($query);
        $result = $db->query($query)->row_array();
        return $result['total_cnt'];
    }

    /**
     * 상품평 상세
     */
    public function get_goods_comment_detail($comment_no)
    {
        $cust_no = $this->session->userdata('EMS_U_NO_');

        $query = "
			select	/*  > etah_mfront > mywiz_m > get_goods_comment_detail > ETAH 상품평 상세 구하기 */
				cm.CUST_GOODS_COMMENT
				, cm.GOODS_CD
				, cm.`CONTENTS`
				, cm.CUST_GOODS_COMMENT_REG_DT
				, cm.FILE_PATH
				, cm.GRADE_VAL
				, substr(cm.GRADE_VAL,1,1) 	as GRADE_VAL1
				, substr(cm.GRADE_VAL,2,1) 	as GRADE_VAL2
				, substr(cm.GRADE_VAL,3,1) 	as GRADE_VAL3
				, substr(cm.GRADE_VAL,4,1) 	as GRADE_VAL4
				, DATE_FORMAT(cm.REG_DT,'%Y.%m.%d') as REG_DT
				, c.CUST_ID
				, c.CUST_NM
				, g.GOODS_NM
				, r.GOODS_OPTION_NM
				, i.IMG_URL
				, b.BRAND_NM

			from
				DAT_CUST_GOODS_COMMENT cm
				inner join	DAT_CUST 			c
					on	cm.CUST_NO 				= c.CUST_NO
				inner join	DAT_ORDER_REFER 	r
					on	cm.ORDER_REFER_NO 		= r.ORDER_REFER_NO
				inner join	DAT_GOODS			g
					on	cm.GOODS_CD				= g.GOODS_CD
				inner join	DAT_GOODS_IMAGE		i
					on	g.GOODS_CD				= i.GOODS_CD
					and	i.TYPE_CD				= 'TITLE'
				inner join	DAT_GOODS_OPTION	op
					on	r.GOODS_OPTION_CD		= op.GOODS_OPTION_CD
				inner join	DAT_BRAND			b
					on	b.BRAND_CD				= g.BRAND_CD
			where
				cm.CUST_NO = '".$cust_no."'
			and cm.USE_YN = 'Y'
			and cm.CUST_GOODS_COMMENT = '".$comment_no."'


		";

        $db = self::_slave_db();
//		var_dump($query);
        $data = $db->query($query)->row_array();
        return $data;
    }

    /**
     * 상품평 첨부파일 가져오기
     */
    public function get_goods_comment_file($param)
    {
        $query = "
            select    	/*  > etah_mfront > mywiz_m > get_goods_comment_file > ETAH 상품평 첨부파일 가져오기 */
				c.CUST_GOODS_COMMENT_FILE_PATH_NO
				, c.CUST_GOODS_COMMENT
				, c.FILE_PATH
			from 
			    MAP_CUST_GOODS_COMMENT_FILE_PATH c 
			where 
			    1=1
            and c.CUST_GOODS_COMMENT = '".$param['comment_no']."'
            and c.USE_YN = 'Y'
            
			order by 
			    c.CUST_GOODS_COMMENT_FILE_PATH_NO asc
        ";

        $db = self::_slave_db();
        $data = $db->query($query)->result_array();
        return $data;
    }

    /**
     * 상품평 수정
     */
    public function update_goods_comment($param)
    {
        $query = "
			update 	DAT_CUST_GOODS_COMMENT      	/*  > etah_mfront > mywiz_m > update_goods_comment > ETAH 상품평수정 */
			set		`CONTENTS` = '".$param['comment']."'
					, GRADE_VAL = '".@$param['grade1'].@$param['grade2'].@$param['grade3'].@$param['grade4'].@$param['grade5']."'
			where	CUST_GOODS_COMMENT = '".$param['comment_cd']."'
        ";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 상품평 수정 - 첨부파일
     */
    public function update_goods_comment_file_path($file_path, $file_no)
    {
        //첨부파일 삭제
        if($file_path == '') {
            $query = "
            update MAP_CUST_GOODS_COMMENT_FILE_PATH f   /*  > etah_mfront > mywiz_m > update_goods_comment_file_path > ETAH 상품평 첨부파일삭제 */
            set f.USE_YN = 'N'
            where f.CUST_GOODS_COMMENT_FILE_PATH_NO = '".$file_no."'
            ";
        }
        //첨부파일 변경
        else {
            $query = "
            update MAP_CUST_GOODS_COMMENT_FILE_PATH f   /*  > etah_mfront > mywiz_m > update_goods_comment_file_path > ETAH 상품평 첨부파일변경 */
            set f.FILE_PATH = '".$file_path."'
            where f.CUST_GOODS_COMMENT_FILE_PATH_NO = '".$file_no."'
            ";
        }

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 상품평 삭제
     */
    public function delete_goods_comment($param)
    {
        $query = "
			update 	DAT_CUST_GOODS_COMMENT    /*  > etah_mfront > mywiz_m > delete_goods_comment > ETAH 상품평 삭제 */
			set		USE_YN = 'N'
			where	CUST_GOODS_COMMENT = '".$param['comment_cd']."'
        ";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 고객 상품평 등록
     */
    public function regist_comment($param)
    {
        $query = "
			insert into DAT_CUST_GOODS_COMMENT	(   /*  > etah_mfront > mywiz_m > regist_comment > ETAH 상품평 등록 */
				  GOODS_CD
				, CUST_NO
				, ORDER_REFER_NO
				, `CONTENTS`
				, GRADE_VAL
				, CUST_GOODS_COMMENT_REG_DT
			)
			values
			(
				  '".$param['goods_code']."'
				, '".$param['mem_no']."'
				, '".$param['order_refer_code']."'
				, '".$param['comment_contents']."'
				, '".$param['grade_val']."'
				, now()
			)
		";

        $db = self::_master_db();
        $result = $db->query($query);
        $rs_identity = $db->insert_id();

        return $rs_identity;
    }

    /**
     * 고객 상품평 첨부파일 저장
     */
    public function insert_goods_comment_file_path($title, $goods_comment_no)
    {
        $cust_no = $this->session->userdata('EMS_U_NO_');

        $query = "
            insert into MAP_CUST_GOODS_COMMENT_FILE_PATH      /*  > etah_mfront > mywiz_m > insert_goods_comment_file_path > ETAH 상품평 첨부파일등록 */
            (
                CUST_GOODS_COMMENT
                , FILE_PATH
                , REG_USER_CD
            )
            values (
                '".$goods_comment_no."'
                , '".$title."'
                , '".$cust_no."'
            )
        ";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 고객 상품평을 등록하기 전에 해당 상품을 구매했는지 주문상세번호 가져오기
     */
    public function get_goods_order_refer($param)
    {
        $query = "
			select      /*  > etah_mfront > mywiz_m > get_goods_order_refer > ETAH 상품평등록 전 해당 상품을 구매했는지 체크 */
				  r.ORDER_REFER_NO
			from
				DAT_ORDER		o
			inner join
				DAT_ORDER_REFER		r
			on r.ORDER_NO		= o.ORDER_NO
			inner join
				DAT_ORDER_REFER_PROGRESS		rp
			on  rp.ORDER_REFER_PROC_STS_NO	= r.ORDER_REFER_PROC_STS_NO
			and rp.ORDER_REFER_PROC_STS_CD	= 'OE02'

			where
				1 = 1
			and o.CUST_NO	= '".$param['mem_no']."'
			and r.GOODS_CD	= '".$param['goods_code']."'

            group by 
				r.ORDER_NO  
				
			order by
				r.ORDER_REFER_NO	asc
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 해당 주문상세번호의 상품평을 등록한 적이 있는지 여부 확인
     */
    public function get_exists_comment_order($param)
    {
        $query = "
			select    /*  > etah_mfront > mywiz_m > get_exists_comment_order > ETAH 상품평을 등록한 적이 있는지 체크 */
				count(gc.CUST_GOODS_COMMENT)	as cnt
			from
				DAT_CUST_GOODS_COMMENT		gc
			where
				1 = 1
			and gc.GOODS_CD			= '".$param['goods_code']."'
			and gc.CUST_NO			= '".$param['mem_no']."'
			and gc.ORDER_REFER_NO	= '".$param['order_refer_code']."'
			and gc.USE_YN			= 'Y'
		";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 해당 주문상세번호의 상품평 모두 조회 (삭제된 상품평 포함)
     * 마일리지 중복 적립 방지
     */
    public function get_exists_all_comment_order($param)
    {
        $query = "
			select    /*  > etah_mfront > mywiz_m > get_exists_all_comment_order > ETAH 상품평 모두 조회 */
				count(gc.CUST_GOODS_COMMENT)	as cnt
			from
				DAT_CUST_GOODS_COMMENT		gc
			where
				1 = 1
			and gc.GOODS_CD			= '".$param['goods_code']."'
			and gc.CUST_NO			= '".$param['mem_no']."'
			and gc.ORDER_REFER_NO	= '".$param['order_refer_code']."'
		";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }


    /**
     * 마이페이지 > 쇼핑내역 > 주문조회
     * 상품평작성 위해 상품 정보 가져오기
     */
    public function get_goods_info_write_comment($order_refer_code)
    {
        $query = "
            select    /*  > etah_mfront > mywiz_m > get_goods_info_write_comment > ETAH 상품평작성 위해 상품 정보 가져오기 */
                g.GOODS_CD                as GOODS_CD
                , g.GOODS_NM              as GOODS_NM
                , b.BRAND_CD			  as BRAND_CD
                , b.BRAND_NM			  as BRAND_NM
                , gi.IMG_URL              as IMG_URL
                , r.GOODS_OPTION_NM       as GOODS_OPTION_NM
                , cg.CLASS_GOODS_NO	      as CLASS_NO
            from 
                DAT_ORDER_REFER r 
                inner join 
                        DAT_GOODS         g 
                on r.GOODS_CD             = g.GOODS_CD 
                inner join
                        DAT_BRAND		  b
                on g.BRAND_CD 			  = b.BRAND_CD
                left join 
                        MAP_CLASS_GOODS   cg 
                on g.GOODS_CD             = cg.GOODS_CD
                inner join 
                        DAT_GOODS_IMAGE   gi 
                on g.GOODS_CD             = gi.GOODS_CD
            where 
                r.ORDER_REFER_NO          = '".$order_refer_code."'
        ";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 마일리지
     */
    public function get_mileage_list($param)
    {
        $limit_num_rows         = $param['limit_num_rows'];
        $startPos               = ($param['page'] - 1) * $limit_num_rows;

        if($limit_num_rows)	$query_limit = "limit $startPos, $limit_num_rows ";

        $cust_no = $this->session->userdata('EMS_U_NO_');

        $query = "
			select	/*  > etah_mfront > mywiz_m > get_mileage_list > ETAH 마일리지 */
				t.MILEAGE_AMT
				, t.TYPE
				, CUST_NO
				, left(t.REG_DT, 11)		as REG_DT
				, t.ORDER_PAY_DTL_NO
				, pay.ORDER_NO
			    , t.SAVING_REASON_ETC 
			from
			(
				(
					select 	s.MILEAGE_SAVING_AMT	as MILEAGE_AMT
							, s.SAVE_DT				as REG_DT
							, 'S'					as `TYPE`
							, s.CUST_NO
							, ''					as ORDER_PAY_DTL_NO
							, s.SAVING_REASON_ETC 
					from	DAT_CUST_MILEAGE_SAVING s
					where	s.SAVE_YN ='Y'
					and		s.CUST_NO = '".$cust_no."'
					and		s.REG_DT between ('".$param['date_from']." 00:00:00') and ('".$param['date_to']." 23:59:59')
					and		s.USE_YN = 'Y'

				)
				union all

				(
					select 	p.MILEAGE_PAY_AMT		as MILEAGE_AMT
							, p.REG_DT
						--	, 'P'					as TPYE
							, if(left(p.MILEAGE_PAY_AMT, 1)='-', 'C', 'P')	as TYPE
							, p.CUST_NO
							, p.ORDER_PAY_DTL_NO
							, ''  			        as SAVING_REASON_ETC 
					from	DAT_CUST_MILEAGE_PAY 	p
					where	p.CUST_NO = '".$cust_no."'
					and		p.REG_DT between ('".$param['date_from']." 00:00:00') and ('".$param['date_to']." 23:59:59')
					and		p.USE_YN = 'Y'
				)
			)	t
			left join	DAT_ORDER_PAY_DTL 	d
				on	d.ORDER_PAY_DTL_NO 		= t.ORDER_PAY_DTL_NO
			left join	DAT_ORDER_PAY		pay
				on	d.PAY_NO				= pay.PAY_NO

			order by 	t.REG_DT desc
			$query_limit

		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 마일리지 개수구하기
     */
    public function get_mileage_list_count($param)
    {
        $cust_no = $this->session->userdata('EMS_U_NO_');

        $query = "
			select	/*  > etah_mfront > mywiz_m > get_mileage_list_count > ETAH 마일리지 개수구하기*/
				count(t.MILEAGE_AMT)			as total_cnt
			from
			(
				(
					select 	s.MILEAGE_SAVING_AMT	as MILEAGE_AMT
							, s.SAVE_DT				as REG_DT
							, 'S'					as `TYPE`
							, s.CUST_NO

					from	DAT_CUST_MILEAGE_SAVING s
					where	s.SAVE_YN ='Y'
					and		s.CUST_NO = '".$cust_no."'
					and		s.REG_DT between ('".$param['date_from']." 00:00:00') and ('".$param['date_to']." 23:59:59')
					and		s.USE_YN = 'Y'

				)
				union all

				(
					select 	p.MILEAGE_PAY_AMT		as MILEAGE_AMT
							, p.REG_DT
							, 'P'					as TPYE
							, p.CUST_NO

					from	DAT_CUST_MILEAGE_PAY 	p
					where	p.CUST_NO = '".$cust_no."'
					and		p.REG_DT between ('".$param['date_from']." 00:00:00') and ('".$param['date_to']." 23:59:59')
					and		p.USE_YN = 'Y'
				)
			)	t


		";

        $db = self::_slave_db();
        $data = $db->query($query)->row_array();
        return $data['total_cnt'];
    }

    /**
     * 마일리지 정보
     */
    public function get_mileage_info($param)
    {
        $query = "
			select	/* >etah_mfront > mywiz_m > get_mileage_info > ETAH 마일리지 정보 */
			--	m.CUST_MILEAGE_NO
				 m.CUST_NO
				, m.MILEAGE_AMT
				, m.SAVE_MILEAGE_AMT
				, m.PAY_MILEAGE_AMT
			--	, COL5
			from
				DAT_CUST_MILEAGE		m
			where
				1 = 1
			and m.CUST_NO	= '".$param['CUST_NO']."'
		";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 마일리지 정보
     */
    public function get_mileage_info_kcp($param)
    {
        $query = "
			select	/* >etah_mfront > mywiz_m > get_mileage_info > ETAH 마일리지 정보 */
			--	m.CUST_MILEAGE_NO
				 m.CUST_NO
				, m.MILEAGE_AMT
				, m.SAVE_MILEAGE_AMT
				, m.PAY_MILEAGE_AMT
			--	, COL5
			from
				DAT_CUST_MILEAGE		m
			where
				1 = 1
			and m.CUST_NO	= ?
		";

        $db = self::_slave_db();
        return $db->query($query, $param['BUYER_CODE'])->row_array();
    }

    /**
     * 쿠폰리스트
     */
    public function get_coupon_list($param)
    {
        $limit_num_rows         = $param['limit_num_rows'];
        $startPos               = ($param['page'] - 1) * $limit_num_rows;

        if($limit_num_rows)	$query_limit = "limit $startPos, $limit_num_rows ";
        //사용 가능한 쿠폰
        $query_date	= "	and c.COUPON_END_DT >= now()
						and cc.USE_YN = 'Y'";
        //지난 쿠폰
        if($param['last_coupon']) $query_date = "and ( c.COUPON_END_DT < now() or cc.USE_YN = 'N') ";

        $cust_no = $this->session->userdata('EMS_U_NO_');

        $query = "
			select	/*  > etah_mfront > mywiz_m > get_coupon_list > ETAH 쿠폰리스트 */
				cc.COUPON_CD
				, cg.COUPON_GET_CD
				, cg.COUPON_GET_CD_NM
				, cc.COUPON_DTL_NO
				, cc.USE_YN
				, c.DC_COUPON_NM
				, c.MIN_AMT
				, c.MAX_DISCOUNT
				, c.COUPON_START_DT
				, c.COUPON_END_DT
				, c.BUYER_COUPON_APPLICATION_SCOPE_CD
			from
				DAT_CUST_COUPON 	cc
				inner join	DAT_COUPON 		c
					on	c.COUPON_CD 		= cc.COUPON_CD
					and	c.USE_YN			= 'Y'
				inner join	DAT_COUPON_PROGRESS		cp
					on cp.COUPON_PROGRESS_NO		= c.COUPON_PROGRESS_NO
					and cp.COUPON_PROGRESS_STS_CD	= '03'
					and cp.USE_YN					= 'Y'
				left join	DAT_COUPON_DTL 	cd
					on	cc.COUPON_DTL_NO 	= cd.COUPON_DTL_NO
				inner join	COD_COUPON_GET_CD cg
					on 	cc.COUPON_GET_CD	= cg.COUPON_GET_CD

			where
				cc.CUST_NO = '".$cust_no."'
		--	and	cc.USE_YN  = 'Y'
			$query_date
			order by
				cc.COUPON_CD desc
			$query_limit

		";

        $db = self::_slave_db();
//		var_dump($query);
        return $db->query($query)->result_array();
    }

    /**
     * 쿠폰리스트 개수구하기
     */
    public function get_coupon_list_count($param)
    {
        //사용 가능한 쿠폰
        $query_date	= "	and c.COUPON_END_DT >= now()
						and cc.USE_YN = 'Y'";
        //지난 쿠폰
        if($param['last_coupon']) $query_date = "and ( c.COUPON_END_DT < now() or cc.USE_YN = 'N') ";

        $cust_no = $this->session->userdata('EMS_U_NO_');

        $query = "
			select	/*  > etah_mfront > mywiz_m > get_coupon_list_count > ETAH 쿠폰리스트 개수구하기*/
				count(cc.COUPON_CD)			as total_cnt
			from
				DAT_CUST_COUPON 	cc
				inner join	DAT_COUPON 		c
					on	cc.COUPON_CD 		= c.COUPON_CD
					and	c.USE_YN			= 'Y'
				inner join	DAT_COUPON_PROGRESS		cp
					on cp.COUPON_PROGRESS_NO		= c.COUPON_PROGRESS_NO
					and cp.COUPON_PROGRESS_STS_CD	= '03'
					and cp.USE_YN					= 'Y'
				left join	DAT_COUPON_DTL 	cd
					on	cc.COUPON_DTL_NO 	= cd.COUPON_DTL_NO
				inner join	COD_COUPON_GET_CD cg
					on 	cc.COUPON_GET_CD	= cg.COUPON_GET_CD

			where
				cc.CUST_NO = '".$cust_no."'
		--	and	cc.USE_YN  = 'Y'
			$query_date

		";

        $db = self::_slave_db();
        $data = $db->query($query)->row_array();
        return $data['total_cnt'];
    }

    /**
     * 최근 주문 정보
     */
    public function get_order_list($param)
    {
        $limit_num_rows         = $param['limit_num_rows'];
        $startPos               = ($param['page'] - 1) * $limit_num_rows;
        $query_cancel_return	= "";
        $query_date				= "";
        $query_cust				= "";

        if($limit_num_rows)	$query_limit = "limit $startPos, $limit_num_rows ";

        $cust_id = $this->session->userdata('EMS_U_ID_');
        $cust_no = $this->session->userdata('EMS_U_NO_');

        /* 비회원 구분 */
        if($cust_id == "GUEST"){
            $query_cust = "and o.ORDER_NO = '".$cust_no."'";
            $param['date_type'] = -1;
        }else{
            $query_cust = "and o.CUST_NO = '".$cust_no."'";
        }

        /* 취소/반품 */
        if($param['cancel_return'])	$query_cancel_return = "and (rp.ORDER_REFER_PROC_STS_CD	like 'OC%'	or	rp.ORDER_REFER_PROC_STS_CD	like 'OR%')";

        /* 일자조회 */
        if($param['date_type']>=0) $query_date = "and r.REG_DT between '".$param['date_from']." 00:00:00' and '".$param['date_to']." 23:59:59'";



        $query = "
			select	/*  > etah_mfront > mywiz_m > get_order_list > ETAH 최근 주문 정보 구하기 */
				o.ORDER_NO
				, r.ORDER_REFER_NO
				, r.ORD_QTY
				, r.GOODS_OPTION_NM
				, r.SELLING_PRICE
				, r.INVOICE_NO
				, r.DELIV_COMPANY_CD
				, substr(r.REG_DT,1,10)							as REG_DT
				, g.GOODS_CD
				, g.GOODS_NM
				, g.PROMOTION_PHRASE
				, b.BRAND_NM
				, odf.DELIV_POLICY_NO
				, i.IMG_URL
				-- , pri.SELLING_PRICE
				, s.ORDER_REFER_PROC_STS_CD
				, s.ORDER_REFER_PROC_STS_CD_NM
				, sum(if(s.ORDER_REFER_PROC_STS_CD in ('OC01', 'OC02' ,'OC21','OC22','OR01','OR02','OR03','OR04','OR11','OR12','OR13','OR21','OR22', 'OB02', 'OB03'), '1', '0'))	as CANCEL_CHANGE_RETURN	/* 취소/교환/반품 */
				, if(s.ORDER_REFER_PROC_STS_CD in ('OA01','OA02','OA03','OB01','OB03'), 'Y', 'N')	as CANCEL_YN
				, odf.DELIV_COST								as ORDER_DELIV_COST
				, if(rp.ORDER_REFER_PROC_STS_CD in ('OE01', 'OE02'),'Y','N')						as RETURN_YN
				, pay.ORDER_AMT
				, pay.REAL_PAY_AMT
				, payKind.ORDER_PAY_KIND_CD
				, vs.SEND_NATION
				, if(isnull(cmt.CUST_GOODS_COMMENT), 'Y', 'N')		as COMMENT_YN
				, if(isnull(o.CUST_NO), 'N', 'Y')                   as MEMBER_YN

			/*	, (	select	count(rf.ORDER_REFER_NO)
					from	DAT_ORDER_REFER rf
					where	rf.ORDER_NO = o.ORDER_NO
					and		o.CUST_NO	= '".$cust_no."'
					)											as CNT_ORDER_REFER
			*/
			/*	, (	select 	count(rr.ORDER_REFER_NO)
					from	DAT_ORDER_REFER rr
							inner join	DAT_GOODS		gg
								on	rr.GOODS_CD			= gg.GOODS_CD
							inner join	DAT_ORDER_DELIV_FEE f
								on	gg.DELIV_POLICY_NO	= f.DELIV_POLICY_NO
								and rr.ORDER_NO			= f.ORDER_NO
					where	rr.ORDER_NO =o.ORDER_NO
					and		f.DELIV_POLICY_NO = g.DELIV_POLICY_NO

					)											as GROUP_DELI_ROW
			*/
			from
				DAT_ORDER o
				inner join	DAT_ORDER_REFER 			r
					on 	o.ORDER_NO 						= r.ORDER_NO
				inner join	DAT_GOODS 					g
					on	r.GOODS_CD						= g.GOODS_CD
				inner join	DAT_GOODS_IMAGE				i
					on 	g.GOODS_CD						= i.GOODS_CD
					and i.TYPE_CD						= 'TITLE'
				inner join	DAT_BRAND					b
					on	b.BRAND_CD						= g.BRAND_CD
				inner join	DAT_GOODS_PRICE				pri
					on	g.GOODS_CD						= pri.GOODS_CD
					and g.GOODS_PRICE_CD				= pri.GOODS_PRICE_CD
				inner join	DAT_GOODS_OPTION			op
					on 	r.GOODS_OPTION_CD				= op.GOODS_OPTION_CD
				inner join	DAT_VENDOR_SUBVENDOR		vs
					on 	vs.VENDOR_SUBVENDOR_CD		= g.VENDOR_SUBVENDOR_CD
				inner join	DAT_ORDER_REFER_PROGRESS 	rp
					on	r.ORDER_REFER_NO				= rp.ORDER_REFER_NO
					and r.ORDER_REFER_PROC_STS_NO		= rp.ORDER_REFER_PROC_STS_NO
				inner join	COD_ORDER_REFER_PROC_STS_CD	s
					on	rp.ORDER_REFER_PROC_STS_CD		= s.ORDER_REFER_PROC_STS_CD
				inner join	DAT_ORDER_PAY				pay
					on	o.ORDER_NO						= pay.ORDER_NO
				inner join	DAT_ORDER_DELIV_FEE			odf
					on	r.ORDER_NO						= odf.ORDER_NO
					and	r.ORDER_DELIV_FEE_NO			= odf.ORDER_DELIV_FEE_NO
				inner join	DAT_ORDER_PAY_DTL			dt
					on	pay.PAY_NO						= dt.PAY_NO
				inner join	COD_ORDER_PAY_KIND_CD		payKind
					on	dt.ORDER_PAY_KIND_CD			= payKind.ORDER_PAY_KIND_CD
				left join DAT_CUST_GOODS_COMMENT       cmt
					on r.ORDER_REFER_NO                 = cmt.ORDER_REFER_NO
					and cmt.USE_YN                      = 'Y'
			where
				1 = 1
				$query_cust
				$query_cancel_return
				$query_date
			and	o.USE_YN = 'Y'
			and	r.USE_YN = 'Y'
			group by
				r.ORDER_REFER_NO
			order by
				r.ORDER_REFER_NO desc
			$query_limit
		";

        $db = self::_slave_db();
//		var_dump($query);
        return $db->query($query)->result_array();
    }

    /**
     * 최근 주문 정보
     */
    public function get_order_list_count($param)
    {
        $query_cancel_return	= "";
        $query_date				= "";
        $query_cust				= "";

        /* 취소/반품 */
        if($param['cancel_return'])	$query_cancel_return = "and (rp.ORDER_REFER_PROC_STS_CD	like 'OC%'	or	rp.ORDER_REFER_PROC_STS_CD	like 'OR%')";

        $cust_id = $this->session->userdata('EMS_U_ID_');
        $cust_no = $this->session->userdata('EMS_U_NO_');

        /* 비회원 구분 */
        if($cust_id == "GUEST"){
            $query_cust = "and o.ORDER_NO = '".$cust_no."'";
            $param['date_type'] = 0;
        }else{
            $query_cust = "and o.CUST_NO = '".$cust_no."'";
        }

        /* 일자조회 */
        if($param['date_type']>=0) $query_date = "and r.REG_DT between '".$param['date_from']." 00:00:00' and '".$param['date_to']." 23:59:59'";

        $query = "
			select	/*  > etah_mfront > mywiz_m > get_order_list_count > ETAH 최근 주문 정보 개수 구하기 */
				count(o.ORDER_NO)					total_cnt
			from
				DAT_ORDER o
				inner join	DAT_ORDER_REFER 			r
					on 	o.ORDER_NO 						= r.ORDER_NO
				inner join	DAT_GOODS 					g
					on	r.GOODS_CD						= g.GOODS_CD
				inner join	DAT_GOODS_IMAGE				i
					on 	g.GOODS_CD						= i.GOODS_CD
					and i.TYPE_CD						= 'TITLE'
				inner join	DAT_GOODS_PRICE				pri
					on	g.GOODS_CD						= pri.GOODS_CD
					and g.GOODS_PRICE_CD				= pri.GOODS_PRICE_CD
				inner join	DAT_GOODS_OPTION			op
					on 	r.GOODS_OPTION_CD				= op.GOODS_OPTION_CD
				inner join	DAT_ORDER_REFER_PROGRESS 	rp
					on	r.ORDER_REFER_NO				= rp.ORDER_REFER_NO
					and r.ORDER_REFER_PROC_STS_NO		= rp.ORDER_REFER_PROC_STS_NO
				inner join	COD_ORDER_REFER_PROC_STS_CD	s
					on	rp.ORDER_REFER_PROC_STS_CD		= s.ORDER_REFER_PROC_STS_CD
			--	inner join	DAT_ORDER_PAY				pay
			--		on	o.ORDER_NO						= pay.ORDER_NO
			where
				1 = 1
				$query_cust
				$query_cancel_return
				$query_date
			and	o.USE_YN = 'Y'
			and	r.USE_YN = 'Y'
		";

        $db = self::_slave_db();
//		var_dump($query);
        $result = $db->query($query)->row_array();
        return $result['total_cnt'];
    }

    /**
     * 주문 상세 정보
     */
    public function get_order_detail($order_no, $order_refer_no = null)
    {
        $query_order_refer_no = "";

        $cust_id = $this->session->userdata('EMS_U_ID_');
        $cust_no = $this->session->userdata('EMS_U_NO_');

        if($order_refer_no) $query_order_refer_no ="and	r.ORDER_REFER_NO = '".$order_refer_no."'";

        /* 비회원 구분 */
        if($cust_id == "GUEST"){
            $query_cust = "";
        }else{
            $query_cust = "and o.CUST_NO = '".$cust_no."'";
        }

        $query = "
			select	/*  > etah_mfront > mywiz_m > get_order_detail > ETAH 주문 상세 정보 구하기 */
				o.ORDER_NO
				, o.REG_DT
				, r.ORD_QTY
				, r.ORDER_REFER_NO
				, r.SELLING_PRICE
				, r.SELLING_ADD_PRICE
				, (r.SELLING_PRICE + r.SELLING_ADD_PRICE)* r.ORD_QTY		as SUM_GOODS_SELIING_PRICE
				, r.GOODS_OPTION_NM
				, r.INVOICE_NO
				, r.DELIV_COMPANY_CD
				, cdc.CD_NM								as DELIVERY_COMPANY_NM
				, g.GOODS_CD
				, g.GOODS_NM
				, g.PROMOTION_PHRASE
				, b.BRAND_NM
				, i.IMG_URL
			--	, pri.SELLING_PRICE
				, s.ORDER_REFER_PROC_STS_CD
				, s.ORDER_REFER_PROC_STS_CD_NM
				, pay.ORDER_AMT
				, pay.DC_AMT
				, pay.DELIV_COST_AMT
				, pay.REAL_PAY_AMT
				, pay.TOTAL_PAY_SUM
				, pay.ORDER_PAY_COMPLETE_DT
				, dt.CARD_COMPANY_NM
				, dt.CARD_MONTH
				, dt.FREE_INTEREST_YN
				, dt.BANK_NM
				, dt.BANK_ACCOUNT_NO
				, dt.DEPOSIT_DEADLINE_DY
				, dt.DEPOSIT_DUE_DY
				, dt.DEPOSIT_CUST_NM
				, dt.RETURN_BANK_NM
				, dt.RETURN_ACCOUNT_NO
				, dt.RETURN_CUST_NM
				, dt.RECEIPT_URL
				, dt.VARS_VNUM_NO
				, dt.VARS_EXPR_DT
				, dt.PAY_AMT							as R_PAY_AMT
				, dc.COUPON_CD
				, dc.DC_AMT								as R_DC_AMT
			--	, sum(dc.DC_AMT)						as SUM_R_DC_AMT
				, payKind.ORDER_PAY_KIND_CD
				, payKind.ORDER_PAY_KIND_CD_NM			as ORDER_PAY_KIND_NM
				, od.SENDER_NM
				, if(od.SENDER_MOB_NO = '',od.RECEIVER_MOB_NO, od.SENDER_MOB_NO )	as SENDER_MOB_NO
				, od.RECEIVER_NM
				, od.RECEIVER_PHONE_NO
				, od.RECEIVER_MOB_NO
				, od.RECEIVER_EMAIL
				, od.RECEIVER_ZIPCODE
				, od.RECEIVER_ADDR1
				, od.RECEIVER_ADDR2
				, od.DELIV_MSG
				, od.LIVING_FLOOR_CD
				, od.STEP_WIDTH_CD
				, od.ELEVATOR_CD
				, concat(g.VENDOR_SUBVENDOR_CD,'_',odf.DELIV_POLICY_NO)	as DELI_CODE
				, dp.PATTERN_TYPE_CD
				, max(dpp.DELIV_COST_DECIDE_VAL)		as DELI_LIMIT
				, max(dpp.DELIV_COST)					as DELI_COST
				, dp.DELIV_POLICY_NO
				, odf.DELIV_COST						as ORDER_DELIV_COST
				, if(s.ORDER_REFER_PROC_STS_CD in ('OA01','OA02','OA03','OB01','OB03'), 'Y', 'N')	as CANCEL_YN
				, if(rp.ORDER_REFER_PROC_STS_CD in ('OE02'),'Y','N')						        as RETURN_YN
				, c2.CATEGORY_MNG_CD
				, c2.PARENT_CATEGORY_MNG_CD
				, cr.QTY								as CANCEL_RETURN_QTY
				, cr.REAL_PAY_AMT						as CANCEL_RETURN_REAL_PAY_AMT
				, cr.TOTAL_PAY_SUM						as CANCEL_RETURN_TOTAL_PAY_SUM
				, cr.MILEAGE_AMT						as CANCEL_RETURN_MILEAGE_AMT
				, (	select 	PAY_AMT
					from	DAT_ORDER_PAY_DTL
					where	PAY_NO = pay.PAY_NO
					and		ORDER_PAY_KIND_CD = '04'
					)									as PAY_MILEAGE
			/*	, (	select	sum(DC_AMT)
					from	DAT_ORDER_PAY_DC_DTL
					where	PAY_NO = pay.PAY_NO
					and		m.PAY_DC_NO = PAY_DC_NO
					)									as SUM_R_DC_AMT
			*/
				, (	select 	sum(subD.DC_AMT)
					from 	MAP_DC_DTL_N_ORD_REFER 			subM
							inner join	DAT_ORDER_PAY_DC_DTL subD
								on 	subM.PAY_DC_NO 			= subD.PAY_DC_NO
					where 	subM.ORDER_REFER_NO 			= r.ORDER_REFER_NO
					)										as SUM_R_DC_AMT
				, (	select 	count(rr.ORDER_REFER_NO)
					from	DAT_ORDER_REFER rr
							inner join	DAT_ORDER_DELIV_FEE f
								on rr.ORDER_NO				= f.ORDER_NO
								and	rr.ORDER_DELIV_FEE_NO	= f.ORDER_DELIV_FEE_NO
					where	rr.ORDER_NO =o.ORDER_NO
					and		f.DELIV_POLICY_NO = odf.DELIV_POLICY_NO

					)									as GROUP_DELI_ROW


			from
				DAT_ORDER o
				inner join	DAT_ORDER_REFER 			r
					on 	o.ORDER_NO 						= r.ORDER_NO
				inner join	DAT_GOODS 					g
					on	r.GOODS_CD						= g.GOODS_CD
				inner join	DAT_GOODS_IMAGE				i
					on 	g.GOODS_CD						= i.GOODS_CD
					and i.TYPE_CD						= 'TITLE'
				inner join	DAT_BRAND					b
					on b.BRAND_CD						= g.BRAND_CD
				inner join	DAT_GOODS_PRICE				pri
					on	g.GOODS_CD						= pri.GOODS_CD
					and g.GOODS_PRICE_CD				= pri.GOODS_PRICE_CD
				inner join	DAT_GOODS_OPTION			op
					on 	r.GOODS_OPTION_CD				= op.GOODS_OPTION_CD
				inner join	DAT_ORDER_REFER_PROGRESS 	rp
					on	r.ORDER_REFER_NO				= rp.ORDER_REFER_NO
					and r.ORDER_REFER_PROC_STS_NO		= rp.ORDER_REFER_PROC_STS_NO
				inner join	COD_ORDER_REFER_PROC_STS_CD	s
					on	rp.ORDER_REFER_PROC_STS_CD		= s.ORDER_REFER_PROC_STS_CD
				inner join	DAT_ORDER_PAY				pay
					on	o.ORDER_NO						= pay.ORDER_NO
				left join	MAP_DC_DTL_N_ORD_REFER		m
					on	r.ORDER_REFER_NO				= m.ORDER_REFER_NO
				inner join	DAT_ORDER_PAY_DTL			dt
					on	pay.PAY_NO						= dt.PAY_NO
				inner join	COD_ORDER_PAY_KIND_CD		payKind
					on	dt.ORDER_PAY_KIND_CD			= payKind.ORDER_PAY_KIND_CD
				left join	DAT_ORDER_PAY_DC_DTL		dc
					on	pay.PAY_NO						= dc.PAY_NO
					and m.PAY_DC_NO						= dc.PAY_DC_NO
				inner join	DAT_ORDER_DELIV				od
					on 	o.ORDER_NO						= od.ORDER_NO
				inner join	DAT_ORDER_DELIV_FEE			odf
					on	r.ORDER_NO						= odf.ORDER_NO
					and	r.ORDER_DELIV_FEE_NO			= odf.ORDER_DELIV_FEE_NO
				inner join	DAT_DELIV_POLICY			dp
					on	dp.DELIV_POLICY_NO				= odf.DELIV_POLICY_NO
					and dp.USE_YN						= 'Y'
				left join	DAT_DELIV_POLICY_PATTERN	dpp
					on	dpp.DELIV_POLICY_NO				= dp.DELIV_POLICY_NO
				left join	COD_DELIV_COMPANY			cdc
					on	r.DELIV_COMPANY_CD				= cdc.DELIV_COMPANY_CD
				inner join	DAT_CATEGORY_MNG			c3
					on	g.CATEGORY_MNG_CD				= c3.CATEGORY_MNG_CD
				inner join	DAT_CATEGORY_MNG			c2
					on	c3.PARENT_CATEGORY_MNG_CD		= c2.CATEGORY_MNG_CD
				left join	(	select 	cr.QTY
										, cr.ORDER_REFER_NO
										, crP.REAL_PAY_AMT
										, crP.TOTAL_PAY_SUM
										, crP.MILEAGE_AMT
								from	DAT_ORDER_REFER				scR
										inner join	DAT_ORDER_REFER_CANCEL_RETURN cr
											on	scR.ORDER_REFER_NO	= cr.ORDER_REFER_NO
										inner join	DAT_ORDER_PAY	crP
											on	scR.ORDER_NO		= crP.ORDER_NO
											and crP.REAL_PAY_AMT	< 0
							)	cr
					on r.ORDER_REFER_NO					= cr.ORDER_REFER_NO


			where
				o.ORDER_NO = '".$order_no."'
			$query_order_refer_no
			$query_cust
		--	and dt.ORDER_PAY_KIND_CD in ('01', '02', '03')
			group by
				r.ORDER_REFER_NO
			order by
				r.ORDER_REFER_NO desc
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 취소 반품 사유
     */
    public function get_cancel_return_reason()
    {
        $query = "
			select	/*  > etah_mfront > mywiz_m > get_cancel_return_reason > ETAH 취소 반품 사유 */
					CANCEL_RETURN_REASON_CD
					, CANCEL_RETURN_REASON_CD_NM
			from 	COD_CANCEL_RETURN_REASON_CD
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();

    }

    /**
     * 주문상세정보
     */
    public function get_order_refer_detail($order_refer_no)
    {
        $cust_no = $this->session->userdata('EMS_U_NO_');

        $query = "
			select    /*  > etah_mfront > mywiz_m > get_order_refer_detail > ETAH 주문상세정보 */
				r.ORDER_NO
				, r.ORDER_REFER_NO
				, r.ORD_QTY
				, r.SELLING_PRICE
				, r.SELLING_ADD_PRICE
				, r.GOODS_OPTION_NM
				, od.SENDER_NM
				, if(od.SENDER_MOB_NO = '', od.RECEIVER_MOB_NO , od.SENDER_MOB_NO)	as SENDER_MOB_NO
				, payKind.ORDER_PAY_KIND_CD_NM				as ORDER_PAY_KIND_NM
				, g.GOODS_NM
				, g.PROMOTION_PHRASE
				, b.BRAND_NM
				, i.IMG_URL
				, dp.PATTERN_TYPE_CD
				, dp.DELIV_POLICY_NO
				, dp.RETURN_DELIV_COST
				, ifnull(max(dpp.DELIV_COST_DECIDE_VAL),0)		as DELI_LIMIT
				, ifnull(max(dpp.DELIV_COST),0)					as DELI_COST
			--	, ceil(dc.DC_AMT / r.ORD_QTY)			as DC_AMT
			--	, ifnull(sum(dc.DC_AMT),0)					as DC_AMT
				, dCom.DELIV_COMPANY_CD					as DELIVERY_CODE
				, dCom.CD_NM							as DELIVERY_NAME
				, pay.TOTAL_PAY_SUM
				, pay.DELIV_COST_AMT
				, odf.DELIV_COST						as ORDER_REFER_DELI_COST
				, (select ifnull(sum(pay_dc.DC_AMT),0) from DAT_ORDER_PAY_DC_DTL pay_dc 
								    inner join MAP_DC_DTL_N_ORD_REFER orp
								    on orp.PAY_DC_NO = pay_dc.PAY_DC_NO
								  where orp.ORDER_REFER_NO = r.ORDER_REFER_NO	)   as DC_AMT
			from
				DAT_ORDER_REFER r
				inner join	DAT_GOODS 				g
					on	r.GOODS_CD 					= g.GOODS_CD
				inner join	DAT_BRAND				b
					on	g.BRAND_CD					= b.BRAND_CD
				inner join	DAT_GOODS_OPTION 		o
					on 	r.GOODS_OPTION_CD 			= o.GOODS_OPTION_CD
				inner join	DAT_GOODS_IMAGE			i
					on	g.GOODS_CD					= i.GOODS_CD
					and i.TYPE_CD					= 'TITLE'
				inner join	DAT_ORDER_DELIV			od
					on	r.ORDER_NO					= od.ORDER_NO
				inner join	DAT_ORDER_PAY			pay
					on	r.ORDER_NO					= pay.ORDER_NO
				inner join	DAT_ORDER_PAY_DTL		dt
					on	pay.PAY_NO					= dt.PAY_NO
					and dt.ORDER_PAY_KIND_CD		in ('01','02','03','04','05')
				left join	MAP_DC_DTL_N_ORD_REFER	m
					on	m.ORDER_REFER_NO			= r.ORDER_REFER_NO
				left join	DAT_ORDER_PAY_DC_DTL	dc
					on	m.PAY_DC_NO					= dc.PAY_DC_NO
					and pay.PAY_NO					= dc.PAY_NO
				inner join	COD_ORDER_PAY_KIND_CD	payKind
					on	dt.ORDER_PAY_KIND_CD		= payKind.ORDER_PAY_KIND_CD
				inner join	DAT_GOODS_PRICE			pri
					on	g.GOODS_CD					= pri.GOODS_CD
					and g.GOODS_PRICE_CD			= pri.GOODS_PRICE_CD
				inner join	DAT_ORDER_DELIV_FEE		odf
					on	r.ORDER_NO					= odf.ORDER_NO
					and	r.ORDER_DELIV_FEE_NO		= odf.ORDER_DELIV_FEE_NO
				inner join	DAT_DELIV_POLICY		dp
					on	dp.DELIV_POLICY_NO			= odf.DELIV_POLICY_NO
					and dp.USE_YN					= 'Y'
				left join	COD_DELIV_COMPANY		dCom
					on	dp.DELIV_COMPANY_CD			= dCom.DELIV_COMPANY_CD

				left join	DAT_DELIV_POLICY_PATTERN	dpp
					on dpp.DELIV_POLICY_NO				= dp.DELIV_POLICY_NO

			where
				r.ORDER_REFER_NO = '".$order_refer_no."'


		";

        $db = self::_slave_db();
//		var_dump($query);
        return $db->query($query)->row_array();

    }

    /**
     *	택배업체
     */
    public function get_delivery_company()
    {
        $query = "
			select	/*  > etah_mfront > mywiz_m > get_delivery_company > ETAH 택배업체*/
					DELIV_COMPANY_CD
					, CD_NM
			from 	COD_DELIV_COMPANY
			order by	CD_NM
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();

    }

    /**
     *	반품 수거 유형
     */
    public function get_return_collection_type()
    {
        $query = "
			select	/*  > etah_mfront > mywiz_m > get_return_collection_type > ETAH 반품 수거 유형*/
					RETURN_COLLECTION_TYPE_CD
					, RETURN_COLLECTION_TYPE_CD_NM
			from 	COD_RETURN_COLLECTION_TYPE_CD
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();

    }

    /**
     *	반품 배송비 결제 방식
     */
    public function get_return_pay_type()
    {
        $query = "
			select	/*  > etah_mfront > mywiz_m > get_return_pay_type > ETAH 반품 배송비 결제 방식*/
					RETURN_DELIVFEE_PAY_WAY_CD
					, RETURN_DELIVFEE_PAY_WAY_CD_NM
			from 	COD_RETURN_DELIVFEE_PAY_WAY_CD
			where	RETURN_DELIVFEE_PAY_WAY_CD in ('02')
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();

    }

    /**
     * 취소/반품 데이터 생성
     */
    public function register_order_cancel($param)
    {
        $query = "
			insert into DAT_ORDER_REFER_CANCEL_RETURN (   /*  > etah_mfront > mywiz_m > register_order_cancel > ETAH 취소 데이터 생성 */
				CANCEL_RETURN_GB_CD
				, ORDER_REFER_NO
				, SELLER_CANCEL_RETURN_ORDER_REFER_NO
				, REQ_DT
				, QTY
				, CANCEL_PAID_PRICE
				, CANCEL_PAID_PRICE_LAST
				, CANCEL_RETURN_REASON_CD
				, CANCEL_RETURN_REASON_ETC_VAL
			)values(
				'".$param['gb']."'
				, '".$param['order_refer_no']."'
				, ''
				, now()
				, '".$param['qty']."'
				, ''
				, ''
				, '".$param['reason']."'
				, '".$param['reason_detail']."'
			)
		";

        $db = self::_master_db();
        $result = $db->query($query);
        $rs_identity = $db->insert_id();

        return $rs_identity;
    }

    /**
     * 취소/반품 데이터 생성
     */
    public function register_order_return($param)
    {
        $attributable_reason_cd = "";
        switch($param['reason']){
            case '01' : $attributable_reason_cd = "CUST"; break;
            case '02' : $attributable_reason_cd = "ETAH"; break;
            case '03' : $attributable_reason_cd = "CUST"; break;
            case '04' : $attributable_reason_cd = "VENDOR"; break;
            case '99' : $attributable_reason_cd = "ETC"; break;
        }

        $query = "
			insert into DAT_ORDER_REFER_CANCEL_RETURN (   /*  > etah_mfront > mywiz_m > register_order_return > ETAH 반품 데이터 생성 */
				CANCEL_RETURN_GB_CD
				, ORDER_REFER_NO
				, SELLER_CANCEL_RETURN_ORDER_REFER_NO
				, REQ_DT
				, QTY
				, FIRST_DELIV_COST
				, RETURN_DELIVFEE_PAY_WAY_CD
				, RETURN_DELIV_COST
				, RETURN_ATTRIBUTABLE_REASON_CD
				, RETURN_COLLECTION_TYPE_CD

		";
        if($param['deli_type'] == 01){
            $query .= "
				, RETURN_INVOICE_NO
				, RETURN_INVOICE_REG_DT
			";
        }
        $query .= "
				, RETURN_DELIV_COMPANY_CD
				, CANCEL_RETURN_REASON_CD
				, CANCEL_RETURN_REASON_ETC_VAL
			)values(
				'".$param['gb']."'
				, '".$param['order_refer_no']."'
				, ''
				, now()
				, '".$param['qty']."'
				, '".$param['first_deli_cost']."'
				, '".$param['deli_cost_type']."'
				, '".$param['deli_cost']."'
				, '".$attributable_reason_cd."'
				, '".$param['deli_type']."'
		";
        if($param['deli_type'] == 01){
            $query .= "
				, '".$param['invoice_no']."'
				, '".$param['invoice_date']." 00:00:00'
			";
        }
        $query .= "
				, '".$param['deli_com']."'
				, '".$param['reason']."'
				, '".$param['reason_detail']."'
			)
		";

        $db = self::_master_db();
        $result = $db->query($query);
        $rs_identity = $db->insert_id();

        return $rs_identity;
    }

    /**
     * 취소/반품 첨부파일 등록
     */
    public function register_order_return_file_path($file_path, $return_no)
    {
        $cust_no = $this->session->userdata('EMS_U_NO_');

        $query = "
            insert into MAP_ORDER_REFER_CANCEL_RETURN_FILE_PATH (    /*  > etah_mfront > mywiz_m > register_order_return_file_path > ETAH 취소/반품 첨부파일 등록 */
                ORDER_REFER_CANCEL_RETURN_NO
                , FILE_PATH
                , REG_USER_CD
            )values(
                '".$return_no."'
                , '".$file_path."'
                , '".$cust_no."'
            )
        ";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 주문 상태 생성
     */
    public function register_order_refer_progress($param, $cancel_return_no)
    {
        $query = "
			insert into DAT_ORDER_REFER_PROGRESS (     /*  > etah_mfront > mywiz_m > register_order_refer_progress > ETAH 주문 상태 생성 */
				ORDER_REFER_NO
				, ORDER_REFER_PROC_STS_CD
				, ORDER_REFER_CANCEL_RETURN_NO
			)values(
				  '".$param['order_refer_no']."'
				, '".$param['state_cd']."'
				, '".$cancel_return_no."'
			)
		";

        $db = self::_master_db();
        $result = $db->query($query);
        $rs_identity = $db->insert_id();

        return $rs_identity;
    }

    /**
     * 주문상태 업데이트
     */
    public function update_order_refer($param, $progress_no)
    {
        $query = "
			update	DAT_ORDER_REFER    /*  > etah_mfront > mywiz_m > update_order_refer > ETAH 주문상태 업데이트 */
			set		ORDER_REFER_PROC_STS_NO = '".$progress_no."'
			where	ORDER_REFER_NO = '".$param['order_refer_no']."'
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 기존 데이터 N
     */
    public function update_cancel_return_ues_yn($param)
    {
        $query = "
			update 	DAT_ORDER_REFER_CANCEL_RETURN    /*  > etah_mfront > mywiz_m > update_cancel_return_ues_yn > 기존 데이터 N */
			set		USE_YN = 'N'
			where 	ORDER_REFER_NO		= '".$param['order_refer_no']."'
			and		USE_YN				= 'Y'
			and		CANCEL_RETURN_GB_CD = '".$param['gb']."'
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 상품평을 남겼을시 마일리지 적립
     */
    public function insert_mileage_comment($param){
        $db = self::_master_db();

        $query1 = "
				insert into	DAT_CUST_MILEAGE    /*  > etah_mfront > mywiz_m > insert_mileage_comment > 마일리지 적립*/
				(CUST_NO,SAVE_MILEAGE_AMT, MILEAGE_AMT, REG_USER_CD)
				values(
					?, ?, ?, 14)
					on duplicate key update 
						CUST_NO= ?
						, SAVE_MILEAGE_AMT=SAVE_MILEAGE_AMT+ ?
						, MILEAGE_AMT=MILEAGE_AMT+ ?
			";

        $db->query($query1, array($param['mem_no'], $param['mileage'],$param['mileage'],$param['mem_no'],$param['mileage'],$param['mileage']));

        $query2 = "
				insert into	DAT_CUST_MILEAGE_SAVING   /*  > etah_mfront > mywiz_m > insert_mileage_comment > 마일리지 적립 */
				(CUST_NO,ORDER_REFER_NO, ORDER_DT, MILEAGE_SAVING_AMT, SAVE_YN,
				 SAVE_DT, SAVING_REASON_GB_CD, SAVING_REASON_ETC, REG_USER_CD)
				values(
					?, ?, ?, ?, 'Y', now(), 'OTHER', '상품평 적립', 14)
			";

        $db->query($query2, array($param['mem_no'], $param['order_refer_code'], null,$param['mileage']));
    }

    public function get_payinfo($param)
    {
        $query = "select    /*  > etah_mfront > mywiz_m > get_payinfo > 결제정보 조회 */
								  PAY.PAY_NO 										as PAY_NO
								, PAY.ORDER_AMT										as ORDER_AMT					
								, PAY.DELIV_COST_AMT								as DELIV_COST_AMT				
								, PAY.DC_AMT										as DC_AMT						
								, PAY.MILEAGE_AMT									as MILEAGE_AMT				
								, PAY.REAL_PAY_AMT									as REAL_PAY_AMT				
								, PAY.TOTAL_PAY_SUM									as TOTAL_PAY_SUM			
								, O.ORDER_NO										as ORDER_NO
								
					from
								DAT_ORDER	O
								inner join DAT_ORDER_REFER R
								   on R.ORDER_NO = O.ORDER_NO
								inner join DAT_ORDER_DELIV	DLV
									on O.ORDER_NO									= DLV.ORDER_NO
								left outer join DAT_ORDER_PAY	PAY
									on O.ORDER_NO									= PAY.ORDER_NO
								left outer join DAT_ORDER_PAY_DTL	PAY_DTL
									on PAY.PAY_NO									= PAY_DTL.PAY_NO
									and PAY_DTL.ORDER_PAY_KIND_CD					in ('01','02','03','04','05','06','07','08','09')
								left outer join COD_ORDER_PAY_STS_CD	PAY_STATE_M2
									on PAY_DTL.ORDER_PAY_DTL_STS_CD					= PAY_STATE_M2.ORDER_PAY_STS_CD
								left outer join COD_ORDER_PAY_KIND_CD	MP2
									on PAY_DTL.ORDER_PAY_KIND_CD					= MP2.ORDER_PAY_KIND_CD
								left outer join COD_ORDER_PAY_STS_CD	PAY_STATE_M1
									on PAY.ORDER_PAY_STS_CD							= PAY_STATE_M1.ORDER_PAY_STS_CD
								
					where
								1 = 1
								and R.ORDER_REFER_NO								= ?
					";
        $db = self::_slave_db();
        $result = $db->query($query, $param)->row_array();
        //$rs_identity = $db->insert_id();

        return $result;
    }

    /**
     * 카카오 알리미 발송
     * 2018.07.12
     */
    //발송 대상 주문데이터 조회
    public function get_Orderinfo($param)
    {
        $db = self::_slave_db();

        $query = "select R.ORDER_NO   /*  > etah_mfront > mywiz_m > get_Orderinfo > 발송 대상 주문데이터 조회 */
                        , R.GOODS_NM                      as GOODS_NM
                        , R.SELLING_PRICE                 as SELLING_PRICE
                        , P.REAL_PAY_AMT
                        ,(select d.SENDER_MOB_NO  
                          from DAT_ORDER_DELIV d 
                          where d.ORDER_NO = R.ORDER_NO) as SENDER_MOB_NO
                        ,(select d.RECEIVER_MOB_NO  
                          from DAT_ORDER_DELIV d 
                          where d.ORDER_NO = R.ORDER_NO) as RECEIVER_MOB_NO 
                  from DAT_ORDER_REFER R
                  
                  left join DAT_ORDER_PAY P
                  on R.ORDER_NO = P.ORDER_NO
                  
                  where R.ORDER_REFER_NO = ?";
        $row = $db->query($query, $param['order_refer_no'])->row_array();
//        log_message('DEBUG','============='.$db->last_query());
        return  $row;
    }

    public function send_sms_kakao($kakao)
    {
        $mdb = self::_master_db();
        $mdb->trans_begin();

        self::insert_table('DAT_SMS_MSG',$kakao);

        if ( $mdb->trans_status() === FALSE ){
            $mdb->trans_rollback();
            return false;
        }else{
            $mdb->trans_commit();
            return true;
        }
    }

    /**
     * ETAH 회원정보로 sns 데이터 구하기
     */
    public function get_snsdata()
    {
        $cust_no = $this->session->userdata('EMS_U_NO_');

        $query="select	/*  > etah_mfront > mywiz_m > get_snsdata > ETAH 회원정보로 sns 데이터 구하기 */
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
					, group_concat(cs.SNS_KIND_CD) as SNS_KIND_CD

			from	DAT_CUST c
			
			inner join DAT_CUST_SNS cs
			on cs.CUST_NO = c.CUST_NO
			
			where c.CUST_NO = '".$cust_no."'
			and c.USE_YN = 'Y' and c.SNS_YN = 'Y'";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }
}