<?php

namespace AdminWebMailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function usersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $domains_raw = $em->createQueryBuilder()
            ->select('d.id, d.name')
            ->from('AdminWebMailBundle:Domain', 'd')
            ->getQuery()
            ->getResult();

        foreach ($domains_raw as $domain) {
            $domains[] = array(
                "value" => $domain['id'],
                "text" => $domain['name']
            );
        }
        return $this->render('AdminWebMailBundle::users.html.twig', array('domains' => $domains));
    }

    public function domainsAction()
    {
        return $this->render('AdminWebMailBundle::domains.html.twig');
    }

    public function aliasesAction()
    {
        return $this->render('AdminWebMailBundle::aliases.html.twig');
    }
}
