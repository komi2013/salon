<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>HTMLで投稿</title>
    <script src="/plugin/jquery-3.4.1.min.js"></script>
    <script src="/plugin/jquery.cookie.js"></script>
    <meta name="viewport" content="width=device-width, user-scalable=no" >
<!--    <link rel="stylesheet" href="/css/pc/pc.css?ver=42" />
    <link rel="stylesheet" href="/css/pc/article_staff.css?ver=42" />-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<!--    <script src="/js/pc/pc.js"></script>-->
    <script src="/plugin/dropzone.js"></script>
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
    var article_id = 0;
    
    </script>
    <script>
      tinymce.init({
        selector: '#article_body',
        height: 800,
        theme: 'modern',
        mode : "specific_textareas",
        editor_selector : "mceEditor",
        forced_root_block : "",
        paste_data_images: true,
        //inline_styles : true,
        //verify_html : false,
        valid_children : "+body[style]",
        menubar: "insert view format table tools",
        plugins: [
            'advlist autolink lists link charmap preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'emoticons template paste textcolor colorpicker textpattern code table'
        ],
        toolbar1: 'alignleft aligncenter alignright | numlist | link image | forecolor backcolor | fontsizeselect | removeformat ',
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        formats:{
          italic: {inline: 'span', styles: {fontStyle: 'italic'}},
          bold: {inline: 'span', styles: {fontWeight: 'bold'}},
          underline: {inline : 'span', styles: {textDecoration: 'underline'}},
          strikethrough: {inline : 'span', styles: {textDecoration: 'line-through'}}
        },
        style_formats: [
//          { title: 'Bold', inline: 'span', styles: { font-weight: 'bold' } },
          { title: 'Red header', block: 'h1', styles: { color: '#ff0000' } },
          { title: 'Table row 1', selector: 'tr', classes: 'tablerow1' }
        ],
        relative_urls : false,
        setup: function(ed){ed.on('change',function(ed){
          var html_str = ed.target.getContent();

          var sta = html_str.indexOf("data:image");
          var end = html_str.indexOf('"',sta);
          var data_img = html_str.slice(sta,end);

          var canvas = document.createElement('canvas');
          var ctx = canvas.getContext('2d');
          var image = new Image();
          var reader = new FileReader();
          image.crossOrigin = "Anonymous";
          image.onload = function(event){
            var width_ratio = 1
            if(this.width > 2000){
              width_ratio = 2000/this.width;
            }
            
            canvas.width = this.width*width_ratio;
            canvas.height = this.height*width_ratio;
            ctx.drawImage(this, 0, 0, this.width, this.height, 0, 0, canvas.width, canvas.height);
            var param = {
              csrf: $.cookie('csrf')
              ,img_data: canvas.toDataURL()
            };
            $.post('/Content/Img/add/?article_id='+article_id,param,function(){},"json")
            .always(function(res){
              if(res[0]==1){
                $('#image_drop_area').prepend('<img src="'+res[1]+'" class="m_img">');
                var newstr = html_str.replace(data_img,res[1]+'" class="m_img');
                tinymce.activeEditor.setContent(newstr);
                img_attach();
                var iii = 0;
                $('#image_drop_area img').each(function(){
                  if(iii > 19){
                    $(this).css("display","none");
                  }
                  ++iii;
                });
              }else{
                alert('サーバーエラー');
              }
            });
          }
          image.src = data_img;
        });},
        extended_valid_elements : 'script[language|type|src],iframe[src|frameborder|style|scrolling|class|width|height|name|align]',
        content_css: [ '/css/article_staff_content.css?ver=42' ]
      });

    </script>
  </head>
<body>
<div id="header">

</div>
<div style="width:1400px; margin: 15px auto;" class="clearfix">
  <div class="left_div">
    <div id="article-new-body" class="card new-body">
      <div class="title-wrap">
      <div class="err_msg">
      <span id="title_err_msg" style="color:red;"></span><span id="comment_err_msg" style="color:red;"></span>
      </div>
      <input id="title" type="text" placeholder="記事のタイトル...." value="" class="input_title" >
      </div>
      <textarea id="article_body" class="a_body"></textarea>
        <div class="post-btn-area">
            <button class="post_article" onClick="post_data(0)">保存</button>&nbsp;&nbsp;
            <button class="post_article" style="color:red;" onClick="articledel()">削除</button>&nbsp;&nbsp;
            <button id="add_success" class="post_article" style="display:none;">ありがとうございました</button>
        </div>
    </div>
  </div>
  <div class="right_div">

    <div class="uploadButton">
      <div class="img_attach">画像を添付<i class="fa fa-camera"></i></div>
      <div id="image_drop_area"></div>
    </div>
    <div id="preview_area" class="dropzone-custom"></div>
  </div>
</div>
<div id="footer">

</div>

<script>
var new_a = '';
var article_id = '';

</script>

<!--<script src="/js/pc/article_staff.js?ver=42"></script>-->
<!--<script src="/js/basic.js?ver=42"></script>-->

<script>

