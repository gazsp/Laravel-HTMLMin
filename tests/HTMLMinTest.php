<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 * (c) Raza Mehdi <srmk@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HTMLMin\Tests\HTMLMin;

use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;
use HTMLMin\HTMLMin\HTMLMin;
use HTMLMin\HTMLMin\Minifiers\HtmlMinifier;
use Mockery;

/**
 * This is the htmlmin test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class HTMLMinTest extends AbstractTestBenchTestCase
{
    public function methodProvider()
    {
        return [
            ['html', 'getHtmlMinifier'],
        ];
    }

    /**
     * @dataProvider methodProvider
     */
    public function testMethods($method, $class)
    {
        $htmlmin = $this->getHTMLMin();

        $htmlmin->$class()->shouldReceive('render')
            ->once()->andReturn('abc');

        $return = $htmlmin->$method('test');

        $this->assertSame('abc', $return);
    }

    protected function getHTMLMin()
    {
        $html = Mockery::mock(HtmlMinifier::class);

        return new HTMLMin($html);
    }
}
