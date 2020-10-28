<?php

class Magazine extends MY_Controller
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
        $this->load->model('magazine_m');
        $this->load->model('cart_m');
        $this->load->model('main_m'); //브랜드 인사이드용.
    }

    public function index_get()
    {
        $data = array();
        self::main_get($data);

    }

    /**
     * 매거진 메인화면
     */
    public function main_get()
    {
        $param = $this->input->get();

        //매거진 카테고리 정보
        $category = $this->magazine_m->get_category_list('T', '');


        //매거진 리스트
        $param['limit_num_rows'] = 4;
        $param['page'] = 1;
        $param['cate_gb'] = 'M';
        $param['order_by'] = $param['order_by']?$param['order_by']:'A';

        $param['cate_cd'] = 40000000;
        $homejok = $this->magazine_m->get_list($param); //홈족피디아

        $param['cate_cd'] = 50000000;
        $trend = $this->magazine_m->get_list($param);   //트렌드매거진

        $param['cate_cd'] = 70000000;
        $class = $this->magazine_m->get_list($param);   //에타클래스

        $param['cate_cd'] = 60000000;
        $brand = $this->magazine_m->get_list($param);   //브랜드소개

        $param['cate_cd'] = 90000000;
        $event = $this->magazine_m->get_list($param);   //이벤트


        $data['category'    ] = $category;
        $data['homejok'     ] = $homejok;
        $data['trend'       ] = $trend;
        $data['class'       ] = $class;
        $data['brand'       ] = $brand;
        $data['event'       ] = $event;
        $data['order_by'    ] = $param['order_by'];


        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
        $data['add_wrap'] = 'magazine';
        $data['bar_magazine'] = 'magazine';


        $this->load->view('include/header', $data);
        $this->load->view('magazine/magazine_main');
        $this->load->view('include/footer');
    }

    /**
     * 매거진 리스트
     */
    public function list_get()
    {
        $param = $this->input->get();

        $param['page'] = $this->uri->segment(3);

        //매거진 카테고리 정보
        $cur_category   = $this->magazine_m->get_category_list('C', $param['cate_cd']);    //현재 위치한 카테고리정보
        $category       = $this->magazine_m->get_category_list($param['cate_gb'], $param['cate_cd']);  //카테고리 리스트


        //매거진 리스트
        $param['limit_num_rows'] = 10;
        $param['page'] = $param['page']?$param['page']:1;
        $param['cate_gb'] = $param['cate_gb']?$param['cate_gb']:'M';
        $param['order_by'] = $param['order_by']?$param['order_by']:'A';
        $param['cate_cd'] = $param['cate_cd']?$param['cate_cd']:'50000000';

        $totalCnt = $this->magazine_m->get_list_count($param);
        $list = $this->magazine_m->get_list($param);


        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'magazine/list/';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '5';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	    ] = $this->pagination->create_links();

        $data['category'] = $category;
        $data['current_category'] = $cur_category;
        $data['cate_gb'] = $param['cate_gb'];
        $data['order_by'    ] = $param['order_by'   ];
        $data['totalCnt'] = $totalCnt;
        $data['list'] = $list;


        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
        $data['add_wrap'] = 'magazine';
        $data['bar_magazine'] = 'magazine';

        $this->load->view('include/header', $data);
        $this->load->view('magazine/magazine_list');
        $this->load->view('include/footer');
    }

    /**
     * 매거진 컨텐트
     */
    public function detail_get()
    {
        $data = array();

        $magazine_no = $this->uri->segment(3);
        $cust_no = $this->session->userdata('EMS_U_NO_');

        $data['magazine_contents'   ] = $this->magazine_m->get_magazine_contents($magazine_no);
        $data['detail'              ] = $this->magazine_m->get_detail($magazine_no);

        //좋아요 확인
        $love_check = $this->magazine_m->get_magazine_love_list($magazine_no, $cust_no);
        if($love_check != 0) $data['heart'] = 'Y';

        //카테고리 코드(구분)
        $cateGubun = substr($data['detail']['CATEGORY_CD'],0,1);
        $data['cateGubun'       ] = $cateGubun;

        $param['magazine_no'    ] = $magazine_no;
        $param['brand_cd'       ] = $data['detail']['BRAND_CD'];

        //매거진 상품
        if($cateGubun == 4 || $cateGubun == 5 || $cateGubun == 6) {
            $data['magazineGoods'   ] = $this->magazine_m->get_goods('M', $param); // 매거진에 나온 상품
        } else if($cateGubun == 7) {
            $data['magazineGoods'   ] = $this->magazine_m->get_goods('G', $param); //공방 상품
        }

        //관련상품 추천
        if(count($data['magazineGoods'])!=0){
            for($i=0;$i<count($data['magazineGoods']);$i++) {
                $param['goods'      ][] = $data['magazineGoods'][$i]['GOODS_CD'];
                $param['category'   ][] = $data['magazineGoods'][$i]['CATEGORY_CD'];
                $param['brand'      ][] = "'".$data['magazineGoods'][$i]['BRAND_CD']."'";
            }
            $param['category'   ] = array_unique($param['category']);
            $param['brand'      ] = array_unique($param['brand']);
            $param['goods'      ] = array_unique($param['goods']);

            $param['category'   ] = implode(', ', $param['category']);
            $param['brand'      ] = implode(', ', $param['brand']);
            $param['goods'      ] = implode(', ', $param['goods']);

            $data['plusGoods'] = $this->magazine_m->get_goods('R', $param);
        }

        //다른 매거진 더보기
        if($cateGubun == 7) {
            $data['otherMagazine'] = $this->magazine_m->get_other_magazine('class', $magazine_no);
        } else {
            $data['otherMagazine'] = $this->magazine_m->get_other_magazine($data['detail']['CATEGORY_CD'], $magazine_no);
        }

        //댓글
        $paging_limit	= 5;
        $magazine_comment_num = $data['detail']['COMMENT_CNT'];	//매거진 댓글 전체 갯수 불러오기
        $data['comment'     ] = $this->magazine_m->get_magazine_comment_list($magazine_no, 1, $paging_limit);	//댓글 불러오기

        //댓글 - 페이징 구성
        $data['page'		] = 1;  //현재페이지
        $data['total_page'	] = ceil($magazine_comment_num / $paging_limit);	//전체 페이지 갯수
        $data['limit_num'	] = $paging_limit;  //한 페이지에 보여주는 갯수


        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
        $data['add_wrap'] = 'magazine';
        $data['bar_magazine'] = 'magazine';
        $data['TITLE'] = $data['detail']['TITLE'];

        $this->load->view('include/header', $data);
        $this->load->view('magazine/magazine_detail');
        $this->load->view('include/footer');
    }

    /**
     *  매거진 댓글 페이징
     */
    public function comment_paging_post()
    {
        $param = $this->input->post();
        $magazine_comment = $this->magazine_m->get_magazine_comment_list($param['magazine_no'], $param['page'], $param['limit']);

        if($magazine_comment) {
            $this->response(array('status' => 'ok', 'comment' => $magazine_comment), 200);
        } else {
            $this->response(array('status' => 'error'), 200);
        }
    }

    /**
     * 매거진 댓글 등록
     */
    public function comment_regist_post()
    {
        $param                      = $this->input->post();
        $param['mem_no']		    = $this->session->userdata('EMS_U_NO_');

        $param = str_replace("\\","\\\\",$param);
        $param = str_replace("'","\'",$param);
        $param = str_replace("\n","<br />",$param);

        //첨부파일 확인
        if($_FILES['fileUpload']['name']){
            $this->load->helper(array('form', 'url'));

            $image_path = '/webservice_root/etah_mfront/assets/uploads';

            if ( ! @is_dir($image_path)){
                $this->response(array('status' => 'error upload fail_comment_NO Directory'));
            }

            $config['upload_path'	] = $image_path;
            $config['allowed_types'	] = 'gif|jpg|jpeg';
            $config['encrypt_name'	] = preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $_FILES['fileUpload']['name']);

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload('fileUpload')){ //업로드 에러시
                $error = array('error' => $this->upload->display_errors());
                $this->response(array('status' => 'fail', 'message'=>'파일 업로드에 실패하였습니다.'), 200);
            }else{
                $data = $this->upload->data();
                //s3 파일전송
                $param['file_url'] = self::_s3_upload($data);

                if(!$param['file_url']) {
                    $this->response(array('status' => 'fail', 'message'=>'파일 업로드에 실패하였습니다.'), 200);
                }
            }
        }

        if( $this->magazine_m->regist_comment($param) ) {
            $this->response(array('status' => 'ok', 'message'=>'댓글 등록 성공!'), 200);
        } else {
            $this->response(array('status' => 'fail', 'message'=>'잠시 후 다시 시도해주세요.'), 200);
        }
    }

    /**
     * 매거진 댓글 수정 레이어
     */
    public function comment_update_layer_post()
    {
        $param = $this->input->post();
        $data = array();

        $data['comment_no'	] = $param['comment_no'];
        $data['comment'		] = $this->magazine_m->get_magazine_comment($param['comment_no']);	//상품평

        if($data['comment']) {
            $modify_comment = $this->load->view('mywiz/modify_magazine_comment.php', $data, TRUE);		//상품평 수정

            $this->response(array('status' => 'ok', 'modify_comment'=>$modify_comment), 200);
        } else {
            $this->response(array('status' => 'fail', 'message'=>'수정할 수 없는 댓글 입니다.'), 200);
        }

    }


    /**
     * 매거진 댓글 수정
     */
    public function comment_update_post() {
        $param                      = $this->input->post();
        $param['mem_no']		    = $this->session->userdata('EMS_U_NO_');

        $param['comment_txt'] = str_replace("\\","\\\\",$param['comment_txt']);
        $param['comment_txt'] = str_replace("'","\'",$param['comment_txt']);
        $param['comment_txt'] = str_replace("\n","<br />",$param['comment_txt']);

        //매거진 상세페이지 댓글 수정
        if($param['gubun'] == 'A')  $param['file_url'] = '';

        //매거진 이벤트 상세페이지 댓글 수정
        else if($param['gubun'] == 'B') {
            $param['file_url'] = $param['file_url2'];

            //첨부파일 확인
            if($_FILES['fileUpload2']['name']){

                $this->load->helper(array('form', 'url'));

                $image_path = '/webservice_root/etah_mfront/assets/uploads';

                if ( ! @is_dir($image_path)){
                    $this->response(array('status' => 'error upload fail_comment_NO Directory'));
                }

                $config['upload_path'	] = $image_path;
                $config['allowed_types'	] = 'gif|jpg|jpeg';
                $config['encrypt_name'	] = preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $_FILES['fileUpload2']['name']);

                $this->load->library('upload', $config);

                if ( !$this->upload->do_upload('fileUpload2')){ //업로드 에러시
                    $error = array('error' => $this->upload->display_errors());
                    $this->response(array('status' => 'fail', 'message'=>'파일 업로드에 실패하였습니다.'), 200);
                }else{
                    $data = $this->upload->data();
                    //s3 파일전송
                    $param['file_url'] = self::_s3_upload($data);

                    if(!$param['file_url']) {
                        $this->response(array('status' => 'fail', 'message'=>'파일 업로드에 실패하였습니다.'), 200);
                    }
                }
            }
        }

        if( $this->magazine_m->update_comment($param) ) {
            $this->response(array('status' => 'ok', 'message'=>'댓글 등록 성공!'), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => '수정 실패하였습니다. 잠시 후 다시 시도해주세요.'), 200);
        }
    }

    /**
     * s3 파일전송
     */
    public function _s3_upload($param)
    {
        $cust_no = $this->session->userdata('EMS_U_NO_');
        $date = date("YmdHis", time());

        $title = $cust_no.$date;

        //Load Library
        $this->load->library('s3');

        $input = S3::inputFile('/webservice_root/etah_mfront/assets/uploads/'.$param['file_name']);
        if (S3::putObject($input, 'image.etah.co.kr', 'magazine_comment/'.$cust_no.'/'.$title.$param['file_ext'], S3::ACL_PUBLIC_READ)) {
//			echo "File uploaded.";

            $title = 'http://image.etah.co.kr/magazine_comment/'.$cust_no.'/'.$title.$param['file_ext'];

            return $title;
        } else {
            return false;
        }
    }

    /**
     * 매거진 댓글 삭제
     */
    public function comment_delete_post() {
        $param = $this->input->post();

        if($this->magazine_m->delete_comment($param)) {
            $this->response(array('status' => 'ok'), 200);
        } else {
            $this->response(array('status' => 'error'), 200);
        }

    }

    /**
     * 매거진 좋아요
     */
    public function magazine_love_post(){
        $param = $this->input->post();

        $magazine_no	= $param['magazine_no'];
        $member_no      = $this->session->userdata('EMS_U_NO_');

        $love_check = $this->magazine_m->get_magazine_love_list($magazine_no, $member_no);  //좋아요 여부 확인

        //좋아요
        if($love_check == 0) {
            $result = $this->magazine_m->magazine_love($magazine_no, $member_no, 'Y');
            if($result) {
                $this->response(array('status' => 'ok','message' => 'LOVE'), 200);
            } else {
                $this->response(array('status' => 'error'), 200);
            }
        }
        //좋아요 취소
        else {
            $result = $this->magazine_m->magazine_love($magazine_no, $member_no, 'N');
            if($result) {
                $this->response(array('status' => 'ok','message' => 'NO'), 200);
            } else {
                $this->response(array('status' => 'error'), 200);
            }
        }

    }


    /**
     * 2018.02.12
     * 브랜드 인사이드 추가
     */
    public function brand_inside_get($page = 1)
    {
        $data = array();

        $data['brand_inside'	] = $this->main_m->get_md_goods('MAIN_BRAND_INSIDE');

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'] = $category_menu['category'];
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기
        $data['add_wrap'] = 'magazine';
        $data['bar_magazine'] = "Y";
        /**
         * 퀵 레이아웃
         */
//		$this->load->library('quick_lib');
//		$data['quick'] =  $this->quick_lib->get_quick_layer();

        $this->load->view('include/header', $data);
        $this->load->view('magazine/brand_inside');
        $this->load->view('include/footer');
    }


}
?>