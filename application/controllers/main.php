<?php
/**
 * User: Joe, Yong June
 * Date: 2016/04/04
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller
{

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
        /* model_m */
        $this->load->model('main_m');
        $this->load->model('cart_m');
    }

    public function index_get()
    {
        self::main_get();
    }

    public function main_org2_get()
    {
//        header("Cache-Control: max-age=60");
        /**
         * 상단 카테고리 데이타
         */
        $data = array();

        $top_banner = $this->main_m->get_md_goods('MOB_MAIN_TOP');
//        var_dump($top_banner);
        $data['top'			] = $this->main_m->get_banner($top_banner[0]['BANNER_CD']);
//        var_dump($data['top'			]);
        /* HOT Issue keyword */
        $hotkey = $this->main_m->get_md_goods('MOB_HOT_KEYWORD');
        for($i=0; $i<count($hotkey); $i++){
            if($hotkey[$i]['NAME'] != null)
                $keyword[$i] = $hotkey[$i];
        }
        $data['keyword'] = $keyword;

        /* Weekly theme */
        $data['new_item'	] = $this->main_m->get_md_goods('MOB_WEEKLY_THEME');

        /* Brand Focus */
        $data['new_brand'	] = $this->main_m->get_md_goods('MOB_BRAND_FOCUS');

        /* MD 픽! */
        $data['etah_choice'	] = $this->main_m->get_md_goods_choice_c('MAIN_ETAH_CHOICE'); //쿼리

        /* BRAND RECOMMENDATION */
        $data['brand_recommendation'] = $this->main_m->get_md_brand('MOB_MAIN_RCMD');

        /* CLLECTION */
        $data['collection_t'] = $this->main_m->get_md_goods('MAIN_COLLECTION_TITL'); //TITL 오타아님
        $data['collection'	] = $this->main_m->get_md_goods_choice_c('MAIN_COLLECTION'); //쿼리

        // 주력 상품 재배치.
        $param= $data['collection'];
        unset($data['collection'][0]);
        unset($data['collection'][1]);
        $data['collection'][8] = $param[0];
        $data['collection'][9] = $param[1];

        /* MAGAZINE */
        $magazine = $this->main_m->get_md_goods('MAIN_MAGAZINE');

        for($i=0; $i<count($magazine); $i++){
            $magazine[$i]['NAME'] = explode('||',$magazine[$i]['NAME']);
        }
        $data['magazine'	] = $magazine;

        //$data['bar_md'	] = "Y";

        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
        $data['menu'] = $category_menu['category'];

        $this->load->view('include/header', $data);
        $this->load->view('change_main');
        $this->load->view('include/footer');
    }

    public function main_org_get()
    {
        $data = array();

        /* TOP BANNER */
        $data['top'			] = $this->main_m->get_md_goods('MOB_MAIN_TOP');
//var_dump($data['top']);
//		//메인롤링배너 DB에서 가져오기
//		$top_disp_html		  = $data['top'][0]['DISP_HTML'];
//
//		$rolling_top = str_replace('main_banner_item','main-banner-item',$top_disp_html);
//		$rolling_top = str_replace('main_banner_link','main-banner-link',$rolling_top);
//
//		$data['rolling_top']	= $rolling_top;


        /* 에타 초이스 */
        $data['etah_choice'	] = $this->main_m->get_md_goods_choice('MAIN_ETAH_CHOICE');

        /* BRAND RECOMMENDATION */
        $data['brand_recommendation'] = $this->main_m->get_md_brand('MOB_MAIN_RCMD');

        /* BEST 상품 */
        $data['best_goods'	] = $this->main_m->get_best_goods();

        /* MAGAZINE */
        $magazine = $this->main_m->get_md_goods('MAIN_MAGAZINE');

        for($i=0; $i<count($magazine); $i++){
            $magazine[$i]['NAME'] = explode('||',$magazine[$i]['NAME']);
        }
        $data['magazine'	] = $magazine;
        $data['bar_home'	] = "Y";

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
//		$data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
        $data['menu'] = $category_menu['category'];

//		$this->load->view('include/header', $data);
//		$this->load->view('include/menu');
        $this->load->view('main_org', $data);
//		$this->load->view('include/bottom_menu');
//		$this->load->view('include/footer');
    }

    public function search_get()
    {
        $data = array();

        $data['kind'] = 'search';
        $data['footer_gb'] = 'search';


        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        $this->load->view('include/header', $data);
//		$this->load->view('include/menu');
        $this->load->view('goods/search', $data);
//		$this->load->view('include/bottom_menu');
        $this->load->view('include/footer', $data);
    }

    public function menu_get()
    {
        $data = array();

        /* load model */
        $this->load->model('mywiz_m');
        $this->load->model('cart_m');
        $this->load->model('customer_m');

        $data['notice_cnt'			] = count($this->customer_m->get_notice_3days());			//최근 3일 내에 공지사항이 등록
        $data['mycoupon_cnt'		] = $this->mywiz_m->get_coupon_count_by_cust();		//보유쿠폰 갯수 가져오기
        $data['mileage'				] = $this->mywiz_m->get_mileage_by_cust();			//보유 마일리지 가져오기
        $data['cart_cnt'			] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
        $data['interest_cnt'		] = $this->mywiz_m->get_interest_list_count();

        $returnUrl = ($this->agent->is_referral()) ? $this->agent->referrer() : '/';
        if(preg_match('/member\/login/i', $returnUrl)) {
            $returnUrl = '/';
        }

        if(strpos($returnUrl,'join_finish')){
            $returnUrl	= '/';
        }

        if(isset($_GET['return_url'])){
            $returnUrl = $_GET['return_url'];
        }

        $data['returnUrl'] = $returnUrl;

        /**
         * 퀵 레이아웃
         */
        $this->load->library('quick_lib');
        $data['quick'] =  $this->quick_lib->get_quick_layer();

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];

