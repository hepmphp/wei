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

获取 id 为 tree 的 zTree 对象
var treeObj = $.fn.zTree.getZTreeObj("tree");
获取全部节点数据
var treeObj = $.fn.zTree.getZTreeObj("tree");
var nodes = treeObj.getNodes();
for(var i=0;i<nodes.length;i++){
alert(nodes[i].id); //获取每个节点的id
}
获取当前被勾选的节点集合
var treeObj = $.fn.zTree.getZTreeObj("treeMenu");
var nodes = treeObj.getCheckedNodes(true);
console.log(nodes);
for(var i=0;i<nodes.length;i++){
	alert(nodes[i].id); //获取每个节点的id
}
获取当前被选中的节点数据集合
var treeObj = $.fn.zTree.getZTreeObj("tree");
var nodes = treeObj.getSelectedNodes();
for(var i=0;i<nodes.length;i++){
alert(nodes[i].id); //获取每个节点的id
}*/

	</SCRIPT>
</html>