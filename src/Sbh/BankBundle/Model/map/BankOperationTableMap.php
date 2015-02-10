<?php

namespace Sbh\BankBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'bank_operation' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Sbh.BankBundle.Model.map
 */
class BankOperationTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Sbh.BankBundle.Model.map.BankOperationTableMap';

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
        $this->setName('bank_operation');
        $this->setPhpName('BankOperation');
        $this->setClassname('Sbh\\BankBundle\\Model\\BankOperation');
        $this->setPackage('src.Sbh.BankBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addForeignKey('bank_account_id', 'BankAccountId', 'INTEGER', 'bank_account', 'id', false, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->addColumn('date', 'Date', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('bank_payee_id', 'BankPayeeId', 'INTEGER', 'bank_payee', 'id', false, null, null);
        $this->addForeignKey('bank_category_id', 'BankCategoryId', 'INTEGER', 'bank_category', 'id', false, null, null);
        $this->addColumn('payment', 'Payment', 'FLOAT', false, null, null);
        $this->addColumn('deposit', 'Deposit', 'FLOAT', false, null, null);
        $this->addForeignKey('bank_frequent_operation_id', 'BankFrequentOperationId', 'INTEGER', 'bank_frequent_operation', 'id', false, null, null);
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
        $this->addRelation('BankAccount', 'Sbh\\BankBundle\\Model\\BankAccount', RelationMap::MANY_TO_ONE, array('bank_account_id' => 'id', ), 'SET NULL', 'CASCADE');
        $this->addRelation('BankPayee', 'Sbh\\BankBundle\\Model\\BankPayee', RelationMap::MANY_TO_ONE, array('bank_payee_id' => 'id', ), 'SET NULL', 'CASCADE');
        $this->addRelation('BankCategory', 'Sbh\\BankBundle\\Model\\BankCategory', RelationMap::MANY_TO_ONE, array('bank_category_id' => 'id', ), 'SET NULL', 'CASCADE');
        $this->addRelation('BankFrequentOperation', 'Sbh\\BankBundle\\Model\\BankFrequentOperation', RelationMap::MANY_TO_ONE, array('bank_frequent_operation_id' => 'id', ), 'SET NULL', 'CASCADE');
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
