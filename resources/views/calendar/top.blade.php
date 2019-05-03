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
    <style>
        .offwork{
            color:orange;
        }
        th {
            font-size:10px;
            width: 14.28%;
            
        }
        td {
            text-align: center;
            font-size: 10px;
            padding: 20px 0px 10px 0px;
        }
    </style>
<table>
    <thead><tr>
    <th>Sun</th>
    <th>Mon</th>
    <th>Tue</th>
    <th>Wed</th>
    <th>Thu</th>
    <th>Fri</th>
    <th>Sat</th>
    </tr></thead>
    <?php foreach ($arr_35days as $k => $d) {?>
        <?php if($d['day'] == 'Sun'){?> <tr> <?php }?>
        <td class="date<?=$d['css_class']?>" date="<?=$k?>"><?=$d['j']?></td>
        <?php if($d['day'] == 'Sat'){?> </tr> <?php }?>
    <?php } ?>
</table>

    

</div>

<div id="ad_right"><iframe src="/htm/ad_right/" width="160" height="600" frameborder="0" scrolling="no"></iframe></div>

<script>
var param = {
  month : '<?=$month?>'
};
$.get('/Calendar/My/index/<?=$month?>/',param,function(){},"json")
.always(function(res){
    console.log(res);
  if(res[0]==1){

  }else if(res[0]==2){
  }
});

  $(function(){ $(function(){ ga('send', 'pageview'); }); });
</script>
</body>
</html>
