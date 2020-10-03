<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Terminal;

class PrinterCommand extends Command
{
    protected static $defaultName = 'print';

    protected function configure(): void
    {
        $this->addArgument('image', InputArgument::REQUIRED, 'Path to image to print');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $image = $input->getArgument('image');

        $terminal = new Terminal();
        $width = $terminal->getWidth();
        $height = $terminal->getHeight() * 2;

        $printer = new Printer($output);
        $printer->print($image, $width, $height);

        return 0;
    }
}
