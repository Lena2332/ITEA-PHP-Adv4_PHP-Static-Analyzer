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
 * @author Elena Kupriec <box32.lena@gmail.com>
 */
final class ClassStatistic
{
    private $fullClassName;
    private $reflector;

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

    /**
     * Return classname
     *
     * @return string with classname
     */
    public function getClassName(): string
    {
        return $this->reflector->getName();
    }

    /**
     * @return string of classType (abstract, final, trait ...)
     */
    public function getClassType(): string
    {
        $class_type_arr = [];

        if ($this->reflector->isAbstract()) {
            $class_type_arr[] = 'abstract';
        }

        if ($this->reflector->isFinal()) {
            $class_type_arr[] = 'final';
        }

        if ($this->reflector->isInterface()) {
            $class_type_arr[] = 'interface';
        }

        if ($this->reflector->isAnonymous()) {
            $class_type_arr[] = 'anonimus';
        }

        if ($this->reflector->isTrait()) {
            $class_type_arr[] = 'trait';
        }

        if ($this->reflector->isCloneable()) {
            $class_type_arr[] = 'clonable';
        }

        if ($this->reflector->isIterable()) {
            $class_type_arr[] = 'iterable';
        }

        if ($this->reflector->isInternal()) {
            $class_type_arr[] = 'internal';
        }

        if ($this->reflector->isInstantiable()) {
            $class_type_arr[] = 'instantiable';
        }

        return \implode(', ', $class_type_arr);
    }

    /**
     * Return array with amounts of public, private, protected properties
     *
     * @return array
     */
    public function getPropertiesData(): array
    {
        $property_data = $this->reflector->getProperties();

        $publ = 0;
        $publ_stat = 0;
        $prot = 0;
        $prot_stat = 0;
        $priv = 0;

        if (!empty($property_data)) {
            foreach ($property_data as $prop) {
                if ($prop->isPublic()) {
                    $publ++;

                    if ($prop->isStatic()) {
                        $publ_stat++;
                    }
                }

                if ($prop->isProtected()) {
                    $prot++;

                    if ($prop->isStatic()) {
                        $prot_stat++;
                    }
                }

                if ($prop->isPrivate()) {
                    $priv++;
                }
            }
        }

        $output_prop_array = [
            'public' => $publ,
            'public_static' => $publ_stat,
            'protected' => $prot_stat,
            'protected_static' => $prot_stat,
            'private' => $priv,
        ];

        return $output_prop_array;
    }

    /**
     * Return array with amount of public, private,protected methods
     */
    public function getMethodsData(): array
    {
        $methods_data = $this->reflector->getMethods();

        $publ = 0;
        $publ_stat = 0;
        $prot = 0;
        $prot_stat = 0;
        $priv = 0;
        $priv_stat = 0;

        if (!empty($methods_data)) {
            foreach ($methods_data as $method) {
                if ($method->isPublic()) {
                    $publ++;

                    if ($method->isStatic()) {
                        $publ_stat++;
                    }
                }

                if ($method->isProtected()) {
                    $prot++;

                    if ($method->isStatic()) {
                        $prot_stat++;
                    }
                }

                if ($method->isPrivate()) {
                    $priv++;

                    if ($method->isStatic()) {
                        $priv_stat++;
                    }
                }
            }
        }

        $output_method_array = [
            'public' => $publ,
            'public_static' => $publ_stat,
            'protected' => $prot_stat,
            'protected_static' => $prot_stat,
            'private' => $priv,
            'private_static' => $priv_stat,
        ];

        return $output_method_array;
    }
}
