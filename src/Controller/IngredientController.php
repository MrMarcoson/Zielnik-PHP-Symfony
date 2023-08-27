<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientFormType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends AbstractController
{
    private $ingredientRepository;
    private $em;

    public function __construct(IngredientRepository $ingredientRepository, EntityManagerInterface $em)
    {
        $this->ingredientRepository = $ingredientRepository;
        $this->em = $em;
    }

    #[Route('/ingredient', name: 'app_ingredient')]
    public function index(): Response
    {
        $ingredients = $this->ingredientRepository->findAll();

        return $this->render('ingredient/index.html.twig', [
            'ingredients' => $ingredients,
        ]);
    }

    #[Route('/ingredient/add', name: 'add_ingredient')]
    public function addTag(Request $request): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientFormType::class, $ingredient);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $this->em->persist($form->getData());
            $this->em->flush();
            return $this->redirectToRoute('app_recipe');
        }

        return $this->render('ingredient/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
