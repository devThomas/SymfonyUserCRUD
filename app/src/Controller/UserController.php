<?php
/**
 * File UserController.php
 *
 * Description of the purpose and functionality of the file.
 * php version 7.2.10
 *
 * @category Controllers
 * @package  App\Controller
 * @author   Thomas Boff <thomas.boff.dev@gmail.com>
 * @license  Your License
 * @link     https://example.com
 * @since    PHP 8.2 or higher
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * UserController
 *
 * This controller class is responsible for handling user-related operations.
 *
 * @category Controllers
 * @package  App\Controller
 * @author   Thomas Boff <thomas.boff.dev@gmail.com>
 * @license  Your License
 * @link     https://example.com/user
 */
class UserController extends AbstractController
{
    /**
     * Entity manager attribute
     * 
     * @var EntityManagerInterface
     */
    private $_entityManager;

    /**
     * UserController constructor.
     *
     * @param EntityManagerInterface $entityManager entitymanager doctrine request
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->_entityManager = $entityManager;
    }

    /**
     * Add a new user and/or get the index page.
     *
     * @param Request $request params request
     * 
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addUser(Request $request)
    {
        $userF = new User();
        $form = $this->createForm(UserType::class, $userF);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->_entityManager->persist($userF);
            $this->_entityManager->flush();
    
            return $this->redirectToRoute('user_list');
        }
        $users = $this->_entityManager->getRepository(User::class)->findAll();
        return $this->render(
            'user.html.twig', 
            [
                'users' => $users,
                'form'  => $form->createView()
            ]
        );
    }
    

    /**
     * Delete a user.
     *
     * @param int $id user_id to delete
     * 
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteUser(int $id)
    {
        $user = $this->_entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            throw $this->createNotFoundException('User Not found');
        }

        $this->_entityManager->remove($user);
        $this->_entityManager->flush();

        return $this->redirectToRoute('user_list');
    }
}