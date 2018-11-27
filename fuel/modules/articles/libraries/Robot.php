<?php

class Robot {

    public function __construct()
    {
        // Do something with $params
    }

    public function get_content_by_url($url) {
        $content = file_get_contents($url);
        do {
            $content = str_replace("  ", " ", $content);
        } while (strpos($content, "  ", 0) !== false);
        return $content;
    }

    //$content = MyFunctions::get_content_by_tag($noidung, "<div class=\"content\">");
    public function get_content_by_tag($content, $tag_and_more, $include_tag = true) {
        $p = stripos($content, $tag_and_more, 0);

        if ($p === false)
            return "";
        $content = substr($content, $p);
        $p = stripos($content, " ", 0);
        if (abs($p) == 0)
            return "";
        $open_tag = substr($content, 0, $p);
        $close_tag = substr($open_tag, 0, 1) . "/" . substr($open_tag, 1) . ">";

        $count_inner_tag = 0;
        $p_open_inner_tag = 1;
        $p_close_inner_tag = 0;
        $count = 1;
        do {
            $p_open_inner_tag = stripos($content, $open_tag, $p_open_inner_tag);
            $p_close_inner_tag = stripos($content, $close_tag, $p_close_inner_tag);
            $count++;
            if ($p_close_inner_tag !== false)
                $p = $p_close_inner_tag;
            if ($p_open_inner_tag !== false) {
                if (abs($p_open_inner_tag) < abs($p_close_inner_tag)) {
                    $count_inner_tag++;
                    $p_open_inner_tag++;
                } else {
                    $count_inner_tag--;
                    $p_close_inner_tag++;
                }
            } else {
                $count_inner_tag--;
                if ($p_close_inner_tag > 0)
                    $p_close_inner_tag++;
            }
        }while ($count_inner_tag > 0);
        if ($include_tag)
            return substr($content, 0, $p + strlen($close_tag));
        else {
            $content = substr($content, 0, $p);
            $p = stripos($content, ">", 0);
            return substr($content, $p + 1);
        }
    }

    //$content = MyFunctions::fix_src_img_tag($content, "http://vnexpress.net");
    public function fix_src_img_tag($content, $url) {
        $p_start = 0;
        $start_tag = "<img";
        $loop = true;
        $double_ = true;
        if (substr($url, strlen($url) - 1, 1) == "/")
            $url = substr($url, 0, strlen($url) - 1);
        $src = "src=";
        $content = str_ireplace("src =", $src, $content);
        $content = str_ireplace("src= ", $src, $content);
        $len = 0;
        do {
            $p_start = stripos($content, $start_tag, $p_start);
            $len = 0;
            if ($p_start !== false) {
                $p_start = stripos($content, $src, $p_start + 1);
                if ($p_start > 0) {
                    $t = substr($content, strlen($src) + $p_start, 1);
                    if ($t == "\"" || $t == "'") {
                        $p_start += strlen($src) + 1;
                    } else {
                        $p_start += strlen($src);
                    }
                    $content = substr($content, 0, $p_start) . $url . substr($content, $p_start);
                }
                $p_start+=$len + 1;
            } else {
                $loop = false;
            }
        } while ($loop);
        return $content;
    }
    
    public function GetBetween($var1,$var2,$pool){
        $temp1 = strpos($pool,$var1)+strlen($var1);
        $result = substr($pool,$temp1,strlen($pool));
        $dd=strpos($result,$var2);
        if($dd == 0){
            $dd = strlen($result);
        }

        return substr($result,0,$dd);
    }
    
    function find_between($string, $start, $end, $trim = true, $greedy = false) {
        $pattern = '/' . preg_quote($start) . '(.*';
        if (!$greedy) $pattern .= '?';
        $pattern .= ')' . preg_quote($end) . '/';
        preg_match($pattern, $string, $matches);
        $string = $matches[0];
        if ($trim) {
            $string = substr($string, strlen($start));
            $string = substr($string, 0, -strlen($start) + 1);
        }
        return $string;
    }



