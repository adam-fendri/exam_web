<?php

namespace App\Controller;

use App\Entity\Etudiant;
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

    #[Route('/etudiant/add', name: 'etudiant.add')]
    public function add(ManagerRegistry $doctrine,  Request $request): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //si oui
            //on va ajouter lobjet personne dans la BD
            $entityManager = $doctrine->getManager();
            $entityManager->persist($etudiant);
            $entityManager->flush();
            //msg success
            $this->addFlash("success", $etudiant->getNom() . "a ete ajoute");
            //rediriger vers la liste de success
            return $this->redirectToRoute('etudiant');
        } else {
            //sinon
            return $this->render('etudiant.add.html.twig', ['form' => $form->createView()]);
            //on affiche le formulaire
        }

        #[Route('/etudiant/edit/{id}', name: 'etudiant.edit')]
    public function editPersonne(Etudiant $etudiant=null, ManagerRegistry $doctrine, Request $request ): Response
    {
        if(!$etudiant){
            $etudiant= new Etudiant();
        }
        $form=$this->createForm(EtudiantType::class, $etudiant);
        $form->remove('createdAt');
        $form->remove('updatedAt');

        $form->handleRequest($request);
        //est ce que le formulaire a ete soumis
        if($form->isSubmitted()){
            //si oui
            //on va ajouter lobjet personne dans la BD
            $entityManager=$doctrine->getManager();
            $entityManager->persist($etudiant);
            $entityManager->flush();
            //msg success
            $this->addFlash("success", $etudiant->getName()."a ete edite");
            //rediriger vers la liste de success
            return $this->redirectToRoute('etudiant');
        }else{
            //sinon
            return $this->render('etudiant.add.html.twig',['form'=>$form->createView()]);
            //on affiche le formulaire
        }




        return $this->render('etudiant.add.html.twig', [
            'form'=> $form->createView()
        ]);
    }


    }
    #[Route('/etudaint/delete/{id}', name: 'etudiant.delete')]
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
