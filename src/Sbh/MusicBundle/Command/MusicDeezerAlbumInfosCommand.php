<?php

namespace Sbh\MusicBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use \Criteria;
use \Exception;
use Sbh\MusicBundle\Model\MusicAlbumQuery;
use Sbh\MusicBundle\Model\MusicDeezerArtist;
use Sbh\MusicBundle\Model\MusicDeezerArtistQuery;
use Sbh\MusicBundle\Model\MusicDeezerAlbumQuery;
use Sbh\MusicBundle\Model\MusicDeezerGenre;
use Sbh\MusicBundle\Model\MusicDeezerGenreQuery;
use Sbh\MusicBundle\Model\MusicDeezerTrack;
use Sbh\MusicBundle\Model\MusicDeezerTrackQuery;

/**
 * 
 * @version 1.0.0
 * @author Sébastien "sebii" Bloino <sebii@sebiiheckel.fr>
 */
class MusicDeezerAlbumInfosCommand extends ContainerAwareCommand
{
    /**
     * configuration
     * 
     * Configuration, nécessaire pour l'app/console de Symfony2
     * @since 1.0.0 Création -- sebii
     * @access protected
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('sbh:music:deezer:album:infos')
            ->setDescription('complete infos of album via deezer');
    }
    
    /**
     * Execution
     * 
     * Execution de la commande
     * @since 1.0.0 Création -- sebii
     * @access protected
     * @param Symfony\Component\Console\Input\InputInterface $input
     * @param Symfony\Component\Console\Output\OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('> Recherche de 5 albums non scannés chez Deezer');
        $musicAlbums = MusicAlbumQuery::create()
            ->filterByScanDeezerAlbum(true)
            ->useMusicDeezerAlbumQuery()
                ->filterByAlbumId(null, Criteria::NOT_EQUAL)
            ->endUse()
            ->groupById()
            ->limit(5)
            ->find();
        $output->writeln('    - ' . $musicAlbums->count() . ' albums trouvés');
        foreach ($musicAlbums as $musicAlbum)
        {
            $output->writeln('    - Album "' . $musicAlbum->getName() . '" de ' . $musicAlbum->getMusicArtist()->getName());
            $deezerUrl  = 'http://api.deezer.com/album/' . $musicAlbum->getMusicDeezerAlbums()->getFirst()->getDeezerId();
            $output->writeln('        > Ouverture de l\'url : ' . $deezerUrl);
            $deezerJson = file_get_contents($deezerUrl);
            $deezerData = json_decode($deezerJson);
            $output->writeln('        - Récupération des informations');
            $deezerAlbum = MusicDeezerAlbumQuery::create()
                ->filterByDeezerId($deezerData->id)
                ->findOne();
            $deezerGenres = array();
            foreach ($deezerData->genres->data as $deezerDataGenre)
            {
                $deezerGenres[] = $deezerDataGenre->id;
                $deezerGenre = MusicDeezerGenreQuery::create()
                    ->filterByDeezerId($deezerDataGenre->id)
                    ->findOne();
                if (is_null($deezerGenre))
                {
                    $output->writeln('        > Création du genre Deezer "' . $deezerDataGenre->name . '"');
                    $deezerGenre = new MusicDeezerGenre();
                    $deezerGenre
                        ->setDeezerId($deezerDataGenre->id)
                        ->save();
                }
            }
            $deezerArtist = MusicDeezerArtistQuery::create()
                ->filterByDeezerId($deezerData->artist->id)
                ->findOne();
            $deezerAlbum
                ->setName($deezerData->title)
                ->setUpc($deezerData->upc)
                ->setMainGenreDeezerId($deezerData->genre_id)
                ->setGenreDeezerIds($deezerGenres)
                ->setLabel($deezerData->label)
                ->setNbTracks($deezerData->nb_tracks)
                ->setDuration($deezerData->duration)
                ->setNbFans($deezerData->fans)
                ->setRating($deezerData->rating)
                ->setRecordType($deezerData->record_type)
                ->setAvailable($deezerData->available)
                ->setExplicitLyrics($deezerData->explicit_lyrics)
                ->setMusicDeezerArtist($deezerArtist)
                ->save();
            $output->writeln('        > Album deezer mis à jour');
            $output->writeln('        - Traitement des pistes');
            foreach ($deezerData->tracks->data as $deezerDataTrack)
            {
                $output->writeln('            - Piste Deezer "' . $deezerDataTrack->title . '"');
                $output->writeln('                > Recherche dans la base de données de la piste');
                $deezerTrack = MusicDeezerTrackQuery::create()
                    ->filterByDeezerId($deezerDataTrack->id)
                    ->findOne();
                if (is_null($deezerTrack))
                {
                    $output->writeln('                > Création de la piste Deezer "' . $deezerDataTrack->title . '"');
                    $deezerTrack = new MusicDeezerTrack();
                    $deezerTrack
                        ->setDeezerId($deezerDataTrack->id)
                        ->save();
                }
                $output->writeln('                > Recherche de l\'artiste Deezer "' . $deezerDataTrack->artist->name . '"');
                $deezerTrackArtist = MusicDeezerArtistQuery::create()
                    ->filterByDeezerId($deezerDataTrack->artist->id)
                    ->findOne();
                if (is_null($deezerTrackArtist))
                {
                    $output->writeln('                > Création de l\'artiste Deezer "' . $deezerDataTrack->artist->name . '"');
                    $deezerArtist = new MusicDeezerArtist();
                    $deezerArtist
                        ->setDeezerId($deezerDataTrack->artist->id)
                        ->setName($deezerDataTrack->artist->name)
                        ->save();
                }
                $deezerTrack
                    ->setName($deezerDataTrack->title)
                    ->setReadable($deezerDataTrack->readable)
                    ->setDuration($deezerDataTrack->duration)
                    ->setRank($deezerDataTrack->rank)
                    ->setExplicitLyrics($deezerDataTrack->explicit_lyrics)
                    ->setPreviewLink($deezerDataTrack->preview)
                    ->setMusicDeezerAlbum($deezerAlbum)
                    ->setMusicDeezerArtist($deezerTrackArtist)
                    ->save();
                $output->writeln('                > Sauvegarde des données de la piste');
            }
            $musicAlbum
                ->setScanDeezerAlbum(false)
                ->save();
            $output->writeln('        > Signalé comme scanné');
        }
    }
}