<?php
/**
 * File: statistics.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/6/9 12:51
 * Description: 统计
 */
$this->cs->registerScript('echarts', "
function getSaleStockOption(data){
    return  {
        title:{
            text:data.title,
        },
        legend: {
            data: ['出货', '进货'],
            x:'right'
        },
        tooltip: {
            trigger: 'axis',
        },
        xAxis: [
            {
                data: data.xAxis,
            }
        ],
        yAxis: [],
        series: [
            {
                name: '出货',
                type: 'line',
                data: data.sales
            },
            {
                name: '进货',
                type: 'line',
                data: data.stock
            }
        ]
    };
}

function getYear(charts){
    charts.showLoading({
        text: '正在努力的读取数据中...',
    });
    $.get('/admin/cargo/statistics',{operationType:'year'},function(res){
        if(res.status == 200){
            var option = getSaleStockOption(res.data);
            charts.clear()
            charts.setOption(option);
        }
        charts.hideLoading();
    });
}

function getMonth(charts, year){
    charts.showLoading({
        text: '正在努力的读取数据中...',
    });
    $.get('/admin/cargo/statistics',{operationType:'month', year:year},function(res){
        if(res.status == 200){
            var option = getSaleStockOption(res.data);
            charts.clear()
            charts.setOption(option);
        }
        charts.hideLoading();
    });
}


function getDay(charts, year, month){
    charts.showLoading({
        text: '正在努力的读取数据中...',
    });
    $.get('/admin/cargo/statistics',{operationType:'day', year:year, month:month},function(res){
        if(res.status == 200){
            var option = getSaleStockOption(res.data);
            charts.clear()
            charts.setOption(option);
        }
        charts.hideLoading();
    });
}

$('#form').on('click','a',function(){
    var form = $('#form');
    var yearData = form.find('select[name=year]').val();
    var monthData = form.find('select[name=month]').val();
    console.log(yearData);
    console.log(monthData);
    if(monthData == 0){
        getMonth(day, yearData);
    }else{
        getDay(day, yearData, monthData);
    }
    return false;
});

var day = echarts.init(document.getElementById('taxi7-day'));
var month = echarts.init(document.getElementById('taxi7-month'));
var year = echarts.init(document.getElementById('taxi7-year'));
var myDate = new Date();
getDay(day, myDate.getFullYear(), myDate.getMonth()+1)
getMonth(month, myDate.getFullYear());
getYear(year);
");
?>
<div class="panel panel-default">
    <div class="panel-heading">统计报表</div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'form',
            'htmlOptions' => array(
                'class' => 'form-horizontal'
            )
        )); ?>
        <div class="form-group">
            <?php echo CHtml::label('日期', 'datetime', array('class' => 'col-xs-3 col-sm-2 col-md-1 control-label')); ?>
            <div class="col-xs-3 col-sm-2 col-md-2">
                <?php echo CHtml::dropDownList('year', date('Y'), $year, array('class' => 'form-control')) ?>
            </div>
            <div class="col-xs-3 col-sm-2 col-md-2">
                <?php echo CHtml::dropDownList('month', date('n'), $month, array('class' => 'form-control')) ?>
            </div>
            <div class="col-xs-4 col-sm-2 col-md-1">
                <?php echo CHtml::link('统计', '##', array('class' => 'btn btn-default')); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <div class="col-md-12">
            <div id="taxi7-day" style="width:800px; height:400px; margin: 0 auto;"></div>
        </div>
        <div class="col-md-12">
            <div id="taxi7-month" style="width:800px; height:400px; margin: 0 auto;"></div>
        </div>
        <div class="col-md-12">
            <div id="taxi7-year" style="width:800px; height:400px; margin: 0 auto;"></div>
        </div>
    </div>
</div>
