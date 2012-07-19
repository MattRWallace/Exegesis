<?php

namespace Exegesis;

/**
 * Class to access custom annotations in the phpdoc blocks of class methods
 *
 * @package Exegesis
 * @version 0.5
 * @copyright Copyright (c) 2012 Matt Wallace All rights reserved.
 * @author Matt Wallace <matthew.wallace@ieee.org>
 * @license http://www.opensource.org/licenses/mit-license.html MIT Public License.
 */
class AnnotationMethod extends \ReflectionMethod {

	use Annotation;

	/**
	 * Constructor
	 *
     * @param string $class Name of the class the method belongs to
     * @param string $name Name of the method
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
