<?php

namespace MattRWallace\Exegesis;

/**
 * AnnotationParameter
 *
 * @package Exegesis
 * @version 0.7 (Beta 2)
 * @copyright Copyright (c) 2012 Matt Wallace All rights reserved.
 * @author Matt Wallace <matthew.wallace@ieee.org>
 * @license http://www.opensource.org/licenses/mit-license.html MIT Public License.
 */
class AnnotationParameter extends \ReflectionParameter {

    use Annotation;

    /**
     * Constructor
     *
     * @param string $function Name of the function to reflect parameters from
     * @param string $parameter The name of the parameter
     * @access public
     * @return void
     */
    public function __construct($function, $parameter) {
        parent::__construct($function, $parameter);

        $parser = new AnnotationParser($this->getDocComment());
        $this->annotations = $parser->getAnnotationArray();
    }

    /**
     * Wrapper function around ReflectionParameter::getClass to return an
     * AnnotationClass object instead of a ReflectionClass object.
     *
     * @access public
     * @return void
     */
    public function getClass() {
        return new AnnotationClass(parent::getClass());
    }

    /**
     * Wrapper function around ReflectionParameter::getDeclaringClass to return an
     * AnnotationClass object instead of a ReflectionClass object.
     *
     * @access public
     * @return void
     */
    public function getDeclaringClass() {
        return new AnnotationClass(parent::getDeclaringClass());
    }

    /**
     * Wrapper function around ReflectionParameter::getDeclaringFunction to
     * return an AnnotationMethod object instead of a ReflectionMethod
     * object.
     *
     * @access public
     * @return void
     */
    public function getDeclaringFunction() {
        return new AnnotationFunction(parent::getDeclaringFunction()->getName());
    }
}
