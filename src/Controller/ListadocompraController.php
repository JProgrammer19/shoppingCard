<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ListadocompraController extends AbstractController
{
    /**
     * @Route("/", name="listadocompra")
     * @Method({"GET"})
     */
    public function index()
    {
        $articles = $this->getDoctrine()->getRepository
        (Article::class)->findAll();

        return $this->render('listadocompra/index.html.twig', array(
            'articles' => $articles
        ));
    }   


    public function new(Request $request){
        $article = new Article();

        $form = $this->createFormBuilder($article)
        ->add('title', TextType::class, array('attr' => array( 
            'class' => 'form-control')))
        ->add('body', TextareaType::class, array(
            'label' => 'Description',
            'required' => false,
            'attr' => array( 'class' => 'form-control')
        ))
        ->add('save', SubmitType::class, array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-primary mt-3')
        ))
        ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('listadocompra');
        }
            
        return $this->render('listadocompra/new.html.twig', array(
            'form' => $form->createView()
        ));
    }


    public function update(Request $request, $id){
        $article = new Article();
        $article = $this->getDoctrine()->getRepository
        (Article::class)->find($id);

        $form = $this->createFormBuilder($article)
        ->add('title', TextType::class, array('attr' => array( 
            'class' => 'form-control')))
        ->add('body', TextareaType::class, array(
            'label' =>'Description',
            'required' => false,
            'attr' => array( 'class' => 'form-control')
        ))
        ->add('save', SubmitType::class, array(
            'label' => 'Update',
            'attr' => array('class' => 'btn btn-primary mt-3')
        ))
        ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            

            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->flush();

            return $this->redirectToRoute('listadocompra');
        }
            
        return $this->render('listadocompra/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
  
    public function show($id){
        $article = $this->getDoctrine()->getRepository
        (Article::class)->find($id);

        return $this->render('listadocompra/show.html.twig', array(
            'article' => $article
        ));
    }

    public function delete(Request $request, $id){
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        $response = new Response();
        $response-> send();


    }


    
    /*
    //PROOF SAVE FUNCTION  AND RESPONSE 
    public function save(){
        $entityManager = $this->getDoctrine()->getManager();

        $article = new Article();
        $article->setTitle('Article one');
        $article->setBody('This is the body first article one');

        $entityManager->persist($article);
        $entityManager->flush();

        return new Response('Save an article with the id of
        '.$article->getId());

    }
    */

    
}