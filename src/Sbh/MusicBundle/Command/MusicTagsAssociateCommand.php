<?php

namespace Sbh\MusicBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Sbh\StartBundle\Model\FilePeer;
use Sbh\StartBundle\Model\FileQuery;
use Sbh\MusicBundle\Model\MusicArtist;
use Sbh\MusicBundle\Model\MusicArtistQuery;
use Sbh\MusicBundle\Model\MusicAlbum;
use Sbh\MusicBundle\Model\MusicAlbumQuery;
use Sbh\MusicBundle\Model\MusicTrack;
use Sbh\MusicBundle\Model\MusicTrackQuery;

/**
 * 
 * @version 1.0.0
 * @author Sébastien "sebii" Bloino <sebii@sebiiheckel.fr>
 */
class MusicTagsAssociateCommand extends ContainerAwareCommand
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
            ->setName('sbh:music:associate:tags')
            ->setDescription('Associate tags of music files');
    }
    
    /**
     * récupération de l'iiPath
     * 
     * Récupère l'adresse du dossier ii et le génère si non trouvé
     * @since 1.0.0 Création -- sebii
     * @access protected
     * @return string
     */
    protected function getIiPath()
    {
        $fs      = new FileSystem();
        $webPath = realpath($this->getContainer()->get('kernel')->getRootDir() .
                            DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .
                            'web');
        $iiPath  = $webPath . DIRECTORY_SEPARATOR . 'ii';
        if (!$fs->exists($iiPath))
        {
            $fs->mkdir($iiPath, 0777);
        }
        return realpath($iiPath);
    }
    
    /**
     * récupération du musicPath
     * 
     * Récupère l'adresse du dossier music et le génère si non trouvé
     * @since 1.0.0 Création -- sebii
     * @access protected
     * @return string
     */
    protected function getMusicPath()
    {
        $fs        = new FileSystem();
        $musicPath = $this->getIiPath() . DIRECTORY_SEPARATOR . 'music';
        if (!$fs->exists($musicPath))
        {
            $fs->mkdir($musicPath, 0777);
        }
        return realpath($musicPath);
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
        $musicPath = $this->getMusicPath();
        
        $output->writeln('> Scan des tags musicaux');
        $files = FileQuery::create()
            ->filterByType(FilePeer::TYPE_MUSIC)
            ->useMusicFileQuery()
                ->filterByAssociateTags(true)
            ->endUse()
            ->find();
        $output->writeln('    - ' . $files->count() . ' entrées trouvées');
        
        foreach ($files as $file)
        {
            $output->writeln('    > fichier #' . $file->getMusicFiles()->getFirst()->getId() . '/' . $file->getId());
            $output->writeln('        > Recherche des tags');
            $tagsInfos = array();
            foreach ($file->getMusicFiles()->getFirst()->getMusicOriginalTags() as $originalTag)
            {
                $tagsInfos[$originalTag->getName()][$originalTag->getType()] = $originalTag->getValue();
                $output->writeln('            - ' . $originalTag->getType() . '->' . $originalTag->getName() . ' : ' . $originalTag->getValue());
            }
            
            $output->writeln('        > Récupération des tags');
//            var_dump($tagsInfos);
            /* Récupération de l'artist */
            $artistName = isset($tagsInfos['artist']['id3v2']) ? trim($tagsInfos['artist']['id3v2']) : '';
            $artistName = (strlen($artistName) == 0 && isset($tagsInfos['artist']['id3v1'])) ? trim($tagsInfos['artist']['id3v1']) : $artistName;
            $output->writeln('            - Artiste : ' . $artistName);
            /* Récupération de l'artiste groupé */
            $bandName = isset($tagsInfos['band']['id3v2']) ? trim($tagsInfos['band']['id3v2']) : '';
            $output->writeln('            - Artiste général : ' . $bandName);
            /* Récupération de l'album */
            $albumName = isset($tagsInfos['album']['id3v2']) ? trim($tagsInfos['album']['id3v2']) : '';
            $albumName = (strlen($albumName) == 0 && isset($tagsInfos['album']['id3v1'])) ? trim($tagsInfos['album']['id3v1']) : $albumName;
            $output->writeln('            - Album : ' . $albumName);
            /* Récupération du nom de piste */
            $trackName = isset($tagsInfos['title']['id3v2']) ? trim($tagsInfos['title']['id3v2']) : '';
            $trackName = (strlen($trackName) == 0 && isset($tagsInfos['artist']['id3v1'])) ? trim($tagsInfos['artist']['id3v1']) : $trackName;
            $output->writeln('            - Titre : ' . $trackName);
            /* Récupération de la piste */
            $trackNumber = isset($tagsInfos['track_number']['id3v2']) ? intval(trim($tagsInfos['track_number']['id3v2'])) : 0;
            $trackNumber = ($trackNumber == 0 && isset($tagsInfos['track']['id3v1'])) ? intval(trim($tagsInfos['track']['id3v1'])) : $trackNumber;
            $output->writeln('            - Numéro de piste : ' . $trackNumber);
            
            $output->writeln('        > Traitement des tags');
            $artist = null;
            if (strlen($artistName) > 0)
            {
                $artist = MusicArtistQuery::create()
                    ->filterByName($artistName)
                    ->findOne();
                if (is_null($artist))
                {
                    $output->writeln('            - Création de l\'artiste : ' . $artistName);
                    $artist = new MusicArtist();
                    $artist
                        ->setName($artistName)
                        ->setAlias(null)
                        ->save();
                }
                $output->writeln('            - Artiste #' . $artist->getId() . ' trouvé : ' . $artist->getName());
            }
            
            $band = null;
            if (strlen($bandName) > 0)
            {
                $band = MusicArtistQuery::create()
                    ->filterByName($bandName)
                    ->findOne();
                if (is_null($band))
                {
                    $output->writeln('            - Création de l\'artiste : ' . $bandName);
                    $band = new MusicArtist();
                    $band
                        ->setName($bandName)
                        ->setAlias(null)
                        ->save();
                }
                $output->writeln('            - Artiste général #' . $band->getId() . ' trouvé : ' . $band->getName());
            }
            elseif (!is_null($artist))
            {
                $band = $artist;
                $output->writeln('            - Artiste général #' . $band->getId() . ' forcé : ' . $band->getName());
            }
            
            $album = null;
            if (!is_null($band) && strlen($albumName) > 0)
            {
                $album = MusicAlbumQuery::create()
                    ->filterByName($albumName)
                    ->filterByMusicArtist($band)
                    ->findOne();
                if (is_null($album))
                {
                    $output->writeln('            - Création de l\'album de ' . $band->getName() . ' : ' . $albumName);
                    $album = new MusicAlbum();
                    $album
                        ->setMusicArtist($band)
                        ->setName($albumName)
                        ->save();
                }
                $output->writeln('            - Album #' . $band->getId() . ' trouvé : ' . $band->getName());
            }
            
            $track = null;
            if (!is_null($artist) && !is_null($album) && strlen($trackName) > 0)
            {
                $track = MusicTrackQuery::create()
                    ->filterByName($trackName)
                    ->filterByMusicAlbum($album)
                    ->filterByMusicArtist($artist)
                    ->findOne();
                if (is_null($track))
                {
                    $output->writeln('            - Création de la piste de ' . $album->getName() . ' : ' . $trackName);
                    $track = new MusicTrack();
                    $track
                        ->setName($trackName)
                        ->setMusicArtist($artist)
                        ->setMusicAlbum($album)
                        ->save();
                }
                $track
                    ->setTrack($trackNumber)
                    ->save();
                $output->writeln('            - Piste #' . $track->getId() . ' trouvé : ' . $track->getName());
            }
            
            if (!is_null($track))
            {
                $file->getMusicFiles()->getFirst()
                    ->setMusicTrack($track)
//                    ->setAssociateTags(false)
                    ->save();
                $output->writeln('            - Piste #' . $track->getId() . ' associée au fichier musical #' . $file->getMusicFiles()->getFirst()->getId() . '/' . $file->getId());
            }
//            unset(  $tagsInfos['filesize'],
//                    $tagsInfos['fileformat'],
//                    $tagsInfos['channels'],
//                    $tagsInfos['sampleRate'],
//                    $tagsInfos['bitrate'],
//                    $tagsInfos['channelMode'],
//                    $tagsInfos['bitrateMode'],
//                    $tagsInfos['lossless'],
//                    $tagsInfos['encoderOptions'],
//                    $tagsInfos['compressionRatio'],
//                    $tagsInfos['encoding'],
//                    $tagsInfos['mime_type'],
//                    $tagsInfos['playtime_seconds'],
//                    $tagsInfos['artist']['id3v2'], $tagsInfos['artist']['id3v1'],
//                    $tagsInfos['album']['id3v2'], $tagsInfos['album']['id3v1']
//                 );
//            print_r($tagsInfos);
//            var_dump($artistName, $bandName, $albumName);
//            exit();
        }
    }
}