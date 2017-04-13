<?php

namespace AdminWebMailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DomainController extends Controller
{
    public function getDomainsJSONAction()
    {
        $em = $this->getDoctrine()->getManager();
        $domains = $em->createQueryBuilder()
            ->select('d.id, d.name')
            ->from('AdminWebMailBundle:Domain', 'd')
            ->getQuery()
            ->getResult();

        $serializer = $this->container->get('serializer');
        $data = $serializer->serialize($domains, 'json');
        return new Response($data);
    }
}
