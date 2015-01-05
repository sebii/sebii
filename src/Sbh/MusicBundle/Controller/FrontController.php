<?php

namespace Sbh\MusicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sbh\MusicBundle\Model\MusicArtist;
use Sbh\MusicBundle\Model\MusicArtistQuery;
use Sbh\MusicBundle\Model\MusicAlbum;
use Sbh\MusicBundle\Model\MusicAlbumQuery;
use Sbh\MusicBundle\Model\MusicTrackQuery;
use Sbh\MusicBundle\Model\MusicDeezerAlbumQuery;
use Imagine\Imagick\Imagine;
use \Criteria;

/**
 * 
 * @version 1.0.0
 * @author Sébastien "sebii" Bloino <sebii@sebiiheckel.fr>
 */
class FrontController extends Controller
{
    /**
     * 
     * @since 1.0.0 Création -- sebii
     * @access public
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
     * @since 1.0.0 Création -- sebii
     * @access public
     * @param Sbh\MusicBundle\Model\MusicArtist $artist
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
    
    /**
     * 
     * @since 1.0.0 Création -- sebii
     * @access public
     * @param Sbh\MusicBundle\Model\MusicArtist $artist
     * @param Sbh\MusicBundle\Model\MusicAlbum $album
     * @Route("/{_lang}/music/album/{artistId}/{albumId}", name="sbh_music_front_album", requirements={"_lang"="\w{2}", "artistId"="\d+", "albumId"="\d+"}, defaults={"_lang"="fr"})
     * @ParamConverter("artist", class="Sbh\MusicBundle\Model\MusicArtist", options={"mapping": {"artistId": "id"}})
     * @ParamConverter("album", class="Sbh\MusicBundle\Model\MusicAlbum", options={"mapping": {"albumId": "id"}})
     */
    public function albumAction(MusicArtist $artist, MusicAlbum $album)
    {
        $tracks = MusicTrackQuery::create()
            ->filterByMusicAlbum($album)
            ->orderByDisc(Criteria::ASC)
            ->orderByTrack(Criteria::ASC)
            ->find();
        
        return $this->render('SbhMusicBundle:Front:album.html.twig', array(
                'artist' => $artist,
                'album'  => $album,
                'tracks' => $tracks,
        ));
    }
    
    /**
     * 
     * @since 1.0.0 Création -- sebii
     * @access public
     * @param Sbh\MusicBundle\Model\MusicArtist $artist
     * @param Sbh\MusicBundle\Model\MusicAlbum $album
     * @Route("/{_lang}/music/album/{artistId}/{albumId}/deezerLink/{deezerId}", name="sbh_music_front_album_deezer_link", requirements={"_lang"="\w{2}", "artistId"="\d+", "albumId"="\d+", "deezerId"="\d+"}, defaults={"_lang"="fr", "deezerId"="0"})
     * @ParamConverter("artist", class="Sbh\MusicBundle\Model\MusicArtist", options={"mapping": {"artistId": "id"}})
     * @ParamConverter("album", class="Sbh\MusicBundle\Model\MusicAlbum", options={"mapping": {"albumId": "id"}})
     */
    public function albumDeezerLinkAction(MusicArtist $artist, MusicAlbum $album, $deezerId)
    {
        $deezerAlbums = MusicDeezerAlbumQuery::create()
            ->orderByName()
            ->useMusicDeezerArtistQuery()
                ->filterByMusicArtist($artist)
            ->endUse()
            ->find();
        
        if ($deezerId != 0)
        {
            foreach ($deezerAlbums as $deezerAlbum)
            {
                if ($deezerId == $deezerAlbum->getDeezerId())
                {
                    $deezerAlbum
                        ->setMusicAlbum($album)
                        ->save();
//                    
//                    $imgPath       = $this->get('kernel')->getRootDir() .
//                                     DIRECTORY_SEPARATOR . '..' .
//                                     DIRECTORY_SEPARATOR . 'web' .
//                                     DIRECTORY_SEPARATOR . 'ii' .
//                                     DIRECTORY_SEPARATOR . 'music' .
//                                     DIRECTORY_SEPARATOR . '_img';
//                    $deezerImgName = 'deezer_album_' . $deezerAlbum->getDeezerId() . '.jpg';
//                    $albumImgName  = 'album_' . $album->getId() . '.jpg';
//                    $albumThmName  = 'album_' . $album->getId() . '_thumb.jpg';
//                    $imagine       = new Imagine();
//                    $imagine
//                        ->open($imgPath . DIRECTORY_SEPARATOR . $deezerImgName)
//                        ->save($imgPath . DIRECTORY_SEPARATOR . $albumImgName, array('jpeg_quality' => 100));
//                    $imagine
//                        ->open($imgPath . DIRECTORY_SEPARATOR . $deezerImgName)
//                        ->resize(new Box(300, 300))
//                        ->save($imgPath . DIRECTORY_SEPARATOR . $albumThmName, array('jpeg_quality' => 100));
                    return $this->redirect($this->generateUrl('sbh_music_front_album', array('albumId' => $album->getId(), 'artistId' => $artist->getId())));
                }
            }
        }
        
        return $this->render('SbhMusicBundle:Front:albumDeezerLink.html.twig', array(
                'artist'       => $artist,
                'album'        => $album,
                'deezerAlbums' => $deezerAlbums,
        ));
    }
}
