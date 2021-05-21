<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Provider_model extends CI_Model{
    function getRows($params = array()){
        $this->db->select('p.*, c.CityName');
        $this->db->from('provider p');
		$this->db->join('city c', 'p.City = c.ID', 'left');
		
		
		if(array_key_exists("searchKey",$params)){
			if($params['searchKey'] != ''){
				$this->db->like('CompanyName',$params['searchKey'],'both');
				$this->db->or_like('ContactPerson',$params['searchKey'],'both');
				$this->db->or_like('ContactNumber',$params['searchKey'],'both');   
				$this->db->or_like('Email',$params['searchKey'],'both');
				$this->db->or_like('RatePerMin',$params['searchKey'],'both');
				$this->db->or_like('RatePerMile',$params['searchKey'],'both');
				$this->db->or_like('AvgRating',$params['searchKey'],'both');
			}
		}
        $this->db->order_by('id','desc');
        
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        
        $query = $this->db->get();
        
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }
	
	function get_provider($ID)
    {
        return $this->db->get_where('provider',array('ID'=>$ID))->row_array();
    }
    
    function get_all_provider()
    {
        return $this->db->get('provider')->result_array();
    }
    function get_close_dates($ID)
    {
        return $this->db->where('ProviderID',$ID)->get('holiday_list')->result_array();
    }
    function add_provider($params)
    {
        $this->db->insert('provider',$params);
        return $this->db->insert_id();
    }
    function update_provider($ID,$params)
    {
        $this->db->where('ID',$ID);
        $response = $this->db->update('provider',$params);
        if($response)
        {
            return "provider updated successfully";
        }
        else
        {
            return "Error occuring while updating provider";
        }
    }
	
	function update_holiday($table,$params,$ID)
    {
        $this->db->delete($table, array('ProviderID' => $ID)); 
		
		foreach($params as $Date)
		{
			$data[] = array(
					  'ProviderID' => $ID,
					  'Date' => date("Y-m-d", strtotime($Date)),
				   );		
		}
		if (!empty($data)){
			$this->db->insert_batch($table, $data); 
		}
    }
    function delete_provider($ID)
    {
        $response = $this->db->delete('provider',array('ID'=>$ID));
        if($response)
        {
            return "provider deleted successfully";
        }
        else
        {
            return "Error occuring while deleting provider";
        }
    }
}