<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?=date('Y/m/d',strtotime($date))?></title>
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
    <meta name="csrf-token" content="<?=csrf_token()?>" />
  </head>
<body>

<table id="drawer">
  <tr><td id="ad_menu"><iframe src="/htm/ad_menu/" width="300" height="250" frameborder="0" scrolling="no"></iframe></td></tr>
</table>
<style>
    input[name="group"]{
        display:none;
    }
    input[name="group"] + label {
        display:inline-block;
        width: 30%;
        padding: 10px 0px 10px 0px;
    }
    input[name="group"]:checked + label {
        display:inline-block;
        width: 30%;
        padding: 10px 0px 10px 0px;
        font-weight: bold;
        background-color: gray;
    }
    .joining {
        width: 80%;
        height: 120px;
        border: 1px solid #000000;
        display: inline-block;
        overflow: scroll;
        text-align: left;
    }
</style>
<div id="content">
    <div style="width:100%;text-align: center;">
        <select name='tag' style="height:30px;width:80%;">
            <option>タグ</option>
            <option value="1" style="background-color:rgba(0,0,255,0.2);">会議</option>
            <option value="2" style="background-color:rgba(0,128,0,0.2);">休み</option>
            <option value="3" style="background-color:rgba(255,255,0,0.2);">外出</option>
            <option value="4" style="background-color:rgba(255,0,0,0.2);">タスク</option>
            <option value="5" style="background-color:rgba(128,0,128,0.2);">シフト</option>
        </select><br>
        <input type="text" placeholder="タイトル" id="title" style="height:50px;width:80%;">
    </div>
    <div style="width:100%;text-align: center;">
        <?=date('m/d',strtotime($date))?>
        <select name='hour_start' style="height:30px;">
        <?php $hour = 0; while($hour < 24){?>
            <option><?=str_pad($hour,2,0,STR_PAD_LEFT)?></option>
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
            <option><?=str_pad($hour,2,0,STR_PAD_LEFT)?></option>
        <?php $hour++; }?>
        </select>
        <select name='minute_end' style="height:30px;">
        <?php $minute = 0; while($minute < 60){?>
            <option><?=str_pad($minute,2,0)?></option>
        <?php $minute = $minute + 15; }?>
        </select>
    </div>
    <div style="width:100%;text-align: center;">
        <textarea id="todo" style="width:90%;height:120px;" placeholder="内容"></textarea>
    </div>
    <div style="width:100%;text-align: center;">
        <input type="radio" name="group" value="0" id="public" v-model="group_radio">
        <label for="public"> 公開</label>
        <input type="radio" name="group" value="1" id="private" v-model="group_radio">
        <label for="private"> 非公開</label>
        <input type="radio" name="group" value="2" id="group" v-model="group_radio">
        <label for="group"> 一部</label><br>
        <div v-if="group_radio == 2">
        <select id="select_group" style="height:30px;width:80%;" oauth="people" >
            <option>所属グループ</option>
            <?php $i = 0; foreach($arr_group as $d){ if($d['category_id'] == 0){ ?>
            <option <?=$i == 0 ? 'selected' : '' ?> value="<?=$d['group_type_id']?>"><?=$d['group_name']?></option>
            <?php $i++; }}?>
        </select>
        <br>
        </div>
    </div>
    <br>
    <div style="width:100%;text-align: center;">
    <input type="button" value="登録・更新"　style="height:30px;width:80%;" id="submit">
    </div>
    <br>
    <div style="width:100%;text-align: center;">
    <div style="width:100%;display:inline-block;">
        <input type="text" placeholder="ユーザー検索" style="height:40px;">
        <img src="/img/icon/magnifier.png" id="search" oauth="people" class="icon">
        <select class="group" id="people_group" style="height:30px;width:80%;" oauth="people">
            <option disabled>所属グループ</option>
            <?php $i = 0; foreach($arr_group as $d){ if($d['category_id'] == 0){ ?>
            <option <?=$i == 0 ? 'selected' : '' ?> value="<?=$d['group_type_id']?>"><?=$d['group_name']?></option>
            <?php $i++; }}?>
        </select><br>
    </div>
    <div class="joining">
        <div>候補者</div>
    <template v-for="(d,k) in group_usrs">
        <label v-bind:for="d[0]"><div style="margin:5px;">
            <div style="width:80%;display:inline-block;">{{d[1]}}</div>
            <div style="width:10%;display:inline-block;">
                <input type="checkbox"　v-bind:value="d" v-model="join_usrs" v-bind:id="d[0]">
            </div></div></label>
    </template>
    </div>
    <div style="width:100%;">↓</div>
    <div class="joining">
    <template v-for="(d,k) in reverseUsrs">
        <div>{{d[1]}}</div>
    </template>
        <div>参加者</div>
    </div>
    </div>
    <br>
    <div style="width:100%;text-align: center;">
    <div style="width:100%;display:inline-block;">
        <select class="group" id="facility_group" style="height:30px;width:80%;" oauth="facility">
            <option disabled>施設カテゴリ</option>
            <?php $i = 0; foreach($arr_group as $d){ if($d['category_id'] == 1){ ?>
            <option <?=$i == 0 ? 'selected' : '' ?> value="<?=$d['group_type_id']?>"><?=$d['group_name']?></option>
            <?php $i++; }}?>
        </select><br>
    </div>
    <div class="joining">
    <div>候補施設　全て</div>
    <template v-for="(d,k) in group_facility">
        <label v-bind:for="d[0]" style='margin:5px;'>
            <div style="width:80%;display:inline-block;">{{d[1]}}</div>
            <div style="width:10%;display:inline-block;">
                <input type="checkbox"　v-bind:value="d" v-model="join_facility" v-bind:id="d[0]">
            </div></label>
    </template>
    </div>
    <div style="width:100%;">↓</div>
    <div class="joining">
    <template v-for="(d,k) in reverseFacility">
        <div>{{d[1]}}</div>
    </template>
        <div>利用施設</div>
    </div>
    </div>
    <a target="_blank" v-bind:href="'/Calendar/Space/hours12/<?=$date?>/'+checkSchedule+'/'">空き時間を確認</a>

    <br><br>
