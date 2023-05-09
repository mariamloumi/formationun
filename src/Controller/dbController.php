<?php

namespace App\Controller;

use App\Entity\Courstd;
use App\Entity\Matiere;
use App\Repository\CourstdRepository;
use App\Repository\FilcoursesRepository;
use App\Repository\MatiereRepository;
use Doctrine\ORM\EntityManagerInterface;
use SebastianBergmann\Environment\Console;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Summary of dbController
 */
class dbController extends AbstractController
{

    public function index(FilcoursesRepository $FilcoursesRepository): Response
    {
        $filcourses = $FilcoursesRepository->findAll();

        return $this->render('collapsible.html.twig', [
            'filcourses' => $filcourses,
        ]);

    }

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
    public function matieres(string $ansem, MatiereRepository $MatiereRepository): Response
    {
        $matiere = $MatiereRepository->findBy(['ansem' => $ansem]);

        return $this->render('matieres.html.twig', [
            'matieres' => $matiere,
        ]);

    }
    public function courstd(string $anesem,string $nom, CourstdRepository $courstdRepository): Response
    {
        $matiere = $courstdRepository->findBy(['anesem' => $anesem,'matiere'=>$nom]);

        return $this->render('courstd.html.twig', [
            'matieres' => $matiere,
        ]);

    }


    public function ajtc(Request $request, MatiereRepository $MatiereRepository, EntityManagerInterface $entityManager): Response
    {
        
        $choices = [];
        $form = $this->createFormBuilder()
            ->add('nom', FileType::class, [
                'label' => 'Choisir le cours',
                'required' => true,
            ])
            ->add('matiere', ChoiceType::class, [
                'choices' => $choices,
                'placeholder' => 'merci de choisir une matière',
                'constraints' => new NotBlank(['message' => 'merci de choisir une matiere.']),
            ])
            ->add('anesem', ChoiceType::class, [
                'choices' => [
                    'Cycle prépararoire 1-1' => 'prepa1-1',
                    'Cycle prépararoire 1-2' => 'prepa1-2',
                    'Cycle prépararoire 2-1' => 'prepa2-1',
                    'Cycle prépararoire 2-2' => 'prepa2-2',
                    'Cycle ingénieur 1-1' => 'FIA1-1',
                    'Cycle ingénieur 1-2' => 'FIA1-2',
                    'Cycle ingénieur 2-1' => 'FIA2-1',
                    'Cycle ingénieur 2-2' => 'FIA2-2',
                    'Cycle ingénieur 3-1' => 'FIA3-1',
                ],
                'label'=>'Année et semestre',
                'placeholder' => 'merci de choisir un niveau',
                'constraints' => new NotBlank(['message' => 'merci de choisir un niveau.']),
            ]) ->add('submit', SubmitType::class, ['label' => 'Submit'])
            ->getForm();
            
            $form->handleRequest($request);

            
            if ($request->isXmlHttpRequest()) {
                $cours = new Courstd();
                $anesem = $request->request->get('anesem');
                $matiere = $request->request->get('matiere');
                $nom = $request->files->get('nom');
                error_log("anesem: " . $anesem);
                error_log("matiere: " . $matiere);
                error_log("nom: " . $nom);
                $nom->move(
                      $this->getParameter('kernel.project_dir') . '/public/assets/docs',
                      $nom->getClientOriginalName()
                      );
                $cours->setAnesem($anesem);
                $cours->setNom($nom->getClientOriginalName());
                $cours->setMatiere($matiere);
                $cours->setType('autre');
                $entityManager->persist($cours);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();
                return new JsonResponse(['success' => true,'cours ajouté avec succes']);
            }
            
            
        return $this->render('ajoutcours.html.twig', [
            'form' => $form->createView(),
            'choices' => $choices,
        ]);
    
 
    }
    public function getMatieres(Request $request, MatiereRepository $matiereRepository): JsonResponse
{
    $anesem = $request->get('anesem');
    $matieres = $matiereRepository->findBy(['ansem' => $anesem]);
    $choices = [];

    foreach ($matieres as $matiere) {
        $choices[$matiere->getNom()] = $matiere->getNom();
    }

    return new JsonResponse($choices);
}

}