//		$this->load->view('include/header', $data);
        $this->load->view('include/menu', $data);
//		$this->load->view('include/footer');


    }

    /**
     * SNS 공유하기 레이어
     */
    public function layer_share_post()
    {
        $param = $this->input->post();
        $data = array();

        //매거진 공유일때 공유수 증가
        if($param['gubun'] == 'M') {
            $this->main_m->share_increase($param);
        }

        $data['gubun'   ] = $param['gubun'];
        $data['code'    ] = $param['code'];
        $data['img'		] = $param['img'];
        $data['name'	] = $param['name'];
        $data['addInfo' ] = $param['addInfo'];

        $share = $this->load->view('include/share_sns.php', $data, TRUE);		//1:1문의 수정

        $this->response(array('status' => 'ok', 'share'=>$share), 200);;
    }

    /**
     *  모바일 교체 메인
     *  2018.02.02.
     *  모바일 배너 교체 메인
     *  2018.09.11.
     * @auth 박상현
     */
    public function change_main_get(){
        /**
         * 상단 카테고리 데이타
         */
        $data = array();

        $data['top'			] = $this->main_m->get_md_goods('MOB_MAIN_TOP');

        /* HOT Issue keyword */
        $hotkey = $this->main_m->get_md_goods('MOB_HOT_KEYWORD');
        for($i=0; $i<count($hotkey); $i++){
            if($hotkey[$i]['NAME'] != null)
                $keyword[$i] = $hotkey[$i];
        }
        $data['keyword'] = $keyword;

        /* Weekly theme */
        $data['new_item'	] = $this->main_m->get_md_goods('MOB_WEEKLY_THEME');

        /* Brand Focus */
        $data['new_brand'	] = $this->main_m->get_md_goods('MOB_BRAND_FOCUS');

        /* MD 픽! */
        $data['etah_choice'	] = $this->main_m->get_md_goods_choice_c('MAIN_ETAH_CHOICE'); //쿼리

        /* BRAND RECOMMENDATION */
        $data['brand_recommendation'] = $this->main_m->get_md_brand('MOB_MAIN_RCMD');

        /* CLLECTION */
        $data['collection_t'] = $this->main_m->get_md_goods('MAIN_COLLECTION_TITL'); //TITL 오타아님
        $data['collection'	] = $this->main_m->get_md_goods_choice_c('MAIN_COLLECTION'); //쿼리

        // 주력 상품 재배치.
        $param= $data['collection'];
        unset($data['collection'][0]);
        unset($data['collection'][1]);
        $data['collection'][8] = $param[0];
        $data['collection'][9] = $param[1];

        /* MAGAZINE */
        $magazine = $this->main_m->get_md_goods('MAIN_MAGAZINE');

        for($i=0; $i<count($magazine); $i++){
            $magazine[$i]['NAME'] = explode('||',$magazine[$i]['NAME']);
        }
        $data['magazine'	] = $magazine;

        //$data['bar_md'	] = "Y";

        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
        $data['menu'] = $category_menu['category'];

        $this->load->view('include/header', $data);
        $this->load->view('main');
        $this->load->view('include/footer');
    }


    /**
     * 메인화면.
     * @auth 김현아
     */
    public function main_get()
    {
        $data = array();

        /*MAIN_BANNER*/
        $data['top'                 ] = $this->main_m->get_Main_Banner('MOB_MAIN_TOP');
        $data['event'               ] = $this->main_m->get_Main_Banner('MAIN_EVENT');

        /*에타딜*/
        $data['etahDeal'            ] = $this->main_m->get_md_goods_choice_c('MAIN_RCMD');

        /*홈족피디아*/
        $data['homejokAll'          ] = $this->main_m->get_md_goods('MAIN_HOMEJOK');
        $data['homejok1'            ] = $this->main_m->get_magazine('40010000');    //리빙백서
        $data['homejok2'            ] = $this->main_m->get_magazine('40030000');    //감성생활
        $data['homejok3'            ] = $this->main_m->get_magazine('40020000');    //홈족TIP
        $data['homejok4'            ] = $this->main_m->get_magazine('40040000');    //해외직구

        /*Best 후기*/
        $data['bestReview'          ] = $this->main_m->get_md_best_review('MAIN_BEST_REVIEW');

        /*인기 키워드*/
        $keyword = $this->main_m->get_md_goods('MAIN_HOT_KEYWORD');
        unset($keyword[0]);
        $data['hot_keyword'         ] = $keyword;

        /*이번 주의 추천상품*/
        $data['mdPick'              ] = $this->main_m->get_md_goods_choice_c('MAIN_ETAH_CHOICE');   //MD Pick
        $data['newItem'             ] = $this->main_m->get_md_goods_choice_c('MOB_NEW_ITEM');       //신상품

        /*에타 인기 매거진*/
        $data['magazine1'           ] = $this->main_m->get_md_goods('MAIN_MAGAZINE1'); //생활Tip
        $data['magazine2'           ] = $this->main_m->get_md_goods('MAIN_MAGAZINE2'); //인테리어Tip
        $data['magazine3'           ] = $this->main_m->get_md_goods('MAIN_MAGAZINE3'); //Brand

        /*올 어바웃 에타 클래스*/
        $data['classGoods'          ] = $this->main_m->get_md_goods_class('MOB_CLASS_GOODS');
        $data['classA'              ] = $this->main_m->get_md_goods_class('MOB_CLASS_24010100');    //가구
        $data['classB'              ] = $this->main_m->get_md_goods_class('MOB_CLASS_24010200');    //수공예
        $data['classC'              ] = $this->main_m->get_md_goods_class('MOB_CLASS_24010300');    //도예
        $data['classD'              ] = $this->main_m->get_md_goods_class('MOB_CLASS_24010400');    //플라워
        $data['classE'              ] = $this->main_m->get_md_goods_class('MOB_CLASS_24010500');    //캔들/향수/디퓨저
        $data['classF'              ] = $this->main_m->get_md_goods_class('MOB_CLASS_24010600');    //디저트/요리
        $data['classG'              ] = $this->main_m->get_md_goods_class('MOB_CLASS_24010700');    //미술
        $data['classH'              ] = $this->main_m->get_md_goods_class('MOB_CLASS_24010800');    //이벤트

        /*브랜드포커스*/
        $data['brandFocus'          ] = $this->main_m->get_md_brand_focus();

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
        $data['menu'] = $category_menu['category'];

        $this->load->view('include/header', $data);
        $this->load->view('new_main');
        $this->load->view('include/footer');
    }

    /**
     * 메인화면.
     * 홈족피디아 gif 이미지
     * @auth 김현아
     */
    public function main_img_post()
    {
        $homejok_A = $this->main_m->get_md_goods('MAIN_HOMEJOK');
        $homejok_B = $this->main_m->get_magazine('40010000');    //리빙백서
        $homejok_C = $this->main_m->get_magazine('40030000');    //감성생활
        $homejok_D = $this->main_m->get_magazine('40020000');    //홈족TIP
        $homejok_E = $this->main_m->get_magazine('40040000');    //해외직구

        $all_homejok = array_merge($homejok_A, $homejok_B, $homejok_C, $homejok_D, $homejok_E);

        $gif_array = array();
        foreach($all_homejok as $home){
            $idx = (!isset($home['GOODS_CD']))?$home['MAGAZINE_NO']:$home['GOODS_CD'];

            $gif_array[$idx] = $home['MOB_MAGAZINE_IMG_URL'];
        }

        $gif_array = array_filter($gif_array);

        $this->response(array('status' => 'ok', 'data' => $gif_array), 200);
    }


