<?php

namespace Exegesis;

/**
 * Wrapper around the ReflectionClass class that provides the extra
 * functionality to pull annotated information out of documentation blocks
 * while still allowing access to all the functionality of the class being extended.
 *
 * @package Exegesis
 * @version 0.7 (Beta 2)
 * @copyright Copyright (c) 2012 Matt Wallace All rights reserved.
 * @author Matt Wallace <matthew.wallace@ieee.org>
 * @license http://www.opensource.org/licenses/mit-license.html MIT Public License.
 * @link http://www.php.net/manual/en/class.reflectionclass.php See \ReflectionClass
 *
 */
class AnnotationClass extends \ReflectionClass {

	use Annotation;

	/**
	 * Constructor
	 *
	 * @param mixed $class Either a string containing the name of the class to reflect, or an object.
	 * @access public
	 * @return void
	 */
	public function __construct($object) {
		parent::__construct($object);
		$parser = new AnnotationParser($this->getDocComment());
		$this->annotations = $parser->getAnnotationArray();
	}

	/**
	 * Wraps ReflectionClass::getConstructor to return an AnnotationMethod
	 * object of the constructor instead of a ReflectionMethod object.
	 *
	 * @link http://www.php.net/manual/en/class.reflectionmethod.php See \ReflectionMethod
	 *
	 * @access public
	 * @return AnnotationMethod Returns an AnnotationMethod object reflecting the class' constructor.
	 */
	public function getConstructor() {
		return new AnnotationMethod($this->getName(), '__construct');
	}

	/**
	 * Wraps ReflectionClass::getInterfaces() to return an array of
	 * AnnotationClass objects instead of an array of ReflectionClass
	 * objects.
	 *
	 * @access public
	 * @return array An associative array of interfaces, with keys as interface names and the array values as AnnotationClass objects.
	 */
	public function getInterfaces() {
		return array_map(function ($object) { return new AnnotationClass($object); }, parent::getInterfaces());
	}

	/**
	 * Wraps ReflectionClass::getMethod to return an AnnotationMethod object
	 * of the requested method instead of a ReflectionMethod object.
	 *
	 * @link http://www.php.net/manual/en/class.reflectionmethod.php See \ReflectionMethod
	 *
	 * @param string $name The method name to reflect.
	 * @access public
	 * @return AnnotationMethod An AnnotationMethod object representing the requested method.
	 */
    public function getMethod($name) {
		return new AnnotationMethod($this->getName(), $name);
	}

	/**
	 * Wraps ReflectionClass::getMethods to return an array of AnnotationMethod
	 * objects instead of an array of ReflectionMethod objects.
	 *
	 * @link http://www.php.net/manual/en/class.reflectionmethod.php See \ReflectionMethod
	 * @link Exegesis.AnnotationMethod.html See \Exegesis\AnnotationMethod
	 * @link http://www.php.net/manual/en/class.reflectionproperty.php#reflectionproperty.constants.modifiers Valid filter values
	 *
	 * @param int $filter Filter the results to include only methods with
	 * certain attributes. Defaults to no filtering.
	 * @access public
	 * @return array Returns an array of AnnotationMethod objects reflecting each method.
	 */
	public function getMethods($filter = null) {
		return array_map(function($object) { return new AnnotationMethod($this->getName(), $object->getName()); }, parent::getMethods($filter));
	}

	/**
	 * Wraps ReflectionClass::getParentClass to return an AnnotationClass
	 * object instead of a ReflectionClass object.
	 *
	 * @access public
	 * @return AnnotationClass A AnnotationClass object representing the parent class of the invoking object.
	 */
    public function getParentClass() {
        return new AnnotationClass(parent::getParentClass());
	}

	/**
	 * Wraps ReflectionClass::getProperties to return an array of
	 * AnnotationProperty objects instead of an array of ReflectionProperty
	 * objects.
	 *
	 * @link http://www.php.net/manual/en/class.reflectionproperty.php#reflectionproperty.constants.modifiers Valid filter values
	 *
	 * @param mixed $filter The optional filter, for filtering desired property types.
	 * @access public
	 * @return array An array of {@link AnnotationProperty} objects.
	 */
	public function getProperties($filter = null) {
		return array_map(function ($object) { return new AnnotationProperty($this->getName(), $object->getName()); }, parent::getProperties($filter));
	}

	/**
	 * Wraps ReflectionClass::getProperty to return an an AnnotationProperty
	 * object instead of a ReflectionProperty object.
	 *
	 * @param string $name The name of the property to retrieve.
	 * @access public
	 * @return void A AnnotationProperty object representing the requested property.
	 */
	public function getProperty($name) {
		return new AnnotationProperty($this->getName(), $name);
	}

	/**
	 * Wraps ReflectionClass::getTraits to return an AnnotationClass object
	 * instead of a ReflectionClass object.
	 *
	 * @access public
	 * @return array Returns an array with trait names in keys and objects of trait's AnnotationClass in values. Returns NULL in case of an error.
	 */
	public function getTraits() {
		if($traits = parent::getTraits())
			return array_map(function ($object) { return new AnnotationClass($object); }, $traits);
		return null;
	}
}
