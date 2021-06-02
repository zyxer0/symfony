<?php


namespace App\Controller;


use App\Entity\ShortUrl;
use App\Form\ShortUrlType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    
    
    public function index(Request $request): Response
    {
        $shortUrl = new ShortUrl();
        
        $form = $this->createForm(ShortUrlType::class, $shortUrl)
            ->add('saveAndCreateNew', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($shortUrl);
            $em->flush();
            
            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('admin_post_new');
            }

            return $this->redirectToRoute('admin_post_index');
        }
        
        
        return $this->render('shortener/index.twig', [
            'var1' => 'foo',
            'form' => $form->createView(),
        ]);
    }
    
    public function history(): Response
    {
        return new Response('history');
    }
}