<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart_m extends CI_Model {

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
     * 장바구니에 담은 상품 가져오기
     */
    public function get_cart_goods($cust_no)
    {
        $query = "
			select		/*  > etah_mfront > cart_m > get_cart_goods > ETAH 장바구니에 담은 상품 가져오기 */
				  c.CART_NO
				, c.CUST_NO
				, c.GOODS_CD
				, c.GOODS_OPTION_CD
				, c.CART_QTY		as GOODS_CNT
				, g.GOODS_NM
				, gp.GOODS_STS_CD
				, gp2.GOODS_STS_CD_NM
				, g.CATEGORY_MNG_CD
				, cm1.CATEGORY_MNG_CD		as CATEGORY_MNG_CD1
				, cm1.CATEGORY_NM			as CATEGORY_MNG_NM1
				, cm2.CATEGORY_MNG_CD		as CATEGORY_MNG_CD2
				, cm2.CATEGORY_NM			as CATEGORY_MNG_NM2
				, cm3.CATEGORY_MNG_CD		as CATEGORY_MNG_CD3
				, cm3.CATEGORY_NM			as CATEGORY_MNG_NM3
		--		, gi.IMG_URL		as GOODS_IMG
                , ifnull(gim.IMG_URL, gi.IMG_URL)   as GOODS_IMG
				, b.BRAND_CD
				, b.BRAND_NM
				, go.GOODS_OPTION_NM
				, ifnull(go.QTY, 0)			as GOODS_OPTION_QTY
				, ifnull(gop.GOODS_OPTION_ADD_PRICE, 0)		as GOODS_OPTION_ADD_PRICE
				, price.GOODS_PRICE_CD
				, price.SELLING_PRICE
				, price.STREET_PRICE
				, price.FACTORY_PRICE
				, ifnull(mileage.GOODS_MILEAGE_SAVE_RATE, 0)		as GOODS_MILEAGE_SAVE_RATE
				, concat(g.VENDOR_SUBVENDOR_CD,'_',g.DELIV_POLICY_NO)	as DELI_CODE
				, dp.PATTERN_TYPE_CD
				, max(dpp.DELIV_COST_DECIDE_VAL)		as DELI_LIMIT
				, max(dpp.DELIV_COST)					as DELI_COST
				, dp.DELIV_POLICY_NO
				, subvendor.SEND_NATION
				, g.BUY_LIMIT_CD
				, g.BUY_LIMIT_QTY
				, g.TAX_GB_CD

			from
				DAT_CART		c

			left join
				DAT_GOODS		g
			on	g.GOODS_CD	= c.GOODS_CD
			and g.USE_YN	= 'Y'

			inner join
				DAT_CATEGORY_MNG		cm3
			on g.CATEGORY_MNG_CD				= cm3.CATEGORY_MNG_CD

			inner join
				DAT_CATEGORY_MNG		cm2
			on cm3.PARENT_CATEGORY_MNG_CD		= cm2.CATEGORY_MNG_CD

			inner join
				DAT_CATEGORY_MNG		cm1
			on	cm2.PARENT_CATEGORY_MNG_CD		= cm1.CATEGORY_MNG_CD
			and cm1.PARENT_CATEGORY_MNG_CD		IS NULL

			inner join
				DAT_GOODS_PROGRESS		gp
			on	gp.GOODS_PROGRESS_NO	= g.GOODS_PROGRESS_NO
			and gp.USE_YN			= 'Y'
		--	and gp.GOODS_STS_CD		= '03'

			inner join
				COD_GOODS_STS_CD		gp2
			on	gp2.GOODS_STS_CD	= gp.GOODS_STS_CD

			inner join
				DAT_GOODS_PRICE		price
			on	price.GOODS_PRICE_CD	= g.GOODS_PRICE_CD
			and price.USE_YN	= 'Y'

			left join
				MAP_GOODS_MILEAGE_N_GOODS		mileage
			on  mileage.GOODS_MILEAGE_N_GOODS_NO	= g.GOODS_MILEAGE_N_GOODS_NO
			and mileage.USE_YN	= 'Y'

			left join
				DAT_GOODS_IMAGE		gi
			on	gi.GOODS_CD = g.GOODS_CD
			and gi.TYPE_CD	= 'TITLE'
			and gi.USE_YN	= 'Y'
			
			left join
				DAT_GOODS_IMAGE_MD		gim
			on	gim.GOODS_CD = g.GOODS_CD
			and gim.TYPE_CD	= 'TITLE'
			and gim.USE_YN	= 'Y'

			inner join
				DAT_GOODS_OPTION		go
			on	go.GOODS_OPTION_CD	= c.GOODS_OPTION_CD
		--	and go.QTY				!= 0
			and go.USE_YN			= 'Y'

			left join
				DAT_GOODS_OPTION_PRICE		gop
			on gop.GOODS_OPTION_PRICE_NO	= go.GOODS_OPTION_PRICE_NO
			and gop.USE_YN	= 'Y'

			inner join
				DAT_BRAND			b
			on	b.BRAND_CD	= g.BRAND_CD
			and b.USE_YN	= 'Y'

			inner join
				DAT_DELIV_POLICY		dp
			on	dp.DELIV_POLICY_NO	= g.DELIV_POLICY_NO
			and dp.USE_YN			= 'Y'

			left join
				DAT_DELIV_POLICY_PATTERN		dpp
			on dpp.DELIV_POLICY_NO	= dp.DELIV_POLICY_NO

			left join
				DAT_VENDOR_SUBVENDOR			subvendor
			on subvendor.VENDOR_SUBVENDOR_CD		= g.VENDOR_SUBVENDOR_CD

			where
				1 = 1
			and c.USE_YN	= 'Y'
			and c.CUST_NO	= '".$cust_no."'

			group by
				c.CART_NO
			order by
				c.CART_NO asc
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }


    /**
     * 해당 상품의 쿠폰 정보 가져오기
     */
    public function get_coupon_info($param, $METHOD)
    {
        if($METHOD == 'AUTO'){	//기본 자동 할인
            $query = "
				select		/*  > etah_mfront > cart_m > get_coupon_info > 상품에 해당하는 쿠폰 정보 가져오기 */
					  cp.COUPON_CD
					, cp.DC_COUPON_NM
					, ifnull(cp.WEB_DISP_DC_COUPON_NM, cp.DC_COUPON_NM)		as WEB_DISP_DC_COUPON_NM
					, cp.COUPON_KIND_CD
					, cp.COUPON_DTL_NO
					, cp.COUPON_SALE
					, cp.MIN_AMT
					, cp.MAX_DISCOUNT
					, cp.COUPON_DC_METHOD_CD
					, cp.COUPON_END_DT
				from	(
							(	select	/* 기본 셀러 할인 쿠폰  */
									  cpn.COUPON_CD
									, cpn.DC_COUPON_NM
									, ifnull(cpn.WEB_DISP_DC_COUPON_NM, cpn.DC_COUPON_NM)		as WEB_DISP_DC_COUPON_NM
									, cpn.COUPON_KIND_CD
									, ''		as COUPON_DTL_NO
									, cpn.COUPON_DC_METHOD_CD
									, ifnull(case	when cpn.COUPON_DC_METHOD_CD = 'RATE' then floor(cpn.COUPON_FLAT_RATE / 10)
													when cpn.COUPON_DC_METHOD_CD = 'AMT' then cpn.COUPON_FLAT_AMT
													end, 0)			as COUPON_SALE		/* 할인율이나 할인액*/
									, cpn.MIN_AMT
									, cpn.MAX_DISCOUNT
									, cpn.COUPON_END_DT
									, 'cpn_g'	as gubun
								from
									DAT_COUPON		cpn
								inner join
									DAT_COUPON_PROGRESS		cpp
								on	cpp.COUPON_CD	= cpn.COUPON_CD
								and cpp.COUPON_PROGRESS_NO = (	select	max(COUPON_PROGRESS_NO)
																	from	DAT_COUPON_PROGRESS
																	where	COUPON_CD	= cpp.COUPON_CD
															)
								and cpp.USE_YN = 'Y'

								left join
									MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp
								on mcp.COUPON_CD	= cpn.COUPON_CD
								and mcp.USE_YN = 'Y'


								where
									1 = 1
								and cpn.USE_YN = 'Y'
								and cpn.COUPON_KIND_CD = 'SELLER'
								and cpn.BUYER_COUPON_APPLICATION_SCOPE_CD	= 'GOODS'
								and if(cpn.COUPON_START_DT is null, 1 = 1, cpn.COUPON_START_DT	<= now()	and cpn.COUPON_END_DT	>= now())
								and cpp.COUPON_PROGRESS_STS_CD	= '03'
								and mcp.COUPON_APPLICATION_SCOPE_OBJECT_CD	= '".$param['goods_code']."'

								order by
									cpn.COUPON_CD	desc

								limit 1		)

								UNION ALL

							(	select	/* 기본 상품 할인 쿠폰  */
									  cpn1.COUPON_CD
									, cpn1.DC_COUPON_NM
									, ifnull(cpn1.WEB_DISP_DC_COUPON_NM, cpn1.DC_COUPON_NM)		as WEB_DISP_DC_COUPON_NM
									, cpn1.COUPON_KIND_CD
									, ''		as COUPON_DTL_NO
									, cpn1.COUPON_DC_METHOD_CD
									, ifnull(case	when cpn1.COUPON_DC_METHOD_CD = 'RATE' then truncate(cpn1.COUPON_FLAT_RATE / 10, 1)
													when cpn1.COUPON_DC_METHOD_CD = 'AMT' then cpn1.COUPON_FLAT_AMT
													end, 0)			as COUPON_SALE		/* 할인율이나 할인액*/
									, cpn1.MIN_AMT
									, cpn1.MAX_DISCOUNT
									, cpn1.COUPON_END_DT
									, 'cpn_g'	as gubun
								from
									DAT_COUPON		cpn1
								inner join
									DAT_COUPON_PROGRESS		cpp1
								on	cpp1.COUPON_CD	= cpn1.COUPON_CD
								and cpp1.COUPON_PROGRESS_NO = (	select	max(COUPON_PROGRESS_NO)
																	from	DAT_COUPON_PROGRESS
																	where	COUPON_CD	= cpp1.COUPON_CD
															)
								and cpp1.USE_YN = 'Y'

								left join
									MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp1
								on mcp1.COUPON_CD	= cpn1.COUPON_CD
								and mcp1.USE_YN = 'Y'


								where
									1 = 1
								and cpn1.USE_YN = 'Y'
								and cpn1.COUPON_KIND_CD = 'GOODS'
								and cpn1.BUYER_COUPON_APPLICATION_SCOPE_CD = 'GOODS'
								and if(cpn1.COUPON_START_DT is null, 1 = 1, cpn1.COUPON_START_DT	<= now()	and cpn1.COUPON_END_DT	>= now())
								and cpp1.COUPON_PROGRESS_STS_CD	= '03'
								and mcp1.COUPON_APPLICATION_SCOPE_OBJECT_CD	= '".$param['goods_code']."'

								order by
									cpn1.COUPON_CD	desc

								limit 1		)
						)	cp
				where
					1 = 1
			";

        } else if($METHOD == 'ADD'){	//추가 할인쿠폰
            $query = "
				select		/*  > etah_mfront > cart_m > get_coupon_info > 해당 상품의 쿠폰 정보 가져오기 */
					  cp.COUPON_CD
					, cp.CUST_COUPON_NO
					, cp.DC_COUPON_NM
					, ifnull(cp.WEB_DISP_DC_COUPON_NM, cp.DC_COUPON_NM)		as WEB_DISP_DC_COUPON_NM
					, cp.COUPON_DTL_NO
					, cp.BUYER_COUPON_GIVE_METHOD_CD
					, cp.COUPON_SALE
					, cp.MIN_AMT
					, cp.MAX_DISCOUNT
					, cp.COUPON_DC_METHOD_CD
					, cp.COUPON_END_DT
					, cp.BUYER_COUPON_DUPLICATE_DC_YN
					, cp.GUBUN
				from	(
							/************************************ 자동 지급 쿠폰 ***************************************/
							select	/* 기본 바이어(상품) 할인 쿠폰  */
								  cpn.COUPON_CD
								, 'NONE'			as CUST_COUPON_NO
								, cpn.DC_COUPON_NM
								, ifnull(cpn.WEB_DISP_DC_COUPON_NM, cpn.DC_COUPON_NM)		as WEB_DISP_DC_COUPON_NM
								, cpn.COUPON_KIND_CD
								, ifnull(cpnd.COUPON_DTL_NO,'')		as COUPON_DTL_NO
								, cpn.BUYER_COUPON_GIVE_METHOD_CD
								, cpn.COUPON_DC_METHOD_CD
								, ifnull(case	when cpn.COUPON_DC_METHOD_CD = 'RATE' then floor(cpn.COUPON_FLAT_RATE / 10)
												when cpn.COUPON_DC_METHOD_CD = 'AMT' then cpn.COUPON_FLAT_AMT
												end, 0)			as COUPON_SALE		/* 할인율이나 할인액*/
								, ifnull(cpn.MIN_AMT,0)		as MIN_AMT
								, cpn.MAX_DISCOUNT
								, cpn.COUPON_END_DT
								, cpn.BUYER_COUPON_DUPLICATE_DC_YN
								, 'GOODS'	as GUBUN
							from
								DAT_COUPON		cpn
							inner join
								DAT_COUPON_PROGRESS		cpp
							on	cpp.COUPON_CD	= cpn.COUPON_CD
							and cpp.COUPON_PROGRESS_NO = (	select	max(COUPON_PROGRESS_NO)
																from	DAT_COUPON_PROGRESS
																where	COUPON_CD	= cpp.COUPON_CD
														)
							and cpp.USE_YN = 'Y'

							left join
								DAT_COUPON_DTL			cpnd
							on	cpnd.COUPON_CD	= cpn.COUPON_CD
							and cpnd.USE_YN		= 'Y'

							left join
								MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp
							on mcp.COUPON_CD	= cpn.COUPON_CD
							and mcp.USE_YN = 'Y'


							where
								1 = 1
							and cpn.USE_YN = 'Y'
							and cpn.COUPON_KIND_CD = 'BUYER'
							and cpn.BUYER_COUPON_GIVE_METHOD_CD = 'AUTO_DC'
							and cpn.BUYER_COUPON_APPLICATION_SCOPE_CD	= 'GOODS'
							and if(cpn.COUPON_START_DT is null, 1 = 1, cpn.COUPON_START_DT	<= now()	and cpn.COUPON_END_DT	>= now())
							and cpp.COUPON_PROGRESS_STS_CD	= '03'
							and mcp.COUPON_APPLICATION_SCOPE_OBJECT_CD	= '".$param['goods_code']."'

							UNION ALL

							select	/* 기본 바이어(브랜드) 할인 쿠폰  */
								  cpn1.COUPON_CD
								, 'NONE'			as CUST_COUPON_NO
								, cpn1.DC_COUPON_NM
								, ifnull(cpn1.WEB_DISP_DC_COUPON_NM, cpn1.DC_COUPON_NM)		as WEB_DISP_DC_COUPON_NM
								, cpn1.COUPON_KIND_CD
								, ifnull(cpnd1.COUPON_DTL_NO,'')		as COUPON_DTL_NO
								, cpn1.BUYER_COUPON_GIVE_METHOD_CD
								, cpn1.COUPON_DC_METHOD_CD
								, ifnull(case	when cpn1.COUPON_DC_METHOD_CD = 'RATE' then floor(cpn1.COUPON_FLAT_RATE / 10)
												when cpn1.COUPON_DC_METHOD_CD = 'AMT' then cpn1.COUPON_FLAT_AMT
												end, 0)			as COUPON_SALE		/* 할인율이나 할인액*/
								, ifnull(cpn1.MIN_AMT, 0)		as MIN_AMT
								, cpn1.MAX_DISCOUNT
								, cpn1.COUPON_END_DT
								, cpn1.BUYER_COUPON_DUPLICATE_DC_YN
								, 'BRAND'	as GUBUN
							from
								DAT_COUPON		cpn1
							inner join
								DAT_COUPON_PROGRESS		cpp1
							on	cpp1.COUPON_CD	= cpn1.COUPON_CD
							and cpp1.COUPON_PROGRESS_NO = (	select	max(COUPON_PROGRESS_NO)
																from	DAT_COUPON_PROGRESS
																where	COUPON_CD	= cpp1.COUPON_CD
														)
							and cpp1.USE_YN = 'Y'

							left join
								DAT_COUPON_DTL			cpnd1
							on	cpnd1.COUPON_CD	= cpn1.COUPON_CD
							and cpnd1.USE_YN		= 'Y'

							left join
								MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp1
							on mcp1.COUPON_CD	= cpn1.COUPON_CD
							and mcp1.USE_YN = 'Y'


							where
								1 = 1
							and cpn1.USE_YN = 'Y'
							and cpn1.COUPON_KIND_CD = 'BUYER'
							and cpn1.BUYER_COUPON_GIVE_METHOD_CD = 'AUTO_DC'
							and cpn1.BUYER_COUPON_APPLICATION_SCOPE_CD	= 'BRAND'
							and if(cpn1.COUPON_START_DT is null, 1 = 1, cpn1.COUPON_START_DT	<= now()	and cpn1.COUPON_END_DT	>= now())
							and cpp1.COUPON_PROGRESS_STS_CD	= '03'
							and mcp1.COUPON_APPLICATION_SCOPE_OBJECT_CD	= '".$param['brand_code']."'

							UNION ALL

							select	/* 기본 바이어(카테고리) 할인 쿠폰  */
								  cpn2.COUPON_CD
								, 'NONE'			as CUST_COUPON_NO
								, cpn2.DC_COUPON_NM
								, ifnull(cpn2.WEB_DISP_DC_COUPON_NM, cpn2.DC_COUPON_NM)		as WEB_DISP_DC_COUPON_NM
								, cpn2.COUPON_KIND_CD
								, ifnull(cpnd2.COUPON_DTL_NO,'')		as COUPON_DTL_NO
								, cpn2.BUYER_COUPON_GIVE_METHOD_CD
								, cpn2.COUPON_DC_METHOD_CD
								, ifnull(case	when cpn2.COUPON_DC_METHOD_CD = 'RATE' then floor(cpn2.COUPON_FLAT_RATE / 10)
												when cpn2.COUPON_DC_METHOD_CD = 'AMT' then cpn2.COUPON_FLAT_AMT
												end, 0)			as COUPON_SALE		/* 할인율이나 할인액*/
								, ifnull(cpn2.MIN_AMT, 0)		as MIN_AMT
								, cpn2.MAX_DISCOUNT
								, cpn2.COUPON_END_DT
								, cpn2.BUYER_COUPON_DUPLICATE_DC_YN
								, 'CATEGORY'	as GUBUN
							from
								DAT_COUPON		cpn2
							inner join
								DAT_COUPON_PROGRESS		cpp2
							on	cpp2.COUPON_CD	= cpn2.COUPON_CD
							and cpp2.COUPON_PROGRESS_NO = (	select	max(COUPON_PROGRESS_NO)
																from	DAT_COUPON_PROGRESS
																where	COUPON_CD	= cpp2.COUPON_CD
														)
							and cpp2.USE_YN = 'Y'

							left join
								DAT_COUPON_DTL			cpnd2
							on	cpnd2.COUPON_CD	= cpn2.COUPON_CD
							and cpnd2.USE_YN		= 'Y'

							left join
								MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp2
							on mcp2.COUPON_CD	= cpn2.COUPON_CD
							and mcp2.USE_YN = 'Y'


							where
								1 = 1
							and cpn2.USE_YN = 'Y'
							and cpn2.COUPON_KIND_CD = 'BUYER'
							and cpn2.BUYER_COUPON_GIVE_METHOD_CD = 'AUTO_DC'
							and cpn2.BUYER_COUPON_APPLICATION_SCOPE_CD	= 'CATEGORY'
							and if(cpn2.COUPON_START_DT is null, 1 = 1, cpn2.COUPON_START_DT	<= now()	and cpn2.COUPON_END_DT	>= now())
							and cpp2.COUPON_PROGRESS_STS_CD	= '03'
							and mcp2.COUPON_APPLICATION_SCOPE_OBJECT_CD	= '".$param['category_mng_code']."'

							UNION ALL

								select	/* 기본 바이어(셀러) 할인 쿠폰  */
								  cpn3.COUPON_CD
								, 'NONE'			as CUST_COUPON_NO
								, cpn3.DC_COUPON_NM
								, ifnull(cpn3.WEB_DISP_DC_COUPON_NM, cpn3.DC_COUPON_NM)		as WEB_DISP_DC_COUPON_NM
								, cpn3.COUPON_KIND_CD
								, ifnull(cpnd3.COUPON_DTL_NO,'')		as COUPON_DTL_NO
								, cpn3.BUYER_COUPON_GIVE_METHOD_CD
								, cpn3.COUPON_DC_METHOD_CD
								, ifnull(case	when cpn3.COUPON_DC_METHOD_CD = 'RATE' then floor(cpn3.COUPON_FLAT_RATE / 10)
												when cpn3.COUPON_DC_METHOD_CD = 'AMT' then cpn3.COUPON_FLAT_AMT
												end, 0)			as COUPON_SALE		/* 할인율이나 할인액*/
								, ifnull(cpn3.MIN_AMT, 0)		as MIN_AMT
								, cpn3.MAX_DISCOUNT
								, cpn3.COUPON_END_DT
								, cpn3.BUYER_COUPON_DUPLICATE_DC_YN
								, 'SELLER'	as GUBUN
							from
								DAT_COUPON		cpn3
							inner join
								DAT_COUPON_PROGRESS		cpp3
							on	cpp3.COUPON_CD	= cpn3.COUPON_CD
							and cpp3.COUPON_PROGRESS_NO = (	select	max(COUPON_PROGRESS_NO)
																from	DAT_COUPON_PROGRESS
																where	COUPON_CD	= cpp3.COUPON_CD
														)
							and cpp3.USE_YN = 'Y'

							left join
								DAT_COUPON_DTL			cpnd3
							on	cpnd3.COUPON_CD	= cpn3.COUPON_CD
							and cpnd3.USE_YN		= 'Y'

							left join
								MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp3
							on mcp3.COUPON_CD	= cpn3.COUPON_CD
							and mcp3.USE_YN = 'Y'


							where
								1 = 1
							and cpn3.USE_YN = 'Y'
							and cpn3.COUPON_KIND_CD = 'BUYER'
							and cpn3.BUYER_COUPON_GIVE_METHOD_CD = 'AUTO_DC'
							and cpn3.BUYER_COUPON_APPLICATION_SCOPE_CD	= 'SELLER'
							and if(cpn3.COUPON_START_DT is null, 1 = 1, cpn3.COUPON_START_DT	<= now()	and cpn3.COUPON_END_DT	>= now())
							and cpp3.COUPON_PROGRESS_STS_CD	= '03'
							and mcp3.COUPON_APPLICATION_SCOPE_OBJECT_CD	= ''


							UNION ALL

								select	/* 기본 바이어(고객) 할인 쿠폰 */
								  cpn4.COUPON_CD
								, cc.CUST_COUPON_NO
								, cpn4.DC_COUPON_NM
								, ifnull(cpn4.WEB_DISP_DC_COUPON_NM, cpn4.DC_COUPON_NM)		as WEB_DISP_DC_COUPON_NM
								, cpn4.COUPON_KIND_CD
								, ifnull(cpnd4.COUPON_DTL_NO,'')		as COUPON_DTL_NO
								, cpn4.BUYER_COUPON_GIVE_METHOD_CD
								, cpn4.COUPON_DC_METHOD_CD
								, ifnull(case	when cpn4.COUPON_DC_METHOD_CD = 'RATE' then floor(cpn4.COUPON_FLAT_RATE / 10)
												when cpn4.COUPON_DC_METHOD_CD = 'AMT' then cpn4.COUPON_FLAT_AMT
												end, 0)			as COUPON_SALE		/* 할인율이나 할인액 */
								, ifnull(cpn4.MIN_AMT, 0)		as MIN_AMT
								, cpn4.MAX_DISCOUNT
								, cpn4.COUPON_END_DT
								, cpn4.BUYER_COUPON_DUPLICATE_DC_YN
								, 'CUST'	as GUBUN
							from
								DAT_COUPON		cpn4
							inner join
								DAT_COUPON_PROGRESS		cpp4
							on	cpp4.COUPON_CD	= cpn4.COUPON_CD
							and cpp4.COUPON_PROGRESS_NO = (	select	max(COUPON_PROGRESS_NO)
																from	DAT_COUPON_PROGRESS
																where	COUPON_CD	= cpp4.COUPON_CD
														)
							and cpp4.USE_YN = 'Y'

							left join
								DAT_COUPON_DTL			cpnd4
							on	cpnd4.COUPON_CD	= cpn4.COUPON_CD
							and cpnd4.USE_YN		= 'Y'

							left join
								MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp4
							on mcp4.COUPON_CD	= cpn4.COUPON_CD
							and mcp4.USE_YN = 'Y'

							inner join
								DAT_CUST_COUPON			cc
							on	cc.COUPON_CD	= cpn4.COUPON_CD
							and cc.CUST_NO		= '".$this->session->userdata('EMS_U_NO_')."'
							and cc.USE_YN		= 'Y'

							where
								1 = 1
							and cpn4.USE_YN = 'Y'
							and cpn4.COUPON_KIND_CD = 'BUYER'
							and cpn4.BUYER_COUPON_GIVE_METHOD_CD = 'AUTO_DC'
							and cpn4.BUYER_COUPON_APPLICATION_SCOPE_CD	= 'CUST'
							and if(cpn4.COUPON_START_DT is null, 1 = 1, cpn4.COUPON_START_DT	<= now()	and cpn4.COUPON_END_DT	>= now())
							and cpp4.COUPON_PROGRESS_STS_CD	= '03'
							and mcp4.COUPON_APPLICATION_SCOPE_OBJECT_CD	= '".$this->session->userdata('EMS_U_NO_')."'
							and if(cc.COUPON_DTL_NO is null, 1=1 , cc.COUPON_DTL_NO	= cpnd4.COUPON_DTL_NO)




							/************************************ 고객 다운로드 ***************************************/

							UNION ALL

							select	/* 기본 바이어(상품) 할인 쿠폰  */
								  cpn5.COUPON_CD
								, cc5.CUST_COUPON_NO
								, cpn5.DC_COUPON_NM
								, ifnull(cpn5.WEB_DISP_DC_COUPON_NM, cpn5.DC_COUPON_NM)		as WEB_DISP_DC_COUPON_NM
								, cpn5.COUPON_KIND_CD
								, ifnull(cpnd5.COUPON_DTL_NO,'')		as COUPON_DTL_NO
								, cpn5.BUYER_COUPON_GIVE_METHOD_CD
								, cpn5.COUPON_DC_METHOD_CD
								, ifnull(case	when cpn5.COUPON_DC_METHOD_CD = 'RATE' then floor(cpn5.COUPON_FLAT_RATE / 10)
												when cpn5.COUPON_DC_METHOD_CD = 'AMT' then cpn5.COUPON_FLAT_AMT
												end, 0)			as COUPON_SALE		/* 할인율이나 할인액*/
								, ifnull(cpn5.MIN_AMT, 0)		as MIN_AMT
								, cpn5.MAX_DISCOUNT
								, cpn5.COUPON_END_DT
								, cpn5.BUYER_COUPON_DUPLICATE_DC_YN
								, 'GOODS'	as GUBUN
							from
								DAT_COUPON		cpn5
							inner join
								DAT_COUPON_PROGRESS		cpp5
							on	cpp5.COUPON_CD	= cpn5.COUPON_CD
							and cpp5.COUPON_PROGRESS_NO = (	select	max(COUPON_PROGRESS_NO)
																from	DAT_COUPON_PROGRESS
																where	COUPON_CD	= cpp5.COUPON_CD
														)
							and cpp5.USE_YN = 'Y'

							left join
								DAT_COUPON_DTL			cpnd5
							on	cpnd5.COUPON_CD	= cpn5.COUPON_CD
							and cpnd5.USE_YN		= 'Y'

							left join
								MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp5
							on mcp5.COUPON_CD	= cpn5.COUPON_CD
							and mcp5.USE_YN = 'Y'

							inner join
								DAT_CUST_COUPON			cc5
							on	cc5.COUPON_CD	= cpn5.COUPON_CD
							and cc5.CUST_NO		= '".$this->session->userdata('EMS_U_NO_')."'
							and cc5.USE_YN		= 'Y'


							where
								1 = 1
							and cpn5.USE_YN = 'Y'
							and cpn5.COUPON_KIND_CD = 'BUYER'
							and cpn5.BUYER_COUPON_GIVE_METHOD_CD = 'CUST_DOWNLOAD'
							and cpn5.BUYER_COUPON_APPLICATION_SCOPE_CD	= 'GOODS'
							and if(cpn5.COUPON_START_DT is null, 1 = 1, cpn5.COUPON_START_DT	<= now()	and cpn5.COUPON_END_DT	>= now())
							and cpp5.COUPON_PROGRESS_STS_CD	= '03'
							and mcp5.COUPON_APPLICATION_SCOPE_OBJECT_CD	= '".$param['goods_code']."'
							and if(cc5.COUPON_DTL_NO is null, 1=1 , cc5.COUPON_DTL_NO	= cpnd5.COUPON_DTL_NO)

							UNION ALL

							select	/* 기본 바이어(브랜드) 할인 쿠폰  */
								  cpn6.COUPON_CD
								, cc6.CUST_COUPON_NO
								, cpn6.DC_COUPON_NM
								, ifnull(cpn6.WEB_DISP_DC_COUPON_NM, cpn6.DC_COUPON_NM)		as WEB_DISP_DC_COUPON_NM
								, cpn6.COUPON_KIND_CD
								, ifnull(cpnd6.COUPON_DTL_NO,'')		as COUPON_DTL_NO
								, cpn6.BUYER_COUPON_GIVE_METHOD_CD
								, cpn6.COUPON_DC_METHOD_CD
								, ifnull(case	when cpn6.COUPON_DC_METHOD_CD = 'RATE' then floor(cpn6.COUPON_FLAT_RATE / 10)
												when cpn6.COUPON_DC_METHOD_CD = 'AMT' then cpn6.COUPON_FLAT_AMT
												end, 0)			as COUPON_SALE		/* 할인율이나 할인액*/
								, ifnull(cpn6.MIN_AMT, 0)		as MIN_AMT
								, cpn6.MAX_DISCOUNT
								, cpn6.COUPON_END_DT
								, cpn6.BUYER_COUPON_DUPLICATE_DC_YN
								, 'BRAND'	as GUBUN
							from
								DAT_COUPON		cpn6
							inner join
								DAT_COUPON_PROGRESS		cpp6
							on	cpp6.COUPON_CD	= cpn6.COUPON_CD
							and cpp6.COUPON_PROGRESS_NO = (	select	max(COUPON_PROGRESS_NO)
																from	DAT_COUPON_PROGRESS
																where	COUPON_CD	= cpp6.COUPON_CD
														)
							and cpp6.USE_YN		= 'Y'

							left join
								DAT_COUPON_DTL			cpnd6
							on	cpnd6.COUPON_CD	= cpn6.COUPON_CD
							and cpnd6.USE_YN	= 'Y'

							left join
								MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp6
							on mcp6.COUPON_CD	= cpn6.COUPON_CD
							and mcp6.USE_YN		= 'Y'

							inner join
								DAT_CUST_COUPON			cc6
							on	cc6.COUPON_CD	= cpn6.COUPON_CD
							and cc6.CUST_NO		= '".$this->session->userdata('EMS_U_NO_')."'
							and cc6.USE_YN		= 'Y'


							where
								1 = 1
							and cpn6.USE_YN = 'Y'
							and cpn6.COUPON_KIND_CD = 'BUYER'
							and cpn6.BUYER_COUPON_GIVE_METHOD_CD = 'CUST_DOWNLOAD'
							and cpn6.BUYER_COUPON_APPLICATION_SCOPE_CD	= 'BRAND'
							and if(cpn6.COUPON_START_DT is null, 1 = 1, cpn6.COUPON_START_DT	<= now()	and cpn6.COUPON_END_DT	>= now())
							and cpp6.COUPON_PROGRESS_STS_CD	= '03'
							and mcp6.COUPON_APPLICATION_SCOPE_OBJECT_CD	= '".$param['brand_code']."'
							and if(cc6.COUPON_DTL_NO is null, 1=1 , cc6.COUPON_DTL_NO	= cpnd6 .COUPON_DTL_NO)

							UNION ALL

							select	/* 기본 바이어(카테고리) 할인 쿠폰  */
								  cpn7.COUPON_CD
								, cc7.CUST_COUPON_NO
								, cpn7.DC_COUPON_NM
								, ifnull(cpn7.WEB_DISP_DC_COUPON_NM, cpn7.DC_COUPON_NM)		as WEB_DISP_DC_COUPON_NM
								, cpn7.COUPON_KIND_CD
								, ifnull(cpnd7.COUPON_DTL_NO,'')		as COUPON_DTL_NO
								, cpn7.BUYER_COUPON_GIVE_METHOD_CD
								, cpn7.COUPON_DC_METHOD_CD
								, ifnull(case	when cpn7.COUPON_DC_METHOD_CD = 'RATE' then floor(cpn7.COUPON_FLAT_RATE / 10)
												when cpn7.COUPON_DC_METHOD_CD = 'AMT' then cpn7.COUPON_FLAT_AMT
												end, 0)			as COUPON_SALE		/* 할인율이나 할인액*/
								, ifnull(cpn7.MIN_AMT, 0)		as MIN_AMT
								, cpn7.MAX_DISCOUNT
								, cpn7.COUPON_END_DT
								, cpn7.BUYER_COUPON_DUPLICATE_DC_YN
								, 'CATEGORY'	as GUBUN
							from
								DAT_COUPON		cpn7
							inner join
								DAT_COUPON_PROGRESS		cpp7
							on	cpp7.COUPON_CD	= cpn7.COUPON_CD
							and cpp7.COUPON_PROGRESS_NO = (	select	max(COUPON_PROGRESS_NO)
																from	DAT_COUPON_PROGRESS
																where	COUPON_CD	= cpp7.COUPON_CD
														)
							and cpp7.USE_YN		= 'Y'

							left join
								DAT_COUPON_DTL			cpnd7
							on	cpnd7.COUPON_CD	= cpn7.COUPON_CD
							and cpnd7.USE_YN	= 'Y'

							left join
								MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp7
							on mcp7.COUPON_CD	= cpn7.COUPON_CD
							and mcp7.USE_YN		= 'Y'

							inner join
								DAT_CUST_COUPON			cc7
							on	cc7.COUPON_CD	= cpn7.COUPON_CD
							and cc7.CUST_NO		= '".$this->session->userdata('EMS_U_NO_')."'
							and cc7.USE_YN		= 'Y'


							where
								1 = 1
							and cpn7.USE_YN = 'Y'
							and cpn7.COUPON_KIND_CD = 'BUYER'
							and cpn7.BUYER_COUPON_GIVE_METHOD_CD = 'CUST_DOWNLOAD'
							and cpn7.BUYER_COUPON_APPLICATION_SCOPE_CD	= 'CATEGORY'
							and if(cpn7.COUPON_START_DT is null, 1 = 1, cpn7.COUPON_START_DT	<= now()	and cpn7.COUPON_END_DT	>= now())
							and cpp7.COUPON_PROGRESS_STS_CD	= '03'
							and mcp7.COUPON_APPLICATION_SCOPE_OBJECT_CD	= '".$param['category_mng_code']."'
							and if(cc7.COUPON_DTL_NO is null, 1=1 , cc7.COUPON_DTL_NO	= cpnd7 .COUPON_DTL_NO)

							UNION ALL

								select	/* 기본 바이어(셀러) 할인 쿠폰  */
								  cpn8.COUPON_CD
								, cc8.CUST_COUPON_NO
								, cpn8.DC_COUPON_NM
								, ifnull(cpn8.WEB_DISP_DC_COUPON_NM, cpn8.DC_COUPON_NM)		as WEB_DISP_DC_COUPON_NM
								, cpn8.COUPON_KIND_CD
								, ifnull(cpnd8.COUPON_DTL_NO,'')		as COUPON_DTL_NO
								, cpn8.BUYER_COUPON_GIVE_METHOD_CD
								, cpn8.COUPON_DC_METHOD_CD
								, ifnull(case	when cpn8.COUPON_DC_METHOD_CD = 'RATE' then floor(cpn8.COUPON_FLAT_RATE / 10)
												when cpn8.COUPON_DC_METHOD_CD = 'AMT' then cpn8.COUPON_FLAT_AMT
												end, 0)			as COUPON_SALE		/* 할인율이나 할인액*/
								, ifnull(cpn8.MIN_AMT,0)		as MIN_AMT
								, cpn8.MAX_DISCOUNT
								, cpn8.COUPON_END_DT
								, cpn8.BUYER_COUPON_DUPLICATE_DC_YN
								, 'SELLER'	as GUBUN
							from
								DAT_COUPON		cpn8
							inner join
								DAT_COUPON_PROGRESS		cpp8
							on	cpp8.COUPON_CD	= cpn8.COUPON_CD
							and cpp8.COUPON_PROGRESS_NO = (	select	max(COUPON_PROGRESS_NO)
																from	DAT_COUPON_PROGRESS
																where	COUPON_CD	= cpp8.COUPON_CD
														)
							and cpp8.USE_YN		= 'Y'

							left join
								DAT_COUPON_DTL			cpnd8
							on	cpnd8.COUPON_CD	= cpn8.COUPON_CD
							and cpnd8.USE_YN	= 'Y'

							left join
								MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp8
							on mcp8.COUPON_CD	= cpn8.COUPON_CD
							and mcp8.USE_YN = 'Y'

							inner join
								DAT_CUST_COUPON			cc8
							on	cc8.COUPON_CD	= cpn8.COUPON_CD
							and cc8.CUST_NO		= '".$this->session->userdata('EMS_U_NO_')."'
							and cc8.USE_YN		= 'Y'


							where
								1 = 1
							and cpn8.USE_YN = 'Y'
							and cpn8.COUPON_KIND_CD = 'BUYER'
							and cpn8.BUYER_COUPON_GIVE_METHOD_CD = 'CUST_DOWNLOAD'
							and cpn8.BUYER_COUPON_APPLICATION_SCOPE_CD	= 'SELLER'
							and if(cpn8.COUPON_START_DT is null, 1 = 1, cpn8.COUPON_START_DT	<= now()	and cpn8.COUPON_END_DT	>= now())
							and cpp8.COUPON_PROGRESS_STS_CD	= '03'
							and mcp8.COUPON_APPLICATION_SCOPE_OBJECT_CD	= ''
							and if(cc8.COUPON_DTL_NO is null, 1=1 , cc8.COUPON_DTL_NO	= cpnd8.COUPON_DTL_NO)


							UNION ALL

								select	/* 기본 바이어(고객) 할인 쿠폰 */
								  cpn9.COUPON_CD
								, cc9.CUST_COUPON_NO
								, cpn9.DC_COUPON_NM
								, ifnull(cpn9.WEB_DISP_DC_COUPON_NM, cpn9.DC_COUPON_NM)		as WEB_DISP_DC_COUPON_NM
								, cpn9.COUPON_KIND_CD
								, ifnull(cpnd9.COUPON_DTL_NO,'')		as COUPON_DTL_NO
								, cpn9.BUYER_COUPON_GIVE_METHOD_CD
								, cpn9.COUPON_DC_METHOD_CD
								, ifnull(case	when cpn9.COUPON_DC_METHOD_CD = 'RATE' then floor(cpn9.COUPON_FLAT_RATE / 10)
												when cpn9.COUPON_DC_METHOD_CD = 'AMT' then cpn9.COUPON_FLAT_AMT
												end, 0)			as COUPON_SALE		/* 할인율이나 할인액 */
								, ifnull(cpn9.MIN_AMT, 0)		as MIN_AMT
								, cpn9.MAX_DISCOUNT
								, cpn9.COUPON_END_DT
								, cpn9.BUYER_COUPON_DUPLICATE_DC_YN
								, 'CUST'	as GUBUN
							from
								DAT_COUPON		cpn9
							inner join
								DAT_COUPON_PROGRESS		cpp9
							on	cpp9.COUPON_CD	= cpn9.COUPON_CD
							and cpp9.COUPON_PROGRESS_NO = (	select	max(COUPON_PROGRESS_NO)
																from	DAT_COUPON_PROGRESS
																where	COUPON_CD	= cpp9.COUPON_CD
														)
							and cpp9.USE_YN = 'Y'

							left join
								DAT_COUPON_DTL			cpnd9
							on	cpnd9.COUPON_CD	= cpn9.COUPON_CD
							and cpnd9.USE_YN	= 'Y'

							left join
								MAP_COUPON_APPLICATION_SCOPE_OBJECT		mcp9
							on mcp9.COUPON_CD	= cpn9.COUPON_CD
							and mcp9.USE_YN		= 'Y'

							inner join
								DAT_CUST_COUPON			cc9
							on	cc9.COUPON_CD	= cpn9.COUPON_CD
							and cc9.CUST_NO		= '".$this->session->userdata('EMS_U_NO_')."'
							and cc9.USE_YN		= 'Y'

							where
								1 = 1
							and cpn9.USE_YN = 'Y'
							and cpn9.COUPON_KIND_CD = 'BUYER'
							and cpn9.BUYER_COUPON_GIVE_METHOD_CD = 'CUST_DOWNLOAD'
							and cpn9.BUYER_COUPON_APPLICATION_SCOPE_CD	= 'CUST'
							and if(cpn9.COUPON_START_DT is null, 1 = 1, cpn9.COUPON_START_DT	<= now()	and cpn9.COUPON_END_DT	>= now())
							and cpp9.COUPON_PROGRESS_STS_CD	= '03'
							and mcp9.COUPON_APPLICATION_SCOPE_OBJECT_CD	= '".$this->session->userdata('EMS_U_NO_')."'
							and if(cc9.COUPON_DTL_NO is null, 1=1 , cc9.COUPON_DTL_NO	= cpnd9.COUPON_DTL_NO)

					)	cp

			/*	left join
					DAT_CUST_COUPON			cc
				on	cc.COUPON_CD	= cp.COUPON_CD
				and cc.COUPON_DTL_NO	= cp.COUPON_DTL_NO
				and cc.CUST_NO		= '".$this->session->userdata('EMS_U_NO_')."'
				and cc.USE_YN		= 'Y'		*/

				where
					1 = 1
			";
        }
//var_dump($query);
        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 장바구니에 동일상품&옵션이 담겨있는지 확인
     */
    public function chk_cart($param)
    {
        $query = "
			select		/*  > etah_mfront > cart_m > chk_cart > ETAH 장바구니에 동일 상품&옵션이 담겨있는지 확인 */
				  c.CART_NO
				, c.CART_QTY
				, g.BUY_LIMIT_CD
				, g.BUY_LIMIT_QTY
			from
				DAT_CART		c
				inner join DAT_GOODS g 
					on c.GOODS_CD = g.GOODS_CD
			where
				1 = 1
			and c.CUST_NO			= '".$param['cust_no']."'
			and c.GOODS_CD			= '".$param['goods_code']."'
			and c.GOODS_OPTION_CD	= '".$param['goods_option_code']."'
			and c.USE_YN			= 'Y'
		";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 장바구니에 상품 담기
     */
    public function add_cart($param)
    {
        $query = "
			insert into	DAT_CART	(   /*  > etah_mfront > cart_m > add_cart > ETAH 장바구니에 상품 담기 */
				CUST_NO
			  , GOODS_CD
			  , GOODS_OPTION_CD
			  , CART_QTY
			)
			values
			(
				'".$param['cust_no']."'
			  , '".$param['goods_code']."'
			  , '".$param['goods_option_code']."'
			  , '".$param['goods_cnt']."'
			)
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 장바구니에서 상품 제거
     */
    public function del_cart($cart_no)
    {
        $query = "
			update	DAT_CART       /*  > etah_mfront > cart_m > del_cart > ETAH 장바구니에 상품 제거 */
			set	USE_YN	= 'N'
			where
				1 = 1
			and CART_NO = '".$cart_no."'
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 장바구니에서 옵션/수량 변경
     */
    public function upd_cart($param)
    {
        if($param['gb'] == 'CNT'){
            $query = "
				update	DAT_CART       /*  > etah_mfront > cart_m > upd_cart > ETAH 장바구니에 수량 변경 */
				set
					CART_QTY	= '".$param['cnt']."'
				where
					1 = 1
				and CART_NO		= '".$param['cart_no']."'
			";
        } else if($param['gb'] == 'OPT'){
            $query = "
				update	DAT_CART       /*  > etah_mfront > cart_m > upd_cart > ETAH 장바구니에 옵션 변경 */
				set
					 GOODS_OPTION_CD	= '".$param['option_code']."'
					, CART_QTY			= '".$param['cnt']."'
				where
					1 = 1
				and CART_NO		= '".$param['cart_no']."'
			";
        }

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 우편번호 시/도 가져오기
     */
    public function get_post_sido()
    {
        $query = "
			select		/* > etah_mfront  > cart_m > get_post_sido > 우편번호 시/도 가져오기 */
				  zo.SIDO
			from
				DAT_ZIPCODE_OLD		zo
			group by
				zo.SIDO
			order by
				zo.ZIPCODE
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 우편번호 시/군/구 가져오기
     */
    public function get_post_sigungu($param)
    {
        $query = "
			select		/* > etah_mfront  > cart_m > get_post_sigungu > 우편번호 시/군/구 가져오기 */
				  zo.SIGUNGU
			from
				DAT_ZIPCODE_OLD		zo
			where
				1 = 1
			and zo.SIDO = '".$param['sido']."'

			group by
				zo.SIGUNGU
			order by
				zo.ZIPCODE
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();

    }

    /**
     * 우편번호 검색 (지번주소)
     */
    public function get_postnum_old($param)
    {
        $query = "
			select		/*  > etah_mfront  > cart_m > get_postnum_old > 우편번호 검색 (지번주소) */
				  zo.ZIPCODE
				, zo.SIDO
				, zo.SIGUNGU
				, zo.EUPMYEONDONG
				, zo.RI
				, zo.DOSEO
				, zo.BUNGI
				, zo.BUILDING_NM
			from
				DAT_ZIPCODE_OLD		zo
			where
				1 = 1
			and zo.SIDO			= '".$param['sido']."'
		";
        if($param['sigungu'] != 'N/A'){	//시/군/구가 없는 경우는 제외함
            $query .= "
			and zo.SIGUNGU		= '".$param['sigungu']."'	";
        }
        $query .= "
			and zo.EUPMYEONDONG	like '%".$param['dong']."%'

			order by
				zo.SIDO, zo.SIGUNGU, zo.EUPMYEONDONG, zo.RI, zo.DOSEO, zo.BUNGI, zo.BUILDING_NM		asc
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }


    /**
     * 우편번호 검색 (도로명주소)
     */
    public function get_postnum_new($param)
    {
        if($param['gb'] == '02'){
            $query = "
				select		/*  > etah_mfront  > cart_m > get_postnum_new > 우편번호 검색 (도로명주소) */
					  zn.ZIPCODE
					, zn.SIDO
					, zn.SIGUNGU
					, zn.EUPMYEONDONG
					, zn.ROAD_NM
					, zn.ROAD_NO
					, zn.BUILDING_NM
					, zn.LAWDONG_BUILDING_NM
					, zn.LAWDONG_NM
					, zn.ADMINDONG_NM
					, zn.GIBUN_BUNGI
				from
					DAT_ZIPCODE_NEW		zn
				where
					1 = 1
				and zn.SIDO		= '".$param['sido']."'
			";
            if($param['sigungu'] != 'N/A'){	//시/군/구가 없는 경우는 제외함
                $query .= "
				and zn.SIGUNGU	= '".$param['sigungu']."'	";
            }
            $query .= "
				and zn.ROAD_NM	= '".$param['road_name']."'
				and zn.ROAD_NO	= '".$param['road_no']."'

				group by
					zn.ROAD_NM, zn.ROAD_NO

				order by
					zn.SIDO, zn.SIGUNGU, zn.ROAD_NM, zn.ROAD_NO, zn.BUILDING_NM		asc
			";
        } else if($param['gb'] == '03'){
            $query = "
				select		/*  > etah_mfront > cart_m > get_postnum_new > 우편번호 검색 (도로명주소) */
					  zn.ZIPCODE
					, zn.SIDO
					, zn.SIGUNGU
					, zn.EUPMYEONDONG
					, zn.ROAD_NM
					, zn.ROAD_NO
					, zn.BUILDING_NM
					, zn.LAWDONG_BUILDING_NM
					, zn.LAWDONG_NM
					, zn.ADMINDONG_NM
					, zn.GIBUN_BUNGI
				from
					DAT_ZIPCODE_NEW		zn
				where
					1 = 1
				and zn.SIDO			= '".$param['sido']."'	";
            if($param['sigungu'] != 'N/A'){	//시/군/구가 없는 경우는 제외함
                $query .= "
				and zn.SIGUNGU		= '".$param['sigungu']."'	";
            }
            $query .= "
				and zn.BUILDING_NM	like '%".$param['building_name']."%'

				group by
					zn.ROAD_NM, zn.ROAD_NO

				order by
					zn.SIDO, zn.SIGUNGU, zn.ROAD_NM, zn.ROAD_NO, zn.BUILDING_NM		asc
			";
        }

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 도서산간지역 추가배송비 여부
     */
    public function get_add_delivery_cost($param)
    {
        $query = "
			select		/*  > etah_mfront > cart_m > get_add_delivery_cost > 도서산간지역 추가배송비 여부 */
				  adc.DELIV_POLICY_NO
				, adc.DELIV_POLICY_ADD_DELIV_COST_NO
				, adc.DELIV_AREA_CD
				, adc.ADD_DELIV_COST
				, da.DELIV_AREA_NM
				, anz.ZIPCODE

			from
				DAT_DELIV_POLICY_ADD_DELIV_COST		adc

			left join
				DAT_DELIV_AREA						da
			on	da.DELIV_AREA_CD	= adc.DELIV_AREA_CD
			and da.USE_YN			= 'Y'

			left join
				MAP_DELIV_AREA_N_ZIPCODE			anz
			on anz.DELIV_AREA_CD	= da.DELIV_AREA_CD
			and anz.USE_YN			= 'Y'

			where
				1 = 1
			and adc.DELIV_POLICY_NO	= '".$param['deli_policy_no']."'
			and anz.ZIPCODE			= '".$param['postnum']."'
		";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 배송불가지역
     */
    public function get_no_delivery($param)
    {
        $query = "
			select		/*  > etah_mfront > cart_m > get_no_delivery > 배송불가지역 */
				  nd.DELIV_POLICY_NO
				, nd.DELIV_AREA_CD
				, da.DELIV_AREA_NM
				, anz.ZIPCODE
			from
				DAT_DELIV_POLICY_NO_DELIV		nd

			left join
				DAT_DELIV_AREA			da
			on	da.DELIV_AREA_CD	= nd.DELIV_AREA_CD
			and da.USE_YN			= 'Y'

			left join
				MAP_DELIV_AREA_N_ZIPCODE		anz
			on	anz.DELIV_AREA_CD	= da.DELIV_AREA_CD
			and	anz.USE_YN			= 'Y'

			where
				1 = 1
			and nd.DELIV_POLICY_NO	= '".$param['deli_policy_no']."'
			and anz.ZIPCODE			= '".$param['postnum']."'
		";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }


}