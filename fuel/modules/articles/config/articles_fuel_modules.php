<?php 

//$config['modules']['articles'] = array(
//	'preview_path' => '', // put in the preview path on the site e.g products/{slug}
//	'model_location' => 'articles', // put in the advanced module name here
//);

$config['modules']['news'] = array(
    'module_name' => 'News',
    'module_uri' => 'articles/news',
    'model_name' => 'news_model',
    'model_location' => 'articles',// put in the advanced module name here
    'display_field' => 'title',
    'preview_path' => 'news/{year}/{month}/{day}/{slug}',
    'permission' => array('news', 'create' => 'news/create', 'edit' => 'news/edit', 'publish' => 'news/publish', 'delete' => 'news/delete'),
    'instructions' => lang('module_instructions_default', 'News posts'),
    'archivable' => TRUE,
    'configuration' => array('articles' => 'articles'),
    'nav_selected' => 'articles/news|articles/news/:any',
//	'language' => array('blog' => 'blog'),
    'default_col' => 'publish_date',
    'default_order' => 'desc',
    'sanitize_input' => array('template','php'),
    'filters' => array(
        'category_id' => array('label' => lang('form_label_category'), 'type' => 'select', 'model' => array(FUEL_FOLDER => 'fuel_categories_model'), 'first_option' => lang('label_select_one')),
        'author_id' => array('label' => lang('form_label_author'), 'type' => 'select', 'model' => array(BLOG_FOLDER => 'blog_users_model'), 'first_option' => lang('label_select_one'))

    ),
    'advanced_search' => TRUE
);