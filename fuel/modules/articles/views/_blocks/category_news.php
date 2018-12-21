<?php
$this->load->model('news_model');
$this->load->model('fuel_categories_model');

$categories = $this->fuel_categories_model->find_all(array('published' => 'yes', 'context' => 'news'));


?>
<div class="row">
    <?php foreach($categories as $category) : ?>
        <?php
        $articles = $this->news_model->find_all(array('published' => 'yes', 'category_id' => $category->id), 'date_added desc', 8);
        $count_item = 0;
        ?>
        <?php if (!empty($articles)) : ?>


            <?php foreach($articles as $article) : ?>
                <?php if ($count_item < 1) : ?>
                    <div class="col-md-12">
                        <div class="post post-thumb">
                            <a class="post-img" href="blog-post.html"><img src="<?= $article->main_image ?>" alt=""></a>
                            <div class="post-body">
                                <div class="post-meta">
                                    <a class="post-category cat-3" href="category.html">Jquery</a>
                                    <span class="post-date">March 27, 2018</span>
                                </div>
                                <h3 class="post-title"><a href="blog-post.html"><?= $article->name ?></a></h3>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-md-6">
                        <div class="post">
                            <a class="post-img" href="blog-post.html"><img src="<?= $article->main_image ?>" alt=""></a>
                            <div class="post-body">
                                <div class="post-meta">
                                    <a class="post-category cat-4" href="category.html">Css</a>
                                    <span class="post-date">March 27, 2018</span>
                                </div>
                                <h3 class="post-title"><a href="blog-post.html"><?= $article->title ?></a></h3>
                            </div>
                        </div>
                    </div>
                    <?php if ($count_item > 0 && $count_item % 2 == 0) : ?>
                        <div class="clearfix visible-md visible-lg"></div>
                    <?php endif; ?>
                <?php endif; ?>
                <?php $count_item++; ?>
            <?php endforeach; ?>


            <!-- /row -->
        <?php endif; ?>
    <?php endforeach; ?>
</div>
