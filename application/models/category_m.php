<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_m extends CI_Model {

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
     * 카테고리 리스트 parent_code
     */
    public function get_list_by_category($param)
    {
        if($param['cate_gb']=='L') {
            $query_category = "and c.CATEGORY_DISP_CD = ".$param['cate_cd'];
        } else if($param['cate_gb']=='M') {
            $query_category = "and c.CATEGORY_DISP_CD = ".$param['category']['CATE_CODE2'];
        } else if($param['cate_gb']=='S') {
            $query_category = "and c2.CATEGORY_DISP_CD = ".$param['category']['CATE_CODE2'];
        }

        if($param['cate_cd']){
            $query = "
                  select	/*  > etah_mfront > category_m > get_list_by_category > ETAH 카테고리 구하기 (카테고리리스트) */
					c.CATEGORY_DISP_CD      as CATEGORY_CD1
					, c.CATEGORY_DISP_NM    as CATEGORY_NM1
					, c2.CATEGORY_DISP_CD   as CATEGORY_CD2
					, c2.CATEGORY_DISP_NM   as CATEGORY_NM2
					, c3.CATEGORY_DISP_CD	AS CATEGORY_CD3
					, c3.CATEGORY_DISP_NM	AS CATEGORY_NM3
				from
					DAT_CATEGORY_DISP 	c
               INNER JOIN 
                    DAT_CATEGORY_DISP	c2
					ON c.CATEGORY_DISP_CD       = c2.PARENT_CATEGORY_DISP_CD
					and c2.USE_YN               = 'Y'
					and c2.MOB_DISP_YN          = 'Y'
					
					INNER JOIN 
                    DAT_CATEGORY_DISP	c3
					ON c2.CATEGORY_DISP_CD       = c3.PARENT_CATEGORY_DISP_CD
					and c3.USE_YN                = 'Y'
					and c3.MOB_DISP_YN           = 'Y'
					
                where
                    1=1
				and c.USE_YN					= 'Y'
				and c.MOB_DISP_YN				= 'Y'
				$query_category
				
                order by
					c.CATEGORY_DISP_CD
            ";
        }else{
            $query = "
				select	/*  > etah_mfront > category_m > get_list_by_category > ETAH 카테고리 구하기 (입점문의) */
					c.CATEGORY_DISP_CD
					, c.CATEGORY_DISP_NM
					, c.PARENT_CATEGORY_DISP_CD
					, c.USE_YN
				from
					DAT_CATEGORY_DISP 	c
				where
					c.PARENT_CATEGORY_DISP_CD is null
				and c.USE_YN = 'Y'
				and c.MOB_DISP_YN				= 'Y'
				order by
					c.SORT_VAL, c.CATEGORY_DISP_CD
            ";
        }

        $db = self::_slave_db();
        //log_message('debug', '============================ get_list_by_category : '.$query);
//var_dump($query);
        return $db->query($query)->result_array();
    }


    /**
     * 카테고리 정보
     */
    public function get_category_detail($cate_code)
    {
        $query = "
			select	/*  > etah_mfront > category_m > get_category_detail > ETAH 카테고리 정보 구하기 */
				c3.CATEGORY_DISP_CD				as CATE_CODE3
				, c3.CATEGORY_DISP_NM			as CATE_NAME3
				, c2.CATEGORY_DISP_CD			as CATE_CODE2
				, c2.CATEGORY_DISP_NM			as CATE_NAME2
				, c1.CATEGORY_DISP_CD			as CATE_CODE1
				, c1.CATEGORY_DISP_NM			as CATE_NAME1
				, c3.CATEGORY_DISP_NM			as CATE_TITLE
			from
				DAT_CATEGORY_DISP 	c3
			left join	DAT_CATEGORY_DISP c2
				on	c3.PARENT_CATEGORY_DISP_CD = c2.CATEGORY_DISP_CD
				and	c2.MOB_DISP_YN	= 'Y'
			left join	DAT_CATEGORY_DISP c1
				on	c2.PARENT_CATEGORY_DISP_CD = c1.CATEGORY_DISP_CD
				and	c1.MOB_DISP_YN	= 'Y'
			where
				c3.CATEGORY_DISP_CD	= '".$cate_code."'
			and c3.USE_YN		= 'Y'
			and c3.MOB_DISP_YN = 'Y'
			order by
				c3.SORT_VAL, c3.CATEGORY_DISP_CD
		";
        $db = self::_slave_db();
//var_dump($query);
        return $db->query($query)->row_array();
    }


    /**
     * 카테고리 상품 리스트
     */
    public function get_goods_list($param)
    {
        $limit_num_rows         = $param['limit_num_rows'];
        $startPos               = ($param['page'] - 1) * $limit_num_rows;
        $query_category			= "";
        $query_brand			= "";
        $query_price_limit		= "";
        $query_order_by			= "";
        $query_out_order_by		= "";
        $query_sort_table		= "";
        $query_deli_policy		= "";
        $query_interest_s		= "";
        $query_interest_j		= "";
        $query_global           = "";
//var_dump($param);

        if($limit_num_rows)		$query_limit = "limit $startPos, $limit_num_rows ";

        /* 카테고리 */
        if($param['cate_cd']){
            if($param['cate_gb'] == 'S'){		//소분류
                $query_category = "and	mc.CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }else if($param['cate_gb'] == 'M'){	//중분류
                $query_category = "and	c.PARENT_CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }else if($param['cate_gb'] == 'L'){	//대분류
                $query_category = "and c3.CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }
        }

        /* 금액제한 */
        if($param['price_limit']){
            $arr_price_limit = explode("|", $param['price_limit']);

            if( $arr_price_limit[1]=='' ) {
                $query_price_limit = "and pri.SELLING_PRICE >= '".$arr_price_limit[0]."'";
            } else {
                $query_price_limit = "and pri.SELLING_PRICE >= '".$arr_price_limit[0]."' and pri.SELLING_PRICE <= '".$arr_price_limit[1]."'";
            }
        }

        /* 국가 체크 */
        if($param['country']) {
            $country_list = "";
            $arr_country = explode("|", substr($param['country'],1));

            if( in_array("KR", $arr_country) ) {
                if( count($arr_country)>1 ) {
                    foreach($arr_country as $cntry){
                        if($cntry != 'KR') {
                            $country_list .= ", '".$cntry."'";
                        }
                    }
                    $query_country = "and ( (cnc.COUNTRY_CD is null) or (cnc.COUNTRY_CD in (".substr($country_list,2).")) )";
                } else {
                    $query_country = "and cnc.COUNTRY_CD is null";
                }
            } else {
                $query_country = "and cnc.COUNTRY_CD in ('".str_replace("|", "','", substr($param['country'],1))."')";
            }
        }

        /* 무료배송 체크 */
        if($param['deliv_type']) {
            $query_free_delivery = "and dp.PATTERN_TYPE_CD = 'FREE'";
        }

        /* 브랜드 체크 */
        if($param['brand_cd']){
            $str_brand_cd = str_replace('|',"','", $param['brand_cd']);
            if(strpos($str_brand_cd, ',')) $str_brand_cd = substr($str_brand_cd, 3);
            $query_brand = "and b.BRAND_CD in ('".$str_brand_cd."')";

        }

        /* 묶음배송정책 체크 */
        if($param['deli_policy_no']){
            $query_deli_policy = "and g.DELIV_POLICY_NO = '".$param['deli_policy_no']."'	";
        }

        /* 정렬 */
        if($param['order_by']){
            switch($param['order_by']){
                case 'A' :	//인기순
                    $query_order_by .= "order by eg.PLAN_EVENT_REFER_CD is null asc, sort.GOODS_SORT_SCORE desc, g.GOODS_CD desc";
                    $query_out_order_by .= "order by t.PLAN_EVENT_REFER_CD IS NULL ASC, t.GOODS_SORT_SCORE desc, t.GOODS_CD desc"; break;
                case 'B' :	//신상품순
                    $query_order_by .= "order by g.GOODS_CD desc";
                    $query_out_order_by .= "order by t.GOODS_CD desc"; break;
                case 'C' :	//낮은가격순
                    $query_order_by = "order by pri.SELLING_PRICE asc, g.GOODS_CD desc";
                    $query_out_order_by ="order by COUPON_PRICE asc, t.GOODS_CD desc"; break;
                case 'D' :	//높은가격순
                    $query_order_by = "order by pri.SELLING_PRICE desc, g.GOODS_CD desc";
                    $query_out_order_by ="order by COUPON_PRICE desc, t.GOODS_CD desc"; break;
            }
        }

        /* 직구SHOP 메인 */
        if($param['global_cd']) {
            $query_global = "and g.GOODS_CD in (".$param['global_cd'].")";
            $query_category = ""; //카테고리 지정안함
        }

        /* 관심상품 */
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

        $query = "

			select /*  > etah_mfront > category_m > get_goods_list > ETAH 상품리스트 */
				t.GOODS_CD
				, t.GOODS_NM
				, t.CATEGORY_CD1
				, t.CATEGORY_NM1
				, t.CATEGORY_CD2
				, t.CATEGORY_NM2
				, t.CATEGORY_CD3
				, t.CATEGORY_NM3
				, t.PROMOTION_PHRASE
				, t.BRAND_CD
				, t.BRAND_NM
				, t.BRAND_NM_FST_LETTER
			--	, t.CATEGORY_DISP_CD
			--	, t.CATEGORY_DISP_NM
			
				, if( (cpn_s.COUPON_CD is not null) || (cpn_g.COUPON_CD is not null),
							( t.SELLING_PRICE
								 - (
										ifnull(if(floor(t.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)) > cpn_s.MAX_DISCOUNT && cpn_s.MAX_DISCOUNT != 0, cpn_s.MAX_DISCOUNT, floor(t.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000))),0)
										+ifnull(if(floor(t.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)) > cpn_g.MAX_DISCOUNT && cpn_g.MAX_DISCOUNT != 0, cpn_g.MAX_DISCOUNT, floor(t.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000))),0)
									)
								 - (ifnull(cpn_s.COUPON_FLAT_AMT, 0)+ifnull(cpn_g.COUPON_FLAT_AMT, 0))
							),
							t.SELLING_PRICE
						)                                                                           as COUPON_PRICE
					
				, t.SELLING_PRICE
			--	, gi.IMG_URL
			--	, if(gir.IMG_URL is null, gi.IMG_URL, gir.IMG_URL)		as IMG_URL
				, ifnull(ifnull(girm.IMG_URL, im.IMG_URL), ifnull(gir.IMG_URL, gi.IMG_URL))		as IMG_URL
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
				, round( if(floor(t.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)) > cpn_s.MAX_DISCOUNT && cpn_s.MAX_DISCOUNT != 0, cpn_s.MAX_DISCOUNT, floor(t.SELLING_PRICE * (cpn_s.COUPON_FLAT_RATE / 1000)))/10)*10		as RATE_PRICE_S
				, round( if(floor(t.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)) > cpn_g.MAX_DISCOUNT && cpn_g.MAX_DISCOUNT != 0, cpn_g.MAX_DISCOUNT, floor(t.SELLING_PRICE * (cpn_g.COUPON_FLAT_RATE / 1000)))/10)*10		as RATE_PRICE_G
				, ifnull(cpn_s.COUPON_FLAT_AMT, 0)					as AMT_PRICE_S
				, ifnull(cpn_g.COUPON_FLAT_AMT, 0)					as AMT_PRICE_G
				, cpn_s.COUPON_CD									as COUPON_CD_S
				, cpn_g.COUPON_CD									as COUPON_CD_G
				, ifnull(mileage.GOODS_MILEAGE_SAVE_RATE, 0)		as GOODS_MILEAGE_SAVE_RATE
				
				, t.CLASS_GUBUN
				, t.CLASS_TYPE
				, t.ADDRESS
				, t.DEAL
                , t.COUNTRY_CD
                , t.COUNTRY_NM
                
				$query_interest_s

			from
			(
				select
					g.GOODS_CD
					, ifnull(gmm.NAME, g.GOODS_NM) as GOODS_NM
					, c3.CATEGORY_DISP_CD as CATEGORY_CD1
					, c3.CATEGORY_DISP_NM as CATEGORY_NM1
					, c2.CATEGORY_DISP_CD as CATEGORY_CD2
					, c2.CATEGORY_DISP_NM as CATEGORY_NM2
					, c.CATEGORY_DISP_CD  as CATEGORY_CD3
					, c.CATEGORY_DISP_NM  as CATEGORY_NM3
					, g.PROMOTION_PHRASE
					, g.BRAND_CD
					, b.BRAND_NM_FST_LETTER
					, g.GOODS_MILEAGE_N_GOODS_NO
					, g.DELIV_POLICY_NO
					, b.BRAND_NM
				--	, c.CATEGORY_DISP_CD
				--	, c.CATEGORY_DISP_NM
					, pri.SELLING_PRICE
					, sort.GOODS_SORT_SCORE
					, if(c.PARENT_CATEGORY_DISP_CD='24010000', 'C', if(c.PARENT_CATEGORY_DISP_CD='24020000', 'G', ''))  as CLASS_GUBUN
					, if(cg.CLASS_TYPE='ONE', '원데이', if(cg.CLASS_TYPE='MANY', '다회차', '공방상품'))                   as CLASS_TYPE
					, cg.ADDRESS
					, eg.PLAN_EVENT_REFER_CD
                    , if(eg.PLAN_EVENT_REFER_CD, 'DEAL', '')	as DEAL
                    , IFNULL(cnc.COUNTRY_CD, 'KR')          AS COUNTRY_CD
                    , IFNULL(cntry.COUNTRY_KO_NM, '한국')	AS COUNTRY_NM
				from
					DAT_GOODS 				g
                left join DAT_GOODS_MD_MOD             gmm
                    on g.GOODS_CD                       = gmm.GOODS_CD
                    and gmm.USE_YN                      = 'Y'
				left join	MAP_CLASS_GOODS				cg
					on g.GOODS_CD 						= cg.GOODS_CD
				inner join	DAT_BRAND 					b
					on	g.BRAND_CD 						= b.BRAND_CD
				--	and b.MOB_DISP_YN					= 'Y'
			/*	inner join	MAP_CATEGORY_DISP_N_GOODS	x
					on	g.GOODS_CD						= x.GOODS_CD
				inner join	DAT_CATEGORY_DISP 			c
					on	x.CATEGORY_DISP_CD 				= c.CATEGORY_DISP_CD*/
			
				inner join	DAT_GOODS_PRICE 			pri
					on	g.GOODS_CD 						= pri.GOODS_CD
					and g.GOODS_PRICE_CD 				= pri.GOODS_PRICE_CD
				inner join	DAT_GOODS_PROGRESS			gp
					on	g.GOODS_CD 						= gp.GOODS_CD
					and g.GOODS_PROGRESS_NO 			= gp.GOODS_PROGRESS_NO
					and	gp.GOODS_STS_CD					= '03'
				inner join	COD_GOODS_STS_CD			gs
					on	gp.GOODS_STS_CD 				= gs.GOODS_STS_CD
				/*inner join	(	select	distinct
										mc.GOODS_CD
								from	MAP_CATEGORY_DISP_N_GOODS 	mc
								inner join	DAT_CATEGORY_DISP 		c
									on	mc.CATEGORY_DISP_CD 		= c.CATEGORY_DISP_CD
									and	c.USE_YN 					= 'Y'
								--	and	c.MOB_DISP_YN				= 'Y'
								where	mc.USE_YN					= 'Y'
								$query_category
							) m
					on	g.GOODS_CD						= m.GOODS_CD 
					*/
                inner join MAP_CATEGORY_DISP_N_GOODS mc
                on mc.GOODS_CD = g.GOODS_CD
                and mc.USE_YN = 'Y'
                
                inner join DAT_CATEGORY_DISP c
                on mc.CATEGORY_DISP_CD = c.CATEGORY_DISP_CD
                and c.USE_YN = 'Y'
                
                INNER JOIN      DAT_CATEGORY_DISP         c2
                    ON  c.PARENT_CATEGORY_DISP_CD         = c2.CATEGORY_DISP_CD
                INNER JOIN      DAT_CATEGORY_DISP         c3
                    ON  c2.PARENT_CATEGORY_DISP_CD         = c3.CATEGORY_DISP_CD
					
				left join	DAT_GOODS_SORT_SCORE	sort
					on	g.GOODS_CD		= sort.GOODS_CD
					
				left join DAT_PLAN_EVENT_GOODS      eg
                    on g.GOODS_CD              = eg.GOODS_CD
                    and eg.PLAN_EVENT_CODE    in (586,587)
                    
                INNER JOIN DAT_VENDOR_SUBVENDOR suv
                    ON suv.VENDOR_SUBVENDOR_CD = g.VENDOR_SUBVENDOR_CD
                INNER JOIN DAT_VENDOR v
                    ON v.VENDOR_CD = suv.VENDOR_CD
                LEFT JOIN MAP_COMPANY_N_COUNTRY cnc
                    ON v.COMPANY_CD = cnc.COMPANY_CD
                LEFT JOIN DAT_COUNTRY cntry
                    ON cntry.COUNTRY_CD = cnc.COUNTRY_CD
                    
                inner join	DAT_DELIV_POLICY				dp
                    on	dp.DELIV_POLICY_NO					= g.DELIV_POLICY_NO
                    and dp.USE_YN							= 'Y'
                    
				$query_sort_table

				where
					1 = 1
				and g.MOB_DISP_YN = 'Y'
				$query_brand
				$query_deli_policy
				$query_price_limit
				$query_country
				$query_category
				$query_free_delivery
				$query_global
				
				group by g.GOODS_CD

				$query_order_by
				$query_limit

			) t

			inner join	DAT_GOODS_IMAGE					gi
				on 	t.GOODS_CD 							= gi.GOODS_CD
				and	gi.TYPE_CD							= 'TITLE'
			left join	 DAT_GOODS_IMAGE_RESIZING 		gir
				on 	t.GOODS_CD							= gir.GOODS_CD
				and	gir.TYPE_CD							= '300'
			left join	DAT_GOODS_IMAGE_MD		        im
				on	t.GOODS_CD							= im.GOODS_CD
				and	im.TYPE_CD							= 'TITLE'
			left join	 DAT_GOODS_IMAGE_RESIZING_MD 	girm
				on 	t.GOODS_CD							= girm.GOODS_CD
				and	girm.TYPE_CD						= '300'
			inner join	DAT_DELIV_POLICY				dp
				on	dp.DELIV_POLICY_NO					= t.DELIV_POLICY_NO
				and dp.USE_YN							= 'Y'
			left join	DAT_DELIV_POLICY_PATTERN		dpp
				on dpp.DELIV_POLICY_NO					= dp.DELIV_POLICY_NO
			left join	MAP_GOODS_MILEAGE_N_GOODS		mileage
				on	mileage.GOODS_MILEAGE_N_GOODS_NO	= t.GOODS_MILEAGE_N_GOODS_NO
				and mileage.USE_YN						= 'Y'
			
			left join BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_SELLER cpn_s
				on	t.GOODS_CD = cpn_s.COUPON_APPLICATION_SCOPE_OBJECT_CD

			left join BAT_MAP_COUPON_APPLICATION_SCOPE_OBJECT_GOODS cpn_g
				on	t.GOODS_CD = cpn_g.COUPON_APPLICATION_SCOPE_OBJECT_CD

