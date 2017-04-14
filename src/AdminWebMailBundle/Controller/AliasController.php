<?php

namespace AdminWebMailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AliasController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminWebMailBundle::aliases.html.twig');
    }

    public function getAliasesJSONAction()
    {
        $em = $this->getDoctrine()->getManager();
        $aliases = $em->createQueryBuilder()
            ->select('a.id, a.source, a.destination')
            ->from('AdminWebMailBundle:Alias', 'a')
            ->getQuery()
            ->getResult();

        $data = $this->container->get('serializer')->serialize($aliases, 'json');
        return new Response($data);
    }
}
