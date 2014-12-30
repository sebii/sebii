<?php

namespace Sbh\MusicBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'music_deezer_artist' table.
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
class MusicDeezerArtistTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Sbh.MusicBundle.Model.map.MusicDeezerArtistTableMap';

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
        $this->setName('music_deezer_artist');
        $this->setPhpName('MusicDeezerArtist');
        $this->setClassname('Sbh\\MusicBundle\\Model\\MusicDeezerArtist');
        $this->setPackage('src.Sbh.MusicBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addColumn('deezer_id', 'DeezerId', 'INTEGER', false, null, null);
        $this->addForeignKey('artist_id', 'ArtistId', 'INTEGER', 'music_artist', 'id', false, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->addColumn('image', 'Image', 'BOOLEAN', false, 1, false);
        $this->addColumn('nb_albums', 'NbAlbums', 'INTEGER', false, null, null);
        $this->addColumn('nb_fan', 'NbFan', 'INTEGER', false, null, null);
        $this->addColumn('radio', 'Radio', 'BOOLEAN', false, 1, null);
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
