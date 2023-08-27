<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeFormType;
use App\Repository\RecipeRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    private $recipeRepository;
    private $em;

    public function __construct(RecipeRepository $recipeRepository, EntityManagerInterface $em)
    {
        $this->recipeRepository = $recipeRepository;
        $this->em = $em;
    }

    #[Route('/recipe', name: 'app_recipe')]
    public function index(): Response
    {
        $recipes = $this->recipeRepository->findAll();

        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('/recipe/get/{id}', name: 'get_recipe')]
    public function getRecipe($id): Response
    {
        $recipe = $this->recipeRepository->find($id);

        return $this->render('recipe/record.html.twig', [
            'recipe' => $recipe
        ]);
    }

    #[Route('/recipe/add', name: 'add_recipe')]
    public function addRecipe(Request $request): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeFormType::class, $recipe);
        $form->handleRequest($request);
        
        if($form->isSubmitted()) {
            $newRecipe = $form->getData();
            $newRecipe->setAuthor($this->getUser());
            $newRecipe->setDateOfEntry(new DateTime());
            $this->em->persist($newRecipe);
            $this->em->flush();
            return $this->redirectToRoute('get_recipe', array('id' => $newRecipe->getId()));
        }

        return $this->render('recipe/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/recipe/delete/{id}', name: 'delete_recipe')]
    public function deleteRecipe($id): Response
    {
        $recipe = $this->recipeRepository->find($id);
        $this->em->remove($recipe);
        $this->em->flush();

        return $this->redirectToRoute('app_recipe');
    }

    #[Route('/recipe/edit/{id}', name: 'edit_recipe')]
    public function editRecipe($id, Request $request): Response
    {
        $recipe = $this->recipeRepository->find($id);
        $form = $this->createForm(RecipeFormType::class, $recipe);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $recipe = $form->getData();
            $recipe->setAuthor($this->getUser());
            $recipe->setDateOfEntry(new DateTime());
            $this->em->persist($recipe);
            $this->em->flush();
            return $this->redirectToRoute('get_recipe', array('id' => $id));
        }

        return $this->render('recipe/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
