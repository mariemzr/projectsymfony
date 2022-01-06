<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




use Symfony\Component\HttpFoundation\Request;
use App\Entity\Reservations;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;





class ProjetController extends AbstractController
{
    /**
     * @Route("/projet", name="projet")
     */
    public function index(): Response
    {
        return $this->render('projet/index.html.twig', [
            'controller_name' => 'ProjetController',
        ]);
    }


/**
     * @Route("/voir/{id}", name="voir", requirements={"id"="\d+"})
     */
    public function voir($id)
    {
        $repository=$this->getDoctrine()->getManager()->getRepository(Reservations::class);
        $reservation=$repository->find($id);
        if (null===$reservation){
            throw new NotFoundHttpException("La res ayant l'id ".$id."n'existe pas.");
        }    





        //return new Response("Détails du job ayant l'id:".$id); ou bien 
        return $this->render('projet/voir.html.twig', [
        	'reservation'=> $reservation,
        ]);
    }





        /**
     * @Route("/base", name="base" ,
     requirements={"id"="\d+"})

     */
    public function base()
    {
        return $this->render('base.html.twig'); //render thotek wahadha fel template 
    }

    /**
     * @Route("/layout", name="layout" )
     */  
     public function layout()
    {
        return $this->render('projet/layout.html.twig'); 
    }




/**
     * @Route("/recipes", name="recipes" )
     */  
     public function recipes()
    {
        return $this->render('projet/recipes.html.twig'); 
    }

/**
     * @Route("/about", name="about" )
     */  
     public function about(Request $request)
    {

		$reservation=new reservations();
		$date="2021-01-01";
		$reservation->setDate(new \DateTime($date)); 
		$time="09:00";
		$reservation->setTime(new \DateTime($time)); 
		
        $form= $this->createFormBuilder($reservation)
            ->add('nom',TextType::class, array('required'=>true,'label' => 'Surname'))
            ->add('prenom', TextType::class, array('required'=>true,'label' => 'Name'))
            ->add('email', TextType::class, array('required'=>true,'label' => 'Email'))
            ->add('phone', IntegerType::class, array('required'=>true,'label' => 'Phone'))
            ->add('date', DateType::class, array('required'=>true,'label' => 'Book Date'))
            ->add('time', TimeType::class, array('required'=>true,'label' => 'Book Time'))
            ->add('personnes', IntegerType::class, array('required'=>false,'label' => 'person'))
            ->add('submit', SubmitType::class, array('label' => 'Book'))
            ->getForm();

            if($request->isMethod('POST'))
            	{ $form->handleRequest($request);
            		if($form->isValid())
            		{ $em=$this->getDoctrine()->getManager();
            		  $em->persist($reservation);
            		  $em->flush();
            		  $request->getSession()->getFlashBag()->add('notice','Reservations bien enregistrer');
            		  return $this->redirectToRoute('voir',array('id'=>$reservation->getId()));

            		} 

            	}



        return $this->render('projet/about.html.twig', array('form' =>$form->createView()));



        
    }


    /**
     * @Route("/modifier/{id}", name="modifier", requirements={"id"="\d+"})

     */
     public function modifier($id,Request $request)
    {

        $reservation=$this->getDoctrine()
                        ->getManager()
                        ->getRepository(Reservations::class)
                        ->find($id);
        $date="2021-01-01";
        $reservation->setDate(new \DateTime($date)); 
        $time="09:00";
        $reservation->setTime(new \DateTime($time)); 
        
        $form= $this->createFormBuilder($reservation)
            ->add('nom',TextType::class, array('required'=>true,'label' => 'Surname'))
            ->add('prenom', TextType::class, array('required'=>true,'label' => 'Name'))
            ->add('email', TextType::class, array('required'=>true,'label' => 'Email'))
            ->add('phone', IntegerType::class, array('required'=>true,'label' => 'Phone'))
            ->add('date', DateType::class, array('required'=>true,'label' => 'Book Date'))
            ->add('time', TimeType::class, array('required'=>true,'label' => 'Book Time'))
            ->add('personnes', IntegerType::class, array('required'=>false,'label' => 'person'))
            ->add('submit', SubmitType::class, array('label' => 'Book'))
            ->getForm();

            if($request->isMethod('POST'))
                { $form->handleRequest($request);
                    if($form->isValid())
                    { $em=$this->getDoctrine()->getManager();
                      $em->persist($reservation);
                      $em->flush();
                      $request->getSession()->getFlashBag()->add('notice','Reservations bien modifié.');
                      return $this->redirectToRoute('voir',array('id'=>$reservation->getId()));

                    } 

                }



        return $this->render('projet/modifier.html.twig', array('form' =>$form->createView()));



        
    }

}

