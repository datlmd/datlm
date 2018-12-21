<?php
$this->load->model('news_model');
$articles = $this->news_model->find_all(array('published' => 'yes'), 'date_added desc', 8);

$count_item = 0;
?>

<?php if (!empty($articles)) : ?>
    <!-- row -->
    <div class="row">
    <!--            <div class="col-md-12">-->
    <!--                <div class="section-title">-->
    <!--                    <h2>Recent Posts</h2>-->
    <!--                </div>-->
    <!--            </div>-->
    <?php foreach($articles as $article) : ?>
        <?php if ($count_item < 2) : ?>
            <div class="col-md-6">
                <div class="post post-thumb">
                    <a class="post-img" href="blog-post.html"><img src="<?= $article->main_image ?>" alt="<?= $article->title ?>"></a>
                    <div class="post-body">
                        <div class="post-meta">
                            <a class="post-category cat-2" href="category.html">JavaScript</a>
                            <span class="post-date">March 27, 2018</span>
                        </div>
                        <h3 class="post-title"><a href="blog-post.html"><?= $article->title ?></a></h3>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <?php if ($count_item == 2) : ?>
                </div>
                <!-- /row -->
                <!-- row -->
                <div class="row">
                <?php $count_item = 3; ?>
            <?php endif; ?>
            <?php if ($count_item > 0 && $count_item % 3 == 0) : ?>
                <div class="clearfix visible-md visible-lg"></div>
            <?php endif; ?>
            <div class="col-md-4">
                <div class="post">
                    <a class="post-img" href="blog-post.html"><img src="<?= $article->main_image ?>" alt="<?= $article->title ?>"></a>
                    <div class="post-body">
                        <div class="post-meta">
                            <a class="post-category cat-1" href="category.html">Web Design</a>
                            <span class="post-date">March 27, 2018</span>
                        </div>
                        <h3 class="post-title"><a href="blog-post.html"><?= $article->title ?></a></h3>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php $count_item++; ?>
    <?php endforeach; ?>
    </div>
    <!-- /row -->
<?php endif; ?>