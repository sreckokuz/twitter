<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    private const USERS = [
        [
            'username' => 'john_doe',
            'email' => 'john_doe@doe.com',
            'password' => 'john123',
            'fullName' => 'John Doe',
            'roles' => ['ROLE_USER']
        ],
        [
            'username' => 'rob_smith',
            'email' => 'rob_smith@smith.com',
            'password' => 'rob123',
            'password' => 'rob123',
            'fullName' => 'Rob Smith',
            'roles' => ['ROLE_USER']
        ],
        [
            'username' => 'marry_gold',
            'email' => 'marry_gold@gold.com',
            'password' => 'marry123',
            'fullName' => 'Marry Gold',
            'roles' => ['ROLE_USER']
        ],
        [
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'admin123',
            'fullName' => 'Admin Admin',
            'roles' => ['ROLE_ADMIN']
        ],
    ];

    private const POST_TEXT = [
        'Hello, how are you?',
        'It\'s nice sunny weather today',
        'I need to buy some ice cream!',
        'I wanna buy a new car',
        'There\'s a problem with my phone',
        'I need to go to the doctor',
        'What are you up to today?',
        'Did you watch the game yesterday?',
        'How was your day?'
    ];

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadPosts($manager);
    }

    public function loadPosts(ObjectManager $manager) {
        for ($i=0; $i<30; $i++) {
            $post = new Post();
            $post->setContent(self::POST_TEXT[rand(0,count(self::POST_TEXT)-1)]);
            $post->setUser($this->getReference(self::USERS[rand(0,count(self::USERS)-1)]['username']));
            $manager->persist($post);
        }
        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager) {
        foreach (self::USERS as $userData) {
            $user = new User();
            $user->setUsername($userData['username']);
            $user->setEmail($userData['email']);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $userData['password']));
            $user->setFullName($userData['fullName']);
            $user->setRoles($userData['roles']);
            $this->addReference($userData['username'], $user);
            $manager->persist($user);
        }
        $manager->flush();
    }

}
