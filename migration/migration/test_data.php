<?php
namespace Migration\Components\Migration\Entities;

use Doctrine\DBAL\Connection;
use Migration\Database\Handler;
use Doctrine\DBAL\Schema\AbstractSchemaManager as Schema;
use Migration\Components\Migration\EntityInterface;

class test_data implements EntityInterface
{
    
    public function up(Connection $db, Schema $sc)
    {
        $db->insert('status_codes',array(
            'status_code'       => 'W'
            ,'status_parent_code'=> null
            ,'status_description'=>  'Waiting to start the approval checks'
        ));
        
        $db->insert('status_codes',array(
            'status_code'        => 'WI'
            ,'status_parent_code'=> ''
            ,'status_description'=> 'Withdrawn from apporval checks'
        ));

        $db->insert('status_codes',array(
            'status_code'       => 'PA'
            ,'status_parent_code'=> null
            ,'status_description'=>  'Passed all approval checks'
        ));

        $db->insert('status_codes',array(
            'status_code'       => 'FA'
            ,'status_parent_code'=> null
            ,'status_description'=>  'Failed an approval checks'
        ));
        
        $db->insert('status_codes',array(
            'status_code'       => 'AP'
            ,'status_parent_code'=> null
            ,'status_description'=>  'Approval Pending (Entered system queue)'
        ));
        
        $db->insert('status_codes',array(
            'status_code'       => 'EX'
            ,'status_parent_code'=> 'AP'
            ,'status_description'=>  'Link Resolve Approval Test'
        ));
        
        $db->insert('status_codes',array(
            'status_code'       => 'GSB'
            ,'status_parent_code'=> 'AP'
            ,'status_description'=>  'Link tested against Google Safer Browser'
        ));
        
        $db->insert('status_codes',array(
            'status_code'       => 'WH'
            ,'status_parent_code'=> 'AP'
            ,'status_description'=>  'Link tested against Whitelist'
        ));
        
        $db->insert('status_codes',array(
            'status_code'       => 'BL'
            ,'status_parent_code'=> 'AP'
            ,'status_description'=>  'Link tested against Blacklist'
        ));
        
        $db->insert('status_codes',array(
            'status_code'        => 'BILL'
            ,'status_parent_code'=> ''
            ,'status_description'=> 'Linked passed for billing'
        ));
        
        $db->insert('status_codes',array(
            'status_code'        => 'PAID'
            ,'status_parent_code'=> 'BILL'
            ,'status_description'=> 'Link bill has been paid'
        ));

        $db->insert('status_codes',array(
            'status_code'        => 'VOID'
            ,'status_parent_code'=> 'BILL'
            ,'status_description'=> 'Link billing issues on hold'
        ));
    }

    public function down(Connection $db, Schema $sc)
    {
        

    }


}
/* End of File */
