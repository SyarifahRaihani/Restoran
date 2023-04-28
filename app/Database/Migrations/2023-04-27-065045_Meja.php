<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Meja extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [ 'type'=>'int', 'constraint'=>10, 'unsigned'=>true, 'auto_increment'=>true ],
            'nama_meja'     => [ 'type'=> 'varchar', 'constraint'=>255, 'null'=>false ],
            'no_meja'       => [  'type'=> 'varchar', 'constraint'=>11, 'null'=>true ],
            'kapasitas'     => [ 'type'=> 'int', 'constraint'=>11, 'default'=>'0', 'null'=>false ],
            'status'        => [ 'type' => 'enum("T", "H")', 'null'=>true ],
            'ruangan_id'    => [ 'type'=> 'int', 'constraint'=>10, 'unsigned'=>true ],
            'created_at'    => [ 'type' => 'datetime', 'null'=>true ],
            'updated_at'    => [ 'type' => 'datetime', 'null'=>true ],
            'deleted_at'    => [ 'type' => 'datetime', 'null'=>true ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('ruangan_id', 'ruangan', 'id', 'cascade');
        $this->forge->createTable('meja');
    }

    public function down()
    {
        $this->forge->dropTable('meja');
    }
}
