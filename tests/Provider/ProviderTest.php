<?php

namespace Yii\EventDispatcher\Tests\Provider;

use PHPUnit\Framework\TestCase;
use Yii\EventDispatcher\Provider\Provider;
use Yii\EventDispatcher\Tests\Event\Event;
use Yii\EventDispatcher\Tests\Listener\NonStatic;
use Yii\EventDispatcher\Tests\Listener\Invokable;
use Yii\EventDispatcher\Tests\Listener\WithStaticMethod;

class ProviderTest extends TestCase
{
    public function testAttachCallableArray()
    {
        $provider = new Provider();
        $provider->attach([WithStaticMethod::class, 'handle']);

        $listeners = $provider->getListenersForEvent(new Event());
        $this->assertCount(1, $listeners);
    }

    public function testAttachCallableFunction()
    {
        $provider = new Provider();
        $provider->attach('Yii\EventDispatcher\Tests\Provider\handle');

        $listeners = $provider->getListenersForEvent(new Event());
        $this->assertCount(1, $listeners);
    }

    public function testAttachClosure()
    {
        $provider = new Provider();
        $provider->attach(function (Event $event) {
            // do nothing
        });

        $listeners = $provider->getListenersForEvent(new Event());
        $this->assertCount(1, $listeners);
    }

    public function testAttachCallableObject()
    {
        $provider = new Provider();
        $provider->attach([new NonStatic(), 'handle']);

        $listeners = $provider->getListenersForEvent(new Event());
        $this->assertCount(1, $listeners);
    }

    public function testInvokable()
    {
        $provider = new Provider();
        $provider->attach(new Invokable());

        $listeners = $provider->getListenersForEvent(new Event());
        $this->assertCount(1, $listeners);
    }
}

function handle(Event $event)
{
    // do nothing
}
