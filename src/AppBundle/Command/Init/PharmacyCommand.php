<?php

namespace AppBundle\Command\Init;

use AppBundle\Entity\Location\City;
use AppBundle\Entity\Pharmacy\Pharmacy;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class PharmacyCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:init:pharmacy');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $list = Yaml::parse(file_get_contents($this->getContainer()->getParameter('kernel.root_dir') . '/fixtures/pharmacy.yml'));

        $repo = $this->getContainer()->get('doctrine.orm.default_entity_manager')->getRepository(City::class);
        $explorer_subway = $this->getContainer()->get('explorer.subway');

        foreach ($list as $key => $val) {

            $subway = $explorer_subway->explore($val['subway']);

            $repo->create(
                (new Pharmacy())
                    ->setSubway($subway)
                    ->setName($val['name'])
                    ->setAddress($val['address'])
                    ->setGeoLat($val['geo_lat'])
                    ->setGeoLng($val['geo_lng'])
                    ->setDescription($val['description'])
                    ->setPhone($val['phone'])
            );
        }
    }
}
