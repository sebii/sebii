<?php

namespace Sbh\MusicBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'music_deezer_track' table.
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
class MusicDeezerTrackTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Sbh.MusicBundle.Model.map.MusicDeezerTrackTableMap';

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
        $this->setName('music_deezer_track');
        $this->setPhpName('MusicDeezerTrack');
        $this->setClassname('Sbh\\MusicBundle\\Model\\MusicDeezerTrack');
        $this->setPackage('src.Sbh.MusicBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addColumn('deezer_id', 'DeezerId', 'INTEGER', false, null, null);
        $this->addForeignKey('album_deezer_id', 'AlbumDeezerId', 'INTEGER', 'music_deezer_album', 'deezer_id', false, null, null);
        $this->addForeignKey('artist_deezer_id', 'ArtistDeezerId', 'INTEGER', 'music_deezer_artist', 'deezer_id', false, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->addColumn('readable', 'Readable', 'BOOLEAN', false, 1, null);
        $this->addColumn('duration', 'Duration', 'INTEGER', false, null, null);
        $this->addColumn('rank', 'Rank', 'BOOLEAN', false, 1, null);
        $this->addColumn('explicit_lyrics', 'ExplicitLyrics', 'BOOLEAN', false, 1, null);
        $this->addColumn('preview_link', 'PreviewLink', 'VARCHAR', false, 255, null);
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
        $this->addRelation('MusicDeezerAlbum', 'Sbh\\MusicBundle\\Model\\MusicDeezerAlbum', RelationMap::MANY_TO_ONE, array('album_deezer_id' => 'deezer_id', ), 'SET NULL', 'CASCADE');
        $this->addRelation('MusicDeezerArtist', 'Sbh\\MusicBundle\\Model\\MusicDeezerArtist', RelationMap::MANY_TO_ONE, array('artist_deezer_id' => 'deezer_id', ), 'SET NULL', 'CASCADE');
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
