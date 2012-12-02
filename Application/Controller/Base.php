<?php

namespace {

from('Hoa')
-> import('Dispatcher.Kit')
-> import('Session.~');

from('Hoathis')
-> import('Kit.Aggregator');

}

namespace Application\Controller {

class Base extends \Hoathis\Kit\Aggregator { }

}