<?php
/**
 * Created by PhpStorm.
 * User: YIC-007
 * Date: 2019-11-06
 * Time: 오후 5:40
 */


class Visit extends MY_Controller
{
    protected $methods = array(//'index_get' => array('log' => 0)
    );

    function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: api_key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }

        parent::__construct();

        /* model_m */
        $this->load->model('visit_m');


        /**
         * 로그 기록 여부 설정
         */
        $method_id = explode(".", $this->uri->segment(2));
        if (!empty($method_id[0])) {
            $method_type = strtolower($method);
            $funtion = $method_id[0] . "_" . $method_type;
            if (!config_item('log')) $this->methods[$funtion] = array('log' => 0);
        }

        //API Key 사용시 해당 값을 설정하면 키검사를 하지 않음
        $this->_allow = TRUE;
    }

    /**
     * 매장방문 예약시스템
     * 고객 화면
     */
    public function cust_get()
    {
        $reserve_no = $this->uri->segment(3);

        $info = $this->visit_m->get_reservationInfo($reserve_no);

        if(empty($info)) {
            $this->load->view('template/error_404');
        } else {
            $data = array();

            $data['sTime'] = substr($info['VISIT_START_DT'], "11", "5");    //시간 (시:분)까지 추출
            $data['eTime'] = substr($info['VISIT_END_DT'], "11", "5");    //시간 (시:분)까지 추출

            $data['reserve'] = $info;

            $this->load->view('visit/visit_cust', $data);
        }

    }

    /**
     * 매장방문 예약시스템
     * 고객 예약 취소
     */
    public function reservation_cancel_post()
    {
        $param = $this->input->post();

        $result = $this->visit_m->set_reservation_sts_cd($param['reserve_cd'], '05');

        if($result) {
            $this->response(array('status' => 'ok', 'message' => '예약취소 성공'), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => '예약 취소에 실패하였습니다.'), 200);
        }
    }

    /**
     * 매장방문 예약시스템
     * 판매자 화면
     */
    public function seller_get()
    {
        $reserve_no = $this->uri->segment(3);

        $info = $this->visit_m->get_reservationInfo($reserve_no);

        if(empty($info)) {
            $this->load->view('template/error_404');
        } else {
            $data = array();

            $data['sTime'] = substr($info['VISIT_START_DT'], "11", "5");    //시간 (시:분)까지 추출
            $data['eTime'] = substr($info['VISIT_END_DT'], "11", "5");    //시간 (시:분)까지 추출

            $data['reserve'] = $info;

            $this->load->view('visit/visit_seller', $data);
        }
    }

    /**
     * 매장방문 예약시스템
     * 판매자 예약 확정
     */
    public function reservation_confirm_post()
    {
        $param = $this->input->post();

        $param['start_dt' ] = $param['sdate']." ".$param['stime'].":00";
        $param['end_dt'   ] = $param['edate']." ".$param['etime'].":00";

        //시간변경
        if( $this->visit_m->set_reservation_time($param) ) {
            //상태값 변경
            if( $this->visit_m->set_reservation_sts_cd($param['reserve_no'], '02') ) {
                $this->response(array('status' => 'ok', 'message' => '예약확정 성공'), 200);
            } else {
                $this->response(array('status' => 'fail', 'message' => '예약 확정에 실패하였습니다.'), 200);
            }
        } else {
            $this->response(array('status' => 'fail', 'message' => '시간 변경에 실패하였습니다.'), 200);
        }
    }

    /**
     * 매장방문 예약시스템
     * 판매자 방문 완료
     */
    public function reservation_complete_post()
    {
        $param = $this->input->post();

        $result = $this->visit_m->set_reservation_sts_cd($param['reserve_cd'], '04');

        if($result) {
            $this->response(array('status' => 'ok', 'message' => '방문완료 성공'), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => '방문완료에 실패하였습니다.'), 200);
        }
    }

}