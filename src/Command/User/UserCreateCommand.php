<?php

namespace JK\CmsBundle\Command\User;

use Exception;
use JK\CmsBundle\Entity\User;
use JK\CmsBundle\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserCreateCommand extends Command
{
    protected static $defaultName = 'cms:user:create';

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var string
     */
    private $kernelEnvironment;

    public function __construct(
        string $kernelEnvironment,
        UserPasswordEncoderInterface $encoder,
        ValidatorInterface $validator,
        UserRepository $repository
    ) {
        parent::__construct(self::$defaultName);

        $this->encoder = $encoder;
        $this->validator = $validator;
        $this->repository = $repository;
        $this->kernelEnvironment = $kernelEnvironment;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a new user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $username = $io->ask('What is the user name ?');
        $email = $io->ask('What is the email of the user ?', null, function ($value) {
            $errors = $this->validator->validate($value, [
                new Email([
                    'strict' => true,
                ]),
            ]);

            if (!$value || 0 !== $errors->count()) {
                throw new Exception('Invalid email provided');
            }

            return $value;
        });
        $password = $io->askHidden('What is the password of the user ?', function ($value) {
            if ('dev' === $this->kernelEnvironment && 8 < strlen($value)) {
                throw new Exception('The password should be at least 8 characters length');
            }

            return $value;
        });
        $role = $io->ask('What is the role of the user ?', 'ROLE_ADMIN');

        $user = new User();
        $user->setSalt(md5(random_bytes(10)));

        $password = $this->encoder->encodePassword($user, $password);

        $user->setUsername($username);
        $user->setUsernameCanonical($username);
        $user->setEmail($email);
        $user->setEmailCanonical($email);
        $user->setPassword($password);
        $user->setRoles([
            $role,
        ]);

        $this->repository->save($user);
        $io->success('User successfully created');

        return 0;
    }
}
