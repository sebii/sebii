<?php

namespace Sbh\StartBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'file' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Sbh.StartBundle.Model.map
 */
class FileTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Sbh.StartBundle.Model.map.FileTableMap';

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
        $this->setName('file');
        $this->setPhpName('File');
        $this->setClassname('Sbh\\StartBundle\\Model\\File');
        $this->setPackage('src.Sbh.StartBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addColumn('type', 'Type', 'ENUM', false, null, 'binary');
        $this->getColumn('type', false)->setValueSet(array (
  0 => 'binary',
  1 => 'music',
));
        $this->addColumn('original_path', 'OriginalPath', 'VARCHAR', false, 255, null);
        $this->addColumn('path', 'Path', 'VARCHAR', false, 255, null);
        $this->addColumn('original_ext', 'OriginalExt', 'ENUM', false, null, 'bin');
        $this->getColumn('original_ext', false)->setValueSet(array (
  0 => 'bin',
  1 => 'mp3',
  2 => 'ogg',
  3 => 'aac',
  4 => 'flac',
  5 => 'mpga',
  6 => 'wav',
));
        $this->addColumn('guess_ext', 'GuessExt', 'ENUM', false, null, 'bin');
        $this->getColumn('guess_ext', false)->setValueSet(array (
  0 => 'bin',
  1 => 'mp3',
  2 => 'ogg',
  3 => 'aac',
  4 => 'flac',
  5 => 'mpga',
  6 => 'wav',
));
        $this->addColumn('ext', 'Ext', 'ENUM', false, null, 'bin');
        $this->getColumn('ext', false)->setValueSet(array (
  0 => 'bin',
  1 => 'mp3',
  2 => 'ogg',
  3 => 'aac',
  4 => 'flac',
  5 => 'mpga',
  6 => 'wav',
));
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
