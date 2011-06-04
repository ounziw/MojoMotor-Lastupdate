<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lastupdate
{
    var $addon;
    var $page_info;
    var $page_data;
    var $_number;
    var $_wrap;
    var $_data;
    var $outdata;
    var $addon_version = 1.0;

    /**
     * __construct 
     * 
     * @access protected
     * @return void
     */
    function __construct()
    {
        $this->addon =& get_instance();
        $this->addon->load->helper(array('page', 'array'));
        $this->addon->load->model(array('page_model'));
    }

    function _intval($data="",$default=1)
    {
        if ( is_numeric($data) && $data >=1 )
        {
            return (int) $data ;
        }
        else
        {
            return (int) $default ;
        }
    }
    function _h($data="",$default="")
    {
        if ( $data )
        {
            return htmlspecialchars($data,ENT_QUOTES,"UTF-8");
        }
        else
        {
            return htmlspecialchars($default,ENT_QUOTES,"UTF-8");
        }
    }
    function create($template_data = array())
    {
        $this->addon->db->select('id, page_title, url_title, meta_description, last_modified');
        $this->addon->db->where('include_in_page_list','y');
        $this->addon->db->order_by('last_modified','desc');
        $this->_number = $this->_intval($template_data['parameters']['number'],1);
        $this->page_info = $this->addon->db->get('pages',$this->_number) or die('No pages');
        $this->_wrap = $this->_h($template_data['parameters']['wrap'],"li");
        $this->_data['before'] = '<'. $this->_wrap .'>';
        $this->_data['after'] = '</'. $this->_wrap .'>';
        foreach ($this->page_info->result() as $page) {
            $this->_data['contents'][] = array(
                "url" => $page->url_title,
                "title" => $page->page_title,
                "description" => $page->meta_description,
                "date" => $page->last_modified
            );
        }
        // Views Path
        $orig_view_path = $this->addon->load->_ci_view_path;
        $this->addon->load->_ci_view_path = APPPATH.'third_party/lastupdate/views/';
        $this->outdata = $this->addon->load->view('link', $this->_data, TRUE);
        $this->addon->load->_ci_view_path = $orig_view_path;
        // Views Path END
        return $this->outdata;
    }

    function test()
    {
        $this->addon->load->library('unit_test');
        $this->addon->unit->run($this->_intval(4.3),4);
        $this->addon->unit->run($this->_intval(0),1);
        $this->addon->unit->run($this->_intval(i),1);
        $this->addon->unit->run($this->_intval("5"),5);
        $this->addon->unit->run($this->_h("<br>"),"&lt;br&gt;");
        echo $this->addon->unit->report();
    }
}
?>
