<?php

namespace AdminWebMailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    public function indexAction()
    {
        $domains_raw = $this->getDomains();
        foreach ($domains_raw as $domain) {
            $domains[] = array(
                "value" => $domain['id'],
                "text" => $domain['name']
            );
        }
        return $this->render('AdminWebMailBundle::index.html.twig', array('domains' => $domains));
    }

    private function getDomains()
    {
        $em = $this->getDoctrine()->getManager();
        //$domains = $em->getRepository('AdminWebMailBundle:Domain')->findAll();
        $domains = $em->createQueryBuilder()
            ->select('d.id, d.name')
            ->from('AdminWebMailBundle:Domain', 'd')
            ->getQuery()
            ->getResult();
        return $domains;
    }

    public function getDomainsJSONAction()
    {
        $domains = $this->getDomains();
        $serializer = $this->container->get('serializer');
        $data = $serializer->serialize($domains, 'json');
        return new Response($data);
    }

    public function getAliasesJSONAction()
    {
        $em = $this->getDoctrine()->getManager();
        //$aliases = $em->getRepository('AdminWebMailBundle:Alias')->findAll();
        $aliases = $em->createQueryBuilder()
            ->select('a.id, a.source, a.destination')
            ->from('AdminWebMailBundle:Alias', 'a')
            ->getQuery()
            ->getResult();

        $serializer = $this->container->get('serializer');

        $data = $serializer->serialize($aliases, 'json');
        return new Response($data);
    }

    public function getUsersJSONAction()
    {
        $em = $this->getDoctrine()->getManager();
        //$users = $em->getRepository('AdminWebMailBundle:User')->findAll();

        $users = $em->createQueryBuilder()
            ->select('u.id, u.email, d.id AS domain')
            ->from('AdminWebMailBundle:User', 'u')
            ->join('u.domain', 'd')
            ->getQuery()->getArrayResult();

        $serializer = $this->container->get('serializer');
        $data = $serializer->serialize($users, 'json');
        return new Response($data);
    }


}
