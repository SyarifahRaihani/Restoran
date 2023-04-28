<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ruangan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [ 'type'=>'int', 'constraint'=>10, 'unsigned'=>true, 'auto_increment'=>true ],
            'nama_ruangan'  => [ 'type'=> 'varchar', 'constraint'=>255, 'null'=>false ],
            'deskripsi' => [ 'type'=> 'varchar', 'constraint'=>255, 'null'=>false ],
            'created_at'    => [ 'type' => 'datetime', 'null'=>true ],
            'updated_at'    => [ 'type' => 'datetime', 'null'=>true ],
            'deleted_at'    => [ 'type' => 'datetime', 'null'=>true ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('ruangan');
    }

    public function down()
    {
        $this->forge->dropTable('ruangan');
    }
}
