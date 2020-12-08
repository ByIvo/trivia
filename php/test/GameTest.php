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
		$game->wasCorrectlyAnswered();
		$game->wasCorrectlyAnswered();
		$game->wasCorrectlyAnswered();
		$game->wasCorrectlyAnswered();
		$game->wasCorrectlyAnswered();
		$game->wasCorrectlyAnswered();
		$game->wasCorrectlyAnswered();
		$game->wasCorrectlyAnswered();
		$game->wasCorrectlyAnswered();
		$game->wasCorrectlyAnswered();
		$game->wasCorrectlyAnswered();
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

	/** @test */
	public function shouldLeaveJailAfterRollingAnOddNumber(): void {
		$game = new Game();
		$game->add('first player');
		$game->add('second player');

		// first player rolls the dice
		$game->roll(3);
		$game->wrongAnswer();

		Assert::assertTrue($firstPlayerIsInJail = $game->inPenaltyBox[0]);

		// second player rolls the dice
		$game->roll(3);
		$game->wasCorrectlyAnswered();

		// first player rolls the dice, takes an odd result and leaves the jail
		$game->roll(5);
		$game->wasCorrectlyAnswered();

		Assert::assertFalse($firstPlayerIsInJail = $game->inPenaltyBox[0]);
	}

    /** @test */
    public function shouldNotLeaveJailAfterRollingAnEvenNumber(): void {
        $game = new Game();
        $game->add('first player');
        $game->add('second player');

        // first player rolls the dice and answers it wrongly
        $game->roll(3);
        $game->wrongAnswer();

        Assert::assertTrue($firstPlayerIsInJail = $game->inPenaltyBox[0]);

        // second player rolls the dice
        $game->roll(3);
        $game->wasCorrectlyAnswered();

        // first player rolls the dice, takes an even result and does not leave the jail
        $game->roll(2);

        Assert::assertTrue($firstPlayerIsInJail = $game->inPenaltyBox[0]);
    }
}
