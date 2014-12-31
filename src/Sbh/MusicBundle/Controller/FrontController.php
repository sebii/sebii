<?php

namespace Sbh\MusicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sbh\MusicBundle\Model\MusicArtist;
use Sbh\MusicBundle\Model\MusicArtistQuery;
use Sbh\MusicBundle\Model\MusicAlbum;
use Sbh\MusicBundle\Model\MusicAlbumQuery;
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
            ->useMusicAlbumQuery()
                ->filterByArtistId(null, Criteria::NOT_EQUAL)
            ->endUse()
            ->orderByName(Criteria::ASC)
            ->groupById()
            ->find();
        
        return $this->render('SbhMusicBundle:Front:artists.html.twig', array(
                'artists' => $artists,
        ));
    }
    
    /**
     * 
     * @Route("/{_lang}/music/artist/{artistId}", name="sbh_music_front_artist", requirements={"_lang"="\w{2}", "artistId"="\d+"}, defaults={"_lang"="fr"})
     * @ParamConverter("artist", class="Sbh\MusicBundle\Model\MusicArtist", options={"mapping": {"artistId": "id"}})
     */
    public function artistAction(MusicArtist $artist)
    {
        $albums = MusicAlbumQuery::create()
            ->filterByMusicArtist($artist)
            ->orderByName(Criteria::ASC)
            ->find();
        
        return $this->render('SbhMusicBundle:Front:artist.html.twig', array(
                'artist' => $artist,
                'albums' => $albums,
        ));
    }
}
