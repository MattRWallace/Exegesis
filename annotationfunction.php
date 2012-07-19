<?php

namespace Exegesis;

class AnnotationFunction extends \ReflectionFunction {

    use Annotation;

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
