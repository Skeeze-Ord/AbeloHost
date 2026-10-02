<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{$metaTitle|escape} | AbeloHost</title>
    <meta name="description" content="{$metaDescription|default:''|escape}">

    <meta property="og:title" content="{$metaTitle|escape} | AbeloHost">
    <meta property="og:description" content="{$metaDescription|default:''|escape}">
    <meta property="og:type" content="website">
    {if $robots|default:''}
        <meta name="robots" content="{$robots}">
    {/if}

    <link rel="stylesheet" href="/assets/css/main.css">
</head>