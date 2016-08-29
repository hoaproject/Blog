<?php

use Hoa\Router;

$router = new Router\Http();
$router
    ->get(
        'home',
        '/'
    )
    ->get(
        'page',
        '/(?<pathname>[\w\d\-_]+)'
    )
    ->get(
        'post',
        '/(?<pathname>[\w\d\-_]+)'
    )
    ->_get(
        '_resource',
        'https://static.hoa-project.net/(?<resource>)'
    )
    ->_get(
        'g',
        'https://hoa-project.net/'
    )
    ->_get(
        's',
        'https://hoa-project.net/Source.html'
    )
    ->_get(
        'l',
        'https://hoa-project.net/Literature.html'
    )
    ->_get(
        'lh',
        'https://hoa-project.net/Literature/Hack/(?<chapter>).html'
    )
    ->_get(
        'v',
        'https://hoa-project.net/Video.html'
    )
    ->_get(
        'v+',
        'https://hoa-project.net/Awecode/(?<id>).html'
    )
    ->_get(
        'ev',
        'https://hoa-project.net/Event.html'
    )
    ->_get(
        'ev+',
        'https://hoa-project.net/Event/(?<_able>).html'
    )
    ->_get(
        'lists',
        'https://lists.hoa-project.net/lists'
    )
    ->_get(
        'forum',
        'http://forum.hoa-project.net'
    )
    ->_get(
        'a',
        'https://hoa-project.net/About.html'
    )
    ->_get(
        'f',
        'https://hoa-project.net/Foundation.html'
    )
    ->_get(
        'f+',
        'https://hoa-project.net/Foundation/(?<_able>).html'
    )
    ->_get(
        'c',
        'https://hoa-project.net/Community.html'
    )
    ->_get(
        'u',
        'https://hoa-project.net/Whouse/(?<who>).html'
    )

    ->_get('twitter', 'https://twitter.com/hoaproject')
    ->_get('github',  'https://github.com/hoaproject/(?<repository>)');

return $router;
