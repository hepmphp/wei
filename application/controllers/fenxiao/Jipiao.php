<?php
namespace controllers\fenxiao;
use base;
use base\BaseController;
use helpers\Tools;
use models\Jipiao\Passenger;
use helpers\Arr;
use models\Table;
class Jipiao extends BaseController{
    protected $render_engine= 'Smarty';
    public function index(){

        echo $this->render_engine;
        echo __METHOD__;
        $data = array(
            'test'=>100,
            'test2'=>200,
            'test3'=>300,
        );
        $this->view->assign($data);
        $this->view->display('fenxiao/jipiao_index');
    }

    public function test_list(){
        $m_jp_order = new Table\Order();
        $where = [
            "AND"=>[
                'order_date[>]'=>time()-100*86400,
                'order_date[<]'=>time()+100*86400,
             ],
            'LIMIT'=>10,
        ];
        $order_list = $m_jp_order->get_list($where,'*');
        $m_jp_order->fill_list($order_list);
        echo "<pre>";
        print_r($order_list);
    }

    public function test_detail(){
        $m_jp_order = new Table\Order();
        $id = 1021;
        $where = array('id'=>$id);
        $detail = $m_jp_order->find($where);
        $m_jp_order->fill_detail($detail);
        echo "<pre>";
        print_r($detail);
    }

    public function gss_list(){
        $m_order_gss = new Table\Ordergss();
        //乘机人 会员名 PNR 订单号 gss订单号 票号票号 预订日期 2016-08-09 2016-08-16 订单状态 订单来源
        // $search_params['psgr_name'] = '黄少雄';
        $relate_where['ticket_no'] = '7814565546545';
        $where = [
            'AND'=>[
                'id[>]'=>1,
                'id[<]'=>100,
            ],
            'LIMIT'=>10,
        ];
        $m_order_gss->fill_search($where,$relate_where);//填充关联查询
        $order_gss_list = $m_order_gss->get_list($where,'*');
        $m_order_gss->fill_list($order_gss_list);        
        echo "<pre>";
        print_r($order_gss_list);    
    }

    public function test_model(){
        $m_passenger = new Passenger();
        $passenger = $m_passenger->db->get('cgfx_jipiao_passenger','*',array('id'=>1));
        $passenger = $m_passenger->db->get('cgfx_jipiao_passenger','*',array('id'=>1));
        $passenger = $m_passenger->db->get('cgfx_jipiao_passenger','*',array('id'=>1));
        echo "<Pre>";
        print_R($passenger);
    }
    public function booking(){
        echo  __METHOD__;
    }

    public function db(){
        /*
         *
         *  ��ȡ��һ�����ݵĵ�һ��
            ��ȡ��һ������
            ��ȡ��������
            ��ȡ�������� ��ĳһ����Ϊ����
            ��ȡһ������ ���л���ĳһ��
            ��ȡ��ֵ������  ���� id ֵ��Ϊ�����ļ�ֵ�� title ��Ϊֵ�����飬���� $db->get_pairs("SELECT id, title FROM article");
         */
        $db = base\Application::get_db();
        echo "<pre>";
        print_r($db);
        //ȡһ��
        $one = $db->get('cgfx_jipiao_order','*',array('id'=>2));
        //ȡһ�е�ĳһ��
        $one_col = $db->get('cgfx_jipiao_order','id',array('id'=>2));

//        $all = $db->select('cgfx_jipiao_order','*',array('id[<]'=>5));
//        $all = $db->select('cgfx_jipiao_order','*',array('#id[!]'=>[2,4],'LIMIT'=>1));
//        $all = $db->select('cgfx_jipiao_order','order_id',['id'=>[1,2,3,4,5]]);//where_in��ѯ
//        $all = $db->select('cgfx_jipiao_order','order_id',['id'=>'1']);//where
//        $all = $db->select('cgfx_jipiao_order','*',['id'=>'1']);
//        $all = $db->select('cgfx_jipiao_order','*',['linkMan[~]'=>'��','LIMIT'=>1]);
        $all = $db->select('cgfx_jipiao_order','*',['AND'=>['id[>]'=>1,'linkMan[~]'=>'��'],'LIMIT'=>100]);
        print_r($db->log());
        print_r($one);
        print_r($one_col);
        print_r($all);

    }
}