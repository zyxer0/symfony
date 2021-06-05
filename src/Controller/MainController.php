<?php


namespace App\Controller;


use App\Entity\ShortUrl;
use App\Form\ShortUrlType;
use App\Form\TrackType;
use App\Repository\ShortUrlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    
    
    public function index(Request $request, ValidatorInterface $validator, UrlGeneratorInterface $router): Response
    {
        $shortUrl = new ShortUrl();
        
        $form = $this->createForm(ShortUrlType::class, $shortUrl)
            ->add('saveAndCreateNew', SubmitType::class);

        $form->handleRequest($request);
        
        $errors = [];
        if ($form->isSubmitted()) {
            
            $errors = $validator->validate($shortUrl);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($shortUrl);
                $em->flush();
                
                return $this->render('shortener/created_url.twig', [
                    'short_url' => $shortUrl->getShortUrl(),
                    'absolute_short_url' => $router->generate('short_url_page', ['slug' => $shortUrl->getShortUrl()], UrlGeneratorInterface::ABSOLUTE_URL),
                    'long_url' => $shortUrl->getLongUrl(),
                ]);
            }
        }
        
        return $this->render('shortener/create_url.twig', [
            'validateErrors' => $errors,
            'form' => $form->createView(),
        ]);
    }
    
    public function totalClicks(ShortUrlRepository $shortUrlRepository, string $slug): Response
    {
        /** @var ShortUrl $shortUrl */
        if (!($shortUrl = $shortUrlRepository->findOneByShortUrl($slug))/* || (new \DateTime()) > $shortUrl->getExpiration()*/) {
            return $this->render('404.twig');
        }
        
        return $this->render('shortener/history_click.twig', [
            'short_url' => $shortUrl->getShortUrl(),
            'usages_num' => $shortUrl->getUsages(),
        ]);
    }
    
    public function trackTotalClicks(Request $request, ShortUrlRepository $shortUrlRepository): Response
    {
        $form = $this->createForm(TrackType::class);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid() && !empty($form->getData()['ShortUrl'])) {
            /** @var ShortUrl $shortUrl */
            if (!$shortUrl = $shortUrlRepository->findOneByShortUrl($form->getData()['ShortUrl'])) {
                return $this->render('shortener/track_history_click.twig', [
                    'form' => $form->createView(),
                    'error' => 'track.not_found',
                ]);
            }
            return $this->redirectToRoute('total_clicks', ['slug' => $shortUrl->getShortUrl()]);
        }

        return $this->render('shortener/track_history_click.twig', [
            'form' => $form->createView(),
            'error' => null,
        ]);
    }
    
    public function externalRedirect(ShortUrlRepository $shortUrlRepository, string $slug): Response
    {
        /** @var ShortUrl $shortUrl */
        if (!($shortUrl = $shortUrlRepository->findOneByShortUrl($slug)) || (new \DateTime()) > $shortUrl->getExpiration()) {
            return $this->render('404.twig');
        }
        $shortUrl->setUsages($shortUrl->getUsages() + 1);
        
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($shortUrl);
        $em->flush();

        return $this->redirect($shortUrl->getLongUrl());
    }
}