var img_src = '';
function post_data(public_status){
console.log($('#order_num').val());
  if(!$('#title').val()){
    alert('タイトルがない！！');
    return;
  }
  var body_content = tinymce.get('article_body').getContent();
  if(body_content.indexOf("data:image") > 0){
    alert('画像データが入ってます');
    return;
  }
  if(body_content.indexOf('src="https://www.youtube.com/embed/') > 0){
    var youtube_position = body_content.indexOf('src="https://www.youtube.com/embed/');
    var sp_support_position = body_content.indexOf('style="width:');
    if(sp_support_position - youtube_position > 80 || sp_support_position - youtube_position < 0){
      alert('youtubeを入れたらstyle="width: 100%;"を入れてください');
      return;
    }
  }
  r = confirm('投稿します');
  if(r){
    var url = '/articlestaffupd/';
    if(new_a){
      url = '/articlestaffadd/';
    }
    var param = {
      csrf : $.cookie('csrf')
      ,title : $('#title').val()
      ,free_txt    : body_content
      ,category_id : $('#category').data('id')
      ,article_id : article_id
      ,public_status : public_status
      ,order_num : $('#order_num').val()
    };
    $.post(url,param,function(){},"json")
    .always(function(res){
      if(res[0]==1){
       location.href='/articledraft/'+res[1]+'/';
      }else{
        alert('サーバーエラー');
      }
    });
    ga('send','event','post_article',$('#section').text(),$('#category').text(),article_id);
  }
}

$('#image_drop_area').dropzone({
  url:'/Content/Img/add/?article_id='+article_id,
  //url:'/Content/Img/add/',
  paramName:'img_data',
  maxFilesize:5, //MB
  addRemoveLinks:true,
  previewsContainer:'#preview_area',
  thumbnailWidth:100, //px
  thumbnailHeight:100, //px
  uploadprogress:function(_file, _progress, _size){
    _file.previewElement.querySelector("[data-dz-uploadprogress]").style.width = "" + _progress + "%";
  },
  success:function(_file, _return, _xml){
    var res = eval(_return);
    $('#image_drop_area').prepend('<img src="'+res[1]+'" class="m_img">');
    article_id = res[2];
    var iii = 0;
//     $('#image_drop_area img').each(function(){
//       if(iii > 19){
//         $(this).css("display","none");
//       }
//       ++iii;
//     });
    //_file.previewElement.classList.add("dz-success");
    img_attach();
  },
  error:function(_file, _error_msg){
    var ref;
    (ref = _file.previewElement) != null ? ref.parentNode.removeChild(_file.previewElement) : void 0;
  },
  removedfile:function(_file){
    var ref;
    (ref = _file.previewElement) != null ? ref.parentNode.removeChild(_file.previewElement) : void 0;
  },
  previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-details\">\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n    <div class=\"dz-size\" data-dz-size></div>\n    <img data-dz-thumbnail />\n  </div>\n  <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>\n  <div class=\"dz-success-mark\"><span>&#10004;</span></div>\n  <div class=\"dz-error-mark\"><span>&#10008;</span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n</div>",
  dictRemoveFile:'削除',
  dictCancelUpload:'キャンセル'
});

var start = 0;
function img_take(start){
  var param = {
    start : start
  };
  $.get('/Content/Img/index/',param,function(){},"json")
  .always(function(res){
    arr_img = res[1];
    for(var i3 = 0; i3 < arr_img.length; i3++){
      $('#image_drop_area').prepend('<img src="'+arr_img[i3]+'" class="m_img">');
    }
    img_attach();
  });
}
//img_take(start);
// $('#more_img').click(function(){
//   start++;
//   img_take(start);
// });

function img_take(){
  var param = {
    article_id : article_id
  };
  $.get('/Content/Img/index/',param,function(){},"json")
  .always(function(res){
    arr_img = JSON.parse(res[1]);
    for(var i3 = 0; i3 < arr_img.length; i3++){
      $('#image_drop_area').prepend('<img src="'+arr_img[i3]+'" class="m_img">');
    }
  });
}
img_take();


function img_attach () {
  $('#image_drop_area img').click(function(){
    img_src = $(this).attr('src');
    $('#thumbnail').attr('src',img_src);
//     $('#image_drop_area img').each(function(){
//       $(this).css('border','none');
//       if(img_src == $(this).attr('src')){
//         $(this).css('border','2px solid #0000de');
//       }else{
//         $(this).css('border','none');
//       }
//     });
  });
}

function articleconfirm(change){
  var param = {
    change_id : change
    ,article_id : article_id
  };
  $.post('/articleconfirm/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
      location.href='/articledraft/'+res[1]+'/';
    }else if(res[0]==2){
      alert('connection error');
    }
  });
}

function articledel(){
  var param = {
    article_id : article_id
  };
  $.post('/articledel/',param,function(){},"json")
  .always(function(res){
    if(res[0]==1){
      location.href='/articledraft/'+res[1]+'/';
    }else if(res[0]==2){
      alert('connection error');
    }
  });
}


</script>

</body>
</html>