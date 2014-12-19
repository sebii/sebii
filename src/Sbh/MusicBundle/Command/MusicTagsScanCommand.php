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
            ->limit(5)
            ->find();
        $output->writeln('    - ' . $musicFiles->count() . ' entrées trouvées');
        foreach ($musicFiles as $musicFile)
        {
            $musicPath = $musicPath . DIRECTORY_SEPARATOR . $musicFile->getFile()->getPath();
            $getId3    = new getID3();
            $output->writeln('    > fichier #' . $musicFile->getId() . '/' . $musicFile->getFileId());
            $output->writeln('        - open file ' . $musicPath);
            $getId3->analyze($musicPath);
            $id3Infos  = $getId3->info;
            foreach ($id3Infos as $infoKey => $infoValue)
            {
                switch ($infoKey)
                {
                    case 'GETID3_VERSION':
                        $output->writeln('        - clé info ignorée : ' . $infoKey);
                        break;
                    default:
                        $output->writeln('        - clé info inconnue : ' . $infoKey . ' - type valeur : ' . gettype($infoValue) . ' - valeur : ' . ((gettype($infoValue) == 'array') ? 'array' : $infoValue));
                        exit();
                }
            }
        }
    }
}