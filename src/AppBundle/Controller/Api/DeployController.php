<?php

namespace AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DeployController extends Controller
{
    public function deployAction($deploy_key)
    {
        if((string)$deploy_key !== (string)$this->getParameter('deploy.key')) {
            return new Response('wrong deploy key ' . $deploy_key, Response::HTTP_BAD_REQUEST);
        }

        $response = shell_exec($this->getParameter('deploy.script'));

        return new Response($response);
    }
}
