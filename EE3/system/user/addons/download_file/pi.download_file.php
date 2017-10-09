<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Download File Plugin
*
* @package ExpressionEngine
* @subpackage Addons
* @category Plugin
* @author Blis Web Agency
* @link http://blis.net.au
*/

class Download_file {

	public $return_data;

	public function serve()
	{
		$restricted = ee()->TMPL->fetch_param('restricted');
		$prepend = ee()->TMPL->fetch_param('prepend');
		$remove_path = ee()->TMPL->fetch_param('remove_path');

		ee()->load->helper('download');
		ee()->load->library('encrypt');

		$totalsegs = ee()->uri->total_segments();
		$msg = ee()->uri->segment($totalsegs, 0);
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
		$file = ee()->TMPL->fetch_param('file');
		$template = ee()->TMPL->fetch_param('template');
		$remove = ee()->TMPL->fetch_param('remove');
		if ($remove) $file = str_replace($remove,"",$file);
		$encoded_data = base64_encode(serialize($file));
		$encoded_data = str_replace("=","_",$encoded_data);

		$url = $template . $encoded_data;

		return $url;
	}
}