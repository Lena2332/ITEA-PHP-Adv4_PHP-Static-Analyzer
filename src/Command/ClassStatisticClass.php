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
 * {@inheritdoc}
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
        $properties = $statistic->getProperty();
        $methods = $statistic->getMethods();

        $output->writeln(\sprintf(
            '<info>Class: %s is %s
                          Properties:
                               public: %s %s
                               protected: %s %s
                               private: %s %s 
                          Methods:
                               public: %s %s
                               protected: %s %s
                               private: %s %s</info>',
            $class_name,
            $class_type,
            $properties->publ,
            $properties->publ_stat_str,
            $properties->prot,
            $properties->prot_stat_str,
            $properties->priv,
            $properties->priv_stat_str,
            $methods->publ,
            $methods->publ_stat_str,
            $methods->prot,
            $methods->prot_stat_str,
            $methods->priv,
            $methods->priv_stat_str

        ));
    }
}
