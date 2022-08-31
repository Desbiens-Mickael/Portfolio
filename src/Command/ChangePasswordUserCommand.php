<?php

namespace App\Command;

use App\Repository\UserRepository;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'user:change-password-user',
    description: 'Add a short description for your command',
)]
class ChangePasswordUserCommand extends Command
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private string $name = 'user:change-password-user'

    )
    {
        parent::__construct($this->name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, "User's email")
            ->addArgument(
                'newPassword',
                InputArgument::REQUIRED,
                "The new password (if blank, will be interactively asked)")
        ;
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);
        $questions = array();
        $questions['email'] = $io->ask("user's email");
        $questions['newPassword'] = $io->askHidden('Please choose a new password: ', function ($newPassword) {
            if (empty($newPassword)) {
                throw new Exception('Password can not be empty');
            }
            return $newPassword;
        });

        foreach ($questions as $name => $question) {
            $input->setArgument($name, $question);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Changing the user password');

        $email = $input->getArgument('email');
        $newPassword = $input->getArgument('newPassword');

        $user = $this->userRepository->findOneBy(['email' => $email]);
        $user ->setPassword($this->passwordHasher->hashPassword($user, $newPassword));

        $this->userRepository->add($user, true);

        $io->success("The user's password has been successfully changed!");
        return Command::SUCCESS;
    }
}
