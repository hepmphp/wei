<?php
namespace controllers\test;
use base\BaseController;
use models\Jipiao\Passenger;
class Tree extends BaseController{
    protected $render_engine= 'php';
    public function index(){
	    $m_passenger = new Passenger();
	 	$db = $m_passenger->db;
        $admin_menus = $db->select('cgfx_admin_menu','*');
        foreach($admin_menus as $menu){
			$data_menus[] = array(
				'id'=>$menu['mid'],
				'pId'=>$menu['parent_id'],
				'name'=>iconv('gbk','utf-8',$menu['menu_name']),
				'open'=>false,
			);
		}
		$data['menu_json'] = json_encode($data_menus,true);
        $this->view->assign($data);
        $this->view->display('test/tree_index');
    }

    public function test_model(){
      
        $passenger = $m_passenger->db->get('cgfx_jipiao_passenger','*',array('id'=>1));
        $passenger = $m_passenger->db->get('cgfx_jipiao_passenger','*',array('id'=>1));
        $passenger = $m_passenger->db->get('cgfx_jipiao_passenger','*',array('id'=>1));
        echo "<Pre>";
        print_R($passenger);
    }

    public function booking(){
        echo  __METHOD__;
    }
}