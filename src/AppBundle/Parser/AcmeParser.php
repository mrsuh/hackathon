<?php

namespace AppBundle\Parser;

use AppBundle\Entity\Drug\ActiveSubstance;
use AppBundle\Entity\Drug\Drug;
use AppBundle\Entity\Statistic\Statistic;
use AppBundle\Explorer\ActiveSubstanceExplorer;
use AppBundle\Explorer\DrugExplorer;
use AppBundle\Explorer\PharmacyExplorer;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Component\CssSelector\Exception\ParseException;

class AcmeParser
{
    private $explorer_pharmacy;
    private $explorer_drug;
    private $explorer_active_substance;

    private $repo_drug;
    private $repo_active_substance;
    private $logger;

    public function __construct(
        EntityManager $em,
        DrugExplorer $explorer_drug,
        PharmacyExplorer $explorer_pharmacy,
        ActiveSubstanceExplorer $explorer_active_substance,
        Logger $logger
    )
    {
        $this->explorer_drug = $explorer_drug;
        $this->explorer_pharmacy = $explorer_pharmacy;
        $this->explorer_active_substance = $explorer_active_substance;
        $this->repo_drug = $em->getRepository(Drug::class);
        $this->repo_active_substance = $em->getRepository(ActiveSubstance::class);
        $this->logger = $logger;
    }

    public function parse(\simplehtmldom_1_5\simple_html_dom $dom)
    {
        $str_name = $dom->find('.nameblock .drug', 0)->innertext . PHP_EOL;
        if (null === $str_name) {
            throw new ParseException('Name not found');
        }

        $str_active_substance = $dom->find('.filters p', 0)->innertext . PHP_EOL;
        if (null === $str_active_substance) {
            throw new ParseException('Active Substance not found');
        }

        $active_substance = $this->explorer_active_substance->explore($str_active_substance);

        if (null === $active_substance) {
            $active_substance = $this->repo_drug->create(
                (new ActiveSubstance())
                    ->setName($str_active_substance)
            );
        }

        $drug = $this->explorer_drug->explore($str_name);

        if (null === $drug) {
            $drug = $this->repo_drug->create(
                (new Drug())
                    ->setName($str_name)
                    ->setActiveSubstance($active_substance)
            );
        }

        $statistics = [];
        foreach ($dom->find('#container .trow') as $key => $row) {

            if ($key === 0) {
                continue;
            }

            try {

                $date = $row->find('.date', 0)->innertext;
                if (null === $date) {
                    throw new ParseException('Date not found');
                }

                $price = $row->find('.pricefull', 0)->innertext;
                if (null === $price) {
                    throw new ParseException('Price not found');
                }

                $address = $row->find('.address a', 0)->innertext;
                if (null === $address) {
                    throw new ParseException('Address not found');
                }

                $pharmacy = $this->explorer_pharmacy->explore($address);
                if (null === $pharmacy) {
                    throw new ParseException('Pharmacy not found by address ' . $address);
                }

                $drug = $this->explorer_drug->explore($str_name);

                if (null === $drug) {
                    $drug = $this->repo_drug->create(
                        (new Drug())
                            ->setName($str_name)
                            ->setActiveSubstance($active_substance)
                    );
                }

                $statistics[] = (new Statistic())
                    ->setDrug($drug)
                    ->setSubway($pharmacy->getSubway())
                    ->setPharmacy($pharmacy)
                    ->setPrice($price)
                    ->setDate(\DateTime::createFromFormat('j.n.y', $date));

            } catch (ParseException $e) {
                $this->logger->error($e->getMessage());
            }
        }

        return $statistics;
    }
}

