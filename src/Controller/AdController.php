<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use \Symfony\Component\HttpFoundation\Request;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends AbstractController
{
    /**
     * permet d 'afficher des annonces en provenance de la base de donnéé
     */

    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo): Response
    {
       // $repo =$this->getDoctrine()->getRepository(Ad::class);
        $ads= $repo->findAll();
        return $this->render('ad/index.html.twig', [
            'ads' =>$ads
        ]);
    }
    /**
     * creer une annonce à travers un formulaire
     */
    /**
     * @Route("/ads/new", name="ads_create")
     */
    public function create( Request $request, EntityManagerInterface $manager)
    {
        $ad= new Ad();
       /* $image= new Image();
        $image->setUrl('https://via.placeholder.com/140x100')
            ->setLegende('titre1');

        $image2= new Image();
        $image2->setUrl('https://via.placeholder.com/140x100')
            ->setLegende('titre1');
            $ad->addImage($image);
            $ad->addImage($image2);
       */



        $form= $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);
        // permet de test avant de soumettre le formulaire
        //$this->addFlash('success',"l'annonce <strong>test</strong> à été bien enregistrée!");
       // $this->addFlash('success',"l'annonce de geoffroy");
       // $this->addFlash('danger',"le message d'erreur");
        if($form->isSubmitted()&& $form->isValid()){
            foreach ($ad->getImages() as$image){
                $image->setAd($ad);
                $manager->persist($image);
            }

           $manager->persist($ad);
           $manager->flush();

            $this->addFlash('success',"l'annonce <strong>{$ad->getTitle()}</strong> à été bien enregistrée!");
           return $this->redirectToRoute('ads_slug',[
               'slug'=>$ad->getSlug()
           ]);
        }

        return $this->render('ad/new.html.twig',[

'form' => $form->createView()
            ]);
    }

    /**
     * permet d editer une annonce
     */
    /**
     * @Route("ads/{slug}/edit", name= "ads_edit")
     */
    public function edit(Ad $ad, Request $request, EntityManagerInterface $manager){
        $form= $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            foreach ($ad->getImages() as$image){
                $image->setAd($ad);
                $manager->persist($image);
            }

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash('success',"les modifications de l'annonce <strong>{$ad->getTitle()}</strong> ont été bien enregistrées!");
            return $this->redirectToRoute('ads_slug',[
                'slug'=>$ad->getSlug()
            ]);
        }


        return $this->render('ad/edit.html.twig',[
            'form'=>$form->createView(),
            'ad'=> $ad
        ]);
    }
    /**
     * permet d affiche une seule annonce
     */
    /**
     * @Route ("/ads/{slug}", name= "ads_slug")
     */
    public function show(Ad $ad)
    {
        // je recupere l'annonce correspond au slug

     // $ad= $repo->findOneBySlug($slug);
      return $this->render('ad/show.html.twig', [
        'ad' =>$ad
      ]);
    }
}
