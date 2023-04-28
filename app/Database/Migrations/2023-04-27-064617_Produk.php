<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => [ 'type'=>'int', 'constraint'=>10, 'unsigned'=>true, 'auto_increment'=>true ],
            'kode'              => [ 'type'=> 'varchar', 'constraint'=>30, 'null'=>true],
            'nama'              => [ 'type'=> 'varchar', 'constraint'=>255, 'null'=>false],
            'deskripsi'         => [ 'type'=> 'varchar', 'constraint'=>255, 'null'=>false],
            'kategori_id'       => [ 'type'=> 'int', 'constraint'=>10, 'unsigned'=>true ],
            'status'            => [ 'type'=>'enum("T", "H")', 'null'=>true ],
            'harga_jual'        => [ 'type' => 'double', 'default' => '0',],
            'diskon'            => [ 'type' => 'double', 'default' => '0',],
            'harga_standar'     => [ 'type' => 'double', 'default' => '0',],
            'foto'              => [ 'type' => 'varchar', 'constraint' => 255],
            'terjual'           => [ 'type' =>'double', 'default' =>'0' ],
            'created_at'        => [ 'type' => 'datetime', 'null'=>true ],
            'updated_at'        => [ 'type' => 'datetime', 'null'=>true ],
            'deleted_at'        => [ 'type' => 'datetime', 'null'=>true ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('kategori_id', 'kategori', 'id', 'cascade');
        $this->forge->createTable('produk');
    }

    public function down()
    {
        $this->forge->dropTable('produk');
    }
}
