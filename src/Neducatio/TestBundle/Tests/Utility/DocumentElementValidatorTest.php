<?php

namespace Neducatio\TestBundle\Tests\Utility;

use \Neducatio\TestBundle\Utility\DocumentElementValidator;

use \Mockery as m;

/**
 * Do sth.
 *
 * @covers Neducatio\TestBundle\Utility\DocumentElementValidator
 * @covers Neducatio\TestBundle\Utility\Validator
 */
class DocumentElementValidatorTest extends \PHPUnit_Framework_TestCase
{
  /**
   * Do sth.
   */
  public function tearDown()
  {
    m::close();
  }

  /**
   * Do sth
   *
   * @test
   */
  public function __construct_shouldCreateInstanceOf()
  {
    $this->assertInstanceOf('\Neducatio\TestBundle\Utility\DocumentElementValidator', $this->getValidator());
  }

  /**
   * Do sth.
   *
   * @test
   * @expectedException \Neducatio\TestBundle\PageObject\InvalidPageException
   */
  public function validate_pageWithoutProofSelectors_shouldThrowException()
  {
    $page = $this->getDocumentElement(array());
    $this->getValidator()->validate($page, 'any-selector');
  }

  /**
   * Do sth.
   *
   * @test
   * @expectedException \Neducatio\TestBundle\PageObject\InvalidPageException
   */
  public function validate_pageWithInvisibleProofSelectors_shouldThrowException()
  {
    $proofSelectors = array($this->getNodeElement(false));
    $page = $this->getDocumentElement($proofSelectors);
    $this->getValidator()->validate($page, 'any-selector', true);
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function validate_pageWithEndingHtmlTagAndProofSelector_should()
  {
    $page = $this->getDocumentElement();
    $this->getValidator()->validate($page, 'any-selector');
  }

  /**
   * Do sth.
   *
   * @test
   */
  public function validate_pageWithVisibleProofSelectors_shouldCreateInstance()
  {
    $page = $this->getDocumentElement();
    $this->getValidator()->validate($page, 'any-selector', true);
  }

  /**
   * Gets node element
   *
   * @param bool $visiblity Vsibility of the node element
   *
   * @return NodeElement
   */
  private function getNodeElement($visiblity)
  {
    $node = m::mock('\Behat\Mink\Element\NodeElement');
    $node->shouldReceive('isVisible')->andReturn($visiblity);

    return $node;
  }

  /**
   * Gets document element
   * 
   * @param type $selectors Selectors
   * @param type $content   Content
   * 
   * @return type
   */
  private function getDocumentElement($selectors = null, $content = '</html>')
  {
    if ($selectors === null) {
      $selectors = array($this->getNodeElement(true));
    }

    $session = m::mock('\stdClass');
    $session->shouldReceive('wait');

    $page = m::mock('\Behat\Mink\Element\DocumentElement');
    $page->shouldReceive('findAll')->andReturn($selectors);
    $page->shouldReceive('getContent')->andReturn($content);
    $page->shouldReceive('getSession')->andReturn($session);

    return $page;
  }

  /**
   * Gets validator
   * 
   * @return DocumentElementValidator
   */
  private function getValidator()
  {
    return new DocumentElementValidator();
  }
}