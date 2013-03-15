<?php
namespace TestClass;

/**
 * TestClass
 *
 * Test class doc block.  Needed for testing.
 */
class TestClass extends TestClassParent implements TestClassInterface {

    // properties
    public $publicProp;
    protected $protectedProp;
    private $privateProp;

    // property with default property
    public $defaultProp = 'default value';

    // constant
    const A_CONSTANT = 'constant';

    public function __construct() {
    }

    public function publicFunc() {
    }

    protected function protectedFunc() {
    }

    private function privateFunc() {
    }

}
