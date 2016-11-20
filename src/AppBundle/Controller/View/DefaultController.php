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
        $order = $request->get('order') ?(int)$request->get('order'): 1;
        $name = $request->get('name');
        $price_from = $request->get('price_from');
        $price_to = $request->get('price_to');

        $subway = [];
        foreach (explode(',', $request->get('subway')) as &$v) {
            if (empty($v)) {
                unset($v);
                continue;
            }
            $subway[] = (int)$v;
        }
        unset($v);

        $items_on_page = $this->getParameter('items_on_page');

        $repo = $this->get('doctrine.orm.default_entity_manager')->getRepository(Statistic::class);

        $total = count($repo->findByParams(
            $name,
            $price_from,
            $price_to,
            $subway,
            $order
        ));
        $list = $repo->findByParamsAndLimit(
            $name,
            $price_from,
            $price_to,
            $subway,
            $order,
            $items_on_page,
            $page
        );

        $count_pages = ceil($total / $items_on_page);

        return $this->render('AppBundle:Default:index.html.twig', [
            'list' => $list,
            'subways' => [],
            '_page' => $page,
            '_name' => $name,
            '_pages' => Paginator::numbers($page, $count_pages, 5),
            '_count_pages' => $count_pages,
            '_count_items' => $total,
            '_subway' => $subway,
            '_price_from' => $price_from,
            '_price_to' => $price_to,
            '_order' => $order

        ]);
    }
}
