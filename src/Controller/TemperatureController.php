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
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 *
 */
class TemperatureController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/temperature", name="post_app_temperature")
     * @param Request $request
     *
     * @return Response
     */
    public function postTemperatureAction(Request $request, TemperatureQueryManager  $temperatureQueryManager): Response
    {
        try {
            $uploadedFile = $request->files->get('myFile');

            if (!$uploadedFile) {
                return new Response("No file uploaded!!",  Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $response = $temperatureQueryManager->calculateMkt($uploadedFile, $request->getClientIp());

            return new Response(json_encode($response), Response::HTTP_OK);
        } catch (\InvalidArgumentException $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/temperature", name="get_app_temperature")
     * @param Request $request
     *
     * @return Response
     */
    public function getAction(Request $request, TemperatureQueryManager  $temperatureQueryManager): Response
    {
        try {
            $response = $temperatureQueryManager->findTemperature($request->getClientIp());

            return new Response(json_encode($response), Response::HTTP_OK);
        } catch (\InvalidArgumentException $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


}
