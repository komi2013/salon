<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>My Calendar</title>
    <meta name="description" content="美容室、理容店、サロン検索">
    <meta name="google-site-verification" content="" />

    <link rel="shortcut icon" href="" />

    <script src="/plugin/jquery-3.4.0.min.js"></script>
    <script src="/plugin/jquery.cookie.js"></script>
    <script src="/plugin/vue.min.js"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-57298122-3"></script>
    <script src="/js/analytics.js<?=config('my.cache_v')?>"></script>
    <link rel="stylesheet" type="text/css" href="/css/basic.css<?=config('my.cache_v')?>" />
    <link rel="stylesheet" href="/css/pc.css<?=config('my.cache_v')?>" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/css/sp.css<?=config('my.cache_v')?>" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<table id="drawer">
  <tr><td id="ad_menu"><iframe src="/htm/ad_menu/" width="300" height="250" frameborder="0" scrolling="no"></iframe></td></tr>
</table>
    <style>

    </style>
    <div style="width:100%;text-align: center;">
        <select name='tag' style="height:30px;width:80%;">
            <option>タグ</option>
            <option style="background-color:rgba(0,0,255,0.2);">会議</option>
            <option style="background-color:rgba(0,0,255,0.2);">休み</option>
            <option style="background-color:rgba(0,0,255,0.2);">外出</option>
            <option style="background-color:rgba(0,0,255,0.2);">タスク</option>
            <option style="background-color:rgba(0,0,255,0.2);">シフト</option>
        </select><br>
var tag_color = ['','rgba(0,0,255,0.2)','rgba(0,128,0,0.2)','rgba(255,255,0,0.2)','rgba(255,0,0,0.2)','rgba(128,0,128,0.2)'];
        <input type="text" placeholder="タイトル" value="" style="height:50px;width:80%;">
    </div>
    <div style="width:100%;text-align: center;">
        <?=date('m/d',strtotime($date))?>
        <select name='hour_start' style="height:30px;">
        <?php $hour = 0; while($hour < 25){?>
            <option><?=str_pad($hour,2,0)?></option>
        <?php $hour++; }?>
        </select>
        <select name='minute_start' style="height:30px;">
        <?php $minute = 0; while($minute < 60){?>
            <option><?=str_pad($minute,2,0)?></option>
        <?php $minute = $minute + 15; }?>
        </select>
        <span>~</span>
        <select name='hour_end' style="height:30px;">
        <?php $hour = 0; while($hour < 25){?>
            <option><?=str_pad($hour,2,0)?></option>
        <?php $hour++; }?>
        </select>
        <select name='minute_end' style="height:30px;">
        <?php $minute = 0; while($minute < 60){?>
            <option><?=str_pad($minute,2,0)?></option>
        <?php $minute = $minute + 15; }?>
        </select>
    </div>
    <div style="width:100%;text-align: center;">
    <textarea style="width:90%;height:120px;"></textarea>
    </div>
<div id="content">
    <div style="width:100%;text-align: center;">
    <div style="width:100%;display:inline-block;">
        <select style="height:30px;width:80%;">
            <option>所属グループ</option>
            <option v-for="(d,k) in group_usrs">
                {{d[1]}}
            </option>
        </select><br>
        <input type="text" placeholder="ユーザー検索" style="height:40px;"><img src="/img/icon/magnifier.png" class="icon">
    </div>
    <div style="width:80%;height:120px;border:1px solid #000000;display:inline-block;overflow: scroll;">
        <div>候補者</div>
    <template v-for="(d,k) in group_usrs">
        <div style="margin:10px;">
            <div style="width:80%;display:inline-block;">{{d[1]}}</div>
            <div style="width:10%;display:inline-block;">
                <input type="checkbox"　v-bind:value="d" v-model="join_usrs" v-id="d[0]">
            </div></div>
    </template>
    </div>
    <div style="width:100%;">↓</div>
    <div style="width:80%;height:120px;border:1px solid #000000;display:inline-block;overflow: scroll;">
    <template v-for="(d,k) in reverseUsrs">
        <div>{{d[1]}}</div>
    </template>
        <div>参加者</div>
    </div>
    </div>
    <div style="width:80%;height:120px;border:1px solid #000000;display:inline-block;overflow: scroll;">
    <template v-for="(d,k) in group_facility">
        <div style="margin:10px;">
            <div style="width:80%;display:inline-block;">{{d[1]}}</div>
            <div style="width:10%;display:inline-block;">
                <input type="checkbox"　v-bind:value="d" v-model="join_usrs" v-id="d[0]">
            </div></div>
    </template>
    </div>
    <div style="width:100%;text-align:center;">↓</div>
    <div style="width:80%;height:120px;border:1px solid #000000;display:inline-block;overflow: scroll;">
    <template v-for="(d,k) in join_facility">
        <div>{{d[1]}}</div>
    </template>
    </div>
    <br>
    <input type="button" id="checkArr">
