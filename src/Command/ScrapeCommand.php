<?php

namespace MichaelKing0\SainsburysScraper\Command;

use MichaelKing0\SainsburysScraper\Service\CategoryService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ScrapeCommand extends Command
{
    private $categoryService;

    /**
     * ScrapeCommand constructor.
     * @param CategoryService $categoryService
     * @param null $name
     */
    public function __construct(CategoryService $categoryService, $name = null)
    {
        parent::__construct($name);
        $this->categoryService = $categoryService;
    }

    /**
     * Configure the command
     */
    protected function configure()
    {
        $this
            ->setName('app:scrape')
            ->setDescription('Scrape and parse a page.')
            ->setHelp('This command allows you to scrape and parse a page.')
            ->addArgument('url', InputArgument::REQUIRED, 'The URL to scrape')
            ->addOption('prettyPrint', 'pp', InputOption::VALUE_OPTIONAL, 'Pretty print the output', null);
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $category = $this->categoryService->getCategory($input->getArgument('url'));

        $options = 0;
        if ($input->getOption('prettyPrint')) {
            $options = JSON_PRETTY_PRINT;
        }

        $output->writeln(json_encode($category, $options));
    }
}