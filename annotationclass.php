<?php

namespace Exegesis;

/**
 * Class to access custom annotations in the phpdoc blocks of class methods
 *
 * @author Matt Wallace <matt@cs.txstate.edu>
 * @package Service\Annotation
 */
class AnnotationClass extends \ReflectionClass {

	use Annotation;

	/**
	 * Constructor
	 *
	 * @param \ReflectionClass $class
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
	 * @return AnnotationMethod
	 */
	public function getConstructor() {
		return new AnnotationMethod($this->getName(), parent::getConstructor()->getName());
	}

	/**
	 * Wraps ReflectionClass::getMethod to return an AnnotationMethod instance
	 * of the requested method instead of a ReflectionMethod instance.
	 *
	 * @param mixed $name
	 * @access public
	 * @return ReflectionMethod
	 */
	public function getMethod($name) {
		return new AnnotationMethod($this->getName(), parent::getMethod($name)->getName());
	}

	/**
	 * Wraps ReflectionClass::getMethods to return an array of AnnotationMethod
	 * instances instead of an array of ReflectionMethod instances.
	 *
	 * @param mixed $filter
	 * @access public
	 * @return array
	 */
	public function getMethods($filter) {
		$annotationMethods = [];

		foreach (parent::getMethods($filter) as $method)
			$annotationMethods[] = new AnnotationMethod($this->getName(), $method->getName());

		return $annotationMethods;
	}

	/**
	 * Wraps ReflectionClass::getParentClass to return an AnnotationClass
	 * instance instead of a ReflectionClass instance.
	 *
	 * @param mixed $name
	 * @access public
	 * @return AnnotationClass
	 */
	public function getParentClass($name) {
		return new AnnotationClass(parent::getParentClass()->getName());
	}
}
