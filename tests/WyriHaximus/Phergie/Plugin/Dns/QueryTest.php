<?php
/**
 * This file is part of PhergieDns.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WyriHaximus\Phergie\Plugin\Dns;

/**
 * Tests for the Query class.
 *
 * @category Phergie
 * @package WyriHaximus\Phergie\Plugin\Dns
 */
class QueryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetHostname()
    {
        $query = new Query('wyrihaximus.net', function() {}, function() {});

        $this->assertSame('wyrihaximus.net', $query->getHostname());
    }

    public function testCallResolve()
    {
        $callbackFired = false;
        $that = $this;
        $callback = function($ip) use (&$callbackFired, $that) {
            $that->assertSame('foo:bar', $ip);
            $callbackFired = true;
        };

        $query = new Query('wyrihaximus.net', $callback, function() {});

        $query->callResolve('foo:bar');

        $this->assertTrue($callbackFired);
    }

    public function testCallReject()
    {
        $callbackFired = false;
        $that = $this;
        $callback = function($ip) use (&$callbackFired, $that) {
            $that->assertSame('foo:bar', $ip);
            $callbackFired = true;
        };

        $query = new Query('wyrihaximus.net', function() {}, $callback);

        $query->callReject('foo:bar');

        $this->assertTrue($callbackFired);
    }
}
