<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>美容室、理容店、サロン検索</title>
    <meta name="description" content="美容室、理容店、サロン検索">
    <meta name="google-site-verification" content="" />

    <link rel="shortcut icon" href="" />

    <script src="/plugin/jquery-3.4.0.min.js"></script>
    <script src="/plugin/jquery.cookie.js"></script>
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

<div id="content">
<div class="img_input">
  <input type="text" list="tag_list" value="" maxlength="50" id="tag_name" class="input_with">
  <datalist id="tag_list"></datalist>
  <img src="/img/icon/magnifier.png" alt="search" class="icon" id="search">
</div>
<div id="ad" style="text-align: center;"><iframe src="/htm/ad/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>

<table>
<?php foreach ($obj as $d) {?>
<tr>
  <td colspan="100" class="td_99_t">
    <a href="/Salon/Shop/index/<?=$prefecture?>/<?=$d->city?>/" ><?=$d->city?></a>
  </td>
</tr>
<?php } ?>
</table>
</div>
<div id="ad_right"><iframe src="/htm/ad_right/" width="160" height="600" frameborder="0" scrolling="no"></iframe></div>

<script>

</script>

<script>
  $(function(){ $(function(){ ga('send', 'pageview'); }); });
</script>
</body>
</html>
