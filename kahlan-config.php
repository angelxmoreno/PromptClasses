<?php
/**
 * @var Kahlan\Cli\Kahlan $this
 */


$commandLine = $this->commandLine();
$commandLine->option('src', 'default', 'src');
$commandLine->option('spec', 'default', 'tests');
$commandLine->option('reporter', 'default', 'tree');
$commandLine->option('ff', 'default', 1);
//$commandLine->option('coverage-scrutinizer', 'default', 'scrutinizer.xml');
//$commandLine->option('coverage-coveralls', 'default', 'coveralls.json');

const DS = DIRECTORY_SEPARATOR;
const FIXTURES_DIR = __DIR__ . DS . 'tests' . DS . 'fixtures' . DS;
