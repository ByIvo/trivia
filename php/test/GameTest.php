<?php

namespace Test\Trivia;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Trivia\Game;

class GameTest extends TestCase {

	/** @test */
	public function shouldWinAGame_WhenAnsweringCorrectlyForSixTimes(): void {
		$game = new Game();
		$game->add('Ivo');

		$game->roll("6");
		echo $game->wasCorrectlyAnswered();
		echo $game->wasCorrectlyAnswered();
		echo $game->wasCorrectlyAnswered();
		echo $game->wasCorrectlyAnswered();
		echo $game->wasCorrectlyAnswered();
		$winner = $game->wasCorrectlyAnswered();

		//When answering correctly, the false is only returned when the game is over.
		Assert::assertFalse($winner);
	}
}
