<?php

namespace Sbh\MusicBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use \Criteria;
use \Exception;
use Sbh\MusicBundle\Model\MusicArtistQuery;
use Sbh\MusicBundle\Model\MusicAlbumQuery;
use Sbh\MusicBundle\Model\MusicDeezerArtist;
use Sbh\MusicBundle\Model\MusicDeezerArtistQuery;
use Sbh\MusicBundle\Model\MusicDeezerAlbum;
use Sbh\MusicBundle\Model\MusicDeezerAlbumQuery;
use Sbh\MusicBundle\Model\MusicDeezerAlbumPeer;

/**
 * 
 * @version 1.0.0
 * @author Sébastien "sebii" Bloino <sebii@sebiiheckel.fr>
 */
class MusicDeezerArtistAlbumsCommand extends ContainerAwareCommand
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
            ->setName('sbh:music:deezer:artist:albums')
            ->setDescription('Search and associate albums from artists via deezer');
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
        $output->writeln('> Recherche de 5 artistes non scannés chez Deezer');
        $musicArtists = MusicArtistQuery::create()
            ->filterByScanDeezerAlbums(true)
            ->useMusicDeezerArtistQuery()
                ->filterByArtistId(null, Criteria::NOT_EQUAL)
            ->endUse()
            ->limit(5)
            ->groupById()
            ->find();
        $output->writeln('    - ' . $musicArtists->count() . ' artistes trouvés');
        foreach ($musicArtists as $musicArtist)
        {
            $output->writeln('    - Artiste ' . $musicArtist->getName());
            foreach ($musicArtist->getMusicDeezerArtists() as $deezerArtist)
            {
                $deezerUrl = 'http://api.deezer.com/artist/' . $deezerArtist->getDeezerId() . '/albums';
                while ($deezerUrl)
                {
                    $output->writeln('        > Ouverture de l\'url ' . $deezerUrl);
                    $deezerJson = file_get_contents($deezerUrl);
                    $deezerData = json_decode($deezerJson);
                    $output->writeln('        - ' . $deezerData->total . ' albums trouvés pour l\'artiste');
                    foreach ($deezerData->data as $deezerAlbumData)
                    {
                        $output->writeln('        - Traitement de l\'album Deezer "' . $deezerAlbumData->title . '" [' . $deezerAlbumData->id . ']');
                        $deezerAlbum = MusicDeezerAlbumQuery::create()
                            ->filterByDeezerId($deezerAlbumData->id)
                            ->findOne();
                        if (is_null($deezerAlbum))
                        {
                            $output->writeln('            > Création d\'un nouvel album Deezer ' . $deezerAlbumData->title . ' [' . $deezerAlbumData->id . ']');
                            $deezerAlbum = new MusicDeezerAlbum();
                            $deezerAlbum
                                ->setDeezerId($deezerAlbumData->id)
                                ->save();
                        }
                        $output->writeln('            > Récupération de l\'album local ' . $deezerAlbumData->title);
                        $musicAlbum = MusicAlbumQuery::create()
                            ->filterByMusicArtist($musicArtist)
                            ->filterByName(substr($deezerAlbumData->title, 0, strlen($deezerAlbumData->title) - 7))
                            ->findOne();
                        $output->writeln('            > Traitement des données');
                        $deezerAlbum
                            ->setName($deezerAlbumData->title)
                            ->setMainGenreDeezerId($deezerAlbumData->genre_id)
                            ->setRecordType($deezerAlbumData->record_type)
                            ->setMusicAlbum($musicAlbum)
                            ->setMusicDeezerArtist($deezerArtist)
                            ->save();
                        $output->writeln('            > Enregistrement');
                    }
                    try
                    {
                        $deezerUrl = $deezerData->next;
                    } catch (Exception $ex) {
                        break;
                    }
                }
            }
            $musicArtist
                ->setScanDeezerAlbums(false)
                ->save();
            $output->writeln('        > Signalé comme déjà recherché');
        }
    }
}