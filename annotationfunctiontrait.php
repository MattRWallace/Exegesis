<?php

namespace Exegesis;

/**
 * Trait that contains overriden versions of the methods from the
 * ReflectionFunctionAbstract class.  Any annotation class that extends a
 * Reflection class which extends ReflectionFunctionAbstract can use this trait
 * to get overridden versions of those inherited functions.
 *
 * @package Exegesis
 * @version 0.7 (Beta 2)
 * @copyright Copyright (c) 2010 Matt Wallace All rights reserved.
 * @author Matt Wallace <matthew.wallace@ieee.org>
 * @license http://www.opensource.org/licenses/mit-license.html MIT Public License.
 */
trait AnnotationFunctionTrait {
    public function getParameters() {
        array_map(function($object) { return new AnnotationParameter($this, $object->getName()); }, parent::getParameters());
    }
}
