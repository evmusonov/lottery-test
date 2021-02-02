<?php

namespace Application\Controller;

use Application\View\RenderInterface;
use Casino\Domain\Entity\User;
use Casino\Domain\Factory\UserFactory;
use Casino\Domain\Repository\UserRepositoryInterface;
use Casino\Service\InputFilter\UserInputFilter;
use Laminas\Hydrator\HydratorInterface;

class UserController extends Controller
{
    protected $userRepository;
    protected $inputFilter;
    protected $hydrator;
    protected $userFactory;

    public function __construct(
        RenderInterface $render,
        UserRepositoryInterface $repository,
        UserInputFilter $inputFilter,
        HydratorInterface $hydrator,
        UserFactory $userFactory
    ) {
        parent::__construct($render);
        $this->userRepository = $repository;
        $this->inputFilter = $inputFilter;
        $this->hydrator = $hydrator;
        $this->userFactory = $userFactory;
    }

    public function index()
    {
        echo $this->render::view('user/index', ['users' => $this->userRepository->getAll()]);
    }

    public function register()
    {
        $user = $this->userFactory->create();
        if (count($_POST)) {
            $this->inputFilter->setData($_POST);
            if ($this->inputFilter->isValid()) {

                $this->hydrator->hydrate($this->inputFilter->getValues(), $user);
                $isUser = $this->userRepository->getOneBy(
                    [
                        'email' => $user->getEmail()
                    ]
                );

                if (is_null($isUser)) {
                    $this->userRepository->begin()->persist($user)->commit();
                    header("Location: /users/login");
                } else {
                    $errorMessage = 'Sorry, the user already exists';
                    echo $this->render::view('user/register', ['user' => $user, 'errorMessage' => $errorMessage]);
                }

                exit;
            } else {
                $this->hydrator->hydrate($_POST, $user);
                $errors = $this->inputFilter->getMessages();
                echo $this->render::view('user/register', ['user' => $user, 'errors' => $errors]);
                exit;
            }
        }

        echo $this->render::view('user/register');
    }

    public function login()
    {
        $user = $this->userFactory->create();
        if (count($_POST)) {
            $this->inputFilter->setData($_POST);
            if ($this->inputFilter->isValid()) {
                $user = $this->userRepository->getOneBy(
                    [
                        'email' => $this->inputFilter->getRawValue('email')
                    ]
                );
                if (!is_null($user) && password_verify($this->inputFilter->getRawValue('password'), $user->getPassword())) {
                    $_SESSION['user'] = $this->hydrator->extract($user);
                    header("Location: /users/profile");
                    exit;
                } else {
                    $errorMessage = 'Sorry, the user is not found';
                    echo $this->render::view('user/login', ['errorMessage' => $errorMessage]);
                    exit;
                }
            } else {
                $this->hydrator->hydrate($_POST, $user);
                $errors = $this->inputFilter->getMessages();
                echo $this->render::view('user/login', ['user' => $user, 'errors' => $errors]);
                exit;
            }
        }

        echo $this->render::view('user/login');
    }

    public function profile()
    {
        $user = $this->userRepository->getById($_SESSION['user']['id']);
        $_SESSION['user'] = $this->hydrator->extract($user);
        echo $this->render::view('user/profile', ['user' => $user]);
    }

    public function logout()
    {
        unset($_SESSION['user']);
        header("Location: /");
        exit;
    }
}