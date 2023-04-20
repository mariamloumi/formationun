<?php

namespace App\Controller;

use App\Entity\Courstd;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FilcoursesRepository;
use App\Repository\MatiereRepository;
use App\Repository\CourstdRepository;
/**
 * Summary of dbController
 */
class dbController extends AbstractController
{
    /*
     * @Route("/collapsible__", name="collapsible__")
     */
    public function index(FilcoursesRepository $FilcoursesRepository): Response
    {
        $filcourses = $FilcoursesRepository->findAll();

        return $this->render('collapsible.html.twig', [
            'filcourses' => $filcourses,
        ]);

    }

    #[Route('/courstd', name: 'create_cours')]
    public function addcours(EntityManagerInterface $entityManager): Response
    {
        $cours = new Courstd();
       
        $cours->setNom("analyse1");
        $cours->setMatiere('analyse');
        $cours->setAnesem('prepa1');
        $cours->setType('td');

        // tell Doctrine you want to (eventually) save the cours (no queries yet)
        $entityManager->persist($cours);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new cours with id ' . $cours->getId());
    }
    public function matieres(string $ansem,MatiereRepository $MatiereRepository): Response
    {
        $matiere = $MatiereRepository->findBy(['ansem' => $ansem]);

        return $this->render('matieres.html.twig', [
            'matieres' => $matiere,
        ]);

    }
    public function courstd(string $anesem,string $nom,CourstdRepository $courstdRepository): Response
    {
        $matiere = $courstdRepository->findBy(['anesem' => $anesem,'matiere'=>$nom]);

        return $this->render('courstd.html.twig', [
            'matieres' => $matiere,
        ]);

    }
    
}