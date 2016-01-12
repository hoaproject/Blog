<?php

require_once dirname(dirname(__DIR__)) .
             DIRECTORY_SEPARATOR . 'Data' .
             DIRECTORY_SEPARATOR . 'Core.link.php';

use Hoa\Consistency;
use Hoa\Database;
use Hoa\Dispatcher;
use Hoa\File;
use Hoa\Http;
use Hoa\Protocol;
use Hoa\Router;
use Hoa\Xyl;
use Hoathis\Kit;
use Hoathis\Xyl\Interpreter\Html\Html;

$autoloader = new Consistency\Autoloader();
$autoloader->addNamespace('Application', dirname(__DIR__));
$autoloader->addNamespace('Hoathis', dirname(dirname(__DIR__)) . DS . 'Data' . DS . 'Library' . DS . 'Hoathis' . DS);
$autoloader->register();

Protocol::getInstance()['Application']->setReach(dirname(__DIR__) . DS);
Protocol::getInstance()['Data']->setReach(dirname(dirname(__DIR__)) . DS . 'Data' . DS);

Database\Dal::initializeParameters([
    'connection.list.default.dal' => Database\Dal::PDO,
    'connection.list.default.dsn' => 'sqlite:hoa://Data/Variable/Database/Blog.sqlite',
    'connection.autoload'         => 'default'
]);

$dispatcher = new Dispatcher\ClassMethod([
    'synchronous.call'  => 'Application\Controller\(:call:U:)',
    'synchronous.able'  => '(:able:U:)Action',
    'asynchronous.call' => '(:%synchronous.call:)',
    'asynchronous.able' => '(:%synchronous.able:)'
]);
$dispatcher->setKitName('Hoathis\Kit\Aggregator');
$router     = new Router\Http();
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
       ->_get('v',     '/Video.html',      null, null, array('_subdomain' => '__root__'))
       ->_get('v+',    '/Awecode/(?<id>).html', null, null, array('_subdomain' => '__root__'))
       ->_get('ev',    '/Event.html',      null, null, array('_subdomain' => '__root__'))
       ->_get('ev+',   '/Event/(?<_able>).html', null, null, array('_subdomain' => '__root__'))
       ->_get('lists', 'http://lists.hoa-project.net/lists')
       ->_get('forum', 'http://forum.hoa-project.net')
       ->_get('a',     '/About.html',      null, null, array('_subdomain' => '__root__'))
       ->_get('f',     '/Foundation.html', null, null, array('_subdomain' => '__root__'))
       ->_get('f+',    '/Foundation/(?<_able>).html', null, null, array('_subdomain' => '__root__'))
       ->_get('c',     '/Community.html',    null, null, array('_subdomain' => '__root__'))
       ->_get('u',     '/Whouse/(?<who>).html', null, null, array('_subdomain' => '__root__'))

       ->_get('twitter', 'https://twitter.com/hoaproject')
       ->_get('github',  'https://github.com/hoaproject/(?<repository>)');

try {

    $dispatcher->dispatch(
        $router,
        new Xyl(
            new File\Read('hoa://Application/View/Main.xyl'),
            new Http\Response(),
            new Html(),
            $router
        )
    );
}
catch ( Router\Exception\NotFound $e ) {

    echo 'Your page seems to be not found /o\.', "\n";
}
