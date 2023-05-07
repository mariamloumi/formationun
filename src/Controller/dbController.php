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
        /* $form = $this->createFormBuilder();
        //$cours = new Courstd();
        $choices = ['selected' => 'merci de choisir une matiere'];
        if ($request->isXmlHttpRequest()) {
        $ansem = $request->get('anesem');
        $matieres = $MatiereRepository->findBy(['ansem' => $ansem]);
        foreach ($matieres as $matiere) {
        $choices[$matiere->getNom()] = $matiere->getNom();
        }
        $mat = '';
        if ($mat == '') {
        return new JsonResponse($choices);
        }
        $form->handleRequest($request);
        $mat = $request->get('matiere');
        if ($form->isSubmitted() /*&& $form->isValid()*//*) {
        return new Response($mat);
        }
        }
        //return new jsonResponse($mat);
        $form->add('nom', FileType::class, [
        'label' => 'Choisir le cours',
        'required' => true,
        ])
        ->add('matiere', choiceType::class, [
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
        'placeholder' => 'merci de choisir un niveau',
        'constraints' => new NotBlank(['message' => 'merci de choisir un niveau.'])
        ])
        ->getForm();
        // $form->handleRequest($request);
        // Handle Ajax request
        // if ($form->isSubmitted() /*&& $form->isValid()*//*) {
        //handle file upload
        //dd($form->getErrors(true));
        ///data = $form->getData();
        //dd($data);
        //  $niveau = $form['anesem']->getData();
        //$cours->setType('cours');
        // $ch = $form['matiere']->getData();
        // $mat = $form->get('matiere')->getData();
        // $ch=$cours->getMatiere();
        //   $fileup = $form['nom']->getData();
        // $fileName = $fileup->getClientOriginalName();
        // moves the file to the directory where brochures are stored
        // $fileup->move(
        //   $this->getParameter('kernel.project_dir') . '/public/assets/images',
        //   $fileName
        //  );
        //return new Response('Saved new cours with id ' . $ch . '666' . $niveau . '777' . $fileName);
        // Render the form
        //  }
        //$cours->setNom('assets/image/'.$fileName);
        //$cours->setAnesem("anesem");
        //$cours->setNom($fileName);
        //$cours->setMatiere("web");
        // $cours->setMatiere($mat);
        //$cours->setAnesem($niveau);
        // tell Doctrine you want to (eventually) save the cours (no queries yet)
        // $entityManager->persist($cours);
        // actually executes the queries (i.e. the INSERT query)
        //  $entityManager->flush();
        // dump($cours);
        $forma = $form->getForm(); // create the form instance
        $formView = $forma->createView();
        return $this->render('ajoutcours.html.twig', [
        'form' => $formView,
        ]);*/

        /*    $form = $this->createFormBuilder();
        $choices = ['selected' => 'merci de choisir une matiere'];
        if ($request->isXmlHttpRequest()) {
        $ansem = $request->get('anesem');
        $matieres = $MatiereRepository->findBy(['ansem' => $ansem]);
        foreach ($matieres as $matiere) {
        $choices[$matiere->getNom()] = $matiere->getNom();
        }
        $mat = '';
        if ($mat == '') {
        return new JsonResponse($choices);
        }
        $mat = $request->get('anesem');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        $mat = $form->getData()['matiere'];
        return $this->redirectToRoute('test', ['matiere' => $mat]);
        }
        }
        $form->add('nom', FileType::class, [
        'label' => 'Choisir le cours',
        'required' => true,
        ])
        ->add('matiere', ChoiceType::class, [
        'choices' => $choices,
        'placeholder' => 'merci de choisir une matière',
        'data' => isset($mat) ? $mat : null,
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
        'placeholder' => 'merci de choisir un niveau',
        'constraints' => new NotBlank(['message' => 'merci de choisir un niveau.']),
        ]);
        $form = $form->getForm();
        return $this->render('ajoutcours.html.twig', [
        'form' => $form->createView(),
        ]);
        }
        public function test($matiere)
        {
        return $this->render('test.html.twig', [
        'matiere' => $matiere,
        ]);
        }*/
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

            /*if ($form->isSubmitted() && $form->isValid()) {
                // Handle the submitted form data
                $formData = $form->getData();
                $matiere = $formData['matiere'];
        
                // Process the form data and do any necessary operations (e.g. file upload)
        
                // Return a JSON response
                $response = new JsonResponse(['success' => true, 'matiere' => $matiere]);
                return $response;
            } */
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
                $cours->setType('td');
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