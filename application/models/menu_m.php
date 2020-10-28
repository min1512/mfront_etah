<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_m extends CI_Model {

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

	public function get_catemenu()
	{
		$query	= "
			select			/*  > etah_mfront > menu_m > get_catemenu > 전시카테고리 배너 조회 */
				c.CATEGORY_DISP_CD
				, c.CATEGORY_DISP_NM
			/*	,(	case
						when c.CATEGORY_DISP_CD = '10000000' then '1'
						when c.CATEGORY_DISP_CD = '11000000' then '2'
						when c.CATEGORY_DISP_CD = '13000000' then '3'
						when c.CATEGORY_DISP_CD = '14000000' then '4'
						when c.CATEGORY_DISP_CD = '15000000' then '5'
						when c.CATEGORY_DISP_CD = '16000000' then '6'
						when c.CATEGORY_DISP_CD = '19000000' then '7'
						when c.CATEGORY_DISP_CD = '17000000' then '8'
						when c.CATEGORY_DISP_CD = '18000000' then '9'
					end	)			as sort		*/
				, m.LINK_URL		as CATE_BANNER_LINK
				, m.NAME			as CATE_BANNER_NAME
				, m.IMG_URL			as CATE_BANNER_IMG
			from
				DAT_CATEGORY_DISP 	c
			left join	DAT_MAINCATEGORY_MDGOODS_DISP 	m
				on	m.GUBUN								= concat('CATE_MENU_',c.CATEGORY_DISP_CD)
			where
				c.PARENT_CATEGORY_DISP_CD is null
				and	c.USE_YN = 'Y'
				and c.MOB_DISP_YN = 'Y'
				and c.CATEGORY_DISP_CD not in (20000000, 24000000)		/*해외직구, .공방 가져오지 않기.*/
			order by
			   c.CATEGORY_DISP_CD
		";

		$db = self::_slave_db();
		return $db->query($query)->result_array();
	}

	public function get_menu($parent_code)
	{

		$query	= "
			select			/*  > etah_mfront > menu_m > get_menu > 전시카테고리 조회 */
				c.CATEGORY_DISP_CD
				, c.CATEGORY_DISP_NM
				, c.PARENT_CATEGORY_DISP_CD
			from
				DAT_CATEGORY_DISP 	c
            where
				c.PARENT_CATEGORY_DISP_CD	= '".$parent_code."'
			and	c.USE_YN					= 'Y'
			and c.MOB_DISP_YN				= 'Y'
            order by
				c.SORT_VAL, c.CATEGORY_DISP_CD
		";

		$db = self::_slave_db();
		return $db->query($query)->result_array();
	}

	public function get_cate_menu()
	{
		$query = "
			select		/*  > etah_mfront > menu_m > get_cate_menu > 전시카테고리 배너 조회 */
				c.CATEGORY_DISP_CD			as CATE_CODE1
				, c.CATEGORY_DISP_NM		as CATE_NAME1
				, subC.CATEGORY_DISP_CD		as CATE_CODE2
				, subC.CATEGORY_DISP_NM		as CATE_NAME2
			/*	,(	case
						when c.CATEGORY_DISP_CD = '10000000' then '1'
						when c.CATEGORY_DISP_CD = '11000000' then '2'
						when c.CATEGORY_DISP_CD = '13000000' then '3'
						when c.CATEGORY_DISP_CD = '14000000' then '4'
						when c.CATEGORY_DISP_CD = '15000000' then '5'
						when c.CATEGORY_DISP_CD = '16000000' then '6'
						when c.CATEGORY_DISP_CD = '19000000' then '7'
						when c.CATEGORY_DISP_CD = '17000000' then '8'
						when c.CATEGORY_DISP_CD = '18000000' then '9'
					end	)			as sort		*/
				, m.LINK_URL		as CATE_BANNER_LINK
				, m.NAME			as CATE_BANNER_NAME
				, m.IMG_URL			as CATE_BANNER_IMG
			from
				DAT_CATEGORY_DISP 	c
			inner join	DAT_CATEGORY_DISP 				subC
				on	c.CATEGORY_DISP_CD 					= subC.PARENT_CATEGORY_DISP_CD
				and subC.USE_YN							= 'Y'
			left join	DAT_MAINCATEGORY_MDGOODS_DISP 	m
				on	m.GUBUN								= concat('CATE_MENU_',c.CATEGORY_DISP_CD)
			where
				c.PARENT_CATEGORY_DISP_CD is null
			and	c.USE_YN = 'Y'
			and c.MOB_DISP_YN = 'Y'
			order by
				c.SORT_VAL, subC.CATEGORY_DISP_CD

		";

		$db = self::_slave_db();
		return $db->query($query)->result_array();
	}
}
?>

