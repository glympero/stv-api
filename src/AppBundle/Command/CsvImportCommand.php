<?php

namespace AppBundle\Command;

use AppBundle\Entity\Postcode;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;


class CsvImportCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setName('csv:import')
            ->setDescription('Imports a csv file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Attempting to import all csv file...');

        $finder = new Finder();
        $finder->files()->in(__DIR__.'/Data');

        foreach ($finder as $file) {

                $reader = Reader::createFromPath('%kernel.root_dir%/../src/AppBundle/Data/'.$file->getRelativePathname());

               // $reader = Reader::createFromPath();

                $results = $reader->fetchAssoc([0, 1, 2, 3]);

                $io->progressStart(iterator_count($results));

                foreach($results as $row){
                    $trimmedPostcode = preg_replace('/\s+/', '', $row[0]);
                    $postcode = (new Postcode())
                        ->setPostcode($trimmedPostcode)
                        ->setEastings(intval($row[2]))
                        ->setNorthings(intval($row[3]));

                    $this->em->persist($postcode);

                    $io->progressAdvance();
                }
                $this->em->flush();

                $io->progressFinish();
        }

        $io->success('Import complete');
    }
}