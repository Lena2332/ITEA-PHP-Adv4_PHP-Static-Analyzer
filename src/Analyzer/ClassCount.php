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
 * Class get object instance of \ReflectionClass
 * and write into properties statistic of methods and properties
 *
 * @author Elena Kupriiets <box32.lena@gmail.com>
 *
 */
abstract class ClassCount
{
    protected $reflectObj;
    protected $countObj;
    public $publ = 0;
    public $publ_stat = 0;
    public $publ_stat_str = '';
    public $prot = 0;
    public $prot_stat = 0;
    public $prot_stat_str = '';
    public $priv = 0;
    public $priv_stat = 0;
    public $priv_stat_str = '';
    protected static $obj_type = 'method';

    public function __construct(\ReflectionClass $obj)
    {
        $this->reflectObj = $obj;
        $this->countObj = [];
    }

    protected function getAmountPublic()
    {
        switch (static::$obj_type) {
            case 'method':
                $this->countObj = $this->reflectObj->getMethods(\ReflectionMethod::IS_PUBLIC);
                break;
            case 'property':
                $this->countObj = $this->reflectObj->getProperties(\ReflectionProperty::IS_PUBLIC);
                break;
        }

        $this->publ = \count($this->countObj);
        $this->publ_stat = $this->checkStatic();
        $this->publ_stat_str = ($this->publ_stat) ? '(' . $this->publ_stat . ' static)' : '';
    }


    protected function getAmountProtected()
    {
        switch (static::$obj_type) {
            case 'method':
                $this->countObj = $this->reflectObj->getMethods(\ReflectionMethod::IS_PROTECTED);
                break;
            case 'property':
                $this->countObj = $this->reflectObj->getProperties(\ReflectionProperty::IS_PROTECTED);
                break;
        }
        $this->prot = \count($this->countObj);
        $this->prot_stat = $this->checkStatic();
        $this->prot_stat_str = ($this->prot_stat) ? '(' . $this->prot_stat . ' static)' : '';
    }

    protected function getAmountPrivate()
    {
        switch (static::$obj_type) {
            case 'method':
                $this->countObj = $this->reflectObj->getMethods(\ReflectionMethod::IS_PRIVATE);
                break;
            case 'property':
                $this->countObj = $this->reflectObj->getProperties(\ReflectionProperty::IS_PRIVATE);
                break;
        }
        $this->priv = \count($this->countObj);
        $this->priv_stat = $this->checkStatic();
        $this->priv_stat_str = ($this->priv_stat) ? '(' . $this->priv_stat . ' static)' : '';
    }

    private function checkStatic(): int
    {
        $static_count = 0;

        if (\count($this->countObj)) {
            foreach ($this->countObj as $countobj) {
                if ($countobj->isStatic()) {
                    $static_count++;
                }
            }
        }

        return $static_count;
    }
}
