<?php

namespace App\Controllers;

use App\Models\EmpruntModel;
use App\Models\LivreModel;

class Emprunts extends BaseController
{
    public function pret(int $livreId)
    {
        $livreModel = new LivreModel();
        $empruntModel = new EmpruntModel();

        $livre = $livreModel->find($livreId);
        if (! $livre) {
            return redirect()->to('/')->with('error', 'Livre introuvable.');
        }

        if (($livre['statut'] ?? 'disponible') !== 'disponible') {
            return redirect()->to('/')->with('error', 'Ce livre est deja prete.');
        }

        $emprunteur = trim((string) $this->request->getPost('emprunteur'));
        if ($emprunteur === '') {
            return redirect()->to('/')->with('error', 'Le nom de l\'emprunteur est obligatoire.');
        }

        $empruntModel->insert([
            'livre_id'     => $livreId,
            'emprunteur'   => $emprunteur,
            'date_emprunt' => date('Y-m-d'),
            'date_retour'  => null,
        ]);

        $livreModel->update($livreId, ['statut' => 'prete']);

        return redirect()->to('/')->with('success', 'Livre prete avec succes.');
    }

    public function retour(int $livreId)
    {
        $livreModel = new LivreModel();
        $empruntModel = new EmpruntModel();

        $livre = $livreModel->find($livreId);
        if (! $livre) {
            return redirect()->to('/')->with('error', 'Livre introuvable.');
        }

        $empruntActif = $empruntModel->getEmpruntActifByLivre($livreId);
        if (! $empruntActif) {
            return redirect()->to('/')->with('error', 'Aucun emprunt actif trouve pour ce livre.');
        }

        $empruntModel->update($empruntActif['id'], [
            'date_retour' => date('Y-m-d'),
        ]);

        $livreModel->update($livreId, ['statut' => 'disponible']);

        return redirect()->to('/')->with('success', 'Livre retourne avec succes.');
    }
}