    /*
     *
     * $arr_attribute = array(
			'start' => '<article',
			'end' => '</article',
			'title' => '/title=\"(.*?)\"/',
			'note' => '/class=\"summary\">(.*?)</',
			'datetime' => '/datetime=\"(.*?)\">(.*?)</',
			'image' => '/src=\"(.*?)\"/',
			'href' => '/href=\"(.*?)\"/',
		);
     */
    public function get_item_news($arr_attribute, $url, $cate, $url_cate, $domain, $limit = 0, $attribute = "class", $remove_image_link = true) {
        try {
            include_once ("Crawl.php");
            $H_Crawl = new H_Crawl ( );

            $content = $this->runBrowser($url_cate);
            if (isset($arr_attribute['content'])) {
                preg_match($arr_attribute['content'], $content, $matches);
                if ($matches)
                    $content = $matches[1];
            }

            if (isset($arr_attribute['replace_content']) && isset($arr_attribute['replace_content_to'])) {
                $content = str_replace($arr_attribute['replace_content'], $arr_attribute['replace_content_to'], $content);
            }

            $list = array();
            $bool = true;
            $i = 0;
            $href = "";
            $title = "";
            $attr = "";
            $content = str_ireplace("href =", "href=", $content);
            $content = str_ireplace("href= ", "href=", $content);

            do {
                if ($limit > 0 && $i == $limit)
                    break;

                $p_start = 0;
                $p_end = 0;
                $p_start = strpos($content, $arr_attribute['start'], $p_start);

                if ($p_start !== false) {
                    $p_end = strpos($content, $arr_attribute['end'], $p_start);

                    if ($p_end > 0) {
                        $temp = substr($content, $p_start, $p_end - $p_start);

                        $content = substr($content, $p_end, strlen($content) - 1);

                        $href = $img = $title = $note = $date = '';

                        preg_match($arr_attribute['href'], $temp, $matches);
                        if ($matches)
                            $href = str_ireplace($url, '', $matches[1]);

                        preg_match($arr_attribute['image'], $temp, $matches);
                        if ($matches)
                            $img = $matches[1];

                        preg_match($arr_attribute['title'], $temp, $matches);
                        if ($matches)
                            $title = $matches[1];

                        $is_match = explode('(.*?)', $arr_attribute['note']);
                        if (count($is_match) > 1) {
                            preg_match($arr_attribute['note'], $temp, $matches);
                            if ($matches)
                                $note = $matches[1];
                        } else {
                            $note = trim($H_Crawl->getTitle($url_cate, $arr_attribute['note']));
                        }

//                        preg_match($arr_attribute['note'], $temp, $matches);
//                        if ($matches)
//                            $note = $matches[1];

                        preg_match($arr_attribute['datetime'], $temp, $matches);
                        if ($matches) {
                            $date = $matches[1];
                            if (empty($date) || $date != '') {
                                if(isset($matches[1])) {
                                    $date = $matches[2];
                                }
                            }
                        }
                        //echo '<pre>'; print_r($p_start);die;
                        if ($title != '' && $href != '' && $img != '') {
                            $id_item = md5($title . 'kenhtraitim');
                            if (!isset($list[$i][$id_item])) {
                                $list[$i]['id'] = $id_item;
                                $title = trim(str_replace("&nbsp;", " ", $title));
                                if ($href[0] == '/') {
                                    $list[$i]['href'] = substr(strip_tags($href),1);
                                    $list[$i]['href_root'] = substr(strip_tags($href),1);
                                } else {
                                    $list[$i]['href'] = strip_tags($href);
                                    $list[$i]['href_root'] = strip_tags($href);
                                }

                                $href_end = '';
                                if (isset($arr_attribute['replace_href']) && isset($arr_attribute['replace_href_to'])) {
                                    foreach ($arr_attribute['replace_href'] as $item) {
                                        if (stripos($list[$i]['href'], $item) !== false) {
                                            $list[$i]['href'] = str_replace($item, '', $list[$i]['href']);
                                            $href_end = $item;
                                            break;
                                        }
                                    }
                                }
                                $list[$i]['href'] = str_replace('/', '_', $list[$i]['href']);
                                if ($href_end != '' && $href_end != null) {
                                    $list[$i]['href'] = str_replace('/', '_', $list[$i]['href']) . '?t=' . $href_end;
                                }


                                $list[$i]['title'] = strip_tags(str_replace("hình ảnh", " ", $title));
                                $list[$i]['image'] = strip_tags(trim($img));
                                $list[$i]['note'] = trim($note);
                                $list[$i]['datetime'] = trim($date);
                                $list[$i]['domain'] = $domain;
                                $list[$i]['cate'] = $cate;
                                $list[$i]['url_cate'] = $url_cate;


                                $i++;

                            }
                        }
                    }
                } else {
                    $bool = false;
                }
            } while ($bool);
        } catch(Exception $e) {
            $list = array();
        }
        return $list;
    }

