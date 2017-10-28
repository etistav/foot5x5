<?php
// src/foot5x5/MainBundle/Beta/BetaListener.php

namespace foot5x5\MainBundle\Beta;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class BetaListener {
	// La date de fin de la version bêta :
	// - Avant cette date, on affichera un compte à rebours
	// - Après cette date, on n'affichera plus le "bêta"
	protected $endDate;

	public function __construct ($endDate) {
		$this->endDate = new \Datetime($endDate);
	}

	// Methode pour ajouter le "beta" à une réponse
	protected function displayBeta(Response $response, $daysLeft) {
		$content = $response->getContent();

		// Code à rajouter
		$html = '<span style="color: red; font-size: 0.8em;"> - Beta J-'.(int) $daysLeft.' !</span>';

		// Insertion du code dans la page, dans le <h1> du header
		$content = preg_replace('#<p(.+Etienne AURAND, 2015)</p>#isU', '<p$1'.$html.'</p>', $content, 1);

		// Modification du contenu dans la réponse
		$response->setContent($content);

		return $response;
	}

	// Méthode appelée par le gestionnaire d'évènement
	public function onKernelResponse(FilterResponseEvent $event) {
		
		// Test si la requête est bien la requête principale
		if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
			return;
		}

		// Récupération de la réponse que le kernel a insérée dans l'évènement
		$response = $event->getResponse();

		// Modification de la réponse si date de fin pas encore dépassée
		$daysLeft = $this->endDate->diff(new \Datetime())->days;
		if ($daysLeft > 0) {
			$response = $this->displayBeta($event->getResponse(), $daysLeft);
		}

		// Insertion de la réponse modifiée dans l'évènement
		$event->setResponse($response);
	}
}