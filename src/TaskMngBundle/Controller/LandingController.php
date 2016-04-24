<?php

namespace TaskMngBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \DateTime;
use Symfony\Component\HttpFoundation\Response;

class LandingController extends Controller
{

    /**
     * Landing page
     *
     * @Route("/landing", name="landing")
     * @Method("GET")
     * @Template("TaskMngBundle::landing.html.twig")
     */
    public function landingAction()
    {
        return [];
    }



}
