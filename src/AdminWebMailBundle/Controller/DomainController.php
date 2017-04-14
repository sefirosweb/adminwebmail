<?php

namespace AdminWebMailBundle\Controller;

use AdminWebMailBundle\Entity\Domain;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DomainController extends Controller
{
    public function indexAction()
    {
        $users = $this->getUsersAgroupedAction();
        $aliases = $this->getAliasesAgroupedAction();
        return $this->render('AdminWebMailBundle::domains.html.twig', array('users' => $users, 'aliases' => $aliases));
    }

    public function getDomainsJSONAction()
    {
        $em = $this->getDoctrine()->getManager();
        $domains = $em->createQueryBuilder()
            ->select('d.id, d.name')
            ->from('AdminWebMailBundle:Domain', 'd')
            ->orderBy('d.id', 'asc')
            ->getQuery()
            ->getResult();

        $data = $this->container->get('serializer')->serialize($domains, 'json');
        return new Response($data);
    }

    private function getDomainById($id)
    {
        $em = $this->getDoctrine()->getManager();
        $domain = $em->createQueryBuilder()
            ->select('d.id, d.name')
            ->from('AdminWebMailBundle:Domain', 'd')
            ->where('d.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
        return $domain;
    }

    private function getAliasesAgroupedAction()
    {
        $em = $this->getDoctrine()->getManager();
        $aliases = $em->createQueryBuilder()
            ->select('a.id, a.source, a.destination, d.id AS domain')
            ->from('AdminWebMailBundle:Alias', 'a')
            ->join('a.Domain', 'd')
            ->getQuery()->getArrayResult();

        $usersGroupedByDomain = $this->arrayGroupBy($aliases, 'domain');
        return $usersGroupedByDomain;
    }

    private function getUsersAgroupedAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->createQueryBuilder()
            ->select('u.id, u.email, d.id AS domain')
            ->from('AdminWebMailBundle:User', 'u')
            ->join('u.Domain', 'd')
            ->getQuery()->getArrayResult();

        $usersGroupedByDomain = $this->arrayGroupBy($users, 'domain');
        return $usersGroupedByDomain;
    }

    private function arrayGroupBy(array $array, $key)
    {
        if (!is_string($key) && !is_int($key) && !is_float($key) && !is_callable($key)) {
            trigger_error('array_group_by(): The key should be a string, an integer, or a callback', E_USER_ERROR);
            return null;
        }
        $func = (is_callable($key) ? $key : null);
        $_key = $key;
        // Load the new array, splitting by the target key
        $grouped = [];
        foreach ($array as $value) {
            if (is_callable($func)) {
                $key = call_user_func($func, $value);
            } elseif (is_object($value) && isset($value->{$_key})) {
                $key = $value->{$_key};
            } elseif (isset($value[$_key])) {
                $key = $value[$_key];
            } else {
                continue;
            }
            $grouped[$key][] = $value;
        }
        // Recursively build a nested grouping if more parameters are supplied
        // Each grouped array value is grouped according to the next sequential key
        if (func_num_args() > 2) {
            $args = func_get_args();
            foreach ($grouped as $key => $value) {
                $params = array_merge([$value], array_slice($args, 2, func_num_args()));
                $grouped[$key] = call_user_func_array('array_group_by', $params);
            }
        }
        return $grouped;
    }

    public function addDomainAction(Request $request)
    {
        $serializer = $this->container->get('serializer');
        $domainName = $request->get('domainName');

        $em = $this->getDoctrine()->getManager();
        $exists = $em->getRepository('AdminWebMailBundle:Domain')->findBy(array(
            'name' => $domainName
        ));

        if ($exists) {
            $data = $serializer->serialize(array("success" => "false", "error" => "Domain alredy exist"), 'json');
            return new Response($data);
        }

        $domain = new Domain();
        $domain->setName($domainName);
        $em->persist($domain);
        $em->flush();

        $data = $serializer->serialize(array("success" => "true", 'domain' => $this->getDomainById($domain->getId())), 'json');
        return new Response($data);
    }

    public function deleteDomainAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AdminWebMailBundle:Domain')->find($id);
        $em->remove($user);
        $em->flush();
        $data = $this->container->get('serializer')->serialize(array("success" => "true"), 'json');
        return new Response($data);
    }

    public function updateUpdateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->container->get('serializer');
        $id = $request->get('id');
        $domainName = $request->get('name');

        $exists = $em->getRepository('AdminWebMailBundle:Domain')->findOneBy(array('name' => $domainName));

        if ($exists) {
            $data = $serializer->serialize(array("success" => "false", "error" => "Domain alredy exist"), 'json');
            return new Response($data);
        }

        $domain = $em->getRepository('AdminWebMailBundle:Domain')->find($id);
        $domain->setName($domainName);
        $em->persist($domain);
        $em->flush();
        $data = $serializer->serialize(array("success" => "true"), 'json');
        return new Response($data);
    }
}
