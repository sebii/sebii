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
            /* Récupération de l'artist */
            $artistName = isset($tagsInfos['artist']['id3v2']) ? $tagsInfos['artist']['id3v2'] : '';
            $artistName = (strlen($artistName) == 0 && isset($tagsInfos['artist']['id3v1'])) ? $tagsInfos['artist']['id3v1'] : $artistName;
            $artistName = trim($artistName);
            $output->writeln('            - Artiste : ' . $artistName);
            /* Récupération de l'artiste groupé */
            $bandName = isset($tagsInfos['band']['id3v2']) ? $tagsInfos['band']['id3v2'] : '';
            $output->writeln('            - Artiste général : ' . $bandName);
            /* Récupération de l'artist */
            $albumName = isset($tagsInfos['album']['id3v2']) ? $tagsInfos['album']['id3v2'] : '';
            $albumName = (strlen($albumName) == 0 && isset($tagsInfos['album']['id3v1'])) ? $tagsInfos['album']['id3v1'] : $albumName;
            $output->writeln('            - Album : ' . $albumName);
            
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
            else
            {
                $band = $artist;
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