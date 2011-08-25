<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Admin Template Controller
 *
 * @package     Admin
 * @category    Base
 * @author      Kyle Treubig
 * @copyright   (c) 2010 Kyle Treubig
 * @license     MIT
 */
abstract class Controller_Template_Admin extends Controller_Template {

	/**
	 * @var Template file
	 */
	public $template = 'admin/themes/default/template';

	/**
	 * @var Admin configuration
	 */
	protected $_config;

	/**
	 * @var Current navigation item
	 */
	protected $_current_nav = NULL;

	/**
	 * Configure admin controller
	 */
	public function before() {
		parent::before();

		// Load admin config
		$this->_config = Kohana::config('admin');

		if ($this->auto_render)
		{
			// Prepare templates
			$this->template          = View::factory($this->_config['template'].'/template');
			$this->template->header  = View::factory($this->_config['template'].'/header');
			$this->template->menu    = View::factory($this->_config['template'].'/menu');
			$this->template->footer  = View::factory($this->_config['template'].'/footer');
			$this->template->content = '';

			// Bind menu items
			$this->template->menu->bind('links', $this->_config['menu']);
			$this->template->menu->bind('sublinks', $this->_config['submenu'][$this->_current_nav]);

			// Prepare media arrays
			$this->template->set_global('styles', array());
			$this->template->set_global('scripts', array());
		}
	}

	/**
	 * Unset current navigation item
	 */
	public function after() {
		$key = array_search($this->_current_nav, $this->_config['menu']);
		if ($key)
		{
			$this->_config['menu'][$key] = NULL;
		}

		// If a submenu is defined
		if(isset($this->_config['submenu'][$this->_current_nav]))
		{
			// Unset current action sublink
			$key = array_search($this->request->action, $this->_config['submenu'][$this->_current_nav]);
			if($key === FALSE)
			{
				// Match controler and action
				$key = array_search($this->request->controller."/".$this->request->action, $this->_config['submenu'][$this->_current_nav]);
				if($key === FALSE)
				{
					// Match controler only (if a submenu belong to many actions)
					$key = array_search($this->request->controller, $this->_config['submenu'][$this->_current_nav]);
				}
			}

			if($key)
			{
				$this->_config['submenu'][$this->_current_nav][$key] = NULL;
			}

			// Prepend current navigation path to all menu's actions
			foreach($this->_config['submenu'][$this->_current_nav] as $key => $action)
			{
				if(!empty($action))
					$this->_config['submenu'][$this->_current_nav][$key] = $this->_current_nav.'/'.$action;
			}
		}

		parent::after();
	}

}	// End of Controller_Template_Admin

