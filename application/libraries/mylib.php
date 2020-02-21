<?php

include_once('application/libraries/simple_html_dom.php');

defined('BASEPATH') OR exit('No direct script access allowed');

//$counter = 0;
function proxyIp()
{
    //$url = 'http://pubproxy.com/api/proxy?api=N2JVT3ZYeXByd1ZEWlVwSVN2d29kZz09&google=true';
    $url = 'http://pubproxy.com/api/proxy';
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    $res = json_decode($response);
    $res = $res->data[0]->ipPort;
    var_dump("IP IS = ".$res);
    return $res;
}

function proxyIpDocker(&$counter)
{
    var_dump("counter is = ".$counter);
    $url = 'https://www.proxydocker.com/en/proxylist/api?email=pavlostif%40outlook.com&country=all&city=all&port=all&type=all&anonymity=all&state=all&need=Google&format=json';
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    $res = json_decode($response);
    
    $res = $res->Proxies[$counter]->ip.':'.$res->Proxies[$counter]->port;
    var_dump("IP IS = ".$res);
    $counter++;
    return $res;
}

function check_error_msg($error_msg){
    $state = 0;
    if($error_msg == "Proxy CONNECT aborted"){
        $state = 1;
    }elseif (strpos($error_msg, 'Timed out') !== false) {
        $state = 1;
    }elseif (strpos($error_msg, '502') !== false) {
        $state = 1;
    }elseif (strpos($error_msg, '503') !== false) {
        $state = 1;
    }elseif (strpos($error_msg, '400') !== false) {
        $state = 1;
    }elseif (strpos($error_msg, '401') !== false) {
        $state = 1;
    }elseif (strpos($error_msg, '514') !== false) {
        $state = 1;
    }elseif (strpos($error_msg, '403') !== false) {
        $state = 1;
    }elseif (strpos($error_msg, 'failure') !== false) {
        $state = 1;
    }elseif (strpos($error_msg, 'SSL_ERROR_SYSCALL') !== false) {
        $state = 1;
    }elseif (strpos($error_msg, 'Failed') !== false) {
        $state = 1;
    }elseif (strpos($error_msg, 'The document has moved') !== false) {
        $state = 1;
    }
    return $state;
}


class Mylib {

    public function __construct()
        {
            $CI = & get_instance();
            $CI->load->helper('url');
        }

        

    public function prof_list_scraping($url)
    {
        $i=0;
        start:
        $ch = curl_init();

        // set options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PROXY, proxyIp());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // read more about HTTPS http://stackoverflow.com/questions/31162706/how-to-scrape-a-ssl-or-https-url/31164409#31164409
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        // $output contains the output string
        $str = curl_exec($ch);
        $error_msg = curl_error($ch);
        if(check_error_msg($error_msg) == 1){
            goto start;
        }
        //echo "CURL ERROR Message: ".var_dump($error_msg);
        //echo "<br>";
        //echo "Returned result: ".var_dump($str);
        curl_close($ch); 

        $html_base = new simple_html_dom();

        $html_base->load($str); 
        $prof = [];
        foreach($html_base->find('.gsc_1usr') as $key => $element)
        {
            $temp = [];
            //echo $element->plaintext . '<br>';
            $tds = $element->find('.gs_ai_t');
            foreach ($tds as $idx => $td) {
                switch ($idx)
                {
                    case 0:
                        $contents = $td->find('a');
                        $temp['name'] = $contents[0]->plaintext;
                        $link = trim($contents[0]->href,'/citations?hl=el&user=!');
                        $temp['scholarid'] = trim($link,'mp;user=');
                        if (!$contents)
                            break;
                    case 1:
                        $contents = $td->find('.gs_ai_eml');
                        $trimmed = trim($contents[0]->plaintext, "Η διεύθυνση ηλεκτρονικού ταχυδρομείου έχει επαληθευτεί στον τομέα .");
                        $temp['description'] = $trimmed;
                        //$temp['description'] = $contents[0]->plaintext;
                        if (!$contents)
                            break;
                    case 2:
                        $contents = $td->find('.gs_ai_cby');
                        preg_match_all('!\d+!', $contents[0], $matches);
                        $temp['citation'] = $matches[0];

                        if (!$contents)
                            break;
                }
            }
            $prof[$i] = $temp;
            $i++;
        }
        $html_base->clear();
        unset($html_base);
        return $prof;
    }

