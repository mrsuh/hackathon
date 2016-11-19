<?php

namespace AppBundle\Command\Statistic;

use AppBundle\Entity\Source\Source;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CollectCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:collect');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sources = $this->getContainer()->get('doctrine.orm.default_entity_manager')->getRepository(Source::class)->findBy(['id' => Source::ACME]);

        foreach($sources as $source) {
            $this->getContainer()->get('factory.collector')->collect($source);
        }

    }
}
