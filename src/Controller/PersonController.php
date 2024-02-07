<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PersonRepository;

class PersonController extends AbstractController
{
    #[Route('/person', name: 'app_person')]
    public function index(): Response
    {
        return $this->render('person/index.html.twig', [
            'controller_name' => 'PersonController',
        ]);
    }

    #[Route('/create_person', name: 'create_person')]
    public function createPerson(EntityManagerInterface $entityManager): Response
    {
    $person = new Person();
    $person->setNom('Kent');
    $person->setPrenom('Clark');
    $person->setVille('Metropolis');
    $entityManager->persist($person);
    $entityManager->flush();
    return new Response('Saved new person with id '.$person->getId());
    }

    #[Route('/personnes', name: 'app_personnes')]
    public function indexPersons(PersonRepository $personRepository): Response
    {
        return $this->render('persons/index.html.twig', [
            'persons' => $personRepository->findAll(),
        ]);
    }

    #[Route('/personnes/{id}', name: 'personne_edit',methods:['GET'])]
    public function edit(int $id, PersonRepository $persoRepo){
        $personne = $persoRepo->find($id);
        //var_dump($personne);
        return $this->render('persons/edit.html.twig', [
        'personne' => $personne->findAll(),
    ]);
        
    }

    #[Route('/personnes/{id}/delete', name: 'personne_delete',methods:['GET'])]
    public function delete(int $id, PersonRepository $persoRepository): Response{
    $personne = $persoRepository->find($id);
    $persoRepository->remove($personne);
    return $this->redirect('/personnes', Response::HTTP_FOUND);
    }
}
