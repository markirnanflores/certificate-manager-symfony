<?php

namespace App\Controller;

use App\Entity\Certificate;
use App\Exception\ConstraintValidationException;
use App\Model\Http\Request\CertificateModel;
use App\Model\Http\Response\ValidationResponse;
use App\Validator\CertificateRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CertificatesController extends AbstractController
{
    #[Route('/certificates', name: 'certificate_index', methods: ['GET'])]
    public function index(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ): Response {
        $response = new Response(
            $serializer->serialize($entityManager->getRepository(Certificate::class)->findAll(), 'json'),
            200
        );
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    #[Route('/certificates', name: 'certificate_store', methods: ['POST'])]
    public function store(
        CertificateRequest $certificateRequestValidator,
        EntityManagerInterface $entityManager,
        Request $request,
        SerializerInterface $serializer
    ): JsonResponse {
        try{
            $certificateRequest = new CertificateModel($request->getPayload());
            $certificateRequestValidator->validate($certificateRequest);
            $certificate = new Certificate();
            $certificate->setName($certificateRequest->getName());
            $certificate->setCertificate($certificateRequest->getCertificate());
            $certificate->setPrivateKey($certificateRequest->getPrivateKey());
            $certificate->setIntermediateCa($certificateRequest->getIntermediateCa());
            $entityManager->persist($certificate);
            $entityManager->flush();
            return $this->json(json_decode($serializer->serialize($certificate, 'json')));
        } catch(ConstraintValidationException $e) {
            return new ValidationResponse($e->getViolationList());
        }
    }

    #[Route('/certificates/{id}', name: 'certificate_show', methods: ['GET'])]
    public function show(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        int $id
    ): Response {
        $certificate = $entityManager->getRepository(Certificate::class)->find($id);
        // dd($certificate);
        if (!$certificate instanceof Certificate) {
            return new JsonResponse(['message' => 'Not found'], 404);
        }
        return new JsonResponse(json_decode($serializer->serialize($certificate, 'json')));
    }

    #[Route('/certificates/{id}', name: 'certificate_destroy', methods: ['DELETE'])]
    public function destroy(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        int $id
    ): Response {
        $certificate = $entityManager->getRepository(Certificate::class)->find($id);
        if (!$certificate instanceof Certificate) {
            return new JsonResponse(['message' => 'Not found'], 404);
        }
        $entityManager->remove($certificate);
        $entityManager->flush();
        return new JsonResponse(json_decode($serializer->serialize($certificate, 'json')));
    }

    #[Route('/certificates/{id}', name: 'certificate_update', methods: ['PUT'])]
    public function update(
        EntityManagerInterface $entityManager,
        Request $request,
        SerializerInterface $serializer,
        int $id
    ): Response {
        $certificate = $entityManager->getRepository(Certificate::class)->find($id);
        if (!$certificate instanceof Certificate) {
            return new JsonResponse(['message' => 'Not found'], 404);
        }
        $payload = $request->getPayload()->all();
        $certificate->setName($payload['name'] ?? $certificate->getName());
        $certificate->setCertificate($payload['certificate'] ?? $certificate->getCertificate());
        $certificate->setPrivateKey($payload['privateKey'] ?? $certificate->getPrivateKey());
        $certificate->setIntermediateCa($payload['intermediateCa'] ?? $certificate->getIntermediateCa());
        $entityManager->flush();
        return new JsonResponse(json_decode($serializer->serialize($certificate, 'json')));
    }
}
