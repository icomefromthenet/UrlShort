<?php
namespace Migration\Components\Migration\Entities;

use Doctrine\DBAL\Connection,
    Doctrine\DBAL\Schema\AbstractSchemaManager as Schema,
    Doctrine\DBAL\Schema\Schema as SchemaBuilder;
use Migration\Components\Migration\EntityInterface;

/**
 * Store the review result, pass/fail status for each test
 * and if in the end the url is approvied.
 * 
 */ 
class review_data_2015_04_09_23_00_55 implements EntityInterface
{

    protected function getReviewTable($builder) {
        
        $table =  $builder->createTable('approval_review');
       
        # Pk column 
        $table->addColumn('review_id','integer',array("unsigned" => true,'autoincrement' => true));
        
        #fk to stored url
        $table->addColumn('url_id','integer',array("unsigned" => true));
        
        # Review failure msg
        $table->addColumn('review_msg','string', array('notnull'=> false));
        
        # Review bool
        $table->addColumn('review_passed','boolean', array('notnull'=> false));
        
        # Passed Resolve Test
        $table->addColumn('review_resolve_passed','boolean', array('default'=> false));
        
        # Passed Whitelist
        $table->addColumn('review_whitelist_passed','boolean', array('default'=> false));
        
        # Passed Blacklist
        $table->addColumn('review_blacklist_passed','boolean', array('default'=> false));
        
        # Passed GSB
        $table->addColumn('review_gsb_passed','boolean', array('default'=> false));
        
        # set PK
        $table->setPrimaryKey(array("review_id"));
        
        $table->addForeignKeyConstraint('url_storage', 
            array("url_id"), 
            array("url_id"), 
            array("onDelete" => "CASCADE"),
            'activity_review_fk1'
        );
        
        return $table;
    }


    public function up(Connection $db, Schema $sc)
    {
        $builder = new SchemaBuilder();
        
        $this->getReviewTable($builder);
        
        $queries = $builder->toSql($db->getDatabasePlatform());
        
        foreach($queries as $query){
            $db->exec($query);
        }         
       

    }

    public function down(Connection $db, Schema $sc)
    {

        $builder = new SchemaBuilder();
        
        $this->getReviewTable($builder);
        
        $queries = $builder->toDropSql($db->getDatabasePlatform());
        
        foreach($queries as $query){
            $db->exec($query);
        }

    }

}
/* End of File */
