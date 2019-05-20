<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?=$m_group->group_name?></title>
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
    .centerize {
        width: 100%;
        text-align: center;
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
    <div class="centerize">
    <input type="text" placeholder="グループ名" id="group_name" value="<?=$m_group->group_name?>" style="height:50px;width:80%;">
    <br><br>
    <select name='category_id' style="height:30px;width:80%;">
        <option value="0" <?=$people?> >人</option>
        <option value="1" <?=$facility?> >施設</option>
    </select><br><br>
    <a v-bind:href="'/test/auth/'+password+'/'" target="_blank" id="password">{{password}}</a>
    &nbsp;&nbsp;<img src="/img/icon/pencil.png" class="icon" id="shuffle">
    </div>

    <br>
    <br>
    <div class="centerize">
    <div style="width:100%;display:inline-block;">
        <input type="text" placeholder="ユーザー検索" style="height:40px;">
        <img src="/img/icon/magnifier.png" id="search" oauth="people" class="icon">
        <select class="group" id="people_group" style="height:30px;width:80%;" oauth="people">
            <option disabled>所属グループ</option>
            <?php $i = 0; foreach($arr_group as $d){ if($d['category_id'] == 0){ ?>
            <option <?=$i == 0 ? 'selected' : '' ?> value="<?=$d['group_id']?>"><?=$d['group_name']?></option>
            <?php $i++; }}?>
        </select><br>
    </div>
    <div class="joining">
        <div>候補者</div>
    <template v-for="(d,k) in group_usrs">
        <label v-bind:for="d[0]"><div style="margin:5px;">
            <div style="width:80%;display:inline-block;">{{d[1]}}</div>
            <div style="width:10%;display:inline-block;">
                <input type="checkbox"　v-bind:value="d[0]" v-model="arr_usrs" v-bind:id="d[0]">
            </div></div></label>
    </template>
    </div>
    <div class="centerize">↓</div>
    <div class="joining">
        <div>参加者</div>
    <template v-for="(d,k) in reverseUsrs">
        <div style="display:inline-block;">{{d[1]}}</div>
        <div style="display:inline-block;">
            <input type="checkbox" v-bind:checked="d[2]" v-model="d[2]"></div>
        <br>
    </template>
    </div>
    </div>
    <br>
    <div class="centerize">
    <div style="width:100%;display:inline-block;">
        <select class="group" id="facility_group" style="height:30px;width:80%;" oauth="facility_owner">
            <option disabled>施設カテゴリ</option>
            <?php $i = 0; foreach($arr_group as $d){ if($d['category_id'] == 1){ ?>
            <option <?=$i == 0 ? 'selected' : '' ?> value="<?=$d['group_id']?>"><?=$d['group_name']?></option>
            <?php $i++; }}?>
        </select><br>
    </div>
    <div class="joining">
    <div>候補施設　全て</div>
    <template v-for="(d,k) in group_facility">
        <label v-bind:for="d[0]" style='margin:5px;'>
            <div style="width:80%;display:inline-block;">{{d[1]}}</div>
            <div style="width:10%;display:inline-block;">
                <input type="checkbox"　v-bind:value="d[0]" v-model="arr_facility" v-bind:id="d[0]">
            </div></label>
    </template>
    </div>
    <div class="centerize">↓</div>
    <div class="joining">
    <template v-for="(d) in reverseFacility">
        <div>{{d[1]}}  --- {{d[2]}}</div>
    </template>
        <div>利用施設</div>
    </div>
    </div>
    <br>
    <div class="centerize">
    <input type="button" value="登録・更新"　style="height:30px;width:80%;" id="submit">
    </div>
</div>
<br>
<div id="ad_right"><iframe src="/htm/ad_right/" width="160" height="600" frameborder="0" scrolling="no"></iframe></div>

<script>
var usr_id = <?=$usr_id?>;
var usrs = <?=$usrs?>;
var content = new Vue({
  el: '#content',
  data: {
      password:'<?=$m_group->password?>'
      ,usrs : usrs
      ,group_usrs:[]
      ,arr_usrs: []
      ,join_usrs:[]
      ,group_facility:[]
      ,arr_facility:[]
      ,join_facility:[]
  },
  computed: {
    reverseUsrs() {
        var join = [];
        var i = 0;
        for (var k in this.arr_usrs) {
            if(this.group_usrs[this.arr_usrs[k]]){
                join[i] = this.group_usrs[this.arr_usrs[k]];
                i++;
            } else {  //nor group_usrs but join_usrs has. it should show
                for (var i2=0; this.join_usrs.length > i2; i2++) {
                    if(this.join_usrs[i2][0] == this.arr_usrs[k]){
                        join[i] = this.join_usrs[i2];
                        i++;
                    }
                }
            }
        }
        this.join_usrs = join;
        return this.join_usrs.slice().reverse();
    },
    reverseFacility() {
        var join = [];
        var i = 0;
        for (var k in this.arr_facility) {
            if(this.group_facility[this.arr_facility[k]]){
                join[i] = this.group_facility[this.arr_facility[k]];
                i++;
            } else {  //nor group_facility but join_facility has. it should show
                for (var i2=0; this.join_facility.length > i2; i2++) {
                    if(this.join_facility[i2][0] == this.arr_facility[k]){
                        join[i] = this.join_facility[i2];
                        i++;
                    }
                }
            }
        }
        this.join_facility = join;
        return this.join_facility.slice().reverse();
    },
  },
  methods : {
//    del : function(index){
//      this.usrs.splice(index, 1);
//    }
  },
});

function randomString(length) {
    var result = '';
    var length = 16
    var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;
}
content.password = content.password ? content.password : randomString(16);
$('#shuffle').click(function(){
    content.password = randomString(16);
});

$('#submit').click(function(){
    console.log(content.join_facility);
});

$('#search').click(function(){
    var param = {group_ids:JSON.parse(group_ids)};
    $.get('/Calendar/Get/searchUsr/'+$('#searchUsr').val() +'/'+$('#search').attr('oauth')+'/',param,function(){},"json")
    .always(function(res){
        content.group_usrs = res;
    });
});
groupChange($('#people_group option:selected').val(),'people');
groupChange($('#facility_group option:selected').val(),'facility_owner');
$('.group').change(function(){
    var group_id = $(this).val();
    var oauth = $(this).attr('oauth');
    groupChange(group_id,oauth);
});
function groupChange(group_id,oauth){
    $.get('/Calendar/Get/groupUsr/'+group_id +'/'+oauth+'/',{},function(){},"json")
    .always(function(res){
        if(oauth == 'facility_owner'){
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