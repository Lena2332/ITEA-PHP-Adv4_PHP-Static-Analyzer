<?php

/*
 * This file is part of the "default-project" package.
 *
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Greeflas\StaticAnalyzer\Analyzer;

/**
 * Class intended for get statistic of Methods
 *
 * @author Elena Kupriiets <box32.lena@gmail.com>
 *
 */
class ClassMethodsCount extends ClassCount
{
    public function __construct(\ReflectionClass $obj)
    {
        parent::__construct($obj);
        parent::$obj_type = 'method';
        $this->getAmountPublic();
        $this->getAmountPrivate();
        $this->getAmountProtected();
    }
}
