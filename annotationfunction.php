<?php

namespace MattRWallace\Exegesis;

/**
 * AnnotationFunction
 *
 * @package Exegesis
 * @version 0.7 (Beta 2)
 * @copyright Copyright (c) 2012 Matt Wallace All rights reserved.
 * @author Matt Wallace <matthew.wallace@ieee.org>
 * @license http://www.opensource.org/licenses/mit-license.html MIT Public License.
 */
class AnnotationFunction extends \ReflectionFunction {

    use Annotation;
    use AnnotationFunctionTrait;

    /**
     * Constructor
     *
     * @param string $name
     * @access public
     * @return void
     */
    public function __construct($name) {
        parent::__construct($name);

        // get the annotations
        $parser = new AnnotationParser($this->getDocComment());
        $this->annotations = $parser->getAnnotationArray();
    }
}
