<?php

namespace Sbh\MusicBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Sbh\MusicBundle\Model\MusicArtistQuery;
use Sbh\MusicBundle\Model\MusicDeezerArtist;
use Sbh\MusicBundle\Model\MusicDeezerArtistQuery;

/**
 * 
 * @version 1.0.0
 * @author Sébastien "sebii" Bloino <sebii@sebiiheckel.fr>
 */
class MusicDeezerArtistSearchCommand extends ContainerAwareCommand
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
            ->setName('sbh:music:deezer:artist:search')
            ->setDescription('Search and associate artists via deezer');
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
        $output->writeln('> Recherche de 5 artistes non scannés chez Spotify');
        $musicArtists = MusicArtistQuery::create()
            ->filterByScanDeezerSearch(true)
            ->limit(5)
            ->find();
        $output->writeln('    - ' . $musicArtists->count() . ' artistes trouvés');
        
        foreach ($musicArtists as $musicArtist)
        {
            $output->writeln('    - Artiste ' . $musicArtist->getName());
            $deezerUrl  = 'http://api.deezer.com/search/artist?q=' . urlencode(strtolower($musicArtist->getName()));
            $output->writeln('        > Ouverture de l\'url ' . $deezerUrl);
            $deezerJson = file_get_contents($deezerUrl);
            $deezerData = json_decode($deezerJson);
            $output->writeln('        - ' . count($deezerData->data) . ' artistes Deezer trouvés');
            foreach ($deezerData->data as $deezerSearchArtist)
            {
                $deezerId     = $deezerSearchArtist->id;
                $deezerName   = $deezerSearchArtist->name;
                $output->writeln('        - Traitement de l\'artiste Deezer "' . $deezerName . '" [' . $deezerId . ']');
                $deezerArtist = MusicDeezerArtistQuery::create()
                    ->filterByDeezerId($deezerId)
                    ->findOne();
                if (is_null($deezerArtist))
                {
                    $output->writeln('            > Création d\'un nouvel artiste Deezer ' . $deezerName . ' [' . $deezerId . ']');
                    $deezerArtist = new MusicDeezerArtist();
                    $deezerArtist
                        ->setDeezerId($deezerId)
                        ->setName($deezerName);
                }
                if (is_null($deezerArtist->getArtistId()) && $deezerName == $musicArtist->getName())
                {
                    $output->writeln('            > Artiste Deezer lié à l\'artiste local');
                    $deezerArtist->setMusicArtist($musicArtist);
                }
                $deezerArtist
                    ->setNbAlbums($deezerSearchArtist->nb_album)
                    ->setNbFan($deezerSearchArtist->nb_fan)
                    ->setRadio($deezerSearchArtist->radio);
                $deezerArtist->save();
                $output->writeln('            > Sauvegarde de l\'artiste Deezer ' . $deezerArtist->getDeezerId() . ' [' . $deezerArtist->getId() . ']');
            }
            $musicArtist
                ->setScanDeezerSearch(false)
                ->save();
            $output->writeln('        > Signalé comme déjà recherché');
        }
    }
}