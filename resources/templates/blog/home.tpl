<!DOCTYPE html>
<html lang="ru">
    {include file="site/head.tpl"}
<body>

{include file="site/header.tpl"}

<main>
    {include file="site/heading.tpl"}

    <div class="container">
        {foreach $result as $categoryData}
            <section class="category-section">
                <div class="category-section__header">
                    <div>
                        <h2 class="category-section__title">{$categoryData.category->name}</h2>
                        <p class="category-section__description">{$categoryData.category->description}</p>
                    </div>
                    <a href="/categories/{$categoryData.category->id}" class="category-section__link">Все статьи →</a>
                </div>
                <div class="posts">
                    {foreach $categoryData.posts as $post}
                        <article class="post-card">
                            <a href="/posts/{$post->id}">
                                <img src="/images/{$post->image}"
                                     alt="{$post->title}"
                                     class="post-card__image">
                            </a>
                            <div class="post-card__body">
                                <h3 class="post-card__title">
                                    <a href="/posts/{$post->id}">{$post->title}</a>
                                </h3>
                                <p class="post-card__description">{$post->description}</p>
                                <div class="post-card__meta">
                                    <span>{$post->publishedAt}</span>
                                    <span>👁 {$post->viewsCount}</span>
                                </div>
                            </div>
                        </article>
                    {/foreach}
                </div>
            </section>
        {/foreach}
    </div>
</main>

{include file="site/footer.tpl"}

</body>
</html>