<?php

namespace App\Command;

use App\Entity\Brand;
use App\Entity\Model;
use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class ImportCarDataCommand extends Command
{
    private $entityManager;
    private $kernel;

    public function __construct(EntityManagerInterface $entityManager, KernelInterface $kernel)
    {
        $this->entityManager = $entityManager;
        $this->kernel = $kernel;
        parent::__construct();
    }

    protected function configure(): void 
    {
        $this
            ->setName('app:import-car-data')
            ->setDescription('Import car data from JSON file.'); 
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $jsonData = file_get_contents($this->kernel->getProjectDir() . '/resources/Command/Brands_&_Models.json');
        $data = json_decode($jsonData, true);

        foreach ($data as $brandData) {
            $brandName = $brandData['brand'];
            $brand = $this->entityManager->getRepository(Brand::class)->findOneBy(['name' => $brandName]);

            // Create the brand if it doesn't exist
            if (!$brand) {
                $brand = new Brand();
                $brand->setName($brandName);
                $this->entityManager->persist($brand);
            }

            foreach ($brandData['models'] as $modelData) {
                $modelName = $modelData['name'];
                $model = $this->entityManager->getRepository(Model::class)->findOneBy(['name' => $modelName]);

                // Create the model if it doesn't exist
                if (!$model) {
                    $model = new Model();
                    $model->setName($modelName);
                    $model->setBrand($brand); 
                    $this->entityManager->persist($model);
                }

                // Create a car association. You can comment this out if not needed
                $car = new Car();
                $car->setBrand($brand);
                $car->setModel($model);
                $this->entityManager->persist($car);
            }
        }

        $this->entityManager->flush();

        $output->writeln('Data imported successfully!');

        return Command::SUCCESS; 
    }
}