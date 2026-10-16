<?php

declare(strict_types=1);

namespace Drupal\ldt_musterhinweis\EventSubscriber;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Routing\LocalRedirectResponse;
use Drupal\Core\Url;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Leitet die Startseiten-Seite unter ihrer eigenen Adresse auf "/" weiter.
 *
 * Die Startseite ist die Seite "Start" (/node/1, Alias /start). Ohne
 * Weiterleitung wäre sie unter "/" und "/start" doppelt erreichbar. Aufrufe
 * von /start oder /node/1 werden deshalb dauerhaft (301) auf "/" umgeleitet,
 * Abfrageparameter bleiben erhalten. Bearbeiten-Seiten (/node/1/edit) sind
 * andere Routen und bleiben unberührt. Kein Redirect-Modul nötig.
 */
class StartseiteWeiterleitung implements EventSubscriberInterface {

  public function __construct(
    protected ConfigFactoryInterface $configFactory,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    // Nach dem Routing (32), vor dem Dynamic Page Cache (27).
    return [KernelEvents::REQUEST => ['weiterleiten', 30]];
  }

  /**
   * Leitet /start und /node/1 auf "/" um.
   */
  public function weiterleiten(RequestEvent $event): void {
    $request = $event->getRequest();
    if (!$event->isMainRequest() || !in_array($request->getMethod(), ['GET', 'HEAD'], TRUE)) {
      return;
    }
    if ($request->attributes->get('_route') !== 'entity.node.canonical') {
      return;
    }
    $node = $request->attributes->get('node');
    $front = $this->configFactory->get('system.site')->get('page.front');
    // Aufgerufene Adresse ist schon "/": nichts zu tun.
    if (!$node || $front !== '/node/' . $node->id() || $request->getPathInfo() === '/') {
      return;
    }
    $ziel = Url::fromRoute('<front>', [], ['query' => $request->query->all()])->toString();
    $event->setResponse(new LocalRedirectResponse($ziel, 301));
  }

}
