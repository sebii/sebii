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
        $output->writeln('> Scan des tags musicaux');
        $files = FileQuery::create()
            ->filterByType(FilePeer::TYPE_MUSIC)
            ->useMusicFileQuery()
                ->filterByAssociateTags(true)
            ->endUse()
            ->find();
        $output->writeln('    - ' . $files->count() . ' entrées trouvées');
        $tagsList = array();
        
        foreach ($files as $file)
        {
            $output->writeln('    > fichier #' . $file->getMusicFiles()->getFirst()->getId() . '/' . $file->getId());
            $output->writeln('        > Recherche des tags');
            $tagsInfos = array();
            foreach ($file->getMusicFiles()->getFirst()->getMusicOriginalTags() as $originalTag)
            {
                $tagsInfos[$originalTag->getName()][$originalTag->getType()] = $originalTag->getValue();
                $output->writeln('            - ' . $originalTag->getType() . '->' . $originalTag->getName() . ' : ' . $originalTag->getValue());
                if (!isset($tagsList[$originalTag->getType()]))
                {
                    $tagsList[$originalTag->getType()] = array();
                }
                if (!in_array($originalTag->getName(), $tagsList[$originalTag->getType()]))
                {
                    $tagsList[$originalTag->getType()][] = $originalTag->getName();
                }
            }
            
            $output->writeln('        > Récupération des tags');
            /* Récupération de l'artist */
            $artistName = isset($tagsInfos['artist']['id3v2']) ? $tagsInfos['artist']['id3v2'] : '';
            $artistName = (strlen($artistName) == 0 && isset($tagsInfos['artist']['vorbiscomment'])) ? $tagsInfos['artist']['vorbiscomment'] : $artistName;
            $artistName = (strlen($artistName) == 0 && isset($tagsInfos['artist']['lyrics3'])) ? $tagsInfos['artist']['lyrics3'] : $artistName;
            $artistName = (strlen($artistName) == 0 && isset($tagsInfos['artist']['id3v1'])) ? $tagsInfos['artist']['id3v1'] : $artistName;
            $artistName = trim($artistName);
            $output->writeln('            - Artiste : ' . $artistName);
            /* Récupération de l'artiste groupé */
            $bandName = isset($tagsInfos['band']['id3v2']) ? $tagsInfos['band']['id3v2'] : '';
            $bandName = (strlen($bandName) == 0 && isset($tagsInfos['albumartist']['vorbiscomment'])) ? $tagsInfos['albumartist']['vorbiscomment'] : $bandName;
            $bandName = (strlen($bandName) == 0) ? $artistName : $bandName;
            $output->writeln('            - Artiste général : ' . $bandName);
            /* Récupération de l'artist */
            $albumName = isset($tagsInfos['album']['id3v2']) ? $tagsInfos['album']['id3v2'] : '';
            $albumName = (strlen($albumName) == 0 && isset($tagsInfos['album']['vorbiscomment'])) ? $tagsInfos['album']['vorbiscomment'] : $albumName;
            $albumName = (strlen($albumName) == 0 && isset($tagsInfos['album']['id3v1'])) ? $tagsInfos['album']['id3v1'] : $albumName;
            $output->writeln('            - Album : ' . $albumName);
            /* Récupération du titre de piste */
            $trackName = isset($tagsInfos['title']['id3v2']) ? $tagsInfos['title']['id3v2'] : '';
            $trackName = (strlen($trackName) == 0 && isset($tagsInfos['title']['vorbiscomment'])) ? $tagsInfos['title']['vorbiscomment'] : $trackName;
            $trackName = (strlen($trackName) == 0 && isset($tagsInfos['title']['id3v1'])) ? $tagsInfos['title']['id3v1'] : $trackName;
            $output->writeln('            - Piste : ' . $trackName);
            /* Récupération du numéro de piste */
            $trackNumber = isset($tagsInfos['track_number']['id3v2']) ? $tagsInfos['track_number']['id3v2'] : 0;
            $trackNumber = ($trackNumber == 0 && isset($tagsInfos['tracknumber']['id3v1'])) ? $tagsInfos['tracknumber']['id3v1'] : $trackNumber;
            $trackNumber = ($trackNumber == 0 && isset($tagsInfos['track']['id3v1'])) ? $tagsInfos['track']['id3v1'] : $trackNumber;
            $trackNumber = intval($trackNumber);
            $output->writeln('            - Numéro : ' . $trackNumber);
            /* Récupération du numéro du disque */
            $discNumber = 0;
            $discNumber = intval($discNumber);
            $output->writeln('            - Disque : ' . $discNumber);
            
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
//                $output->writeln('            - Artiste général #' . $band->getId() . ' forcé : ' . $band->getName());
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
                $output->writeln('            - Album #' . $album->getId() . ' trouvé : ' . $album->getName());
            }
            
            if (!is_null($artist) && !is_null($album))
            {
                $track = MusicTrackQuery::create()
                    ->filterByMusicArtist($artist)
                    ->filterByMusicAlbum($album)
                    ->filterByName($trackName)
                    ->filterByTrack($trackNumber)
                    ->findOne();
                if (is_null($track))
                {
                    $output->writeln('            - Création de la piste de ' . $album->getName() . ' : ' . $trackName);
                    $track = new MusicTrack();
                    $track
                        ->setMusicArtist($artist)
                        ->setMusicAlbum($album)
                        ->setName($trackName)
                        ->setTrack($trackNumber)
                        ->setDisc($discNumber)
                        ->save();
                }
                $output->writeln('            - Piste #' . $track->getId() . ' trouvé : ' . $track->getName());
            }
            else
            {
                $track = null;
            }
            
            $musicFile = $file->getMusicFiles()->getFirst();
            $musicFile
                ->setMusicTrack($track)
                ->save();
            $output->writeln('            - Liage de la piste au fichier musique');
            
//            break;
        }
        
        ksort($tagsInfos);
        foreach ($tagsList as $key => $values)
        {
            $output->writeln('');
            $output->writeln('  Liste : ' . $key);
            sort($values);
            $output->writeln('        ' . implode(', ', $values));
        }
    }
}