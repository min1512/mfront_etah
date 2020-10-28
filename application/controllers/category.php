<?php
/**
 * User: Joe, Yong June
 * Date: 2016/04/04	1205
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller
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
        $this->load->model('category_m');
    }

    /*  2018.07.03 카테고리 메인 변경으로 삭제.
    public function index_get()
    {
        self::main_get();
    }*/


    /**
     * 카테고리 메인
     */
    public function main_get()
    {
        //header("Cache-Control: max-age=3200");
        /*
         * 2018.07.03 new 카테고리 메인
         * */
        $data    = array();
        $arrCate = array();

        $param = $this->input->get();
        $cate_cd = $param['cate_cd'];
        $param['page'] = $this->uri->segment(3);


        //카테고리 TOP 배너 변경 2018.10.22
        $gubun1 = "CATE_TOP_".$cate_cd;
        $gubun2 = "CATE_RCMD_".$cate_cd;
        $banner_cd = $this->category_m->get_md_goods($gubun1,$gubun2);

        if($banner_cd['banner_cd'] != null || $banner_cd['banner_cd'] != '') {
            $data ['top_banner'] = $this->category_m->get_Banner($banner_cd['banner_cd']);
        }

        //2017.08.28 이진호
        //에타 초이스 목록 batch로 변경, 에타초이스 select table 변경
        $gubun = "CATE_CHOICE_".$cate_cd;
        $data ['etah_choice'	] = $this->category_m->get_md_goods_choice_batch($gubun);

        $param['cate_cd'        ] = $cate_cd;
        $param['brand_cd'		] = empty($param['brand_cd'	]) ? ''	 : $param['brand_cd'];
        $param['order_by'		] = empty($param['order_by'	]) ? 'A' : $param['order_by'];
        $param['page'			] = empty($param['page'		]) ? 1	 : $param['page'    ];
        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 80  : $param['limit_num_rows'];
        $param['price_limit'	] = empty($param['price_limit'		]) ? ''	 : $param['price_limit'	  ];

        //카테고리 정보
        $category = $this->category_m->get_category_detail($cate_cd);
        $param['category'] = $category;

        if(isset($category['CATE_CODE2']) && $category['CATE_CODE2']){
            if($category['CATE_CODE1']){
                $param['cate_gb'] = 'S';
            } else {
                $param['cate_gb'] = 'M';
            }
        } else {
            $param['cate_gb'] = 'L';
        }

        $data['category'	] = $category;

        //네비게이션
        $row = $this->category_m->get_list_by_category($param);

        for($i=0; $i<count($row); $i++){
            $arr_cate2[$row[$i]['CATEGORY_CD2']]['CD'] = $row[$i]['CATEGORY_CD2'];
            $arr_cate2[$row[$i]['CATEGORY_CD2']]['NM'] = $row[$i]['CATEGORY_NM2'];

            $arr_cate3[$row[$i]['CATEGORY_CD3']]['CD'] = $row[$i]['CATEGORY_CD3'];
            $arr_cate3[$row[$i]['CATEGORY_CD3']]['NM'] = $row[$i]['CATEGORY_NM3'];
            $arr_cate3[$row[$i]['CATEGORY_CD3']]['P_CD'] = $row[$i]['CATEGORY_CD2'];

        }
        $data['arr_cate2'   ] = $arr_cate2;
        $data['arr_cate3'   ] = $arr_cate3;

        //전상품리스트 정보
        $all_goodsList = $this->category_m->get_goods_list($param);

        $arr_brand = array();   //브랜드
        $arr_country = array();  //국가
        $arr_sellingPrice = array();   //가격

        foreach($all_goodsList as $all_goods) {
            //브랜드 리스트
            $arr_brand[$all_goods['BRAND_NM_FST_LETTER']][$all_goods['BRAND_CD']]['NM'] = $all_goods['BRAND_NM'];

            //국가 리스트
            $country_cd = $all_goods['COUNTRY_CD'];
            $arr_country[$country_cd]['NM'] = $all_goods['COUNTRY_NM'];

            //가격
            $price = $all_goods['SELLING_PRICE'];
            if( !in_array($price, $arr_sellingPrice) ) array_push($arr_sellingPrice, $price);
        }

        ksort($arr_brand);

        $data['arr_brand'       ] = $arr_brand;
        $data['arr_country'     ] = $arr_country;
        $data['arr_sellingPrice'] = $arr_sellingPrice;

        //직구SHOP 메인 - 상품리스트 고정
        if($param['cate_cd'] == 20000000)  {
            $param['global_cd'] = "1115591,1120462,1224914,1231797,1312447,1327845,1475144,1499417,1692951,1776573,1793697,1827195,1885549,1896742,1898031,1913971,1915722,1917703,1918440,1919576,1920534,1920551,1920705,1920882,1921877,1923635,1942344,1945636,1954283,1956040,1965091,1966249,1967357";
        }

        //상품개수
        $totalCnt = $this->category_m->get_goods_list_count($param);

        //상품리스트
        $goodsList = $this->category_m->get_goods_list($param);

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'category/main';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '5';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	   ] = $this->pagination->create_links();
        $data['totalCnt'       ] = $param['cate_cd']==20000000 ? count($all_goodsList) : $totalCnt;
        $data['goods'          ] = $goodsList;
        $data['cate_cd'        ] = $param['cate_cd'];
        $data['cate_gb'        ] = $param['cate_gb'];
        $data['brand_cnt'      ] = 0;
        $data['order_by'       ] = $param['order_by'];

        $this->load->model('cart_m');

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $data['header_gb'] = 'none';		//헤더의 검색바만 보이도록 하기
        $data['footer_gb'] = 'category';
        $data['cart_cnt' ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        $this->load->view('include/header', $data);
        $this->load->view('goods/category_main');
        $this->load->view('include/footer', $data);
    }

    /**
     * 카테고리 리스트(구 메인)
     */
    public function category_list_get()
    {
        $param = $this->input->get();

        $cate_cd = $param['cate_cd'];
        $param['page'] = $this->uri->segment(3);

        $param['cate_gb'	    ] = empty($param['cate_gb'		    ]) ? 'S' : $param['cate_gb'	      ];
        $param['cate_cd'        ] = $cate_cd;
        $param['brand_cd'		] = empty($param['brand_cd'	        ]) ? ''	 : $param['brand_cd'      ];
        $param['order_by'		] = empty($param['order_by'	        ]) ? 'A' : $param['order_by'      ];
        $param['page'			] = empty($param['page'		        ]) ? 1	 : $param['page'          ];
        $param['limit_num_rows'	] = empty($param['limit_num_rows'	]) ? 80  : $param['limit_num_rows'];
        $param['deliv_type'	    ] = empty($param['deliv_type'		]) ? ''	 : $param['deliv_type'	  ];
        $param['country'	    ] = empty($param['country'		    ]) ? ''	 : $param['country'	      ];
        $param['price_limit'	] = empty($param['price_limit'		]) ? ''	 : $param['price_limit'	  ];


        $category = $this->category_m->get_category_detail($cate_cd);
        $param['category'] = $category;

        if(isset($category['CATE_CODE2']) && $category['CATE_CODE2']){
            if($category['CATE_CODE1']){
                $param['cate_gb'] = 'S';
            } else {
                $param['cate_gb'] = 'M';
            }
        } else {
            $param['cate_gb'] = 'L';
        }


        //네비게이션
        $row = $this->category_m->get_list_by_category($param);

        for($i=0; $i<count($row); $i++){
            $arr_cate2[$row[$i]['CATEGORY_CD2']]['CD'] = $row[$i]['CATEGORY_CD2'];
            $arr_cate2[$row[$i]['CATEGORY_CD2']]['NM'] = $row[$i]['CATEGORY_NM2'];
            $arr_cate2[$row[$i]['CATEGORY_CD2']]['P_CD'] = $row[$i]['CATEGORY_CD1'];

            $arr_cate3[$row[$i]['CATEGORY_CD3']]['CD'] = $row[$i]['CATEGORY_CD3'];
            $arr_cate3[$row[$i]['CATEGORY_CD3']]['NM'] = $row[$i]['CATEGORY_NM3'];
            $arr_cate3[$row[$i]['CATEGORY_CD3']]['P_CD'] = $row[$i]['CATEGORY_CD2'];

        }
        $data['arr_cate2'   ] = $arr_cate2;
        $data['arr_cate3'   ] = $arr_cate3;
        $data['category'	] = $category;

        //상품개수
        $totalCnt = $this->category_m->get_goods_list_count($param);

        //상품리스트
        $goodsList = $this->category_m->get_goods_list($param);


        //전상품리스트 정보
        $iParam['cate_gb'] = $param['cate_gb'];
        $iParam['cate_cd'] = $param['cate_cd'];
        $all_goodsList = $this->category_m->get_goods_list($iParam);

        $arr_brand = array();   //브랜드
        $arr_country = array();  //국가
        $arr_sellingPrice = array();   //가격

        foreach($all_goodsList as $all_goods) {
            //브랜드 리스트
            $arr_brand[$all_goods['BRAND_NM_FST_LETTER']][$all_goods['BRAND_CD']]['NM'] = $all_goods['BRAND_NM'];

            //국가 리스트
            $country_cd = $all_goods['COUNTRY_CD'];
            $arr_country[$country_cd]['NM'] = $all_goods['COUNTRY_NM'];

            //가격
            $price = $all_goods['SELLING_PRICE'];
            if( !in_array($price, $arr_sellingPrice) ) array_push($arr_sellingPrice, $price);
        }

        ksort($arr_brand);

        $data['arr_brand'       ] = $arr_brand;
        $data['arr_country'     ] = $arr_country;
        $data['arr_sellingPrice'] = $arr_sellingPrice;


        //설정된 브랜드 코드 초성 추출
        $arr_letter = explode("|", substr($param['brand_cd'],1));

        $this->load->model('goods_m');

        $brand_letter = array();
        foreach($arr_letter as $arr){
            $brand_info = $this->goods_m->get_brandInfo($arr);

            if(!in_array($brand_info['BRAND_NM_FST_LETTER'], $brand_letter)){
                $brand_letter[] = $brand_info['BRAND_NM_FST_LETTER'];
            }
        }

        //페이지네비게이션
        $this->load->library('pagination');
        $config['base_url'		] = base_url().'category/category_list';
        $config['uri_segment'	] = '3';
        $config['total_rows'	] = $totalCnt;
        $config['per_page'		] = $param['limit_num_rows'];
        $config['num_links'		] = '5';
        $config['suffix'		] = '?'.http_build_query($param, '&');
        $this->pagination->initialize($config);

        $data['pagination'	] = $this->pagination->create_links();
        $data['totalCnt'    ] = $totalCnt;
        $data['goods'       ] = $goodsList;
        $data['cate_cd'     ] = $param['cate_cd'        ];
        $data['cate_gb'     ] = $param['cate_gb'        ];
        $data['brand_cd'    ] = $param['brand_cd'       ];
        $data['brand_letter'] = $brand_letter;
        $data['order_by'    ] = $param['order_by'       ];
        $data['deliv_type'  ] = $param['deliv_type'     ];
        $data['country'     ] = $param['country'        ];
        $data['price_limit' ] = $param['price_limit'    ];

        $this->load->model('cart_m');

        /**
         * 상단 카테고리 데이타
         */
        $this->load->library('etah_lib');
        $category_menu = $this->etah_lib->get_category_menu();
        $data['menu'        ] = $category_menu['category'];
        $data['header_gb'   ] = 'none';		//헤더의 검색바만 보이도록 하기
        $data['footer_gb'   ] = 'category';
        $data['cart_cnt'    ] = count($this->cart_m->get_cart_goods($this->session->userdata('EMS_U_NO_')));	//장바구니 갯수 가져오기

        $this->load->view('include/header', $data);
        $this->load->view('goods/category_list');
        $this->load->view('include/footer', $data);
    }


}