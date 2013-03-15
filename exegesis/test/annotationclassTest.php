<?php

namespace Test;

class AnnotationClassTest extends \PHPUnit_Framework_TestCase {
    protected $reflection;
    protected $annotation;

    public function setup() {
        $testClass = new TestClass();
        $this->reflection = new \ReflectionClass($testClass);
        $this->annotation = new \Exegesis\AnnotationClass($testClass);
    }

    public function testExport() {
        $result   = \Exegesis\AnnotationClass::export('Test\TestClass', true);
        $expected = \ReflectionClass::export('Test\TestClass', true);
        $this->assertEquals($result, $expected);
    }

    public function testGetConstant() {
        $result   = $this->annotation->getConstant('A_CONSTANT');
        $expected = $this->reflection->getConstant('A_CONSTANT');
        $this->assertEquals($result, $expected);
    }

    public function testGetConstants() {
        $result   = $this->annotation->getConstants();
        $expected = $this->reflection->getConstants();
        $this->assertEquals($result, $expected);
    }

    public function testGetDefaultProperties() {
        $result   = $this->annotation->getDefaultProperties();
        $expected = $this->reflection->getDefaultProperties();
        $this->assertEquals($result, $expected);
    }

    public function testGetDocComment() {
        $result   = $this->annotation->getDocComment();
        $expected = $this->reflection->getDocComment();
        $this->assertEquals($result, $expected);
    }

    public function testGetEndLine() {
        $result   = $this->annotation->getEndLine();
        $expected = $this->reflection->getEndLine();
        $this->assertEquals($result, $expected);
    }

    public function testGetExtension() {
        $result   = $this->annotation->getExtension();
        $expected = $this->reflection->getExtension();
        $this->assertEquals($result, $expected);
    }

    public function testGetExtensionName() {
        $result   = $this->annotation->getExtensionName();
        $expected = $this->reflection->getExtensionName();
        $this->assertEquals($result, $expected);
    }

    public function testGetFileName() {
        $result   = $this->annotation->getFileName();
        $expected = $this->reflection->getFileName();
        $this->assertEquals($result, $expected);
    }

    public function testGetInterfaceNames() {
        $result   = $this->annotation->getInterfaceNames();
        $expected = $this->reflection->getInterfaceNames();
        $this->assertEquals($result, $expected);
    }

    public function testGetInterfaces() {
        $result   = array_keys($this->annotation->getInterfaces());
        $expected = array_keys($this->reflection->getInterfaces());
        $this->assertEquals($result, $expected);
    }

    public function testGetMethod() {
        $result   = $this->annotation->getMethod('publicFunc');
        $expected = $this->reflection->getMethod('publicFunc');
        $this->assertEquals($result->getName(), $expected->getName());
        $this->assertEquals($result->getDeclaringClass(), $expected->getDeclaringClass());
    }

    public function testGetModifiers() {
        $result   = $this->annotation->getModifiers();
        $expected = $this->reflection->getModifiers();
        $this->assertEquals($result, $expected);
    }

    public function testGetName() {
        $result   = $this->annotation->getName();
        $expected = $this->reflection->getName();
        $this->assertEquals($result, $expected);
    }

    public function testGetNamespaceName() {
        $result   = $this->annotation->getNamespaceName();
        $expected = $this->reflection->getNamespaceName();
        $this->assertEquals($result, $expected);
    }

    public function testGetParentClass() {
        $result   = $this->annotation->getParentClass();
        $expected = $this->reflection->getParentClass();
        $this->assertEquals($result, $expected);
    }

    public function testGetProperties() {
        $result   = $this->annotation->getProperties();
        $expected = $this->reflection->getProperties();
        $this->assertEquals($result, $expected);
    }

    public function testGetProperty() {
        $result   = $this->annotation->getProperty('publicProp');
        $expected = $this->reflection->getProperty('publicProp');
        $this->assertEquals($result, $expected);
    }

    public function testGetSHortName() {
        $result   = $this->annotation->getShortName();
        $expected = $this->reflection->getShortName();
        $this->assertEquals($result, $expected);
    }
}

