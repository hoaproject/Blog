<?php

namespace {

from('Hoa')
-> import('Dispatcher.Kit')
-> import('Session.~')
-> import('Session.QNamespace');

from('Hoathis')
-> import('Kit.Aggregator');

}

namespace Application\Controller {

class Base extends \Hoathis\Kit\Aggregator {
}

}