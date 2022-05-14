<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    #[Route('/etudiant', name: 'etudiant')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Etudiant::class);
        $etudiants=$repository->findAll();
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiants,
        ]);
    }


//    #[Route('/etudiant/add', name: 'etudiant.add')]
    #[Route('/etudiant/edit/{id?0}', name: 'etudiant.edit')]
    public function add(Etudiant $etudiant = null ,ManagerRegistry $doctrine,  Request $request): Response
    {
        $new = false;
        if (!$etudiant) {
            $new = true;
            $etudiant = new Etudiant();
        }

        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //si oui
            //on va ajouter lobjet etudiant dans la BD
            $entityManager = $doctrine->getManager();
            $entityManager->persist($etudiant);
            $entityManager->flush();
            //msg success
            if($new) {
                $message = " a été ajouté avec succès";
            } else {
                $message = " a été mis à jour avec succès";
            }
            $this->addFlash('success',$etudiant->getNom(). $message );
            //rediriger vers la liste de success
            return $this->redirectToRoute('etudiant');
        } else {
            //sinon
            //on affiche le formulaire
            return $this->render('etudiant/etudiant.add.html.twig', ['form' => $form->createView()]);

        }
    }

    #[Route('/add', name: 'etudiant.add')]
    public function addEtudiant(ManagerRegistry $doctrine,Request $request): Response
    {  $entityManager=$doctrine->getManager();
        $etudiant=new Etudiant();
        $form=$this->createForm(EtudiantType::class,$etudiant);
        $form->handleRequest($request);
        if(!$form->isSubmitted()){
            return $this->render('etudiant/etudiant.add.html.twig',[
                'form'=>$form->createView(),
            ]);}
        else{
            $entityManager->persist($etudiant);
            $entityManager->flush();
            $this->addFlash('success',$etudiant->getNom().' est ajouté avec success');
            return $this->redirectToRoute('etudiant');
        }
    }

    #[Route('/etudaint/delete/{id?0}', name: 'etudiant.delete')]
    public function delete(Etudiant $etudiant = null, ManagerRegistry $doctrine): RedirectResponse
    {
        //recuperer la personne
        if($etudiant){
            //si la personne existe => le supprimer et addFlash success
            $manager = $doctrine->getManager();
            // ajout de la supression dans la transaction
            $manager->remove($etudiant);
            //executer la transaction
            $manager->flush();
            //addFlash
            $this->addFlash('success',"letudiant a ete supprimee");
        }else{
            //si la personne nexiste pas => addFlash danger/erreur
            $this->addFlash('error',"letudiant nexiste pas");
        }
        return $this->redirectToRoute('etudiant');
    }

}
