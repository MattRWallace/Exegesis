<?php

namespace Exegesis;

/**
 * Trait that contains shared functionality between the annotation class and
 * annotation method functionality.
 *
 * @package Exegesis
 * @version 0.7 (Beta 2)
 * @copyright Copyright (c) 2012 Matt Wallace All rights reserved.
 * @author Matt Wallace <matthew.wallace@ieee.org>
 * @license http://www.opensource.org/licenses/mit-license.html MIT Public License.
 */
trait Annotation {
	private $annotations;

	/**
	 * Returns true or false if the specified annotation exists for this class
	 * or method
	 *
	 * @param string $annotation
	 * @access public
	 * @return void
	 */
	public function hasAnnotation($annotation) {
		return array_key_exists($annotation, $this->annotations);
	}

	/**
	 * Returns the value for a given annotation.
	 *
	 * @param string $annotation
	 * @access public
	 * @return void
	 */
	public function getAnnotationValue($annotation) {
		return $this->annotations[$annotation];
	}

	/**
	 * Returns an array of the parsed annotations.
	 *
	 * @access public
	 * @return void
	 */
	public function getAnnotations() {
		return $this->annotations;
	}
}
