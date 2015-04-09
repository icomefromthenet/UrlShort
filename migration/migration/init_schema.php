<?php
namespace Migration\Components\Migration\Entities;

use Doctrine\DBAL\Connection,
    Doctrine\DBAL\Schema\AbstractSchemaManager as Schema,
    Doctrine\DBAL\Schema\Schema as SchemaBuilder;
use Migration\Components\Migration\EntityInterface;


class init_schema implements EntityInterface
{

    public function up(Connection $db, Schema $sc)
    {
        $builder = new SchemaBuilder();
        $table   = $builder->createTable('url_storage');
        
        $table->addColumn('url_id','integer',array("unsigned" => true,'autoincrement' => true));
        $table->setPrimaryKey(array("url_id"));
        
        # setup unique short code index
        $table->addColumn('short_code','string',array('length'=> 6,'notnull' => false));
        $table->addIndex(array('short_code'));
        
        # setup the url storage
        $table->addColumn('long_url','string',array('length'=> 255,'notnull' => false));
        
        # column date created
        $table->addColumn('date_created','datetime',array('notnull' => true));
        
        # Optional description message
        $table->addColumn('description_msg','string',array('length' => 200,'notnull'=> false));
        
        # Tag Relation (QuickTag)
        $table->addColumn('tag_id','integer', array("unsigned" => true));
        
       
        # last activity link
        $table->addColumn('last_activity_id', 'integer', array('unsigned'=>true));
        
        $queries = $builder->toSql($db->getDatabasePlatform());
        
        foreach($queries as $query){
            $db->exec($query);
        }

    }

    public function down(Connection $db, Schema $sc)
    {
       
    }


}
/* End of File */
