<?php

namespace Game\Bundle\HangmanBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Game\Bundle\HangmanBundle\Game;

class GameControllerTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function tearDown()
    {
        $this->client = null;
    }

    public function testResetGame()
    {
        $crawler = $this->client->request('GET', '/game/hangman/?length=3');

        // Click letter P
        $letter = $crawler->selectLink('P')->link();
        $this->client->click($letter);
        $crawler = $this->client->followRedirect();
        $this->assertCount(2, $crawler->filter('.word_letters .guessed'));
        $this->assertCount(1, $crawler->filter('.word_letters .hidden'));

        // Click the reset link
        $reset = $crawler->selectLink('reset the game')->link();
        $this->client->click($reset);

        // Check the initial state
        $crawler = $this->client->followRedirect();
        $this->assertCount(0, $crawler->filter('.word_letters .guessed'));
        $this->assertCount(3, $crawler->filter('.word_letters .hidden'));
    }

    public function testGuessTheWord()
    {
        $crawler = $this->client->request('GET', '/game/hangman/?length=3');

        // Count the letters on the homepage
        $this->assertCount(0, $crawler->filter('.word_letters .guessed'));
        $this->assertCount(3, $crawler->filter('.word_letters .hidden'));

        // Click letter P
        $letter = $crawler->selectLink('P')->link();
        $this->client->click($letter);
        $crawler = $this->client->followRedirect();
        $this->assertCount(2, $crawler->filter('.word_letters .guessed'));
        $this->assertCount(1, $crawler->filter('.word_letters .hidden'));

        // Click letter H
        $letter = $crawler->selectLink('H')->link();
        $this->client->click($letter);

        // Check the game is won
        $crawler = $this->client->followRedirect();
        $response = $this->client->getResponse();
        $this->assertRegexp('#Congratulations, you found the word <strong>php<\/strong>#', $response->getContent());
    }

    public function testTryWord()
    {
        $crawler = $this->client->request('GET', '/game/hangman/?length=3');
        $form = $crawler->selectButton('Let me guess...')->form();
        $this->client->submit($form, array('word' => 'php'));
        $crawler = $this->client->followRedirect();

        // Check the game is won
        $response = $this->client->getResponse();
        $this->assertRegexp('#Congratulations, you found the word <strong>php<\/strong>#', $response->getContent());
    }

    public function testGameOverHanged()
    {
        $crawler = $this->client->request('GET', '/game/hangman/?length=3');
        $form = $crawler->selectButton('Let me guess...')->form();
        $this->client->submit($form, array('word' => 'foo'));
        $crawler = $this->client->followRedirect();

        $response = $this->client->getResponse();
        $this->assertRegexp("/Oops, you're hanged/", $response->getContent());
    }

    public function testGuessLetterAndGetHanged()
    {
        $crawler = $this->client->request('GET', '/game/hangman/?length=3');

        // Play the same letter until reaching the hanged status
        for ($i = 0; $i < Game::MAX_ATTEMPTS; $i++) {
            $letter = $crawler->selectLink('Z')->link();
            $this->client->click($letter);
            $this->client->followRedirect();
        }

        $response = $this->client->getResponse();
        $this->assertRegexp("/Oops, you're hanged/", $response->getContent());
    }

    public function testGuessLetterWithoutStartedGame()
    {
        $this->client->request('GET', '/game/hangman/letter/H');
        $this->assertTrue($this->client->getResponse()->isNotFound());
    }

    public function testGuessWordWithoutStartedGame()
    {
        $this->client->request('POST', '/game/hangman/word', array(
            'word' => 'php'
        ));

        $this->assertTrue($this->client->getResponse()->isNotFound());
    }
}
