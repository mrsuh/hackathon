<?php

namespace AppBundle\Command\Init;

use AppBundle\Entity\Location\City;
use AppBundle\Entity\Source\Source;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class SourceCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:init:source');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $list = Yaml::parse(file_get_contents($this->getContainer()->getParameter('kernel.root_dir') . '/fixtures/source.yml'));

        $repo = $this->getContainer()->get('doctrine.orm.default_entity_manager')->getRepository(Source::class);
        $repo_city = $this->getContainer()->get('doctrine.orm.default_entity_manager')->getRepository(City::class);
        foreach ($list as $key => $val) {
            $city = $repo_city->findOneBy(['id' => $val['city']]);
            $repo->create(
                (new Source())
                    ->setId($val['id'])
                    ->setName($val['name'])
                    ->setUrl($val['url'])
                    ->setCity($city)
            );
        }
    }
}
