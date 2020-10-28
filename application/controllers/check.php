<?php

class Check extends MY_Controller
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
        $this->load->model('main_m');
        $this->load->model('cart_m');
        $this->load->model('order_m');


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

    public function b_review_get()
    {
        $data = array();
        $param['BANNER_NO']	= $this->input->get('banner_cd');

        $result = $this->main_m->get_Banner_review($param['BANNER_NO']);
//        print_r($result);
        $data['banner_cd'   ] = $param ['BANNER_NO'                     ];
        $data['banCate'     ] = $result['KIND_GB_CD'                    ];
        $data['banTitle'    ] = $result['BANNER_NM'                     ];
        $data['banner_text1'] = $result['BANNER_MAIN_TITLE'             ];
        $data['banner_text2'] = $result['BANNER_SUB_TITLE'              ];
        $data['banner_text3'] = $result['BANNER_SUB_TITLE_2'            ];
        $data['font_Gb1'    ] = $result['BANNER_FONT_CLASS_GB_CD1'		];
        $data['font_Gb2'    ] = $result['BANNER_FONT_CLASS_GB_CD2'		];
        $data['font_Gb3'    ] = $result['BANNER_FONT_CLASS_GB_CD3'		];
        $data['font_color1' ] = $result['BANNER_FONTCOLOR_CLASS_GB_CD1'	];
        $data['font_color2' ] = $result['BANNER_FONTCOLOR_CLASS_GB_CD2'	];
        $data['font_color3' ] = $result['BANNER_FONTCOLOR_CLASS_GB_CD3'	];
        $data['font_weight1'    ] = $result['BANNER_FONTWEIGHT_CLASS_GB_CD1'		];
        $data['font_weight2'    ] = $result['BANNER_FONTWEIGHT_CLASS_GB_CD2'		];
        $data['font_weight3'    ] = $result['BANNER_FONTWEIGHT_CLASS_GB_CD3'		];
        $data['font_size1' ] = $result['BANNER_FONT_SIZE1'	];
        $data['font_size2' ] = $result['BANNER_FONT_SIZE2'	];
        $data['font_size3' ] = $result['BANNER_FONT_SIZE3'	];
        $data['banLinkUrl'  ] = $result['BANNER_LINK_URL'	            ];
        $data['banImgUrl'   ] = $result['BANNER_IMG_URL'	            ];

        //텍스트 위치
        if($result['BANNER_LOCATION'] == 'L'){
            $data['text_locaion'] = '01';       //좌측
        }else if($result['BANNER_LOCATION'] == 'M'){
            $data['text_locaion'] = '02';       //중앙
        }else{
            $data['text_locaion'] = '03';       //우측
        }



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

    public function phpinfo_get(){
        echo phpinfo();
    }

    public function chktest_get(){
        $tax_goods_cd = '';
        $qty = 0;
        $order_info = $this->order_m->get_temp_order_kakao(9968);

        $goods_count = count(json_decode($order_info['GOODS_CODE']));
        $goods_nm    = json_decode($order_info['GOODS_NAME'],true);
        $goods_gb    = json_decode($order_info['GOODS_CODE']);
        $goods_qty   = json_decode($order_info['GOODS_CNT' ]);
        log_message('DEBUG','============'.$goods_gb);
        for($i = 0; $i < count($goods_qty); $i++){
            $qty += (int)$goods_qty[$i]['GOODS_CNT'];
        }
        if($goods_count > 1){
            $cnt = $goods_count - 1;
            $Cmsg =  ' 외 '.$cnt.'건';
        }


        $total_amount = ($order_info['TOTAL_ORDER_MONEY'] + $order_info['TOTAL_DELIVERY_MONEY']) - ($order_info['TOTAL_DISCOUNT_MONEY'] + $order_info['USE_MILEAGE']);

        // 과세, 비과세, 부가세 금액 계산.
        // 과세액 = round(총결제금액 / 1.1)
        // 비과세 = 총결제금액 – 과세금액 – 부가가 치세
        // 부가가치세 = (총결제금액 – 과세금액) 상품총액의 10%

        for($i = 0; $i < count($goods_gb); $i++){
            $tax_goods_cd .= ",".$goods_gb[$i];
        }
        $tax_goods_cd = substr($tax_goods_cd, 1);

        echo $qty;
        var_dump($goods_gb);
    }
}
?>