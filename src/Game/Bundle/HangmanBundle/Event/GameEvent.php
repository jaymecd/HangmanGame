<?php

namespace Game\Bundle\HangmanBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class GameEvent extends Event
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param mixed $value
     * @throws \InvalidArgumentException
     */
    public function __construct($value)
    {
        if (!$value || !is_scalar($value)) {
        	throw new \InvalidArgumentException(sprintf('invalid value [%s] provided', $value));
        }

        $this->value = $value;
    }

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}
}
