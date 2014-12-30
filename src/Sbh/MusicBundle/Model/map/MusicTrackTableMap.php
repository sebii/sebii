<?php

namespace Sbh\MusicBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'music_track' table.
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
class MusicTrackTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Sbh.MusicBundle.Model.map.MusicTrackTableMap';

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
        $this->setName('music_track');
        $this->setPhpName('MusicTrack');
        $this->setClassname('Sbh\\MusicBundle\\Model\\MusicTrack');
        $this->setPackage('src.Sbh.MusicBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->addColumn('track', 'Track', 'INTEGER', false, null, null);
        $this->addColumn('disc', 'Disc', 'INTEGER', false, null, null);
        $this->addForeignKey('artist_id', 'ArtistId', 'INTEGER', 'music_artist', 'id', false, null, null);
        $this->addForeignKey('album_id', 'AlbumId', 'INTEGER', 'music_album', 'id', false, null, null);
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
        $this->addRelation('MusicArtist', 'Sbh\\MusicBundle\\Model\\MusicArtist', RelationMap::MANY_TO_ONE, array('artist_id' => 'id', ), 'SET NULL', 'CASCADE');
        $this->addRelation('MusicAlbum', 'Sbh\\MusicBundle\\Model\\MusicAlbum', RelationMap::MANY_TO_ONE, array('album_id' => 'id', ), 'SET NULL', 'CASCADE');
        $this->addRelation('MusicFile', 'Sbh\\MusicBundle\\Model\\MusicFile', RelationMap::ONE_TO_MANY, array('id' => 'track_id', ), 'SET NULL', 'CASCADE', 'MusicFiles');
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
