<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PlatRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\Plat;
use App\Entity\Category;
use App\Form\PlatType;

class PlatController extends AbstractController
{

    /** Lecture d'un plat */

    #[Route('/plat/{id}', name: 'plat_show'), IsGranted('ROLE_ADMIN')]
    public function index(ManagerRegistry $doctrine,PlatRepository $platRepository, int $id): Response
    {
        // Entity Manager de Symfony
        $entityManager = $doctrine->getManager();
        $platRepository = $entityManager->getRepository(Plat::class);
        $plat    = new Plat();
        // On récupère le plat qui correspond à l'id passé dans l'url
        // $plat = $platRepository->findBy(['id' => $id]);
        $plat = $platRepository->findBy(['id' => $id])[0];

        return $this->render('plat/viewPlat.html.twig', [
            'controller_name' => 'PlatController',
            'plat' => $plat,
        ]);
    }

    /** Affichage les plats */
    #[Route('/listePlat', name: 'app_liste'), IsGranted('ROLE_ADMIN')]
    public function listePlats(ManagerRegistry $doctrine,PlatRepository $platRepository): Response
    {

         // Entity Manager de Symfony
        $entityManager = $doctrine->getManager();
        $platRepository = $entityManager->getRepository(Plat::class);
         // On récupère tous les articles disponibles en base de données
        $plats   = $platRepository->findAll();
        return $this->render('plat/listePlat.html.twig', [
            // 'controller_name' => 'HomeController',
            'plats'  => $plats
        ]);
        
    }

 /** Modification d'un plat */
#[Route('/editPlat/{id}', name: 'plat_edit'), IsGranted('ROLE_ADMIN')]
public function edit(ManagerRegistry $doctrine,PlatRepository $platRepository,Request $request, int $id=null): Response
{
     // Entity Manager de Symfony
    $entityManager = $doctrine->getManager();
    $platRepository = $entityManager->getRepository(Plat::class);

     // Si un identifiant est présent dans l'url alors il s'agit d'une modification
     // Dans le cas contraire il s'agit d'une création d'plat

    if($id){
        $mode = 'update';
         // On récupère l'plat qui correspond à l'id passé dans l'url
        $plat = $platRepository->findBy(['id' => $id])[0];
    }
    else {
        $mode       = 'new';
        $plat    = new Plat();
    }
    // $plat =$platRepository->findAll();
    // $categories = $entityManager->getRepository(Category::class)->findAll();

    $form = $this->createForm(PlatType::class, $plat);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()) {

        $this->savePlat($plat,$doctrine,$mode);
        return $this->redirectToRoute('app_liste', array('id' => $plat->getId()));
    }
    $parameters = array(
        'form'      => $form->createView(),
        'plat'   => $plat,
        'mode'      => $mode
    );
    return $this->render('plat/edit.html.twig', $parameters);
}

/** Enregistrer un plat en base de données */
#[Route('/addPlat', name: 'plat_add'), IsGranted('ROLE_ADMIN')]
private function savePlat(Plat $plat,ManagerRegistry $doctrine ,string $mode){

    $entityManager = $doctrine->getManager();
    $entityManager->persist($plat);
    $entityManager->flush();
    $this->addFlash('success', 'Enregistré avec succès');
}
/** Supprimer un plat en base de données */
#[Route('/removPlat/{id}', name: 'plat_remove'), IsGranted('ROLE_ADMIN')]
public function remove(ManagerRegistry $doctrine,PlatRepository $platRepository,int $id): Response
{
    /// Entity Manager de Symfony
    $entityManager = $doctrine->getManager();
    $platRepository = $entityManager->getRepository(Plat::class);

    // On récupère l'article qui correspond à l'id passé dans l'URL
    $plat = $platRepository->findBy(['id' => $id])[0];

    // Le plat est supprimé
    $entityManager->remove($plat);
    $entityManager->flush();
    return $this->redirectToRoute('app_liste', [], Response::HTTP_SEE_OTHER);
}
}