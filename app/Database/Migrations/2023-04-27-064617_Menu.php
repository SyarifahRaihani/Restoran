<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Menu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => [ 'type'=>'int', 'constraint'=>10, 'unsigned'=>true, 'auto_increment'=>true ],
            'nama'              => [ 'type'=> 'varchar', 'constraint'=>255, 'null'=>false],
            'kategori_id'       => [ 'type'=> 'int', 'constraint'=>10, 'unsigned'=>true ],
            'status'            => [ 'type'=>'enum("T", "H")', 'null'=>true ],
            'harga'             => ['type'=>'double','null'=>true],
            'foto'              => [ 'type' => 'varchar', 'constraint' => 255],
            'terjual'           => [ 'type' =>'double', 'default' =>'0' ],
            'created_at'        => [ 'type' => 'datetime', 'null'=>true ],
            'updated_at'        => [ 'type' => 'datetime', 'null'=>true ],
            'deleted_at'        => [ 'type' => 'datetime', 'null'=>true ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('kategori_id', 'kategori', 'id', 'cascade');
        $this->forge->createTable('menu');
    }

    public function down()
    {
        $this->forge->dropTable('menu');
    }
}