    public function get_list_news($arr_attribute, $url, $cate, $url_cate, $domain, $limit = 0, $attribute = "class", $remove_image_link = true) {
        $list = array();
        foreach ($arr_attribute as $key => $val) {
            $limit = $limit - count($list);
            $list = array_merge($list, $this->get_item_news($val, $url, $cate, $url_cate, $domain, $limit, $attribute, $remove_image_link));
        }
        return $list;
    }

    public function get_detail($arr_attribute, $url, $url_domain, $url_detail) {
        $detail = array();
        foreach ($arr_attribute as $key => $val) {
            $detail = $this->_get_detail($val, $url, $url_domain, $url_detail);
            if (isset($detail['title']) && isset($detail['note']) && isset($detail['content']) && !empty($detail['title']) && !empty($detail['note']) && !empty($detail['content'])) {
                break;
            }
        }
        return $detail;
    }
    
    public function _get_detail($arr_attribute, $url, $url_domain, $url_detail) {
        include_once ("Crawl.php");
        $H_Crawl = new H_Crawl ( );

        $content = $this->runBrowser($url);
        $content = str_ireplace("href =", "href=", $content);
        $content = str_ireplace("href= ", "href=", $content);
        $content = str_ireplace("href=" . $url_domain, "href=", $content);

        $detail = array();
        foreach ($arr_attribute as $key => $value) {
            $is_match = explode('(.*?)', $value);
        
            if (count($is_match) > 1) {
                preg_match($value, $content, $matches);

                if ($matches) {
                    $detail[$key] = trim($matches[1]);
                }
            } else {
                $str_robot = trim($H_Crawl->getTitle($url, $value));
                $detail[$key] = $str_robot;
            }

//            if ($key == 'content' && $url_domain == 'http://kenh14.vn/') {
//                $video = '';
//                preg_match('/data-src=\"(.*?)\"/', $detail[$key], $matches);
//                if ($matches)
//                    $video = str_ireplace($url, '', $matches[1]);
//                if (!empty($video))
//                    $video = '<p style="text-align: center;"><iframe class="video" align="middle" style="width: 100%; max-width: 500px; height:auto; min-height:300px; overflow: hidden; margin: 20px auto; border: 0px;" src="' . base_url('video?u=') . $video . '"></iframe></p>';
//                $detail[$key] = $video . $detail[$key];
//
//                //$content = str_ireplace("href=", "href=", $content);
//            }
            $detail[$key] = str_ireplace($url, '', $detail[$key]);
            $detail[$key] = str_ireplace('href="', 'href="' . $url_detail, $detail[$key]);
        }

        return $detail;
    }

