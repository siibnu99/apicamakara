<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblBlog extends Migration
{

	public function up()
	{
		$this->forge->addField([
			'id_blog'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '64',
			],
			'title'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'slug'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'description' => [
				'type'           => 'TEXT',
				'null'           => true,
			],
			'author' => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'thumbnail' => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'category_id' => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'created_at' => [
				'type'           => 'TIMESTAMP',
			],
			'updated_at' => [
				'type'           => 'TIMESTAMP',
			],
		]);
		$this->forge->addKey('id_blog', true);
		$this->forge->addForeignKey('category_id', 'tbl_category', 'id_category', 'CASCADE', 'RESTRICT');
		$this->forge->createTable('tbl_blog');
	}

	public function down()
	{
		$this->forge->dropTable('tbl_blog');
	}
}