    public function scraping_professor_citation($profId){
        $url = "https://scholar.google.com/citations?user=".$profId."&hl=en";
        start:
        $ch = curl_init();

        // set options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PROXY, proxyIp());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // read more about HTTPS http://stackoverflow.com/questions/31162706/how-to-scrape-a-ssl-or-https-url/31164409#31164409
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        // $output contains the output string
        $str = curl_exec($ch);
        $error_msg = curl_error($ch);
        if(check_error_msg($error_msg) == 1){
            goto start;
        }
        // echo "CURL ERROR Message: ".var_dump($error_msg);
        // echo "<br>";
        // echo "Returned result: ".var_dump($str);
        curl_close($ch); 

        $html_base = new simple_html_dom();

        $html_base->load($str); 
        //$html = file_get_html($url);
        $i=0;
        $prof = [];
        foreach($html_base->find('#gsc_rsb_cit') as $key => $element){
            $temp = [];
            $element = $element->find('#gsc_rsb_st');
            foreach ($element as $idx => $td) {
                foreach ($td->find('.gsc_rsb_std') as $key => $value) {                  
                    $temp['citation'] = $value->plaintext;
                    break;                 
                }
                break;               
            }
        }
        // clean up memory
        $html_base->clear();
        unset($html_base);
        return $temp['citation'];
    }


    public function scraping_article_list($profId){
        var_dump("<pre>");
        $b=0;
        $i=0;
        $n=0;
        $j=0;
        $t=1;
        $a=10;
        $reference = [];
        $contents = [];
        $start = 0;
        $count = 0;
        $intpart = 0;
        $pagesize = 100;

        $t=false;
        $article_list = [];

        start:
        while($n == 0){
        $url = 'https://scholar.google.com/citations?hl=en&user=' . $profId. '&sortby=pubdate' . '&cstart=' . $start . '&pagesize=' .$pagesize;
        var_dump('URL IS ==='.$url);

        $ch = curl_init();

        // set options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PROXY, proxyIp());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // read more about HTTPS http://stackoverflow.com/questions/31162706/how-to-scrape-a-ssl-or-https-url/31164409#31164409
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        // $output contains the output string
        $str = curl_exec($ch);
        $error_msg = curl_error($ch);
        if(check_error_msg($error_msg) == 1){
            goto start;
        }
        // echo "CURL ERROR Message: ".var_dump($error_msg);
        // echo "<br>";
        // echo "Returned result: ".var_dump($str);
        curl_close($ch); 

        //var_dump($str);
        var_dump("------");
        $html_base = new simple_html_dom();
        $html_base->load($str); 
        if($b == 0){
            $article_count = '';
            $contents = [];
            $btn = $html_base->find('#gsc_bpf_more');
            //ean to koumpi einai apenergopoihmeno tote exei fortwthei olh h lista
            if($btn[0]->attr['disabled'] != 'bool(true)'){
                var_dump("not button");
                $start = $start + 100;
                foreach ($html_base->find('.gsc_a_tr') as $key => $element)
                {
                    $temp = [];
                    $tds = $element->find('.gsc_a_t');
                    foreach ($tds as $idx => $td)
                    {
                        switch ($idx)
                        {
                            case 0:
                                $contents = $td->find('.gsc_a_at');
                                $temp['title'] = $contents[0]->plaintext;
                                $link = $contents[0]->{"data-href"};
                                $uriParts = explode(':',$link);
                                $temp['articleId'] = $uriParts[1];
                                if (!$contents)
                                    break;
                            case 2:
                                $contents = $td->find('span');
                                $temp['year'] = $contents[0]->plaintext;
                                if (!$contents)
                                    break;
                        }
                    }
                    $tds1 = $element->find('.gsc_a_c');
                    echo "<pre>";
                    foreach ($tds1 as $key => $value) {
                        $contents = $value->find('a');                       
                        $citation = $contents[0]->plaintext; 
                        if($citation == "")
                        {
                            $temp['citation'] = null;
                        }
                        else
                        {
                            $temp['citation'] = $citation;
                            $reference_id = explode('=', $contents[0]->href);
                            if(isset($reference_id[4]))
                                $temp['reference_id'] = $reference_id[4];
                            $temp['reference_url'] = $contents[0]->href; 
                        }  
                    }
                    $article_list[$i] = $temp;
                    $i++;
                }
                $html_base->clear();
                unset($html_base);
                goto start;
            }else{
                var_dump("found all list");
                foreach ($html_base->find('.gsc_a_tr') as $key => $element)
                {
                    $temp = [];
                    $tds = $element->find('.gsc_a_t');
                    foreach ($tds as $idx => $td)
                    {
                        switch ($idx)
                        {
                            case 0:
                                $contents = $td->find('.gsc_a_at');
                                $temp['title'] = $contents[0]->plaintext;
                                $link = $contents[0]->{"data-href"};
                                $uriParts = explode(':',$link);
                                $temp['articleId'] = $uriParts[1];
                                if (!$contents)
                                    break;
                            case 2:
                                $contents = $td->find('span');
                                $temp['year'] = $contents[0]->plaintext;
                                if (!$contents)
                                    break;
                        }
                    }
                    $tds1 = $element->find('.gsc_a_c');
                    echo "<pre>";
                    foreach ($tds1 as $key => $value) {
                        $contents = $value->find('a');
                        
                        $citation = $contents[0]->plaintext; 
                        if($citation == "")
                        {
                            $temp['citation'] = null;
                        }
                        else
                        {
                            $temp['citation'] = $citation;
                            $reference_id = explode('=', $contents[0]->href);
                            if(isset($reference_id[4]))
                                $temp['reference_id'] = $reference_id[4];
                            $temp['reference_url'] = $contents[0]->href; 
                        }  
                    }
                    $article_list[$i] = $temp;
                    $i++;
                    // $html_base->clear();
                    // unset($html_base);
                }
                $b = 1;
                $n = 1;
                }
            }
        }
        return $article_list;
    }

