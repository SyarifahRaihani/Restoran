<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailPesanan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [ 'type'=>'int', 'constraint'=>10, 'unsigned'=>true, 'auto_increment'=>true ],
            'produk_id'     => [ 'type'=> 'int', 'constraint'=>10, 'unsigned'=>true ],
            'harga_jual'    =>[ 'type' => 'double', 'default' => '0',],
            'jumlah'        => [ 'type'=>'int', 'constraint'=>11, 'default'=>'0'],
            'created_at'    => [ 'type' => 'datetime', 'null'=>true ],
            'updated_at'    => [ 'type' => 'datetime', 'null'=>true ],
            'deleted_at'    => [ 'type' => 'datetime', 'null'=>true ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('produk_id', 'produk', 'id', 'cascade');
        $this->forge->createTable('detailpesanan');
    }

    public function down()
    {
        $this->forge->dropTable('detailpesanan');
    }
}
