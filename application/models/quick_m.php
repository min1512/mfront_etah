<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quick_m extends CI_Model {

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
	 * 관심상품 정보 구하기
	 *
	 * @return bool
	 */
	public function get_wish_goods($page)
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');
		if( empty($cust_no)) return FALSE;

		$startPos = ($page - 1) * 6;

        $query = "
			select	/*  > etah_mfront > quick_m > get_wish_goods > ETAH 관심상품 정보 구하기 */
				ig.INTEREST_GOODS_NO
				, g.GOODS_NM
				, g.GOODS_CD
				, gi.IMG_URL
				, pri.SELLING_PRICE
				, b.BRAND_NM
				, ''						as GOODS_OPTION_NM
				
			from 
				DAT_CUST c
				inner join	DAT_INTEREST_GOODS 	ig
					on 	c.CUST_NO 				= ig.CUST_NO
					and ig.USE_YN				= 'Y'
				inner join	DAT_GOODS 			g
					on	ig.GOODS_CD 			= g.GOODS_CD
				inner join	DAT_GOODS_PROGRESS	p
					on	p.GOODS_PROGRESS_NO		= g.GOODS_PROGRESS_NO
					and p.USE_YN				= 'Y'
					and p.GOODS_STS_CD			= '03'
				inner join	DAT_BRAND			b
					on	g.BRAND_CD				= b.BRAND_CD
				inner join	DAT_GOODS_IMAGE		gi
					on	g.GOODS_CD 				= gi.GOODS_CD
					and gi.TYPE_CD				= 'TITLE'
				inner join	DAT_GOODS_PRICE		pri
					on	g.GOODS_CD				= pri.GOODS_CD
					and g.GOODS_PRICE_CD		= pri.GOODS_PRICE_CD
			where
				c.CUST_NO = '".$cust_no."'
			and c.USE_YN = 'Y'
			order by
				ig.UPD_DT desc
         
        ";
		$query .= "limit $startPos, 6";

		$db = self::_slave_db();
		return $db->query($query)->result_array();
	}

	/**
	 * 관심상품 정보 count
	 *
	 * @return bool
	 */
	public function get_wish_goods_count()
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');
		if( empty($cust_no)) return 0;

        $query = "
           select	/*  > etah_mfront > quick_m > get_wish_goods_count > 관심상품 정보 count */
				count(ig.INTEREST_GOODS_NO)		as total_cnt
				
				
			from 
				DAT_CUST c
				inner join	DAT_INTEREST_GOODS 	ig
					on 	c.CUST_NO 				= ig.CUST_NO
					and ig.USE_YN				= 'Y'
				inner join	DAT_GOODS 			g
					on	ig.GOODS_CD 			= g.GOODS_CD
				inner join	DAT_GOODS_PROGRESS	p
					on	p.GOODS_PROGRESS_NO		= g.GOODS_PROGRESS_NO
					and p.USE_YN				= 'Y'
					and p.GOODS_STS_CD			= '03'
				inner join	DAT_GOODS_IMAGE		gi
					on	g.GOODS_CD 				= gi.GOODS_CD
					and gi.TYPE_CD				= 'TITLE'
				inner join	DAT_GOODS_PRICE		pri
					on	g.GOODS_CD				= pri.GOODS_CD
					and g.GOODS_PRICE_CD		= pri.GOODS_PRICE_CD
			where
				c.CUST_NO = '".$cust_no."'
			and c.USE_YN = 'Y'
			order by
				ig.UPD_DT desc
        ";

		$db = self::_slave_db();
		$row = $db->query($query)->row_array();

		return $row['total_cnt'];
	}

	/**
	 * 장바구니에 담은 상품 가져오기
	 */
	public function get_cart_goods($page)
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');
		if( empty($cust_no)) return FALSE;

		$startPos = ($page - 1) * 2;

		$query = "
			select		/*  > etah_mfront > quick_m > get_cart_goods > ETAH 장바구니에 담은 상품 가져오기 */
				  c.CART_NO
				, c.GOODS_CD
				, g.GOODS_NM
				, gi.IMG_URL		
				, b.BRAND_NM
				, gp.SELLING_PRICE
				, go.GOODS_OPTION_NM

			from
				DAT_CART		c

			inner join	DAT_GOODS			g
				on	g.GOODS_CD				= c.GOODS_CD
				and g.USE_YN				= 'Y'
			inner join	DAT_GOODS_PROGRESS	p
				on	p.GOODS_PROGRESS_NO		= g.GOODS_PROGRESS_NO
				and p.USE_YN				= 'Y'
				and p.GOODS_STS_CD			= '03'
				inner join	DAT_GOODS_PRICE	gp
				on	gp.GOODS_CD				= g.GOODS_CD
				and gp.USE_YN				= 'Y'
				and g.GOODS_PRICE_CD		= gp.GOODS_PRICE_CD
			left join	DAT_GOODS_IMAGE		gi
				on	gi.GOODS_CD				= g.GOODS_CD
				and gi.TYPE_CD				= 'TITLE'
				and gi.USE_YN				= 'Y'
			inner join	DAT_BRAND			b
				on	b.BRAND_CD				= g.BRAND_CD
				and b.USE_YN				= 'Y'
			inner join	DAT_GOODS_OPTION	go
				on	go.GOODS_OPTION_CD		= c.GOODS_OPTION_CD
				and go.USE_YN				= 'Y'
	
			where
				1 = 1
			and c.USE_YN	= 'Y'
			and c.CUST_NO	= '".$cust_no."'
			
			order by
				c.CART_NO asc
			 
		";

		$query .= "limit $startPos, 2";

		$db = self::_slave_db();
		return $db->query($query)->result_array();
	}

	/**
	 * 장바구니에 담은 상품 개수
	 */
	public function get_cart_goods_count()
	{
		$cust_no = $this->session->userdata('EMS_U_NO_');
		if( empty($cust_no)) return 0;

		$query = "
			select		/*  > etah_mfront > quick_m > get_cart_goods_count > ETAH 장바구니에 담은 상품 개수 가져오기 */
				  count(c.CART_NO)			as total_cnt
			from
				DAT_CART		c

			inner join	DAT_GOODS			g
				on	g.GOODS_CD				= c.GOODS_CD
				and g.USE_YN				= 'Y'
			inner join	DAT_GOODS_PROGRESS	p
				on	p.GOODS_PROGRESS_NO		= g.GOODS_PROGRESS_NO
				and p.USE_YN				= 'Y'
				and p.GOODS_STS_CD			= '03'
				inner join	DAT_GOODS_PRICE	gp
				on	gp.GOODS_CD				= g.GOODS_CD
				and gp.USE_YN				= 'Y'
				and g.GOODS_PRICE_CD		= gp.GOODS_PRICE_CD
			left join	DAT_GOODS_IMAGE		gi
				on	gi.GOODS_CD				= g.GOODS_CD
				and gi.TYPE_CD				= 'TITLE'
				and gi.USE_YN				= 'Y'
			inner join	DAT_BRAND			b
				on	b.BRAND_CD				= g.BRAND_CD
				and b.USE_YN				= 'Y'

			where
				1 = 1
			and c.USE_YN	= 'Y'
			and c.CUST_NO	= '".$cust_no."'

			order by
				c.CART_NO asc
		";

		$db = self::_slave_db();
		$row = $db->query($query)->row_array();
//var_dump($query);
		return $row['total_cnt'];
	}

	/**
	 * 최근 본 상품 구하기
	 * @return int
	 */
	public function get_view_goods($page=null)
	{
		//만약 최근 검색한 상품데이타의 쿠키값이 없다면 0갯수를 리턴
		$cookie_view_goods = get_cookie('VIEWGOODS');
		if( empty($cookie_view_goods)) return FALSE;

		/* 관심상품 */
		$query_interest_s = "";
		$query_interest_j = "";
		
		$cust_id = $this->session->userdata('EMS_U_ID_');
		$cust_no = $this->session->userdata('EMS_U_NO_');
		if($cust_id != 'GUEST'){
			$query_interest_s = "
				, ig.INTEREST_GOODS_NO
			";
			$query_interest_j = "
				left join DAT_INTEREST_GOODS ig
					on ig.GOODS_CD = t.GOODS_CD
					and ig.CUST_NO = '".$cust_no."'
					and ig.USE_YN = 'Y'
			";
		}

		$sort = array();
		$goods = array();
		$strGoodsCode = "";
		$arrGoodsCode = explode('|',$cookie_view_goods);
//var_dump($arrGoodsCode);
		if($page) {
			$startPos = ($page - 1) * 10;
			$e = ($startPos+10);
		} else {
			$startPos = 0;
			$e = 20;
		}

		if($arrGoodsCode){
			$idx = 0;
//			foreach($arrGoodsCode as $goods_cd){
//				$strGoodsCode .= ",'".$goods_cd."'";
//				$sort[$goods_cd] = $idx;
//				$idx++;
//			}
			for($i=$startPos; $i<$e; $i++){
				if(isset($arrGoodsCode[$i])){
					$strGoodsCode .= ",'".$arrGoodsCode[$i]."'";
					$sort[$arrGoodsCode[$i]] = $idx;
					$idx++;
				}
			}
			$strGoodsCode = substr($strGoodsCode,1);
		}

//		var_dump($sort);


//var_dump($startPos);
//		$query = "
//			select	/*  > etah_front > quick_m > get_new_goods > ETAH 최근 본 상품 */
//					g.GOODS_CD
//					, g.GOODS_NM
//					, b.BRAND_NM
//					, i.IMG_URL
//					, pri.SELLING_PRICE
//					, ''					as GOODS_OPTION_NM
//			from	DAT_GOODS g
//			inner join	DAT_BRAND 			b
//				on	g.BRAND_CD 				= b.BRAND_CD
//			inner join	DAT_GOODS_PROGRESS 	p
//				on	g.GOODS_CD 				= p.GOODS_CD
//				and	g.GOODS_PROGRESS_NO 	= p.GOODS_PROGRESS_NO
//			--	and	p.GOODS_STS_CD 			= '03'
//			inner join	DAT_GOODS_PRICE
//			pri
//				on	g.GOODS_CD				= pri.GOODS_CD
//				and	g.GOODS_PRICE_CD		= pri.GOODS_PRICE_CD
//			inner join	DAT_GOODS_IMAGE 	i
//				on	g.GOODS_CD 				= i.GOODS_CD
//				and	i.TYPE_CD 				= 'TITLE'
//
//
//			where	g.GOODS_CD in (".$strGoodsCode.")
//			and		g.USE_YN = 'Y'
//		";

$query = "
		
			select /*  > etah_mfront > quick_m > get_view_goods > ETAH 최근 본 상품 구하기 */
				t.GOODS_CD
				, t.GOODS_NM
				, t.PROMOTION_PHRASE
				, t.BRAND_CD
				, t.BRAND_NM
			--	, t.CATEGORY_DISP_CD
			--	, t.CATEGORY_DISP_NM
				, t.SELLING_PRICE
				, gi.IMG_URL
				, dp.DELIV_POLICY_NO
				, dp.PATTERN_TYPE_CD
				, max(dpp.DELIV_COST_DECIDE_VAL)					as DELI_LIMIT
			--	, max(dpp.DELIV_COST)								as DELI_COST
			/*	, sum(if(cpn.MAX_DISCOUNT > 0,
					if(round(t.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)) > cpn.MAX_DISCOUNT, cpn.MAX_DISCOUNT,
					 round(t.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000))),
					 round(t.SELLING_PRICE * (cpn.COUPON_FLAT_RATE / 1000)))
				 )													as RATE_PRICE
				, sum(cpn.COUPON_FLAT_AMT)							as AMT_PRICE	*/
				, if(round(t.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)) > cpn_s.MAX_DISCOUNT && cpn_s.MAX_DISCOUNT != 0, cpn_s.MAX_DISCOUNT, round(t.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)))		as RATE_PRICE_S
				, if(round(t.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)) > cpn_g.MAX_DISCOUNT && cpn_g.MAX_DISCOUNT != 0, cpn_g.MAX_DISCOUNT, round(t.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)))		as RATE_PRICE_G
				, ifnull(cpn_s.COUPON_FLAT_AMT, 0)					as AMT_PRICE_S
				, ifnull(cpn_g.COUPON_FLAT_AMT, 0)					as AMT_PRICE_G
				, cpn_s.COUPON_CD									as COUPON_CD_S
				, cpn_g.COUPON_CD									as COUPON_CD_G
				, ifnull(mileage.GOODS_MILEAGE_SAVE_RATE, 0)		as GOODS_MILEAGE_SAVE_RATE
				$query_interest_s

			from
			(
				select
					g.GOODS_CD
					, g.GOODS_NM
					, g.PROMOTION_PHRASE
					, g.BRAND_CD
					, g.GOODS_MILEAGE_N_GOODS_NO
					, g.DELIV_POLICY_NO
					, b.BRAND_NM
				--	, c.CATEGORY_DISP_CD
				--	, c.CATEGORY_DISP_NM
					, pri.SELLING_PRICE
					, sort.GOODS_SORT_SCORE



				from
					DAT_GOODS 				g
				inner join	DAT_BRAND 					b
					on	g.BRAND_CD 						= b.BRAND_CD
				--	and b.MOB_DISP_YN					= 'Y'
			/*	inner join	MAP_CATEGORY_DISP_N_GOODS	m
					on	g.GOODS_CD						= m.GOODS_CD
				inner join	DAT_CATEGORY_DISP 			c
					on	m.CATEGORY_DISP_CD 				= c.CATEGORY_DISP_CD
			*/
				inner join	DAT_GOODS_PRICE 			pri
					on	g.GOODS_CD 						= pri.GOODS_CD
					and g.GOODS_PRICE_CD 				= pri.GOODS_PRICE_CD
				inner join	DAT_GOODS_PROGRESS			gp
					on	g.GOODS_CD 						= gp.GOODS_CD
					and g.GOODS_PROGRESS_NO 			= gp.GOODS_PROGRESS_NO
					and	gp.GOODS_STS_CD					= '03'
				inner join	COD_GOODS_STS_CD			gs
					on	gp.GOODS_STS_CD 				= gs.GOODS_STS_CD
		/*		inner join	(	select	distinct
										mc.GOODS_CD
								from	MAP_CATEGORY_DISP_N_GOODS 	mc
								inner join	DAT_CATEGORY_DISP 		c
									on	mc.CATEGORY_DISP_CD 		= c.CATEGORY_DISP_CD
									and	c.USE_YN 					= 'Y'
								--	and	c.MOB_DISP_YN				= 'Y'
								where	mc.USE_YN					= 'Y'
							) m
					on	g.GOODS_CD						= m.GOODS_CD
					*/
					
                inner join MAP_CATEGORY_DISP_N_GOODS mc
                on mc.GOODS_CD = g.GOODS_CD
                and mc.USE_YN = 'Y'
                
                inner join DAT_CATEGORY_DISP c
                on mc.CATEGORY_DISP_CD = c.CATEGORY_DISP_CD
                and c.USE_YN = 'Y'
					
				left join	DAT_GOODS_SORT_SCORE	sort
					on	g.GOODS_CD		= sort.GOODS_CD

				where
					1 = 1
				and g.MOB_DISP_YN = 'Y'

			) t

			inner join	DAT_GOODS_IMAGE					gi
				on 	t.GOODS_CD 							= gi.GOODS_CD
				and	gi.TYPE_CD							= 'TITLE'
			inner join	DAT_DELIV_POLICY				dp
				on	dp.DELIV_POLICY_NO					= t.DELIV_POLICY_NO
				and dp.USE_YN							= 'Y'
			left join	DAT_DELIV_POLICY_PATTERN		dpp
				on dpp.DELIV_POLICY_NO					= dp.DELIV_POLICY_NO
			left join	MAP_GOODS_MILEAGE_N_GOODS		mileage
				on	mileage.GOODS_MILEAGE_N_GOODS_NO	= t.GOODS_MILEAGE_N_GOODS_NO
				and mileage.USE_YN						= 'Y'
			left join	(	select	convert(mcp.COUPON_APPLICATION_SCOPE_OBJECT_CD, UNSIGNED) AS COUPON_APPLICATION_SCOPE_OBJECT_CD
									, cpn_s.COUPON_CD
									, cpn_s.COUPON_DC_METHOD_CD
									, cpn_s.COUPON_FLAT_RATE
									, cpn_s.COUPON_FLAT_AMT
									, cpn_s.MIN_AMT
									, cpn_s.MAX_DISCOUNT
							from
								MAP_COUPON_APPLICATION_SCOPE_OBJECT	 mcp
							inner join DAT_COUPON	cpn_s
								on	mcp.COUPON_CD					 = cpn_s.COUPON_CD
								and cpn_s.COUPON_KIND_CD				 in ('SELLER')
								and cpn_s.USE_YN						 = 'Y'
								and cpn_s.BUYER_COUPON_DUPLICATE_DC_YN = 'N'
								and	if(cpn_s.COUPON_START_DT is null,  1 = 1, cpn_s.COUPON_START_DT	<= now()	and cpn_s.COUPON_END_DT	>= now())

							inner join DAT_COUPON_PROGRESS cpp
								on	cpn_s.COUPON_PROGRESS_NO			= cpp.COUPON_PROGRESS_NO
								and cpp.COUPON_PROGRESS_STS_CD		= '03'
								and	cpp.USE_YN						= 'Y'
						) cpn_s
				on	t.GOODS_CD = cpn_s.COUPON_APPLICATION_SCOPE_OBJECT_CD

			left join	(	select	convert(mcp.COUPON_APPLICATION_SCOPE_OBJECT_CD, UNSIGNED) AS COUPON_APPLICATION_SCOPE_OBJECT_CD
									, cpn_g.COUPON_CD
									, cpn_g.COUPON_DC_METHOD_CD
									, cpn_g.COUPON_FLAT_RATE
									, cpn_g.COUPON_FLAT_AMT
									, cpn_g.MIN_AMT
									, cpn_g.MAX_DISCOUNT
							from
								MAP_COUPON_APPLICATION_SCOPE_OBJECT	 mcp
							inner join DAT_COUPON	cpn_g
								on	mcp.COUPON_CD					 = cpn_g.COUPON_CD
								and cpn_g.COUPON_KIND_CD				 in ('GOODS')
								and cpn_g.USE_YN						 = 'Y'
								and cpn_g.BUYER_COUPON_DUPLICATE_DC_YN = 'N'
								and	if(cpn_g.COUPON_START_DT is null,  1 = 1, cpn_g.COUPON_START_DT	<= now()	and cpn_g.COUPON_END_DT	>= now())

							inner join DAT_COUPON_PROGRESS cpp
								on	cpn_g.COUPON_PROGRESS_NO			= cpp.COUPON_PROGRESS_NO
								and cpp.COUPON_PROGRESS_STS_CD		= '03'
								and	cpp.USE_YN						= 'Y'
						) cpn_g
				on	t.GOODS_CD = cpn_g.COUPON_APPLICATION_SCOPE_OBJECT_CD
				$query_interest_j

			where t.GOODS_CD in (".$strGoodsCode.")

			group by
				t.GOODS_CD

