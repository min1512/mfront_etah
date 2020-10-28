<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_m extends CI_Model {

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
     * insert table
     *
     * @return mixed
     */
    public function insert_table( $table_name, $param )
    {
        $db = self::_master_db();
        $query_insert = $db->insert_string( $table_name, $param );

        try{
            $db->query( $query_insert );
        }catch( Exception $E ){

            return false;
        }

        return $db->insert_id();
    }

    /**
     * update string
     *
     */
    public function update_data( $table, $data , $where )
    {
        $db = self::_master_db();
        $db->cache_on();

        $query = $db->update_string( $table, $data , $where );

        $result = $db->query( $query );
        $db->cache_off();

        return $result;
    }

    /**
     * 주문 상품 배송 메일
     */
    public function get_order_delivery_mail($order_refer_no)
    {
        $query = "
			select    /*  > etah_mfront > order_m > get_order_delivery_mail > 주문 상품 배송 메일 */
				  r.ORDER_NO
				, r.ORDER_REFER_NO
				, r.GOODS_CD
				, r.GOODS_NM
				, r.GOODS_OPTION_CD
				, r.GOODS_OPTION_NM
				, b.BRAND_CD
				, b.BRAND_NM
				, r.DELIV_DT
				, r.DELIV_COMPANY_CD
				, cd.CD_NM	as DELIV_COMPANY_NM
				, r.INVOICE_NO
				, d.RECEIVER_NM
				, concat(d.RECEIVER_ADDR1, '****')	as RECEIVER_ADDR
				, d.SENDER_NM
				, d.SENDER_EMAIL
				, o.ORD_DT

			from DAT_ORDER_REFER			r

			inner join
				DAT_ORDER				o
			on o.ORDER_NO				= r.ORDER_NO

			inner join
				DAT_GOODS				g
			on g.GOODS_CD				= r.GOODS_CD

			inner join
				DAT_BRAND				b
			on b.BRAND_CD				= g.BRAND_CD

			inner join
				COD_DELIV_COMPANY			cd
			on cd.DELIV_COMPANY_CD	= r.DELIV_COMPANY_CD

			inner join
				DAT_ORDER_DELIV			d
			on d.ORDER_NO			= r.ORDER_NO

			where
				1 = 1
			and r.ORDER_REFER_NO	= '".$order_refer_no."'
		";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }


    /**
     * 아임포트 결제번호로 결제번호/주문번호/주문상세번호 가져오기
     */
    public function get_pay_N_order_info($imp_uid)
    {
        $query = "
			select    /*  > etah_mfront > order_m > get_pay_N_order_info > 아임포트 결제번호로 결제번호/주문번호/주문상세번호 가져오기 */
				  o.ORDER_NO
				, r.ORDER_REFER_NO
				, pay.PAY_NO
				, pay_dtl.ORDER_PAY_DTL_NO
				, rp.ORDER_REFER_PROC_STS_CD
			from
				DAT_ORDER_PAY_DTL		pay_dtl

			inner join
				DAT_ORDER_PAY			pay
			on pay.PAY_NO		= pay_dtl.PAY_NO

			inner join
				DAT_ORDER			o
			on o.ORDER_NO		= pay.ORDER_NO

			inner join
				DAT_ORDER_REFER		r
			on r.ORDER_NO		= o.ORDER_NO

			inner join
				DAT_ORDER_REFER_PROGRESS		rp
			on rp.ORDER_REFER_PROC_STS_NO		= r.ORDER_REFER_PROC_STS_NO

			where
				1 = 1
			and pay_dtl.IMP_UID = '".$imp_uid."'
		";
//var_dump($query);
        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 주문 시 옵션 재고수량 차감
     */
    public function upd_option_cnt($param)
    {
        $query = "
			update	DAT_GOODS_OPTION     /*  > etah_mfront > order_m > upd_option_cnt > 옵션 재고수량 차감 */
			set		QTY = QTY-".$param['goods_cnt']."
			where
				1 = 1
			and GOODS_OPTION_CD		= '".$param['goods_option_code']."'
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 주문 마스터 생성
     */
    public function set_order($param, $date)
    {
        //원더쇼핑 유입 여부 체크
        $column = "";
        $value = "";

        if(isset($_COOKIE['funnel'])) {
            if($_COOKIE['funnel'] == 'wonder') {
                $column = ", LINK_CD";
                $value = ", '4'";
            }
        }

        if($param['buyerid'] != 'GUEST'){	//회원주문일경우
            $query = "
				insert into	DAT_ORDER	(   /*  > etah_mfront > order_m > set_order > 주문 마스터 생성 */
					  CUST_NO
					, ORD_DT
					, NONMEMBER_ORDER_YN
					$column
				)
				values
				(
					  '".$param['buyercode']."'
					, '".$date."'
					, 'N'
					$value
				)
			";
        } else {
            $query = "
				insert into	DAT_ORDER	(   /*  > etah_mfront > order_m > set_order > 주문 마스터 생성 */
					  ORD_DT
					, NONMEMBER_ORDER_YN
					$column
				)
				values
				(
					  '".$date."'
					, 'Y'
					$value
				)
			";
        }
//var_dump($query);
        $db = self::_master_db();
        $result = $db->query($query);
        $rs_identity = $db->insert_id();

        return $rs_identity;
    }

    /**
     * 주문 배송비 생성
     */
    public function set_order_deli_fee($order_no, $param)
    {
        $query = "
			insert into	DAT_ORDER_DELIV_FEE	(   /*  > etah_mfront > order_m > set_order_deli_fee > 주문 배송비 생성 */
				  ORDER_NO
				, DELIV_POLICY_NO
				, DELIV_COST
			)
			values
			(
				  '".$order_no."'
				, '".$param['deli_policy_no']."'
				, '".$param['deli_cost']."'
			)
		";

        $db = self::_master_db();
        $result = $db->query($query);
        $rs_identity = $db->insert_id();

        return $rs_identity;
    }

    /**
     * 주문 상세 생성
     */
    public function set_order_refer($order_no, $order_deliv_fee_no, $param)
    {
        $param = str_replace("'","＇",$param);

        $query = "
			insert into	DAT_ORDER_REFER	(   /*  > etah_mfront > order_m > set_order_refer > 주문 상세 생성 */
				  ORDER_NO
				, ORDER_DELIV_FEE_NO
				, GOODS_CD
				, GOODS_NM
				, GOODS_OPTION_CD
				, GOODS_OPTION_NM
				, ORD_QTY
				, GOODS_PRICE_CD
				, STREET_PRICE
				, SELLING_PRICE
				, SELLING_ADD_PRICE
				, FACTORY_PRICE
				, TOTAL_PRICE
				, GOODS_MILEAGE_SAVING_AMT
			)
			values
			(
				  '".$order_no."'
				, '".$order_deliv_fee_no."'
				, '".$param['goods_code']."'
				, '".$param['goods_name']."'
				, '".$param['goods_option_code']."'
				, '".$param['goods_option_name']."'
				, '".$param['goods_cnt']."'
				, '".$param['goods_price']."'
				, '".$param['goods_street_price']."'
				, '".$param['goods_selling_price']."'
				, '".$param['goods_option_add_price']."'
				, '".$param['goods_factory_price']."'
				, '".$param['total_price']."'
				, '".$param['goods_mileage_saving_amt']."'

			)
		";

        $db = self::_master_db();
        $result = $db->query($query);
        $rs_identity = $db->insert_id();

        return $rs_identity;
    }

    /**
     * 주문 상태 생성
     */
    public function set_order_refer_progress($order_refer_no, $state_cd)
    {
        $query = "
			insert into	DAT_ORDER_REFER_PROGRESS	(   /*  > etah_mfront > order_m > set_order_refer_progress > 주문 상태 생성 */
				  ORDER_REFER_NO
				, ORDER_REFER_PROC_STS_CD
			)
			values
			(
				  '".$order_refer_no."'
				, '".$state_cd."'
			)
		";

        $db = self::_master_db();
        $result = $db->query($query);
        $rs_identity = $db->insert_id();

        return $rs_identity;
    }

    /**
     * 주문 상태 업데이트
     */
    public function upd_order_refer_state($order_refer_no, $order_state_no)
    {
        $query = "
			update	DAT_ORDER_REFER   /*  > etah_mfront > order_m > upd_order_refer_state > 주문 상태 업데이트 */
			set		ORDER_REFER_PROC_STS_NO	= '".$order_state_no."'
			where	ORDER_REFER_NO			= '".$order_refer_no."'
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 주문 배송지 생성
     */
    public function set_order_delivery($order_no, $param)
    {
        $param = str_replace("'","＇",$param);

        $query = "
			insert into	DAT_ORDER_DELIV	(   /*  > etah_mfront > order_m > set_order_delivery > 주문 배송지 생성 */
				  ORDER_NO
				, SENDER_NM
				, SENDER_PHONE_NO
				, SENDER_MOB_NO
				, SENDER_EMAIL
				, SENDER_ZIPCODE
				, SENDER_ADDR1
				, SENDER_ADDR2
				, RECEIVER_NM
				, RECEIVER_PHONE_NO
				, RECEIVER_MOB_NO
				, RECEIVER_ZIPCODE
				, RECEIVER_ADDR1
				, RECEIVER_ADDR2
				, LIVING_FLOOR_CD
				, STEP_WIDTH_CD
				, ELEVATOR_CD
				, INSTALL_SPACE_YN
				, LADDER_TRUCK_NEED_YN
				, LADDER_TRUCK_CUST_PAY_YN
				, DELIV_MSG	";
        if(isset($param['orderCustomsNum'])){
            $query .= "
				, CUST_ID_NO	";
        }
        $query .= "
			)
			values
			(
				  '".$order_no."'
				, '".$param['order_name']."'
				, ''
				, '".$param['buyermobno']."'
				, '".$param['buyeremail']."'
				, '".$param['buyerzipcode']."'
				, '".$param['buyeraddr1']."'
				, '".$param['buyeraddr2']."'
				, '".$param['order_recipient']."'
				, '".$param['order_phone']."'
				, '".$param['order_mobile']."'
				, '".$param['order_postnum']."'
				, '".$param['order_addr1']."'
				, '".$param['order_addr2']."'
				, '".$param['shipping_floor']."'
				, '".$param['shipping_step_width']."'
				, '".$param['shipping_elevator']."'
				, 'Y'
				, 'Y'
				, 'Y'
				, '".$param['order_request']."'	";
        if(isset($param['orderCustomsNum'])){
            $query .= "
				, '".$param['orderCustomsNum']."'	";
        }
        $query .= "
			)
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 결제 마스타 생성
     */
    public function set_order_pay($order_no, $param, $date)
    {
        $real_pay_amt = $param['total_order_money']+$param['total_delivery_money']-$param['total_discount_money']-$param['use_mileage'];

        $total_pay_sum = $param['total_order_money']+$param['total_delivery_money']-$param['total_discount_money'];
        $query = "
			insert into	DAT_ORDER_PAY	(   /*  > etah_mfront > order_m > set_order_pay > 결제 마스타 생성 */
				  ORDER_NO
				, ORDER_PAY_STS_CD
				, ORDER_AMT
				, DELIV_COST_AMT
				, DC_AMT
				, MILEAGE_AMT
				, REAL_PAY_AMT
				, TOTAL_PAY_SUM
				, ORDER_PAY_REQ_DT
				, DEVICE_TYPE
			)
			values
			(
				  '".$order_no."'
				, '01'
				, '".$param['total_order_money']."'
				, '".$param['total_delivery_money']."'
				, '".$param['total_discount_money']."'
				, '".$param['use_mileage']."'
				, '".$real_pay_amt."'
				, '".$total_pay_sum."'
				, '".$date."'
				, 'M'
			)
		";

        $db = self::_master_db();
        $result = $db->query($query);
        $rs_identity = $db->insert_id();

        return $rs_identity;
    }

    /**
     * 결제 상세 생성
     */
    public function set_order_pay_dtl($pay_no, $param, $date)
    {
        $pay_amt = $param['total_order_money']+$param['total_delivery_money']-$param['total_discount_money']-$param['use_mileage'];

        $query = "
			insert into	DAT_ORDER_PAY_DTL	(   /*  > etah_mfront > order_m > set_order_pay_dtl > 결제 상세 생성 */
				  PAY_NO							
				, ORDER_PAY_DTL_STS_CD
				, ORDER_PAY_KIND_CD
				, PAY_AMT
			)
			values
			(
				  '".$pay_no."'
				, '01'
				, '".$param['order_payment_type']."'
				, '".$pay_amt."'
			)
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 결제 상세 생성 (마일리지 결제)
     */
    public function set_order_pay_dtl_mileage($pay_no, $param, $date)
    {
        $query = "
			insert into	DAT_ORDER_PAY_DTL	(   /*  > etah_mfront > order_m > set_order_pay_dtl_mileage > 결제 상세 생성 (마일리지 결제) */
				  PAY_NO							
				, ORDER_PAY_DTL_STS_CD
				, ORDER_PAY_KIND_CD
				, PAY_AMT
			)
			values
			(
				  '".$pay_no."'
				, '01'
				, '04'
				, '".$param['use_mileage']."'
			)
		";

        $db = self::_master_db();
        $result = $db->query($query);
        $rs_identity = $db->insert_id();

        return $rs_identity;
    }

    /**
     * 카드로 결제시 결제 상세 업데이트
     */
    public function upd_order_pay_dtl_card($pay_no, $param)
    {
        $query = "
			update	DAT_ORDER_PAY_DTL    /*  > etah_mfront > order_m > upd_order_pay_dtl_card > 카드로 결제시 결제 상세 업데이트 */
			set		  ORDER_PAY_DTL_STS_CD	= '02'			-- 결제상태 :: 결제완료
					, IMP_UID				= '".$param['imp_uid']."'
					, RECEIPT_URL			= '".$param['receipt_url']."'
					, CARD_COMPANY_NM		= '".$param['card_name']."'
					, CARD_MONTH			= '".$param['card_quota']."'
					, PG_ORDER_NO			= '".$param['pg_tid']."'
			where
				1 = 1
			and PAY_NO	= '".$pay_no."'
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 실시간 계좌이체로 결제시 결제 상세 업데이트
     */
    public function upd_order_pay_dtl_bank($pay_no, $param, $date)
    {
        $query = "
			update	DAT_ORDER_PAY_DTL    /*  > etah_mfront > order_m > upd_order_pay_dtl_bank > 실시간 계좌이체로 결제시 결제 상세 업데이트 */
			set		  ORDER_PAY_DTL_STS_CD	= '02'			-- 결제상태 :: 결제완료
					, IMP_UID				= '".$param['imp_uid']."'
					, BANK_PAY_FEE			= ''
					, CASH_RECEIPT_YN		= 'N'
					, DEPOSIT_CUST_NM		= ''
					, ESCROW_YN				= '".$param['escrowuse']."'
					, PG_ORDER_NO			= '".$param['pg_tid']."'
			where
				1 = 1
			and	PAY_NO	= '".$pay_no."'
		";

        $db = self::_master_db();
        return $db->query($query);
    }
    /**
     * 2018.04.09
     * 휴대폰 결제시 결제 상세 업데이트
     */
    public function upd_order_pay_dtl_phone($pay_no, $param, $date)
    {
        $query = "
			update	DAT_ORDER_PAY_DTL    /*  > etah_mfront > order_m > upd_order_pay_dtl_phone > 휴대폰 결제시 결제 상세 업데이트 */
			set		  ORDER_PAY_DTL_STS_CD	= '02'			-- 결제상태 :: 결제완료
					, IMP_UID				= '".$param['imp_uid']."'
					, RECEIPT_URL			= '".$param['receipt_url']."'
					, MOBILE_TEL_CODE		= '".$param['tel_code']."'
					, MOBILE_NO			    = '".$param['mob_no']."'
					, PG_ORDER_NO			= '".$param['pg_tid']."'
			where
				1 = 1
			and	PAY_NO	= '".$pay_no."'
		";

        $db = self::_master_db();
        return $db->query($query);
    }
    /**
     * 가상계좌로 결제시 결제 상세 업데이트
     */
    public function upd_order_pay_dtl_vbank($pay_no, $param, $date)
    {
        $query = "
			update	DAT_ORDER_PAY_DTL    /*  > etah_mfront > order_m > upd_order_pay_dtl_vbank > 가상계좌로 결제시 결제 상세 업데이트 */
			set		  IMP_UID				= '".$param['imp_uid']."'
					, BANK_PAY_FEE			= ''
					, BANK_NM				= '".$param['vbank_name']."'
					, BANK_ACCOUNT_NO		= '".$param['vbank_num']."'
					, DEPOSIT_DEADLINE_DY	= '".$param['vbank_date']."'
					, CASH_RECEIPT_YN		= 'N'
					, DEPOSIT_CUST_NM		= ''
					, ESCROW_YN				= '".$param['escrowuse']."'
					, PG_ORDER_NO			= '".$param['pg_tid']."'
					, RETURN_BANK_NM        = '".$param['selRefundBank']."'
					, RETURN_ACCOUNT_NO     = REPLACE('".$param['txtRefundAccount']."', '-', '')
					, RETURN_CUST_NM        = '".$param['txtRefundCust']."'
			where
				1 = 1
			and	PAY_NO	= '".$pay_no."'
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 결제 완료시 결제 완료일시 및 상태 업데이트
     */
    public function upd_order_pay_state($pay_no)
    {
        $query = "
			update	DAT_ORDER_PAY    /*  > etah_mfront > order_m > upd_order_pay_state > 결제 완료시 결제 완료일시 및 상태 업데이트트 */
			SET		ORDER_PAY_COMPLETE_DT	= now()
				  , ORDER_PAY_STS_CD		= '02'
			WHERE	PAY_NO = '".$pay_no."'
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 무통장 입금완료시 결제상세 상태 업데이트
     */
    public function upd_order_pay_dtl_vbank_state($imp_uid)
    {
        $query = "
			update	DAT_ORDER_PAY_DTL    /*  > etah_mfront > order_m > upd_order_pay_dtl_vbank_state > 무통장 입금완료시 결제상세 상태 업데이트 */
			set		ORDER_PAY_DTL_STS_CD	= '02'
			where
				1 = 1
			and IMP_UID		= '".$imp_uid."'
		";
//var_dump($query);
        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 마일리지 적립할 금액이 있을 경우 적립정보 등록
     */
    public function set_cust_mileage_save($order_refer_no, $param, $date)
    {
        $query = "
			insert into	DAT_CUST_MILEAGE_SAVING	(    /*  > etah_mfront > order_m > set_cust_mileage_save > 마일리지 적립할 금액이 있을 경우 적립정보 등록 */
				CUST_NO
			  , ORDER_REFER_NO
			  , ORDER_DT
			  , MILEAGE_SAVING_AMT
			  , SAVE_YN
			  , SAVE_DT
			)
			values
			(
				'".$param['CUST_NO']."'
			  , '".$order_refer_no."'
			  , '".$date."'
			  , '".$param['goods_mileage_saving_amt']."'
			  , 'Y'
			  , '".$date."'
			)
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 마일리지로 결제시 마일리지 사용정보 등록
     */
    public function set_cust_mileage_pay($pay_dtl_no, $param, $date)
    {
        $query = "
			insert into	DAT_CUST_MILEAGE_PAY	(   /*  > etah_mfront > order_m > set_cust_mileage_pay > 마일리지로 결제시 마일리지 사용정보 등록 */
				  ORDER_PAY_DTL_NO
				, CUST_NO
				, ORDER_DT
				, MILEAGE_PAY_AMT
			)
			values
			(
				  '".$pay_dtl_no."'
				, '".$param['buyercode']."'
				, '".$date."'
				, '".$param['use_mileage']."'
			)
		";

        //log_message("DEBUG","set_cust_mileage_pay==============".$query);
        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 마일리지 사용정보 업데이트
     */
    public function upd_cust_pay_mileage($param,$gb)
    {
        if($gb == 'pay'){
            $pay_mileage = $param['pay_mileage_amt'] + $param['use_mileage'];	//사용한 마일리지 재계산
            $mileage_amt = $param['org_mileage'] - $param['use_mileage'];		//보유 마일리지 재계산

            $query = "
				update	DAT_CUST_MILEAGE    /*  > etah_mfront > order_m > upd_cust_pay_mileage > 마일리지 사용정보 업데이트 */
				set		  PAY_MILEAGE_AMT		= '".$pay_mileage."'
						, MILEAGE_AMT			= '".$mileage_amt."'
				where
					1 = 1
				and	CUST_NO	= '".$param['buyercode']."'
			";
        } else if($gb == 'save'){
            $save_mileage = $param['pay_mileage_amt'] + $param['goods_mileage_saving_amt'];	//사용한 마일리지 재계산
            $mileage_amt  = $param['org_mileage'] + $param['goods_mileage_saving_amt'];		//보유 마일리지 재계산

            $query = "
				insert into	DAT_CUST_MILEAGE(   /*  > etah_mfront > order_m > upd_cust_pay_mileage > 마일리지 사용정보 업데이트 */
					  SAVE_MILEAGE_AMT
					, MILEAGE_AMT
					, CUST_NO
				)
				values(
					  '".$save_mileage."'
					, '".$mileage_amt."'
					, '".$param['buyercode']."'
				)
				on duplicate key
				update
					  SAVE_MILEAGE_AMT		= '".$save_mileage."'
					, MILEAGE_AMT			= '".$mileage_amt."'
			";
        }

        $db = self::_master_db();
        return $db->query($query);
    }





    /**
     * 결제 할인 상세 생성
     */
    public function set_order_pay_dc_dtl($pay_no, $param)
    {
        $query = "
			insert into	DAT_ORDER_PAY_DC_DTL	(   /*  > etah_mfront > order_m > set_order_pay_dc_dtl > 결제 할인 상세 생성 */
				  PAY_NO
				, COUPON_CD
				, ORDER_PAY_DC_DTL_STS_CD
				, COUPON_DTL_NO
				, DC_AMT
			)
			values
			(
				  '".$pay_no."'
				, '".$param['goods_coupon_code']."'
				, '02'
			";
        if($param['goods_coupon_num'] == ""){
            $query .= "
				, null		";
        } else {
            $query .= "
				, '".$param['goods_coupon_num']."'	";
        }
        $query .= "
				, '".$param['goods_discount_price']."'
			)
		";
//var_dump($query);
        $db = self::_master_db();
        $result = $db->query($query);
        $rs_identity = $db->insert_id();

        return $rs_identity;
    }

    /**
     * 할인상세&주문상세 매핑
     */
    public function set_map_dc_n_order($pay_dc_no, $order_refer_no)
    {
        $query = "
			insert into	MAP_DC_DTL_N_ORD_REFER	(   /*  > etah_mfront > order_m > set_map_dc_n_order > 할인상세&주문상세 매핑 */
				  PAY_DC_NO
				, ORDER_REFER_NO
			)
			values
			(
				  '".$pay_dc_no."'
				, '".$order_refer_no."'
			)
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 사용한 쿠폰 상세 상태 변경하기
     */
    public function upd_coupon_dtl($param, $date)
    {
        $query = "
			update	DAT_COUPON_DTL    /*  > etah_mfront > order_m > upd_coupon_dtl > 사용한 쿠폰 상세 상태 변경하기 */
			set		  COUPON_USE_DT	= '".$date."'
					, USE_YN		= 'N'
			where
				1 = 1
			and COUPON_DTL_NO	= '".$param['goods_coupon_num']."'
			and COUPON_CD		= '".$param['goods_coupon_code']."'
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 사용한 고객 쿠폰 상태 변경하기
     */
    public function upd_cust_coupon($param, $order_no)
    {
        $query = "
			update	DAT_CUST_COUPON   /*  > etah_mfront > order_m > upd_cust_coupon > 사용한 고객 쿠폰 상태 변경하기 */
			set		  DC_AMT	= '".$param['goods_discount_price']."'
					, ORDER_NO	= '".$order_no."'
					, USE_YN	= 'N'
			where
				1 = 1
			and CUST_NO			= '".$param['cust_no']."'
			and CUST_COUPON_NO	= '".$param['goods_coupon_no']."'
			and COUPON_CD		= '".$param['goods_coupon_code']."'
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 장바구니에서 구매했을 경우 장바구니 목록에서 제거
     */
    public function upd_cart_state($param, $cust_no)
    {
        $query = "
			update	DAT_CART    /*  > etah_mfront > order_m > upd_cart_state > 장바구니 목록에서 제거 */
			set		USE_YN	= 'N'
			where
				1 = 1
			and CUST_NO			= '".$cust_no."'
			and GOODS_CD		= '".$param['goods_code']."'
			and GOODS_OPTION_CD	= '".$param['goods_option_code']."'
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 주문 완료시, SMS 전송
     */
    public function set_order_sms($sParam)
    {
        $query = "
			insert into	DAT_SMS_MSG	(    /*  > etah_mfront > order_m > set_order_sms > 주문 완료시, SMS 전송 */
				  DEST_PHONE
				, GUBN_VAL
				, MSG
			)
			values
			(
				  '".$sParam['DEST_PHONE']."'
				, '".$sParam['GUBN_VAL']."'
				, '".$sParam['MSG']."'
			)
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 주문 데이터 불러오기
     */
    public function get_order_info($order_no)
    {
        $query = "
			select		/*  > etah_mfront > order_m > get_order_info > 주문 데이터 불러오기 */
				   o.ORDER_NO
				 , p.ORDER_AMT
				 , p.DC_AMT
				 , p.MILEAGE_AMT
				 , p.DELIV_COST_AMT
				 , p.TOTAL_PAY_SUM
				 , p.REAL_PAY_AMT
				 , p.ORDER_PAY_STS_CD
				 , pd.ORDER_PAY_KIND_CD
				 , cpk.ORDER_PAY_KIND_CD_NM
				 , pd.CARD_COMPANY_NM
				 , pd.PAY_AMT
				 , pd.CARD_FEE_AMT
				 , pd.CARD_MONTH
				 , pd.FREE_INTEREST_YN
				 , pd.BANK_NM
				 , pd.BANK_ACCOUNT_NO
				 , pd.DEPOSIT_DEADLINE_DY
				 , pd.DEPOSIT_CUST_NM
				 , pd.VARS_VNUM_NO
				 , pd.VARS_EXPR_DT
                 , pd.RETURN_BANK_NM
                 , pd.RETURN_ACCOUNT_NO
                 , pd.RETURN_CUST_NM
				 , d.SENDER_NM
				 , d.RECEIVER_NM
				 , d.RECEIVER_ZIPCODE
				 , d.RECEIVER_ADDR1
				 , d.RECEIVER_ADDR2
				 , d.RECEIVER_PHONE_NO
				 , d.RECEIVER_MOB_NO
				 , d.DELIV_MSG
				 , d.LIVING_FLOOR_CD
				 , d.STEP_WIDTH_CD
				 , d.ELEVATOR_CD

			from
				DAT_ORDER			o

			inner join
				DAT_ORDER_DELIV		d
			on d.ORDER_NO	= o.ORDER_NO

			inner join
				DAT_ORDER_PAY		p
			on p.ORDER_NO	= o.ORDER_NO

			inner join
				DAT_ORDER_PAY_DTL		pd
			on pd.PAY_NO	= p.PAY_NO

			inner join
				COD_ORDER_PAY_KIND_CD	cpk
			on cpk.ORDER_PAY_KIND_CD	= pd.ORDER_PAY_KIND_CD

			left join
				DAT_CUST			c
			on c.CUST_NO	= o.CUST_NO

			where
				1 = 1
			and o.ORDER_NO	= '".$order_no."'
		";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }

    /**
     * 주문 상품 데이터 불러오기
     */
    public function get_order_refer_info($order_no)
    {
        $query = "
			select		/*  > etah_mfront > order_m > get_order_refer_info > 주문상세 상품 데이터 불러오기 */
				  r.ORDER_REFER_NO
				, r.GOODS_CD
				, r.GOODS_NM
				, r.GOODS_OPTION_CD
				, r.GOODS_OPTION_NM
				, ifnull(r.SELLING_ADD_PRICE, 0)		as GOODS_OPTION_ADD_PRICE
				, r.ORD_QTY
				, r.SELLING_PRICE
				, r.TOTAL_PRICE
				, b.BRAND_NM
				, df.DELIV_COST
				, gi.IMG_URL
				, dp.DELIV_POLICY_NO
				, dp.PATTERN_TYPE_CD
				, sum(pdd.DC_AMT)		as DC_AMT
				, (	select	custcoupon.COUPON_CD
					from	DAT_ORDER_PAY_DC_DTL		paydtl
					inner join
						MAP_DC_DTL_N_ORD_REFER		map
					on map.PAY_DC_NO	= paydtl.PAY_DC_NO
					inner join
						DAT_CUST_COUPON				custcoupon
					on custcoupon.COUPON_CD		= paydtl.COUPON_CD
					where
						1 = 1
					and paydtl.PAY_NO		= p.PAY_NO
					and map.ORDER_REFER_NO	= r.ORDER_REFER_NO
					limit 1
				)	as ADD_COUPON_CD		/** 사용한 추가쿠폰 코드 **/
				, (	select	coupon.DC_COUPON_NM
					from	DAT_ORDER_PAY_DC_DTL		paydtl
					inner join
						MAP_DC_DTL_N_ORD_REFER	map
					on map.PAY_DC_NO	= paydtl.PAY_DC_NO
					inner join
						DAT_CUST_COUPON		custcoupon
					on custcoupon.COUPON_CD	= paydtl.COUPON_CD
					inner join
						DAT_COUPON			coupon
					on coupon.COUPON_CD		= custcoupon.COUPON_CD
					where
						1 = 1
					and paydtl.PAY_NO		= p.PAY_NO
					and map.ORDER_REFER_NO	= r.ORDER_REFER_NO
					limit 1
				)	as ADD_COUPON_NM		/** 사용한 추가쿠폰 이름 **/

			from
				DAT_ORDER			o

			inner join
				DAT_ORDER_REFER		r
			on r.ORDER_NO 	= o.ORDER_NO

			inner join
				DAT_ORDER_DELIV_FEE			df
			on df.ORDER_DELIV_FEE_NO = r.ORDER_DELIV_FEE_NO

			inner join
				DAT_GOODS			g
			on g.GOODS_CD 	= r.GOODS_CD

			inner join
				DAT_GOODS_OPTION		go
			on	go.GOODS_CD			= r.GOODS_CD
			and go.GOODS_OPTION_CD	= r.GOODS_OPTION_CD

			inner join
				DAT_GOODS_IMAGE		gi
			on gi.GOODS_CD = g.GOODS_CD
			and gi.TYPE_CD = 'TITLE'
			and gi.USE_YN  = 'Y'

			inner join
				DAT_BRAND			b
			on b.BRAND_CD 	= g.BRAND_CD

			left join
				MAP_DC_DTL_N_ORD_REFER		mdc
			on mdc.ORDER_REFER_NO	= r.ORDER_REFER_NO

			inner join
				DAT_ORDER_PAY		p
			on p.ORDER_NO	= r.ORDER_NO

			left join
				DAT_ORDER_PAY_DC_DTL		pdd
			on	pdd.PAY_NO	= p.PAY_NO
			and pdd.PAY_DC_NO	= mdc.PAY_DC_NO

			inner join
				DAT_DELIV_POLICY	dp
			on	dp.DELIV_POLICY_NO	= g.DELIV_POLICY_NO
			and dp.USE_YN			= 'Y'

			where
				1 = 1
			and o.ORDER_NO = '".$order_no."'

			group by
				r.ORDER_REFER_NO
		";

        $db = self::_slave_db();
        return $db->query($query)->result_array();
    }

    /**
     * 최근 주문한 배송지 불러오기
     */
    public function get_last_order_deliv($cust_no)
    {
        $query = "
			select    /*  > etah_mfront > order_m > get_last_order_deliv > 최근 주문한 배송지 불러오기 */
				  d.ORDER_DELIV_NO
				, d.ORDER_NO
				, d.SENDER_NM
				, d.SENDER_PHONE_NO
				, d.SENDER_MOB_NO
				, d.SENDER_EMAIL
				, d.SENDER_ZIPCODE
				, d.SENDER_ADDR1
				, d.SENDER_ADDR2
				, d.RECEIVER_NM
				, d.RECEIVER_PHONE_NO
				, d.RECEIVER_MOB_NO
				, d.RECEIVER_EMAIL
				, d.RECEIVER_ZIPCODE
				, d.RECEIVER_ADDR1
				, d.RECEIVER_ADDR2
			from
				DAT_ORDER			o
			inner join
				DAT_ORDER_DELIV		d
			on d.ORDER_NO	= o.ORDER_NO

			where
				1 = 1
			and o.CUST_NO	= '".$cust_no."'
			order by
				o.ORDER_NO	desc

			limit 1
		";

        $db = self::_slave_db();
        return $db->query($query)->row_array();
    }


    //kcp 결제 정보 저장
    public function saveKCPLOG($kcp_param){

        $query = "
				insert into	LOG_KCP	(   /*  > etah_mfront > order_m > saveKCPLOG > kcp 결제 정보 저장 */
					  SEQ
					, RES_CD
					, RES_MSG
					, TNO
					, AMOUNT
					, ESCW_YN
					, CARD_CD
					, CARD_NAME
					, CARD_APP_TIME
					, CARD_NOINF
					, CARD_NOINF_TYPE
					, CARD_QUOTA
					, CARD_MNY
					, CARD_COUPON_MNY
					, CARD_PARTCANC_YN
					, CARD_BIN_TYPE_01
					, CARD_BIN_TYPE_02
					, BANK_CODE
					, BANK_NAME
					, BANK_APP_TIME
					, BANK_CASH_AUTHNO
					, BANK_CASH_NO
					, BANK_BK_MNY
					, VCNT_BANKNAME
					, VCNT_BANKCODE
					, VCNT_ACCOUNT
					, VCNT_VA_DATE
					, VCNT_APP_TIME
					, MOBX_VAN_CD
					, MOBX_VAN_ID
					, MOBX_COMMID
					, MOBX_MOBILE_NO
					, CASH_AUTHNO
					, CASH_NO
				)
				values
				(
					 ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
				)
			";

        $db = self::_master_db();
        return	$db->query($query, array($kcp_param['SEQ']
        , $kcp_param['RES_CD']
        , $kcp_param['RES_MSG']
        , $kcp_param['TNO']
        , $kcp_param['AMOUNT']
        , $kcp_param['ESCW_YN']
        , $kcp_param['CARD_CD']
        , $kcp_param['CARD_NAME']
        , $kcp_param['CARD_APP_TIME']
        , $kcp_param['CARD_NOINF']
        , $kcp_param['CARD_NOINF_TYPE']
        , $kcp_param['CARD_QUOTA']
        , $kcp_param['CARD_MNY']
        , $kcp_param['CARD_COUPON_MNY']
        , $kcp_param['CARD_PARTCANC_YN']
        , $kcp_param['CARD_BIN_TYPE_01']
        , $kcp_param['CARD_BIN_TYPE_02']
        , $kcp_param['BANK_CODE']
        , $kcp_param['BANK_NAME']
        , $kcp_param['BANK_APP_TIME']
        , $kcp_param['BANK_BK_MNY']
        , $kcp_param['BANK_CASH_AUTHNO']
        , $kcp_param['BANK_CASH_NO']
        , $kcp_param['VCNT_BANKNAME']
        , $kcp_param['VCNT_BANKCODE']
        , $kcp_param['VCNT_ACCOUNT']
        , $kcp_param['VCNT_VA_DATE']
        , $kcp_param['VCNT_APP_TIME']
        , $kcp_param['MOBX_VAN_CD']
        , $kcp_param['MOBX_VAN_ID']
        , $kcp_param['MOBX_COMMID']
        , $kcp_param['MOBX_MOBILE_NO']
        , $kcp_param['BANK_CASH_AUTHNO']
        , $kcp_param['BANK_CASH_NO']
        ));
    }


    /**
     * 주문 임시 데이터 저장
     * @auth beom
     */
    function set_temp_order($param){

        $query = "
				insert into	TEMP_ORDER	(    /*  > etah_mfront > order_m > set_temp_order > 주문 임시 데이터 저장 */
					  BUYER_ID
					  , BUYER_CODE
					  , ORDER_NAME
					  , BUYERMOBNO
					  , BUYEREMAIL
					  , BUYERZIPCODE
					  , BUYERADDR1
					  , BUYERADDR2
					  , RETURN_BANK_NM
					  , RETURN_ACCOUNT_NO
					  , RETURN_CUST_NM
					  , ORDER_RECIPIENT
					  , ORDER_PHONE
					  , ORDER_MOBILE
					  , ORDER_POSTNUM
					  , ORDER_ADDR1
					  , ORDER_ADDR2
					  , SHIPPING_FLOOR
					  , SHIPPING_STEP_WIDTH
					  , SHIPPING_ELEVATOR
					  , ORDER_REQUEST
					  , ORDERCUSTOMSNUM
					  , GROUP_DELI_POLICY_NO
					  , GROUP_DELIVERY_PRICE
					  , GROUP_ADD_DELIVERY_PRICE
					  , GOODS_CODE
					  , GOODS_NAME
					  , GOODS_OPTION_CODE
					  , GOODS_OPTION_NAME
					  , GOODS_OPTION_ADD_PRICE
					  , GOODS_CNT
					  , GOODS_PRICE_CODE
					  , GOODS_STREET_PRICE
					  , GOODS_SELLING_PRICE
					  , GOODS_FACTORY_PRICE
					  , GOODS_MILEAGE_SAVE_AMT
					  , GOODS_DELI_POLICY_NO
					  , TOTAL_ORDER_MONEY
					  , TOTAL_DELIVERY_MONEY
					  , TOTAL_DISCOUNT_MONEY
					  , USE_MILEAGE
					  , ORDER_PAYMENT_TYPE
					  , GOODS_COUPON_CODE_S
					  , GOODS_COUPON_AMT_S
					  , GOODS_COUPON_CODE_I
					  , GOODS_COUPON_AMT_I
					  , GOODS_ADD_COUPON_CODE
					  , GOODS_ADD_COUPON_NO
					  , GOODS_ADD_COUPON_NUM
					  , GOODS_ADD_DISCOUNT_PRICE
					  , CART_COUPON_CODE
					  , CART_COUPON_NUM
					  , CART_COUPON_AMT
					  , ESCROWUSE
					  , BROWSER_INFO
				)
				values
				(
					  ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
				)
			";

        $db = self::_master_db();
        $db->query($query, array($param['buyerid']
        , $param['buyercode']
        , $param['order_name']
        , $param['buyermobno']
        , $param['buyeremail']
        , $param['buyerzipcode']
        , $param['buyeraddr1']
        , $param['buyeraddr2']
        , $param['selRefundBank']
        , $param['txtRefundAccount']
        , $param['txtRefundCust']
        , $param['order_recipient']
        , $param['order_phone']
        , $param['order_mobile']
        , $param['order_postnum']
        , $param['order_addr1']
        , $param['order_addr2']
        , $param['shipping_floor']
        , $param['shipping_step_width']
        , $param['shipping_elevator']
        , $param['order_request']
        , $param['orderCustomsNum']
        , $param['group_deli_policy_no']
        , $param['group_delivery_price']
        , $param['group_add_delivery_price']
        , $param['goods_code']
        , $param['goods_name']
        , $param['goods_option_code']
        , $param['goods_option_name']
        , $param['goods_option_add_price']
        , $param['goods_cnt']
        , $param['goods_price_code']
        , $param['goods_street_price']
        , $param['goods_selling_price']
        , $param['goods_factory_price']
        , $param['goods_mileage_save_amt']
        , $param['goods_deli_policy_no']
        , $param['total_order_money']
        , $param['total_delivery_money']
        , $param['total_discount_money']
        , $param['use_mileage']
        , $param['order_payment_type']
        , $param['goods_coupon_code_s']
        , $param['goods_coupon_amt_s']
        , $param['goods_coupon_code_i']
        , $param['goods_coupon_amt_i']
        , $param['goods_add_coupon_code']
        , $param['goods_add_coupon_no']
        , $param['goods_add_coupon_num']
        , $param['goods_add_discount_price']
        , $param['cart_coupon_code']
        , $param['cart_coupon_num']
        , $param['cart_coupon_amt']
        , $param['escrowuse']
        , $param['browser_info']
        ));

        // $db->query($query, "test" );
        $code = $db->insert_id();

        return $code;
    }

    /**
     * 모바일 임시 주문정보 가져오기
     */
    public  function get_temp_order($ordNo){
        //log_message("DEBUG" , "===============get_temp_order======== ".$ordNo);
        $query = "select     /*  > etah_mfront > order_m > get_temp_order > 모바일 임시 주문정보 가져오기 */
				  o.ORDER_CODE
				, o.BUYER_ID
				, o.BUYER_CODE
				, o.ORDER_NAME
				, o.BUYERMOBNO
				, o.BUYEREMAIL
				, o.BUYERZIPCODE
				, o.BUYERADDR1
				, o.BUYERADDR2
				, o.RETURN_BANK_NM
				, o.RETURN_ACCOUNT_NO
				, o.RETURN_CUST_NM
				, o.ORDER_RECIPIENT
				, o.ORDER_PHONE
				, o.ORDER_MOBILE
				, o.ORDER_POSTNUM
				, o.ORDER_ADDR1
				, o.ORDER_ADDR2
				, o.SHIPPING_FLOOR
				, o.SHIPPING_STEP_WIDTH
				, o.SHIPPING_ELEVATOR
				, o.ORDER_REQUEST
				, o.ORDERCUSTOMSNUM
				, o.GROUP_DELI_POLICY_NO
				, o.GROUP_DELIVERY_PRICE
				, o.GROUP_ADD_DELIVERY_PRICE
				, o.GOODS_CODE
				, o.GOODS_NAME
				, o.GOODS_OPTION_CODE
				, o.GOODS_OPTION_NAME
				, o.GOODS_OPTION_ADD_PRICE
				, o.GOODS_CNT
				, o.GOODS_PRICE_CODE
				, o.GOODS_STREET_PRICE
				, o.GOODS_SELLING_PRICE
				, o.GOODS_FACTORY_PRICE
				, o.GOODS_MILEAGE_SAVE_AMT
				, o.GOODS_DELI_POLICY_NO
				, o.TOTAL_ORDER_MONEY
				, o.TOTAL_DELIVERY_MONEY
				, o.TOTAL_DISCOUNT_MONEY
				, o.USE_MILEAGE
				, o.ORDER_PAYMENT_TYPE
				, o.GOODS_COUPON_CODE_S	
                , o.GOODS_COUPON_AMT_S
                , o.GOODS_COUPON_CODE_I
                , o.GOODS_ADD_COUPON_NO
                , o.GOODS_ADD_COUPON_CODE
                , o.GOODS_ADD_COUPON_NUM
                , o.GOODS_ADD_DISCOUNT_PRICE
                , o.GOODS_COUPON_AMT_I
                , o.CART_COUPON_CODE
                , o.CART_COUPON_NUM
                , o.CART_COUPON_AMT
                , o.ESCROWUSE
			from
				TEMP_ORDER	o
			where
				o.ORDER_CODE = ?
		";

        $db = self::_master_db();
        $result = $db->query($query, $ordNo)->row_array();

        //   log_message("DEBUG", "=======get_temp_order ===== ".$db->last_query());
        return $result;
    }


    /**
     * 주문생성 실패시 해당주문 사용안함
     * @auth beom
     */
    public function set_order_dismiss($ordNo){
        $query = "
			update	DAT_ORDER   /*  > etah_mfront > order_m > set_order_dismiss > 주문생성 실패시 해당주문 사용안함 */
			set		USE_YN = 'N'
			where
				ORDER_NO = ?
		";

        $db = self::_master_db();
        $db->query($query, $ordNo);
    }

    /**
     * 회원 레벨 변경
     * @auth beam
     */

    public function upd_cust_level($custNo){
        $query = "
			update	DAT_CUST    /*  > etah_mfront > order_m > upd_cust_level > 회원 레벨 변경 */
			set		CUST_LEVEL_CD = '02'
			where
				CUST_NO = ?
		";

        $db = self::_master_db();
        $db->query($query, $custNo);
    }


    /**
     * 주문마스터 생성 kcp
     *
     */
    public function set_order_kcp($param){
        $db = self::_master_db();

        //원더쇼핑 유입 여부 체크
        $column = "";
        $value = "";

        if(isset($_COOKIE['funnel'])) {
            if($_COOKIE['funnel'] == 'wonder') {
                $column = ", LINK_CD";
                $value = ", '4'";
            }
        }

        if($param['BUYER_ID'] != 'GUEST'){	//회원주문일경우
            $query = "
				insert into	DAT_ORDER	(   /*  > etah_mfront > order_m > set_order_kcp > 주문마스터 생성 kcp */
					  CUST_NO
					, ORD_DT
					, NONMEMBER_ORDER_YN
					$column
				)
				values
				(
					  ?
					, now()
					, 'N'
					$value
				)
			";
            $db->query($query, $param['BUYER_CODE']);
            $rs_identity = $db->insert_id();

        } else {
            $query = "
				insert into	DAT_ORDER	(    /*  > etah_mfront > order_m > set_order_kcp > 주문마스터 생성 kcp */
					  ORD_DT
					, NONMEMBER_ORDER_YN
					$column
				)
				values
				(
					  now()
					, 'Y'
					$value
				)
			";

            $db->query($query);
            $rs_identity = $db->insert_id();
        }
        return $rs_identity;
    }


    /**
     * 주문 상세 생성
     */
    public function set_order_refer_kcp($order_no, $order_deliv_fee_no, $param)
    {
        $query = "
			insert into	DAT_ORDER_REFER	(    /*  > etah_mfront > order_m > set_order_refer_kcp > 주문 상세 생성 */
				  ORDER_NO
				, ORDER_DELIV_FEE_NO
				, GOODS_CD
				, GOODS_NM
				, GOODS_OPTION_CD
				, GOODS_OPTION_NM
				, ORD_QTY
				, GOODS_PRICE_CD
				, STREET_PRICE
				, SELLING_PRICE
				, SELLING_ADD_PRICE
				, FACTORY_PRICE
				, TOTAL_PRICE
				, GOODS_MILEAGE_SAVING_AMT
			)
			values
			(
				  ?
				, ?
				, ?
				, ?
				, ?
				, ?
				, ?
				, ?
				, ?
				, ?
				, ?
				, ?
				, ?
				, ?

			)
			
		";

        $db = self::_master_db();
        $db->query($query, array(
            $order_no
        , $order_deliv_fee_no
        , $param['goods_code']
        , $param['goods_name']
        , $param['goods_option_code']
        , $param['goods_option_name']
        , $param['goods_cnt']
        , $param['goods_price']
        , $param['goods_street_price']
        , $param['goods_selling_price']
        , $param['goods_option_add_price']
        , $param['goods_factory_price']
        , $param['total_price']
        , $param['goods_mileage_saving_amt']
        ));
        $rs_identity = $db->insert_id();

        return $rs_identity;
    }



    /**
     * 주문 배송지 생성
     */
    public function set_order_delivery_kcp($order_no, $param)
    {
        $param = str_replace("'","＇",$param);

        $query = "
			insert into	DAT_ORDER_DELIV	(   /*  > etah_mfront > order_m > set_order_delivery_kcp > 주문 배송지 생성 */
				  ORDER_NO
				, SENDER_NM
				, SENDER_PHONE_NO
				, SENDER_MOB_NO
				, SENDER_EMAIL
				, SENDER_ZIPCODE
				, SENDER_ADDR1
				, SENDER_ADDR2
				, RECEIVER_NM
				, RECEIVER_PHONE_NO
				, RECEIVER_MOB_NO
				, RECEIVER_ZIPCODE
				, RECEIVER_ADDR1
				, RECEIVER_ADDR2
				, LIVING_FLOOR_CD
				, STEP_WIDTH_CD
				, ELEVATOR_CD
				, INSTALL_SPACE_YN
				, LADDER_TRUCK_NEED_YN
				, LADDER_TRUCK_CUST_PAY_YN
				, DELIV_MSG	";
        if(isset($param['ORDERCUSTOMSNUM'])){
            $query .= "
				, CUST_ID_NO	";
        }
        $query .= "
			)
			values
			(
				  '".$order_no."'
				, '".$param['ORDER_NAME']."'
				, ''
				, '".$param['BUYERMOBNO']."'
				, '".$param['BUYEREMAIL']."'
				, '".$param['BUYERZIPCODE']."'
				, '".$param['BUYERADDR1']."'
				, '".$param['BUYERADDR2']."'
				, '".$param['ORDER_RECIPIENT']."'
				, '".$param['ORDER_PHONE']."'
				, '".$param['ORDER_MOBILE']."'
				, '".$param['ORDER_POSTNUM']."'
				, '".$param['ORDER_ADDR1']."'
				, '".$param['ORDER_ADDR2']."'
				, '".$param['SHIPPING_FLOOR']."'
				, '".$param['SHIPPING_STEP_WIDTH']."'
				, '".$param['SHIPPING_ELEVATOR']."'
				, 'Y'
				, 'Y'
				, 'Y'
				, '".$param['ORDER_REQUEST']."'	";
        if(isset($param['ORDERCUSTOMSNUM'])){
            $query .= "
				, '".$param['ORDERCUSTOMSNUM']."'	";
        }
        $query .= "
			)
		";

        $db = self::_master_db();
        $db->query($query);
    }

    /**
     * 결제 마스타 생성
     */
    public function set_order_pay_kcp($order_no, $param, $date)
    {
        $real_pay_amt = $param['TOTAL_ORDER_MONEY']+$param['TOTAL_DELIVERY_MONEY']-$param['TOTAL_DISCOUNT_MONEY']-$param['USE_MILEAGE'];

        $total_pay_sum = $param['TOTAL_ORDER_MONEY']+$param['TOTAL_DELIVERY_MONEY']-$param['TOTAL_DISCOUNT_MONEY'];
        $query = "
			insert into	DAT_ORDER_PAY	(    /*  > etah_mfront > order_m > set_order_pay_kcp > 결제 마스타 생성 */
				  ORDER_NO
				, ORDER_PAY_STS_CD
				, ORDER_AMT
				, DELIV_COST_AMT
				, DC_AMT
				, MILEAGE_AMT
				, REAL_PAY_AMT
				, TOTAL_PAY_SUM
				, ORDER_PAY_REQ_DT
				, DEVICE_TYPE
			)
			values
			(
				  '".$order_no."'
				, '01'
				, '".$param['TOTAL_ORDER_MONEY']."'
				, '".$param['TOTAL_DELIVERY_MONEY']."'
				, '".$param['TOTAL_DISCOUNT_MONEY']."'
				, '".$param['USE_MILEAGE']."'
				, '".$real_pay_amt."'
				, '".$total_pay_sum."'
				, '".$date."'
				, 'M'
			)
		";

        $db = self::_master_db();
        $db->query($query);
        $rs_identity = $db->insert_id();

        return $rs_identity;
    }


    /**
     * 결제 상세 생성
     */
    public function set_order_pay_dtl_kcp($pay_no, $param)
    {
        $pay_amt = $param['TOTAL_ORDER_MONEY']+$param['TOTAL_DELIVERY_MONEY']-$param['TOTAL_DISCOUNT_MONEY']-$param['USE_MILEAGE'];

        $query = "
			insert into	DAT_ORDER_PAY_DTL	(    /*  > etah_mfront > order_m > set_order_pay_dtl_kcp > 결제 상세 생성 */
				  PAY_NO							
				, ORDER_PAY_DTL_STS_CD
				, ORDER_PAY_KIND_CD
				, PAY_AMT
			)
			values
			(
				  '".$pay_no."'
				, '01'
				, '".$param['ORDER_PAYMENT_TYPE']."'
				, '".$pay_amt."'
			)
		";

        $db = self::_master_db();
        $db->query($query);
    }

    /**
     * 카드로 결제시 결제 상세, 결제 업데이트
     */
    public function upd_order_pay_dtl_card_kcp($pay_no, $param)
    {
        $db = self::_master_db();

        $query = "
			update	DAT_ORDER_PAY_DTL   /*  > etah_mfront > order_m > upd_order_pay_dtl_card_kcp >  카드로 결제시 결제 상세, 결제 업데이트 */
			set		  ORDER_PAY_DTL_STS_CD	= '02'			-- 결제상태 :: 결제완료
					, IMP_UID				= '".$param['IMP_UID']."'
					, RECEIPT_URL			= '".$param['RECEIPT_URL']."'
					, CARD_COMPANY_NM		= '".$param['CARD_NAME']."'
					, CARD_MONTH			= '".$param['CARD_QUOTA']."'
					, PG_ORDER_NO			= '".$param['PG_TID']."'
			where
				1 = 1
			and PAY_NO	= '".$pay_no."'
		";

        $db->query($query);


        $query1 = "
			update	DAT_ORDER_PAY   /*  > etah_mfront > order_m > upd_order_pay_dtl_card_kcp >  카드로 결제시 결제 상세, 결제 업데이트 */
			SET		ORDER_PAY_COMPLETE_DT	= now()
				  , ORDER_PAY_STS_CD		= '02'
			WHERE	PAY_NO = '".$pay_no."'
		";

        $db->query($query1);
    }

    /**
     * 실시간 계좌이체로 결제시 결제 상세 업데이트
     */
    public function upd_order_pay_dtl_bank_kcp($pay_no, $param)
    {
        $db = self::_master_db();

        $query = "
			update	DAT_ORDER_PAY_DTL   /*  > etah_mfront > order_m > upd_order_pay_dtl_bank_kcp >  실시간 계좌이체로 결제시 결제 상세, 결제 업데이트 */
			set		  ORDER_PAY_DTL_STS_CD	= '02'			-- 결제상태 :: 결제완료
					, IMP_UID				= '".$param['IMP_UID']."'
					, BANK_PAY_FEE			= ''
					, CASH_RECEIPT_YN		= 'N'
					, DEPOSIT_CUST_NM		= ''
					, ESCROW_YN				= '".$param['ESCROWUSE']."'
					, PG_ORDER_NO			= '".$param['PG_TID']."'
			where
				1 = 1
			and	PAY_NO	= '".$pay_no."'
		";

        $db->query($query);

        $query1 = "
			update	DAT_ORDER_PAY   /*  > etah_mfront > order_m > upd_order_pay_dtl_bank_kcp >  실시간 계좌이체로 결제시 결제 상세, 결제 업데이트 */
			SET		ORDER_PAY_COMPLETE_DT	= now()
				  , ORDER_PAY_STS_CD		= '02'
			WHERE	PAY_NO = '".$pay_no."'
		";

        $db->query($query1);
    }


    /**
     * 가상계좌로 결제시 결제 상세 업데이트
     */
    public function upd_order_pay_dtl_vbank_kcp($pay_no, $param)
    {
        $query = "
			update	DAT_ORDER_PAY_DTL   /*  > etah_mfront > order_m > upd_order_pay_dtl_vbank_kcp >  가상계좌로 결제시 결제 상세, 결제 업데이트 */
			set		  IMP_UID				= '".$param['IMP_UID']."'
					, BANK_PAY_FEE			= ''
					, BANK_NM				= '".$param['VBANK_NAME']."'
					, BANK_ACCOUNT_NO		= '".$param['VBANK_NUM']."'
					, DEPOSIT_DEADLINE_DY	= '".$param['VBANK_DATE']."'
					, CASH_RECEIPT_YN		= 'N'
					, DEPOSIT_CUST_NM		= ''
					, ESCROW_YN				= '".$param['ESCROWUSE']."'
					, PG_ORDER_NO			= '".$param['PG_TID']."'
					, RETURN_BANK_NM        = '".$param['RETURN_BANK_NM']."'
					, RETURN_ACCOUNT_NO     = REPLACE('".$param['RETURN_ACCOUNT_NO']."', '-', '')
					, RETURN_CUST_NM        = '".$param['RETURN_CUST_NM']."'
			where
				1 = 1
			and	PAY_NO	= '".$pay_no."'
		";

        $db = self::_master_db();
        $db->query($query);
    }
    /**
     * 2018.04.10 추가
     * 휴대폰으로 결제시 결제 상세, 결제 업데이트
     */
    public function upd_order_pay_dtl_phone_kcp($pay_no, $param)
    {
        $db = self::_master_db();

        $query = "
			update	DAT_ORDER_PAY_DTL   /*  > etah_mfront > order_m > upd_order_pay_dtl_phone_kcp >  휴대폰으로 결제시 결제 상세, 결제 업데이트 */
			set		  ORDER_PAY_DTL_STS_CD	= '02'			-- 결제상태 :: 결제완료
					, IMP_UID				= '".$param['IMP_UID']."'
					, RECEIPT_URL			= '".$param['RECEIPT_URL']."'
					, MOBILE_TEL_CODE		= '".$param['MOBX_COMMID']."'
					, MOBILE_NO			    = '".$param['MOBX_MOBILE_NO']."'
					, ESCROW_YN				= '".$param['ESCROWUSE']."'
					, PG_ORDER_NO			= '".$param['PG_TID']."'
			where
				1 = 1
			and	PAY_NO	= '".$pay_no."'
		";

        $db->query($query);


        $query1 = "    
			update	DAT_ORDER_PAY   /*  > etah_mfront > order_m > upd_order_pay_dtl_phone_kcp >  휴대폰으로 결제시 결제 상세, 결제 업데이트 */
			SET		ORDER_PAY_COMPLETE_DT	= now()
				  , ORDER_PAY_STS_CD		= '02'
			WHERE	PAY_NO = '".$pay_no."'
		";

        $db->query($query1);
    }

    /**
     * 결제 상세 생성 (마일리지 결제)
     */
    public function set_order_pay_dtl_mileage_kcp($pay_no, $param)
    {
        $query = "
			insert into	DAT_ORDER_PAY_DTL	(   /*  > etah_mfront > order_m > set_order_pay_dtl_mileage_kcp >  결제 상세 생성 (마일리지 결제) */
				  PAY_NO							
				, ORDER_PAY_DTL_STS_CD
				, ORDER_PAY_KIND_CD
				, PAY_AMT
			)
			values
			(
				  '".$pay_no."'
				, '01'
				, '04'
				, '".$param['USE_MILEAGE']."'
			)
		";

        $db = self::_master_db();
        $db->query($query);
        $rs_identity = $db->insert_id();

        return $rs_identity;
    }


    /**
     * 마일리지로 결제시 마일리지 사용정보 등록
     */
    public function set_cust_mileage_pay_kcp($pay_dtl_no, $param, $date)
    {
        $query = "
			insert into	DAT_CUST_MILEAGE_PAY	(   /*  > etah_mfront > order_m > set_cust_mileage_pay_kcp >  마일리지로 결제시 마일리지 사용정보 등록 */
				  ORDER_PAY_DTL_NO
				, CUST_NO
				, ORDER_DT
				, MILEAGE_PAY_AMT
			)
			values
			(
				  '".$pay_dtl_no."'
				, '".$param['BUYER_CODE']."'
				, '".$date."'
				, '".$param['USE_MILEAGE']."'
			)
		";

        $db = self::_master_db();
        $db->query($query);
    }

    /**
     * 2018.04.10
     * 임시 주문 데이터 업데이트 저장
     * @auth 박상현
     */
    function set_temptno_data($param1, $param2){

        $query = "
				UPDATE TEMP_ORDER	  /*  > etah_mfront > order_m > set_temptno_data >  임시 주문 데이터 업데이트 저장 */
				   SET KCP_TNO = ?
				WHERE ORDER_CODE = ?  
			";

        $db = self::_master_db();
        $db->query($query, array($param1, $param2));

        // $db->query($query, "test" );
        $code = $db->insert_id();

        return $code;
    }

    /**
     * 2018.07.16
     * 카카오 알리미 sms
     * @auth 박상현
     */
    public function send_sms_kakao($kakao)
    {
        $mdb = self::_master_db();
        $mdb->trans_begin();

        self::insert_table('DAT_SMS_MSG',$kakao);

        if ( $mdb->trans_status() === FALSE ){
            $mdb->trans_rollback();
            return false;
        }else{
            $mdb->trans_commit();
            return true;
        }
    }

    /**
     * 링크프라이스 정보 저장
     */
    public function set_lprice_value($param)
    {
        $db = self::_master_db();
        $query = "
			insert into	DAT_ORDER_LPRICE(    /*  > etah_mfront > order_m > set_lprice_value >  링크프라이스 정보 저장 */
				  ORDER_NO
				, NETWORK_VALUE
				, REMOTE_ADDRESS
				, USER_AGENT
				
			)
			values
			(
				  '".$param['ORDER_NO']."'
				, '".$param['NETWORK_VALUE']."'
				, '".$param['REMOTE_ADDRESS']."'
				, '".$param['USER_AGENT']."'

			)
		";


        $result = $db->query($query);
        $rs_identity = $db->insert_id();

        $query1 = "
            update DAT_ORDER    /*  > etah_mfront > order_m > set_lprice_value >  링크프라이스 정보 저장 */
                set   LPRICE_NO = '".$rs_identity."'
            where ORDER_NO = '".$param['ORDER_NO']."'    
        ";

        $result2 = $db->query($query1);
        return $result2;

    }

    /**
     * 링크프라이스 주문 조회
     */
    public function get_lprice_order($sparam)
    {
        $db = self::_slave_db();
        $query = "select    /*  > etah_mfront > order_m > get_lprice_order >  링크프라이스 주문 조회 */
		                l.NETWORK_VALUE 			  as 'lpinfo'
		              , 'etah'						  as 'merchant_id'
		              , ifnull(o.CUST_NO, 'Guset')    as 'member_id'
		              , o.ORDER_NO			          as 'order_code'
		              , r.GOODS_OPTION_CD			  as 'product_code'
		              , r.GOODS_NM					  as 'product_name'
		              , r.ORD_QTY 					  as 'item_count'
		              , ceil(r.TOTAL_PRICE - (if(sum(PAY_DC.DC_AMT)is null, 0, sum(PAY_DC.DC_AMT)))) as 'sales'
		              , g.CATEGORY_MNG_CD			  as 'category_code'
		              , l.USER_AGENT				  as 'user_agent'
		              , l.REMOTE_ADDRESS 			  as 'remote_addr'
		              , 'MOBILE'					  as 'sales_type'
						
                from DAT_ORDER o

                inner join DAT_ORDER_REFER r
                on r.ORDER_NO = o.ORDER_NO
                
                inner join DAT_ORDER_LPRICE l
                on l.ORDER_NO = o.ORDER_NO
                
                inner join DAT_GOODS g
                on g.GOODS_CD = r.GOODS_CD
                
                left outer join MAP_DC_DTL_N_ORD_REFER MAP_DC
				on r.ORDER_REFER_NO	= MAP_DC.ORDER_REFER_NO
						
				left outer join DAT_ORDER_PAY PAY
				on o.ORDER_NO = PAY.ORDER_NO
				
				left outer join DAT_ORDER_PAY_DC_DTL PAY_DC
				on PAY.PAY_NO = PAY_DC.PAY_NO
				and MAP_DC.PAY_DC_NO = PAY_DC.PAY_DC_NO
                
                where o.ORDER_NO = ?
                
				group by r.ORDER_REFER_NO
				
				order by r.ORDER_REFER_NO
		";


        $result = $db->query($query, $sparam)->result_array();

        $query2="
                select    /*  > etah_mfront > order_m > get_lprice_order >  링크프라이스 주문 조회 */
		                l.NETWORK_VALUE 			  as 'lpinfo'
		              , 'etah'						  as 'merchant_id' 
		              , ifnull(o.CUST_NO, 'Guset')    as 'member_id'
		              , o.ORDER_NO			          as 'order_code'
		              , concat('M',o.ORDER_NO)		  as 'product_code'
		              , '포인트 사용 금액'			  as 'product_name'
		              , '1' 					      as 'item_count'
		              , if(PAY.MILEAGE_AMT, -PAY.MILEAGE_AMT, null) as 'sales'
		              , g.CATEGORY_MNG_CD			  as 'category_code'
		              , l.USER_AGENT				  as 'user_agent'
		              , l.REMOTE_ADDRESS 			  as 'remote_addr'
                      , 'MOBILE'					  as 'sales_type'
						
                from DAT_ORDER o

                inner join DAT_ORDER_REFER r
                on r.ORDER_NO = o.ORDER_NO
                
                inner join DAT_ORDER_LPRICE l
                on l.ORDER_NO = o.ORDER_NO
                
                inner join DAT_GOODS g
                on g.GOODS_CD = r.GOODS_CD
						
				left outer join DAT_ORDER_PAY PAY
				on o.ORDER_NO = PAY.ORDER_NO
                
                where o.ORDER_NO = ?
			 
			    group by o.ORDER_NO	";

        $row = $db->query($query2, $sparam)->row_array();

        if($row['sales'] != null){
            $result[]=$row;
        }

        return $result;
    }


    /**
     * 2018.12.12
     * Kakao Pay 추가
     *
     * @auth 박상현
     */

    /**
     * 임시 저장 데이터 가져오기
     */
    public function get_temp_order_kakao($param)
    {
        $query = "
                 select /*  > etah_mfront > order_m > get_temp_order_kakao >  임시 저장 데이터 가져오기 */
                 * 
                 from TEMP_ORDER t   
                 where t.ORDER_CODE = ?
        ";

        $db = self::_slave_db();
        $row = $db->query($query, $param)->row_array();

        return $row;
    }

    /**
     * 상품 과세 유무 조회
     */
    public function get_goodsTaxGb($goods_cd)
    {
        $query = "
                 select   /*  > etah_mfront > order_m > get_goodsTaxGb >  상품 과세 유무 조회 */
                 g.TAX_GB_CD 
                 from DAT_GOODS g
                 where g.GOODS_CD in (".$goods_cd.")
                 group by g.TAX_GB_CD
        ";

        $db = self::_slave_db();
        $result = $db->query($query)->result_array();

        return $result;
    }

    /**
     * 카카오 고유거래 번호 업데이트
     */
    public function set_kakao_tid($tid, $temp_no)
    {
        $query="
        update	TEMP_ORDER    /*  > etah_mfront > order_m > set_kakao_tid >  카카오 고유거래 번호 업데이트 */
			set		  KCP_TNO	= '".$tid."'			
			where
				1 = 1
			and ORDER_CODE	= '".$temp_no."'
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    /**
     * 카카오 페이 결제 진행상황 업데이트
     */
    public function upd_order_pay_dtl_kakao_pay($pay_no, $param)
    {
        $db = self::_master_db();

        $query = "
			update	DAT_ORDER_PAY_DTL   /*  > etah_mfront > order_m > upd_order_pay_dtl_kakao_pay > 카카오 페이 결제 진행상황 업데이트 */
			set		  ORDER_PAY_DTL_STS_CD	= '02'			-- 결제상태 :: 결제완료
			        , IMP_UID				= '".$param['IMP_UID']."'
			where
				1 = 1
			and PAY_NO	= '".$pay_no."'
		";

        $db->query($query);


        $query1 = "
			update	DAT_ORDER_PAY   /*  > etah_mfront > order_m > upd_order_pay_dtl_kakao_pay > 카카오 페이 결제 진행상황 업데이트 */
			SET		ORDER_PAY_COMPLETE_DT	= now()
				  , ORDER_PAY_STS_CD		= '02'
			WHERE	PAY_NO = '".$pay_no."'
		";

        $db->query($query1);
    }

    /**
     * 카카오 페이 결제로그 저장
     */
    public function saveKakaoLOG($param)
    {
        $query = "
				insert into	LOG_KAKAO_PAY	(   /*  > etah_mfront > order_m > saveKakaoLOG > 카카오 페이 결제로그 저장 */
				      ORDER_STATUS
					, ORDER_NO
					, CODE
					, MSG
					, MSG_EXTRAS
					, AID
					, TID
					, CID
					, PAYMENT_TYPE
					, AMOUNT
					, APPROVED_ID
					, CARD_BIN
					, CARD_MID
					, CARD_TYPE
					, INSTALL_MONTH
					, ISSUER_CORP
					, ISSUER_CORP_CODE
					, PURCHASE_CORP
					, PURCHASE_CORP_CODE
					, INTEREST_FREE
					, CARD_ITEM_CODE
					, ITEM_NAME
					, ITEM_CD
					, QTY
					, CRT_DT
					, APP_DT
					, PAYLOAD
					
				)
				values
				(
					 ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
				)
			";

        $db = self::_master_db();
        return	$db->query($query, array($param['status'], $param['order_no']
        , $param['code']
        , $param['method_result_code']
        , $param['method_result_message']
        , $param['aid']
        , $param['tid']
        , $param['cid']
        , $param['payment_method_type']
        , $param['amount']
        , $param['approved_id']
        , $param['bin']
        , $param['card_mid']
        , $param['card_type']
        , $param['install_month']
        , $param['purchase_corp']
        , $param['purchase_corp_code']
        , $param['issuer_corp']
        , $param['issuer_corp_code']
        , $param['interest_free_install']
        , $param['card_item_code']
        , $param['item_name']
        , $param['item_code']
        , $param['quantity']
        , $param['created_at']
        , $param['approved_at']
        , $param['payload']
        ));
    }

    /**
     * ARS 요청 결과 저장 (실결제 X)
     */
    public function saveVarsLOG($param){
        $query = "
            insert into LOG_VARS_KCP_INFO ( /*  > etah_mfront > order_m > saveVarsLOG > ARS 요청 결과 저장 */
                RES_CD
                , RES_MSG
                , ORDR_IDXX
                , PHON_MNY
                , COMM_ID
                , PHON_NO
                , VNUM_NO
                , CERT_FLG
                , APP_TIME
                , EXPR_DT
                , ARS_TRADE_NO
            ) values (
                '".$param['RES_CD']."'
                , '".$param['RES_MSG']."'
                , '".$param['ORDR_IDXX']."'
                , '".$param['PHON_MNY']."'
                , '".$param['COMM_ID']."'
                , '".$param['PHON_NO']."'
                , '".$param['VNUM_NO']."'
                , '".$param['CERT_FLG']."'
                , '".$param['APP_TIME']."'
                , '".$param['EXPR_DT']."'
                , '".$param['ARS_TRADE_NO']."'
            )
        ";

        $db = self::_master_db();
        return	$db->query($query);
    }

    /**
     * ARS 결제시 결제 상세 업데이트
     */
    public function upd_order_pay_dtl_vars($pay_no, $param, $date){
        $query = "
			update	DAT_ORDER_PAY_DTL   /*  > etah_mfront > order_m > upd_order_pay_dtl_vars >ARS 결제시 결제 상세 업데이트 */
			set		VARS_VNUM_NO    = '".$param['vnum_no']."'
			      , VARS_EXPR_DT    = '".$param['expr_dt']."'
			      , VARS_TRADE_NO   = '".$param['ars_trade_no']."'
			      , PG_ORDER_NO     = '".$param['pg_tid']."'
			where
				1 = 1
			and	PAY_NO	= '".$pay_no."'
		";

        $db = self::_master_db();
        return $db->query($query);
    }

    public function get_order($param)
    {
        $db = self::_slave_db();

        $query = "
                select   /*  > etah_mfront > order_m > get_order > 주문정보 조회 */
                    r.ORDER_NO 
                  , r.ORDER_REFER_NO
                  , s.VENDOR_SUBVENDOR_NM
                  , r.GOODS_NM
                  , i.IMG_URL
                  , r.GOODS_CD
                  , r.GOODS_OPTION_NM
                  , r.SELLING_PRICE
	              , r.SELLING_ADD_PRICE
                  , r.ORD_QTY
                  , r.TOTAL_PRICE
                  , d.SENDER_NM
                  , d.RECEIVER_MOB_NO
                  , d.SENDER_MOB_NO
                  , d.SENDER_EMAIL
                  , s.VENDOR_SUBVENDOR_ZIPCODE
                  , s.VENDOR_SUBVENDOR_ADDR
                  , s.VENDOR_SUBVENDOR_TEL
                  , p.ORDER_REFER_PROC_STS_CD
        		  , rc.CLASS_START_DT
        		  , rc.CLASS_END_DT
        		  , rc.CLASS_NO
        
        
                from DAT_ORDER_REFER r 
                
                inner join DAT_ORDER_REFER_PROGRESS p
        		on p.ORDER_REFER_NO = r.ORDER_REFER_NO
        		and p.ORDER_REFER_PROC_STS_NO = r.ORDER_REFER_PROC_STS_NO
        			 
        		left join DAT_ORDER_REFER_CLASS rc
        		on rc.ORDER_REFER_NO = r.ORDER_REFER_NO
        		and rc.USE_YN = 'Y'
        
                inner join DAT_ORDER_DELIV d
                on d.ORDER_NO = r.ORDER_NO
        
                inner join DAT_GOODS g
                on g.GOODS_CD = r.GOODS_CD
        
                inner join DAT_GOODS_IMAGE i
                on i.GOODS_CD = g.GOODS_CD
                and i.TYPE_CD = 'TITLE'
                
                left join DAT_GOODS_IMAGE_MD m
                on m.GOODS_CD = g.GOODS_CD
                and m.TYPE_CD = 'TITLE'
        
                inner join DAT_VENDOR_SUBVENDOR s
                on s.VENDOR_SUBVENDOR_CD = g.VENDOR_SUBVENDOR_CD
        
                where r.ORDER_REFER_NO = ?
        ";

        $row = $db->query($query, $param)->row_array();

        return $row;
    }

    /**
     * 에타 클래스 : 클래스 시간정보 변경
     *
     */
    public function orderClassMod( $param )
    {
        $mdb = self::_master_db();

        $mdb->trans_begin();

        $YNParam = array();
        $YNParam['USE_YN'] = 'N';
        self::update_data( 'DAT_ORDER_REFER_CLASS', $YNParam , " ORDER_REFER_NO = '".$param['ORDER_REFER_NO']."' " );

        $key = self::insert_table( 'DAT_ORDER_REFER_CLASS', $param );

        if ( $mdb->trans_status() === FALSE ){
            $mdb->trans_rollback();
            return false;
        }else{
            $mdb->trans_commit();
            return $key;
        }
    }

    /**
     * 에타 클래스 : 클래스 PROGRESS 수정
     *
     */
    public function orderClassProgressMod( $param )
    {
        $mdb = self::_master_db();

        $mdb->trans_begin();

        /*        $YNParam = array();
                $YNParam['USE_YN'] = 'N';
                self::update_data( 'DAT_ORDER_REFER_PROGRESS', $YNParam , " ORDER_REFER_NO = '".$param['ORDER_REFER_NO']."' AND ORDER_REFER_PROC_STS_CD = 'OB01' " );*/

        $key = self::insert_table( 'DAT_ORDER_REFER_PROGRESS', $param );

        if ( $mdb->trans_status() === FALSE ){
            $mdb->trans_rollback();
            return false;
        }else{
            $mdb->trans_commit();
            return $key;
        }
    }

    /**
     * 2019.10.10
     * 공방상품인지 체크.
     *
     * @param $goods_cd
     * @return mixed
     */
    public function check_class_goods($goods_cd)
    {
        $query="select    /*  > etah_mfront > order_m > check_class_goods > 공방상품인지 체크. */
                      g.GOODS_CD
                    , b.BRAND_NM
                    , s.VENDOR_SUBVENDOR_TEL 
                    , vc.MOB_NO
                    , vc.TEL
                from DAT_GOODS g 
                
                left outer join DAT_BRAND b
                on b.BRAND_CD = g.BRAND_CD
                and b.BRAND_CATEGORY_CD = '4010'
                
                inner join DAT_CATEGORY_MNG cm
                on g.CATEGORY_MNG_CD = cm.CATEGORY_MNG_CD
                and cm.PARENT_CATEGORY_MNG_CD = 24010000
                
                inner join DAT_VENDOR_SUBVENDOR s
                on s.VENDOR_SUBVENDOR_CD = g.VENDOR_SUBVENDOR_CD
                
                inner join DAT_VENDOR v
                on v.VENDOR_CD = s.VENDOR_CD
                
                left outer join DAT_VENDOR_CONTACT vc
                on vc.VENDOR_CD = v.VENDOR_CD
                
                where g.GOODS_CD = ?";

        $db = self::_slave_db();
        $row = $db->query($query, $goods_cd)->row_array();
        return $row;
    }
}