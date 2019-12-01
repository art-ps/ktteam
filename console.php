<?php

use Symfony\Component\Console\Output\OutputInterface;
use TaskTracker\Database\Migration;
use TaskTracker\Database\Seeds;

$container = require __DIR__ . '/app/bootstrap.php';

$app = new Silly\Application();

$app->useContainer($container, $injectWithTypeHint = true);

$app->command('migrate', function (OutputInterface $output, Migration $migration) {
    $migration->up();
    $output->writeln('Database migrated!');
});

$app->command('seed', function (OutputInterface $output, Seeds $seeds) {
    $seeds->seed();
    $output->writeln('Database seeded with example data!');
});

$app->run();
