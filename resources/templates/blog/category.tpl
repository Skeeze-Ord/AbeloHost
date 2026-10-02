<!DOCTYPE html>
<html lang="ru">
    {include file="site/head.tpl"}
<body>

{include file="site/header.tpl"}

<main>
    {include file="site/heading.tpl"}

    <div class="container">
        <section class="category-page">
            <div class="category-page__sort">
                <span>Сортировка:</span>
                <a href="/categories/{$category->id}?sort=date"
                   class="{($sortMethod === '' || $sortMethod === 'date') ? 'active' : ''}">
                    По дате
                </a>
                <a href="/categories/{$category->id}?sort=views"
                   class="{($sortMethod === 'views') ? 'active' : ''}">
                    По просмотрам
                </a>
            </div>
            <div class="posts">
                {foreach $posts as $post}
                    <article class="post-card">
                        <a href="/posts/{$post->id}">
                            <img src="/assets/images/posts/{$post->image}"
                                 alt="{$post->title|escape}"
                                 class="post-card__image"
                                 loading="lazy">
                        </a>
                        <div class="post-card__body">
                            <h2 class="post-card__title">
                                <a href="/posts/{$post->id}">{$post->title|escape}</a>
                            </h2>
                            <p class="post-card__description">{$post->description|escape}</p>
                            <div class="post-card__meta">
                                <span>{$post->publishedAt|date_format:"%d.%m.%Y"}</span>
                                <span>👁 {$post->viewsCount}</span>
                            </div>
                        </div>
                    </article>
                {/foreach}
            </div>

            {if $totalPages > 1}
                <nav class="pagination">
                    {for $page = 1 to $totalPages}
                        <a href="/categories/{$category->id}?sort={$sortMethod}&page={$page}"
                           class="{$page === $currentPage ? 'active' : ''}">
                            {$page}
                        </a>
                    {/for}
                </nav>
            {/if}
        </section>
    </div>
</main>

{include file="site/footer.tpl"}

</body>
</html>