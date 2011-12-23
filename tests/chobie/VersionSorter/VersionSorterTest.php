<?php
require_once dirname(dirname(dirname(__DIR__))) ."/src/chobie/VersionSorter.php";

class VersionSorterTest extends PHPUnit_Framework_TestCase{
  protected static $versions = array("1.0.9","1.0.10","1.10.1","yui3-999","2.0","1.9.1","yui3-990","3.1.4.2","1.0.9a");
  protected static $expected = array("1.0.9","1.0.9a","1.0.10","1.9.1","1.10.1","2.0","3.1.4.2","yui3-990","yui3-999");

  public function test_sorts_verisons_correctly(){
    $this->assertEquals(self::$expected, chobie\VersionSorter::sort(self::$versions));
  }
  
  public function test_reverse_sorts_verisons_correctly(){
    $this->assertEquals(array_reverse(self::$expected), chobie\VersionSorter::rsort(self::$versions));
  }
}