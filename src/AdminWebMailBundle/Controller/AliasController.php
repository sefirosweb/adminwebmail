<?php

namespace AdminWebMailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AliasController extends Controller
{
    public function getAliasesJSONAction()
    {
        $em = $this->getDoctrine()->getManager();
        $aliases = $em->createQueryBuilder()
            ->select('a.id, a.source, a.destination')
            ->from('AdminWebMailBundle:Alias', 'a')
            ->getQuery()
            ->getResult();

        $serializer = $this->container->get('serializer');
        $data = $serializer->serialize($aliases, 'json');
        return new Response($data);
    }
}
