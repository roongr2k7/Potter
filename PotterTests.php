<?php
require_once __DIR__ . '/Potter.php';

class PotterTests extends PHPUnit_Framework_TestCase {
  public $potter;

  protected function setUp() {
    $this->potter = new Potter();
  }

  public function testBasic() {
    $expect = 8;
    $actual = $this->potter->calculatePrice([0]);
    $this->assertEquals($expect, $actual); 
  }

  public function testSameBook() {
    $expect = 2 * 8;
    $actual = $this->potter->calculatePrice([0, 0]);
    $this->assertEquals($expect, $actual);
  }
 
  public function test2diffBook() {
    $expect = 2 * 8 * 0.95;
    $actual = $this->potter->calculatePrice([0, 1]);
    $this->assertEquals($expect, $actual);
  } 

  public function test3diffBook() {
    $expect = 3 * 8 * 0.90;
    $actual = $this->potter->calculatePrice([0, 1, 2]);
    $this->assertEquals($expect, $actual);
  } 

  public function test4diffBook() {
    $expect = 4 * 8 * 0.80;
    $actual = $this->potter->calculatePrice([0, 1, 2, 3]);
    $this->assertEquals($expect, $actual);
  } 

  public function test5diffBook() {
    $expect = 5 * 8 * 0.75;
    $actual = $this->potter->calculatePrice([0, 1, 2, 3, 4]);
    $this->assertEquals($expect, $actual);
  } 

  public function testGroupBooks() {
    $expect = [[1, 2], [2]];
    $actual = $this->potter->groupBooks([1, 2, 2]);
    $this->assertEquals($expect, $actual);
  } 
	public function testGroupBooksEdgecase() {
		$expect = 38;
		$group_books = [0, 1, 2, 3, 4, 0];
		$actual = $this->potter->chooseLowestPrice($group_books);
    $this->assertEquals($expect, $actual);
	}
	public function testChangeBooksBetweenGroup() {
		$group_books = [[0, 1, 2, 3, 4], [0, 2, 4]];
		$expect = [[0, 2, 3, 4], [0, 1, 2, 4]];
		$actual = $this->potter->changeBooksBetweenGroup($group_books);
    $this->assertEquals($expect, $actual);
  }
  public function testSumPrice() {
		$group_books = [[1, 2], [1, 2, 3]];
		$expect = 4.6 * 8;
		$actual = $this->potter->sumPrice($group_books);
    $this->assertEquals($expect, $actual);
	}
  public function testGroupBooksEdgeCase2() {
		$expect = 51.2;
		$group_books = [0, 0, 1, 1, 2, 2, 3, 4];
		$actual = $this->potter->chooseLowestPrice($group_books);
    $this->assertEquals($expect, $actual);
	}
}