    public function scraping_single_article($url)
    {
        // $url = "https://scholar.google.com/citations?view_op=view_citation&hl=en&user=X2HBQv8AAAAJ&cstart=20&pagesize=80&citation_for_view=X2HBQv8AAAAJ:UebtZRa9Y70C&tzom=-120";
        // $html = file_get_html($url);
        start:
        $ch = curl_init();

        // set options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PROXY, proxyIp());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // read more about HTTPS http://stackoverflow.com/questions/31162706/how-to-scrape-a-ssl-or-https-url/31164409#31164409
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        // $output contains the output string
        $str = curl_exec($ch);
        $error_msg = curl_error($ch);
        if(check_error_msg($error_msg) == 1){
            var_dump($error_msg);
            goto start;
        }
        // echo "CURL ERROR Message: ".var_dump($error_msg);
        // echo "<br>";
        // echo "Returned result: ".var_dump($str);
        curl_close($ch); 

        $html_base = new simple_html_dom();

        $html_base->load($str); 
        $temp = [];
        foreach($html_base->find('.gs_scl') as $key => $element)
        {
            $t=0;
            $tds = $element->find('.gsc_vcd_field');
            $td = $element->find('.gsc_vcd_value');
            foreach ($tds as $idx => $value)
            {
                $field = $value->plaintext;
                foreach ($td as $idx => $value1)
                {
                    echo "<pre>";
                    // var_dump($field);


                    if($field == 'Publication date')
                    {
                        $year = explode('/', $value1->plaintext);

                        if(isset($year[2]))
                        {
                            $temp[$field] = $year[0].'/'.$year[1].'/'.$year[2];
                            $temp['month'] = $year[1];
                        }
                        else if(isset($year[1]))
                        {
                            $temp[$field] = $year[0].'/'.$year[1];
                            $temp['month'] = $year[1];
                        }
                        else
                        {
                            $temp[$field] = $year[0];
                        }

                    }
                    else if($field == 'Total citations')
                    {
                        $contents = $value1->find('a');
                        $field = 'Citation';
                        $citation = explode(' ', $value1->plaintext);
                        $citation = $citation[2];
                        $temp[$field] = substr($citation, 0, -4);

                        $field = 'References';
                        $references = explode('&', $contents[0]->attr['href']);
                        
                        $references1 = explode('cites=', $references[2]);
                        //var_dump($references1);
                        $temp[$field] =  $references1[1];
                        //var_dump($temp['References']);
                    }
                    else
                    {
                        if($key == 2 && $field != 'Journal' && $field != 'Conference')
                        {
                            $temp['General'] = $value1->plaintext;
                        }
                        else
                        {
                             $temp[$field] = $value1->plaintext;
                        }
                       
                    }
                }
            }
        }
        // clean up memory
        $html_base->clear();
        unset($html_base);
        return $temp;
    }

