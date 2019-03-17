<?php

/*
 * This file is part of the "default-project" package.
 *
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Greeflas\StaticAnalyzer\Command;

use Greeflas\StaticAnalyzer\Analyzer\ClassStatistic;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Elena Kupriec <box32.lena@gmail.com>
 */
class ClassStatisticClass extends Command
{
    protected function configure()
    {
        $this
            ->setName('class-statistic')
            ->setDescription('Shows statistic of class')
            ->addArgument(
                'fullClassName',
                InputArgument::REQUIRED,
                'Full class name (with namespace)'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $full_class_name = $input->getArgument('fullClassName');

        $statistic = new ClassStatistic($full_class_name);

        $class_name = $statistic->getClassName();
        $class_type = $statistic->getClassType();
        $class_properties_data = $statistic->getPropertiesData();
        $class_methods_data = $statistic->getMethodsData();

        $output->writeln(\sprintf(
            '<info>Class: %s is %s
                          Properties:
                               public: %s (%s static)
                               protected: %s (%s static)
                               private: %s
                          Methods:
                               public: %s (%s static)
                               protected: %s 
                               private: %s (%s static)</info>',
            $class_name,
            $class_type,
            $class_properties_data['public'],
            $class_properties_data['public_static'],
            $class_properties_data['protected'],
            $class_properties_data['protected_static'],
            $class_properties_data['private'],
            $class_methods_data['public'],
            $class_methods_data['public_static'],
            $class_methods_data['protected'],
            $class_methods_data['private'],
            $class_methods_data['private_static']

        ));
    }
}
