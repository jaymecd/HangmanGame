<?php

namespace Game\Bundle\HangmanBundle;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Game\Bundle\HangmanBundle\Event\EventMapping;
use Game\Bundle\HangmanBundle\Event\GameEvent;

class Game
{
    protected $word;
    protected $attempts;

    /**
     * @var EventDispatcher
     */
    protected $dispatcher;

    public function __construct(Word $word, $attempts = 0)
    {
        $this->word = $word;
        $this->attempts = (int) $attempts;
    }

    /**
     * @param EventDispatcher $dispatcher
     */
    public function setEventDispatcher(EventDispatcher $dispatcher)
    {
    	$this->dispatcher = $dispatcher;
    }

    public function getContext()
    {
        return array(
            'word'          => (string) $this->word,
            'attempts'      => $this->attempts,
            'found_letters' => $this->word->getFoundLetters(),
            'tried_letters' => $this->word->getTriedLetters()
        );
    }

    public function getMaxAttempts()
    {
        $len = strlen($this->word->getWord());

        return $len + 1;
    }

    public function getRemainingAttempts()
    {
        return $this->getMaxAttempts() - $this->attempts;
    }

    public function isLetterFound($letter)
    {
        return in_array(strtolower($letter), $this->word->getFoundLetters());
    }

    public function isLetterTried($letter)
    {
        return in_array(strtolower($letter), $this->word->getTriedLetters());
    }

    public function isHanged()
    {
        return $this->getMaxAttempts() === $this->attempts;
    }

    public function isWon()
    {
        return $this->word->isGuessed();
    }

    public function getWord()
    {
        return $this->word;
    }

    public function getWordLetters()
    {
        return $this->word->split();
    }

    public function getAttempts()
    {
        return $this->attempts;
    }

    public function tryWord($word)
    {
    	$this->dispatch(EventMapping::onWordTry, $word);

        if (0 == strcasecmp($word, $this->word->getWord())) {
            $this->word->guessed();
            return true;
        }

        $this->attempts = $this->getMaxAttempts();
        return false;
    }

    public function tryLetter($letter)
    {
    	$this->dispatch(EventMapping::onLetterTry, $letter);

        try {
            $result = $this->word->tryLetter($letter);
        }
        catch (\InvalidArgumentException $e) {
            $result = false;
        }

        if (false === $result) {
            $this->attempts++;
        }

        return $result;
    }

    protected function dispatch($type, $value)
    {
        if (isset($this->dispatcher)) {
            $this->dispatcher->dispatch($type, new GameEvent($value));
        }
    }
}
