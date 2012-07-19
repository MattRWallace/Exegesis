<?php

namespace Exegesis;

/**
 * AnnotationObject
 *
 * @package Exegesis
 * @version 0.5
 * @copyright Copyright (c) 2010 Matt Wallace All rights reserved.
 * @author Matt Wallace <matthew.wallace@ieee.org>
 * @license http://www.opensource.org/licenses/mit-license.html MIT Public License.
 */
class AnnotationObject extends \ReflectionObject {

    use Annotation;

    /**
     * Constructor
     *
     * @param mixed $object
     * @access public
     * @return void
     */
    public function __construct($object) {
        parent::__construct($object);

        $parser = new AnnotationParser($this->getDocComment());
        $this->annotations = $parser->getAnnotationArray();
    }
}
