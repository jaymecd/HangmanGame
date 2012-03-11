<?php

namespace Game\Bundle\HangmanBundle;

use Symfony\Component\EventDispatcher\EventDispatcher as Dispatcher;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Session;

class GameContext
{
    protected $session;

    protected $wordList;

    protected $dispatcher;

    public function __construct(Dispatcher $dispatcher, Session $session, WordList $list)
    {
    	$this->dispatcher = $dispatcher;
        $this->session = $session;
        $this->wordList = $list;
    }

    public function getWordList()
    {
        return $this->wordList;
    }

    public function reset()
    {
        $this->session->remove('hangman');
    }

    public function newGame($length)
    {
    	$word = $this->getRandomWord($length);

    	$evt = new Event();
    	$evt->letter = implode('; ',array(
    		'len = '. $length,
    		'word = '. $word,
		));
    	$this->dispatcher->dispatch('hangman.letter.try', $evt);

        return new Game($word);
    }

    public function getRandomWord($length)
    {
        return new Word($this->wordList->getRandomWord($length));
    }

    public function loadGame()
    {
        $data = $this->session->get('hangman');

        if (!$data || !is_array($data)) {
            return false;
        }

        $word = new Word($data['word'], $data['found_letters'], $data['tried_letters']);

        return new Game($word, $data['attempts']);
    }

    public function save(Game $game)
    {
        $this->session->set('hangman', $game->getContext());
    }
}