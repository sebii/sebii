<?php

namespace Sbh\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
                    $cmd           = 'youtube-dl https://youtube.com/watch?v=' . $videoId . ' -F';
                    $process       = new Process($cmd);
                    $process->setTimeout(3600);
                    $process->run();
                    $outputLines   = explode(PHP_EOL, $process->getOutput());
                    dump($outputLines);
                    exit();
                    $youtubeInfos  = array();
                    $youtubeAudios = array();
                    $youtubeVideos = array();
                    foreach ($outputLines as $outputLine)
                    {
                        if (substr($outputLine, 0, 1) === '[')
                        {
                            continue;
                        }
                        elseif (strlen($outputLine) === 0)
                        {
                            continue;
                        }
                        elseif (substr($outputLine, 0, 7) === 'format ')
                        {
                            continue;
                        }
                        
                        $formatCodeId = intval(trim(substr($outputLine, 0, 11)));
                        
                        $youtubeInfos[$formatCodeId] = array(
                            'formatCode' => $formatCodeId,
                            'extension'  => trim(substr($outputLine, 12, 9)),
                            'resolution' => trim(substr($outputLine, 22, 11)),
                            'note'       => trim(substr($outputLine, 34)),
                        );
                        
                        if ($youtubeInfos[$formatCodeId]['resolution'] === 'audio only')
                        {
                            preg_match('#^DASH audio [ 0-9]*k , ([a-zA-Z ]*)@([ 0-9]*k) \(([ 0-9]*Hz)\), ([0-9.]*[M]iB)#', $youtubeInfos[$formatCodeId]['note'], $audioMatches);
                            $youtubeAudios[$formatCodeId] = trim($audioMatches[2]) . ' ' . trim($audioMatches[3]) . ' ' . $youtubeInfos[$formatCodeId]['extension'] . '/' . trim($audioMatches[1]) . ' ' . trim($audioMatches[4]);
                        }
                        elseif (substr(trim($youtubeInfos[$formatCodeId]['note']), 0, 11) === 'DASH video ')
                        {
                            preg_match('#^DASH video ([ 0-9]*k) , ([0-9]*)fps, video only, ([0-9.]*[M]iB)#', $youtubeInfos[$formatCodeId]['note'], $videoMatches);
                            dump($videoMatches);
                            $youtubeVideos[$formatCodeId] = $youtubeInfos[$formatCodeId]['resolution'] . ' ' . $videoMatches[1] . ' ' . $videoMatches[2] . 'fps ' . $youtubeInfos[$formatCodeId]['extension'] . ' ' . trim($videoMatches[3]);
                        }
                    }
                    $formDownload = $this->createFormBuilder()
                        ->add('audio', 'choice', array(
                                'choices' => $youtubeAudios,
                        ))
                        ->add('video', 'choice', array(
                                'choices' => $youtubeVideos,
                        ))
                        ->add('save', 'submit')
                        ->getForm();
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
                'formUrl'       => $formUrl->createView(),
        ));
    }
}
