<?php

namespace Sbh\MusicBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File as sFile;
use Sbh\StartBundle\Model\File;
use Sbh\StartBundle\Model\FilePeer;

/**
 * 
 * @version 1.0.0
 * @author Sébastien "sebii" Bloino <sebii@sebiiheckel.fr>
 */
class MusicDirNewScanCommand extends ContainerAwareCommand
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
            ->setName('sbh:music:scan:dir')
            ->setDescription('Scan new musics in web/ii/scan_music')
            ->addArgument('limit', InputArgument::OPTIONAL, 0);
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
     * récupération du scanPath
     * 
     * Récupère l'adresse du dossier scan_music et le génère si non trouvé
     * @since 1.0.0 Création -- sebii
     * @access protected
     * @return string
     */
    protected function getScanPath()
    {
        $fs       = new FileSystem();
        $scanPath = $this->getIiPath() . DIRECTORY_SEPARATOR . 'scan_music';
        if (!$fs->exists($scanPath))
        {
            $fs->mkdir($scanPath, 0777);
        }
        return realpath($scanPath);
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
        $limit = intval($input->getArgument('limit'));
        $scanPath  = $this->getScanPath();
        $musicPath = $this->getMusicPath();
        
        $output->writeln('> Démarrage du scan [' . $musicPath . ']');
        $finder = new Finder();
        $finder
            ->files()
            ->name('*.mp3')
            ->name('*.ogg')
            ->name('*.aac')
            ->name('*.flac')
            ->date('until 10 minutes')
            ->in($scanPath);
        $output->writeln('    - le scan a trouvé ' . $finder->count() . ' fichiers musicaux');
        $count = 0;
        foreach ($finder as $finderFile)
        {
            $count++;
            if ($limit != 0 && ($limit + 1 - $count) == 0)
            {
                break;
            }
            $output->writeln('    > Fichier #' . $count . ' [' . $finderFile->getRelativePathname() . ']');
            $originalRealPath     = $finderFile->getRealpath();
            $explodeExtension     = explode('.', $originalRealPath);
            $sFile                = new sFile($originalRealPath);
            $originalRelativePath = $finderFile->getRelativePathname();
            $originalExtension    = strtolower($explodeExtension[count($explodeExtension) - 1]);
            $guessExtension       = strtolower($sFile->guessExtension());
            $type                 = FilePeer::TYPE_MUSIC;
            $file                 = new File();
            if (!in_array($guessExtension, array(FilePeer::EXT_BIN, FilePeer::EXT_MP3, FilePeer::EXT_OGG, FilePeer::EXT_AAC, FilePeer::EXT_FLAC, FilePeer::EXT_MPGA, FilePeer::EXT_WAV)))
            {
                $output->writeln('    - Extension devinée inconue : ' . $guessExtension);
                exit();
            }
            $output->writeln('        - path               : ' . $originalRelativePath);
            $output->writeln('        - original extension : ' . $originalExtension);
            $output->writeln('        - guess extension    : ' . $guessExtension);
            $file
                ->setType($type)
                ->setOriginalPath($originalRelativePath)
                ->setOriginalExt($originalExtension)
                ->setGuessExt($guessExtension)
                ->setExt($originalExtension)
                ->save();
            $sFile->move($musicPath, $file->getId() . '.' . $originalExtension);
            $output->writeln('        - Le fichier a été renommé : ' . $file->getId() . '.' . $originalExtension);
        }
    }
    
    
    
//    protected function execute(InputInterface $input, OutputInterface $output)
//    {
//        foreach ($finder as $foundFile)
//        {
//            $count++;
//            $output->writeln('    > File #' . $count);
//            $originalRealPath     = $foundFile->getRealpath();
//            $explodeExtension     = explode('.', $originalRealPath);
//            $sFile                = new File($originalRealPath);
//            $originalRelativePath = $foundFile->getRelativePathname();
//            $originalExtension    = strtolower($explodeExtension[count($explodeExtension) - 1]);
//            $guessExtension       = strtolower($sFile->guessExtension());
//            $type                 = FilePeer::TYPE_MUSIC;
//            $iiFile               = new iiFile();
//            switch ($originalExtension)
//            {
//                case 'aac':
//                    $originalFileExtPeer = FilePeer::ORIGINAL_EXTENSION_AAC;
//                    $fileExtPeer         = FilePeer::EXTENSION_ACC;
//                    break;
//                case 'mp3':
//                    $originalFileExtPeer = FilePeer::ORIGINAL_EXTENSION_MP3;
//                    $fileExtPeer         = FilePeer::EXTENSION_MP3;
//                    break;
//                case 'ogg':
//                    $originalFileExtPeer = FilePeer::ORIGINAL_EXTENSION_OGG;
//                    $fileExtPeer         = FilePeer::EXTENSION_OGG;
//                    break;
//                case 'wav':
//                    $originalFileExtPeer = FilePeer::ORIGINAL_EXTENSION_WAV;
//                    $fileExtPeer         = FilePeer::EXTENSION_WAV;
//                    break;
//                default:
//                    $output->writeln('        - name              : ' . $originalRelativePath);
//                    $output->writeln('        - Unknown extension : ' . $originalExtension);
//                    exit();
//            }
//            switch ($guessExtension)
//            {
//                case '':
//                case 'bin':
//                    $guessFileExtPeer = FilePeer::GUESS_EXTENSION_BIN;
//                    break;
//                case 'mpga':
//                    $guessFileExtPeer = FilePeer::GUESS_EXTENSION_MPGA;
//                    break;
//                case 'ogx':
//                    $guessFileExtPeer = FilePeer::GUESS_EXTENSION_OGX;
//                    break;
//                case 'wav':
//                    $guessFileExtPeer = FilePeer::GUESS_EXTENSION_WAV;
//                    break;
//                default:
//                    $output->writeln('        - name                    : ' . $originalRelativePath);
//                    $output->writeln('        - Unknown guess extension : "' . $guessExtension . '"');
//                    exit();
//            }
//            $output->writeln('        - path               : ' . $originalRelativePath);
//            $output->writeln('        - original extension : ' . $originalExtension);
//            $output->writeln('        - guess extension    : ' . $guessExtension);
//            $iiFile
//                ->setType($type)
//                ->setOriginalPath($originalRelativePath)
//                ->setOriginalExtension($originalFileExtPeer)
//                ->setGuessExtension($guessFileExtPeer)
//                ->setExtension($fileExtPeer)
//                ->setCreatedBy(1)
//                ->setUpdatedBy(1)
//                ->save();
//            $sFile->move($musicPath, $iiFile->getId() . '.' . $originalExtension);
//            if (!isset($countExt[$guessExtension]))
//            {
//                $countExt[$guessExtension] = 0;
//            }
//            $countExt[$guessExtension]++;
//            if ($count >= 500)
//            {
//                break;
//            }
//        }
//    }
}