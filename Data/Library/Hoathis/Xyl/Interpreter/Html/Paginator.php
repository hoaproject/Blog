<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2012, Ivan Enderlin. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Hoa nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS AND CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace Hoathis\Xyl\Interpreter\Html;

/**
 * Class \Hoathis\Xyl\Interpreter\Html\Paginator.
 *
 * The <paginator /> component.
 *
 * @author     Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright © 2007-2012 Ivan Enderlin.
 * @license    New BSD License
 */

class Paginator extends \Hoa\Xyl\Interpreter\Html\Generic {

    /**
     * Attributes description.
     *
     * @var \Hoathis\Xyl\Interpreter\Html\Paginator array
     */
    protected static $_attributes        = array(
        'min'    => parent::ATTRIBUTE_TYPE_NORMAL,
        'max'    => parent::ATTRIBUTE_TYPE_NORMAL,
        'select' => parent::ATTRIBUTE_TYPE_NORMAL
    );

    /**
     * Attributes mapping between XYL and HTML.
     *
     * @var \Hoathis\Xyl\Interpreter\Html\Paginator array
     */
    protected static $_attributesMapping = null;



    /**
     * Paint the element.
     *
     * @access  protected
     * @param   \Hoa\Stream\IStream\Out  $out    Out stream.
     * @return  void
     */
    protected function paint ( \Hoa\Stream\IStream\Out $out ) {

        $max = max(0, intval($this->computeAttributeValue(
            $this->abstract->readAttribute('max')
        )));
        $selected = max(0, intval($this->computeAttributeValue(
            $this->abstract->readAttribute('select')
        )));

        $this->writeAttribute('role', 'navigation');
        $out->writeAll('<ul' . $this->readAttributesAsString() . '>');

        $handle = null;

        for($i = 1; $i <= $max; ++$i)
            if($i === $selected)
                $handle .= '<li aria-selected="true">' . $i . '</li>';
            else
                $handle .= '<li><a href="?page='.$i.'">' . $i . '</a></li>';

        $out->writeAll($handle . '</ul>');

        return;
    }
}
