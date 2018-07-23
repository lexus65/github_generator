<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method({"GET"})
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Home:index.html.twig', []);
    }


    /**
     * @Route("/view", name="default.view")
     * @Method({"GET"})
     * @param Request $request
     * @return Response
     */
    public function viewResume(Request $request)
    {
        $username = $request->query->get('query');

        $userData = $this->get('app_github')->getUserByUsername($username);

        if ($userData)
            $userData = \GuzzleHttp\json_decode($userData, true);

        $repositories = $this->get('app_github')->get($userData['repos_url']);


        if($repositories)
            $repositories = \GuzzleHttp\json_decode($repositories, true);

        $langs = $this->get('app_github')->calculateProgrammingLanguages($repositories);

        return $this->render('AppBundle:Resume:resumeView.html.twig',
            [
                'userData' => $userData,
                'repositories' => $repositories,
                'langs' => $langs
            ]);
    }
}
