<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer2_m extends CI_Model {

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
	 * 공지사항
	 */
	public function get_notice_list($param)
	{
		$limit_num_rows         = $param['limit_num_rows'];
        $startPos               = ($param['page'] - 1) * $limit_num_rows;

		if($limit_num_rows)		$query_limit = "limit $startPos, $limit_num_rows ";

		$query = "
			select 	/*  > etah_mfront > customer2_m > get_notice_list > ETAH 공지사항 리스트 */
				n.NOTICE_NO
				, n.TITLE
				, n.REG_DT
			from
				DAT_NOTICE n
			where
				n.USE_YN = 'Y'
			order by
				n.NOTICE_NO desc
			$query_limit
		";

		$db = self::_slave_db();
		return $db->query($query)->result_array();
	}

	/**
	 * 공지사항 개수
	 */
	public function get_notice_list_count($param)
	{
		$query = "
			select 	/*  > etah_mfront > customer2_m > get_notice_list_count > ETAH 공지사항 개수 */
				count(n.NOTICE_NO)		as total_cnt
			from
				DAT_NOTICE n
				inner join	DAT_NOTICE_CONTENT 	nc
					on	n.NOTICE_NO 			= nc.NOTICE_NO
			where
				n.USE_YN = 'Y'
		";

		$db = self::_slave_db();
		$result = $db->query($query)->row_array();
		return $result['total_cnt'];
	}

	/**
	 * 공지사항 상세
	 */
	public function get_notice_detail($notice_no)
	{
		$query = "
			select 	/*  > etah_mfront > customer2_m > get_notice_detail > ETAH 공지사항 상세페이지 */
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
				and nc.USE_YN = 'Y'
				and n.NOTICE_NO = ".$notice_no."
		";

		$db = self::_slave_db();
		$result = $db->query($query)->row_array();
		return $result;
	}


}