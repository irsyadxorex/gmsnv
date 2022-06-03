<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_visitor extends CI_Model
{

    // start datatables
    var $column_order = array(null, 'tanggal', 'jam', 'no_visitor', 'perlu', 'status', 'nama', 'penghuni', 'site'); //set column field database for datatable orderable
    var $column_search = array('tanggal', 'jam', 'site', 'no_visitor', 'perlu', 'status', 'nama', 'penghuni'); //set column field database for datatable searchable
    var $order = array('id_tamu' => 'desc'); // default order

    private function _get_datatables_query()
    {
        $id_site = $this->session->userdata('id_site');
        if ($id_site == 0) {
            $this->db->select('*,gt.status as status_tamu');
            $this->db->from('gms_tamu gt');
            $this->db->join('master_penghuni mp', 'mp.id_penghuni =gt.id_penghuni');
            $this->db->join('keperluan k', 'k.id_perlu = gt.id_perlu');
            $this->db->join('users u', 'u.id = gt.nik');
            $this->db->join('sites s', 'u.id_site = s.id_site');
        } else {
            $this->db->select('*,gt.status as status_tamu');
            $this->db->from('gms_tamu gt');
            $this->db->join('master_penghuni mp', 'mp.id_penghuni =gt.id_penghuni');
            $this->db->join('keperluan k', 'k.id_perlu = gt.id_perlu');
            $this->db->join('users u', 'u.id = gt.nik');
            $this->db->join('sites s', 'u.id_site = s.id_site');
            $this->db->where('u.id_site', $id_site);
        };

        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if (@$_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables()
    {
        $this->_get_datatables_query();
        if (@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_all()
    {
        $this->db->from('gms_tamu');
        return $this->db->count_all_results();
    }
    // end datatables
}
