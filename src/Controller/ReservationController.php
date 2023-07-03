<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\SeuilMaximumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    private $seuilMaximum = null;
    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReservationRepository $reservationRepository, SeuilMaximumRepository $seuilMaximumRepository): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer la valeur du champ 'date' du formulaire
            $reservationDate = $form->get('date')->getData();

            // Récupérer le seuil maximal depuis l'entité SeuilMaximum
            $seuilMaximum = $seuilMaximumRepository->find(1);

            // Vérifier si le nombre de couverts dépasse le seuil maximal
            $nombreCouvert = $reservation->getNombreCouvert();
            if ($nombreCouvert < $seuilMaximum->getSeuilMaximum()) {
                // Vérifier s'il y a des réservations existantes pour la date spécifiée
                $existingReservations = $reservationRepository->findBy([
                    'date' => $reservationDate,
                ]);

                // Calculer la somme des nombres de personnes pour les réservations existantes
                $totalReservedPeople = 0;
                foreach ($existingReservations as $existingReservation) {
                    $totalReservedPeople += $existingReservation->getNombreCouvert();
                }

                // Comparer la somme des nombres de personnes réservées avec le seuil maximal
                if ($totalReservedPeople + $nombreCouvert <= $seuilMaximum->getSeuilMaximum()) {
                    // Il y a des places disponibles
                    $this->seuilMaximum -= $nombreCouvert;
                } else {
                    // Afficher un message d'erreur indiquant que le restaurant est complet pour cette date et heure
                    $this->addFlash('error', "Désolé, le restaurant est complet pour cette date et cette heure.");
                    return $this->redirectToRoute('app_reservation_new');
                }
            } else {
                // Afficher un message d'erreur indiquant que le nombre de couverts dépasse le seuil maximal
                $this->addFlash('error', 'Veuillez choisir un autre créneau, le nombre de couverts dépasse le seuil maximal.');
                return $this->redirectToRoute('app_reservation_new');
            }

            // Enregistrer la réservation dans la base de données
            $reservationRepository->save($reservation, true);

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
            'seuilMaximum' => $seuilMaximumRepository->find(1)->getSeuilMaximum(),
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationRepository->save($reservation, true);

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->request->get('_token'))) {
            $reservationRepository->remove($reservation, true);
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
