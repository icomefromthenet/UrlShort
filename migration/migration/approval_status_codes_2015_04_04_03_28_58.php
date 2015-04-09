<?php
namespace Migration\Components\Migration\Entities;

use Doctrine\DBAL\Connection,
    Doctrine\DBAL\Schema\AbstractSchemaManager as Schema,
    Migration\Components\Migration\EntityInterface;
use Doctrine\DBAL\Schema\Schema as SchemaBuilder;

class approvla_status_codes_2015_04_04_03_28_58 implements EntityInterface
{

    protected function getMeta(SchemaBuilder $builder)
    {
        $table = $builder->createTable('status_codes'); 
        
        # setup primay key
        $table->addColumn('status_code','string',array('length'=> 4,'notnull' => true));
        $table->setPrimaryKey(array("status_code"));
        $table->addColumn('status_parent_code','string',array('length'=> 4,'notnull' => false));
        $table->addColumn('status_description','string',array('length'=> 100,'notnull' => true));
        
    }

    public function up(Connection $db, Schema $sc)
    {
        $builder = new SchemaBuilder();
        
        $this->getMeta($builder);
        
        $queries = $builder->toSql($db->getDatabasePlatform());
        
        foreach($queries as $query){
            $db->exec($query);
        }  

    }

    public function down(Connection $db, Schema $sc)
    {
        $builder = new SchemaBuilder();
        
        $this->getMeta($builder);
        
        $queries = $builder->toDropSql($db->getDatabasePlatform());
        
        foreach($queries as $query){
            $db->exec($query);
        }

    }

}
/* End of File */
