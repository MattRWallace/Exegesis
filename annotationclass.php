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
 * @license PHP Version 3.0 {@link http://www.php.net/license/3_0.txt}
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
	 * @access public
	 * @return AnnotationMethod Returns an {@link AnnotationMethod} object reflecting the class' constructor.
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
     * @return AnnotationClass An associative array of interfaces, with keys as interface names and the array values as {@link AnnotationClass} objects.
     */
    public function getInterfaces() {
        return array_map(function ($object) { return new AnnotationClass($object->getName()); }, parent::getInterfaces());
    }

	/**
	 * Wraps ReflectionClass::getMethod to return an AnnotationMethod instance
	 * of the requested method instead of a ReflectionMethod instance.
	 *
	 * @param mixed $name The method name to reflect.
	 * @access public
	 * @return AnnotationMethod A {@link AnnotationMethod} object representing the requested method.
	 */
	public function getMethod($name) {
		return new AnnotationMethod($this->getName(), parent::getMethod($name)->getName());
	}

	/**
	 * Wraps ReflectionClass::getMethods to return an array of AnnotationMethod
	 * instances instead of an array of ReflectionMethod instances.
	 *
	 * @param mixed $filter Filter the results to include only methods with
     * certain attributes. Defaults to no filtering.
	 * @access public
	 * @return array Returns an array of {@link AnnotationMethod} objects reflecting each method.
	 */
	public function getMethods($filter) {
        return array_map(function($object) { return new AnnotationMethod($this->getName(), $object->getName()); }, parent::getMethods($filter));
	}

	/**
	 * Wraps ReflectionClass::getParentClass to return an AnnotationClass
	 * instance instead of a ReflectionClass instance.
	 *
	 * @access public
	 * @return AnnotationClass A {@link AnnotationClass} object representing the parent class of the invoking object.
	 */
	public function getParentClass() {
		return new AnnotationClass(parent::getParentClass()->getName());
    }

    /**
     * Wraps ReflectionClass::getProperties to return an array of
     * AnnotationProperty instances instead of an array of ReflectionProperty
     * instances.
     *
     * @param mixed $filter The optional filter, for filtering desired property types. It's configured using the {@link http://www.php.net/manual/en/class.reflectionproperty.php#reflectionproperty.constants.modifiers ReflectionProperty constants}, and defaults to all property types.
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
     * @return void A {@link AnnotationProperty} object representing the requested property.
     */
    public function getProperty($name) {
        return new AnnotationProperty($this->getName(), $name);
    }

    /**
     * Wraps ReflectionClass::getTraits to return an AnnotationClass instance
     * instead of a ReflectionClass instance.
     *
     * @access public
     * @return array Returns an array with trait names in keys and instances of trait's {@link AnnotationClass} in values. Returns NULL in case of an error.
     */
    public function getTraits() {
        if($traits = parent::getTraits())
            return array_map(function ($object) { return new AnnotationClass($object->getName()); }, $traits);
        return null;
    }
}
