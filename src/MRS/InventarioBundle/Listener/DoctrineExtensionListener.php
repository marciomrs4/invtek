<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 31/03/17
 * Time: 11:25
 * To Log All Entities
 */

namespace MRS\InventarioBundle\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Kernel;
use Gedmo\Blameable\BlameableListener;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class DoctrineExtensionListener implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;


    private $loggableListener;
    private $tokenStorage;

    public function __construct(BlameableListener $blameableListener, TokenStorageInterface $tokenStorage)
    {
        $this->loggableListener = $blameableListener;
        $this->tokenStorage =$tokenStorage;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function onLateKernelRequest()
    {

    }

    public function onConsoleCommand()
    {

    }

    public function onKernelRequest()
    {

        if($this->tokenStorage !== null && $this->tokenStorage->getToken() !== null &&
         $this->tokenStorage->getToken()->isAuthenticated() === true
        ){
            $this->loggableListener->setUserValue($this->tokenStorage->getToken()->getUsername());
        }

/*        if (Kernel::MAJOR_VERSION == 2 && Kernel::MINOR_VERSION < 6) {
            $securityContext = $this->container->get('security.context', ContainerInterface::NULL_ON_INVALID_REFERENCE);
            if (null !== $securityContext && null !== $securityContext->getToken() && $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                //$loggable = $this->container->get('gedmo.listener.loggable');
                $this->loggableListener->setUserValue($securityContext->getToken()->getUsername());
            }
        }
        else {
            $tokenStorage = $this->container->get('security.token_storage')->getToken();
            $authorizationChecker = $this->container->get('security.authorization_checker');
            if (null !== $tokenStorage && $authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                //$loggable = $this->container->get('gedmo.listener.loggable');
                $this->loggableListener->setUserValue($tokenStorage->getUser());

            }
        }
*/
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * The code must not depend on runtime state as it will only be called at compile time.
     * All logic depending on runtime state must be put into the individual methods handling the events.
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
          KernelEvents::REQUEST => 'onKernelRequest',
          KernelEvents::FINISH_REQUEST => 'onLateKernelRequest'
        ];
    }
}