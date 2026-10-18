<article class="story-card" data-category="<?= e($story['category']) ?>">
    <a class="story-image" href="/seller-stories/<?= e($story['slug']) ?>"><img src="<?= e($story['image']) ?>" alt="<?= e($story['image_alt']) ?>" width="800" height="960" loading="lazy"><span class="round-link"><?= icon('arrow-up-right') ?></span></a>
    <div class="story-meta"><span><?= e($story['category']) ?></span><span><?= e($story['read_time']) ?> min read</span></div>
    <h3><a href="/seller-stories/<?= e($story['slug']) ?>"><?= e($story['title']) ?></a></h3>
    <p><?= e($story['description']) ?></p>
</article>
