<?php

namespace Sbh\MusicBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Sbh\MusicBundle\Model\MusicArtistQuery;
use Sbh\MusicBundle\Model\MusicSpotifyArtist;
use Sbh\MusicBundle\Model\MusicSpotifyArtistQuery;

/**
 * 
 * @version 1.0.0
 * @author Sébastien "sebii" Bloino <sebii@sebiiheckel.fr>
 */
class MusicSpotifyArtistSearchCommand extends ContainerAwareCommand
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
            ->setName('sbh:music:spotify:artist:search')
            ->setDescription('Search and associate artists via spotify');
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
            ->filterByScanSpotifySearch(true)
            ->limit(5)
            ->find();
        $output->writeln('    - ' . $musicArtists->count() . ' artistes trouvés');
        
        foreach ($musicArtists as $musicArtist)
        {
            $output->writeln('    - Artiste ' . $musicArtist->getName());
            $spotifyUrl  = 'https://api.spotify.com/v1/search?type=artist&q=' . urlencode(strtolower($musicArtist->getName()));
            $output->writeln('        > Ouverture de l\'url ' . $spotifyUrl);
            $spotifyJson = file_get_contents($spotifyUrl);
            $spotifyData = json_decode($spotifyJson);
            $output->writeln('        - ' . count($spotifyData->artists->items) . ' artistes Spotify trouvés');
            foreach ($spotifyData->artists->items as $spotifySearchArtist)
            {
                $spotifyId     = $spotifySearchArtist->id;
                $spotifyName   = $spotifySearchArtist->name;
                $spotifyUri    = $spotifySearchArtist->uri;
                $output->writeln('        - Traitement de l\'artiste Spotify "' . $spotifyName . '" [' . $spotifyId . ']');
                $spotifyArtist = MusicSpotifyArtistQuery::create()
                    ->filterBySpotifyId($spotifyId)
                    ->findOne();
                if (is_null($spotifyArtist))
                {
                    $output->writeln('            > Création d\'un nouvel artiste Spotify ' . $spotifyName . ' [' . $spotifyId . ']');
                    $spotifyArtist = new MusicSpotifyArtist();
                    $spotifyArtist
                        ->setSpotifyId($spotifyId)
                        ->setName($spotifyName)
                        ->setUri($spotifyUri);
                }
                if (is_null($spotifyArtist->getArtistId()) && $spotifyName == $musicArtist->getName())
                {
                    $output->writeln('            > Artiste Spotify lié à l\'artiste local');
                    $spotifyArtist->setMusicArtist($musicArtist);
                }
                $spotifyImageId    = null;
                $spotifyImageWidth = null;
                $output->writeln('            > Définition de l\'image ayant la meilleure résolution');
                foreach ($spotifySearchArtist->images as $spotifyImage)
                {
                    if ($spotifyImageWidth == null || $spotifyImageWidth < $spotifyImage->width)
                    {
                        $spotifyImageId    = substr($spotifyImage->url, 24);
                        $spotifyImageWidth = $spotifyImage->width;
                    }
                }
                $spotifyArtist
                    ->setImageId($spotifyImageId)
                    ->setPopularity($spotifySearchArtist->popularity);
                $spotifyArtist->save();
                $output->writeln('            > Sauvegarde de l\'artiste Spotify ' . $spotifyArtist->getSpotifyId() . ' [' . $spotifyArtist->getId() . ']');
            }
            $musicArtist
                ->setScanSpotifySearch(false)
                ->save();
            $output->writeln('        > Signalé comme déjà recherché');
        }
    }
}