<?php

namespace App\Services;

use App\Entity\Document;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class DocumentManagerService
{
    private $params;
    private ManagerRegistry $doctrine;

    public function __construct(ParameterBagInterface $params, ManagerRegistry $doctrine)
    {
        $this->params = $params;
        $this->doctrine = $doctrine;
    }

    public function saveFiles(array $files, array $generatedFilenames): void
    {
        for ($i = 0; $i < count($files[0]); $i++) {
            $files[0][$i]->move($this->params->get('kernel.project_dir').$this->params->get('documentDirectory'),
                $generatedFilenames[$i]);

            $newDocument = new Document();
            $newDocument->setOriginalFilename($files[0][$i]->getClientOriginalName())
                ->setGeneratedFilename($generatedFilenames[$i])
                ->setMimeType($files[0][$i]->getClientOriginalExtension())
                ->setSize(8192);

            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($newDocument);
            $entityManager->flush();
        }
    }
}