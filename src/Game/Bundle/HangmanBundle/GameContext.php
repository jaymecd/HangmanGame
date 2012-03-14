<?php

namespace Game\Bundle\HangmanBundle;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Session;

class GameContext
{
    protected $session;

    protected $wordList;

    protected $dispatcher;

    public function __construct(EventDispatcher $dispatcher, Session $session, WordList $list)
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

    /**
     * @param unknown_type $length
     * @return \Game\Bundle\HangmanBundle\Game
     */
    public function newGame($length)
    {
        $game = new Game($this->getRandomWord($length));
        $game->setEventDispatcher($this->dispatcher);
        return $game;
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

        $game = new Game($word, $data['attempts']);
        $game->setEventDispatcher($this->dispatcher);
        return $game;
    }

    public function save(Game $game)
    {
        $this->session->set('hangman', $game->getContext());
    }
}