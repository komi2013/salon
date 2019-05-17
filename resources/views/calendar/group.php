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
    <table>
    <tr v-for="(d,k) in group_usr">
        <td>{{d['usr_name']}}</td>
        <td><input type="checkbox" v-bind:checked="d['owner_flg']"></td>
        <td><img src="/img/icon/trash.png" class="icon"></td>
    </tr>
    </table>
</div>
<br>
<div id="ad_right"><iframe src="/htm/ad_right/" width="160" height="600" frameborder="0" scrolling="no"></iframe></div>

<script>

var content = new Vue({
  el: '#content',
  data: {
      password:'<?=$m_group->password?>'
      ,group_usr : <?=$group_usr?>
  },
  computed: {
    reverseUsrs() {},
  }
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
console.log(content.group_usr);

//$(function(){ ga('send', 'pageview'); });
</script>
</body>
</html>
