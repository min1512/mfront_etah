<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Footer_m extends CI_Model {

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
	 * 입점문의 등록
	 */
	public function register_que($param)
	{
		$query = "
			insert into	DAT_STANDING_POINT_QUE      /*  > etah_mfront > footer_m > register_que > 입점문의 등록 */
			(
				COMPANY_NM
				, ZIPCODE
				, ADDR
				, CATEGORY_NM
				, BRAND_GOODS_NM
				, GOODS_COMPANY_DESC
				, ASSIGNED_NM
				, TEL
				, EMAIL
				, SITE_URL
				, AGREEMENT_YN
			)values(
				'".$param['company_nm']."'
				,'".$param['post_no']."'
				, '".$param['address1']." ".$param['address2']."'
				, '".$param['category']."'
				, '".$param['brand_goods_nm']."'
				, '".$param['company_desc']."'
				, '".$param['name']."'
				, '".$param['phone']."'
				, '".$param['email']."'
				, '".$param['siteMapUrl']."'
				, 'Y'
				
				)
		";

        $db = self::_master_db();
        $db->query($query);
        return $db->insert_id();
	}

    /**
     * 입점문의 파일업로드 등록
     */
    public function update_que_file_path($title, $que_id){
        $query = "
            update    /*  > etah_mfront > footer_m > update_que_file_path > 입점문의 파일업로드 등록 */
                  DAT_STANDING_POINT_QUE q 
            set 
                  q.FILE_URL = '".$title."'
            where 
                  q.STANDING_POINT_QUE_NO = '".$que_id."'
        ";

        $db = self::_master_db();
        return $db->query($query);
    }
}


?>