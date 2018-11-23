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
}