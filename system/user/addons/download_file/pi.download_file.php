<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(PATH_THIRD . 'download_file/addon.setup.php');

/**
* ExpressionEngine - by EllisLab
*
* @package ExpressionEngine
* @author ExpressionEngine Dev Team
* @copyright Copyright (c) 2003 - 2011, EllisLab, Inc.
* @license http://expressionengine.com/user_guide/license.html
* @link http://expressionengine.com
* @since Version 2.0
* @filesource
*/

// ------------------------------------------------------------------------

/**
* Download File Plugin
*
* @package ExpressionEngine
* @subpackage Addons
* @category Plugin
* @author Blis Web Agency
* @link http://blis.net.au
*/

$plugin_info = array(
	'pi_name' => DOWNLOAD_FILE_NAME,
	'pi_version' => DOWNLOAD_FILE_VER,
	'pi_author' => DOWNLOAD_FILE_AUTHOR,
	'pi_author_url' => DOWNLOAD_FILE_AUTHOR_URL,
	'pi_description'=> DOWNLOAD_FILE_DESC,
	'pi_usage' => Download_file::usage()
);


class Download_file {

	public $return_data;

	/**
	* Constructor
	*/
	public function __construct()
	{
		$this->EE =& get_instance();
		$this->CI =& get_instance();
	}

	public function serve()
	{
		$restricted = $this->EE->TMPL->fetch_param('restricted');
		$prepend = $this->EE->TMPL->fetch_param('prepend');
		$remove_path = $this->EE->TMPL->fetch_param('remove_path');

		$this->CI->load->helper('download');
		$this->CI->load->library('encrypt');

		$totalsegs = $this->CI->uri->total_segments();
		$msg = $this->CI->uri->segment($totalsegs, 0);
		$msg = str_replace("_","=",$msg);
		$file = unserialize(base64_decode($msg));


		$data = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $file);
		$name = str_replace($remove_path,$prepend,$file);

		if ($restricted != ""){
		if (stristr($_SERVER['HTTP_REFERER'], $restricted)) force_download($name, $data);
		else header("Location: /");die;
		} else {
		force_download($name, $data);
		}

		return "";
	}

	public function link()
	{
		$file = $this->EE->TMPL->fetch_param('file');
		$template = $this->EE->TMPL->fetch_param('template');
		$remove = $this->EE->TMPL->fetch_param('remove');
		if ($remove) $file = str_replace($remove,"",$file);
		$encoded_data = base64_encode(serialize($file));
		$encoded_data = str_replace("=","_",$encoded_data);

		$url = $template . $encoded_data;

		return $url;
	}

	// ----------------------------------------------------------------

	/**
	* Plugin Usage
	*/
	public static function usage()
	{
		ob_start(); ?>
			This addon will serve a file as a file, not a page. This means PDF's will download automatically. It also goes some way in hiding where all these files live on your server.

			Step 1. Insert this in a template (e.g. /site/download/):
			{exp:download_file:serve restricted="mydomain.com" prepend="mysite_" remove_path="/assets/"}

			Note: only use the restricted parameter if you want to prevent hotlinking
			Note: only use the prepend parameter if you want to add a string to the front of the files you are serving
			Note: if you don't use "remove_path" the path to your files will be viewable within the filename

			Step 2. Bang this in your link:
			<a href="{exp:download_file:link file='/downloads/file.pdf' template='/site/download' remove='http://mydomain.com'}">Download</a>

			Note: The "remove" attribute allows you to remove something like a domain from your links. If your links include your domain name, you'll want to remove it or this won't work.
		<?php
			$buffer = ob_get_contents();
			ob_end_clean();

		return $buffer;
	}
}