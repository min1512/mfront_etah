<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_m extends CI_Model {

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

		/* ����Ÿ���̽� ���� */
		$this->load->helper('array');
		$database = random_element(config_item('slave'));
		$this->sdb = $this->load->database($database,TRUE);

		return $this->sdb;
	}

	private function _master_db()
	{
		if( ! empty($this->mdb) ) return $this->mdb;

		/* ����Ÿ���̽� ���� */
		$this->load->helper('array');
		$database = random_element(config_item('master'));
		$this->mdb = $this->load->database($database,TRUE);

		return $this->mdb;
	}

	/**
	 * FAQ ����Ʈ
	 */
	public function get_faq_list($param)
	{
		$limit_num_rows         = $param['limit_num_rows'];
        $startPos               = ($param['page'] - 1) * $limit_num_rows;
		$query_keyword			= "";
		$query_type				= "";

		if($limit_num_rows)		$query_limit = "limit $startPos, $limit_num_rows ";
		if($param['keyword'])	$query_keyword = "\nand f.TITLE like '%".$param['keyword']."%'";
		if($param['type'] && $param['type'] != 'SEARCH'){
			$str_type = "";
			$arr_type = explode('__',$param['type']);
			if(count($arr_type) > 1){
				foreach($arr_type as $type){
					$str_type .= ", '".$type."'";
				}
				$str_type = substr($str_type,1);

			}else{
				$str_type = "'".$param['type']."'";
			}
			$query_type = "\nand q.CS_QUE_TYPE_CD in (".$str_type.")";

		}

		$query = "
			select 	/*  > etah_mfront > customer_m > get_faq_list > FAQ 리스트 */
				f.FAQ_NO
				, f.TITLE
				, f.CS_QUE_TYPE_CD
				, f.REG_DT
				, c.CONTENT
				, q.CS_QUE_TYPE_CD_NM

			from
				DAT_FAQ f
				inner join	DAT_FAQ_CONTENT		c
					on	 f.FAQ_NO 				= c.FAQ_NO
				inner join	COD_CS_QUE_TYPE_CD	q
					on	f.CS_QUE_TYPE_CD 		= q.CS_QUE_TYPE_CD
			where
				f.USE_YN = 'Y'
			$query_keyword
			$query_type

			order by
				f.REG_DT

			$query_limit

		";

		$db = self::_slave_db();
//		var_dump($query);
		return $db->query($query)->result_array();
	}

	/**
	 * FAQ ����Ʈ ����
	 */
	public function get_faq_list_count($param)
	{
		$query_keyword			= "";
		$query_type				= "";

		if($param['keyword'])	$query_keyword = "\nand f.TITLE like '%".$param['keyword']."%'";
		if($param['type'] && $param['type'] != 'SEARCH'){
			$str_type = "";
			$arr_type = explode('__',$param['type']);
			if(count($arr_type) > 1){
				foreach($arr_type as $type){
					$str_type .= ", '".$type."'";
				}
				$str_type = substr($str_type,1);
			}else{
				$str_type = "'".$param['type']."'";
			}
			$query_type = "\nand q.CS_QUE_TYPE_CD in (".$str_type.")";

		}

		$query = "
			select 	/*  > etah_mfront > customer_m > get_faq_list_count > FAQ 리스트 개수 */
				count(f.FAQ_NO)				as total_cnt

			from
				DAT_FAQ f
				inner join	DAT_FAQ_CONTENT		c
					on	 f.FAQ_NO 				= c.FAQ_NO
				inner join	COD_CS_QUE_TYPE_CD	q
					on	f.CS_QUE_TYPE_CD 		= q.CS_QUE_TYPE_CD
			where
				f.USE_YN = 'Y'
			$query_keyword
			$query_type
		";

		$db = self::_slave_db();
		$result = $db->query($query)->row_array();
		return $result['total_cnt'];
	}

	/**
	 * ���� �о�
	 */
	public function get_qna_type_list()
	{
		$query = "
			select 	/*  > etah_mfront > customer_m > get_qna_type_list > ETAH 문의유형 코드 */
					CS_QUE_TYPE_CD
					, CS_QUE_TYPE_CD_NM
					, case
						when CS_QUE_TYPE_CD = 'MEMBER'		then 1
						when CS_QUE_TYPE_CD = 'GOODS'		then 2
						when CS_QUE_TYPE_CD = 'ORDER'		then 3
						when CS_QUE_TYPE_CD = 'SHIPPING'	then 4
						when CS_QUE_TYPE_CD = 'CANCEL'		then 5
						when CS_QUE_TYPE_CD = 'RETURN'		then 6
						when CS_QUE_TYPE_CD = 'CHANGE'		then 7
						when CS_QUE_TYPE_CD = 'PAY'			then 8
						when CS_QUE_TYPE_CD = 'MILEAGE'		then 9
						when CS_QUE_TYPE_CD = 'COUPON'		then 10
						when CS_QUE_TYPE_CD = 'EVENT'		then 11
						when CS_QUE_TYPE_CD = 'ETC'			then 12

						end as RANK

			from 	COD_CS_QUE_TYPE_CD
			order by	RANK

		";

		$db = self::_slave_db();
		return $db->query($query)->result_array();
	}

	/**
	 * 1:1���� �ۼ� �� �ֹ�����
	 */
	public function get_order_list_by_customer($param)
	{
		$limit_num_rows         = $param['limit_num_rows'];
        $startPos               = ($param['page'] - 1) * $limit_num_rows;

		if($limit_num_rows)	$query_limit = "limit $startPos, $limit_num_rows ";

		$cust_no = $this->session->userdata('EMS_U_NO_');

		$query = "
			select 	/*  > etah_mfront > customer_m > get_order_list_by_customer > 1:1문의 리스트 */
				o.ORDER_NO
				, o.REG_DT
				, r.ORDER_REFER_NO
				, g.GOODS_CD
				, g.GOODS_NM
				, ifnull(g.PROMOTION_PHRASE,'')	as PROMOTION_PHRASE
				, i.IMG_URL
				, r.GOODS_OPTION_CD
				, r.GOODS_OPTION_NM
			from
				DAT_ORDER 	o
				inner join	DAT_ORDER_REFER 	r
				on 	o.ORDER_NO 					= r.ORDER_NO
				inner join	DAT_GOODS			g
				on	r.GOODS_CD 					= g.GOODS_CD
				inner join	DAT_GOODS_IMAGE	 	i
				on 	g.GOODS_CD					= i.GOODS_CD
				and i.TYPE_CD					= 'TITLE'
				inner join	DAT_GOODS_OPTION	op
				on 	r.GOODS_OPTION_CD			= op.GOODS_OPTION_CD

			where
				o.CUST_NO = '".$cust_no."'
			order by r.REG_DT desc
			$query_limit
		";

		$db = self::_slave_db();
//		var_dump($query);
		return $db->query($query)->result_array();
	}

	/**
	 * 1:1���� �ۼ� �� �ֹ����� ����
	 */
	public function get_order_list_count_by_customer($param)
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');

		$query = "
			select 	/*  > etah_mfront > customer_m > get_order_list_count_by_customer > 1:1문의 리스트 개수*/
				count(o.ORDER_NO)				as total_cnt

			from
				DAT_ORDER 	o
				inner join	DAT_ORDER_REFER 	r
				on 	o.ORDER_NO 					= r.ORDER_NO
				inner join	DAT_GOODS			g
				on	r.GOODS_CD 					= g.GOODS_CD
				inner join	DAT_GOODS_IMAGE	 	i
				on 	g.GOODS_CD					= i.GOODS_CD
				and i.TYPE_CD					= 'TITLE'
				inner join	DAT_GOODS_OPTION	op
				on 	r.GOODS_OPTION_CD			= op.GOODS_OPTION_CD

			where
				o.CUST_NO = '".$cust_no."'
		";

		$db = self::_slave_db();
		$result = $db->query($query)->row_array();
		return $result['total_cnt'];
	}

	/**
	 * 1:1���� ���
	 */
	 public function register_qna($param)
	{
		 $cust_id = $this->session->userdata('EMS_U_ID_');
		 $cust_no = $this->session->userdata('EMS_U_NO_');

		 if(!$cust_id) $cust_id = "GUEST";

		 $param['sms_yn'	] = empty($param['sms_yn'	]) ? 'N' : $param['sms_yn'	];
		 $param['email_yn'	] = empty($param['email_yn'	]) ? 'N' : $param['email_yn'];

		 $query = "
			insert into	DAT_CS(   /*  > etah_mfront > customer_m > register_qna > 1:1문의 등록*/
				CS_QUE_GB_CD
				, CS_QUE_TYPE_CD
		 ";
		 if($cust_id != 'GUEST'){
			$query .= ", CUST_NO";
		 }
		 $query .= "
				, EMAIL
				, EMAIL_REPLAY_YN
				, SMS_REPLAY_YN
				, QUE_CUST_NM
				, QUE_CUST_PHONE_NO
				, QUE_DT
				, SECRET_YN
			)values(
				'01'
				, '".$param['type']."'
		 ";
		 if($cust_id != 'GUEST'){
			$query .= " , '".$cust_no."'";
		 }
		 $query .= "
				, '".$param['email']."@".$param['email2']."'
				, '".$param['email_yn']."'
				, '".$param['sms_yn']."'
				, '".$param['name']."'
				, '".$param['phone']."'
				, now()
				, '".$param['secret_yn']."'
			)
		";

		$db = self::_master_db();
		$result = $db->query($query);
		$rs_identity = $db->insert_id();


		return $rs_identity;

	}

	/**
	 * 1:1���� CONENTS ���
	 */
	 public function register_qna_contents($param)
	{
//		 $cust_no = $this->session->userdata('EMS_U_NO_');

		 $query = "
			insert into	DAT_CS_CONTENTS_REPLY(     /*  > etah_mfront > customer_m > register_qna_contents > 1:1문의  CONENTS 등록*/
				CS_NO
				, KIND
				, TITLE
				, `CONTENTS`
			)values(
				'".$param['qna_no']."'
				, 'Q'
				, '".$param['title']."'
				, '".$param['content']."'
			)
		";

		$db = self::_master_db();
		$result = $db->query($query);
		$rs_identity = $db->insert_id();

		return $rs_identity;

	}

	/**
	 * 1:1���� �ֹ� ����
	 */
	 public function register_map_cs_n_order_refer($param)
	{
		 $cust_no = $this->session->userdata('EMS_U_NO_');

		 $query = "
			insert into	MAP_CS_N_ORDER_REFER (     /*  > etah_mfront > customer_m > register_map_cs_n_order_refer > 1:1문의 주문 매핑 등록 */
				CS_NO
				, ORDER_REFER_NO
			)values(
				'".$param['qna_no']."'
				,'".$param['order_refer_no']."'
			)
		";

		$db = self::_master_db();
		return $db->query($query);
	}

	/**
	 * 1:1���� �ֹ� ���� ����
	 */
	 public function update_map_cs_n_order_refer($param)
	{
		 $cust_no = $this->session->userdata('EMS_U_NO_');

		 $query = "
			update	MAP_CS_N_ORDER_REFER      /*  > etah_mfront > customer_m > update_map_cs_n_order_refer > 1:1문의 주문 매핑 수정 */
			set		ORDER_REFER_NO = '".$param['order_refer_no']."'
			where	CS_NO = '".$param['qna_no']."'
		 ";

		$db = self::_master_db();
		return $db->query($query);
	}

	/**
	 * 1:1���� ��ǰ ����
	 */
	 public function register_map_cs_n_goods($param)
	{
		 $cust_no = $this->session->userdata('EMS_U_NO_');

		 $query = "  
			insert into MAP_CS_N_GOODS (    /*  > etah_mfront > customer_m > register_map_cs_n_goods > 1:1문의 상품 매핑 */
				CS_NO
				, GOODS_CD
			)values(
				'".$param['qna_no']."'
				,'".$param['goods_cd']."'
			)
		";

		$db = self::_master_db();
		return $db->query($query);
	}

	/**
	 * 1:1���� ��� ��ǰ �ֹ� ����
	 */
	 public function register_map_cs_n_order_refer_cancel_return($param)
	{
//		 $cust_no = $this->session->userdata('EMS_U_NO_');

		 $query = "
			insert into MAP_CS_N_ORDER_REFER_CANCEL_RETURN (    /*  > etah_mfront > customer_m > register_map_cs_n_order_refer_cancel_return > 1:1문의 취반품 배핑 */
				CS_NO
				, GOODS_CD
			)values(
				'".$param['qna_no']."'
				,'".$param['order_refer_cancel_return']."'
			)
		";

		$db = self::_master_db();
		return $db->query($query);

	}

	/**
	 * 1:1���� ÷������ ��� ������Ʈ
	 */
	 public function update_cs_qna_file_path($title, $qna_no)
	{
		 $cust_no = $this->session->userdata('EMS_U_NO_');

		 $query = "
			update	DAT_CS    /*  > etah_mfront > customer_m > update_cs_qna_file_path > 1:1문의 첨부파일 업데이트 */
			set		FILE_PATH = '".$title."'

			where	CS_NO = '".$qna_no."'
		";

		$db = self::_master_db();
		return $db->query($query);

	}

	/**
	 * 1:1 ���� ����
	 */
	 public function update_qna($param)
	{
		 $param['sms_yn'	] = empty($param['sms_yn'	]) ? 'N' : $param['sms_yn'	];
		 $param['email_yn'	] = empty($param['email_yn'	]) ? 'N' : $param['email_yn'];

		 $query = "
			update	DAT_CS    /*  > etah_mfront > customer_m > update_qna > 1:1문의 수정 */
			set		CS_QUE_TYPE_CD = '".$param['type']."'
					, EMAIL = '".$param['email']."@".$param['email2']."'
					, EMAIL_REPLAY_YN = '".$param['email_yn']."'
					, SMS_REPLAY_YN = '".$param['sms_yn']."'
					, QUE_CUST_NM = '".$param['name']."'
					, QUE_CUST_PHONE_NO ='".$param['phone']."'

			where	CS_NO = '".$param['qna_no']."'
		";

		$db = self::_master_db();
		return $db->query($query);

	}

	/**
	 * 1:1 ���� ���� CONTENT
	 */
	 public function update_qna_content($param)
	{
		 $query = "
			update	DAT_CS_CONTENTS_REPLY   /*  > etah_mfront > customer_m > update_qna > 1:1문의 답변 수정 */
			set		TITLE = '".$param['title']."'
					, `CONTENTS` = '".$param['content']."'
			where	CS_NO = '".$param['qna_no']."'
			and		KIND = 'Q'
		";

		$db = self::_master_db();
		return $db->query($query);

	}

	/**
	 * ��������
	 */
    public function get_notice_list($param)
    {
        $limit_num_rows         = $param['limit_num_rows'];
        $startPos               = ($param['page'] - 1) * $limit_num_rows;

        if($limit_num_rows)		$query_limit = "limit $startPos, $limit_num_rows ";

        $query = "
			select 	/*  > etah_front > customer_m > get_notice_list > ETAH 공지사항 */
				t.NOTICE_NO                     as NOTICE_NO,
                t.TITLE                         as TITLE,
                t.REG_DT                        as REG_DT,    
                t.CONTENT                       as CONTENT,
                m.FILE_NAME                     as FILE_NAME,
                m.FILE_PATH                     as FILE_PATH
                FROM
                    (
                    select
                        n.NOTICE_NO,
                        n.TITLE,
                        n.REG_DT,
                        nc.CONTENT
                    from
                        DAT_NOTICE n
                        inner join DAT_NOTICE_CONTENT nc 
                        on n.NOTICE_NO = nc.NOTICE_NO
                    where
                        n.USE_YN = 'Y'
                        and n.MALL_DISP_YN = 'Y'
                    order by
                        n.NOTICE_NO DESC
                    ) t
                    LEFT JOIN 
                    (SELECT NOTICE_NO, 
                            USE_YN, 
                            GROUP_CONCAT(FILE_NAME) AS FILE_NAME,
                            GROUP_CONCAT(FILE_PATH) AS FILE_PATH 
                        FROM MAP_CUST_NOTICE_FILE_PATH
                        WHERE USE_YN = 'Y'
                        GROUP BY NOTICE_NO) m 
                    ON t.NOTICE_NO = m.NOTICE_NO
                where
                  1=1 OR m.USE_YN IS NULL
                order by
                  t.NOTICE_NO DESC
			$query_limit
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

	/**
	 * �������� ����
	 */
	public function get_notice_list_count($param)
	{
		$query = "
			select 	/*  > etah_mfront > customer_m > get_notice_list_count > ETAH 공지 리스트 개수 */
				count(n.NOTICE_NO)		as total_cnt
			from
				DAT_NOTICE n
				inner join	DAT_NOTICE_CONTENT 	nc
					on	n.NOTICE_NO 			= nc.NOTICE_NO
			where
				n.USE_YN = 'Y'
				and n.MALL_DISP_YN = 'Y'
		";

		$db = self::_slave_db();
		$result = $db->query($query)->row_array();
		return $result['total_cnt'];
	}

	/**
	 * �������� ��
	 */
    public function get_notice_detail($notice_no)
    {
        $query = "
			select 	/*  > etah_mfront > customer_m > get_notice_detail > ETAH �������� �������� */
				r.NOTICE_NO,
			r.TITLE,
			r.REG_DT,
			r.CONTENT,
			m.FILE_NAME,
			m.FILE_PATH
			 FROM			
			(select 
				n.NOTICE_NO
				, n.TITLE
				, n.REG_DT
				, nc.CONTENT
			from
				DAT_NOTICE n
				inner join DAT_NOTICE_CONTENT nc
					on n.NOTICE_NO = nc.NOTICE_NO
			where
				n.USE_YN = 'Y'
				and nc.USE_YN = 'Y') r
			LEFT JOIN
			(SELECT NOTICE_NO, 
                            USE_YN, 
                            GROUP_CONCAT(FILE_NAME) AS FILE_NAME,
                            GROUP_CONCAT(FILE_PATH) AS FILE_PATH 
                        FROM MAP_CUST_NOTICE_FILE_PATH
                        WHERE USE_YN = 'Y'
                        GROUP BY NOTICE_NO) m
         ON r.NOTICE_NO = m.NOTICE_NO
			WHERE r.NOTICE_NO = ".$notice_no."
		";

        $db = self::_slave_db();
        $result = $db->query($query)->row_array();
        return $result;
    }

	/**
	 * �ֱ� (3��) �ۼ��� �������� ��������
	 */
	 public function get_notice_3days()
	 {
		 $query = "
			select    /*  > etah_mfront > customer_m > get_notice_3days > ETAH 최근 3일간 등록된 공지  */
				n.NOTICE_NO
			from
				DAT_NOTICE		n
			where
				1 = 1
			and n.REG_DT >= date_format(date_add(now(), interval -3 day), '%Y%m%d%H%i%s')
			and n.USE_YN = 'Y'
			and n.MALL_DISP_YN = 'Y'
		";

		$db = self::_slave_db();
		$result = $db->query($query)->row_array();
		return $result;
	}

	/**
	 * 문의 게시판
     * 2018.10.24
	 */
	// ETAH Q&A 리스트
    public function get_qna_list($param)
    {
        $limit_num_rows = $param['limit_num_rows'];
        $startPos       = ($param['page'] - 1) * $limit_num_rows;

        if($limit_num_rows)		$query_limit = "limit $startPos, $limit_num_rows ";

        $query = "
			select	/*  > etah_mfront > customer_m > get_qna_list > ETAH Q&A 리스트 */
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
				, cs.SECRET_YN
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
				on	g.BRAND_CD					= b.BRAND_CD
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
			where
			1=1
			and cs.USE_YN = 'Y'
			and cs.CUST_NO is not null
			and cs.QUE_DT > '2018-10-29 17:00:00'
			order by
				cs.REG_DT desc
			$query_limit	
		";

        $sdb = self::_slave_db();
        $result = $sdb->query($query)->result_array();
        return $result;
    }

    // ETAH Q&A 리스트(count)
    public function get_qna_list_count($param)
    {

        $query = "
			select	/*  > etah_mfront > customer_m > get_qna_list_count > ETAH Q&A 리스트(count) */
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
		    1=1
		  	and cs.USE_YN = 'Y'
		  	and cs.CUST_NO is not null
		  	and cs.QUE_DT > '2018-10-29 17:00:00'
			order by
				cs.REG_DT

		";

        $db = self::_slave_db();
        $data = $db->query($query)->row_array();
        return $data['total_cnt'];
    }

    //ETAH Q&A 상세보기
    public function get_qna_detail($qna_no)
    {
        $query = "
			select 	/*  > etah_mfront > customer_m > get_qna_detail > ETAH Q&A 상세보기 */
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
				, cs.SECRET_YN
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
				on	g.BRAND_CD					= b.BRAND_CD
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
			where
			1=1
			and cs.USE_YN = 'Y'
			and cs.CS_NO = ?
			order by
				cs.REG_DT desc	
		";

        $sdb = self::_slave_db();
        $result = $sdb->query($query, $qna_no)->row_array();
        return $result;
    }
}