";



//		$query .= "limit 0, 6";

//var_dump($query);
		$db = self::_slave_db();
		$result = $db->query($query)->result_array();

		foreach($result as $row){
			$sort_idx = $sort[$row['GOODS_CD']];
			$goods[$sort_idx] = $row;
		}
//var_dump($goods);
		$result = array();
		for($i=0; $i<=count($goods); $i++){
			if(isset($goods[$i])){
				$result[$i] = $goods[$i];
			}
		}
//var_dump($result);
		return $result;
	}
	public function get_view_goods2($page=null)
    {

        $cookie_view_goods = get_cookie('VIEWGOODS');
        if( empty($cookie_view_goods)) return FALSE;

        /* 관심상품 */
        $query_interest_s = "";
        $query_interest_j = "";

        $cust_id = $this->session->userdata('EMS_U_ID_');
        $cust_no = $this->session->userdata('EMS_U_NO_');
        if($cust_id != 'GUEST'){
            $query_interest_s = "
				, ig.INTEREST_GOODS_NO
			";
            $query_interest_j = "
				left join DAT_INTEREST_GOODS ig
					on ig.GOODS_CD = t.GOODS_CD
					and ig.CUST_NO = '".$cust_no."'
					and ig.USE_YN = 'Y'
			";
        }

        $sort = array();
        $goods = array();
        $strGoodsCode = "";
        $arrGoodsCode = explode('|',$cookie_view_goods);
        if($page) {
            $startPos = ($page - 1) * 10;
            $e = ($startPos+10);
        } else {
            $startPos = 0;
            $e = 20;
        }

        if($arrGoodsCode){
            $idx = 0;
            for($i=$startPos; $i<$e; $i++){
                if(isset($arrGoodsCode[$i])){
                    $strGoodsCode .= ",'".$arrGoodsCode[$i]."'";
                    $sort[$arrGoodsCode[$i]] = $idx;
                    $idx++;
                }
            }
            $strGoodsCode = substr($strGoodsCode,1);
        }
        $query = "select    /*  > etah_mfront > quick_m > get_view_goods2 > ETAH 최근 본 상품 구하기2 */
				  t.GOODS_CD
				, t.GOODS_NM
			--	, gi.IMG_URL
			    , ifnull(gim.IMG_URL, gi.IMG_URL)   as IMG_URL
				$query_interest_s
			from
			(
				select
					  g.GOODS_CD
					, g.GOODS_NM
				from
					DAT_GOODS 				g
				inner join	DAT_GOODS_PROGRESS			gp
					on	g.GOODS_CD 						= gp.GOODS_CD
					and g.GOODS_PROGRESS_NO 			= gp.GOODS_PROGRESS_NO
					and	gp.GOODS_STS_CD					= '03'
				inner join	COD_GOODS_STS_CD			gs
					on	gp.GOODS_STS_CD 				= gs.GOODS_STS_CD
				where
					1 = 1
				and g.MOB_DISP_YN = 'Y'

			) t

			inner join	DAT_GOODS_IMAGE					gi
				on 	t.GOODS_CD 							= gi.GOODS_CD
				and	gi.TYPE_CD							= 'TITLE'
            left join DAT_GOODS_IMAGE_MD               gim
			    on 	t.GOODS_CD 							= gim.GOODS_CD
				and	gim.TYPE_CD							= 'TITLE'
				$query_interest_j
			where t.GOODS_CD in (".$strGoodsCode.")
			group by
				t.GOODS_CD
";
        $db = self::_slave_db();
        $result = $db->query($query)->result_array();

        foreach($result as $row){
            $sort_idx = $sort[$row['GOODS_CD']];
            $goods[$sort_idx] = $row;
        }
        $result = array();
        for($i=0; $i<=count($goods); $i++){
            if(isset($goods[$i])){
                $result[$i] = $goods[$i];
            }
        }
        return $result;
    }

	/**
	 * 최근 본 상품 개수
	 * @return int
	 */
	public function get_view_goods_count()
	{
		//만약 최근 검색한 상품데이타의 쿠키값이 없다면 0갯수를 리턴
		$cookie_view_goods = get_cookie('VIEWGOODS');
		if( empty($cookie_view_goods)) return 0;
		$strGoodsCode = "";
		$arrGoodsCode = explode('|',$cookie_view_goods);

		if($arrGoodsCode){
			foreach($arrGoodsCode as $goods_cd){
				$strGoodsCode .= ",'".$goods_cd."'";
			}
			$strGoodsCode = substr($strGoodsCode,1);
		}
//var_dump($strGoodsCode);

		$query = "
			select	/*  > etah_mfront > quick_m > get_view_goods_count > ETAH 최근 본 상품 개수 */
					count(g.GOODS_CD)	as total_cnt
					
			from	DAT_GOODS g
			inner join	DAT_BRAND 			b
				on	g.BRAND_CD 				= b.BRAND_CD
			inner join	DAT_GOODS_PROGRESS 	p
				on	g.GOODS_CD 				= p.GOODS_CD
				and	g.GOODS_PROGRESS_NO 	= p.GOODS_PROGRESS_NO
				and	p.GOODS_STS_CD 			= '03'
			inner join	DAT_GOODS_PRICE		pri
				on	g.GOODS_CD				= pri.GOODS_CD
				and	g.GOODS_PRICE_CD		= pri.GOODS_PRICE_CD
			inner join	DAT_GOODS_IMAGE 	i
				on	g.GOODS_CD 				= i.GOODS_CD
				and	i.TYPE_CD 				= 'TITLE'


			where	g.GOODS_CD in (".$strGoodsCode.")
			and		g.USE_YN = 'Y'
		";
//var_dump($query);
		$db = self::_slave_db();
		$row = $db->query($query)->row_array();

		return $row['total_cnt'];
	}

	/**
	 * 최근 본 상품 상품코드 걸러주기
	 * 
	 */
	public function checked_goods_code($goods_cd)
	{
		$str_goods_cd = "";
		foreach($goods_cd as $row){
			$str_goods_cd .= ",'".$row."'";
		}
		$str_goods_cd = substr($str_goods_cd,1);

		$query = "
			select	g.GOODS_CD    /*  > etah_mfront > quick_m > checked_goods_code > ETAH 최근 본 상품코드 걸러주기 */
			from	DAT_GOODS g
			inner join	DAT_GOODS_PROGRESS 	p
				on	g.GOODS_CD 				= p.GOODS_CD
				and	g.GOODS_PROGRESS_NO 	= p.GOODS_PROGRESS_NO
				and	p.GOODS_STS_CD 			= '03'
			where	g.GOODS_CD in (".$str_goods_cd.")
		";

		$db = self::_slave_db();
		$row = $db->query($query)->result_array();
//var_dump($query);
		return $row;
	}
	
}