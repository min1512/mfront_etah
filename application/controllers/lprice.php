<?php

class Lprice extends MY_Controller
{

    protected $methods = array(
        //'index_get' => array('log' => 0)
    );

    function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: api_key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }

        parent::__construct();


        /**
         * 로그 기록 여부 설정
         */
        $method_id = explode(".", $this->uri->segment(2));
        if( ! empty($method_id[0])) {
            $method_type = strtolower($method);
            $funtion = $method_id[0]."_".$method_type;
            if(!config_item('log')) $this->methods[$funtion] = array('log' => 0);
        }

        //API Key 사용시 해당 값을 설정하면 키검사를 하지 않음
        $this->_allow = TRUE;

        /* model_m */
        $this->load->model('order_m');
    }

    public function index_get()
    {
        self::Gateway_Linkprice();
    }

    /**
     * 2018.10.02 Linkprice 추가
     */
    // 링크프라이스 Gateway
    public function Gateway_Linkprice(){

        define(RETURN_DAYS,15);			    //광고 인정 기간(Cookie expire time)
        $lpinfo = $_REQUEST["lpinfo"];		//어필리에이트 정보(Affiliate info)
        $url = $_REQUEST["url"];			//이동할 페이지(URL of redirection)
        $domain = '.etah.co.kr';	        //서비스 중인 도메인 (Domain in service)
        if ($lpinfo == "" ||  $url == "")  {
            // alert: LPMS: Parameter Error
            echo "<html><head><script type=\"text/javascript\">
            alert('LPMS: Unable to connect. Contact your linkprice site representative');
            history.go(-1);
            </script></head></html>";
            exit;
        }
        Header("P3P:CP=\"NOI DEVa TAIa OUR BUS UNI\"");
        if (RETURN_DAYS == 0) {
            SetCookie("LPINFO", $lpinfo, 0, "/", $domain);
        } else {
            SetCookie("LPINFO", $lpinfo, time() + (RETURN_DAYS * 24 * 60 * 60), "/", $domain);
        }
        Header("Location: ".$url);
    }
}