<?php

namespace MattRWallace\Annotation;

/**
 * Class to access custom annotations in the phpdoc blocks of class methods
 *
 * @author Matt Wallace <matt@cs.txstate.edu>
 * @package Service\Annotation
 */
class AnnotationMethod extends \ReflectionMethod {

	use Annotation;

	/**
	 * Constructor
	 *
	 * @param \ReflectionMethod $method
	 * @access public
	 * @return void
	 */
	public function __construct($class, $name) {
		parent::__construct($class, $name);
		// get the annotations
		$parser = new AnnotationParser($this->getDocComment());
		$this->annotations = $parser->getAnnotationArray();
	}

	public function getDeclaringClass() {
		return new AnnotationClass(parent::getDeclaringClass()->getName());
	}

	public function getPrototype() {
		$prototype = parent::getPrototype();

		return new AnnotationMethod($prototype->getDeclaringClass(), $prototype->getName());
	}
}
