<?php
$this->load->model('news_model');
$articles = $this->news_model->find_all(array('published' => 'yes'), 'date_added desc', 3);

$count_item = 0;
?>

<div class="mag_news">
    <div class="head">
        <div class="headerobjectswrapper">
            <div class="weatherforcastbox"><span style="font-style: italic;">Weatherforcast for the next 24 hours: Plenty of Sunshine</span><br><span>Wind: 7km/h SSE; Ther: 21&deg;C; Hum: 82%</span></div>
            <header>Newpost York</header>
        </div>

        <div class="subhead">York, MA - Thursday August 30, 1978 - Seven Pages</div>
    </div>
    <div class="content">
        <?php if (!empty($articles)) : ?>
            <div class="collumns">
                <div class="collumn">
                <?php foreach($articles as $article) : ?>
                    <?php if ($count_item > 0 && $count_item % 1 == 0) : ?>
                        </div>
                        <div class="collumn">
                    <?php endif; ?>
                    <figure class="figure">
                        <img class="media" src="<?= $article->main_image ?>" alt="">
                        <figcaption class="figcaption">Hermine hoping for courage.</figcaption>
                    </figure>
                    <div class="head">
                        <span class="headline hl3"><?= $article->title ?></span>
                        <p><span class="headline hl4"><?= $article->content_filtered ?></span></p>
                    </div>
                    <?php $count_item++; ?>
                <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
