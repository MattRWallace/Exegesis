<?php

namespace Exegesis;

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
