<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    protected $helpers = ['url', 'form'];
    protected $session;
    protected $currentUser;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->session = service('session');
        $this->currentUser = $this->session->get('user');
    }

    protected function isLoggedIn(): bool
    {
        return $this->currentUser !== null;
    }

    protected function requireLogin()
    {
        if (! $this->isLoggedIn()) {
            return redirect()->to('/login');
        }

        return null;
    }

    protected function requireAdmin()
    {
        if (! $this->isLoggedIn() || ($this->currentUser['role'] ?? 'user') !== 'admin') {
            return redirect()->to('/admin/login');
        }

        return null;
    }

    protected function render(string $view, array $data = [])
    {
        $data['currentUser'] = $this->currentUser;
        $data['isAdmin'] = ($this->currentUser['role'] ?? 'user') === 'admin';

        return view($view, $data);
    }

    protected function setSessionUser(array $user): void
    {
        $payload = [
            'id' => $user['id'],
            'nom' => $user['nom'],
            'email' => $user['email'],
            'role' => $user['role'] ?? 'user',
            'premium' => (int) ($user['premium'] ?? 0),
        ];

        $this->session->set('user', $payload);
        $this->currentUser = $payload;
    }
}
