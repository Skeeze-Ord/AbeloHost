<!DOCTYPE html>
<html lang="ru">
    {include file="site/head.tpl"}
<body>

{include file="site/header.tpl"}

<main>
    {include file="site/heading.tpl"}

    <div class="container">
        <article class="post-page">
            <div class="post-main-card">
                <div class="post-main-card__image">
                    <img src="/assets/images/posts/{$post->image}"
                         alt="{$post->title|escape}"
                         loading="lazy">
                </div>
                <div class="post-main-card__content">
                    <div class="post-main-card__text">
                        {$post->content nofilter}
                    </div>
                    <div class="post-main-card__meta">
                        <span>{$post->publishedAt|date_format:"%d.%m.%Y"}</span>
                        <span>👁 {$post->viewsCount}</span>
                    </div>
                </div>
            </div>

            {if $similarPosts}
                <section class="similar-posts">
                    <h2 class="similar-posts__title">Похожие статьи</h2>

                    <div class="posts">
                        {foreach $similarPosts as $similarPost}
                            <article class="post-card">
                                <a href="/posts/{$similarPost->id}">
                                    <img src="/assets/images/posts/{$similarPost->image}"
                                         alt="{$similarPost->title|escape}"
                                         class="post-card__image"
                                         loading="lazy">
                                </a>
                                <div class="post-card__body">
                                    <h3 class="post-card__title">
                                        <a href="/posts/{$similarPost->id}">{$similarPost->title|escape}</a>
                                    </h3>
                                    <p class="post-card__description">{$similarPost->description|escape}</p>
                                    <div class="post-card__meta">
                                        <span>{$similarPost->publishedAt|date_format:"%d.%m.%Y"}</span>
                                        <span>👁 {$similarPost->viewsCount}</span>
                                    </div>
                                </div>
                            </article>
                        {/foreach}
                    </div>
                </section>
            {/if}
        </article>
    </div>
</main>

{include file="site/footer.tpl"}

</body>
</html>