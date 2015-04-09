<?php
namespace Migration\Components\Migration\Entities;

use Doctrine\DBAL\Connection,
    Doctrine\DBAL\Schema\AbstractSchemaManager as Schema,
    Migration\Components\Migration\EntityInterface;
use Doctrine\DBAL\Schema\Schema as SchemaBuilder;

class approval_activity_2015_04_04_04_14_21 implements EntityInterface
{

    protected function getMeta(SchemaBuilder $builder)
    {
        $table = $builder->createTable('activity_log'); 
        
        # setup primay key
        
        $table->addColumn('activity_id','integer',array("unsigned" => true,'autoincrement' => true));
        
        $table->setPrimaryKey(array("activity_id"));
        
        $table->addColumn('status', 'string', array('length'=> 10, 'notnull' => true));
        $table->addColumn('comment','string', array('length'=> 500, 'notnull' => true));
        $table->addColumn('change_dte','datetime',array('notnull' => true));
        $table->addColumn('user_id','integer',array("unsigned" => true,'notnull' => true));
        $table->addColumn('url_id','integer',array("unsigned" => true,'notnull' => true));
        
        $table->addForeignKeyConstraint('url_storage', 
            array("url_id"), 
            array("url_id"), 
            array("onDelete" => "CASCADE"),
            'activity_log_fk1'
        );
        
        $table->addForeignKeyConstraint('status_codes', 
            array("status"), 
            array("status_code"), 
            array("onDelete" => "CASCADE"),
            'activity_log_fk2'
        );
        
        
        $table->addForeignKeyConstraint('users', 
            array("user_id"), 
            array("id"), 
            array("onDelete" => "CASCADE"),
            'activity_log_fk3'
        );
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
