<?php

namespace App\Controller;

use App\Repository\DepenseRepository;
use App\Repository\OperationRepository;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends AbstractController
{
    #[Route('/pdf/depenses', name: 'app_operations_pdf')]
    public function index(OperationRepository $operationRepository): Response
    {
        $data = [
            // 'imageSrc'  => $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/img/profile.png'),
            'operations' => $operationRepository->findAll(),
        ];
        $html =  $this->renderView('pdf/operations.html.twig', $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
         
        return new Response (
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }
}