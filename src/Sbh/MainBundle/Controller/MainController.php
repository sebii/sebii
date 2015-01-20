<?php

namespace Sbh\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Process\Process;

class MainController extends Controller
{
    /**
     * 
     * @Route("/{_lang}", name="home", requirements={"_lang"="\w{2}"}, defaults={"_lang"="fr"})
     */
    public function indexAction()
    {
        return $this->render('SbhMainBundle:Main:index.html.twig');
    }
    
    /**
     * 
     * @Route("/{_lang}/htmlspchars", name="sbh_main_main_htmlspecialchars", requirements={"_lang"="\w{2}"}, defaults={"_lang"="fr"})
     */
    public function htmlspecialcharsAction()
    {
        return $this->render('SbhMainBundle:Main:htmlspecialchars.html.twig');
    }
    
    /**
     * 
     * @param Symfony\Component\BrowserKit\Request $request
     * @Route("/{_lang}/ytdl/{platform}/{videoId}", name="sbh_main_main_ytdl", requirements={"_lang"="\w{2}"}, defaults={"_lang"="fr", "platform": "none", "videoId": "0"})
     */
    public function ytdl(Request $request, $platform, $videoId)
    {
        $formUrl = $this->createFormBuilder()
            ->add('url', 'text')
            ->add('save', 'submit')
            ->getForm();
        
        if ($platform !== 'none' && $videoId !== "0")
        {
            switch ($platform)
            {
                case 'youtube':
                    $cmd     = 'youtube-dl https://youtube.com/watch?v=' . $videoId . ' -F';
                    $process = new Process($cmd);
                    $process->setTimeout(3600);
                    $process->run();
                    $output  = $process->getOutput();
                    dump($cmd, $output);
                    exit();
                    break;
            }
        }
        elseif ($request->isMethod('POST'))
        {
            if ($formUrl->handleRequest($request))
            {
                $formData = $request->request->get('form');
                $url      = $formData['url'];
                if (substr($url, 0, 30) == 'https://www.youtube.com/watch?')
                {
                    $youtubeParams = explode('&', substr($url, 30));
                    foreach ($youtubeParams as $youtubeParam)
                    {
                        if (substr($youtubeParam, 0, 2) == 'v=')
                        {
                            $videoId = substr($youtubeParam, 2);
                        }
                    }
                    return $this->redirect($this->generateUrl('sbh_main_main_ytdl', array('platform' => 'youtube', 'videoId' => $videoId)));
                }
                
            }
        }
        
        return $this->render('SbhMainBundle:Main:ytdl.html.twig', array(
                'formUrl' => $formUrl->createView(),
        ));
    }
}
