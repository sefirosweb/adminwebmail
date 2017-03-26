<?php

namespace AdminWebMailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminWebMailBundle::index.html.twig');
    }

    public function getDomainsJSONAction()
    {

    }

    public function getAliasesJSONAction()
    {

    }

    public function getUsersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AdminWebMailBundle:User')->findAll();

        $arrays = $users->toArray();
        $fields = array_merge(
            $em->getClassMetadata('AdminWebMailBundle:User')->getFieldNames()
            , $em->getClassMetadata('AdminWebMailBundle:User')->getAssociationNames()
        );

        foreach ($users as $key => $user) {
            foreach ($user as $field) {
                $temp[] = $user->getId();
            }
            unset($temp);
        }


        return $this->responeJSON($fields);
    }

    private function responeJSON($data)
    {
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


}
