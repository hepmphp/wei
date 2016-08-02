<html>
<head>
	<link rel="stylesheet" href="<?=SITE_URL?>/static/plugin/ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
	<script type="text/javascript" src="<?=SITE_URL?>/static/plugin/ztree/js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="<?=SITE_URL?>/static/plugin/ztree/js/jquery.ztree.core.js"></script>
	<script type="text/javascript" src="<?=SITE_URL?>/static/plugin/ztree/js/jquery.ztree.excheck.js"></script>
</head>


<div class="zTreeDemoBackground left">
		<ul id="treeMenu" class="ztree"></ul>
</div>
	
<SCRIPT type="text/javascript">

		var setting = {
			view: {
				selectedMulti: false
			},
			check: {
				enable: true
			},
			data: {
				simpleData: {
					enable: true
				}
			},
		};

		var zNodes = <?=$menu_json?>;
		$(document).ready(function(){
			$.fn.zTree.init($("#treeMenu"), setting, zNodes);
		});
/*

��ȡ id Ϊ tree �� zTree ����
var treeObj = $.fn.zTree.getZTreeObj("tree");
��ȡȫ���ڵ�����
var treeObj = $.fn.zTree.getZTreeObj("tree");
var nodes = treeObj.getNodes();
for(var i=0;i<nodes.length;i++){
alert(nodes[i].id); //��ȡÿ���ڵ��id
}
��ȡ��ǰ����ѡ�Ľڵ㼯��
var treeObj = $.fn.zTree.getZTreeObj("treeMenu");
var nodes = treeObj.getCheckedNodes(true);
console.log(nodes);
for(var i=0;i<nodes.length;i++){
	alert(nodes[i].id); //��ȡÿ���ڵ��id
}
��ȡ��ǰ��ѡ�еĽڵ����ݼ���
var treeObj = $.fn.zTree.getZTreeObj("tree");
var nodes = treeObj.getSelectedNodes();
for(var i=0;i<nodes.length;i++){
alert(nodes[i].id); //��ȡÿ���ڵ��id
}*/

	</SCRIPT>
</html>