</div>

<div id="ad_right"><iframe src="/htm/ad_right/" width="160" height="600" frameborder="0" scrolling="no"></iframe></div>

<script>

var tag_color = ['','rgba(0,0,255,0.2)','rgba(0,128,0,0.2)','rgba(255,255,0,0.2)','rgba(255,0,0,0.2)','rgba(128,0,128,0.2)'];
//1=meeting, 2=off, 3=out, 4=task, 5=shift
var group_ids = '<?=$group_ids?>';
var date = '<?=$date?>';
var schedule_id = '<?=$schedule_id?>';
var content = new Vue({
  el: '#content',
  data: {
      join_usrs:[]
      ,group_usrs:[]
      ,join_facility:[]
      ,group_facility:[]
      ,group_radio:1
  },
  computed: {
    reverseUsrs() {
        return this.join_usrs.slice().reverse();
    },
    reverseFacility() {
        return this.join_facility.slice().reverse();
    },
    checkSchedule() {
        var arr = [];
        for (var i = 0; i < this.join_usrs.length; i++) {
            arr.push(this.join_usrs[i]);
        }
        for (var i = 0; i < this.join_facility.length; i++) {
            arr.push(this.join_facility[i]);
        }
        return encodeURIComponent(JSON.stringify(arr));
    },
  }
});
$('#submit').click(function(){
    console.log($('[name=tag]').val());
    console.log($('#title').val());
    console.log(date +' '+ $('[name=hour_start]').val() + ':' + $('[name=minute_start]').val() + ':00');
    console.log(date +' '+ $('[name=hour_end]').val() + ':' + $('[name=minute_end]').val() + ':00');
    console.log($('#todo').val());
    console.log(arr);
    console.log($('[name=group]:checked').val());
    console.log($('#select_group').val());
    var validate = 1;
    if($('[name=tag]').val()=='タグ'){
        $('[name=tag]').css({'border-color':'red'});
        validate=2;
    }else{
        $('[name=tag]').css({'border-color':''});
    }
    if($('#title').val()==''){
        $('#title').css({'border-color':'red'});
        validate=2;
    }else{
        $('#title').css({'border-color':''});
    }
    if($('#todo').val()==''){
        $('#todo').css({'border-color':'red'});
        validate=2;
    }else{
        $('#todo').css({'border-color':''});
    }
    if(validate==2){
      return;
    }
    var arr = [];
    for (var i = 0; i < content.join_usrs.length; i++) {
        arr.push(content.join_usrs[i]);
    }
    for (var i = 0; i < content.join_facility.length; i++) {
        arr.push(content.join_facility[i]);
    }
    var param = {
        _token : $('[name="csrf-token"]').attr('content')
        ,tag : $('[name=tag]').val()
        ,title : $('#title').val()
        ,time_start : date +' '+ $('[name=hour_start]').val() + ':' + $('[name=minute_start]').val() + ':00'
        ,time_end : date +' '+ $('[name=hour_end]').val() + ':' + $('[name=minute_end]').val() + ':00'
        ,todo : $('#todo').val()
        ,usrs : arr
        ,public : $('[name=group]:checked').val()
        ,group_id : $('#select_group').val()
        ,schedule_id : schedule_id
    }
    $.post('/Calendar/Update/',param,function(){},"json")
    .always(function(res){
        console.log(res);
    });
});
$('#search').click(function(){
    var param = {group_ids:JSON.parse(group_ids)};
    $.get('/Calendar/Get/searchUsr/'+$('#searchUsr').val() +'/'+$('#search').attr('oauth')+'/',param,function(){},"json")
    .always(function(res){
        content.group_usrs = res;
    });
});
groupChange($('#people_group option:selected').val(),'people');
groupChange($('#facility_group option:selected').val(),'facility');
$('.group').change(function(){
    var group_type_id = $(this).val();
    var oauth = $(this).attr('oauth');
    groupChange(group_type_id,oauth);
});
function groupChange(group_type_id,oauth){
    $.get('/Calendar/Get/groupUsr/'+group_type_id +'/'+oauth+'/',{},function(){},"json")
    .always(function(res){
        if(oauth == 'facility'){
            content.group_facility = res;
        }else{
            content.group_usrs = res;
        }
    });
}
//$(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>
