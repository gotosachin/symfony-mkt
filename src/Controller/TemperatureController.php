<?php

namespace App\Controller;

use App\Service\TemperatureQueryManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 *
 */
class TemperatureController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/temperature", name="app_temperature")
     * @return Response
     */
    public function indexAction(TemperatureQueryManager  $temperatureQueryManager): Response
    {
        // return $this->json([
        //     'message' => 'Welcome to your new controller!',
        //     'path' => 'src/Controller/TemperatureController.php',
        // ]);

        // return $this->view("Welcome to your new controller!", Response::HTTP_OK);
       // return $this->view("hello", Response::HTTP_OK);

        // /** @var TemperatureQueryManager $temperatureQueryManager */
        //  $temperatureQueryManager = $this->container->get('temperature_query_manager');

         $response = $temperatureQueryManager->calculateMkt([]);
        // var_dump($response);
       // return new Response("Welcome to your new controller!!", Response::HTTP_OK);
       return new Response(json_encode($response), Response::HTTP_OK);
    }


}
