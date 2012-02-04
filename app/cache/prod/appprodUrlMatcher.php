<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appprodUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appprodUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = urldecode($pathinfo);

        // _homepage
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', '_homepage');
            }
            return array (  '_controller' => 'Game\\Bundle\\HangmanBundle\\Controller\\GameController::indexAction',  '_route' => '_homepage',);
        }

        if (0 === strpos($pathinfo, '/game')) {
            // game_hangman_game_index
            if (rtrim($pathinfo, '/') === '/game/hangman') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'game_hangman_game_index');
                }
                return array (  '_controller' => 'Game\\Bundle\\HangmanBundle\\Controller\\GameController::indexAction',  '_route' => 'game_hangman_game_index',);
            }

            // play_letter
            if (0 === strpos($pathinfo, '/game/hangman/letter') && preg_match('#^/game/hangman/letter/(?P<letter>[^/]+?)$#xs', $pathinfo, $matches)) {
                return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Game\\Bundle\\HangmanBundle\\Controller\\GameController::letterAction',)), array('_route' => 'play_letter'));
            }

            // play_word
            if ($pathinfo === '/game/hangman/word') {
                return array (  '_controller' => 'Game\\Bundle\\HangmanBundle\\Controller\\GameController::wordAction',  '_route' => 'play_word',);
            }

            // hanged
            if ($pathinfo === '/game/hangman/hanged') {
                return array (  '_controller' => 'Game\\Bundle\\HangmanBundle\\Controller\\GameController::hangedAction',  '_route' => 'hanged',);
            }

            // won
            if ($pathinfo === '/game/hangman/won') {
                return array (  '_controller' => 'Game\\Bundle\\HangmanBundle\\Controller\\GameController::wonAction',  '_route' => 'won',);
            }

            // reset
            if ($pathinfo === '/game/hangman/reset') {
                return array (  '_controller' => 'Game\\Bundle\\HangmanBundle\\Controller\\GameController::resetAction',  '_route' => 'reset',);
            }

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
