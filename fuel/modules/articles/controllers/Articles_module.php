<?php
require_once(FUEL_PATH.'/libraries/Fuel_base_controller.php');

class Articles_module extends Fuel_base_controller {
	
	public $nav_selected = 'articles|articles/:any';

	function __construct()
	{
		parent::__construct();
        $this->config->module_load('articles', 'articles');
        $this->view_location = 'articles';
	}

	function index()
	{
		$vars['page_title'] = $this->fuel->admin->page_title(array(lang('module_articles')), FALSE);
		$crumbs = array('tools' => lang('section_tools'), lang('module_articles'));

		$this->fuel->admin->set_titlebar($crumbs, 'ico_articles');
		$this->fuel->admin->render('_admin/articles', $vars, '', ARTICLES_FOLDER);
	}

    function curl()
    {
        $vars['page_title'] = $this->fuel->admin->page_title(array(lang('module_articles')), FALSE);
        $crumbs = array('tools' => lang('section_tools'), lang('module_articles'));

        $this->load->library('robot');
        $info_domain = $this->get_attribute();

        $domain = $info_domain['domain'];
        $url_domain = $info_domain['url_domain'];
        $domain_id = $info_domain['domain_id'];

        $attribute_menu = $info_domain['attribute_menu'];
        $attribute_cate = $info_domain['attribute_cate'];

        $list_menu = $this->robot->get_menu($attribute_menu, $url_domain, $domain_id);

        $this->load->module_model(ARTICLES_FOLDER, 'news_model');
        $this->load->module_model(BLOG_FOLDER, 'blog_posts_model');

        foreach ($list_menu as $key => $menu) {
            if (stripos($menu['href'], "http://") !== false) {
                $url =  $menu['href'];
            } else {
                $url = $url_domain . str_replace(md5($url_domain), $url_domain, $menu['href']);
            }

            $list_news = $this->robot->get_list_news($attribute_cate, $url_domain , $menu['title'], $url, $domain, 5);
            foreach ($list_news as $k => $news) {
                $detail = $this->robot->get_detail($info_domain['attribute_detail'], $url_domain . $news['href_root'], $url_domain, base_url($info_domain['domain_id']));
                $list_news[$k]['detail'] = $detail;

                // create comment
                $news_detail = $this->news_model->create();

                $news_detail->title = $detail['title'];
                $news_detail->content_filtered = $detail['note'];
                $news_detail->content = $detail['content'];
                $news_detail->slug = $news['href_root'];
                $news_detail->main_image = $news['image'];
                $news_detail->page_title = $detail['title'];
                $news_detail->og_title = $detail['title'];
                $news_detail->resource_url = $news['href_root'];

                $news_detail->published = 'yes';
                $news_detail->save();

                // create comment
                $blog_detail = $this->blog_posts_model->create();

                $blog_detail->title = $detail['title'];
                $blog_detail->content_filtered = $detail['note'];
                $blog_detail->content = $detail['content'];
                $blog_detail->slug = $news['href_root'];
                $blog_detail->main_image = $news['image'];

                $blog_detail->published = 'yes';
                $blog_detail->save();


            }

            $list_menu[$key]['articles'] = $list_news;
        }

        $vars['menus'] = $list_menu;

        $this->fuel->admin->set_titlebar($crumbs, 'ico_articles');
        $this->fuel->admin->render('_admin/list_curl', $vars, '', ARTICLES_FOLDER);
    }

    public function get_attribute_kenh14() {
        $data['domain'] = 'K���nh 14';
        $data['domain_id'] = 2;
        $data['url_domain'] = 'http://kenh14.vn/';
        $data['slide_home'] = array(0,2,4);

        $data['attribute_menu'] = array(
            //'content' => 'div.navbar',
            'start' => 'kmli',
            'end' => '/a',
            'title' => '/title=\"(.*?)\"/',
            'href' => '/href=\"(.*?)\"/',
        );

        $data['attribute_cate'] = array(
            'attribute_cate_1' => array(
                'start' => 'ktncli',
                'end' => '</li',
                'title' => '/title=\"(.*?)\"/',
                'note' => '/span class=\"ktncli-sapo\">(.*?)</',
                'datetime' => '/span class=\"kscliw-time\"(.*?)title=\"(.*?)\"/',
                'image' => '/src=\"(.*?)\"/',
                'href' => '/href=\"(.*?)\"/',
            ),
            'attribute_cate_2' => array(
                'start' => 'knswli-left',
                'end' => '</li',
                'title' => '/title=\'(.*?)\'/',
                'note' => '/span class=\'knswli-sapo sapo-need-trim\'>(.*?)</',
                'datetime' => '/span class=\'kscliw-time\'(.*?)title=\'(.*?)\'/',
                'image' => '/src=\'(.*?)\'/',
                'href' => '/href=\'(.*?)\'/',
            ),
            'attribute_cate_3' => array(
                'start' => 'tsn-featured-news',
                'end' => '</h3',
                'title' => '/title=\"(.*?)\"/',
                'note' => '/span class=\"ktncli-sapo\">(.*?)</',
                'datetime' => '/span class=\"kscliw-time\"(.*?)title=\"(.*?)\"/',
                'image' => '/src=\"(.*?)\"/',
                'href' => '/href=\"(.*?)\"/',
            ),
            'attribute_cate_4' => array(
                'start' => 'tsn-news normal clearfix',
                'end' => '</li',
                'title' => '/title=\"(.*?)\"/',
                'note' => '/p class=\"tn-sapo\">(.*?)</',
                'datetime' => '/date-time(.*?)title=\"(.*?)\"/',
                'image' => '/src=\"(.*?)\"/',
                'href' => '/href=\"(.*?)\"/',
            ),
        );

        $data['attribute_detail'] = array (
            'attribute_detail_1' => array (
                'title' => '/h1 class=\"kbwc-title\">(.*?)</',
                'note' => '/h2 class=\"knc-sapo\<\/h2/"
(.*?)/',
                'content' => 'div.knc-content',
                'datetime'	=> 'span.kbwcm-time',
                //'author' 		=> '/class="author">(.*?)</',
            ),
        );

        $data['attribute_meta'] = array (
            'description'		=> '/name=\"description\" content=\"(.*?)\"/',
            'keywords'		=> '/name=\"keywords\" content=\"(.*?)\"/',
            'image_fb'		=> '/property=\"og:image\" content=\"(.*?)\"/',
        );

        return $data;
    }

    public function get_attribute($name = null)
    {
        $domain_name = $this->input->cookie('domain_kenhtraitim', true);

        if (!empty($name) && $domain_name != $name) {
            $domain_name = $name;
            $cookie= array(
                'name'   => 'domain_kenhtraitim',
                'value'  => $domain_name,
                'expire' => '86500',
            );
            $this->input->set_cookie($cookie);
        }

        switch ($domain_name) {
//            case 'zing':
//                $attribute = $this->get_attribute_zing();
//                break;
//            case 'kenh14':
//                $attribute = $this->get_attribute_kenh14();
//                break;
//            case 'vnexpress':
//                $attribute = $this->get_attribute_vnexpress();
//                break;
            default:
                $attribute = $this->get_attribute_kenh14();
        }

        return $attribute;
    }

    function current_url()
    {
        $CI =& get_instance();

        $url = $CI->config->site_url($CI->uri->uri_string());
        return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
    }
}