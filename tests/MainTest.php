<?php

use PHPUnit\Framework\TestCase;
use Tripay\Main;

class MainTest extends TestCase {

    /**
     * @var Main
     */
    private $main;

    /**
     * MainTest constructor.
     */
    public function __construct()
    {
        $this->main = new Main(
            'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'
            'xxxxxxxxxxxxxxxxx',
            'xxxxx',
            'xxxxx'
        );
    }

    public function testChannelPembayaran() {
        $check = $this->main->initChannelPembayaran()->getSuccess();
        $this->assertSame(true, $check);
    }
}