    public function reference_list_count($id)
    {
        $counter = rand(0,999);
        var_dump("from count");
        $start = 0;
        start:
                     // $context = array('http' => array('proxy' => 'tcp://'.$res,'request_fulluri' => true,),);
        // $stream = stream_context_create($context);
        $url = 'https://scholar.google.gr/scholar?start='.$start.'&oi=bibs&hl=en&cites='. $id;
        var_dump('URL IS ==='.$url);
        // $html = file_get_html($url, false, $stream);

        $ch = curl_init();

        // set options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PROXY, proxyIpDocker($counter));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // read more about HTTPS http://stackoverflow.com/questions/31162706/how-to-scrape-a-ssl-or-https-url/31164409#31164409
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        // $output contains the output string
        $str = curl_exec($ch);
        $error_msg = curl_error($ch);
        if(check_error_msg($error_msg) == 1){
            goto start;
        }
        echo "CURL ERROR Message: ".var_dump($error_msg);
        echo "<br>";
        echo "Returned result: ".var_dump($str);
        curl_close($ch); 

        //var_dump($str);
        var_dump("------");

        $html_base = new simple_html_dom();

        $html_base->load($str); 
            $article_count = '';
            $contents = [];
            foreach($html_base->find('.gs_ab_mdw') as $key => $element)
            {            
                
                if($key == 1)
                {
                    $contents = explode(' ', $element->plaintext);
                    if(strpos($contents[0], 'About') !== false){
                        $article_count = $contents[1];
                    }else{
                        $article_count = $contents[0];
                    }
                    var_dump($contents);
                    if($article_count == '') goto start;
                    var_dump("article count =".$article_count);
                }
            }
            // clean up memory
        $html_base->clear();
        unset($html_base);
        return $article_count;
    }

