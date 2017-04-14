<?php

namespace AdminWebMailBundle\Controller;

use AdminWebMailBundle\Entity\Alias;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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

    private function getAliasById($id)
    {
        $em = $this->getDoctrine()->getManager();
        $domain = $em->createQueryBuilder()
            ->select('a.id, a.source, a.destination')
            ->from('AdminWebMailBundle:Alias', 'a')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
        return $domain;
    }

    public function addAliasAction(Request $request)
    {
        $serializer = $this->container->get('serializer');
        $source = $request->get('source');
        $destination = $request->get('destination');

        $em = $this->getDoctrine()->getManager();
        $exists = $em->getRepository('AdminWebMailBundle:Alias')->findOneBy(array(
            'source' => $source
        ));

        if ($exists) {
            $data = $serializer->serialize(array("success" => "false", "error" => "Source alredy exist"), 'json');
            return new Response($data);
        }

        $domainName = explode("@", $destination)[1];
        $domain = $em->getRepository('AdminWebMailBundle:Domain')->findOneBy(array(
            'name' => $domainName
        ));

        if (!$domain) {
            $data = $serializer->serialize(array("success" => "false", "error" => "Destiantion alias incorrect domain."), 'json');
            return new Response($data);
        }

        $existUser = $em->getRepository('AdminWebMailBundle:User')->findOneBy(array(
            'email' => $destination
        ));

        if (!$existUser) {
            $data = $serializer->serialize(array("success" => "false", "error" => "Destination user not found!"), 'json');
            return new Response($data);
        }

        $alias = new Alias();
        $alias->setSource($source);
        $alias->setDestination($destination);
        $alias->setDomain($domain);
        $em->persist($alias);
        $em->flush();

        $data = $serializer->serialize(array("success" => "true", 'alias' => $this->getAliasById($alias->getId())), 'json');
        return new Response($data);
    }

    public function deleteAliasAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AdminWebMailBundle:Alias')->find($id);
        $em->remove($user);
        $em->flush();
        $data = $this->container->get('serializer')->serialize(array("success" => "true"), 'json');
        return new Response($data);
    }
}
