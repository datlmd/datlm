<?php
$this->load->model('news_model');
$this->load->model('news_model');
$articles = $this->news_model->find_all(array('published' => 'yes'), 'date_added desc', 8);

$count_item = 0;
?>


<!-- row -->
<div class="row">
    <div class="col-md-8">
        <div class="row">
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
        </div>
    </div>

    <div class="col-md-4">
        <!-- post widget -->
        <div class="aside-widget">
            <div class="section-title">
                <h2>Most Read</h2>
            </div>

            <div class="post post-widget">
                <a class="post-img" href="blog-post.html"><img src="./img/widget-1.jpg" alt=""></a>
                <div class="post-body">
                    <h3 class="post-title"><a href="blog-post.html">Tell-A-Tool: Guide To Web Design And Development Tools</a></h3>
                </div>
            </div>

            <div class="post post-widget">
                <a class="post-img" href="blog-post.html"><img src="./img/widget-2.jpg" alt=""></a>
                <div class="post-body">
                    <h3 class="post-title"><a href="blog-post.html">Pagedraw UI Builder Turns Your Website Design Mockup Into Code Automatically</a></h3>
                </div>
            </div>

            <div class="post post-widget">
                <a class="post-img" href="blog-post.html"><img src="./img/widget-3.jpg" alt=""></a>
                <div class="post-body">
                    <h3 class="post-title"><a href="blog-post.html">Why Node.js Is The Coolest Kid On The Backend Development Block!</a></h3>
                </div>
            </div>

            <div class="post post-widget">
                <a class="post-img" href="blog-post.html"><img src="./img/widget-4.jpg" alt=""></a>
                <div class="post-body">
                    <h3 class="post-title"><a href="blog-post.html">Tell-A-Tool: Guide To Web Design And Development Tools</a></h3>
                </div>
            </div>
        </div>
        <!-- /post widget -->

        <!-- post widget -->
        <div class="aside-widget">
            <div class="section-title">
                <h2>Featured Posts</h2>
            </div>
            <div class="post post-thumb">
                <a class="post-img" href="blog-post.html"><img src="./img/post-2.jpg" alt=""></a>
                <div class="post-body">
                    <div class="post-meta">
                        <a class="post-category cat-3" href="category.html">Jquery</a>
                        <span class="post-date">March 27, 2018</span>
                    </div>
                    <h3 class="post-title"><a href="blog-post.html">Ask HN: Does Anybody Still Use JQuery?</a></h3>
                </div>
            </div>

            <div class="post post-thumb">
                <a class="post-img" href="blog-post.html"><img src="./img/post-1.jpg" alt=""></a>
                <div class="post-body">
                    <div class="post-meta">
                        <a class="post-category cat-2" href="category.html">JavaScript</a>
                        <span class="post-date">March 27, 2018</span>
                    </div>
                    <h3 class="post-title"><a href="blog-post.html">Chrome Extension Protects Against JavaScript-Based CPU Side-Channel Attacks</a></h3>
                </div>
            </div>
        </div>
        <!-- /post widget -->

        <!-- ad -->
        <div class="aside-widget text-center">
            <a href="#" style="display: inline-block;margin: auto;">
                <img class="img-responsive" src="assets/theme/news/img/ad-1.jpg" alt="">
            </a>
        </div>
        <!-- /ad -->
    </div>
</div>