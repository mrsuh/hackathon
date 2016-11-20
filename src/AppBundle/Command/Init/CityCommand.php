<?php

namespace AppBundle\Command\Init;

use AppBundle\Entity\Location\City;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class CityCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:init:city');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $list = Yaml::parse(file_get_contents($this->getContainer()->getParameter('kernel.root_dir') . '/fixtures/city.yml'));

        $repo = $this->getContainer()->get('doctrine.orm.default_entity_manager')->getRepository(City::class);
        foreach ($list as $key => $val) {
            $repo->create(
                (new City())
                    ->setId($val['id'])
                    ->setName($val['name'])
            );
        }
    }
}
