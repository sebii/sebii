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
use Sbh\MusicBundle\Model\MusicFile;
use Sbh\MusicBundle\Model\MusicFileQuery;
use Sbh\MusicBundle\Model\MusicOriginalTag;
use Sbh\MusicBundle\Model\MusicOriginalTagQuery;
use \Criteria;
use \getID3;

/**
 * 
 * @version 1.0.0
 * @author Sébastien "sebii" Bloino <sebii@sebiiheckel.fr>
 */
class MusicTagsScanCommand extends ContainerAwareCommand
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
            ->setName('sbh:music:scan:tags')
            ->setDescription('Scan tags of music files');
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
     * scanner les fichiers sans currentPath
     * 
     * scanner les fichiers sans currentPath
     * @since 1.0.0 Création -- sebii
     * @access protected
     * @param Symfony\Component\Console\Input\InputInterface $input
     * @param Symfony\Component\Console\Output\OutputInterface $output
     * @return void
     */
    protected function scanFilesWithoutCurrentPath(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('> Scan de la base de données pour trouver les fichiers currentPath');
        $files = FileQuery::create()
            ->filterByPath(null)
            ->filterByType(FilePeer::TYPE_MUSIC)
            ->orderById(Criteria::ASC)
            ->find();
        $output->writeln('    - ' . $files->count() . ' entrées trouvées');
        foreach ($files as $file)
        {
            $output->writeln('    > fichier #' . $file->getId());
            $output->writeln('        - original path : ' . $file->getOriginalPath());
            $output->writeln('        - current path  : ' . $file->getId() . '.' . $file->getExt());
            $file
                ->setPath($file->getId() . '.' . $file->getExt())
                ->save();
        }
    }
    
    /**
     * scanner les fichiers sans musicFile
     * 
     * scanner les fichiers sans musicFile
     * @since 1.0.0 Création -- sebii
     * @access protected
     * @param Symfony\Component\Console\Input\InputInterface $input
     * @param Symfony\Component\Console\Output\OutputInterface $output
     * @return void
     */
    protected function scanFilesWithoutMusicFile(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('> Scan de la base de données pour trouver les fichiers non associés à la table music_file');
        $files = FileQuery::create()
            ->filterByType(FilePeer::TYPE_MUSIC)
            ->useMusicFileQuery()
                ->filterByFileId(null)
            ->endUse()
            ->orderById(Criteria::ASC)
            ->find();
        $output->writeln('    - ' . $files->count() . ' entrées trouvées');
        foreach ($files as $file)
        {
            $output->writeln('    > fichier #' . $file->getId());
            $output->writeln('        - original path : ' . $file->getOriginalPath());
            $musicFile = new MusicFile();
            $musicFile
                ->setFile($file)
                ->save();
        }
    }
    
    protected function addOriginalTag($musicFileId, $tagType, $tagName, $tagContent)
    {
        $originalTag = MusicOriginalTagQuery::create()
            ->filterByMusicFileId($musicFileId)
            ->filterByType($tagType)
            ->filterByName($tagName)
            ->filterByValue($tagContent)
            ->findOne();
        if (is_null($originalTag))
        {
            $originalTag = new MusicOriginalTag();
            $originalTag
                ->setMusicFileId($musicFileId)
                ->setType($tagType)
                ->setName($tagName)
                ->setValue($tagContent)
                ->save();
        }
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
        
        $this->scanFilesWithoutCurrentPath($input, $output);
        $this->scanFilesWithoutMusicFile($input, $output);
        
        $output->writeln('> Scan des tags musicaux');
        $musicFiles = MusicFileQuery::create()
            ->filterByScanOriginalTag(true)
            ->orderByUpdatedAt(Criteria::ASC)
//            ->limit(1000)
            ->find();
        $output->writeln('    - ' . $musicFiles->count() . ' entrées trouvées');
        foreach ($musicFiles as $musicFile)
        {
            $musicFullPath = $musicPath . DIRECTORY_SEPARATOR . $musicFile->getFile()->getPath();
            $getId3        = new getID3();
            $output->writeln('    > fichier #' . $musicFile->getId() . '/' . $musicFile->getFileId());
            $output->writeln('        - open file ' . $musicFullPath);
            $getId3->analyze($musicFullPath);
            $id3Infos      = $getId3->info;
            foreach ($id3Infos as $infoKey => $infoValue)
            {
                switch ($infoKey)
                {
                    case 'audio':
                        $output->writeln('        - scan de la clé info : ' . $infoKey);
                        foreach ($infoValue as $audioKey => $audioValue)
                        {
                            switch ($audioKey)
                            {
                                case 'bitrate':
                                case 'channels':
                                case 'codec':
                                case 'encoder':
                                case 'lossless':
                                    $output->writeln('            - clé audio ajoutée : ' . $audioKey . ' [' . $audioValue . ']');
                                    $this->addOriginalTag($musicFile->getId(), 'audio', $audioKey, $audioValue);
                                    break;
                                case 'bitrate_mode':
                                    $output->writeln('            - clé audio ajoutée : bitrateMode [' . $audioValue . ']');
                                    $this->addOriginalTag($musicFile->getId(), 'audio', 'bitrateMode', $audioValue);
                                    break;
                                case 'channelmode':
                                    $output->writeln('            - clé audio ajoutée : channelMode [' . $audioValue . ']');
                                    $this->addOriginalTag($musicFile->getId(), 'audio', 'channelMode', $audioValue);
                                    break;
                                case 'compression_ratio':
                                    $output->writeln('            - clé audio ajoutée : compressionRatio [' . $audioValue . ']');
                                    $this->addOriginalTag($musicFile->getId(), 'audio', 'compressionRatio', $audioValue);
                                    break;
                                case 'encoder_options':
                                    $output->writeln('            - clé audio ajoutée : encoderOptions [' . $audioValue . ']');
                                    $this->addOriginalTag($musicFile->getId(), 'audio', 'encoderOptions', $audioValue);
                                    break;
                                case 'sample_rate':
                                    $output->writeln('            - clé audio ajoutée : sampleRate [' . $audioValue . ']');
                                    $this->addOriginalTag($musicFile->getId(), 'audio', 'sampleRate', $audioValue);
                                    break;
                                case 'bits_per_sample':
                                case 'dataformat':
                                case 'streams':
                                    $output->writeln('            - clé audio ignorée : ' . $audioKey);
                                    break;
                                default:
                                    $output->writeln('            - clé audio inconnue : ' . $audioKey . ' - type valeur : ' . gettype($audioValue) . ' - valeur : ' . ((gettype($audioValue) == 'array') ? implode(', ', array_keys($audioValue)) : $audioValue));
                                    exit();
                            }
                        }
                        break;
                    case 'tags':
                        $output->writeln('        - scan de la clé info : ' . $infoKey);
                        foreach ($infoValue as $tagGroupKey => $tagGroupValue)
                        {
                            switch ($tagGroupKey)
                            {
                                case 'id3v1':
                                case 'id3v2':
                                case 'lyrics3':
                                case 'vorbiscomment':
                                    $output->writeln('            - scan de la clé tag group : ' . $tagGroupKey);
                                    foreach ($tagGroupValue as $tagKey => $tagValue)
                                    {
                                        $output->writeln('                - clé tag ' . $tagGroupKey . ' ajoutée : ' . $tagKey . ' - valeur : ' . $tagValue[0] . ' - encodage : ' . mb_detect_encoding($tagValue[0]));
                                        $this->addOriginalTag($musicFile->getId(), $tagGroupKey, $tagKey, $tagValue[0]);
                                    }                                    
                                    break;
                                default:
                                    $output->writeln('            - clé tag group inconnue : ' . $tagGroupKey . ' - type valeur : ' . gettype($tagGroupValue) . ' - valeur : ' . ((gettype($tagGroupValue) == 'array') ? implode(', ', array_keys($tagGroupValue)) : $tagGroupValue));
                                    exit();
                            }
                        }
                        break;
                    case 'fileformat':
                    case 'filesize':
                    case 'encoding':
                    case 'mime_type':
                    case 'playtime_seconds':
                        $output->writeln('        - clé info ajoutée : ' . $infoKey . ' [' . $infoValue . ']');
                        $this->addOriginalTag($musicFile->getId(), 'info', $infoKey, $infoValue);
                        break;
                    case 'ape':
                    case 'avdataend':
                    case 'avdataoffset':
                    case 'bitrate':
                    case 'comments': /* Contient les couvertures, à retravailler plus tard */
                    case 'error':
                    case 'filename':
                    case 'filenamepath':
                    case 'filepath':
                    case 'flac':
                    case 'GETID3_VERSION':
                    case 'id3v1':
                    case 'id3v2':
                    case 'lyrics3':
                    case 'md5_data_source':
                    case 'mpeg':
                    case 'ogg':
                    case 'playtime_string':
                    case 'replay_gain':
                    case 'tags_html':
                    case 'vorbiscomment':
                    case 'warning':
                        $output->writeln('        - clé info ignorée : ' . $infoKey);
                        break;
                    default:
                        $output->writeln('        - clé info inconnue : ' . $infoKey . ' - type valeur : ' . gettype($infoValue) . ' - valeur : ' . ((gettype($infoValue) == 'array') ? implode(', ', array_keys($infoValue)) : $infoValue));
                        exit();
                }
            }
            $musicFile
                ->setScanOriginalTag(false)
                ->save();
        }
    }
}