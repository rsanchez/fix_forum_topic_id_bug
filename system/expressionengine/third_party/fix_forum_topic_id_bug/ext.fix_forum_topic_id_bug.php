<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Fix_forum_topic_id_bug Extension
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Extension
 * @author		Rob  Sanchez
 * @link		
 */

class Fix_forum_topic_id_bug_ext {
	
	public $settings 		= array();
	public $description		= 'Fixes this bug: http://expressionengine.com/bug_tracker/bug/16159/';
	public $docs_url		= 'http://expressionengine.com/bug_tracker/bug/16159/';
	public $name			= 'Fix Forum "Invalid Topic ID" Bug';
	public $settings_exist		= 'n';
	public $version			= '1.0';
	
	private $EE;
	
	/**
	 * Constructor
	 *
	 * @param 	mixed	Settings array or empty string if none exist.
	 */
	public function __construct($settings = '')
	{
		$this->EE =& get_instance();
		$this->settings = $settings;
	}// ----------------------------------------------------------------------
	
	/**
	 * Activate Extension
	 *
	 * This function enters the extension into the exp_extensions table
	 *
	 * @see http://codeigniter.com/user_guide/database/index.html for
	 * more information on the db class.
	 *
	 * @return void
	 */
	public function activate_extension()
	{
		// Setup custom settings in this array.
		$this->settings = array();
		
		$data = array(
			'class'		=> __CLASS__,
			'method'	=> 'entry_submission_start',
			'hook'		=> 'entry_submission_start',
			'settings'	=> serialize($this->settings),
			'version'	=> $this->version,
			'enabled'	=> 'y'
		);

		$this->EE->db->insert('extensions', $data);			
		
	}	

	// ----------------------------------------------------------------------
	
	/**
	 * entry_submission_start
	 *
	 * @param 
	 * @return 
	 */
	public function entry_submission_start()
	{
		if (isset($this->EE->api_channel_entries->data['forum__forum_topic_id']) && $this->EE->api_channel_entries->data['forum__forum_topic_id'] === '0')
		{
			$this->EE->api_channel_entries->data['forum__forum_topic_id'] = '';
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * Disable Extension
	 *
	 * This method removes information from the exp_extensions table
	 *
	 * @return void
	 */
	function disable_extension()
	{
		$this->EE->db->where('class', __CLASS__);
		$this->EE->db->delete('extensions');
	}

	// ----------------------------------------------------------------------

	/**
	 * Update Extension
	 *
	 * This function performs any necessary db updates when the extension
	 * page is visited
	 *
	 * @return 	mixed	void on update / false if none
	 */
	function update_extension($current = '')
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
	}	
	
	// ----------------------------------------------------------------------
}

/* End of file ext.fix_forum_topic_id_bug.php */
/* Location: /system/expressionengine/third_party/fix_forum_topic_id_bug/ext.fix_forum_topic_id_bug.php */