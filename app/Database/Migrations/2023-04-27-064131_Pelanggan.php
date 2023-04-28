<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pelanggan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'        => [ 'type'=>'int', 'constraint'=>10, 'unsigned'=>true, 'auto_increment'=>true ],
            'nama'      => [ 'type'=> 'varchar', 'constraint'=>255, 'null'=>false ],
            'gender'    => [ 'type' => 'enum("L", "P")', 'null'=>true ],
            'alamat'    => [ 'type'=>'varchar', 'constraint'=>255, 'null'=>false],
            'email'     => [ 'type'=>'varchar', 'constraint'=>255, 'null'=>true ],
            'sandi'     => [ 'type'=>'varchar', 'constraint'=>60, 'null'=>true ],
            'nohp'      => [ 'type' => 'varchar', 'constraint'=> 15 ],
            'created_at'    => [ 'type' => 'datetime', 'null'=>true ],
            'updated_at'    => [ 'type' => 'datetime', 'null'=>true ],
            'deleted_at'    => [ 'type' => 'datetime', 'null'=>true ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('pelanggan');
    }

    public function down()
    {
        $this->forge->dropTable('pelanggan');
    }
}
