<?php

namespace {

require_once dirname(dirname(__DIR__)) .
             DIRECTORY_SEPARATOR . 'Data' .
             DIRECTORY_SEPARATOR . 'Core.link.php';

from('Hoa')
-> import('Database.Dal')
-> import('Dispatcher.Basic')
-> import('Router.Http')
-> import('Xyl.~')
-> import('File.Read')
-> import('Http.Response.~');

from('Hoathis')
-> import('Xyl.Interpreter.Html.~');

Hoa\Database\Dal::initializeParameters(array(
    'connection.list.default.dal' => Hoa\Database\Dal::PDO,
    'connection.list.default.dsn' => 'sqlite:hoa://Data/Variable/Database/Blog.sqlite',
    'connection.autoload'         => 'default'
));

$dispatcher = new Hoa\Dispatcher\Basic();
$dispatcher->setKitName('Hoathis\Kit\Aggregator');
$router     = new Hoa\Router\Http();
$router->get('posts',       '/',                               'posts', 'index')
       ->get('post',        '/posts/(?<id>\d+)\-(?<normalized_title>.+)\.html', 'posts', 'show')
       ->post('create_comment',    '/posts/(?<post_id>\d+)/comments/create','comments', 'create')
       ->get('admin',       '/admin',                          'admin\log', 'in')
       ->get('log',         '/admin/log',                      'admin\log',   'index')
       ->post('login',      '/admin/log/in',                   'admin\log',   'in')
       ->get('logout',      '/admin/log/out',                  'admin\log',   'out')
       ->get('admin_posts', '/admin/posts',                    'admin\posts', 'index')
       ->get('new_post',    '/admin/posts/new',                'admin\posts', 'new')
       ->post('create_post','/admin/posts/create',             'admin\posts', 'create')
       ->get('edit_post',   '/admin/posts/(?<id>\d+)/edit',    'admin\posts', 'edit')
       ->post('update_post','/admin/posts/(?<id>\d+)',         'admin\posts', 'update')
       ->get('delete_post', '/admin/posts/(?<id>\d+)/delete',  'admin\posts', 'delete')
       ->get('api_posts',   '/api/posts',                      'api\posts', 'index')

       ->_get('_resource', 'http://static.hoa-project.net/(?<resource>)')
       ->_get('g',     '/',                null, null, array('_subdomain' => '__root__'))
       ->_get('s',     '/Source.html',     null, null, array('_subdomain' => '__root__'))
       ->_get('l',     '/Literature.html', null, null, array('_subdomain' => '__root__'))
       ->_get('lh',    '/Literature/Hack/(?<chapter>).html', null, null, array('_subdomain' => '__root__'))
       ->_get('v',     '/Awecode.html',    null, null, array('_subdomain' => '__root__'))
       ->_get('v+',    '/Awecode/(?<id>).html', null, null, array('_subdomain' => '__root__'))
       ->_get('ev',    '/Event.html',      null, null, array('_subdomain' => '__root__'))
       ->_get('ev+',   '/Event/(<?_able>).html', null, null, array('_subdomain' => '__root__'))
       ->_get('lists', 'http://lists.hoa-project.net/index.cgi/lists')
       ->_get('forum', 'http://forum.hoa-project.net')
       ->_get('a',     '/About.html',      null, null, array('_subdomain' => '__root__'))
       ->_get('f',     '/Foundation.html', null, null, array('_subdomain' => '__root__'))
       ->_get('f+',    '/Foundation/(?<_able>).html', null, null, array('_subdomain' => '__root__'))
       ->_get('c',     '/Community.html',    null, null, array('_subdomain' => '__root__'))
       ->_get('u',     '/Whouse/(?<who>).html', null, null, array('_subdomain' => '__root__'))

       ->_get('github', 'https://github.com/hoaproject/(?<repository>)');

try {

    $dispatcher->dispatch(
        $router,
        new Hoa\Xyl(
            new Hoa\File\Read('hoa://Application/View/Main.xyl'),
            new Hoa\Http\Response(),
            new Hoathis\Xyl\Interpreter\Html(),
            $router
        )
    );
}
catch ( Hoa\Router\Exception\NotFound $e ) {

    echo 'Your page seems to be not found /o\.', "\n";
}

}