    public function reference_list($id)
    {
        $counter = 0;
        //$id = '17416187374477165610';
        $i=0;
        $n=0;
        $j=0;
        $t=1;
        $a=10;
        $reference = [];
        $start = 0;
        $count = 0;
        $intpart = 0;

        start:
        while($j <= $intpart){
            var_dump("j is".$j);
            var_dump("intpart is".$intpart);
                     // $context = array('http' => array('proxy' => 'tcp://'.$res,'request_fulluri' => true,),);
        // $stream = stream_context_create($context);
        $url = 'https://scholar.google.gr/scholar?start='.$start.'&oi=bibs&hl=en&cites='. $id;
        var_dump('URL IS ==='.$url);
        // $html = file_get_html($url, false, $stream);

        $ch = curl_init();

        // set options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PROXY, proxyIpDocker($counter));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // read more about HTTPS http://stackoverflow.com/questions/31162706/how-to-scrape-a-ssl-or-https-url/31164409#31164409
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        // $output contains the output string
        $str = curl_exec($ch);
        $error_msg = curl_error($ch);
        if(check_error_msg($error_msg) == 1){
            goto start;
        }
        echo "CURL ERROR Message: ".var_dump($error_msg);
        echo "<br>";
        echo "Returned result: ".var_dump($str);
        curl_close($ch); 

        //var_dump($str);
        var_dump("------");

        $html_base = new simple_html_dom();

        $html_base->load($str); 
        if($j == 0){
            $article_count = '';
            $contents = [];
            foreach($html_base->find('.gs_ab_mdw') as $key => $element)
            {            
                
                if($key == 1)
                {
                    $contents = explode(' ', $element->plaintext);
                    if(strpos($contents[0], 'About') !== false){
                        $article_count = $contents[1];
                    }else{
                        $article_count = $contents[0];
                    }
                    var_dump($contents);
                    if($article_count == '') goto start;
                    var_dump("article count =".$article_count);
                }
            }
            
            $num = intval($article_count) / 10 ;
             var_dump("num is = ".$num);
            $intpart = floor( $num );
            var_dump("intpart is".$intpart);
            $fraction = $num - $intpart;
            var_dump("fraction is ".$fraction);

            if($fraction != 0 && $intpart != 0){
                $intpart = $intpart;
            }else{
                $intpart = $intpart;
            }             
        }

        //$html = file_get_html($url, false, $stream);
        foreach ($html_base->find('.gs_r.gs_or.gs_scl') as $idx => $element)
         {
            $temp = [];
            $tds = $element->find('.gs_ri');
            foreach ($tds as $key => $value) {
                $contents = $value->find('a');
                if(isset($contents[0]->{"id"})){
                    $temp['bibtex_id'] = $contents[0]->{"id"};
                    var_dump($temp);
                }else{
                    //$contents = $value->find('span');
                    
                    $temp['bibtex_id'] = "0000";
                }
                
            }
            $reference[$i] = $temp;
            $i++;
         }
         //clean up memory
        $html_base->clear();
        unset($html_base);

         var_dump("id in ARRAY IS ".count($reference));
         if($j <= $intpart){

            if(count($reference) == $a & $t == ($a / 10))
            {
                $start = $start + 10;
                $a = $a + 10;
                $j++;
                var_dump("------------".$j);
                $t++;
            }
            else if(count($reference) == intval($article_count) && count($reference) != 0)
            {
                var_dump("telos aujhshs tou start kai j dioti exoyme ola ta arthra");
                goto end;
            }
            else
            {
                goto start;
                var_dump("reset");
            }

         }
         else
         {
            var_dump("telos scraping");
            goto end;
         }
         }
        end:
        return $reference;
    }

    public function bibtex_url($bibtex_id)
    {
        //$url = 'https://scholar.google.gr/scholar?q=info:'.$bibtex_id.':scholar.google.com/&output=cite&scirp=0&hl=en';
        $url = 'https://scholar.google.gr/scholar?q=info:'.$bibtex_id.':scholar.google.com/&output=cite&scirp=0&hl=en';
        start:
        $ch = curl_init();

        // set options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PROXY, proxyIp());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // read more about HTTPS http://stackoverflow.com/questions/31162706/how-to-scrape-a-ssl-or-https-url/31164409#31164409
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        // $output contains the output string
        $str = curl_exec($ch);
        $error_msg = curl_error($ch);
        if(check_error_msg($error_msg) == 1){
            goto start;
        }
        // echo "CURL ERROR Message: ".var_dump($error_msg);
        // echo "<br>";
        // echo "Returned result: ".var_dump($str);
        curl_close($ch); 

        $html_base = new simple_html_dom();

        $html_base->load($str);
        $temp = [];
        foreach ($html_base->find('.gs_citr') as $idx => $element) 
        {
            if($idx == 1){
                $contents = explode('(19', $element->plaintext);
                if($contents[1] == ""){
                    $contents = explode('(20', $element->plaintext);
                }
                //var_dump($contents);
                $temp['publishers'] = $contents[0];

                $contents1 = explode(').', $contents[1]);
                if($contents[1] == ""){
                    $temp['year'] = '19'.$contents1[0];
                }else{
                    $temp['year'] = '20'.$contents1[0];
                }
                
                $temp['title'] = $contents1[1];
                //var_dump($temp);
                goto end;
            }
         } 
         end:
        //var_dump($html_base);
        // clean up memory
        $html_base->clear();
        unset($html_base);
        var_dump($temp);
        return $temp;
    }

}