    public function get_meta($arr_attribute, $url) {
        $content = $this->runBrowser($url);
        $content = str_ireplace("href =", "href=", $content);
        $content = str_ireplace("href= ", "href=", $content);

        $meta = array();
        foreach ($arr_attribute as $key => $value) {
            preg_match($value, $content, $matches);//echo '<pre>'; print_r($content);
            if ($matches) {
                $meta[$key] = strip_tags(trim(str_replace(array('"', "'"), '', $matches[1])));
                if ($key == 'description' || $key == 'keywords') {
                    $meta[$key] = str_replace(array('VnExpress', 'vnexpress', '.net' , 'Kênh 14', 'kenh14', 'zing', 'Zing'), array('','','','','','',''), $meta[$key]);
                }
            }
        }

        return $meta;
    }

    public function get_menu($arr_attribute, $url_domain, $domain_id) {
        include_once ("Crawl.php");
        $H_Crawl = new H_Crawl ( );

        $list = array();
        $bool = true;
        $i = 0;
        $id_cate = 1;
        $href = "";
        $title = "";
        $attr = "";

        if (isset($arr_attribute['content'])) {
            $content = $H_Crawl->getTitle($url_domain, $arr_attribute['content']);
        } else {
            $content = $this->runBrowser($url_domain);
        }

        $content = str_ireplace("href =", "href=", $content);
        $content = str_ireplace("href= ", "href=", $content);

        do {
            $p_start = 0;
            $p_end = 0;
            $p_start = strpos($content, $arr_attribute['start'], $p_start);

            if ($p_start !== false) {
                $p_end = strpos($content, $arr_attribute['end'], $p_start);

                if ($p_end > 0) {
                    $temp = substr($content, $p_start, $p_end - $p_start);

                    $content = substr($content, $p_end, strlen($content) - 1);

                    $href = $title = $id = '';
                    preg_match($arr_attribute['href'], $temp, $matches);
                    if ($matches) {
                        $id = md5($url_domain . str_ireplace($url_domain, '', $matches[1]));
                        $href = str_ireplace($url_domain, '', $matches[1]);
                    }

                    preg_match($arr_attribute['title'], $temp, $matches);
                    if ($matches) {
                        $title = $matches[1];
                    }

                    if ($title != '' && $href != '') {
                        $key = array_search($id, array_column($list, 'key'));
                        $title = trim(str_replace("&nbsp;", " ", $title));
                        
                        $is_add_menu = false;
                        if (isset($arr_attribute['not_show'])) {
                            if (stripos($arr_attribute['not_show'], $title) !== false) {
                                $is_add_menu = true;
                            }
                        }
                        if (!$key && $is_add_menu == false) {
                            $list[$i]['id'] = $id_cate;
                            $list[$i]['key'] = $id;
                            $list[$i]['href'] = $href;

                            if (isset($arr_attribute['replace_from']) && isset($arr_attribute['replace_to'])) {
                                $href = str_replace($arr_attribute['replace_from'], $arr_attribute['replace_to'],$href);
                            }
                            if ($href[0] == '/') {
                                $list[$i]['href_show'] = substr(str_replace('/','-',$href),1);
                            } else {
                                $list[$i]['href_show'] = str_replace('/','-',$href);
                            }

                            $list[$i]['title'] = trim($title);
                            $list[$i]['domain_id'] = $domain_id;
                            $i++;
                            $id_cate++;
                        }
                    }
                }
            } else {
                $bool = false;
            }
        } while ($bool);

        foreach ($list as $key => $val) {
            foreach ($list as $k => $v) {
                if ($val['key'] == $v['key']) {
                    $list[$k] = $list[$key];
                }
            }
        }
        return $this->multi_unique($list);
    }

    public function multi_unique($src){
        $output = array_map("unserialize",
            array_unique(array_map("serialize", $src)));
        return $output;
    }

    public function runBrowser($url) {
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Konqueror/4.0; Microsoft Windows) KHTML/4.0.80 (like Gecko)");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            $response = curl_exec($ch);
            curl_close($ch);
        } else {
            $response = @file_get_contents($url);
        }

        return $response;
    }

}

?> 