<?php

namespace App\Controller;

use App\Service\HelloService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    /**
     * @Route("helloService")
     *
     * @return Response
     */
    public function hello(HelloService $helloService)
    {
        $string = $helloService->hello();

        return new Response($string);
    }
    /**
     * @Route({
     *      "fr": "/bonjour",
     *      "en": "/hello",
     *      "es": "/hola"
     * })
     *
     * @return Response
     */
    public function helloLocale(Request $request)
    {
        $locale = $request->getLocale();
        return new Response("hello, locale : " . $locale);
    }
    
    /**
     * @Route("helloName/{name}", name="helloName")
     * 
     * @param [string] $name
     * 
     * @return Response
     */
    public function helloName($name) : Response
    {
        return new Response($name);
    }

    /**
     * @Route("helloList")
     * 
     * @return Response
     */
    public function helloList() : Response
    {
        return $this->render(
            'hello.html.twig', 
            ['title' => 'helloList']
        );
    }

    /**
     * @Route(
     *  "helloParam/{param}",
     *  requirements={"param"="\d+"}, 
     *  methods={"GET"}
     * )
     * 
     * @return Response
     */
    public function helloParamInt($param) : Response
    {
        $title = 'Param Integer';
        $params = [$param];

        return $this->render(
            'base.html.twig', 
            ['title' => $title, 'items' => $params]
        );
    }

    /**
     * @Route("helloParam/{param}", methods={"GET"})
     * 
     * @return Response
     */
    public function helloParamDefault($param) : Response
    {
        $title = 'Param Any';
        $params = [$param];

        return $this->render(
            'base.html.twig', 
            ['title' => $title, 'items' => $params]
        );
    }

    /**
     * @Route("helloRequest")
     * 
     * @return Response
     */
    public function helloRequest(Request $request) : Response
    {
        $title = 'resquest';
        $params = $request->query->all();

        return $this->render(
            'base.html.twig', 
            ['title' => $title, 'items' => $params]
        );
    }

    /**
     * @Route("helloTwig")
     *
     * @return Response
     */
    public function helloTwig() : Response
    {
        $title = "Je suis un titre";
        $tab = ["string $title", 'string $title '];
        $tab = ['string1' => "string $title", 'string2' => 'string $title', 'key3' => 154640156];

        return $this->render('base.html.twig', ['title' => $title, 'items' => $tab]);
    }

    /**
     * @Route("baseTwig")
     *
     * @return Response
     */
    public function baseTwig() : Response
    {
        return $this->render('base.html.twig');
    }
    /**
     * @Route("/hello")
     *
     * @return Response
     */
    public function index() : Response
    {
        return new Response('hello');
    }    
}
