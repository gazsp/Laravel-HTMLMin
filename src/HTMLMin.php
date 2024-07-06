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

namespace HTMLMin\HTMLMin;

use HTMLMin\HTMLMin\Minifiers\BladeMinifier;
use HTMLMin\HTMLMin\Minifiers\CssMinifier;
use HTMLMin\HTMLMin\Minifiers\HtmlMinifier;
use HTMLMin\HTMLMin\Minifiers\JsMinifier;

/**
 * This is the htmlmin class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class HTMLMin
{
    /**
     * The html minifier instance.
     *
     * @var \HTMLMin\HTMLMin\Minifiers\HtmlMinifier
     */
    protected $html;

    /**
     * Create a new instance.
     *
     * @param \HTMLMin\HTMLMin\Minifiers\BladeMinifier $blade
     * @param \HTMLMin\HTMLMin\Minifiers\CssMinifier   $css
     * @param \HTMLMin\HTMLMin\Minifiers\JsMinifier    $js
     * @param \HTMLMin\HTMLMin\Minifiers\HtmlMinifier  $html
     *
     * @return void
     */
    public function __construct(HtmlMinifier $html)
    {
        $this->html = $html;
    }

    /**
     * Get the minified html.
     *
     * @param string $value
     *
     * @return string
     */
    public function html($value)
    {
        return $this->html->render($value);
    }

    /**
     * Return the html minifier instance.
     *
     * @return \HTMLMin\HTMLMin\Minifiers\HtmlMinifier
     */
    public function getHtmlMinifier()
    {
        return $this->html;
    }
}
