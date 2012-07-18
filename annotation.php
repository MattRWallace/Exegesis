<?php

namespace MattRWallace\Annotation;

/**
 * Trait that contains shared functionality between the annotation class and
 * annotation method functionality.
 *
 * @author Matt Wallace <matt@cs.txstate.edu>
 * @package Service\Annotation
 */
trait Annotation {
	private $annotations;

	private static $parser = "\\Service\\Annotation\\DefaultParser";

	/**
	 * Allows the user to change the parser that will be used.  Allows for the
	 * user to code a custom parser to change the syntax of annotations that
	 * are allowed.
	 *
	 * @param string $parser
	 * @static
	 * @access public
	 * @return void
	 */
	public static function changeParser(string $parser) {
		$this->parser = $parser;
	}

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
