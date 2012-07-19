<?php

namespace Exegesis;

/**
 * Wrapper around the ReflectionClass class that provides the extra
 * functionality to pull annotated information out of documentation blocks
 * while still allowing all the functionality of the extended class.
 *
 * @package Exegesis
 * @version 0.5
 * @copyright Copyright (c) 2010 Matt Wallace All rights reserved.
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
	 * @param string $class
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
	 * instance of the constructor instead of a ReflectionMethod instance.
     *
     * @link http://www.php.net/manual/en/class.reflectionmethod.php See \ReflectionMethod
     *
	 * @access public
	 * @return AnnotationMethod Returns an AnnotationMethod object reflecting the class' constructor.
	 */
	public function getConstructor() {
		return new AnnotationMethod($this->getName(), parent::getConstructor()->getName());
    }

    /**
     * Wraps ReflectionClass::getInterfaces() to return an array of
     * AnnotationClass instances instead of an array of ReflectionClass
     * instances.
     *
     * @access public
     * @return array An associative array of interfaces, with keys as interface names and the array values as AnnotationClass objects.
     */
    public function getInterfaces() {
        return array_map(function ($object) { return new AnnotationClass($object->getName()); }, parent::getInterfaces());
    }

	/**
	 * Wraps ReflectionClass::getMethod to return an AnnotationMethod instance
     * of the requested method instead of a ReflectionMethod instance.
     *
     * @link http://www.php.net/manual/en/class.reflectionmethod.php See \ReflectionMethod
	 *
	 * @param mixed $name The method name to reflect.
	 * @access public
	 * @return AnnotationMethod An AnnotationMethod object representing the requested method.
	 */
	public function getMethod($name) {
		return new AnnotationMethod($this->getName(), parent::getMethod($name)->getName());
	}

	/**
	 * Wraps ReflectionClass::getMethods to return an array of AnnotationMethod
	 * instances instead of an array of ReflectionMethod instances.
	 *
     * @link http://www.php.net/manual/en/class.reflectionmethod.php See \ReflectionMethod
     * @link Exegesis
     * @link
     * http://www.php.net/manual/en/class.reflectionproperty.php#reflectionproperty.constants.modifiers Valid filter values
     *
	 * @param mixed $filter Filter the results to include only methods with
     * certain attributes. Defaults to no filtering.
	 * @access public
	 * @return array Returns an array of AnnotationMethod objects reflecting each method.
	 */
	public function getMethods($filter) {
        return array_map(function($object) { return new AnnotationMethod($this->getName(), $object->getName()); }, parent::getMethods($filter));
	}

	/**
	 * Wraps ReflectionClass::getParentClass to return an AnnotationClass
	 * instance instead of a ReflectionClass instance.
	 *
	 * @access public
	 * @return AnnotationClass A AnnotationClass object representing the parent class of the invoking object.
	 */
	public function getParentClass() {
		return new AnnotationClass(parent::getParentClass()->getName());
    }

    /**
     * Wraps ReflectionClass::getProperties to return an array of
     * AnnotationProperty instances instead of an array of ReflectionProperty
     * instances.
     *
     * @link http://www.php.net/manual/en/class.reflectionproperty.php#reflectionproperty.constants.modifiers ReflectionProperty constants
     *
     * @param mixed $filter The optional filter, for filtering desired property types.
     * @access public
     * @return array An array of {@link AnnotationProperty} objects.
     */
    public function getProperties($filter) {
        return array_map(function ($object) { return new AnnotationProperty($this->getName(), $object->getName()); }, parent::getProperties($filter));
    }

    /**
     * Wraps ReflectionClass::getProperty to return an an AnnotationProperty
     * instance instead of a ReflectionProperty instance.
     *
     * @param mixed $name The property name.
     * @access public
     * @return void A AnnotationProperty object representing the requested property.
     */
    public function getProperty($name) {
        return new AnnotationProperty($this->getName(), $name);
    }

    /**
     * Wraps ReflectionClass::getTraits to return an AnnotationClass instance
     * instead of a ReflectionClass instance.
     *
     * @access public
     * @return array Returns an array with trait names in keys and instances of trait's AnnotationClass in values. Returns NULL in case of an error.
     */
    public function getTraits() {
        if($traits = parent::getTraits())
            return array_map(function ($object) { return new AnnotationClass($object->getName()); }, $traits);
        return null;
    }
}
