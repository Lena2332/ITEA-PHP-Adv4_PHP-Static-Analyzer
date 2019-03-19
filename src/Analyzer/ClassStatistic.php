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
 * Class get full class name with namespace and return name, type of class, statistic of methods and properties
 *
 * @author Elena Kupriec <box32.lena@gmail.com>
 */
final class ClassStatistic
{
    private $reflector;
    private $classType = 'default';

    /**
     * ClassStatistic constructor.
     *
     * @param string $fullClassName
     *
     * @throws \ReflectionException
     */
    public function __construct(string $fullClassName)
    {
        $this->reflector = new \ReflectionClass($fullClassName);
    }


    public function getClassName(): string
    {
        return $this->reflector->getName();
    }


    public function getClassType(): string
    {
        if ($this->reflector->isAbstract()) {
            $this->classType = 'abstract';
        }

        if ($this->reflector->isFinal()) {
            $this->classType = 'final';
        }

        return $this->classType;
    }

    public function getProperty(): object
    {
        return new ClassPropertiesCount($this->reflector);
    }

    public function getMethods(): object
    {
        return new ClassMethodsCount($this->reflector);
    }
}
