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
        <?php $hour = 0; while($hour < 24){?>
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
        <textarea style="width:90%;height:120px;" placeholder="内容"></textarea>
    </div>

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
    <div style="width:100%;text-align: center;">
    <div style="width:100%;display:inline-block;">
        <select class="group" id="facility_group" style="height:30px;width:80%;" oauth="facility">
            <option disabled>施設カテゴリ</option>
            <?php $i = 0; foreach($arr_group as $d){ if($d['category_id'] == 1){ ?>
            <option <?=$i == 0 ? 'selected' : '' ?> value="<?=$d['group_type_id']?>"><?=$d['group_name']?></option>
            <?php $i++; }}?>
        </select><br>
    </div>
    <div style="width:80%;height:120px;border:1px solid #000000;display:inline-block;overflow: scroll;">
        <div>候補施設</div>
    <template v-for="(d,k) in group_facility">
        <label v-bind:for="d[0]" style='display: inline;'>
            <span style="width:80%;display:inline-block;">{{d[1]}}</span>
            <span style="width:10%;display:inline-block;">
                <input type="checkbox"　v-bind:value="d" v-model="join_facility" v-bind:id="d[0]">
            </span></label>
    </template>
    </div>
    <div style="width:100%;">↓</div>
    <div style="width:80%;height:120px;border:1px solid #000000;display:inline-block;overflow: scroll;">
    <template v-for="(d,k) in reverseFacility">
        <div>{{d[1]}}</div>
    </template>
        <div>利用施設</div>
    </div>
    </div>
    <a target="_blank" v-bind:href="'/Calendar/Space/hours12/<?=$date?>/'+checkSchedule+'/'">空き時間を確認</a>
    <div style="width:100%;text-align: center;">
        <input type="radio" name="group" value="0" id="public" v-model="group_radio">
        <label for="public"> 公開</label>
        <input type="radio" name="group" value="1" id="private" v-model="group_radio">
        <label for="private"> 非公開</label>
        <input type="radio" name="group" value="2" id="group" v-model="group_radio">
        <label for="group"> 一部</label><br>
        <select class="group" style="height:30px;width:80%;" oauth="people" v-if="group_radio == 2">
            <option>所属グループ</option>
            <?php $i = 0; foreach($arr_group as $d){ if($d['category_id'] == 0){ ?>
            <option <?=$i == 0 ? 'selected' : '' ?> value="<?=$d['group_type_id']?>"><?=$d['group_name']?></option>
            <?php $i++; }}?>
        </select><br>
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
//        console.log(arr);
        return encodeURIComponent(JSON.stringify(arr));
    },
  }
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
$('#search').click(function(){
    var param = {group_ids:JSON.parse(group_ids)};
    $.get('/Calendar/Get/searchUsr/'+$('#searchUsr').val() +'/'+$('#search').attr('oauth')+'/',param,function(){},"json")
    .always(function(res){
        content.group_usrs = res;
    });
});
$('#checkArr').click(function(){
    var arr = [];
    for (var i = 0; i < content.join_usrs.length; i++) {
        arr.push(content.join_usrs[i]);
    }
    for (var i = 0; i < content.join_facility.length; i++) {
        arr.push(content.join_facility[i]);
    }
    console.log(encodeURIComponent(arr));
    console.log(JSON.stringify(arr));
});
//$(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>
