<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblCategory extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_category'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '64',
			],
			'name'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '32',
			],
			'bg_color' => [
				'type'           => 'VARCHAR',
				'constraint'     => '16',
			],
			'text_color' => [
				'type'           => 'VARCHAR',
				'constraint'     => '16',
			],
			'created_at' => [
				'type'           => 'TIMESTAMP',
			],
			'updated_at' => [
				'type'           => 'TIMESTAMP',
			],
		]);
		$this->forge->addKey('id_category', true);
		$this->forge->createTable('tbl_category');
	}

	public function down()
	{
		$this->forge->dropTable('tbl_category');
	}
}
