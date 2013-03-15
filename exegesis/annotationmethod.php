<?php

namespace Exegesis;

/**
 * Wrapper around the ReflectionMethod class that provides the extra
 * functionality to pull annotated information out of the documentation blocks
 * while still allowing access to all the functionality of the class being
 * extended.
 *
 * @package Exegesis
 * @version 0.7 (Beta 2)
 * @copyright Copyright (c) 2012 Matt Wallace All rights reserved.
 * @author Matt Wallace <matthew.wallace@ieee.org>
 * @license http://www.opensource.org/licenses/mit-license.html MIT Public License.
 * @link http://www.php.net/manual/en/class.reflectionmethod.php See
 * \ReflectionMethod
 */
class AnnotationMethod extends \ReflectionMethod {

    use Annotation;
    use AnnotationFunctionTrait;

	/**
	 * Constructor
	 *
     * @param mixed $class Classname or object (object of the class) that contains the method.
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

    /**
     * Wraps ReflectionMethod::getDeclaringClass to return an AnnotationClass
     * object instead of a ReflectionClass object.
     *
     * @access public
     * @return AnnotationClass An AnnotationClass object of the class that the reflected method is part of.
     */
	public function getDeclaringClass() {
		return new AnnotationClass(parent::getDeclaringClass());
	}

    /**
     * Wraps ReflectionMethod::getPrototype to return an AnnotationMethod
     * object instead of a ReflectionMethod object.
     *
     * @access public
     * @return AnnotationMethod An AnnotationMethod object of the method prototype.
     */
	public function getPrototype() {
		$prototype = parent::getPrototype();

        return new AnnotationMethod($prototype->getDeclaringClass(), $prototype->getName());
    }
}
