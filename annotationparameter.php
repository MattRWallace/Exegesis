<?php

namespace Exegesis;

/**
 * AnnotationParameter
 *
 * @package Exegesis
 * @version 0.5
 * @copyright Copyright (c) 2010 Matt Wallace All rights reserved.
 * @author Matt Wallace <matthew.wallace@ieee.org>
 * @license PHP Version 3.0 {@link http://www.php.net/license/3_0.txt}
 */
class AnnotationParameter extends \ReflectionParameter {

    use Annotation;

    /**
     * Constructor
     *
     * @param mixed $function
     * @param mixed $parameter
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
     * AnnotationClass instance instead of a ReflectionClass instance.
     *
     * @access public
     * @return void
     */
    public function getClass() {
        return new AnnotationClass(parent::getClass()->getName());
    }

    /**
     * Wrapper function around ReflectionParameter::getDeclaringClass to return an
     * AnnotationClass instance instead of a ReflectionClass instance.
     *
     * @access public
     * @return void
     */
    public function getDeclaringClass() {
        return new AnnotationClass(parent::getDeclaringClass()->getName());
    }

    /**
     * Wrapper function around ReflectionParameter::getDeclaringFunction to
     * return an AnnotationMethod instance instead of a ReflectionMethod
     * instance.
     *
     * @access public
     * @return void
     */
    public function getDeclaringFunction() {
        return new AnnotationFunction(parent::getDeclaringFunction()->getName());
    }
}
