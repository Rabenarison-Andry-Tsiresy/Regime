<?php

namespace App\Controllers;

use App\Models\ParametreModel;

class AdminParams extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $paramModel = new ParametreModel();
        $params = [
            'imc_underweight_max' => $paramModel->getValue('imc_underweight_max', '18.5'),
            'imc_normal_max' => $paramModel->getValue('imc_normal_max', '24.9'),
            'imc_overweight_max' => $paramModel->getValue('imc_overweight_max', '29.9'),
            'gold_price' => $paramModel->getValue('gold_price', '50'),
            'gold_discount_percent' => $paramModel->getValue('gold_discount_percent', '15'),
        ];

        return $this->render('admin/parametres/index', [
            'title' => 'Parametres',
            'params' => $params,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function update()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'imc_underweight_max' => 'required|decimal',
            'imc_normal_max' => 'required|decimal',
            'imc_overweight_max' => 'required|decimal',
            'gold_price' => 'required|decimal|greater_than[0]',
            'gold_discount_percent' => 'required|decimal',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $paramModel = new ParametreModel();
        $paramModel->setValue('imc_underweight_max', (string) $this->request->getPost('imc_underweight_max'));
        $paramModel->setValue('imc_normal_max', (string) $this->request->getPost('imc_normal_max'));
        $paramModel->setValue('imc_overweight_max', (string) $this->request->getPost('imc_overweight_max'));
        $paramModel->setValue('gold_price', (string) $this->request->getPost('gold_price'));
        $paramModel->setValue('gold_discount_percent', (string) $this->request->getPost('gold_discount_percent'));

        return redirect()->to('/admin/parametres')->with('success', 'Parametres mis a jour.');
    }
}
