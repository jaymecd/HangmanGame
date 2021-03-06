<?php

namespace Game\Bundle\HangmanBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameControllerTest extends WebTestCase
{
    /**
     * @var \Symfony\Component\BrowserKit\Client
     */
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
        $reset = $crawler->selectLink('Reset the game')->link();
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

        $crawler = $this->playLetter('P');
        $this->assertCount(2, $crawler->filter('.word_letters .guessed'));
        $this->assertCount(1, $crawler->filter('.word_letters .hidden'));

        $this->playLetter('H');

        $this->assertRegexp('#Congratulations, you found the word <strong>php<\/strong>#', $this->client->getResponse()->getContent());
    }

    /**
     * Clicks on a letter and returns the Crawler object.
     *
     * @param string $letter The letter to click
     * @return Crawler
     */
    private function playLetter($letter)
    {
        $crawler = $this->client->getCrawler();

        $link = $crawler->selectLink($letter)->link();
        $this->client->click($link);

        return $this->client->followRedirect();
    }

    public function testTryWord()
    {
        $this->playWord('php');

        // Check the game is won
        $response = $this->client->getResponse();
        $this->assertRegexp('#Congratulations, you found the word <strong>php<\/strong>#', $response->getContent());
    }

    public function testGameOverHanged()
    {
        $this->playWord('foo');

        $response = $this->client->getResponse();
        $this->assertRegexp("/Oops, you're hanged/", $response->getContent());
    }

    private function playWord($word)
    {
        $crawler = $this->client->request('GET', '/game/hangman/');
        $form = $crawler->selectButton('Let me guess...')->form();
        $this->client->submit($form, array('word' => $word));
        $this->client->followRedirect();
    }

    public function testGuessLetterAndGetHanged()
    {
        $crawler = $this->client->request('GET', '/game/hangman/?length=3');
        $left = (int) $crawler->filter('.attempts-left')->text();

        $this->assertGreaterThan(0, $left);

        // Play the same letter until reaching the hanged status
        for ($i = 0; $i < $left; $i++) {
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
