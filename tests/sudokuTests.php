<?php
// ./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/sudokuTests.php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class SudokuTests extends TestCase {

	public function testCanSolveSodoku() {

		include_once dirname( __FILE__ ) . '/../index.php';

		$data         = array(
			array( 6, 0, 0, 0, 3, 0, 0, 0, 0 ),
			array( 4, 0, 3, 8, 0, 5, 0, 0, 0 ),
			array( 0, 2, 8, 7, 0, 0, 0, 0, 0 ),
			array( 8, 0, 0, 0, 0, 4, 3, 6, 0 ),
			array( 0, 0, 0, 0, 2, 0, 0, 0, 0 ),
			array( 0, 3, 4, 6, 0, 0, 0, 0, 1 ),
			array( 0, 0, 0, 0, 0, 3, 6, 5, 0 ),
			array( 0, 0, 0, 5, 0, 8, 7, 0, 2 ),
			array( 0, 0, 0, 0, 1, 0, 0, 0, 9 ),
		);
		$sudokuSolver = new SudokuSolver( $data );
		$sudokuSolver->solveSudoku();
		$result = $sudokuSolver->getSolvedSudoku(); // solve function here.
		$match  = array(
			array( 6, 5, 7, 4, 3, 2, 1, 9, 8 ),
			array( 4, 1, 3, 8, 9, 5, 2, 7, 6 ),
			array( 9, 2, 8, 7, 6, 1, 5, 4, 3 ),
			array( 8, 9, 2, 1, 5, 4, 3, 6, 7 ),
			array( 1, 7, 6, 3, 2, 9, 4, 8, 5 ),
			array( 5, 3, 4, 6, 8, 7, 9, 2, 1 ),
			array( 2, 8, 1, 9, 7, 3, 6, 5, 4 ),
			array( 3, 6, 9, 5, 4, 8, 7, 1, 2 ),
			array( 7, 4, 5, 2, 1, 6, 8, 3, 9 ),
		);
		$this->assertSame( $result, $match );
	}
}
