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
        var_dump($where);
        $order_list = $m_jp_order->get_list($where,'*');
        $order_list = $m_jp_order->get_relate_tables($order_list);
        echo "<pre>";
        print_r($order_list);
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
            ��ȡ��ֵ������  ���� id ֵ��Ϊ����ļ�ֵ�� title ��Ϊֵ�����飬���� $db->get_pairs("SELECT id, title FROM article");
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