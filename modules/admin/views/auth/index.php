<?php
/**
 * File: index.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/8 14:28
 * Description: ztree
 */
$this->cs->registerPackage('ztree');
$this->cs->registerCss('ztree', '
.ztree li span.button.add{
    margin-left: 2px;
    margin-right: -1px;
    background-position: -144px 0;
    vertical-align: top;
}
');
$this->cs->registerScript('ztree', '
var setting = {
    async: {
        enable: true,
        url: "' . $asyncUrl . '",
        dataType: "JSON",
        autoParam:["id", "name", "level"],
        otherParam:{"operationType":"asyncLoad"},
        dataFilter: function(treeId, parentNode, response){
            if(response.status == 200){
                return response.data;
            }else{
                return [];
            }
        }
    },
    view: {
        expandSpeed:"fast",
        selectedMulti: false,
        addHoverDom: function(treeId, treeNode){
            var obj = $("#" + treeNode.tId + "_span");
            if(treeNode.editNameFlag || $("#addBtn_"+treeNode.tId).length>0) return;
            var addStr = "<span class=\"button add\" id=\"addBtn_" + treeNode.tId
                        + "\" title=\"添加\" onfocus=\"this.blur();\"></span>";
            obj.after(addStr);
            var btn = $("#addBtn_"+treeNode.tId);
            if(btn){
                btn.bind("click", function(){
                    if(confirm("确定要创建新节点吗？")){
                        $.post("' . $createUrl . '", {id:treeNode.id}, function(m){
                            $.facebox(m.info);
                            if(m.status == 200){
                                var zTree = $.fn.zTree.getZTreeObj(treeId);
                                zTree.addNodes(treeNode, m.data);
                            }
                        });
                    }
                });
            }
        },
        removeHoverDom: function(treeId, treeNode){
            $("#addBtn_"+treeNode.tId).unbind().remove();
        }
    },
    edit: {
        enable: true,
        removeTitle: "删除",
        showRemoveBtn: function(treeId, treeNode){
            return treeNode.level != 0;
        },
        showRenameBtn: false,
        drag: {
            isCopy: false,
            prev: false,
            next: false,
        }
    },
    data: {
        keep: {
            parent: true
        },
    },
    callback: {
        onClick: function(event, treeId, treeNode){
            admin.hide("#miniContent", 100, function($this){
                $.post("' . $editUrl . '", {id:treeNode.id},function(m){
                    if(m.status){
                        $.facebox(m.info);
                    }else{
                        $("#miniContent").html(m);
                    }
                    admin.show("#miniContent", 100);
                });
            });
        },
        beforeDrop: function(treeId, treeNodes, targetNode, moveType){
            if(targetNode){
                var treeNode = treeNodes[0];
                return confirm("确定要将["+treeNode.name+"]移动到["+targetNode.name+"]下吗？");
            }
            return false;
        },
        onDrop: function(event, treeId, treeNodes, targetNode, moveType){
            $.post("' . $editUrl . '",
                {operationType:"drop",id:treeNodes[0].id,tid:targetNode.id}, function(m){
                $.facebox(m.info);
            });
        },
        beforeRemove: function(treeId, treeNode){
            return confirm("确定要删除["+treeNode.name+"]吗？");
        },
        onRemove: function(event, treeId, treeNode){
            $.post("' . $removeUrl . '", {id:treeNode.id}, function(m){
                if(m.status){
                    $.facebox(m.info);
                }else{
                    $("#miniContent").html(m);
                }
            });
        }
    }
};

$.fn.zTree.init($("#auth"), setting);
')
?>
<div class="panel panel-default">
    <div class="panel-heading"><?php echo $name; ?></div>
    <div class="panel-body">
        <div class="container-fluid">
            <div class="raw">
                <div class="col-xs-3 col-sm-3 col-md-3">
                    <ul id="auth" class="ztree"></ul>
                </div>
                <div class="col-xs-9 col-sm-9 col-md-9" id="miniContent"></div>
            </div>
        </div>
    </div>
</div>