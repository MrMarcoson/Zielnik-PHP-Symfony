<?php

namespace App\Controller;

use App\Entity\Herb;
use App\Entity\User;
use App\Form\HerbFormType;
use App\Repository\HerbRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HerbController extends AbstractController
{
    private $herbRepository;
    private $em;

    public function __construct(HerbRepository $herbRepository, EntityManagerInterface $em)
    {
        $this->herbRepository = $herbRepository;
        $this->em = $em;
    }

    #[Route('/herb', name: 'app_herb')]
    public function index(): Response
    {
        $herbs = $this->herbRepository->findAll();

        return $this->render('herb/index.html.twig', [
            'herbs' => $herbs,
        ]);
    }

    #[Route('/herb/get/{id}', name: 'get_herb')]
    public function getHerb($id): Response
    {
        $herb = $this->herbRepository->find($id);
        return $this->render('herb/record.html.twig', [
            'herb' => $herb
        ]);
    }

    #[Route('/herb/add', name: 'add_herb')]
    public function addHerb(Request $request): Response
    {
        $herb = new Herb();
        $form = $this->createForm(HerbFormType::class, $herb);
        $form->handleRequest($request);
        
        if($form->isSubmitted()) {
            $newHerb = $form->getData();
            $newHerb->setAuthor($this->getUser());
            $newHerb->setDateOfEntry(new DateTime());
            $this->em->persist($newHerb);
            $this->em->flush();
            return $this->redirectToRoute('get_herb', array('id' => $newHerb->getId()));
        }

        return $this->render('herb/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/herb/delete/{id}', name: 'delete_herb')]
    public function deleteHerb($id): Response
    {
        $herb = $this->herbRepository->find($id);
        $this->em->remove($herb);
        $this->em->flush();

        return $this->redirectToRoute('app_herb');
    }

    #[Route('/herb/edit/{id}', name: 'edit_herb')]
    public function editHerb($id, Request $request): Response
    {
        $herb = $this->herbRepository->find($id);
        $form = $this->createForm(HerbFormType::class, $herb);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $herb = $form->getData();
            $herb->setAuthor($this->getUser());
            $herb->setDateOfEntry(new DateTime());
            $this->em->persist($herb);
            $this->em->flush();
            return $this->redirectToRoute('get_herb', array('id' => $id));
        }

        return $this->render('herb/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
