<?php
/**
 * @var Kahlan\Cli\Kahlan $this
 */
use Kahlan\Filter\Filters;
use Kahlan\Reporter\Coverage\Exporter\Coveralls;


$commandLine = $this->commandLine();
$commandLine->option('src', 'default','src');
$commandLine->option('spec', 'default', 'tests');
$commandLine->option('reporter', 'default', 'tree');
$commandLine->option('ff', 'default', 1);
//$commandLine->option('coverage-scrutinizer', 'default', 'scrutinizer.xml');
//$commandLine->option('coverage-coveralls', 'default', 'coveralls.json');
