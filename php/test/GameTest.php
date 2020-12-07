<?php

namespace Test\Trivia;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Trivia\Game;
use Trivia\NotEnoughPlayersException;
use Trivia\TooManyPlayersException;

class GameTest extends TestCase {

	/** @test */
	public function shouldWinAGame_WhenAnsweringCorrectlyForSixTimes(): void {
		$game = new Game();
		$game->add('Ivo');
		$game->add('Renata');

		$game->roll("6");
		echo $game->wasCorrectlyAnswered();
		echo $game->wasCorrectlyAnswered();
		echo $game->wasCorrectlyAnswered();
		echo $game->wasCorrectlyAnswered();
		echo $game->wasCorrectlyAnswered();
		echo $game->wasCorrectlyAnswered();
		echo $game->wasCorrectlyAnswered();
		echo $game->wasCorrectlyAnswered();
		echo $game->wasCorrectlyAnswered();
		echo $game->wasCorrectlyAnswered();
		echo $game->wasCorrectlyAnswered();
		$winner = $game->wasCorrectlyAnswered();

		//When answering correctly, the false is only returned when the game is over.
		Assert::assertFalse($winner);
	}

	/** @test */
	public function shouldNotAllowPlaying_WhenHavingLessThanTwoPlayers(): void {
		$game = new Game();
		$game->add('Ivo');

		$this->expectException(NotEnoughPlayersException::class);
		$game->roll("6");
	}

	/** @test */
	public function shouldNotAllowPlaying_WhenHavingMoreThanSixPlayers(): void {
		$game = new Game();
		$game->add('first player');
		$game->add('second player');
		$game->add('third player');
		$game->add('fourth player');
		$game->add('fifth player');
		$game->add('sixth player');

		$this->expectException(TooManyPlayersException::class);
		$game->add('seventh player');
	}
}
