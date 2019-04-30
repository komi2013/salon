<?php
namespace App\Http\Controllers\Scraping;
require_once('/var/www/zstg_salon/vendor/simple_html_dom.php');

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RiyouController extends Controller {

    public function index(Request $request) {
        set_time_limit(0);
        ini_set('memory_limit', '1500M');
        $obj = DB::select("SELECT * FROM salon_riyou2 WHERE salon_id > 0 AND prefecture = '' ORDER BY salon_id ASC LIMIT 1000000");
        foreach ($obj as $d1) {
            $arr = [];
            $html = file_get_html($d1->tel_href);
            $tag = $html->find( '.dlgroup' ); //info
            $arr['prefecture'] = $tag[1]->outertext;
            DB::table('salon_riyou2')
                ->where('salon_id', $d1->salon_id)
                ->update($arr);
            $html->clear(); 
            unset($html);

        }

die($d1->salon_id.' update tag data');

        $arr = [];
        $options['ssl']['verify_peer'] = false;
        $options['ssl']['verify_peer_name'] = false;

        foreach ($obj as $d1) {
            $html = $a = $ele = '';
            $next = '?pageno=';
            $next_i = 1;
            $pager = '';
            $count = 0;
            while ($next) {
                $next = '';
                if (@file_get_contents($d1->city_url.$pager)) {
                    $html = file_get_html($d1->city_url.$pager, 0, stream_context_create($options));
                    $section = $html->find( 'section' );
                    
                    foreach ($section as $d2) {
                        $a = $d2->find( 'h3 a' );
                        DB::table('salon_riyou')->insert([
                            'hpb_url' => $d1->city_url.$pager,
                            'prefecture' => $d1->prefecture,
                            'city' => $d1->city,
                            'salon_name' => $a[0]->plaintext,
                            'riyou_tag' => $d2->outertext
                        ]);
//                        echo $d1->prefecture . "\t".$d1->city_url.$pager . "\t". $a[0]->plaintext. "\t".'<br>';
                    }
                    $pagnation = $html->find( '.pagnation a' );
                    $next_page = false;
                    foreach ($pagnation as $d3) {
                        if(strpos($d3->innertext,'次へ') !== false){
                            $next_page = true;
                        }
                    }
                    if ($next_page) {
                        $next = '?pageno=';
                        $next_i++;
                        $pager = $next.$next_i;
//                        echo $d1->prefecture . "\t".$d1->city_url.$pager . "\t". $d3->innertext. "\t". $next. "\t".'<br>';
                    }
                    $html->clear(); 
                    unset($html);
//                    $section->clear(); 
//                    unset($section);
//                    $a->clear(); 
//                    unset($a);
//                    $pagnation->clear(); 
//                    unset($pagnation);
                }
                $count++;
            }
//die('just one url done');
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

