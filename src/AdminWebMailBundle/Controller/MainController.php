<?php

namespace AdminWebMailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $users = $this->getDoctrine()
            ->getRepository('AdminWebMailBundle:User')
            ->find(1);
        return $this->render('AdminWebMailBundle::index.html.twig',array('users' => $users));
    }


}
