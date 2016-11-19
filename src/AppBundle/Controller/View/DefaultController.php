<?php

namespace AppBundle\Controller\View;

use AppBundle\Doctrine\Paginator;
use AppBundle\Entity\Statistic\Statistic;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function mainAction(Request $request)
    {
        $page = $request->get('page') ?: 1;

        $total = count($this->get('doctrine.orm.default_entity_manager')->getRepository(Statistic::class)->findByParams());
        $list = $this->get('doctrine.orm.default_entity_manager')->getRepository(Statistic::class)->findByParamsAndLimit();

        return $this->render('AppBundle:Default:index.html.twig', [
            'list' => $list,
            'subways' => [],
            '_page' => 1,
            '_pages' => Paginator::numbers(1,$total, 5),
            '_count_pages' => ceil($total / 20),
            '_count_items' => $total,
            '_subway' => 1,
            '_price_from' => 1,
            '_price_to' => 1,
            '_order' => 1

        ]);
    }
}
