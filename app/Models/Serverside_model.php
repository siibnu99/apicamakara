<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class Serverside_model extends Model
{

    public $db;
    public $builder;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }


    protected function _get_datatables_query($table, $column_order, $column_search, $order)
    {
        $this->builder = $this->db->table($table);
        //jika ingin join formatnya adalah sebagai berikut :
        //$this->builder->join('tabel_lain','tabel_lain.kolom_yang_sama = pengguna.kolom_yang_sama','left');
        //end Join
        $i = 0;

        foreach ($column_search as $item) {
            try {
                if ($_POST['search']['value']) {

                    if ($i === 0) {
                        $this->builder->groupStart();
                        $this->builder->like($item, $_POST['search']['value']);
                    } else {
                        $this->builder->orLike($item, $_POST['search']['value']);
                    }

                    if (count($column_search) - 1 == $i)
                        $this->builder->groupEnd();
                }
            } catch (Exception $e) {
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            try {
                $this->builder->orderBy($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } catch (\Throwable $th) {
                $order = $order;
                $this->builder->orderBy(key($order), $order[key($order)]);
            }
        } else if (isset($order)) {
            $order = $order;
            $this->builder->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatables($table, $column_order, $column_search, $order, $data = '')
    {
        $this->_get_datatables_query($table, $column_order, $column_search, $order);
        try {
            if ($_POST['length'] != -1)
                $this->builder->limit($_POST['length'], $_POST['start']);
        } catch (Exception $e) {
        }
        if ($data) {
            $this->builder->where($data);
        }

        $query = $this->builder->get();
        return $query->getResult();
    }

    public function count_filtered($table, $column_order, $column_search, $order, $data = '')
    {
        $this->_get_datatables_query($table, $column_order, $column_search, $order);
        if ($data) {
            $this->builder->where($data);
        }
        $this->builder->get();
        return $this->builder->countAll();
    }

    public function count_all($table, $data = '')
    {
        if ($data) {
            $this->builder->where($data);
        }
        $this->builder->from($table);

        return $this->builder->countAll();
    }
}
