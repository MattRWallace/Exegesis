<?php

namespace Exegesis;

/**
 * This trait allows for overriding of methods defined in the
 * ReflectionFunctionAbstract class.  Since inheriting classes in PHP can
 * only extend one class (which in Exegesis will be the one that is being wrapped) using
 * this trait within each class that wraps a class that inherits from
 * ReflectionFunctionAbstract will override those functions at the level of the
 * inheriting class.
 *
 * @package Exegesis
 * @version 0.5
 * @copyright Copyright (c) 2010 Matt Wallace All rights reserved.
 * @author Matt Wallace <matthew.wallace@ieee.org>
 * @license http://www.opensource.org/licenses/mit-license.html MIT Public License.
 */
trait AnnotationClassTrait {

    /**
     * Wrapper function around ReflectionFunctionAbstract::getParameters which
     * returns an array of AnnotationParamater instances instead of an array of
     * RelfectionParameter instances.
     *
     * The override occurs at the level of the inheriting class so any
     * annotation wrapper class
     *
     * @access public
     * @return void
     */
    public function getParameters() {
        array_map(function ($object) { return new AnnotationParameter($this->getName(), $object->getName()); } , parent::getParameters());
    }
}