//    public function cache_main_get()
//    {
//        $this->load->library('etah_lib');
//
//        $data = array();
//
//
//        //메인 컨텐츠
//        $main_content = $this->etah_lib->get_main_content();
//
//
//        /*MAIN_BANNER*/
//        $data['top'                 ] = $main_content['top'];
//        $data['event'               ] = $main_content['event'];
//
//        /*에타딜*/
//        $data['etahDeal'            ] = $main_content['etahDeal'];
//
//        /*홈족피디아*/
//        $data['homejok_all'         ] = $main_content['homejok_all'];
//        $data['homejok1'            ] = $main_content['homejok1'];
//        $data['homejok2'            ] = $main_content['homejok2'];
//        $data['homejok3'            ] = $main_content['homejok3'];
//
//        /*Best 후기*/
//        $data['bestReview'          ] = $main_content['bestReview'];
//
//        /*인기 키워드*/
//        $data['hot_keyword'         ] = $main_content['hot_keyword'];
//
//        /*이번 주의 추천상품*/
//        $data['mdPick'              ] = $main_content['mdPick'];
//        $data['newItem'             ] = $main_content['newItem'];
//
//        /*에타 인기 매거진*/
//        $data['magazine1'           ] = $main_content['magazine1'];
//        $data['magazine2'           ] = $main_content['magazine2'];
//        $data['magazine3'           ] = $main_content['magazine3'];
//
//        /*올 어바웃 에타 클래스*/
//        $data['classGoods'          ] = $main_content['classGoods'];
//        $data['classA'              ] = $main_content['classA'];
//        $data['classB'              ] = $main_content['classB'];
//        $data['classC'              ] = $main_content['classC'];
//        $data['classD'              ] = $main_content['classD'];
//        $data['classE'              ] = $main_content['classE'];
//        $data['classF'              ] = $main_content['classF'];
//        $data['classG'              ] = $main_content['classG'];
//        $data['classH'              ] = $main_content['classH'];
//
//        /*브랜드포커스*/
//        $data['brandFocus'          ] = $main_content['brandFocus'];
//
//
//        /**
//         * 상단 카테고리 데이타
//         */
//        $category_menu = $this->etah_lib->get_category_menu();
//        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
//        $data['menu'] = $category_menu['category'];
//
//        $this->load->view('include/header', $data);
//        $this->load->view('new_main');
//        $this->load->view('include/footer');
//    }
}