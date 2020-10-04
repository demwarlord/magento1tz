<?php
/**
 * @category    Overdose
 * @package     Overdose_Testimonials
 * @author      Dmytro Kamyshov
 */

$installer = $this;
$tableName = $installer->getTable('overdose_testimonials/overdose_testimonials');

$installer->startSetup();

$installer->getConnection()->dropTable($tableName);
$table = $installer->getConnection()
    ->newTable($tableName)
    ->addColumn('review_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ))
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, '255', array(
        'nullable' => false,
    ))
    ->addColumn('message', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false,
    ))
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_TEXT, '512', array(
        'nullable' => false,
    ));
$installer->getConnection()->createTable($table);

$installer->endSetup();
