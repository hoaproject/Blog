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
        'http://static.hoa-project.net/(?<resource>)'
    )
    ->_get(
        'g',
        'http://hoa-project.net/'
    )
    ->_get(
        's',
        'http://hoa-project.net/Source.html'
    )
    ->_get(
        'l',
        'http://hoa-project.net/Literature.html'
    )
    ->_get(
        'lh',
        'http://hoa-project.net/Literature/Hack/(?<chapter>).html'
    )
    ->_get(
        'v',
        'http://hoa-project.net/Video.html'
    )
    ->_get(
        'v+',
        'http://hoa-project.net/Awecode/(?<id>).html'
    )
    ->_get(
        'ev',
        'http://hoa-project.net/Event.html'
    )
    ->_get(
        'ev+',
        'http://hoa-project.net/Event/(?<_able>).html'
    )
    ->_get(
        'lists',
        'http://lists.hoa-project.net/lists'
    )
    ->_get(
        'forum',
        'http://forum.hoa-project.net'
    )
    ->_get(
        'a',
        'http://hoa-project.net/About.html'
    )
    ->_get(
        'f',
        'http://hoa-project.net/Foundation.html'
    )
    ->_get(
        'f+',
        '/http://hoa-project.netFoundation/(?<_able>).html'
    )
    ->_get(
        'c',
        'http://hoa-project.net/Community.html'
    )
    ->_get(
        'u',
        'http://hoa-project.net/Whouse/(?<who>).html'
    )

    ->_get('twitter', 'https://twitter.com/hoaproject')
    ->_get('github',  'https://github.com/hoaproject/(?<repository>)');

return $router;
