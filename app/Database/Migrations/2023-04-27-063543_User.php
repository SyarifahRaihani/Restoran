<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => [ 'type'=>'int', 'constraint'=>10, 'unsigned'=>true, 'auto_increment'=>true ],
            'nama'  => [ 'type'=> 'varchar', 'constraint'=>255, 'null'=>false ],
            'email'  => [ 'type'=>'varchar', 'constraint'=>255, 'null'=>true ],
            'sandi' => [ 'type'=>'varchar', 'constraint'=>60, 'null'=>true ],
            'nohp'      => [ 'type' => 'varchar', 'constraint'=> 15 ],
            'foto'              => [ 'type' => 'varchar', 'constraint' => 255],
            'level' => [ 'type'=>'enum("admin", "petugas", "customer")', 'null'=>true ],
            'created_at'    => [ 'type' => 'datetime', 'null'=>true ],
            'updated_at'    => [ 'type' => 'datetime', 'null'=>true ],
            'deleted_at'    => [ 'type' => 'datetime', 'null'=>true ]

        ]);
        
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('user');
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
