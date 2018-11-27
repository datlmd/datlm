<div id="fuel_main_content_inner" class="dashboard_module">
	<p class="instructions">This view is located in the fuel/modules/articles/views/_admin/ folder.</p>

    <?php foreach($menus as $menu) : ?>
        <?=$menu['title']?><br/>
        <?php foreach($menu['articles'] as $article) : ?>
            <?=$article['title']?><br/>
        <?php endforeach; ?>
        <hr>
    <?php endforeach; ?>
</div>