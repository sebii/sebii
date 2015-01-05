<?php

namespace Sbh\MusicBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use \Criteria;
use Sbh\MusicBundle\Model\MusicAlbumQuery;
use Sbh\MusicBundle\Model\MusicDeezerAlbum;
use Sbh\MusicBundle\Model\MusicDeezerAlbumQuery;
use Imagine\Imagick\Imagine;
use Imagine\Image\Box;

/**
 * 
 * @version 1.0.0
 * @author Sébastien "sebii" Bloino <sebii@sebiiheckel.fr>
 */
class MusicDeezerAlbumImageCommand extends ContainerAwareCommand
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
            ->setName('sbh:music:deezer:album:image')
            ->setDescription('Download album image of deezer');
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
     * récupération du imgPath
     * 
     * Récupère l'adresse du dossier image et le génère si non trouvé
     * @since 1.0.0 Création -- sebii
     * @access protected
     * @return string
     */
    protected function getImgPath()
    {
        $fs      = new FileSystem();
        $imgPath = $this->getMusicPath() . DIRECTORY_SEPARATOR . '_img';
        if (!$fs->exists($imgPath))
        {
            $fs->mkdir($imgPath, 0777);
        }
        return realpath($imgPath);
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
        $imgPath = $this->getImgPath();
        
        $output->writeln('> Recherche des albums Deezer ayant au moins 1 piste et 1 association Deezer et pas d\'image téléchargée');
        $musicAlbums = MusicAlbumQuery::create()
            ->useMusicDeezerAlbumQuery()
                ->filterByAlbumId(null, Criteria::NOT_EQUAL)
                ->filterByImage(false)
            ->endUse()
            ->useMusicTrackQuery()
                ->filterByAlbumId(null, Criteria::NOT_EQUAL)
            ->endUse()
            ->groupById()
            ->find();
        $output->writeln('    - ' . $musicAlbums->count() . ' albums trouvés');
        
        foreach ($musicAlbums as $musicAlbum)
        {
            $output->writeln('    - album ' . $musicAlbum->getName());
            foreach ($musicAlbum->getMusicDeezerAlbums() as $deezerAlbum)
            {
                $deezerUrl = 'https://api.deezer.com/album/' . $deezerAlbum->getDeezerId() . '/image';
                $output->writeln('        > Ouverture de l\'url ' . $deezerUrl);
                $ch        = curl_init();
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_URL, $deezerUrl);
                $deezerOut    = curl_exec($ch);
                $deezerArr    = explode("\r\n", $deezerOut);
                $deezerImgUrl = $deezerUrl;
                foreach ($deezerArr as $deezerHeader)
                {
                    if (substr($deezerHeader, 0, 10) === 'Location: ')
                    {
                        $deezerImgUrl = str_replace('-80-', '-100-', preg_replace('#/([0-9]+x[0-9]+)-#', '/1000x1000-', substr($deezerHeader, 10)));
                        $output->writeln('        > Récupération de la vraie url ' . $deezerImgUrl);
                    }
                }
                $output->writeln('        > Récupération de l\'image Deezer');
                $deezerImgName = 'deezer_album_' . $deezerAlbum->getDeezerId() . '.jpg';
                $deezerThmName = 'deezer_album_' . $deezerAlbum->getDeezerId() . '_thumb.jpg';
                $fs      = new Filesystem();
                $imagine = new Imagine();
                $imagine
                    ->open($deezerImgUrl)
                    ->save($imgPath . DIRECTORY_SEPARATOR . $deezerImgName, array('jpeg_quality' => 100));
                $imagine
                    ->open($imgPath . DIRECTORY_SEPARATOR . $deezerImgName)
                    ->resize(new Box(300, 300))
                    ->save($imgPath . DIRECTORY_SEPARATOR . $deezerThmName, array('jpeg_quality' => 100));
                $fs->chmod($imgPath . DIRECTORY_SEPARATOR . $deezerImgName, 0777);
                $fs->chmod($imgPath . DIRECTORY_SEPARATOR . $deezerThmName, 0777);
                $output->writeln('        > Sauvegarde de l\'image Deezer ' . $deezerImgName);
                $deezerAlbum->setImage(true)->save();
            }
            if ($musicAlbum->getImage() == false)
            {
                $deezerImgName = 'deezer_album_' . $musicAlbum->getMusicDeezerAlbums()->getFirst()->getDeezerId() . '.jpg';
                $output->writeln('        > Image de l\'album ' . $musicAlbum->getName() . ' inexistante ');
                $albumImgName = 'album_' . $musicAlbum->getId() . '.jpg';
                $albumThmName = 'album_' . $musicAlbum->getId() . '_thumb.jpg';
                $imagine       = new Imagine();
                $imagine
                    ->open($imgPath . DIRECTORY_SEPARATOR . $deezerImgName)
                    ->save($imgPath . DIRECTORY_SEPARATOR . $albumImgName, array('jpeg_quality' => 100));
                $imagine
                    ->open($imgPath . DIRECTORY_SEPARATOR . $deezerImgName)
                    ->resize(new Box(300, 300))
                    ->save($imgPath . DIRECTORY_SEPARATOR . $albumThmName, array('jpeg_quality' => 100));
                $fs->chmod($imgPath . DIRECTORY_SEPARATOR . $albumImgName, 0777);
                $fs->chmod($imgPath . DIRECTORY_SEPARATOR . $albumThmName, 0777);
                $output->writeln('        > Sauvegarde de l\'image Deezer en tant qu\'image de l\'album ' . $albumImgName);
                $musicAlbum
                    ->setImage(true)
                    ->save();
            }
            exit();
            
        }
    }
}