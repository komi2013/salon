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
    <script>var ua = '<?=config('my.ua')?>';</script>
    <script src="/assets/js/analytics.js<?=config('my.cache_v')?>"></script>
    <link rel="stylesheet" type="text/css" href="/css/basic.css<?=config('my.cache_v')?>" />
    <link rel="stylesheet" href="/css/pc.css<?=config('my.cache_v')?>" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/css/sp.css<?=config('my.cache_v')?>" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
<?php $this_page = ''; ?>
<table id="header">
    
<tr>
  <td>
    <img src="/assets/img/icon/menu.png" class="icon" id="menu">
  </td>
  <td id="page_news" class="<?= $this_page == 'news' ? 'this_page' : '' ?>" style="position: relative;">
    <a href="/htm/news/" rel="nofollow"><span id="news_num"></span><img src="/assets/img/icon/mail.png" class="icon"></a>
  </td>
  <td id="page_forumlist" class="<?= $this_page == 'forumlist'  ? 'this_page' : '' ?>">
    <a href="/forumlist/" rel="nofollow" ><img src="/assets/img/icon/list.png" class="icon"></a>
  </td>
  <td id="page_rank" class="<?= $this_page == 'rank'  ? 'this_page' : '' ?>" >
    <a href="/rank/" ><img src="/assets/img/icon/ranking.png" alt="rank" class="icon"></a>
  </td>
  <td id="page_myprofile" class="<?= $this_page == 'myprofile' ? 'this_page' : '' ?>" >
    <a href="/htm/myprofile/" rel="nofollow"><img src="/assets/img/icon/guest.png" id="page_myimg" class="icon"></a>
  </td>
  </tr>
</table>

<table id="drawer">
  <tr><td id="ad_menu"><iframe src="/htm/ad_blank/" width="300" height="250" frameborder="0" scrolling="no"></iframe></td></tr>
</table>

<div id="content">
<div class="img_input">
  <input type="text" list="tag_list" value="" maxlength="50" id="tag_name" class="input_with">
  <datalist id="tag_list"></datalist>
  <img src="/assets/img/icon/magnifier.png" alt="search" class="icon" id="search">
</div>
<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>

</div>
<div id="ad_right"></div>

<script>

</script>

<script>
  $(function(){ $(function(){ ga('send', 'pageview'); }); });
</script>
</body>
</html>
