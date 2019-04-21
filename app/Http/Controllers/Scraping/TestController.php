<?php
namespace App\Http\Controllers\Scraping;
require_once('/var/www/zstg_salon/vendor/simple_html_dom.php');

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TestController extends Controller {

    public function index(Request $request) {
    

        
        
        
$table = '<table>
  <tr>
    <th nowrap="nowrap">北海道<span>|</span>東北</th>
    <td>
      <a href="https://riyou.jp/city/hokkaido/">北海道</a><span>|</span>
      <a href="https://riyou.jp/city/aomori/">青森県</a>
      <a href="https://riyou.jp/city/akita/">秋田県</a>
      <a href="https://riyou.jp/city/yamagata/">山形県</a>
      <a href="https://riyou.jp/city/iwate/">岩手県</a>
      <a href="https://riyou.jp/city/miyagi/">宮城県</a>
      <a href="https://riyou.jp/city/fukushima/">福島県</a>
    </td>
  </tr>
  <tr>
    <th>関東</th>
    <td>
      <a href="https://riyou.jp/city/ibaraki/">茨城県</a>
      <a href="https://riyou.jp/city/tochigi/">栃木県</a>
      <a href="https://riyou.jp/city/gunma/">群馬県</a>
      <a href="https://riyou.jp/city/saitama/">埼玉県</a>
      <a href="https://riyou.jp/city/chiba/">千葉県</a>
      <a href="https://riyou.jp/city/tokyo/">東京都</a>
      <a href="https://riyou.jp/city/kanagawa/">神奈川県</a>
    </td>
  </tr>
  <tr>
    <th>甲信越<span>|</span>北陸</th>
    <td>
      <a href="https://riyou.jp/city/niigata/">新潟県</a>
      <a href="https://riyou.jp/city/yamanashi/">山梨県</a>
      <a href="https://riyou.jp/city/nagano/">長野県</a><span>|</span>
      <a href="https://riyou.jp/city/ishikawa/">石川県</a>
      <a href="https://riyou.jp/city/toyama/">富山県</a>
      <a href="https://riyou.jp/city/fukui/">福井県</a>
    </td>
  </tr>
  <tr>
    <th>東海</th>
    <td>
      <a href="https://riyou.jp/city/aichi/">愛知県</a>
      <a href="https://riyou.jp/city/gifu/">岐阜県</a>
      <a href="https://riyou.jp/city/shizuoka/">静岡県</a>
      <a href="https://riyou.jp/city/mie/">三重県</a>
    </td>
  </tr>
  <tr>
    <th>近畿</th>
    <td>
      <a href="https://riyou.jp/city/osaka/">大阪府</a>
      <a href="https://riyou.jp/city/hyogo/">兵庫県</a>
      <a href="https://riyou.jp/city/kyoto/">京都府</a>
      <a href="https://riyou.jp/city/shiga/">滋賀県</a>
      <a href="https://riyou.jp/city/nara/">奈良県</a>
      <a href="https://riyou.jp/city/wakayama/">和歌山県</a>
    </td>
  </tr>
  <tr>
    <th>中国<span>|</span>四国</th>
    <td>
      <a href="https://riyou.jp/city/okayama/">岡山県</a>
      <a href="https://riyou.jp/city/hiroshima/">広島県</a>
      <a href="https://riyou.jp/city/tottori/">鳥取県</a>
      <a href="https://riyou.jp/city/shimane/">島根県</a>
      <a href="https://riyou.jp/city/yamaguchi/">山口県</a><span>|</span>
      <a href="https://riyou.jp/city/kagawa/">香川県</a>
      <a href="https://riyou.jp/city/tokushima/">徳島県</a>
      <a href="https://riyou.jp/city/ehime/">愛媛県</a>
      <a href="https://riyou.jp/city/kochi/">高知県</a>
    </td>
  </tr>
  <tr>
    <th class="last">九州<span>|</span>沖縄</th>
    <td class="last">
      <a href="https://riyou.jp/city/fukuoka/">福岡県</a>
      <a href="https://riyou.jp/city/saga/">佐賀県</a>
      <a href="https://riyou.jp/city/nagasaki/">長崎県</a>
      <a href="https://riyou.jp/city/kumamoto/">熊本県</a>
      <a href="https://riyou.jp/city/oita/">大分県</a>
      <a href="https://riyou.jp/city/miyazaki/">宮崎県</a>
      <a href="https://riyou.jp/city/kagoshima/">鹿児島県</a><span>|</span>
      <a href="https://riyou.jp/city/okinawa/">沖縄県</a>
    </td>
  </tr>
</table>
';
        $table = str_get_html($table);
        $a = $table->find( 'a' );

        foreach ($a as $d1) {
            $a_arr[] = $d1->attr['href'];
        }
        $table->clear(); 
        unset($table);
        set_time_limit(0);
        $options['ssl']['verify_peer'] = false;
        $options['ssl']['verify_peer_name'] = false;
        foreach ($a_arr as $d1) {
            $html = file_get_html($d1, 0, stream_context_create($options));
            $pref = $html->find( 'strong' )[0]->plaintext;
            
            $a = $html->find( '.accordion ul li a' );
            foreach ($a as $d2) {
//                echo $pref . "\t". $d2->plaintext. "\t". $d2->attr['href'].'<br>';
//                die;
                DB::table('riyou_jp')->insert([
                    'prefecture' => $pref,
                    'city' => $d2->plaintext,
                    'city_url' => $d2->attr['href']
                ]);
            }
            $html->clear(); 
            unset($html);
        }
        
        
        
        

die('works?');
        $obj = DB::select("SELECT * FROM salon3 WHERE salon_name = '' AND tag_area <> '' ORDER BY salon_id ASC LIMIT 500000");
        $arr = [];

//        $options['user_agent'] = 'APIs-Google/1.0';
        foreach ($obj as $d1) {
            $html = $a = $ele = '';
            if (@file_get_contents($d1->hpb_url)) {
                $html = file_get_html($d1->hpb_url, 0, stream_context_create($options));
                $a = $html->find( '.detailTitle a' );
                if (isset($a[0]->plaintext)) {
                    $arr['salon_name'] = $a[0]->plaintext;
                    DB::table('salon3')
                        ->where('salon_id', $d1->salon_id)
                        ->update($arr);
                    $html->clear(); 
                    unset($html);
                }   
            }
        }
die('take tel and salon_name owari');
        foreach ($obj as $d1) {
            if(@file_get_contents($d1->hpb_url)){
                $context = stream_context_create();
                stream_context_set_params($context, array('user_agent' => 'APIs-Google/1.0'));
                $html = file_get_html($d1->hpb_url, 0, $context);
                $table = $html->find( '.pCellV10H12' );
                $outertext = isset($table[0]->outertext) ? $table[0]->outertext : '';
                DB::table('salon3')
                    ->where('salon_id', $d1->salon_id)
                    ->update([
                        'tag_area' => $outertext
                    ]);
            } else {
                echo $d1->salon_id."\r\n";
            }
        }        
die('get tag area owari');
            $td = $html->find( 'td' );
            $arr = [];
            foreach ($th as $k => $d2) {
//                echo $d2->innertext . '<br>';
                switch ($d2->innertext){
                case '電話番号':
                  $arr['tel'] = str_replace("&nbsp;", "", $td[$k]->innertext); 
                  break;
                case '住所':
                  $arr['address'] = str_replace("&nbsp;", "", $td[$k]->innertext);
                  break;
                case 'アクセス・道案内':
                  $arr['way'] = str_replace("&nbsp;", "", $td[$k]->innertext);
                  break;
                case '営業時間':
                  $arr['opentime_text'] = str_replace("&nbsp;", "", $td[$k]->innertext);
                  break;
                case '定休日':
                  $arr['off_day'] = str_replace("&nbsp;", "", $td[$k]->innertext);
                  break;
                case 'お店のホームページ':
                  $arr['salon_url'] = str_replace("&nbsp;", "", $td[$k]->innertext);
                  break;
                case 'カット価格':
                  $arr['price_text'] = str_replace("&nbsp;", "", $td[$k]->innertext);
                  break;
                case '席数':
                  $arr['seat_text'] = str_replace("&nbsp;", "", $td[$k]->innertext);
                  break;
                case '駐車場':
                  $arr['car_parking_text'] = str_replace("&nbsp;", "", $td[$k]->innertext);
                  break;
                case '備考':
                  $arr['note'] = str_replace("&nbsp;", "", $td[$k]->innertext);
                  break;

                }
            }
die('put marameter');
        foreach ($obj as $d1) {
            $i = 1;
            $rotate = true;
            while ($rotate) {
//                https://beauty.hotpepper.jp/svcSA/macAD/salon/PN1.html?searchGender=ALL
                $html = file_get_html($d1->url.'PN'.$i.'.html?searchGender=ALL');
                $href = $html->find( '.slcHeadContentsInner .slcHead a' );
//                $href->plaintext
                foreach ($href as $d2) {
//                    dd($d2->plaintext);
                    if(!isset($d2->attr['href'])){

                        echo $d1->url.'PN'.$i.'.html?searchGender=ALL'."\t".
                                $d2->attr['href']."\t".
                                $d2->sitemap3_id."\t".
                                ' NG <br>';
                            die('hei yo');
                    }
//                    echo $d1->url."\t".$d2->attr['href'].'<br>';
                    DB::table('salon')->insert([
                        'hpb_url' => $d2->attr['href'],
                        'salon_name' => $d2->plaintext,
                        'option1' => $d1->url,
                        'tel' => $d1->sitemap2_id
                    ]);
                }
                $next = $html->find( '.arrowPagingR' );
                if ( isset( $next[0]->attr['href'] ) ) {

//                    echo $d1->url."\t".$next[0]->attr['href'].'<br>';
                } else {
                    $rotate = false;
                }
                ++$i;
            }
        }

        // generate sitemap3
        $obj = DB::select("SELECT * FROM sitemap2 where sitemap2_id > 3 ORDER BY sitemap2_id ASC limit 50000");
        foreach ($obj as $d1) {
            $html = file_get_html($d1->url);
            $href = $html->find( '.routeMa li a[href]' );
            foreach ($href as $d2) {
                    if(strpos($d2->attr['href'],'https://') === false){
                        echo $d1->sitemap2_id."\t".$d1->url."\t".$d2->attr['href'].'<br>';
                        die;
                    }
                    DB::table('sitemap3')->insert([
                        'url' => $d2->attr['href'],
                        'sitemap1' => $d1->sitemap1,
                        'sitemap2' => $d1->url,
                    ]);
            }
        }
/*
 * 
 * insert into sitemap3_bk1 (sitemap1,sitemap2,url)
select sitemap1,sitemap2, url from sitemap3
 * 
 * 
 * 
// make sitemap2 
        $obj = DB::select("SELECT * FROM sitemap1 ORDER BY sitemap1_id ASC");
        foreach ($obj as $d1) {
            $html = file_get_html($d1->url);
            $loc = $html->find( 'loc' );
            foreach ($loc as $d2) {
                foreach ($d2->nodes[0]->_ as $d3) {
                   DB::table('sitemap2')->insert([
                       'url' => $d3,
                       'sitemap1' => $d1->url,
                   ]);
                   echo $d3.'　　'.$d1->url.'<br>';
                }
            }
        }
*/
//         $html = file_get_html("https://beauty.hotpepper.jp/sitemap.xml");
//         $loc = $html->find( 'loc' );
//         foreach ($loc as $d) {
//             foreach ($d->nodes[0]->_ as $dd) {
//                DB::table('sitemap1')->insert([
//                    'url' => $dd
//                ]);
//                echo $dd.'<br>';
//             }
////             dd($d->nodes[0]->_);
//         }

    die;
        $M = DB::select("SELECT * FROM t_variation");
        $t_variation = json_decode(json_encode($M), true);
//        dd($t_variation);
		var_dump('test');
		die;
		
    }

}