</div>

<div id="ad_right"><iframe src="/htm/ad_right/" width="160" height="600" frameborder="0" scrolling="no"></iframe></div>

<script>

var tag_color = ['','rgba(0,0,255,0.2)','rgba(0,128,0,0.2)','rgba(255,255,0,0.2)','rgba(255,0,0,0.2)','rgba(128,0,128,0.2)'];
//1=meeting, 2=off, 3=out, 4=task, 5=shift
var obj = {
    agenda:'新規作成'
    ,time_start:'00:00'
    ,time_end:'00:00'
    ,todo:'...'
    ,file_paths:''
}
var content = new Vue({
  el: '#content',
  data: {
      join_usrs:[]
      ,group_usrs:[['11','test1'],['12','test2'],['13','test3'],['14','test4'],['15','test5'],['16','test6'],['17','test7']]
      ,join_facility:[]
      ,group_facility:[]
  },
  computed: {
    reverseUsrs() {
        return this.join_usrs.slice().reverse();
    },
  }
});
var today = '';
console.log(today);
var month = '';

$.get('/Calendar/My/index/'+month +'/',{},function(){},"json")
.always(function(res){
    for (var i1 in res) {
        var arr = ['','','','','','','','','',''];
        var i3 = 0;
        for (var i2 in res[i1]) {
            
            var start_basic = 9;
            var time0 = new Date(i1 +" "+(start_basic+1)+":00:00");
            var time1 = new Date(i1 +" "+(start_basic+2)+":00:00");
            var time2 = new Date(i1 +" "+(start_basic+3)+":00:00");
            var time3 = new Date(i1 +" "+(start_basic+4)+":00:00");
            var time4 = new Date(i1 +" "+(start_basic+5)+":00:00");
            var time5 = new Date(i1 +" "+(start_basic+6)+":00:00");
            var time6 = new Date(i1 +" "+(start_basic+7)+":00:00");
            var time7 = new Date(i1 +" "+(start_basic+8)+":00:00");
            var time8 = new Date(i1 +" "+(start_basic+9)+":00:00");
            var time_start = new Date(i1 +" "+res[i1][i2]['time_start']);
            console.log(res[i1][i2]['time_start']);
            if(time_start < time0){
                i3 = 0;
            } else if(time_start < time1){
                i3 = 1;       
            } else if(time_start < time2){
                i3 = 2;
            } else if(time_start < time3){
                i3 = 3;
            } else if(time_start < time4){
                i3 = 4;
            } else if(time_start < time5){
                i3 = 5;
            } else if(time_start < time6){
                i3 = 6;
            } else if(time_start < time7){
                i3 = 7;
            } else if(time_start < time8){
                i3 = 8;
            } else if(time_start > time8){
                i3 = 9;
            }
            while(i3 < 10){
                if(i3 == 9 && arr[i3]){
                    var i4 = 9;
                    while(arr[i4]){
                        i4--;
                    }
                    while(i4 < 10){
                        arr[i4] = arr[i4+1];
                        i4++;
                    }
                }
                if(!arr[i3]){
                    arr[i3] = res[i1][i2]['tag'];
                    i3 = 10;
                }
                i3++;
            }
            for (var i5 in arr) {
                $('.d-'+i1+'-'+i5).css({'background-color': tag_color[arr[i5]]});
            }
        }
    }
    $('td').click(function(){
        showDetail(res,$(this).attr('date'));
        content.detail = res[$(this).attr('date')];
    });
//    console.log(month + '' + today);
    showDetail(res,today);
});

function showDetail(d,date){
    console.log(d[date]);
    if(d[date]){
        content.detail = d[date];
    }

}
$('#checkArr').click(function(){
    console.log(content.join_usrs);
    console.log(content.join_usrs[0][0]);    
});
//$(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>
