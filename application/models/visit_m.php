<?php
/**
 * Created by PhpStorm.
 * User: YIC-007
 * Date: 2019-11-06
 * Time: 오후 5:40
 */


if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Visit_m extends CI_Model
{

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
        if (!empty($this->sdb)) return $this->sdb;

        /* 데이타베이스 연결 */
        $this->load->helper('array');
        $database = random_element(config_item('slave'));
        $this->sdb = $this->load->database($database, TRUE);

        return $this->sdb;
    }

    private function _master_db()
    {
        if (!empty($this->mdb)) return $this->mdb;

        /* 데이타베이스 연결 */
        $this->load->helper('array');
        $database = random_element(config_item('master'));
        $this->mdb = $this->load->database($database, TRUE);

        return $this->mdb;
    }

    /**
     * 매장방문 예약정보 가져오기
     */
    public function get_reservationInfo($reserve_no)
    {
        $query = "
                select    /*  > etah_mfront > visit_m > get_reservationInfo > 매장방문 예약정보 가져오기 */
                        r.RESERVATION_NO
                        , r.GOODS_CD
                        , p.RESERVATION_STS_CD
                        , r.CUST_NM
                        , r.MOB_NO
                        , r.VISIT_START_DT
                        , r.VISIT_END_DT
                        , ifnull(irm.IMG_URL, ifnull(im.IMG_URL, ifnull(ir.IMG_URL, i.IMG_URL)))	as IMG_URL
                from 
                        DAT_RESERVATION_INFO r 
                        
                inner join DAT_RESERVATION_PROGRESS p
                on r.RESERVATION_PROC_STS_NO = p.RESERVATION_PROC_STS_NO
                        
                left join DAT_GOODS_IMAGE i
                on r.GOODS_CD = i.GOODS_CD
                and i.USE_YN = 'Y'
                
                left join DAT_GOODS_IMAGE_RESIZING ir
                on ir.TYPE_CD = '400'
                and r.GOODS_CD = ir.GOODS_CD
                and ir.USE_YN = 'Y'
                
                left join DAT_GOODS_IMAGE_MD im
                on r.GOODS_CD = im.GOODS_CD
                and im.USE_YN = 'Y'
                
                left join DAT_GOODS_IMAGE_RESIZING_MD irm
                on irm.TYPE_CD = '400'
                and r.GOODS_CD = irm.GOODS_CD
                and irm.USE_YN = 'Y'
                
                where 
                      1=1
                and r.USE_YN = 'Y' 
                and r.RESERVATION_NO = '".$reserve_no."'
        ";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 예약상태코드 변경
     */
    public function set_reservation_sts_cd($reserve_cd, $status)
    {
        $db = self::_master_db();

        //예약 진행상태 insert
        $query1 = "
            insert into     DAT_RESERVATION_PROGRESS    /*  > etah_mfront > visit_m > set_reservation_sts_cd > 예약상태코드 변경 */
            (
                    RESERVATION_NO
                    , RESERVATION_STS_CD
            )
            values (
                  '".$reserve_cd."'
                  , '".$status."'
            )
        ";

        $db->query($query1);
        $reservation_progress_no = $db->insert_id();


        //예약 진행상태 번호 update
        $query2 = "
            update     /*  > etah_mfront > visit_m > set_reservation_sts_cd > 예약 진행상태 번호 update */
                  DAT_RESERVATION_INFO i    
            set 
                  i.RESERVATION_PROC_STS_NO = '".$reservation_progress_no."' 
            where 
                  i.RESERVATION_NO = '".$reserve_cd."'
        ";

        return $db->query($query2);
    }

    /**
     * 예약시간 변경
     */
    public function set_reservation_time($param)
    {
        $query = "
            update     /*  > etah_mfront > visit_m > set_reservation_time > 예약시간 변경 */
                  DAT_RESERVATION_INFO i
            set 
                  i.VISIT_START_DT = '".$param['start_dt']."'
                  , i.VISIT_END_DT = '".$param['end_dt']."'
            where 
                  i.RESERVATION_NO = '".$param['reserve_no']."'
        ";

        $db = self::_master_db();
        return $db->query($query);
    }


}