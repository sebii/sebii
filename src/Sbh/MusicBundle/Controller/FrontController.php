<?php

namespace Sbh\MusicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sbh\MusicBundle\Model\MusicArtistQuery;
use \Criteria;

class FrontController extends Controller
{
    /**
     * 
     * @Route("/{_lang}/music/artists/{page}", name="sbh_music_front_artists", requirements={"_lang"="\w{2}", "page"="\d+"}, defaults={"_lang"="fr", "page"="1"})
     */
    public function artistsAction($page)
    {
        $artists = MusicArtistQuery::create()
            ->filterByAlias(null)
            ->orderByName(Criteria::ASC)
            ->find();
        
        return $this->render('SbhMusicBundle:Front:artists.html.twig', array(
                'artists' => $artists,
        ));
    }
}
