<?php

namespace Game\Bundle\HangmanBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Game\Bundle\HangmanBundle\Event\EventMapping;
use Game\Bundle\HangmanBundle\Event\GameEvent;

class LetterListener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			EventMapping::onLetterTry => 'onLetterTry',
			EventMapping::onWordTry   => 'onWordTry',
		);
	}

    public function onLetterTry(GameEvent $event)
    {
        $value = $event->getValue();
        $data = 'letter: '. $value . PHP_EOL;

        file_put_contents('/tmp/letter.log', $data, FILE_APPEND);
    }

    public function onWordTry(GameEvent $event)
    {
    	$value = $event->getValue();
    	$data = 'word: '. $value . PHP_EOL;

    	file_put_contents('/tmp/letter.log', $data, FILE_APPEND);
    }
}
