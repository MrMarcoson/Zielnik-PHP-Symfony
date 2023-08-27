<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/tag', name: 'app_tag')]
    public function index(): Response
    {
        return $this->render('tag/index.html.twig', [
            'controller_name' => 'TagController',
        ]);
    }

    #[Route('/tag/add', name: 'add_tag')]
    public function addTag(Request $request): Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagFormType::class, $tag);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $this->em->persist($form->getData());
            $this->em->flush();
            return $this->redirectToRoute('app_recipe');
        }

        return $this->render('tag/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
