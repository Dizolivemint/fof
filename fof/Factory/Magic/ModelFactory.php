<?php
/**
 * @package     FOF
 * @copyright   2010-2015 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license     GNU GPL version 2 or later
 */

namespace FOF30\Factory\Magic;

use FOF30\Model\DataModel;
use FOF30\Factory\Exception\ModelNotFound;
use FOF30\Model\TreeModel;

defined('_JEXEC') or die;

/**
 * Creates a DataModel/TreeModel object instance based on the information provided by the fof.xml configuration file
 */
class ModelFactory extends BaseFactory
{
	/**
	 * Create a new object instance
	 *
	 * @param   string $name The name of the class we're making
	 *
	 * @return  TreeModel|DataModel  A new TreeModel or DataModel object
	 */
	public function make($name = null)
	{
		if (empty($name))
		{
			throw new ModelNotFound;
		}

		$appConfig = $this->container->appConfig;

		$config = array(
			'name'             => $name,
			'use_populate'     => $appConfig->get("views.$name.config.use_populate"),
			'ignore_request'   => $appConfig->get("views.$name.config.ignore_request"),
			'tableName'        => $appConfig->get("views.$name.config.tbl"),
			'idFieldName'      => $appConfig->get("views.$name.config.tbl_key"),
			'knownFields'      => $appConfig->get("views.$name.config.knownFields", null),
			'autoChecks'       => $appConfig->get("views.$name.config.autoChecks"),
			'contentType'      => $appConfig->get("views.$name.config.contentType"),
			'fieldsSkipChecks' => $appConfig->get("views.$name.config.fieldsSkipChecks", array()),
			'aliasFields'      => $appConfig->get("views.$name.field", array()),
			'behaviours'       => $appConfig->get("views.$name.behaviors", array()),
			'fillable_fields'  => $appConfig->get("views.$name.config.fillable_fields", array()),
			'guarded_fields'   => $appConfig->get("views.$name.config.guarded_fields", array()),
			'relations'        => $appConfig->get("views.$name.relations", array()),
		);

		try
		{
			// First try creating a TreeModel
			$model = new TreeModel($this->container, $config);
		}
		catch (DataModel\Exception\TreeIncompatibleTable $e)
		{
			// If the table isn't a nested set, create a regular DataModel
			$model = new DataModel($this->container, $config);
		}

		return $model;
	}
}