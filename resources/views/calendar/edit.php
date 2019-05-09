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
<div id="content">
    <div style="width:100%;text-align: center;">
        <select name='tag' style="height:30px;width:80%;">
            <option>タグ</option>
            <option style="background-color:rgba(0,0,255,0.2);">会議</option>
            <option style="background-color:rgba(0,128,0,0.2);">休み</option>
            <option style="background-color:rgba(255,255,0,0.2);">外出</option>
            <option style="background-color:rgba(255,0,0,0.2);">タスク</option>
            <option style="background-color:rgba(128,0,128,0.2);">シフト</option>
        </select><br>
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
        <?php $hour = 0; while($hour < 24){?>
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

    <div style="width:100%;text-align: center;">
    <div style="width:100%;display:inline-block;">
        <input type="text" placeholder="ユーザー検索" id="searchUsr" style="height:40px;" oauth="facility">
        <img src="/img/icon/magnifier.png" id="search" class="icon">
        <select class="group" style="height:30px;width:80%;" oauth="facility">
            <option>所属グループ</option>
            <?php $i = 0; foreach($arr_group as $d){ if($d['category_id'] == 1){ ?>
            <option <?=$i == 0 ? 'selected' : '' ?> value="<?=$d['group_type_id']?>"><?=$d['group_name']?></option>
            <?php $i++; }}?>
        </select><br>
    </div>
    <div style="width:80%;height:120px;border:1px solid #000000;display:inline-block;overflow: scroll;">
        <div>候補者</div>
    <template v-for="(d,k) in group_usrs">
        <label v-bind:for="d[0]"><div style="margin:10px;">
            <div style="width:80%;display:inline-block;">{{d[1]}}</div>
            <div style="width:10%;display:inline-block;">
                <input type="checkbox"　v-bind:value="d" v-model="join_usrs" v-bind:id="d[0]">
            </div></div></label>
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
    <br>
    <input type="button" value="test check" id="checkArr">
</div>

<div id="ad_right"><iframe src="/htm/ad_right/" width="160" height="600" frameborder="0" scrolling="no"></iframe></div>

<script>

var tag_color = ['','rgba(0,0,255,0.2)','rgba(0,128,0,0.2)','rgba(255,255,0,0.2)','rgba(255,0,0,0.2)','rgba(128,0,128,0.2)'];
//1=meeting, 2=off, 3=out, 4=task, 5=shift
var group_ids = '<?=$group_ids?>';
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

$('.group').change(function(){
    $.get('/Calendar/Get/groupUsr/'+$(this).val() +'/'+$(this).attr('oauth')+'/',{},function(){},"json")
    .always(function(res){
        content.group_usrs = res;
    });
});
$('#search').click(function(){
    var param = {group_ids:JSON.parse(group_ids)};
    $.get('/Calendar/Get/searchUsr/'+$('#searchUsr').val() +'/'+$(this).attr('oauth')+'/',param,function(){},"json")
    .always(function(res){
        content.group_usrs = res;
    });
});
$('#checkArr').click(function(){
    console.log(content.join_usrs);
    console.log(content.join_usrs[0][0]);    
});
//$(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>