/*				
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
*/

				$query_interest_j

			group by
				t.GOODS_CD
			$query_out_order_by
		";

//        var_dump($query);
        //log_message('debug', '============================ get_goods_list5 : '.$query);
        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }


    /**
     * 카테고리별 상품 개수 구하기
     */
    public function get_goods_list_count($param)
    {
        $query_category			= "";
        $query_brand			= "";
        $query_price_limit		= "";
        $query_deli_policy		= "";

        /* 카테고리 */
        if($param['cate_cd']){
            if($param['cate_gb'] == 'S'){		//소분류
                $query_category = "and	mc.CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }else if($param['cate_gb'] == 'M'){	//중분류
                $query_category = "and	c.PARENT_CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }else if($param['cate_gb'] == 'L'){	//대분류
                $query_category = "and c3.CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }
        }

        /* 금액제한 */
        if($param['price_limit']){
            $arr_price_limit = explode("|", $param['price_limit']);

            if( $arr_price_limit[1]=='' ) {
                $query_price_limit = "and pri.SELLING_PRICE >= '".$arr_price_limit[0]."'";
            } else {
                $query_price_limit = "and pri.SELLING_PRICE >= '".$arr_price_limit[0]."' and pri.SELLING_PRICE <= '".$arr_price_limit[1]."'";
            }
        }

        /* 국가 체크 */
        if($param['country']) {
            $country_list = "";
            $arr_country = explode("|", substr($param['country'],1));

            if( in_array("KR", $arr_country) ) {
                if( count($arr_country)>1 ) {
                    foreach($arr_country as $cntry){
                        if($cntry != 'KR') {
                            $country_list .= ", '".$cntry."'";
                        }
                    }
                    $query_country = "and ( (cnc.COUNTRY_CD is null) or (cnc.COUNTRY_CD in (".substr($country_list,2).")) )";
                } else {
                    $query_country = "and cnc.COUNTRY_CD is null";
                }
            } else {
                $query_country = "and cnc.COUNTRY_CD in ('".str_replace("|", "','", substr($param['country'],1))."')";
            }
        }

        /* 무료배송 체크 */
        if($param['deliv_type']) {
            $query_free_delivery = "and dp.PATTERN_TYPE_CD = 'FREE'";
        }

        /* 브랜드 체크 */
        if($param['brand_cd']){
            $str_brand_cd = str_replace('|',"','", $param['brand_cd']);
            if(strpos($str_brand_cd, ',')) $str_brand_cd = substr($str_brand_cd, 3);
            $query_brand = "and b.BRAND_CD in ('".$str_brand_cd."')";

        }

        /* 묶음배송정책 체크 */
        if($param['deli_policy_no']){
            $query_deli_policy = "and g.DELIV_POLICY_NO = '".$param['deli_policy_no']."'	";
        }

        /* 직구SHOP 메인 */
        if($param['global_cd']) $query_global = "and g.GOODS_CD in (".$param['global_cd'].")";

        $query = "
			select	/*  > etah_mfront > category_m > get_goods_list_count > ETAH 상품리스트 개수 */
				count(distinct g.GOODS_CD)			as CNT
			from
				DAT_GOODS 				g
			inner join	DAT_BRAND 					b
				on	g.BRAND_CD 						= b.BRAND_CD
			--	and	b.MOB_DISP_YN					= 'Y'
		/*	inner join	MAP_CATEGORY_DISP_N_GOODS	m
				on	g.GOODS_CD						= m.GOODS_CD
			inner join	DAT_CATEGORY_DISP 			c
				on	m.CATEGORY_DISP_CD 				= c.CATEGORY_DISP_CD
		*/
			inner join	DAT_GOODS_PRICE				pri
				on	g.GOODS_CD 						= pri.GOODS_CD
				and g.GOODS_PRICE_CD 				= pri.GOODS_PRICE_CD
			inner join	DAT_GOODS_PROGRESS			gp
				on	g.GOODS_CD 						= gp.GOODS_CD
				and g.GOODS_PROGRESS_NO 			= gp.GOODS_PROGRESS_NO
				and	gp.GOODS_STS_CD					= '03'
		/*	inner join	(	select	distinct
										mc.GOODS_CD
								from	MAP_CATEGORY_DISP_N_GOODS 	mc
								inner join	DAT_CATEGORY_DISP 		c
									on	mc.CATEGORY_DISP_CD 		= c.CATEGORY_DISP_CD
									and	c.USE_YN 					= 'Y'
									and	c.MOB_DISP_YN				= 'Y'
								where	mc.USE_YN					= 'Y'
								$query_category
							) m
					on	g.GOODS_CD						= m.GOODS_CD 
					*/
					
			INNER JOIN MAP_CATEGORY_DISP_N_GOODS     mc
				ON mc.GOODS_CD                        = g.GOODS_CD
				AND mc.USE_YN					       = 'Y'
			INNER JOIN DAT_CATEGORY_DISP              c
				ON c.CATEGORY_DISP_CD                 = mc.CATEGORY_DISP_CD
				AND	c.USE_YN 					       = 'Y'	
					
			INNER JOIN      DAT_CATEGORY_DISP         c2
                    ON  c.PARENT_CATEGORY_DISP_CD         = c2.CATEGORY_DISP_CD
                INNER JOIN      DAT_CATEGORY_DISP         c3
                    ON  c2.PARENT_CATEGORY_DISP_CD         = c3.CATEGORY_DISP_CD
				
            INNER JOIN DAT_VENDOR_SUBVENDOR suv
                ON suv.VENDOR_SUBVENDOR_CD = g.VENDOR_SUBVENDOR_CD
            INNER JOIN DAT_VENDOR v
                ON v.VENDOR_CD = suv.VENDOR_CD
            LEFT JOIN MAP_COMPANY_N_COUNTRY cnc
                ON v.COMPANY_CD = cnc.COMPANY_CD
            LEFT JOIN DAT_COUNTRY cntry
                ON cntry.COUNTRY_CD = cnc.COUNTRY_CD
                
            inner join	DAT_DELIV_POLICY				dp
                on	dp.DELIV_POLICY_NO					= g.DELIV_POLICY_NO
                and dp.USE_YN							= 'Y'
			where
				1 = 1
			and	g.MOB_DISP_YN = 'Y'
			$query_brand
			$query_deli_policy
			$query_price_limit
				$query_country
				$query_category
				$query_free_delivery
				$query_global

		";
        $db = self::_slave_db();
//		var_dump($query);
        //log_message('debug', '============================ get_goods_list_count : '.$query);

        $data = $db->query($query)->row_array();
        return $data['CNT'];
    }

    /**
     * 카테고리별 브랜드 상품 개수
     */
    public function get_brand_goods_count($param)
    {
        $str_brand_cd			= "";
        $query_category			= "";
        $query_categoryL		= "";
        $query_search_keyword	= "";
        $query_category_attr	= "";

        /* 카테고리 */
        if($param['cate_cd']){
            if($param['cate_gb'] == 'S'){
                $query_category = "and	mc.CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }else if($param['cate_gb'] == 'M'){
                $query_category = "and	c.PARENT_CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }else if($param['cate_gb'] == 'L'){	//대분류
                $query_categoryL = "
				inner join DAT_CATEGORY_DISP	CD3
									on g.CATEGORY_MNG_CD							= CD3.CATEGORY_DISP_CD
				inner join DAT_CATEGORY_DISP CD2
									on CD3.PARENT_CATEGORY_DISP_CD					= CD2.CATEGORY_DISP_CD
									and CD2.PARENT_CATEGORY_DISP_CD = '".$param['cate_cd']."'";
            }
        }

        /* 브랜드 체크 */
        if($param['brand_cd']){
            $str_brand_cd = str_replace('|',"','", $param['brand_cd']);
            $str_brand_cd = substr($str_brand_cd, 3);
        }

        /* 카테고리 속성 검색 */
        if($param['attr']){
            $str_attr_cd = str_replace('|',"','", $param['attr']);
            if(strpos($str_attr_cd, ',')) $str_attr_cd = substr($str_attr_cd, 3);
//var_dump($str_attr_cd);

            $query_category_attr = "
				inner join 	MAP_CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR 	ma
					on	mc.CATEGORY_DISP_CD				= ma.CATEGORY_DISP_CD
					and ma.USE_YN						= 'Y'
					and ma.GOODS_CLASSIFICATION_ATTR_CD	in ('".$str_attr_cd."')
				inner join	MAP_CLASS_ATTR_N_GOODS 		mag
					on 	mc.GOODS_CD						= mag.GOODS_CD
					and	mag.CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR_NO = ma.CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR_NO
			";
        }

        /* 검색 */
        if($param['keyword']) $query_search_keyword = "and	(g.GOODS_NM like '%".$param['keyword']."%' or g.PROMOTION_PHRASE like '%".$param['keyword']."%' or b.BRAND_NM = '".$param['keyword']."')";


        $query = "
			select	/*  > etah_mfront > category_m > get_brand_goods_count > ETAH 브랜드 상품개수 구하기 */
				bb.BRAND_CD
				, bb.BRAND_NM
				, b.GOODS_CNT
				, ifnull(lb.BRAND_CD,'N')	as FLAG_YN
			from
			(
				select
					b.BRAND_CD			as CODE
					, count(g.GOODS_CD)	as GOODS_CNT
				from	DAT_BRAND b
					inner join	DAT_GOODS					g
						on 	g.BRAND_CD						= b.BRAND_CD
						and g.MOB_DISP_YN					= 'Y'
					inner join	DAT_GOODS_PROGRESS			gp
						on	g.GOODS_CD 						= gp.GOODS_CD
						and g.GOODS_PROGRESS_NO				= gp.GOODS_PROGRESS_NO
						and	gp.GOODS_STS_CD					= '03'
				/*	inner join	(	select	distinct
										mc.GOODS_CD
								from	MAP_CATEGORY_DISP_N_GOODS 	mc
								inner join	DAT_CATEGORY_DISP 		c
									on	mc.CATEGORY_DISP_CD 		= c.CATEGORY_DISP_CD
									and	c.USE_YN 					= 'Y'
								--	and c.MOB_DISP_YN				= 'Y'
								$query_category_attr
								where	mc.USE_YN					= 'Y'
								$query_category
							) m
					on	g.GOODS_CD						= m.GOODS_CD */
					$query_categoryL
				where
					1 = 1
			--	and	b.MOB_DISP_YN = 'Y'
				$query_search_keyword
				group by
					CODE
			) b
			inner join	DAT_BRAND		bb
				on 	bb.BRAND_CD			= b.CODE
			left join	DAT_BRAND		lb
				on 	lb.BRAND_CD			= b.CODE
				and lb.BRAND_CD 		in('".$str_brand_cd."')
			order by
				GOODS_CNT desc
		";
        $db = self::_slave_db();
        //log_message('debug', '============================ get_brand_goods_count : '.$query);
//		var_dump($query);
        return $db->query($query)->result_array();
    }

    /**
     * 카테고리별 하위속성(디자인)
     */
    public function get_category_attr($cate_code)
    {
        $query = "
			select	/*  > etah_mfront > category_m > get_category_attr > ETAH 카테고리 하위속성 구하기 */
				 a1.GOODS_CLASSIFICATION_ATTR_CD		as ATTR_CODE1
				, a1.GOODS_CLASSIFICATION_ATTR_CD_NM	as ATTR_NAME1
				, a2.GOODS_CLASSIFICATION_ATTR_CD		as ATTR_CODE2
				, a2.GOODS_CLASSIFICATION_ATTR_CD_NM	as ATTR_NAME2
			from
				DAT_CATEGORY_DISP 	c3
			inner join 	MAP_CATEGORY_DISP_N_GOODS_CLASSIFICATION_ATTR 	m
				on	m.CATEGORY_DISP_CD 									= c3.CATEGORY_DISP_CD
				and m.USE_YN											= 'Y'
			inner join	DAT_GOODS_CLASSIFICATION_ATTR					a2
				on	a2.GOODS_CLASSIFICATION_ATTR_CD						= m.GOODS_CLASSIFICATION_ATTR_CD
			inner join	DAT_GOODS_CLASSIFICATION_ATTR 					a1
				on	a2.PARENT_GOODS_CLASSIFICATION_ATTR_CD 				= a1.GOODS_CLASSIFICATION_ATTR_CD
			where
				c3.CATEGORY_DISP_CD = '".$cate_code."'
			and	c3.MOB_DISP_YN = 'Y'
			and a1.GOODS_CLASSIFICATION_ATTR_CD = '11000'
			order by
				a1.GOODS_CLASSIFICATION_ATTR_CD_NM, a2.GOODS_CLASSIFICATION_ATTR_CD_NM
		";

        $db = self::_slave_db();
//var_dump($query);
        return $db->query($query)->result_array();
    }

    /**
     * 에타 카테고리 메인 추가
     * 2018.07.02
     */
    public function get_md_goods($gubun1,$gubun2)
    {
//        $query = "
//			select	/*  > etah_front > category_m > get_md_goods > ETAH 에타 카테고리 메인 */
//				g.GOODS_CD
//				, g.GOODS_NM
//				, b.BRAND_NM
//				, ifnull(mdG.IMG_URL, i.IMG_URL)					as IMG_URL
//				, pri.SELLING_PRICE
//				, mdG.SEQ
//				, mdG.LINK_URL
//				, if(mdG.SEQ = '2', 'cpp_goods_item__big', if(mdG.SEQ = '5', 'min_layout_item', if(mdG.SEQ = '6', 'cpp_goods_item__big min_layout_item', '')))	as CLASS_NM
//				, mdG.RGB
//				, mdG.DISP_HTML
//			from
//				DAT_MAINCATEGORY_MDGOODS_DISP 	mdG
//				left join	DAT_GOODS						g
//					on	mdG.GOODS_CD						= g.GOODS_CD
//					and	g.WEB_DISP_YN						= 'Y'
//				left join	DAT_BRAND 						b
//					on	g.BRAND_CD 							= b.BRAND_CD
//				--	and	b.WEB_DISP_YN						= 'Y'
//				left join	DAT_GOODS_IMAGE 				i
//					on 	g.GOODS_CD  						= i.GOODS_CD
//					and i.TYPE_CD							= 'TITLE'
//				left join	DAT_GOODS_PRICE 				pri
//					on 	g.GOODS_CD							= pri.GOODS_CD
//					and	g.GOODS_PRICE_CD 					= pri.GOODS_PRICE_CD
//			where
//				mdG.GUBUN = '".$gubun."'
//
//			order by
//				mdG.SEQ
//			limit 1, 2
//
//		";
        $query = "
					select    /*  > etah_mfront > category_m > get_md_goods > ETAH 에타 카테고리 메인 */
					    group_concat(md.BANNER_CD SEPARATOR ',') as banner_cd from
						((select				
							g.GOODS_CD
							, g.GOODS_NM
							, b.BRAND_NM
							, ifnull(mdG.IMG_URL, i.IMG_URL)					as IMG_URL
							, pri.SELLING_PRICE
							, mdG.SEQ
							, mdG.LINK_URL
							, if(mdG.SEQ = '2', 'cpp_goods_item__big', if(mdG.SEQ = '5', 'min_layout_item', if(mdG.SEQ = '6', 'cpp_goods_item__big min_layout_item', '')))	as CLASS_NM
							, mdG.RGB
							, mdG.DISP_HTML
							, case mdG.BANNER_CD
								when '' then '0'
								when null then '0'
								else mdG.BANNER_CD
								end as BANNER_CD
						from
							DAT_MAINCATEGORY_MDGOODS_DISP 	mdG
							left join	DAT_GOODS						g
								on	mdG.GOODS_CD						= g.GOODS_CD
								and	g.WEB_DISP_YN						= 'Y'
							left join	DAT_BRAND 						b
								on	g.BRAND_CD 							= b.BRAND_CD
							--	and	b.WEB_DISP_YN						= 'Y'
							left join	DAT_GOODS_IMAGE 				i
								on 	g.GOODS_CD  						= i.GOODS_CD
								and i.TYPE_CD							= 'TITLE'
							left join	DAT_GOODS_PRICE 				pri
								on 	g.GOODS_CD							= pri.GOODS_CD
								and	g.GOODS_PRICE_CD 					= pri.GOODS_PRICE_CD
						where
							mdG.GUBUN = '".$gubun1."'
			
						order by
							mdG.SEQ
						limit 1, 2)
						
						union all
						
						(select	
							g.GOODS_CD
							, g.GOODS_NM
							, b.BRAND_NM
							, ifnull(mdG.IMG_URL, i.IMG_URL)					as IMG_URL
							, pri.SELLING_PRICE
							, mdG.SEQ
							, mdG.LINK_URL
							, if(mdG.SEQ = '2', 'cpp_goods_item__big', if(mdG.SEQ = '5', 'min_layout_item', if(mdG.SEQ = '6', 'cpp_goods_item__big min_layout_item', '')))	as CLASS_NM
							, mdG.RGB
							, mdG.DISP_HTML
							, case mdG.BANNER_CD
								when '' then '0'
								when null then '0'
								else mdG.BANNER_CD
								end as BANNER_CD
						from
							DAT_MAINCATEGORY_MDGOODS_DISP 	mdG
							left join	DAT_GOODS						g
								on	mdG.GOODS_CD						= g.GOODS_CD
								and	g.WEB_DISP_YN						= 'Y'
							left join	DAT_BRAND 						b
								on	g.BRAND_CD 							= b.BRAND_CD
							--	and	b.WEB_DISP_YN						= 'Y'
							left join	DAT_GOODS_IMAGE 				i
								on 	g.GOODS_CD  						= i.GOODS_CD
								and i.TYPE_CD							= 'TITLE'
							left join	DAT_GOODS_PRICE 				pri
								on 	g.GOODS_CD							= pri.GOODS_CD
								and	g.GOODS_PRICE_CD 					= pri.GOODS_PRICE_CD
						where
							mdG.GUBUN = '".$gubun2."'
			
						order by
							mdG.SEQ
						limit 1, 2)) as md
			";
        $db = self::_master_db();
//		var_dump($query);
//		log_message('debug', '============================ get_md_goods : '.$query);
        return $db->query($query, array($gubun1,$gubun2))->row_array();
    }

    /**
     * 에타 초이스 by batch table 추가
     * 2018.07.02
     */
    public function get_md_goods_choice_batch($gubun)
    {
        $query = "
			select	/*  > etah_mfront > category_m > get_md_goods_choice_batch > ETAH 에타 초이스 상품 구하기(batch table) */
				bat.GOODS_CD
				, bat.GOODS_NM
				, bat.BRAND_NM
				, bat.IMG_URL
				, bat.SELLING_PRICE
				, bat.SEQ
				, bat.LINK_URL
				, bat.NAME
				, bat.RGB
				, bat.DISP_HTML
				, bat.RATE_PRICE
				, bat.AMT_PRICE
				, bat.COUPON_CD
				, cg.ADDRESS
				, if(cd.PARENT_CATEGORY_DISP_CD=24010000, 'C', if(cd.PARENT_CATEGORY_DISP_CD=24020000, 'G', '')) 	as CLASS_GUBUN
				, if(cg.CLASS_TYPE='ONE', '원데이', if(cg.CLASS_TYPE='MANY', '다회차', '공방상품'))					as CLASS_TYPE
				, dp.PATTERN_TYPE_CD
				, sum(dpp.DELIV_COST_DECIDE_VAL)	as DELI_LIMIT	
				, (select PLAN_EVENT_REFER_CD from DAT_PLAN_EVENT_GOODS
					where GOODS_CD = bat.GOODS_CD and PLAN_EVENT_CODE in (586,587) limit 1)  as DEAL
			from
				BAT_ETAH_CHOICE bat
				inner join MAP_CATEGORY_DISP_N_GOODS mcg
					on bat.GOODS_CD = mcg.GOODS_CD
				inner join DAT_CATEGORY_DISP cd
					on mcg.CATEGORY_DISP_CD = cd.CATEGORY_DISP_CD
				left join MAP_CLASS_GOODS cg
					on bat.GOODS_CD = cg.GOODS_CD
				inner join DAT_GOODS g
					on g.GOODS_CD = bat.GOODS_CD
				inner join DAT_DELIV_POLICY dp
					on g.DELIV_POLICY_NO = dp.DELIV_POLICY_NO
				left join DAT_DELIV_POLICY_PATTERN dpp
					on dpp.DELIV_POLICY_NO = dp.DELIV_POLICY_NO
			where
				GUBUN =  '".$gubun."'
			group by
				bat.GUBUN, bat.SEQ
			order by
				SEQ
		";
        $db = self::_master_db();
//		var_dump($query);
//		log_message('debug', '============================ get_md_goods_choice : '.$query);
        return $db->query($query)->result_array();
    }

    /**
     * 에타 카테고리 메인 배너조회
     * 2018.10.22
     */
    public function get_Banner($param)
    {
        $query_banner_code = " and b.BANNER_NO in ( ".$param." ) ";

        $query="select /*  > etah_mfront > category_m > get_Banner > ETAH 카테고리 메인 배너 구하기 */
                      b.BANNER_MAIN_TITLE
                    , b.BANNER_SUB_TITLE
                    , b.BANNER_SUB_TITLE_2
                    , b.BANNER_FONT_CLASS_GB_CD1
                    , b.BANNER_FONT_CLASS_GB_CD2
                    , b.BANNER_FONT_CLASS_GB_CD3
                    , b.BANNER_FONTCOLOR_CLASS_GB_CD1
                    , b.BANNER_FONTCOLOR_CLASS_GB_CD2
                    , b.BANNER_FONTCOLOR_CLASS_GB_CD3
                    , b.BANNER_FONTWEIGHT_CLASS_GB_CD1
                    , b.BANNER_FONTWEIGHT_CLASS_GB_CD2
                    , b.BANNER_FONTWEIGHT_CLASS_GB_CD3
                    , b.BANNER_FONT_SIZE1
                    , b.BANNER_FONT_SIZE2
                    , b.BANNER_FONT_SIZE3
                    , b.BANNER_IMG_URL
                    , b.BANNER_LINK_URL
                    , case b.BANNER_LOCATION when 'L' then '01'
                                              when 'M' then '02'
                                              else '03' end as BANNER_LOCATION
 
                from DAT_BANNER b where
                 1=1
                 $query_banner_code
                 order by field(b.BANNER_NO,$param)";

        $sdb = self::_slave_db();
        $result = $sdb->query($query)->result_array();
//log_message('DEBUG','=========='.$sdb->last_query());
        return $result;
    }
}
?>

