<?php

namespace AppBundle\Command\Init;

use AppBundle\Entity\Location\City;
use AppBundle\Entity\Location\Subway;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class SubwayCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:init:subway');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $list = Yaml::parse(file_get_contents($this->getContainer()->getParameter('kernel.root_dir') . '/fixtures/subway.yml'));

        $repo_subway = $this->getContainer()->get('doctrine.orm.default_entity_manager')->getRepository(Subway::class);
        $repo_city = $this->getContainer()->get('doctrine.orm.default_entity_manager')->getRepository(City::class);
        foreach ($list as $key => $val) {
            $city = $repo_city->findOneBy(['id' => $val['city']]);
            $repo_subway->create(
                (new Subway())
                    ->setCity($city)
                    ->setName($val['name'])
                    ->setRegexp($val['regexp'])
            );
        }
    }
}
