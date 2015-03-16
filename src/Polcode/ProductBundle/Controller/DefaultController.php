<?php

namespace Polcode\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PolcodeProductBundle:Default:index.html.twig');
    }
}
