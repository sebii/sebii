<?php

namespace Sbh\MusicBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'music_deezer_album' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Sbh.MusicBundle.Model.map
 */
class MusicDeezerAlbumTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Sbh.MusicBundle.Model.map.MusicDeezerAlbumTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('music_deezer_album');
        $this->setPhpName('MusicDeezerAlbum');
        $this->setClassname('Sbh\\MusicBundle\\Model\\MusicDeezerAlbum');
        $this->setPackage('src.Sbh.MusicBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addColumn('deezer_id', 'DeezerId', 'INTEGER', false, null, null);
        $this->addForeignKey('album_id', 'AlbumId', 'INTEGER', 'music_album', 'id', false, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->addForeignKey('artist_deezer_id', 'ArtistDeezerId', 'INTEGER', 'music_deezer_artist', 'deezer_id', false, null, null);
        $this->addColumn('main_genre_deezer_id', 'MainGenreDeezerId', 'INTEGER', false, null, null);
        $this->addColumn('genre_deezer_ids', 'GenreDeezerIds', 'ARRAY', false, null, null);
        $this->addColumn('record_type', 'RecordType', 'ENUM', false, null, null);
        $this->getColumn('record_type', false)->setValueSet(array (
  0 => 'album',
  1 => 'ep',
  2 => 'single',
  3 => 'bundle',
));
        $this->addColumn('upc', 'Upc', 'VARCHAR', false, 255, null);
        $this->addColumn('label', 'Label', 'VARCHAR', false, 255, null);
        $this->addColumn('nb_tracks', 'NbTracks', 'INTEGER', false, null, null);
        $this->addColumn('duration', 'Duration', 'INTEGER', false, null, null);
        $this->addColumn('nb_fans', 'NbFans', 'INTEGER', false, null, null);
        $this->addColumn('rating', 'Rating', 'INTEGER', false, null, null);
        $this->addColumn('release_date', 'ReleaseDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('available', 'Available', 'BOOLEAN', false, 1, null);
        $this->addColumn('explicit_lyrics', 'ExplicitLyrics', 'BOOLEAN', false, 1, null);
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('MusicAlbum', 'Sbh\\MusicBundle\\Model\\MusicAlbum', RelationMap::MANY_TO_ONE, array('album_id' => 'id', ), 'SET NULL', 'CASCADE');
        $this->addRelation('MusicDeezerArtist', 'Sbh\\MusicBundle\\Model\\MusicDeezerArtist', RelationMap::MANY_TO_ONE, array('artist_deezer_id' => 'deezer_id', ), 'SET NULL', 'CASCADE');
        $this->addRelation('MusicDeezerTrack', 'Sbh\\MusicBundle\\Model\\MusicDeezerTrack', RelationMap::ONE_TO_MANY, array('deezer_id' => 'album_deezer_id', ), 'SET NULL', 'CASCADE', 'MusicDeezerTracks');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'auto_add_pk' =>  array (
  'name' => 'id',
  'autoIncrement' => 'true',
  'type' => 'INTEGER',
),
            'alternative_coding_standards' =>  array (
  'brackets_newline' => 'true',
  'remove_closing_comments' => 'true',
  'use_whitespace' => 'true',
  'tab_size' => 2,
  'strip_comments' => 'false',
),
            'timestampable' =>  array (
  'create_column' => 'created_at',
  'update_column' => 'updated_at',
  'disable_updated_at' => 'false',
),
        );
    } // getBehaviors()

}
