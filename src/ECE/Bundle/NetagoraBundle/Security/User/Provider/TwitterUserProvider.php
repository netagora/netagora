<?php 

namespace ECE\Bundle\NetagoraBundle\Security\User\Provider;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\Validator\Validator;
use FOS\UserBundle\Entity\UserManager;
use TwitterOAuth;

class TwitterUserProvider implements UserProviderInterface
{
    protected $twitter;
    protected $userManager;
    protected $validator;
    protected $session;

    public function __construct(TwitterOAuth $twitter, UserManager $manager, Validator $validator, Session $session)
    {
        $this->twitter = $twitter;
        $this->manager = $manager;
        $this->validator = $validator;
        $this->session = $session;
    }

    public function supportsClass($class)
    {
        return $this->manager->supportsClass($class);
    }

    public function findUserByTwitterId($twitterID)
    {
        return $this->manager->findUserBy(array('twitterID' => $twitterID));
    }

    public function loadUserByUsername($username)
    {
        $user = $this->findUserByTwitterId($username);

        $this->twitter->setOAuthToken(
            $this->session->get('access_token'),
            $this->session->get('access_token_secret')
        );

        try {
             $info = $this->twitter->get('account/verify_credentials');
        } catch (Exception $e) {
             $info = null;
        }

        if (!empty($info)) {
            if (empty($user)) {
                $user = $this->manager->createUser();
                $user->setEnabled(true);
                $user->setPassword('test');
            }

            $username = $info->screen_name;

            $user->setTwitterID($info->id);
            $user->setTwitterUsername($username);
            $user->setUsername($username);
            $user->setEmail($username);
            $user->setFirstName($info->name);

            $this->manager->updateUser($user);
        }

        if (empty($user)) {
            throw new UsernameNotFoundException('The user is not authenticated on twitter');
        }

        return $user;

    }

    public function refreshUser(UserInterface $user)
    {
        if (!$this->supportsClass(get_class($user)) || !$user->getTwitterID()) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getTwitterID());
    }
}