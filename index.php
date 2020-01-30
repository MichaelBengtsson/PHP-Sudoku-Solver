<?php
/**
 * A Sudoku solver based on and inspired by https://github.com/techwithtim/Sudoku-GUI-Solver with some minor changes.
 * But mainly converted to PHP to see if i could make it work and understand the logic.
 *
 * To use: Pass a 2D array of the Sudoku puzzle to the class constructor, then run the solveSudoku function on that.
 * Each array in the array is a row, with 9 values for each of the slots in the puzzle.
 * Pass the number in the puzzle or 0 for an empty slot.
 *
 * Example used in the test looks like this:
 * array(
 *      array( 6, 0, 0, 0, 3, 0, 0, 0, 0 ),
 *      array( 4, 0, 3, 8, 0, 5, 0, 0, 0 ),
 *      array( 0, 2, 8, 7, 0, 0, 0, 0, 0 ),
 *      array( 8, 0, 0, 0, 0, 4, 3, 6, 0 ),
 *      array( 0, 0, 0, 0, 2, 0, 0, 0, 0 ),
 *      array( 0, 3, 4, 6, 0, 0, 0, 0, 1 ),
 *      array( 0, 0, 0, 0, 0, 3, 6, 5, 0 ),
 *      array( 0, 0, 0, 5, 0, 8, 7, 0, 2 ),
 *      array( 0, 0, 0, 0, 1, 0, 0, 0, 9 ),
 *  );
 */
class SudokuSolver {
	private $unSolvedSudoku = array();

	private $solvedSudoku = array();

	public function __construct( $unSolvedSudoku ) {
		$this->setUnSolvedSudoku( $unSolvedSudoku );
	}

	/**
	 * Solves the sudoku thats been set.
	 *
	 * @return bool
	 */
	public function solveSudoku() {
		$empty = $this->findEmpty( $this->unSolvedSudoku );
		if ( ! $empty ) {
			$this->setSolvedSudoku( $this->unSolvedSudoku );
			return true;
		}
		foreach ( range( 1, 9 ) as $i ) {
			if ( $this->checkValidity( $empty, $i ) ) {
				$this->unSolvedSudoku[ $empty['row'] ][ $empty['col'] ] = $i;
				if ( $this->solveSudoku() ) {
					return true;
				}
				$this->unSolvedSudoku[ $empty['row'] ][ $empty['col'] ] = 0;
			}
		}
		return false;
	}

	/**
	 * Finds the first unsolved spot in the array.
	 *
	 * @param array $unSolvedSudoku
	 * @return mixed
	 */
	private function findEmpty( $unSolvedSudoku ) {
		foreach ( $unSolvedSudoku as $rowNr => $row ) {
			foreach ( $row as $colNr => $number ) {
				if ( $number === 0 ) {
					return array(
						'row' => $rowNr,
						'col' => $colNr,
						'num' => $number,
					);
				}
			}
		}
		return false;
	}

	/**
	 * Checks the validity of the number passed.
	 *
	 * @param array $empty
	 * @param int   $i
	 * @return bool
	 */
	private function checkValidity( $empty, $i ) {
		$row_nr = $empty['row'];
		$col_nr = $empty['col'];

		// Check if row has the same number.
		$unSolvedRow = $this->unSolvedSudoku[ $row_nr ];
		$rowCheck    = array_search( $i, $unSolvedRow );
		if ( $rowCheck !== false ) {
			return false;
		}
		// Check if the column has the same number.
		foreach ( $this->unSolvedSudoku as $row ) {
			if ( $i === $row[ $col_nr ] ) {
				return false;
			}
		}
		// Check if the "box" has the same number.
		$box_row = floor( $row_nr / 3 );
		$box_col = floor( $col_nr / 3 );
		foreach ( range( $box_row * 3, $box_row * 3 + 2 ) as $row_target ) {
			foreach ( range( $box_col * 3, $box_col * 3 + 2 ) as $col_target ) {
				if ( $this->unSolvedSudoku[ $row_target ][ $col_target ] === $i ) {
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Sets the unsolved sudoku.
	 *
	 * @param array $sudoku
	 * @return void
	 */
	public function setUnSolvedSudoku( $unSolvedSudoku = array() ) {
		$this->unSolvedSudoku = $unSolvedSudoku;
	}

	/**
	 * Gets the unsolved sudoku.
	 *
	 * @return array
	 */
	public function getUnSolvedSudoku() {
		return $this->unSolvedSudoku;
	}

	/**
	 * Sets the solved sudoku.
	 *
	 * @param array $solvedSudoku
	 * @return void
	 */
	public function setSolvedSudoku( $solvedSudoku = array() ) {
		$this->solvedSudoku = $solvedSudoku;
	}

	/**
	 * Gets the solved sudoku.
	 *
	 * @return array
	 */
	public function getSolvedSudoku() {
		return $this->solvedSudoku;
	}
}
