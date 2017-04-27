<?php
/**
 * @package     FOF
 * @copyright   2010-2017 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license     GNU GPL version 2 or later
 */

namespace FOF30\Factory\Exception;

use Exception;
use RuntimeException;

defined('_JEXEC') or die;

class ViewNotFound extends RuntimeException
{
	public function __construct( $viewClass, $code = 500, Exception $previous = null )
	{
		$message = \JText::sprintf('LIB_FOF_VIEW_ERR_NOT_FOUND', $viewClass);

		parent::__construct( $message, $code, $previous );
	}

}